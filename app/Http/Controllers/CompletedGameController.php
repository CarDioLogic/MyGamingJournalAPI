<?php

namespace App\Http\Controllers;

use App\CompletedGame;

use App\Http\Requests\StoreGameRequest;
use Auth;
use App\Traits\HttpResponses; 
use App\Traits\GameManagement;
use Illuminate\Http\Request;




class CompletedGameController extends Controller
{
    use HttpResponses;
    use GameManagement;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CompletedGame::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameRequest $request)
    {
        $request->validated();

        $existingGame = $this->checkOrCreateGame($request);

        // Also need to verify if the game_id is already in other lists
        // Example of adding a completed game:

        if(CompletedGame::where('game_id', $existingGame->id)->exists()
        && CompletedGame::where('user_id', Auth::user()->id)->exists())
        {
            $completedGame = CompletedGame::where('game_id', $existingGame->id)->first();
            $message = 'Game already exists in completed games list';
        } else {
            //also need to see if game is in another list and delete it from there!

            $this->clearGameFromLists($existingGame->id, Auth::user()->id);

            $completedGame = CompletedGame::create([
                'user_id' => Auth::user()->id,
                'game_id' => $existingGame->id,
            ]);
            $message = 'Game added to completed games list';
        }

        return $this->success([
            'game' => $completedGame,
        ], $message);
    }

/*     protected function checkOrCreateGame(StoreGameRequest $request){
        $existingGame = Game::where('rawgApiId', $request->rawgApiId)->first();

        //also need to verify if the game_id is aleady in other lists
        if (!$existingGame) {
        $gameController = new GameController();
        $createdGameResponse = $gameController->store($request);

        $existingGame = $createdGameResponse->getData()->game;
        } 

        return $existingGame;
    }

    protected function clearGameFromLists($gameId, $userId)
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
    } */

    /**
     * Display the specified resource.
     *
     * @param  \App\CompletedGame  $completedGame
     * @return \Illuminate\Http\Response
     */
    public function show(CompletedGame $completedGame)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CompletedGame  $completedGame
     * @return \Illuminate\Http\Response
     */
    public function edit(CompletedGame $completedGame)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompletedGame  $completedGame
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompletedGame $completedGame)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CompletedGame  $completedGame
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompletedGame $completedGame)
    {
        //
    }
}
