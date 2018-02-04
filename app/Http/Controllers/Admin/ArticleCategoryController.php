<?php

namespace App\Http\Controllers\Admin;

use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleCategoryController extends CommonController
{
    public function index()
    {
        $list = ArticleCategory::orderBy('serial_number', 'asc')->paginate(10);
        return $this->responseJson('OK', $list);
    }

    public function show(ArticleCategory $category)
    {
        return $this->responseJson('OK',$category);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), ['name' => 'required']);
        if ($validator->fails()) {
            return $this->responseJson('INVALID_REQUEST', [], $validator->errors());
        }
        $data = $request->only(['name', 'serial_number']);
        $res=ArticleCategory::firstOrCreate($data);
        return $this->responseJson('OK', $res);
    }

    public function update(ArticleCategory $category,Request $request)
    {
        $validator = \Validator::make($request->all(), ['name' => 'required']);
        if ($validator->fails()) {
            return $this->responseJson('INVALID_REQUEST', [], $validator->errors());
        }
        $data = $request->only(['name', 'serial_number']);
        $category->name=$data['name'];
        $category->serial_number=$data['serial_number'];
        $category->save();
        return $this->responseJson('OK', $category);
    }
}
