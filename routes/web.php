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

Route::prefix('notes')->group(function () {

    Route::post('/', 'postController@insertPost');

    Route::get('/', 'postController@getPosts');

    Route::get('/{id}',  'postController@getPost');

    Route::put('/{id}', 'postController@updatePost');
    Route::patch('/{id}', 'postController@updatePost');

    Route::delete('/{id}', 'postController@deletePost');
});
