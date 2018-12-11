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

    public function show(Event $eventRepository, $id)
    {
        $events = $eventRepository;        

        if ($id) {
            $events = $events->where('id',$id)->first();
        }

        return $this->respondWithData([
            'events' => $events
        ]);
    }

    public function update(Event $eventRepository, Request $request, $id)
    {
        $event = $eventRepository
            ->findOrFail($id);

        if (is_null($event)) {
            return $this->respondNotFound();
        } 
        else
        {
            $event->update($request->all());
        }
    }

    public function store(Event $eventRepository, Request $request)
    {
        $event = $eventRepository
            ->create($request->all());
        $this->respondCreated($event);
    }
}
