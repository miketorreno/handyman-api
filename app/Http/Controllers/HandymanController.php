<?php

namespace App\Http\Controllers;

use App\Models\Handyman;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use App\Models\SubscriptionType;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\HandymanResource;
use App\Http\Requests\StoreHandymanRequest;
use App\Http\Requests\UpdateHandymanRequest;

/**
 * @group Handymen
 *
 * APIs for managing Handymen
 */

class HandymanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $handymen = Handyman::query()
            ->where('approval_status', Handyman::APPROVED)
            ->when(request('location'), 
                fn ($builder) => $builder->whereRelation('user', 'location', '=', request('location')))
            ->when(request('language'), 
                fn ($builder) => $builder->whereJsonContains('languages->languages', request('language')))
            ->when(request('categories'),
                fn($builder) => $builder->whereHas(
                    'categories',
                    fn ($builder) => $builder->whereIn('id', request('categories'))
                    // * To include exactly all categories in the filter
                    // '=',
                    // count(request('categories'))
                )
            )
            ->when(request('services'),
                fn($builder) => $builder->whereHas(
                    'services',
                    fn ($builder) => $builder->whereIn('id', request('services'))
                    // * To include exactly all services in the filter
                    // '=',
                    // count(request('services'))
                )
            )
            ->with(['user', 'subscriptionType', 'categories', 'services', 'reviews', 'quotes'])
            // ->morphWithCount(['reviews'])
            // ->with([
            //     'reviewable' => function (MorphTo $morphTo) {
            //         $morphTo->morphWithCount();
            //     }
            // ])
            // ->latest('id')
            ->withAvg('reviews', 'rating')
            ->paginate();

        return HandymanResource::collection(
            $handymen
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
    public function store(StoreHandymanRequest $request)
    {
        $handyman = new Handyman();
        $attributes['user_id'] = auth()->id();

        $handyman = DB::transaction(function () use ($handyman, $attributes) {
            $handyman->fill(
                Arr::except($attributes, ['categories', 'services'])
            )->save();

            if (isset($attributes['categories'])) {
                $handyman->categories()->attach($attributes['categories']);
            }

            if (isset($attributes['services'])) {
                $handyman->services()->attach($attributes['services']);
            }

            return $handyman;
        });

        // * DB Notification
        // Notification::send(User::where('is_admin', true)->get(), new NewHandymanNotification($handyman, auth()->user()));


        return HandymanResource::make(
            $handyman->load(['user', 'subscriptionType', 'categories', 'services', 'reviews', 'quotes'])
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Handyman $handyman)
    {
        return HandymanResource::make(
            $handyman->load(['user', 'subscriptionType', 'categories', 'services', 'reviews', 'quotes'])
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Handyman $handyman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHandymanRequest $request, Handyman $handyman)
    {
        abort_unless(auth()->user()->tokenCan('handyman.update'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('update', $handyman);

        $attributes = $request->validated();
        $attributes['user_id'] = auth()->id();
        $handyman->fill(Arr::except($attributes, ['categories', 'services']));
        // $requiresReview = $handyman->isDirty(['about', 'tools']);

        DB::transaction(function () use ($handyman, $attributes) {
            $handyman->save();

            if (isset($attributes['categories'])) {
                $handyman->categories()->sync($attributes['categories']);
            }

            if (isset($attributes['services'])) {
                $handyman->services()->sync($attributes['services']);
            }
        });

        // * DB Notification
        // if ($requiresReview) {
        //     Notification::send(User::where('is_admin', true)->get(), new UpdateHandymanNotification($handyman, auth()->user()));
        // }
        
        return HandymanResource::make(
            $handyman->load(['user', 'subscriptionType', 'categories', 'services', 'reviews', 'quotes'])
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Handyman $handyman)
    {
        abort_unless(auth()->user()->tokenCan('handyman.delete'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('delete', $handyman);

        $handyman->delete();

        // Notification::send(User::where('is_admin', true)->get(), new DeleteHandymanNotification($handyman, auth()->user()));
    }

    public function subscribe(Handyman $handyman, SubscriptionType $subscriptionType)
    {
        abort_unless(auth()->user()->tokenCan('handyman.update'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('update', $handyman);

        $handyman->update(['subscription_type_id' => $subscriptionType->id]);

        return HandymanResource::make(
            $handyman->load(['user', 'subscriptionType', 'categories', 'services', 'reviews', 'quotes'])
        );
    }

    public function unsubscribe(Handyman $handyman)
    {
        abort_unless(auth()->user()->tokenCan('handyman.update'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('update', $handyman);
        
        $handyman->update(['subscription_type_id' => null]);

        return HandymanResource::make(
            $handyman->load(['user', 'subscriptionType', 'categories', 'services', 'reviews', 'quotes'])
        );
    }
}
