<?php

namespace App\Http\Controllers;

use App\Game;
use App\Genre;
use App\Publisher;
use App\Platform;
use App\Http\Requests\StoreGameRequest;
use App\Http\Resources\GamesResource;
use Illuminate\Http\Request;
use App\Traits\HttpResponses; 
use App\Traits\GameManagement;

class GameController extends Controller
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
        $games = Game::with(['genres', 'platforms', 'publishers'])->get();

        return $games;
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

        $game = Game::firstOrCreate(
            ['rawgApiId' => $request->rawgApiId],
            [
                'title' => $request->title,
                'thumbnail' => $request->thumbnail,
                'short_description' => $request->short_description,
                'game_site_url' => $request->game_site_url,
                'game_img_url' => $request->game_img_url,
                'release_date' => $request->release_date,
            ]
        );

        $this->createNewGenres($request, $game);
        $this->createNewPlatforms($request, $game);
        $this->createNewPublishers($request, $game);

    return $this->success([
        'game' => new GamesResource($game),
    ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
    }
}
