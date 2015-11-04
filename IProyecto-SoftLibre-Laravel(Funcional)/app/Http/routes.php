<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|Symfony\Component\HttpKernel\Exception\NotFoundHttpException
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'SongsController@index');

Route::get('/home', 'SongsController@index');

/*
Route::controllers([
	'' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
*/

Route::get('/register', 'Auth\AuthController@getRegister');
Route::post('/register', 'Auth\AuthController@postRegister');
Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@getLogout');
Route::get('/password/email', 'Auth\PasswordController@getEmail');
Route::post('/password/email', 'Auth\PasswordController@postEmail');
Route::get('/reset/{code}', 'Auth\PasswordController@getReset');
Route::post('/reset', 'Auth\PasswordController@postReset');

Route::group(['middleware' => ['\App\Http\Middleware\validateType']], function()
{
	//Singers
	Route::get('/singers', 'ArtistsController@index');
	Route::get('/singers/new', 'ArtistsController@create');
	Route::get('/singers/edit/{id}', 'ArtistsController@edit');
	Route::put('/singers/edit/{id}', 'ArtistsController@update');
	Route::post('/singers', 'ArtistsController@store');
	Route::delete('/singers/{id}', 'ArtistsController@destroy');
	//Songs
	Route::get('/songs/create', 'SongsController@create');
	Route::get('/songs/{id}/edit', 'SongsController@edit');
	Route::put('/songs/{id}', 'SongsController@update');
	Route::post('/songs', 'SongsController@store');
	Route::delete('/songs/{id}', 'SongsController@destroy');
});

//Songs
Route::get('/songs?{name?}', 'SongsController@indexbyName');
Route::get('/songs', 'SongsController@index');
Route::get('/songs/{id}', 'SongsController@show');
Route::post('/songs/{id}/enqueue', 'SongsController@enqueue');

