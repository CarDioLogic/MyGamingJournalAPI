<?php

namespace App\Http\Controllers;

use App\CompletedGame;
use App\Game;
use App\Http\Requests\StoreGameRequest;
use Auth;
use Illuminate\Http\Request;
use App\Traits\HttpResponses; 


class CompletedGameController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function checkOrCreateGame(StoreGameRequest $request){
        $existingGame = Game::where('rawgApiId', $request->rawgApiId)->first();

        //also need to verify if the game_id is aleady in other lists
        if (!$existingGame) {
        $gameController = new GameController();
        $createdGameResponse = $gameController->store($request);

        $existingGame = $createdGameResponse->getData()->game;
        } 

        return $existingGame;
    }

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
