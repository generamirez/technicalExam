<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function tickets(){
        return $this->hasMany('App\Ticket');
    }
}
