<?php

namespace App\PaymentGateways;

use \App\Interfaces\PaymentGateway;
use \App\Order;

class FakePaymentGateway implements PaymentGateway
{

  var $apiKey;
  const IDENTIFIER = 'fake';

  public function setApiKey($apiKey)
  {
    $this->apiKey = $apiKey;
  }


  public function charge(array $orderDetail) : Order
  {
    $order = Order::create([
      'confirmation_code'         => \Carbon\Carbon::now()->format('Ymd')."-".(Order::max('id')+1),
      'customer_name'             => $orderDetail['customer']['first_name']." ".$orderDetail['customer']['last_name'],
      'customer_email'            => $orderDetail['customer']['email'],
      'payment_gateway'           => self::IDENTIFIER,
      'payment_gateway_reference' => \Carbon\Carbon::now()->format('YmdHis'),
      'total' => $orderDetail['total']
    ]);
    $order->tickets()->attach($orderDetail['tickets']->pluck('id'));
    return $order;
  }
}
