<?php
/**
 * File: ArchivesComposer.php
 * Description: 无
 * User: Alan
 * Datetime: 2017/8/13 17:53
 * Copyright Copyright(c) 2017
 * Version 1.0
 */
namespace App\Http\ViewComposers;

use App\Models\Article;
use Illuminate\View\View;


class ArchivesComposer
{
    public function __construct()
    {

    }

    public function compose(View $view)
    {
        $view->with('archives',Article::archives());

    }

}