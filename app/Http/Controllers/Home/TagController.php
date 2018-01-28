<?php

namespace App\Http\Controllers\Home;

use App\Models\Tag;

class TagController extends CommonController
{
    public function index(Tag $tag)
    {
        $articles = $tag->articles()->paginate(1);
        $data=[
            'tag_name'=>$tag->name,
            'articles'=>$articles
        ];
        return view('home.tags',$data);
    }
}
