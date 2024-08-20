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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'UserController@login');
Route::post('/register', 'UserController@register');

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', 'UserController@logout');
    Route::get('getUser/{Id}', 'UserController@show');
    Route::post('/updateUser/{id}', 'UserController@updateUser');
    Route::delete('/deleteUser/{id}', 'UserController@destroy');

    Route::delete('/deleteGameFromLists/{id}', 'GameController@removeGameFromAllLists');
    Route::apiResource('games', 'GameController');
    Route::apiResource('completedGames', 'CompletedGameController');
    Route::apiResource('playLaterGames', 'PlayLaterGamesController');
    Route::apiResource('currentlyPlayingGames', 'CurrentlyPlayingGameController');
    Route::apiResource('playedGame', 'PlayedGameController');
    
    Route::apiResource('platforms', 'PlatformController');
    Route::apiResource('publishers', 'PublisherController');
    Route::apiResource('developers', 'DeveloperController');
    Route::apiResource('genres', 'GenreController');
});