<?php

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

Route::apiResource('genres', 'GenreController');
Route::get('genres/search/', 'GenreController@search');

Route::apiResource('platforms', 'PlatformController');
Route::get('platforms/search/', 'PlatformController@search');

Route::apiResource('publishers', 'PublisherController');
Route::get('publishers/search/', 'PublisherController@search');

Route::apiResource('developers', 'DeveloperController');
Route::get('developers/search/', 'DeveloperController@search');

Route::apiResource('games', 'GamesController');
Route::get('games/search/', 'GamesController@search');

Route::apiResource('playLaterGames', 'PlayLaterGamesController');
Route::get('playLaterGames/search/', 'PlayLaterGamesController@search');

Route::apiResource('completedGames', 'CompletedGamesController');
Route::get('completedGames/search/', 'CompletedGamesController@search');

Route::apiResource('currentlyPlayingGames', 'CurrentlyPlayingGamesController');
Route::get('currentlyPlayingGames/search/', 'CurrentlyPlayingGamesController@search');

Route::apiResource('playedGame', 'PlayedGameController');
Route::get('playedGame/search/', 'PlayedGameController@search');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
