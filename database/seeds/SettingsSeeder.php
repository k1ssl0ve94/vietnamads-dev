<?php

use Illuminate\Database\Seeder;
use App\Setting;
use Carbon\Carbon;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();

        $now = Carbon::now();
        $data = [
            ['group' => 'banner', 'key' => 'banner_top', 'value' => '{"url":"abc","image":"jUIzc11jC8sYRViCugxKOF782jxcuQqo.jpeg"}'],
            ['group' => 'banner', 'key' => 'banner_1', 'value' => '{"url":"abc","image":"jUIzc11jC8sYRViCugxKOF782jxcuQqo.jpeg"}'],
            ['group' => 'banner', 'key' => 'banner_2', 'value' => '{"url":"abc","image":"jUIzc11jC8sYRViCugxKOF782jxcuQqo.jpeg"}'],
            ['group' => 'banner', 'key' => 'banner_3', 'value' => '{"url":"abc","image":"jUIzc11jC8sYRViCugxKOF782jxcuQqo.jpeg"}'],
            ['group' => 'banner', 'key' => 'banner_4', 'value' => '{"url":"abc","image":"jUIzc11jC8sYRViCugxKOF782jxcuQqo.jpeg"}'],
            ['group' => 'banner', 'key' => 'banner_5', 'value' => '{"url":"abc","image":"jUIzc11jC8sYRViCugxKOF782jxcuQqo.jpeg"}'],
            ['group' => 'banner', 'key' => 'banner_6', 'value' => '{"url":"abc","image":"jUIzc11jC8sYRViCugxKOF782jxcuQqo.jpeg"}'],
            ['group' => 'banner', 'key' => 'banner_7', 'value' => '{"url":"abc","image":"jUIzc11jC8sYRViCugxKOF782jxcuQqo.jpeg"}'],
            ['group' => 'banner', 'key' => 'banner_8', 'value' => '{"url":"abc","image":"jUIzc11jC8sYRViCugxKOF782jxcuQqo.jpeg"}'],
            ['group' => 'all', 'key' => 'price_pro', 'value' => 96],
            ['group' => 'all', 'key' => 'refresh_time', 'value' => 12],
            ['group' => 'seo', 'key' => 'meta_title', 'value' => 'abc'],
            ['group' => 'seo', 'key' => 'meta_keywords', 'value' => 'abc'],
            ['group' => 'seo', 'key' => 'meta_description', 'value' => 'abc'],            
        ];

        foreach ($data as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }

        Setting::insert($data);
    }
}
