<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    protected $fillable = [
        'name',
    ];
    protected $hidden = ['pivot'];

    public function games()
    {
        return $this->belongsToMany('App\Game');
    }
}
