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
// 用户管理
Route::group(['middleware' => 'auth:api', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/users', 'UserController@index');
    Route::get('/users/search', 'UserController@search');
});
// 系统设置
Route::group(['middleware' => ['auth:api', 'can:setting'], 'prefix' => 'admin/settings', 'namespace' => 'Admin'], function () {
    Route::get('/', 'SettingController@index');
    Route::put('/', 'SettingController@update');
    Route::post('/upload-logo', 'SettingController@logoUpload');
    Route::post('/upload-logo-delete', 'SettingController@logoDestroy');
});
// 文章管理
Route::group(['middleware' => 'auth:api', 'namespace' => 'Admin'], function () {
    Route::post('/admin/articles/upload-editor', 'ArticleController@uploadBase64');
    Route::post('/admin/articles/upload-cover', 'ArticleController@uploadCover');
    Route::post('/admin/articles/upload-cover-del', 'ArticleController@uploadCoverDel');
    // 文章分类
    Route::resource('/admin/article-categories', 'ArticleCategoryController', ['index',  'update', 'store','destroy']);
    // 文章
    Route::resource('/admin/articles', 'ArticleController', ['index', 'update', 'store', 'show', 'destroy']);

    Route::get('/admin/article/categories', 'ArticleController@categories');
    Route::get('/admin/article/tag/search', 'ArticleController@searchTag');


    // editor.md图片上传
    Route::post('/admin/articles/upload/image', 'ArticleController@imageUpload');
});
Route::group(['middleware' => 'auth:api', 'namespace' => 'Admin'], function () {
    Route::resource('/admin/links', 'LinkController', ['index', 'update', 'destroy']);
});

Route::post('/oauth/token', 'Admin\AuthController@token');
Route::post('/oauth/refresh-token', 'Admin\AuthController@refreshToken');

Route::middleware('auth:api')->post('/admin-user', 'Admin\AuthController@adminUser');
Route::post('hello', function (Request $request) {
    return json_encode(['liked' => true]);
})->middleware('api');
