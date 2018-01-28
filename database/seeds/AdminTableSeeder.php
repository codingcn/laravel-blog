<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Admin::create([
            'username' => 'admin',
            'phone' => 13529595970,
            'email' => '20874823@qq.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
