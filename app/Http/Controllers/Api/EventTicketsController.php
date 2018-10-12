<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Transformers\TicketTransformer;

use App\Event;
use App\Ticket;

class EventTicketsController extends ApiController
{
    //
    public function index(Event $event, TicketTransformer $transformer, Request $request)
    {
      $tickets = $event->tickets()->available()->get();
      return $this->respondWithData([
        'tickets' => $transformer->transformCollection($tickets->toArray())
      ]);
    }
}
