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

// Auth
Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login');
Route::get('register')->name('register')->uses('Auth\RegisterController@showRegisterForm');
Route::post('register')->name('register.submit')->uses('Auth\RegisterController@register');
Route::post('logout')->name('logout')->uses('Auth\LoginController@logout');

// Dashboard
Route::get('/')->name('dashboard')->uses('DashboardController')->middleware('auth');

// Search
Route::get('/search')->name('search')->uses('SearchController@index')->middleware('auth');

// Users
Route::get('users/{user}/edit')->name('users.edit')->uses('UsersController@edit')->middleware('auth');
Route::put('users/{user}')->name('users.update')->uses('UsersController@update')->middleware('auth');

// Libraries
Route::get('libraries')->name('libraries')->uses('LibrariesController@index')->middleware('remember', 'auth');
Route::get('libraries/create')->name('libraries.create')->uses('LibrariesController@create')->middleware('auth');
Route::post('libraries')->name('libraries.store')->uses('LibrariesController@store')->middleware('auth');
Route::get('libraries/{library}/edit')->name('libraries.edit')->uses('LibrariesController@edit')->middleware('auth');
Route::get('libraries/{library}')->name('libraries.books')->uses('LibrariesController@books')->middleware('auth');
Route::put('libraries/{library}')->name('libraries.update')->uses('LibrariesController@update')->middleware('auth');
Route::delete('libraries/{library}')->name('libraries.destroy')->uses('LibrariesController@destroy')->middleware('auth');
Route::put('libraries/{library}/restore')->name('libraries.restore')->uses('LibrariesController@restore')->middleware('auth');

//Books
Route::get('libraries/{library}/book/create')->name('book.create')->uses('BookController@create')->middleware('auth');
Route::post('libraries/{library}')->name('book.store')->uses('BookController@store')->middleware('auth');
Route::get('book/{book}/edit')->name('book.edit')->uses('BookController@edit')->middleware('auth');
Route::put('book/{book}')->name('book.update')->uses('BookController@update')->middleware('auth');
Route::delete('book/{book}')->name('book.destroy')->uses('BookController@destroy')->middleware('auth');
Route::put('book/{book}/restore')->name('book.restore')->uses('BookController@restore')->middleware('auth');

//People
Route::get('people')->name('people')->uses('PeopleController@index')->middleware('auth');

// 500 error
Route::get('500', function () {
    echo $fail;
});
