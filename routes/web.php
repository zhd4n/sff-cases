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

Route::get('/test', function () {
    \App\Models\Parts\Part::find(18)->getMedia('gallery')->each(function($media) {
        echo "<img src='{$media->getFullUrl('thumb')}'>";
    });
});

Route::get('/', ['uses' => 'CaseController@index', 'as' => 'cases.index']);
Route::get('cases/create', ['as' => 'cases.create', 'uses' => 'CaseController@create']);
Route::post('cases', ['as' => 'cases.store', 'uses' => 'CaseController@store']);
Route::get('cases/{case_part}/edit', ['as' => 'cases.edit', 'uses' => 'CaseController@edit']);
Route::put('cases/{case_part}', ['as' => 'cases.update', 'uses' => 'CaseController@update']);
Route::delete('cases/{case_part}', ['as' => 'cases.delete', 'uses' => 'CaseController@delete']);
Route::delete('cases/{case_part}/media/{media}/delete', ['as' => 'cases.media.delete', 'uses' => 'CaseController@deleteMedia']);
Route::delete('cases/{case_part}/media/delete-all', ['as' => 'cases.media.delete-all', 'uses' => 'CaseController@deleteAllMedia']);

Route::get('cases/{case_part}', ['as' => 'cases.show', 'uses' => 'CaseController@show']);

