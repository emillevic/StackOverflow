<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/pergunte', function (){
        return view('open-question');
    })->name('ask');
    Route::post('/pergunte/enviar', 'TopicController@create')->name('createTopic');
    Route::post('/topico/editar/{id}', 'TopicController@update')->name('updateTopic');
    Route::post('/topico/delete', 'TopicController@delete')->name('deleteTopic');
    Route::post('/topico/fechar', 'TopicController@close')->name('closeTopic');
    
    Route::post('/topico/responder', 'AnswerController@create')->name('createAnswer');
    Route::post('/topico/responder/editar/{id}', 'AnswerController@update')->name('updateAnswer');
    Route::post('/topico/responder/delete', 'AnswerController@delete')->name('deleteAnswer');
    Route::get('/topico/favoritar/{id}', 'AnswerController@bookmark')->name('bookmarkAnswer');
    Route::get('/topico/upvote/{id}', 'AnswerController@upvote')->name('upvoteAnswer');
    Route::get('/topico/downvote/{id}', 'AnswerController@downvote')->name('downvoteAnswer');

    Route::post('/topico/responder/comentar', 'CommentController@create')->name('createComment');
    Route::post('/topico/responder/comentar/editar/{id}', 'CommentController@update')->name('updateComment');
    Route::post('/topico/responder/comentar/delete', 'CommentController@delete')->name('deleteComment');
});

Route::get('/', 'TopicController@index')->name('index');

Route::get('/topico/{id}', 'TopicController@show')->name('showTopic');

Auth::routes();

Route::get('/home', 'TopicController@index')->name('home');

// Route::get('/home', 'HomeController@index')->name('home');
