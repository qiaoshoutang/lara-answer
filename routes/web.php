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
    Route::get('/report/{type}', 'IndexController@report');
    Route::match(['get','post'],'/reward', 'IndexController@reward');
    
    Route::post('/ajax/check', 'AjaxController@check');  //验证答案
    Route::post('/ajax/share', 'AjaxController@share');   //分享回调
    
});

Route::group(['middleware'=>'admin_auth'],function(){
    Route::get('/admin/home', 'AdminController@index');                                    //后台首页
    Route::get('/admin/subject', 'AdminController@subjectList');                           //题库列表
    Route::get('/admin/result', 'AdminController@resultList');                             //成绩列表
    Route::match(['get','post'],'/admin/content', 'AdminController@content');              //新增题目
    Route::get('/admin/edit/{id}', 'AdminController@edit');                                //修改题目
    Route::post('/admin/edit', 'AdminController@edit');                                    //修改题目
    Route::post('/admin/del', 'AdminController@del');                                      //删除题目
    Route::post('/admin/user/chance', 'AdminController@userChance');                       //再一次答题机会
    Route::post('/admin/user/del', 'AdminController@userDel');                             //删除用户
});
Route::get('/logout', 'UserController@logout');
    
Route::get('/wx/login', 'UserController@login')->middleware('wx_auth');  //微信登录
Route::get('/admin/login/{key?}', 'AdminController@login');  //后台登录
Route::get('/admin/logout', 'AdminController@logout');  //后台登录


Route::get('/index/{name?}','IndexController@index');
// Route::resource('test','TestController');
Route::get('/test', 'TestController@index');     
Route::get('/test2', 'TestController@test');     




