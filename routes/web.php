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

/**
 * 前台路由
 */


// 重置密码邮件发送
Route::view('/password/reset/email/send', 'home.auth.password.email');
Route::view('/password/reset/{token}', 'home.auth.password.reset');

// 用户登录
Route::view('/sign-in', 'home.signIn');
// 用户注册
Route::view('/sign-up', 'home.signUp');

//前台文章
Route::group(['namespace' => 'Home'], function () {
    Route::post('/password/reset/email/send', 'UserController@sendPasswordResetEmail');
    Route::post('/password/reset', 'UserController@passwordReset');
    // Github登录
    Route::get('/oauth/github/authorize', 'OauthGithubController@authorize');
    Route::get('/oauth/github/callback', 'OauthGithubController@callback');

    Route::get('/', 'IndexController@index');
    Route::get('/index', 'IndexController@index');
    Route::get('/welcome', 'IndexController@welcome');
    Route::get('/email/verify/{token}', 'UserController@emailVerify');

    // 登录行为
    Route::post('/sign-in', 'UserController@signInStore');
    Route::post('/sign-up', 'UserController@signUpStore');
    // 登出行为
    Route::get('/sign-out', 'UserController@signOut');

    // 用户设置行为
    Route::get('/user/setting/self', 'UserController@setting');
    // 标签
    Route::get('/tags/{tag}', 'TagController@index');
    // 归档
    Route::get('/article/archives', 'ArticleController@archives');
    // 文章详情
    Route::get('/articles/{article}', 'ArticleController@show');
    // 文章搜索
    Route::get('/article/search', 'ArticleController@search');

    // 分类
    Route::get('/categories/{category}', 'ArticleCategoryController@show');
    // 评论列表
    Route::get('/comment', 'CommentController@list');
    // 创建评论
    Route::post('/comment/store/{article}', 'CommentController@store');
});

Route::view('/about', 'home.about');


// 后台SPA模板渲染
Route::view('/admin', 'admin.layout');
Route::view('/admin/{query}', 'admin.layout')->where('query', '.*');
