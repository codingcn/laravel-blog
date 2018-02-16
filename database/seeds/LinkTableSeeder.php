<?php

use Illuminate\Database\Seeder;

class LinkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('links')->truncate();
        \App\Models\Link::create([
            'id' => '1',
            'name' => '边城',
            'uri' => 'https://ashub.cn',
            'description' => '面朝大海，春暖花开。',
            'serial_number' => 1
        ]);
    }
}
