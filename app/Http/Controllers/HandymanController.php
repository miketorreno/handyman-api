<?php

namespace App\Http\Controllers;

use App\Models\Handyman;
use App\Http\Resources\HandymanResource;
use App\Http\Requests\StoreHandymanRequest;
use App\Http\Requests\UpdateHandymanRequest;

class HandymanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $handymen = Handyman::query()
            ->where('approval_status', Handyman::APPROVAL_APPROVED)
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Handyman $handyman)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Handyman $handyman)
    {
        //
    }
}
