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

//To prevent insecure links -->

if (App::environment('production')) {
    URL::forceScheme('https');
}

Route::get('/', 'PagesController@index');

Route::post('/save', 'PagesController@store');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/pay', 'PagesController@redirectUser')->name('reduse');



Route::post('/returnback', 'PagesController@returnUser')->name('return');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
