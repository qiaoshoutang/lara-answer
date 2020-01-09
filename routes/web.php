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
Route::get('/', function(){   //活动首页  登录失败页面
    return view('logout');
});

Route::group(['middleware'=>'user_auth'],function(){ 
    Route::get('/home', 'IndexController@index');
    Route::get('/content/{subject}', 'IndexController@content');
    Route::post('/content/check', 'IndexController@check');
    Route::get('/report', 'IndexController@report');
    
});

Route::group(['middleware'=>'admin_auth'],function(){
    Route::get('/admin/home', 'AdminController@index');
    Route::match(['get','post'],'/admin/content', 'AdminController@content');
    Route::get('/admin/edit/{id}', 'AdminController@edit');
    Route::post('/admin/edit', 'AdminController@edit');
    Route::post('/admin/del', 'AdminController@del');
});
Route::get('/logout', 'UserController@logout');
    
Route::get('/wx/login', 'UserController@login')->middleware('wx_auth');  //微信登录
Route::get('/admin/login/{key?}', 'AdminController@login');  //后台登录
Route::get('/admin/logout', 'AdminController@logout');  //后台登录


Route::get('/index/{name?}','IndexController@index');
Route::resource('test','TestController');