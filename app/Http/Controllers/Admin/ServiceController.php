<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    protected $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->middleware('auth:api');
        $this->serviceRepository = $serviceRepository;
    }

    public function options(Request $request)
    {
        $options = $this->serviceRepository->getAllOptions();
        return response()->json([
            'items' => $options,
        ]);
    }

    public function createOption(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|unique:day_options,name|required',
            'days' => 'integer|required|min:1',
        ]);
        $data = $request->only(['name', 'days']);
        $result = $this->serviceRepository->addDayOption($data);
        return response()->json([
            'result' => $result,
        ]);
    }

    public function updateOption(Request $request)
    {
        $id = $request->input('id');
        $this->validate($request, [
            'id' => 'required|integer',
            'name' => 'string|required|unique:day_options,name,' . $id,
            'days' => 'integer|required|min:1',
        ]);
        $option = $this->serviceRepository->getOptionById($id);
        if (!$option) {
            return response()->json([
                'result' => false,
                'message' => 'Day option is not existed.',
            ]);
        }
        $data = $request->only(['name', 'days']);
        $result = $this->serviceRepository->updateDayOption($option, $data);
        return response()->json([
            'result' => $result,
        ]);
    }

    public function removeOption(Request $request, $id)
    {
        $option = $this->serviceRepository->getOptionById($id);
        if (!$option) {
            return response()->json([
                'result' => false,
                'message' => 'Day option is not existed.',
            ]);
        }
        $result = $this->serviceRepository->removeDayOption($option);
        return response()->json([
            'result' => $result,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $isAddProduct = $request->input('addProduct',false);
        $items = $this->serviceRepository->getAllServicePackages($isAddProduct, Auth::user());
        return response()->json([
            'items' => $items,
        ]);
    }

    public function detail(Request $request, $id)
    {
        return response()->json($this->serviceRepository->getDetail($id));
    }

    public function add(Request $request)
    {
        $id = $request->input('id');
        $this->validate($request, [
            'name' => 'string|required|unique:services,name' . ($id ? ',' . $id : ''),
            'title_color' => 'required|string',
            'parameter_color' => 'required|string',
            'price_color' => 'required|string',
            'fee_point' => 'required|numeric',
//            'icon' => 'boolean',
//            'min_days' => 'required|number',
            'images_number' => 'required|integer',
            'max_content' => 'required|integer',
            'max_title' => 'required|integer',
            'allow_sms' => 'boolean',
            'allow_promotion' => 'boolean',
            'allow_management' => 'boolean',
            'allow_send_author' => 'boolean',
            'manual_refresh' => 'required|integer',
            'auto_refresh' => 'required|integer',
            'options' => 'required|array',
            'backup_time' => 'required|integer',
            'direct_link' => 'boolean',
            'priority' => 'required|integer|min:1',
            'display_in_search' => 'boolean',
            'display_in_trend' => 'boolean',
            'display_in_tags' => 'boolean',
            'refresh_fee' => 'integer',
            'auto_active' => 'boolean',
            'edit_times' => 'integer',
            'keep_alive' => 'boolean',
            'vip_only' => 'boolean',
        ]);
        $data = $request->all();

        $result = $this->serviceRepository->add($data, Auth::user());
        return response()->json([
            'result' => $result,
        ]);
    }

    public function remove(Request $request, $id)
    {
        $item = $this->serviceRepository->getDetail($id);
        if (!$item) {
            return response()->json([
                'result' => false,
                'message' => 'Service package is not existed.',
            ]);
        }
        $result = $this->serviceRepository->remove($item);
        return response()->json([
            'result' => $result,
        ]);
    }
}