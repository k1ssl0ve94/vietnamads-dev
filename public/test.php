<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Role;
use App\User;
use Hash;

class AdminController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('auth:api');

        $this->userRepo = $userRepo;
    }

    public function index(Request $request)
    {
        $user = auth('api')->user();
        if (!$user->can('view admin')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        $params = $request->only('keyword', 'role', 'status', 'group');
        $users = $this->userRepo->paginate($params, ['roles'], 10);

        return response()->json($users);
    }

    public function info()
    {
        $user = auth('api')->user();
        $data = $user->toArray();
        $data['roles'] = $user->getRoleNames();
        $data['permissions'] = $user->getPermissionsViaRoles()->pluck('name')->toArray();

        return response()->json([
            'user' => $data,
            'user_token' => encrypt($user->id),
        ]);
    }

    public function all(Request $request)
    {
        return response()->json($this->userRepo->getAllByGroup(config('user.group.backend')));
    }

    public function add(Request $request)
    {
        if (!auth('api')->user()->can('manage admin')) {
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
            event(new \App\Events\AdminLog([
                'admin_id' => auth('api')->user()->id,
                'action' => 'add_admin',
                'metadata' => [
                    'id' => $user->id,
                ]
            ]));

            return response()->json(['user' => $user->toArray()]);
        }

        return response()->json(['user' => null]);
    }

    public function update(Request $request, User $user)
    {
        if (!auth('api')->user()->can('manage admin')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $data = $request->only('name', 'email', 'password', 'status');

        if ($data['status']) {
            $data['status'] = config('user.status.active');
        } else {
            $data['status'] = config('user.status.inactive');
        }

        $roleId = $request->role;
        $role = Role::find($roleId);
        if (!$role) {
            return response()->json([
                'success' => false,
                'msg' => 'Invalid role',
            ]);
        }

        if (isset($data['password']) && !$data['password']) {
            unset($data['password']);
        }
        if ($this->userRepo->update($user, $data, $role)) {
            event(new \App\Events\AdminLog([
                'admin_id' => auth('api')->user()->id,
                'action' => 'update_admin',
                'metadata' => [
                    'id' => $user->id,
                ]
            ]));
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function delete(User $user)
    {
        if (!auth('api')->user()->can('manage admin')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        if (auth('api')->user()->id == $user->id) {
            return response()->json([
                'errors' => ['Cannot delete yourself.'],
            ]);
        }

        if ($this->userRepo->delete($user)) {
            event(new \App\Events\AdminLog([
                'admin_id' => auth('api')->user()->id,
                'action' => 'delete_admin',
                'metadata' => [
                    'id' => $user->id,
                ]
            ]));
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

    public function changePassword()
    {
        $user = auth()->user();
        request()->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:5|confirmed',
        ]);

        if (!empty($user->password) && !Hash::check(request()->current_password, $user->password)) {
            return [
                'status' => 0,
                'errors' => ['current password is wrong'],
            ];
        }

        if ($this->userRepo->updatePassword($user, request()->new_password)) {
            event(new \App\Events\AdminLog([
                'admin_id' => auth('api')->user()->id,
                'action' => 'change_password',
            ]));
            return ['status' => 1];
        }

        return ['status' => 0];
    }

    public function robot(Request $request)
    {
        if ($request->isMethod('put')) {
//            $this->validate($request, [
//                'content' => 'string|required',
//            ]);
            $content = trim($request->input('content'));
            if ($content) {
                File::put(public_path('robots.txt'), $content);
                return response()->json([
                    'status' => 1
                ]);
            }
            return response()->json([
                'status' => 0
            ]);
        } else {
            $content = File::get(public_path('robots.txt'));
            return response()->json([
                'content' => $content,
            ]);
        }
    }
    
    public function category(Request $request)
    {

        if ($request->isMethod('put')) {

            $meta_title0 = trim($request->input('meta_title0'));

            if ($meta_title0) {      
             
                return response()->json([
                    'status' => 1 
                ]);
            }
            return response()->json([
                'status' => 0
            ]);
        } else {
         
            return response()->json([
                'meta_title0' =>   config('product.category')[0]['name'],
                'meta_slug0' =>   config('product.category')[0]['slug'],
                'meta_description0' =>   config('product.category')[0]['description'],
                'meta_keywords0' =>   config('product.category')[0]['keywords'],                   
                'meta_title1' =>   config('product.category')[1]['name'],
                'meta_slug1' =>   config('product.category')[1]['slug'],
                'meta_description1' =>   config('product.category')[1]['description'],
                'meta_keywords1' =>   config('product.category')[1]['keywords'],
                'meta_title2' =>   config('product.category')[2]['name'],
                'meta_slug2' =>   config('product.category')[2]['slug'],
                'meta_description2' =>   config('product.category')[2]['description'],
                'meta_keywords2' =>   config('product.category')[2]['keywords'],
                'meta_title3' =>   config('product.category')[3]['name'],
                'meta_slug3' =>   config('product.category')[3]['slug'],
                'meta_description3' =>   config('product.category')[3]['description'],
                'meta_keywords3' =>   config('product.category')[3]['keywords'],
                'meta_title4' =>   config('product.category')[4]['name'],
                'meta_slug4' =>   config('product.category')[4]['slug'],
                'meta_description4' =>   config('product.category')[4]['description'],
                'meta_keywords4' =>   config('product.category')[4]['keywords'],
                'meta_title5' =>   config('product.category')[5]['name'],
                'meta_slug5' =>   config('product.category')[5]['slug'],
                'meta_description5' =>   config('product.category')[5]['description'],
                'meta_keywords5' =>   config('product.category')[5]['keywords'],                                           
            ]);
        }
    }  

    public function seolink(Request $request)
    {
        if ($request->isMethod('put')) {
//            $this->validate($request, [
//                'content' => 'string|required',
//            ]);
            $content = trim($request->input('content'));
            if ($content) {
                File::put(resource_path('views/partials/seo.link.blade.php'), $content);
                return response()->json([
                    'status' => 1
                ]);
            }
            return response()->json([
                'status' => 0
            ]);
        } else {
            $content = File::get(resource_path('views/partials/seo.link.blade.php'));
            return response()->json([
                'content' => $content,
            ]);
        }
    }    
}
