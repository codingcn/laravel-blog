<?php

namespace App\Http\Controllers\Home;

use App\Http\ApiError\ErrorInfo;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommonController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use ErrorInfo;


    protected function getSeoInfo($title = '', $keywords = '', $description = ''){
        return [
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description
        ];
    }
}
