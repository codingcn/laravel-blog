<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:api', 'prefix' => 'admin/tag', 'namespace' => 'Admin'], function () {

});
Route::group(['middleware' => 'auth:api', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/users', 'UserController@index');
    Route::get('/settings', 'SettingController@index');
    Route::put('/settings', 'SettingController@update');
    Route::post('/settings/upload-logo', 'SettingController@logoUpload');
    Route::post('/settings/upload-logo-delete', 'SettingController@logoDestroy');
    Route::get('/users/search', 'UserController@search');
});
Route::group(['middleware' => 'auth:api', 'prefix' => 'admin/article', 'namespace' => 'Admin'], function () {
    Route::post('/upload-editor', 'ArticleController@uploadBase64');
    Route::post('/upload-cover', 'ArticleController@uploadCover');
    Route::post('/upload-cover-del', 'ArticleController@uploadCoverDel');
    //文章列表
    Route::get('/list', 'ArticleController@index');
    Route::get('/categories/all', 'ArticleController@categories');
    Route::resource('/categories', 'ArticleCategoryController',['index','show','update','store']);

    //创建文章
    Route::post('/store', 'ArticleController@store');
    //编辑文章
    Route::get('/edit/{article}', 'ArticleController@edit');
    Route::put('/edit/{article}', 'ArticleController@update');
    Route::get('/tag/search', 'ArticleController@searchTag');
    //删除文章
    Route::get('/delete/{article}', 'ArticleController@delete');

    //editor.md图片上传
    Route::post('/upload/image', 'ArticleController@imageUpload');
});
Route::post('/oauth/token', 'Admin\AuthController@token');
Route::post('/oauth/refresh-token', 'Admin\AuthController@refreshToken');

Route::middleware('auth:api')->post('/admin-user', 'Admin\AuthController@adminUser');
Route::post('hello', function (Request $request) {
    return json_encode(['liked' => true]);
})->middleware('api');
