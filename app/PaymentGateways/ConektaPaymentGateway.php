<?php

namespace App\PaymentGateways;

use \App\Interfaces\PaymentGateway;

use \Conekta\Conekta;
use \Conekta\Order as ConektaOrder;

use \App\Order;

class ConektaPaymentGateway implements PaymentGateway
{

  var $apiKey;
  const IDENTIFIER = 'conekta';

  public function setApiKey($apiKey)
  {
    Conekta::setApiKey($apiKey);
    Conekta::setLocale('en');
  }

  public function charge(array $orderDetail) : \App\Order
  {
    // $order = Order::create([
    //   'confirmation_code'         => \Carbon\Carbon::now()->format('Ymd')."-".(Order::max('id')+1),
    //   'customer_name'             => $orderDetail['customer']['first_name']." ".$orderDetail['customer']['last_name'],
    //   'customer_email'            => $orderDetail['customer']['email'],
    //   'payment_gateway'           => self::IDENTIFIER,
    //   'payment_gateway_reference' => \Carbon\Carbon::now()->format('YmdHis'),
    //   'total' => $orderDetail['total']
    // ]);
    // $order->tickets()->attach($orderDetail['tickets']->pluck('id'));
    // return $order;


    $conektaOrderArray =
    [
      'line_items'=> $orderDetail['tickets']->map(function($ticket){
        return [
          'name' => $ticket->event->name,
          'unit_price'  => $ticket->price,
          'quantity'    => 1,
          'sku'         => $ticket->seat_number
        ];
      }),
      'currency'    => 'mxn',
      'charges'     => [
        [
          'payment_method' => [
            'type'        => 'default',
          ],
          'amount' => $orderDetail['total']
        ]
      ],
      'customer_info' => [
        'customer_id'  => $orderDetail['customer']['id'],
      ]
    ];

    try {
      $conektaOrder = ConektaOrder::create($conektaOrderArray);
      $order = Order::create([
        'confirmation_code'         => \Carbon\Carbon::now()->format('Ymd')."-".(Order::max('id')+1),
        'customer_name'             => $orderDetail['customer']['first_name']." ".$orderDetail['customer']['last_name'],
        'customer_email'            => $orderDetail['customer']['email'],
        'payment_gateway'           => self::IDENTIFIER,
        'payment_gateway_reference' => $conektaOrder->id,
        'total' => $orderDetail['total']
      ]);

      $order->tickets()->attach($orderDetail['tickets']->pluck('id'));
      return $order;

    } catch (\Conekta\ProcessingError $e){
      throw new \Exception($e->getMessage());
    } catch (\Conekta\ParameterValidationError $e){
      throw new \Exception($e->getMessage());
    } catch (\Exception $e){
      throw new \Exception('There was an error processing your payment. Please try again later.');
    }
  }

}
