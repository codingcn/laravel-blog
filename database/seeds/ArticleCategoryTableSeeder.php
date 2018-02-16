<?php

use Illuminate\Database\Seeder;

class ArticleCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('article_categories')->truncate();
        \App\Models\ArticleCategory::create([
            'id' => '1',
            'name' => '默认分类',
            'serial_number' => 1
        ]);
    }
}
