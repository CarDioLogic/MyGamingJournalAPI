<?php

namespace App\Traits;

use App\CompletedGame;
use App\CurrentlyPlayingGame;
use App\PlayLaterGames;
use App\PlayedGame;
use App\Game;
use App\Http\Controllers\GameController; 



trait GameManagement{
    public function checkOrCreateGame($request)
    {
        $existingGame = Game::where('rawgApiId', $request->rawgApiId)->first();

        if (!$existingGame) {
            $gameController = new GameController();
            $createdGameResponse = $gameController->store($request);

            $existingGame = Game::where('rawgApiId', $request->rawgApiId)->first();
            //$existingGame = $createdGameResponse->getData()->game;
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
}