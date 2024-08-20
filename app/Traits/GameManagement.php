<?php

namespace App\Traits;

use App\CompletedGame;
use App\CurrentlyPlayingGame;
use App\Http\Requests\StoreGameRequest;
use App\PlayLaterGames;
use App\PlayedGame;
use App\Game;
use App\Platform;
use App\Publisher;
use App\Genre;

use App\Http\Controllers\GameController; 



trait GameManagement{
    
    public function checkOrCreateGame(StoreGameRequest $request)
    {

        $existingGame = Game::where('rawgApiId', $request->rawgApiId)->first();

        if (!$existingGame) {

            $gameController = new GameController();

            $createdGameResponse = $gameController->store($request);

            $existingGame = Game::where('rawgApiId', $request->rawgApiId)->first();
        }

        return $existingGame;
    }

    public function clearGameFromLists($gameId, $userId)
    {
        $listsToCheck = [
            CompletedGame::class,
            CurrentlyPlayingGame::class,
            PlayLaterGames::class,
            PlayedGame::class,
        ];

        foreach ($listsToCheck as $list) {
            $list::where('game_id', $gameId)
                ->where('user_id', $userId)
                ->delete();
        }
    }
    public function createNewGenres($request, Game $game){
        $genreIds = [];
        foreach ($request->genres as $genreName) {
            $genre = Genre::firstOrCreate(['name' => $genreName]);
            $genreIds[] = $genre->id;
        }
    
        $game->genres()->sync($genreIds);
    }
    public function createNewPlatforms($request, Game $game){
        $platformsIds = [];
        foreach ($request->platforms as $platformName) {
            $platform = Platform::firstOrCreate(['name' => $platformName]);
            $platformsIds[] = $platform->id;
        }
    
        $game->platforms()->sync($platformsIds);
    }
    public function createNewPublishers($request, Game $game){
        $publisherIds = [];
        foreach ($request->publishers as $publisherName) {
            $publisher = Publisher::firstOrCreate(['name' => $publisherName]);
            $publisherIds[] = $publisher->id;
        }
    
        $game->publishers()->sync($publisherIds);
    }
}