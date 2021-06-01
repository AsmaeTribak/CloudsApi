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


Route::get( '/users' , 'UserController@index' );
Route::get( '/users/reset/password/{userid}' , 'UserController@resetUserPassword' );
Route::get( '/test' , 'TestEmail@index' );
Route::get( '/users/desactivate/{userid}' , 'UserController@desactivate');
Route::get( '/users/activate/{userid}' , 'UserController@activate');
Route::post( '/users' , 'UserController@update')->name("updateuser");

Auth::routes();

Route::post( '/login' , 'Auth\LoginController@checklogin')->name('custumlogin');//->middleware('managerRole');



Route::get('/', 'HomeController@index')->name('home');




