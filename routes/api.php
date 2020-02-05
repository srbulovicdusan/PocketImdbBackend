<?php

use Illuminate\Http\Request;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'Auth\AuthController@login');
    Route::post('logout', 'Auth\AuthController@logout');
    Route::post('refresh', 'Auth\AuthController@refresh');
    Route::post('me', 'Auth\AuthController@me');
    Route::post('register', 'Auth\RegisterController@create');
});

Route::apiResource('movies', 'Api\MovieController');
Route::get('movies/pages', 'Api\MovieController@getMoviesByPage');
Route::get('count/movies', 'Api\MovieController@count');

Route::get('genres', 'Api\GenreController@index');


Route::get('movie/{movieId}/comments', 'Api\CommentController@getAllByMovie');
Route::post('comments', 'Api\CommentController@create');


Route::post('reactions', 'Api\UserReactionController@store');

Route::put('visits/movie/{movieId}', 'Api\MovieController@increaseVisits');

Route::get('search/movies/{searchParam}', 'Api\MovieController@search');

