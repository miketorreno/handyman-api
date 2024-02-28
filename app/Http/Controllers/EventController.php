<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Response;
use App\Http\Resources\EventResource;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;

/**
 * @group Events
 *
 * APIs for managing Events
 */

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::query()
            ->when(request('user'),
                fn($query) => $query->where('user_id', request('user'))
            )
            ->with(['user'])
            ->paginate();

        return EventResource::collection(
            $events
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $event = Event::create(array_merge([
            'user_id' => auth()->id()
        ], $request->validated()));

        return EventResource::make(
            $event->load(['user'])
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return EventResource::make(
            $event->load(['user'])
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        abort_unless(auth()->user()->tokenCan('event.update'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('update', $event);

        $event->update(
            $request->validated()
        );

        return EventResource::make(
            $event->load(['user'])
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        abort_unless(auth()->user()->tokenCan('event.delete'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('delete', $event);

        $event->delete();
    }
}
