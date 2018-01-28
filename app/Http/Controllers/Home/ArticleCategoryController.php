<?php

namespace App\Http\Controllers\Home;

use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleCategoryController extends CommonController
{
    public function show(ArticleCategory $category)
    {
        $articles = $category->articles()->paginate(1);
        $data = [
            'articles' => $articles,
            'seo' => [
                'title' => $category->name . '_' . getSetting('site_title'),
                'keywords' => '面朝大海，春暖花开',
            ]
        ];
        return view('home.category', $data);
    }
}
