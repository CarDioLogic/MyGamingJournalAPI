<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
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

Route::get('genres/search/', 'GenreController@search');

Route::apiResource('platforms', 'PlatformController');
Route::get('platforms/search/', 'PlatformController@search');

Route::apiResource('publishers', 'PublisherController');
Route::get('publishers/search/', 'PublisherController@search');

Route::apiResource('developers', 'DeveloperController');
Route::get('developers/search/', 'DeveloperController@search');

Route::apiResource('playLaterGames', 'PlayLaterGamesController');
Route::get('playLaterGames/search/', 'PlayLaterGamesController@search');

Route::apiResource('currentlyPlayingGames', 'CurrentlyPlayingGamesController');
Route::get('currentlyPlayingGames/search/', 'CurrentlyPlayingGamesController@search');

Route::apiResource('playedGame', 'PlayedGameController');
Route::get('playedGame/search/', 'PlayedGameController@search');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'UserController@login');
Route::post('/register', 'UserController@register');


//protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', 'UserController@logout');

    Route::apiResource('games', 'GameController');
    Route::apiResource('completedGames', 'CompletedGameController');


    Route::apiResource('genres', 'GenreController');
});