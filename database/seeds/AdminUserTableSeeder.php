<?php

use Illuminate\Database\Seeder;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_users')->truncate();
        \App\Models\AdminUser::create([
            'username' => 'admin',
            'phone' => 13529595970,
            'email' => '20874823@qq.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
