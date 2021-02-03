<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['namespace'=>'api','prefix'=>'api'],function (){
   Route::group(['namespace'=>'authenticate','prefix'=>'authenticate'],function (){
       Route::post('/register','indexController@register');
       Route::post('/login','indexController@login');
   });

   Route::group(['namespace'=>'comment','prefix'=>'comment'],function(){
        Route::post('/create','indexController@create');
        Route::post('/update','indexController@update');
        Route::post('/delete','indexController@delete');
   });


    Route::group(['namespace'=>'data','prefix'=>'data'],function (){
        Route::post('/create','indexController@create');
        Route::post('/update','indexController@update');
        Route::post('/delete','indexController@delete');
        Route::get('/detail/{token}/{dataId}','indexController@detail');
        Route::get('/list/{token}','indexController@list');
    });
});

