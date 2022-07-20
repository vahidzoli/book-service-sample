<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/books', 'BooksController@getCollection');

Route::post('/books', 'BooksController@post')->middleware('auth.admin');

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/books/{book}/reviews', 'BooksController@postReview');
});