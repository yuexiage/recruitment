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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

/*后台*/
Route::group(['namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('/admin', 'AdminController@index');
    Route::get('/admin/index', 'AdminController@index');
    
    //角色管理
    Route::get('/admin/role/getRoleList', 'RoleController@getRoleList');
    Route::resource('/admin/role', 'RoleController');
    
    //用户管理
    Route::get('/admin/users/getUsers', 'usersController@getUsers');
    Route::get('/admin/users/delete/{id}', 'usersController@delete');
    Route::resource('/admin/users', 'usersController');
    
    //登录
    Route::post('/admin/dologin', 'LoginController@doLogin');
    Route::get('/admin/logout', 'LoginController@logout');
    Route::get('/admin/indexpage', 'AdminController@indexPage');
    
    //部门
    Route::get('/admin/departme/getdepartme', 'DepartmeController@getDepartme');
    Route::resource('/admin/departme', 'DepartmeController');
    
    //配置
    Route::resource('/admin/config', 'ConfigController');
    
});
Route::get('/admin/login', 'Admin\LoginController@index');
Route::get('/admin/test', 'TestController@index');
/*验证码*/
Route::get('captcha/{tmp}','codeController@captcha');
