<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = ['name','description','venue','start_date'];

    public function tickets()
    {
      return $this->hasMany('App\Ticket');
    }
}
