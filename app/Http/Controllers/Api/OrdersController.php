<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateOrderRequest;

use \App\Ticket;

use \App\Interfaces\PaymentGateway;

use \App\Transformers\TicketTransformer;
use \App\Transformers\OrderTransformer;

class OrdersController extends ApiController
{
  //
  var $paymentGateway;

  public function __construct(PaymentGateway $paymentGateway)
  {
    // If constructor is used, parent constructor should be explicitly called
    parent::__construct();
    $this->paymentGateway = $paymentGateway;
    // Should remove hard-coded Conekta dependency to set API KEY
    // Could be set using a Factory that reads from env file
    $this->paymentGateway->setApiKey(env('CONEKTA_API_KEY_PRIVATE'));
  }

  public function store(Ticket $ticketRepository, CreateOrderRequest $request,
    TicketTransformer $ticketTransformer,
    OrderTransformer $orderTransformer)
  {
    $tickets = $ticketRepository->find($request->ticket_id);

    $orderDetail = [
      'customer'  => [
        'id'          => 'cus_x9jA75tqrLDFgNhkR',
        'first_name'  => 'Guillermo',
        'last_name'   => 'Villalobos',
        'email'       => 'guillermo@pixan.io',
      ],
      'total'     => $tickets->sum('price'),
      'tickets'   => $tickets,
    ];

    try{

      // Charge order on payment gateway
      $order = $this->paymentGateway->charge($orderDetail);

      // Foreach equivalent on collections
      // Tickets var should be created beforehand to avoid losing reference
      $tickets = $order->tickets;
      $tickets->each(function($ticket){
        $ticket->invalidate();
      });

      return $this->respondWithData([
        'order' => $orderTransformer->transform($order->toArray()),
        'tickets' => $ticketTransformer->transformCollection($tickets->toArray())
      ]);
    }
    catch(\Exception $e){
      return $this->respondWithErrors($e->getMessage());
    }
  }
}
