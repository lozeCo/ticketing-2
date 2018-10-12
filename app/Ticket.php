<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $fillable = [
      'available'
    ];

    public function event()
    {
      return $this->belongsTo('App\Event');
    }

    public function scopeAvailable($query)
    {
	    return $query->where('available', true);
    }

    public function invalidate()
    {
      $this->update(['available' => 0]);
    }
}
