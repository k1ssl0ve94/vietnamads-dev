<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\SettingRepository;
use App\Setting;
use Storage;

class SettingController extends Controller
{

    protected $settingRepo;

    function __construct(SettingRepository $settingRepo)
    {
        $this->middleware('auth:api');

        $this->settingRepo = $settingRepo;
    }

    public function index(Request $request)
    {
        $params = $request->only('groups');

        $settings = $this->settingRepo->paginate($params, 20);

        return response()->json($settings);
    }

    public function add(Request $request)
    {
        if (!auth('api')->user()->can('manage setting')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        $data = $request->validate([
            'key' => 'required',
            'value' => 'required',
            'group' => 'required',
        ]);

        $setting = $this->settingRepo->getByKeyAndGroup($data['key'], $data['group']);

        if ($setting != null) {
            return response()->json([
                'errors' => ['key and group already existed.'],
            ]);
        }

        if ($setting = $this->settingRepo->add($data)) {
            return response()->json([
                'setting' => $setting,
            ]);
        }

        return response()->json([
            'setting' => null,
        ]);
    }

    public function delete(Setting $setting)
    {
        if (!auth('api')->user()->can('manage setting')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        if ($this->settingRepo->delete($setting)) {
            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json(['errors' => ['Failed to delete.']]);
    }

    public function getById(Setting $setting)
    {
        return response()->json(['setting' => $setting]);
    }

    public function update(Request $request, Setting $setting)
    {
        if (!auth('api')->user()->can('manage setting')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        $data = $request->validate([
            'key' => 'required',
            'value' => 'required',
            'group' => 'required',
        ]);

        if ($this->settingRepo->update($setting, $data)) {
            return response()->json([
                'setting' => $setting,
            ]);
        }

        return response()->json([
            'setting' => null,
        ]);
    }

    public function getByGroup(Request $request)
    {
        if (empty($request->group)) {
            return response()->json([]);
        }

        return response()->json($this->settingRepo->getByGroup($request->group));
    }

    public function getAll(Request $request)
    {
        return response()->json($this->settingRepo->all());
    }

    public function updateBannerSetting(Request $request)
    {
        $user = auth('api')->user();
        if (!$user->can('manage setting')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        foreach ($request->all() as $key => $data) {
            $s = $this->settingRepo->getByKeyAndGroup($key, 'banner');
            if ($s) {
                if (empty($data['url'])) {
                    $data['url'] = '';
                }
                $s->value = json_encode($data);
                $s->save();
            }
        }

        event(new \App\Events\AdminLog([
            'admin_id' => $user->id,
            'action' => 'update_banner'
        ]));

        return ['status' => 1];
    }

    public function updateMultiple(Request $request)
    {
        if (!auth('api')->user()->can('manage setting')) {
            return response()->json(['errors' => ['unauthorized']]);
        }
        $group = $request->group;
        if (!in_array($group, ['all'])) {
            return [
                'status' => 0,
                'errors' => ['Invalid request'],
            ];
        }

        foreach ($request->all() as $key => $value) {
            $s = $this->settingRepo->getByKeyAndGroup($key, $group);

            if (!$s) {
                continue;
            }
            $this->settingRepo->update($s, [
                'key' => $key,
                'value' => $value,
                'group' => $group,
            ]);
        }

        return ['status' => 1];
    }

    public function getBannerSetting(Request $request)
    {
        $settings = $this->settingRepo->getByGroup('banner');
        $data = [];

        foreach ($settings as $s) {
            $data[$s->key] = json_decode($s->value, true);
            $data[$s->key . '_url'] = '';
            if (!empty($data[$s->key]['image'])) {
                $data[$s->key . '_url'] = Storage::disk('public')->url('uploads/banners/' . $data[$s->key]['image']);
            }
        }

        return $data;
    }


    public function updateSeoSetting(Request $request)
    {
        $user = auth('api')->user();
        if (!$user->can('manage setting')) {
            return response()->json(['errors' => ['unauthorized']]);
        }  
        foreach ($request->all() as $key => $data) {
            $s = $this->settingRepo->getByKeyAndGroup($key, 'seo');
            if ($s) {
                $s->value = $data;
                $s->save();
            }
        }

        event(new \App\Events\AdminLog([
            'admin_id' => $user->id,
            'action' => 'update_seo'
        ]));

        return ['status' => 1];
    } 

    public function getSeoSetting(Request $request)
    {
        $settings = $this->settingRepo->getByGroup('seo');
        $data = [];
        foreach ($settings as $s) {
        	$data[$s->key] = $s->value;             	
        	if($s->key == 'fb_image'){
        		$data['fb_image_url'] = Storage::disk('public')->url('uploads/banners/' . $s->value);
        	}
        }          
        return $data;
    }


}
