<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayedGame extends Model
{
    protected $fillable = [
        'user_id',
        'game_id',
    ];
    public function games()
    {
        return $this->hasOne('App\Game');
    }
}
