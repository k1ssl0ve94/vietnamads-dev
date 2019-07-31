<?php
namespace App\Repositories;

use App\Setting;

class SettingRepository
{
    public function all()
    {
        return Setting::all();
    }

    public function add($data)
    {
        $setting = new Setting;

        $setting->key = trim($data['key']);
        $setting->value = trim($data['value']);
        $setting->group = trim($data['group']);

        if ($setting->save()) {
            return $setting;
        }

        return null;
    }

    public function update($setting, $data)
    {
        $setting->key = trim($data['key']);
        $setting->value = trim($data['value']);
        $setting->group = trim($data['group']);

        return $setting->save();
    }

    public function delete($setting)
    {
        return $setting->delete();
    }

    public function paginate($params = [], $take = 20)
    {
        $query = Setting::query();

        if (!empty($params['groups'])) {
            $query->whereIn('group', $params['groups']);
        }

        return $query->orderBy('id', 'desc')->paginate($take);
    }

    public function getById($id)
    {
        return Setting::find($id);
    }

    public function getByIds($ids)
    {
        return Setting::whereIn('id', $ids)->get();
    }

    public function getByKeyAndGroup($key, $group)
    {
        if ($key == 'refresh_time') {
            //@todo hard code setting
            $setting = new Setting();
            $setting->value = 8;
            return $setting;
        }
        return Setting::where('key', $key)->where('group', $group)->first();
    }

    public function getByGroup($group)
    {
        return Setting::where('group', $group)->get();
    }

    public function getByGroups($groups)
    {
        return Setting::whereIn('group', $groups)->get();
    }
}