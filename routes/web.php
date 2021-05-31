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
Route::get( '/users/reset/password/{userid}' , 'UserController@reseUsertPassword' );//->middleware('managerRole');
Route::get( '/test' , 'TestEmail@index' );//->middleware('managerRole');


// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();


Route::get('/', 'HomeController@index')->name('home');




