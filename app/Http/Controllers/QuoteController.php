<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\QuoteResource;
use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;

/**
 * @group Quotes
 *
 * APIs for managing Quotes
 */

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quote::query()
            ->paginate();

        return QuoteResource::collection(
            $quotes
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
    public function store(StoreQuoteRequest $request)
    {
        $quote = Quote::create(
            $request->validated()
        );

        return QuoteResource::make(
            $quote->load(['user', 'handyman'])
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        return QuoteResource::make(
            $quote->load(['user', 'handyman'])
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuoteRequest $request, Quote $quote)
    {
        abort_unless(auth()->user()->tokenCan('quote.update'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('update', $quote);

        $quote->update(
            $request->validated()
        );

        return QuoteResource::make(
            $quote->load(['user', 'handyman'])
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        abort_unless(auth()->user()->tokenCan('quote.delete'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('delete', $quote);

        $quote->delete();
    }

    public function request(StoreQuoteRequest $request)
    {
        $quote = Quote::create(array_merge([
            'requested' => true
        ], $request->validated()));

        return QuoteResource::make(
            $quote->load(['user', 'handyman'])
        );
    }

    public function respond(UpdateQuoteRequest $request, Quote $quote)
    {
        abort_unless(auth()->user()->tokenCan('quote.update'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('update', $quote);

        if ($quote->requested == false) {
            return response([
                'message' => 'Not requested'
            ], 400);
        }

        $quote->update(
            $request->validated()
        );

        return QuoteResource::make(
            $quote->load(['user', 'handyman'])
        );
    }
}
