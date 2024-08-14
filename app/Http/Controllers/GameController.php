<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests\StoreGameRequest;
use App\Http\Resources\GamesResource;
use Illuminate\Http\Request;
use App\Traits\HttpResponses; 

class GameController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Game::all();
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

        //return new GamesResource($game);
        return $this->success([
            'game' => $game,
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
