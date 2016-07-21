<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'review', 'user_id'
    ];

    public function replays() {
        return $this->hasMany('App\Replay', 'review_id', 'id');
    }

}
