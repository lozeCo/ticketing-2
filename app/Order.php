<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
      'total',
      'confirmation_code',
      'customer_name',
      'customer_email',
      'payment_gateway',
      'payment_gateway_reference'
    ];

    public function tickets()
    {
      return $this->belongsToMany('\App\Ticket')->withTimestamps();
    }
}
