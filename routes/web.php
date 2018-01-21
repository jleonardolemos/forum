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

Route::get('threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');
Route::post('threads', 'ThreadsController@store')->name('threads.store');
Route::get('threads/{channel?}', 'ThreadsController@index')->name('threads.index');
Route::post('threads/{channel}/{thread}/replies', 'RepliesController@store')->name('threads.replies.store');
Route::post('replies/{reply}/favorite', 'FavoritesController@favorite')->name('replies.favorite');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
