<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();
        DB::table('settings')->insert(
            [
                [
                    'key' => 'site_title',
                    'value' => '边城',
                    'description' => '站点标题'
                ],
                [
                    'key' => 'logo',
                    'value' => '边城',
                    'description' => 'LOGO'
                ],
                [
                    'key' => 'icp',
                    'value' => '滇ICP备15008347号-1',
                    'description' => 'ICP备案号'
                ]
            ]
        );
    }
}
