<?php
use Illuminate\Support\Facades\Auth;

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

Route::get('/auth/check',function(){
    return \Auth::id();
});

Route::post('/dispatch_request','AnswerController@dispatchRequest');

Route::post('/post_comment', 'HomeController@store')->middleware('auth');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

