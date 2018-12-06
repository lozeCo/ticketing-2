<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Event;

class EventsController extends ApiController
{
    //
    public function index(Event $eventRepository, Request $request)
    {
        $events = $eventRepository
            ->where('start_date', '>', \Carbon\Carbon::now());

        if ($request->has('name')) {
            $events = $events->where('name', 'LIKE', "%{$request->name}%");
        }

        $events = $events->orderBy('start_date', 'ASC')->orderBy('id', 'DESC')->paginate();
        return $this->respondWithData([
            'events' => $events->items()
        ]);
    }

    public function show(Event $eventRepository, Request $request, $event)
    {
        $events = $eventRepository;
        
        if ($event)
        {
            $events = $events->where('id',$event)->first();
        }

        return $this->respondWithData([
            'events' => $events
        ]);
    }
}
