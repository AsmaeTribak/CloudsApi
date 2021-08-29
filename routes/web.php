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
Route::get( '/entities' , 'EntityController@index' );
Route::post( '/entities' , 'EntityController@store' )->name("addentity");
Route::post( '/entities/update' , 'EntityController@update' )->name("updateentity");
Route::get(  '/entities/destroy/{userid}' , 'EntityController@destroy');
Route::get(  '/providers' , 'ProviderController@index' );
Route::post( '/providers/attach/{providerid}' , 'ProviderController@attach' );
Route::post( '/providers' , 'ProviderController@store' )->name("addprovider");
Route::get(  '/providers/{providerid}/{action}/{entityid}' , 'ProviderController@edit' );
Route::get(  '/accounts' , 'AccountsController@listes');
Route::get(  '/accounts/{providerid}' , 'AccountsController@index' )->name("listaccount");;
Route::post( '/accounts/{providerid}', 'AccountsController@addaccount');;
Route::get( '/tt', 'Controller@test');
Route::get( '/cloudapi', 'CloudapiController@region');
Route::post( '/cloudapi/instances' , 'CloudapiController@getInstances');








Auth::routes();

Route::post( '/login' , 'Auth\LoginController@checklogin')->name('custumlogin');//->middleware('managerRole');



Route::get('/', 'HomeController@index')->name('home');




