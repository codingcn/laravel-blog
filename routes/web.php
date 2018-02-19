<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/event_source', 'Home\IndexController@eventSource');
// Route::get('/test', 'Home\IndexController@test');

/**
 * 前台路由
 */

Route::get('/', 'Home\IndexController@index');
Route::get('/', 'Home\IndexController@index');
Route::get('/index', 'Home\IndexController@index');
Route::get('/welcome', 'Home\IndexController@welcome');

//文章搜索
Route::get('/articles/search', 'Home\ArticleController@search');

//用户登录
Route::view('/sign-in', 'home.signIn');
//登录行为
Route::post('/sign-in', 'Home\UserController@signInStore');
//用户注册
Route::view('/sign-up', 'home.signUp');
//注册行为
Route::post('/sign-up', 'Home\UserController@signUpStore');
//登出行为
Route::get('/sign-out', 'Home\UserController@signOut');

//用户设置行为
Route::get('/user/setting/self', 'Home\UserController@setting');
//标签
Route::get('/tags/{tag}', 'Home\TagController@index');
Route::get('/categories/{category}', 'Home\ArticleCategoryController@show');

//前台文章
Route::group(['namespace' => 'Home'], function () {
    //归档,置于文章详情之前，否者路由冲突
    Route::get('/article/archives', 'ArticleController@archives');
    //文章详情
    Route::get('/articles/{article}', 'ArticleController@show');
});
Route::group(['prefix' => 'comment', 'namespace' => 'Home'], function () {
    //评论列表
    Route::get('/', 'CommentController@list');
    //创建评论
    Route::post('/store/{article}', 'CommentController@store');
    Route::post('/like/{comment}', 'CommentController@like');
    Route::post('/dislike/{comment}', 'CommentController@dislike');
});
Route::view('/about', 'home.about');


Route::view('/admin', 'admin.layout');
Route::view('/admin/{query}', 'admin.layout')->where('query', '.*');

Route::get('/oauth/github/authorize', 'Home\OauthGithubController@authorize');
Route::get('/oauth/github/callback', 'Home\OauthGithubController@callback');


Route::post('/service/sendsms', 'Service\ValidateController@sendSMS');
