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

//Route::get('/', function () {return view('welcome');});
Route::get('/', ['as'=>'dashboard.index','uses'=>'HomeController@index']);

Route::get('/CheckLoginAttempts',['as'=>'login.CheckLoginAttempts','uses'=>'\App\Http\Controllers\Auth\LoginController@CheckLoginAttempts']);

Auth::routes();
Route::get('/dashboard/index.html', ['as'=>'dashboard.index','uses'=>'HomeController@index']);
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');



Route::group(['prefix' => '/dashboard/index.html','middleware' => ['auth']], function() {
    $prefix = '=page.html';

    /*theme settings*/
    Route::POST('theme',['as'=>'theme.index','uses'=>'SettingsController@index']);

    /* role and set permission*/
    Route::GET('role'.$prefix,['as'=>'role.index','uses'=>'RoleController@index','middleware' => ['permission:role-list']]);
    Route::GET('role/create'.$prefix,['as'=>'role.create','uses'=>'RoleController@create','middleware' => ['permission:role-create']]);
    Route::POST('role/store'.$prefix,['as'=>'role.store','uses'=>'RoleController@store','middleware' => ['permission:role-create']]);
    Route::GET('role/edit/{id}'.$prefix,['as'=>'role.edit','uses'=>'RoleController@edit','middleware' => ['permission:role-edit']]);
    Route::POST('role/update/{id}'.$prefix,['as'=>'role.update','uses'=>'RoleController@update','middleware' => ['permission:role-edit']]);
    Route::GET('role/delete/{id}'.$prefix,['as'=>'role.delete','uses'=>'RoleController@destroy','middleware' => ['permission:role-delete']]);


    /*users*/
    Route::GET('user'.$prefix,['as'=>'user.index','uses'=>'UserController@index','middleware' => ['permission:user-list']]);
    Route::GET('user/create'.$prefix,['as'=>'user.create','uses'=>'UserController@create','middleware' => ['permission:user-create']]);
    Route::POST('user/store'.$prefix,['as'=>'user.store','uses'=>'UserController@store','middleware' => ['permission:user-delete']]);
    Route::GET('user/edit/{id}'.$prefix,['as'=>'user.edit','uses'=>'UserController@edit','middleware' => ['permission:user-edit']]);
    Route::POST('user/update/{id}'.$prefix,['as'=>'user.update','uses'=>'UserController@update','middleware' => ['permission:user-edit']]);
    Route::GET('user/delete/{id}'.$prefix,['as'=>'user.delete','uses'=>'UserController@destroy','middleware' => ['permission:user-delete']]);

});
