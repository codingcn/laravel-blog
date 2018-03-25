<?php

namespace App\Http\Controllers\Home;

use App\Models\Tag;

class TagController extends CommonController
{
    public function index(Tag $tag)
    {
        $articles = $tag->articles()
            ->where('publish_status', 2)
            ->paginate(10);
        $data=[
            'tag_name'=>$tag->name,
            'articles'=>$articles
        ];
        return view('home.tags',$data);
    }
}
