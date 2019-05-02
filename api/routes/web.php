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

Route::get('/uploaded/{user_hash}/{file_hash}', 'SimpleMediaStorage@index');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

//Auth::routes();

Route::name('admin.')->prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('index');
    Route::get('/file/{user_hash}/{file_hash}/edit', 'AdminController@edit')->name('file.edit');
    Route::put('/file/{user_hash}/{file_hash}', 'AdminController@update')->name('file.update');
    Route::delete('/file/{user_hash}/{file_hash}', 'AdminController@destroy')->name('file.destroy');
});

Auth::routes();
