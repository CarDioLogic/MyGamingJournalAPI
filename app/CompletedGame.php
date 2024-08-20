<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompletedGame extends Model
{

    protected $fillable = [
        'user_id',
        'game_id',
    ];

    public function games()
    {
        return $this->belongsTo('App\Game', 'game_id');
    }
}
