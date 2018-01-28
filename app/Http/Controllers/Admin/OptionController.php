<?php
/**
 * Created by PhpStorm.
 * User: Alan
 * Date: 2017/11/15
 * Time: 22:29
 */

namespace App\Http\Controllers\Admin;


use App\Models\Setting;

class OptionController extends CommonController
{
    public function index()
    {
        $res=Setting::all()->toArray();
        return $this->responseJson('OK',$res);
    }
}