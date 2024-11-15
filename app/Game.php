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
        return $this->belongsToMany('App\Genre', 'game_genre');
    }
    public function platforms()
    {
        return $this->belongsToMany('App\Platform', 'game_platform');
    }
    public function publishers()
    {
        return $this->belongsToMany('App\Publisher', 'game_publisher');
    }
    public function developers()
    {
        return $this->belongsToMany('App\Developer', 'game_developer');
    }
    public function playLaterGames()
    {
        return $this->hasOne('App\PlayLaterGames', 'game_id');
    }
    public function playedGames()
    {
        return $this->hasOne('App\PlayedGame', 'game_id');
    }
    public function currentlyPlaying()
    {
        return $this->hasOne('App\CurrentlyPlayingGame', 'game_id');
    }
    public function completedGames()
    {
        return $this->hasOne('App\CompletedGame', 'game_id');
    }
}
