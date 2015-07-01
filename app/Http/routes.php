<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('playlist', 'PlaylistController@index');
Route::get('playlist/create', 'PlaylistController@create');
Route::get('playlist/edit/{playlist_id}', 'PlaylistController@edit');
Route::get('playlist/delete/{playlist_id}', 'PlaylistController@delete');
Route::get('playlist/ManageSongs/{playlist_id}', 'PlaylistController@manageSongs');

Route::post('playlist/createPost', 'PlaylistController@createPost');
Route::post('playlist/editPost', 'PlaylistController@editPost');
Route::post('playlist/deletePost', 'PlaylistController@deletePost');
Route::post('playlist/saveSongs', 'PlaylistController@saveSongs');

Route::get('songs', 'SongsController@index');
Route::get('songs/create', 'SongsController@create');
Route::get('songs/edit/{song_id}', 'SongsController@edit');
Route::get('songs/delete/{song_id}', 'SongsController@delete');
Route::get('songs/getSong/{song_id}', 'SongsController@getSong');

Route::post('songs/createPost', 'SongsController@createPost');
Route::post('songs/editPost', 'SongsController@editPost');
Route::post('songs/deletePost', 'SongsController@deletePost');