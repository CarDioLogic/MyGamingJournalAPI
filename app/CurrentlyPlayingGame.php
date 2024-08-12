<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrentlyPlayingGame extends Model
{
    public function games()
    {
        return $this->hasOne('App\Game');
    }
}
