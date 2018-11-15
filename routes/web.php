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

Route::get('/', 'HomeController@index')->name('home');

Route::post('/insert_answer','AnswerController@insertAnswer');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/create_dlma', 'CreateDlmaController@create')->name('createDlma.create');
Route::post('/create_dlma', 'CreateDlmaController@store')->name('createDlma.store');
