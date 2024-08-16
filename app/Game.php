<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'rawgApiId',
        'title',
        'thumbnail',
        'short_description',
        'game_site_url',
        'game_img_url',
        'release_date',
        'profile_image',
    ];
    protected $hidden = ['pivot'];

    public function genres()
    {
        return $this->belongsToMany('App\Genre');
    }
    public function platforms()
    {
        return $this->belongsToMany('App\Platform');
    }
    public function publishers()
    {
        return $this->belongsToMany('App\Publisher');
    }
    public function developers()
    {
        return $this->belongsToMany('App\Developer');
    }
    public function playLaterGames()
    {
        return $this->hasOne('App\PlayLaterGames');
    }
    public function playedGames()
    {
        return $this->hasOne('App\PlayedGame');
    }
    public function currentlyPlaying()
    {
        return $this->hasOne('App\CurrentlyPlayingGame');
    }
    public function completedGames()
    {
        return $this->hasOne('App\CompletedGame');
    }
}
