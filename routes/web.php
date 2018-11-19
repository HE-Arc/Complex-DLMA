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

Route::get('/create_dlma', 'CreateDlmaController@create')->name('createDlma.create');
Route::post('/create_dlma', 'CreateDlmaController@store')->name('createDlma.store');

Route::get('/next_question', 'HomeController@newQuestion');
Route::get('/next_question_choice', 'HomeController@questionChoiceAjax');
Route::get('/next_question_username', 'HomeController@questionUsernameAjax');
Route::get('/next_question_description', 'HomeController@questionDescriptionAjax');
Route::get('/next_question_comments', 'HomeController@questionCommentsAjax');
