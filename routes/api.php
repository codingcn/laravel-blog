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

// 文章管理
Route::group(['middleware' => 'auth:api', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    // 用户管理
    Route::get('/users', 'UserController@index');
    Route::get('/users/search', 'UserController@search');

    Route::post('/articles/upload-editor', 'ArticleController@uploadBase64');
    Route::post('/articles/upload-cover', 'ArticleController@uploadCover');
    Route::post('/articles/upload-cover-del', 'ArticleController@uploadCoverDel');
    // 文章分类
    Route::resource('/article-categories', 'ArticleCategoryController', ['index', 'update', 'store', 'destroy']);
    // 文章
    Route::resource('/articles', 'ArticleController', ['index', 'update', 'store', 'show', 'destroy']);

    Route::get('/article/categories', 'ArticleController@categories');
    Route::get('/article/tag/search', 'ArticleController@searchTag');

    // 友链管理
    Route::resource('/links', 'LinkController', ['index', 'update', 'destroy']);

    // editor图片上传
    Route::post('/articles/upload/image', 'ArticleController@imageUpload');

    // 管理员信息修改
    Route::get('/admin-user', 'AdminUserController@show');
    Route::put('/admin-user', 'AdminUserController@update');
    Route::post('/admin-user/upload-avatar', 'AdminUserController@avatarUpload');
    Route::post('/admin-user/upload-avatar-delete', 'AdminUserController@avatarDestroy');

    // 系统设置
    Route::get('/settings', 'SettingController@index');
    Route::put('/settings', 'SettingController@update');
    Route::post('/settings/upload-logo', 'SettingController@logoUpload');
    Route::post('/settings/upload-logo-delete', 'SettingController@logoDestroy');
});

// 登录
Route::post('/oauth/token', 'Admin\AuthController@token');

/**
 * 前台API
 */
// 点赞
Route::post('/comment/{comment}/like', 'Home\CommentController@like')
    ->middleware('auth:home_token');
