<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleCategoryController extends CommonController
{
    /**
     * 分类列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $list = ArticleCategory::orderBy('serial_number', 'asc')->paginate(10);
        return $this->responseJson('OK', $list);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), ['name' => 'required']);
        if ($validator->fails()) {
            return $this->responseJson('INVALID_REQUEST', [], $validator->errors());
        }
        $data = $request->only(['name', 'serial_number']);
        $res = ArticleCategory::firstOrCreate($data);
        return $this->responseJson('OK', $res);
    }

    public function update(ArticleCategory $article_category, Request $request)
    {
        $validator = \Validator::make($request->all(), ['name' => 'required']);
        if ($validator->fails()) {
            return $this->responseJson('INVALID_REQUEST', [], $validator->errors());
        }
        $data = $request->only(['name', 'serial_number']);
        $article_category->name = $data['name'];
        $article_category->serial_number = $data['serial_number'];
        $article_category->save();
        return $this->responseJson('OK', $article_category);
    }

    public function destroy(ArticleCategory $article_category)
    {
        $article_count = Article::where('category_id', $article_category->id)->count();
        if ($article_count > 0) {
            return $this->responseJson('DELETE_FAIL', $article_count, '该分类下存在文章，无法删除');
        }
        $article_category->delete();
        return $this->responseJson('OK');
    }
}
