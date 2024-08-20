<?php

namespace App\Http\Controllers;

use App\PlayedGame;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGameRequest;
use Auth;
use App\Traits\HttpResponses; 
use App\Traits\GameManagement;

class PlayedGameController extends Controller
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
        return PlayedGame::with([
            'games.genres',
            'games.platforms',
            'games.publishers',
            'games.developers'
        ])->get();    }

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

        if(PlayedGame::where('game_id', $existingGame->id)->exists()
        && PlayedGame::where('user_id', Auth::user()->id)->exists())
        {
            $playedGame = PlayedGame::where('game_id', $existingGame->id)->first();
            $message = 'Game already exists in completed games list';
        } else {
            //also need to see if game is in another list and delete it from there!

            $this->clearGameFromLists($existingGame->id, Auth::user()->id);

            $playedGame = PlayedGame::create([
                'user_id' => Auth::user()->id,
                'game_id' => $existingGame->id,
            ]);
            $message = 'Game added to completed games list';
        }

        return $this->success([
            'game' => $playedGame,
        ], $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PlayedGame  $playedGame
     * @return \Illuminate\Http\Response
     */
    public function show(PlayedGame $playedGame)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PlayedGame  $playedGame
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlayedGame $playedGame)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PlayedGame  $playedGame
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlayedGame $playedGame)
    {
        //
    }
}
