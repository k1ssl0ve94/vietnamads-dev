<?php

namespace App\Http\Controllers\Admin;

use App\Bill;
use App\Lib\Email;
use App\Repositories\BillRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\User;
use Hash;

class UserController extends Controller
{
    protected $userRepo;
    protected $billRepository;

    public function __construct(UserRepository $userRepo, BillRepository $billRepository)
    {
        $this->middleware('auth:api');

        $this->userRepo = $userRepo;
        $this->billRepository = $billRepository;
    }

    public function index(Request $request)
    {
        if (!auth('api')->user()->can('view user')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        $params = $request->only('keyword', 'role', 'status', 'group', 'level', 'type');
        $users = $this->userRepo->paginate($params, ['roles'], 20);

        return response()->json($users);
    }

    public function add(Request $request)
    {
        if (!auth('api')->user()->can('manage user')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $data = $request->only('name', 'email', 'password', 'status');

        if ($data['status']) {
            $data['status'] = config('user.status.active');
        } else {
            $data['status'] = config('user.status.inactive');
        }
        $data['group'] = config('user.group.backend');

        $roleId = $request->role;
        $role = Role::find($roleId);

        if ($user = $this->userRepo->add($data, $role)) {
            return response()->json(['user' => $user->toArray()]);
        }

        return response()->json(['user' => null]);
    }

    public function update(Request $request, User $user)
    {
        if (!auth('api')->user()->can('manage user')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $data = $request->only('name', 'email', 'password', 'status',
            'note', 'department', 'phone', 'activated', 'verified_by_admin');

        if ($data['status']) {
            $data['status'] = config('user.status.active');
        } else {
            $data['status'] = config('user.status.inactive');
        }

        if ($this->userRepo->update($user, $data)) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function addPoint(Request $request, User $user)
    {
        if (!auth('api')->user()->can('manage user')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        $request->validate([
            'point' => 'required|integer',
            'transaction_type' => 'string|required',
            'transaction_code' => 'string|required',
        ]);

        $change = intval($request->point);
        if ($change == 0) {
            return [
                'status' => 0,
                'errors' => ['Invalid point']
            ];
        }
        $point = $user->point + $change;
        $user->remain_point += $change;
        if ($point < 0) {
            $point = 0;
        }

        if ($this->userRepo->update($user, [
                'point' => $point,
                'remain_point' => $user->remain_point,
            ])) {
            $action = $change > 0 ? 'increase_point' : 'decrease_point';
            event(new \App\Events\AdminLog([
                'admin_id' => auth('api')->user()->id,
                'user_id' => $user->id,
                'action' => $action,
                'metadata' => [
                    'point' => $change,
                ]
            ]));
            // Add bill
            $transactionType = $request->input('transaction_type');
            $transactionCode = $request->input('transaction_code');
            $billData = [
                'type' => $change > 0 ? Bill::TYPE_ADD : Bill::TYPE_SUB,
                'mode' => Bill::MODE_ADMIN,
                'point' => $change > 0 ? $change : -1 * $change,
                'date' => date('Y-m-d'),
                'user_id' => $user->id,
                'created_by' => Auth::user() ? Auth::user()->id : null,
                'product_id' => null,
                'service_id' => null,
                'option_id' => null,
                'status' => Bill::STATUS_DONE,
                'note' => 'Add by admin. '.$transactionType.', Mã giao dịch: '.$transactionCode,
            ];
            $bill = $this->billRepository->addBill($billData, Auth::user());
            // Send mail
            Email::send([
                'template_id' => Email::TEMPLATE_ADD_MONEY,
                'to_email' => $user->email,
                'to_name' => $user->name,
                'data' => [
                    'user_id' => $user->name .' ('.$user->id.')',
                    'name' => $user->name,
                    'user' => $user->email,
                    'point' => number_format($change),
                    'bill_id' => 'VNADS_TRANS_'.$bill->id,
                    'payment_method' => $transactionType .', (Mã giao dịch: '.$transactionCode. ')',
                    'payment_date' => Carbon::now()->format('d/m/Y H:i:s'),
                ],
            ]);
            return ['status' => 1];
        }

        return ['status' => 0];

    }

    public function delete(User $user)
    {
        if (!auth('api')->user()->can('manage user')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        if ($user->id == auth('api')->user()->id) {
            return response()->json([
                'errors' => ['Cannot delete yourself.'],
            ]);
        }

        if ($this->userRepo->delete($user)) {
            return response()->json(['success' => true]);
        }

        return response()->json(['errors' => ['Failed to delete.']]);
    }

    public function getById(User $user)
    {
        if (!auth('api')->user()->can('view user')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        $data = $user->toArray();
        $data['role'] = $user->roles->count() ? $user->roles->first()->id: 0;
        $data['status'] = !!$data['status'];
        return response()->json([
            'user' => $data,
        ]);
    }

    public function changeTypeAndLevel(Request $request, User $user)
    {
        if (!auth('api')->user()->can('manage user')) {
            return response()->json(['errors' => ['unauthorized']]);
        }
        $this->validate($request, [
            'type' => 'required|in:1,2',
            'level' => 'required|in:1,2',
        ]);
        $data = $request->only('type', 'level');
        $this->userRepo->update($user, $data);
        return response()->json([
            'status' => 1,
        ]);
    }

    public function phoneVerify(Request $request, User $user)
    {
        if (!auth('api')->user()->can('manage user')) {
            return response()->json(['errors' => ['unauthorized']]);
        }
        $this->validate($request, [
            'phone' => 'required|string|min:5',
        ]);
        $phone = $request->input('phone');
//        $existedUser = $this->userRepo->getByPhone($phone);
//
//        if ($existedUser && $existedUser->id != $user->id) {
//            return response()->json([
//                'status' => 0,
//                'errors' => 'Số điện thoại đã có người sử dụng.',
//            ]);
//        }

        $this->userRepo->update($user, [
            'phone' => $phone,
            'verified_phone' => User::VERIFIED_PHONE_OK,
        ]);

        return response()->json([
            'status' => 1,
        ]);
    }
}
