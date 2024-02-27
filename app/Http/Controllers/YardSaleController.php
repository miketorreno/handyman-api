<?php

namespace App\Http\Controllers;

use App\Models\YardSale;
use Illuminate\Http\Response;
use App\Http\Resources\YardSaleResource;
use App\Http\Requests\StoreYardSaleRequest;
use App\Http\Requests\UpdateYardSaleRequest;

/**
 * @group Yard sales
 *
 * APIs for managing Yard sales
 */

class YardSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $yardSales = YardSale::query()
            ->when(request('user'),
                fn($query) => $query->where('user_id', request('user'))
            )
            ->with(['user'])
            ->paginate();

        return YardSaleResource::collection($yardSales);
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
    public function store(StoreYardSaleRequest $request)
    {
        $yardSale = YardSale::create(array_merge([
            'user_id' => auth()->id()
        ], $request->validated()));

        return YardSaleResource::make(
            $yardSale->load(['user'])
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(YardSale $yardSale)
    {
        $yardSale->load(['user']);

        return YardSaleResource::make($yardSale);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(YardSale $yardSale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateYardSaleRequest $request, YardSale $yardSale)
    {
        abort_unless(auth()->user()->tokenCan('yardsale.update'),
            Response::HTTP_FORBIDDEN
        );
        // $this->authorize('update', $yardSale);
        
        $yardSale->update([
            $request->validated()
        ]);

        return YardSaleResource::make($yardSale->load(['user']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(YardSale $yardSale)
    {
        abort_unless(auth()->user()->tokenCan('yardsale.delete'),
            Response::HTTP_FORBIDDEN
        );
        // $this->authorize('delete', $yardSale);

        $yardSale->delete();
    }
}
