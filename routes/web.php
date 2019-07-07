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
//    Route::get('{format}', "TestController@show")->name("test");
    Route::get('eng', "Test\EngController@show")->name("eng.test");
    Route::get('rus', "Test\RusController@show")->name("rus.test");
    Route::post('eng', "Test\EngController@save")->name("eng.test");
    Route::post('rus', "Test\RusController@save")->name("rus.test");
});

Route::group(['prefix' => 'dictionary'], function ()
{
    Route::get('/', "DictionaryController@show")->name("dictionary");
    Route::post('new', "DictionaryController@new")->name("dictionary.new");
    Route::post('update', "DictionaryController@update")->name("dictionary.update");
    Route::post('save', "DictionaryController@save")->name("dictionary.save");
    Route::post('record', "DictionaryController@record")->name("dictionary.record");
    Route::get('delete', "DictionaryController@delete")->name("dictionary.delete");
});

