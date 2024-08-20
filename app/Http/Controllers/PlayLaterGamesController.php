<?php

namespace App\Http\Controllers;

use App\PlayLaterGames;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGameRequest;
use Auth;
use App\Traits\HttpResponses; 
use App\Traits\GameManagement;

class PlayLaterGamesController extends Controller
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
        return PlayLaterGames::with([
            'games.genres',
            'games.platforms',
            'games.publishers',
            'games.developers'
        ])->get();    }

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

        if(PlayLaterGames::where('game_id', $existingGame->id)->exists()
        && PlayLaterGames::where('user_id', Auth::user()->id)->exists())
        {
            $playLaterGames = PlayLaterGames::where('game_id', $existingGame->id)->first();
            $message = 'Game already exists in completed games list';
        } else {
            //also need to see if game is in another list and delete it from there!

            $this->clearGameFromLists($existingGame->id, Auth::user()->id);

            $playLaterGames = PlayLaterGames::create([
                'user_id' => Auth::user()->id,
                'game_id' => $existingGame->id,
            ]);
            $message = 'Game added to completed games list';
        }

        return $this->success([
            'game' => $playLaterGames,
        ], $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PlayLaterGames  $playLaterGames
     * @return \Illuminate\Http\Response
     */
    public function show(PlayLaterGames $playLaterGames)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PlayLaterGames  $playLaterGames
     * @return \Illuminate\Http\Response
     */
    public function edit(PlayLaterGames $playLaterGames)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PlayLaterGames  $playLaterGames
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlayLaterGames $playLaterGames)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PlayLaterGames  $playLaterGames
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlayLaterGames $playLaterGames)
    {
        //
    }
}
