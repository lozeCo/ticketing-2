<?php

namespace App\Interfaces;

interface PaymentGateway
{

  public function setApiKey($apiKey);
  public function charge(array $order) : \App\Order;

}
