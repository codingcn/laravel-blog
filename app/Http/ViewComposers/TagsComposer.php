<?php
/**
 * File: archviesComposer.php
 * Description: 无
 * User: Alan
 * Datetime: 2017/8/13 17:53
 * Copyright Copyright(c) 2017
 * Version 1.0
 */

namespace App\Http\ViewComposers;

use App\Models\Tag;
use Illuminate\View\View;


class TagsComposer
{
    public function compose(View $view)
    {
        $view->with('tags', Tag::asideTags());
    }

}