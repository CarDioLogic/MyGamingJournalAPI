<?php

namespace App\Http\Controllers;

use App\CompletedGame;

use App\Http\Requests\StoreGameRequest;
use Auth;
use app\Game;
use App\Traits\HttpResponses;
use App\Traits\GameManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;





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
        return CompletedGame::with([
            'games.genres',
            'games.platforms',
            'games.publishers',
            'games.developers'
        ])->get();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameRequest $request)
    {
        Log::info('Data:', ['data' => $request]);

        $request->validated();

        $existingGame = $this->checkOrCreateGame($request);

        // Also need to verify if the game_id is already in other lists
        // Example of adding a completed game:

        if (
            CompletedGame::where('game_id', $existingGame->id)->exists()
            && CompletedGame::where('user_id', Auth::user()->id)->exists()
        ) {
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
