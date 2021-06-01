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


Route::get( '/users' , 'UserController@index' );//->middleware('managerRole');
Route::get( '/users/reset/password/{userid}' , 'UserController@resetUserPassword' );//->middleware('managerRole');
Route::get( '/test' , 'TestEmail@index' );//->middleware('managerRole');
Route::get( '/users/desactivate/{userid}' , 'UserController@desactivate');//->middleware('managerRole');

Route::get( '/users/activate/{userid}' , 'UserController@activate');//->middleware('managerRole');

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::post( '/login' , 'Auth\LoginController@checklogin')->name('custumlogin');//->middleware('managerRole');



Route::get('/', 'HomeController@index')->name('home');




