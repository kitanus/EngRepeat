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

Route::get('/', function ()
{
    return view('welcome');
});

Route::group(['prefix' => 'test'], function ()
{
    Route::get('{format}', "TestController@show")->name("test");
    Route::post('{format}', "TestController@save")->name("test");
});

Route::get('dictionary', "DictionaryController@show")->name("dictionary");
