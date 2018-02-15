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
Route::delete('threads/{channel}/delete/{thread}', 'ThreadsController@destroy')->name('threads.delete');
Route::post('threads/{channel}/{thread}/replies', 'RepliesController@store')->name('threads.replies.store');
Route::delete('threads/{channel}/{thread}/replies/{reply}', 'RepliesController@delete')->name('threads.replies.delete');
Route::post('replies/{reply}/favorite', 'FavoritesController@favorite')->name('replies.favorite');
Route::get('profile/{user}', 'UsersController@show')->name('users.show');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
