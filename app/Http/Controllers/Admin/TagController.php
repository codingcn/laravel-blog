<?php
/**
 * Created by PhpStorm.
 * User: Alan
 * Date: 2017/11/5
 * Time: 15:56
 */

namespace App\Http\Controllers\Admin;


use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends CommonController
{
    public function search(Request $request)
    {
        $keywords=$request->input('keywords','');
        $tags=Tag::where('name','LIKE',"%{$keywords}%")->get()->toArray();
        return $this->responseJson('OK',array_column($tags,'name'));
    }
}