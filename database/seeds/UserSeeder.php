<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        $now = Carbon::now();

        $data = [
            [
                'email' => 'root@vietnamads.vn',
                'password' => \Hash::make('123123'),
                'name' => 'Root',
                'status' => config('user.status.active'),
                'group' => config('user.group.backend'),
                'phone' => '0912345678',
            ],
            [
                'email' => 'admin@vietnamads.vn',
                'password' => \Hash::make('123123'),
                'name' => 'Admin',
                'status' => config('user.status.active'),
                'group' => config('user.group.backend'),
                'phone' => '099999999',
            ],
        ];

        foreach ($data as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }

        User::insert($data);
        // factory(App\User::class, 20)->create();
    }
}
