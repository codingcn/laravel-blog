<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminTableSeeder::class);
        $this->call(ArticleCategoryTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(LinkTableSeeder::class);
    }
}
