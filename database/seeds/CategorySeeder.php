<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();
        $now = Carbon::now();
        $data = [
            // pano
            ['parent_id' => 1, 'name' => 'Nhà dân, công trình'],
            ['parent_id' => 1, 'name' => 'Trên quốc lộ, tỉnh lộ'],
            ['parent_id' => 1, 'name' => 'trên đường phố'],
            ['parent_id' => 1, 'name' => 'Trung tâm công cộng'],
            ['parent_id' => 1, 'name' => 'Trên phương tiện di chuyển'],
            ['parent_id' => 1, 'name' => 'Hộp đèn'],
            ['parent_id' => 1, 'name' => 'Màn hình, frame'],
            ['parent_id' => 1, 'name' => 'Biển quảng cáo khác'],

            // ad
            ['parent_id' => 2, 'name' => 'Quảng cáo trên báo điện tử'],
            ['parent_id' => 2, 'name' => 'Quảng cáo truyền hình'],
            ['parent_id' => 2, 'name' => 'Quảng cáo phát thanh'],
            ['parent_id' => 2, 'name' => 'Quảng cáo trên ấn phẩm'],
            ['parent_id' => 2, 'name' => 'Quảng cáo băng đĩa'],
            ['parent_id' => 2, 'name' => 'Quảng cáo theo sự kiện'],
            ['parent_id' => 2, 'name' => 'Quảng cáo qua email'],
            ['parent_id' => 2, 'name' => 'Quảng cáo qua SMS'],
            ['parent_id' => 2, 'name' => 'Quảng cáo qua telephone'],
            ['parent_id' => 2, 'name' => 'Quảng cáo truyền thông khác'],

            // social
            ['parent_id' => 3, 'name' => 'Quảng cáo trên Facebook'],
            ['parent_id' => 3, 'name' => 'Quảng cáo trên Youtube'],
            ['parent_id' => 3, 'name' => 'Quảng cáo trên Instagram'],
            ['parent_id' => 3, 'name' => 'Quảng cáo trên Twitter'],
            ['parent_id' => 3, 'name' => 'Mạng xã hội khác'],
            ['parent_id' => 3, 'name' => 'Seeding, Accounts'],
            ['parent_id' => 3, 'name' => 'SEO'],
            ['parent_id' => 3, 'name' => 'Affiliate, CPA network'],
            ['parent_id' => 3, 'name' => 'Influencer'],
            ['parent_id' => 3, 'name' => 'Content, Writing'],
            ['parent_id' => 3, 'name' => 'Websites, Pages'],
            ['parent_id' => 3, 'name' => 'Streamer'],
            ['parent_id' => 3, 'name' => 'Khóa học, Traning'],
            ['parent_id' => 3, 'name' => 'Digital marketing khác'],

            // ads banner, web banner
            ['parent_id' => 4, 'name' => 'Thông tin'],
            ['parent_id' => 4, 'name' => 'Mạng xã hội'],
            ['parent_id' => 4, 'name' => 'Thương mại điện tử'],
            ['parent_id' => 4, 'name' => 'Chức năng'],
            ['parent_id' => 4, 'name' => 'Đa nhiệm'],
            ['parent_id' => 4, 'name' => 'Chuyên môn'],
            ['parent_id' => 4, 'name' => 'khác'],

            // other
            ['parent_id' => 5, 'name' => 'Thi công, lắp đặt'],
            ['parent_id' => 5, 'name' => 'Thiết kế'],
            ['parent_id' => 5, 'name' => 'In ấn'],
            ['parent_id' => 5, 'name' => 'Quay phim'],
            ['parent_id' => 5, 'name' => 'Chụp ảnh'],
            ['parent_id' => 5, 'name' => 'Phóng viên, nhà báo'],
            ['parent_id' => 5, 'name' => 'Model, MC'],
            ['parent_id' => 5, 'name' => 'Thiết bị, vật liệu'],
            ['parent_id' => 5, 'name' => 'Nghiệp vụ khác'],

            // find
            ['parent_id' => 6, 'name' => 'Quảng cáo'],
            ['parent_id' => 6, 'name' => 'Marketing'],
            ['parent_id' => 6, 'name' => 'Nhân sự'],
        ];

        foreach ($data as &$row) {
            $row['slug'] = str_slug($row['name']);
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }

        Category::insert($data);
    }
}
