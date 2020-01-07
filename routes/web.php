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
    
});
    Route::get('/logout', 'UserController@logout');
    
Route::get('/wx/login', 'UserController@login')->middleware('wx_auth');  //微信登录

Route::namespace('Auth')->group(function(){
   Route:: get('/login','LoginController@login')->name('login');
});

Route::get('/index/{name?}','IndexController@index');
Route::resource('test','TestController');