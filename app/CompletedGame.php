<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompletedGame extends Model
{
    public function games()
    {
        return $this->hasOne('App\Game');
    }
}
