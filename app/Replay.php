<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replay extends Model
{
    protected $table = 'replays';

    protected $fillable = [
        'replay', 'review_id'
    ];

    public function review(){
        return $this->belongsTo('App\Review','review_id', 'id');
    }

}
