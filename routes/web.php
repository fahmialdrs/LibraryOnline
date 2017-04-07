<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'GuestController@index');
Auth::routes();
Route::get('/home', 'HomeController@index');
Route::group(['prefix'=>'admin', 'middleware'=>['auth','role:admin']], function() {
	Route::resource('author', 'AuthorsController');
	Route::resource('book', 'BooksController');
	Route::resource('member', 'MembersController');
	Route::get('statistic', [
		'as' => 'statistic.index',
		'uses' => 'StatisticsController@index'
		]);
	Route::get('export/book', [
		'as' => 'export.book',
		'uses' => 'BooksController@export'
		]);
	Route::post('export/book', [
		'as' => 'export.book.post',
		'uses' => 'BooksController@exportPost'
		]);	
	Route::get('template/book', [
		'as' => 'template.book',
		'uses' => 'BooksController@generateExcelTemplate'
		]);	
	Route::post('import/book', [
		'as' => 'import.book',
		'uses' => 'BooksController@importExcel'
		]);	
});

route::get('book/{book}/borrow', [
	'middleware' => ['auth', 'role:member'],
	'as'=> 'guest.book.borrow',
	'uses' => 'BooksController@borrow'
	]);

route::put('book/{book}/return', [
	'middleware' => ['auth', 'role:member'],
	'as' => 'member.book.return',
	'uses' => 'BooksController@returnBack'
	]);
route::get('auth/verify/{token}', 'Auth\RegisterController@verify');
route::get('auth/send-verification', 'Auth\RegisterController@sendVerification');
route::get('settings/profile', 'SettingsController@profile');
route::get('settings/profile/edit', 'SettingsController@editProfile');
route::post('settings/profile', 'SettingsController@updateProfile');
route::get('settings/password', 'SettingsController@editPassword');
route::post('settings/password', 'SettingsController@updatePassword');
