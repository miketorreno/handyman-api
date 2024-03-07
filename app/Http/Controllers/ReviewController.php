<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Handyman;
use Illuminate\Http\Response;
use App\Http\Resources\ReviewResource;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @group Reviews
 *
 * APIs for managing Reviews
 */

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Handyman $handyman)
    {
        validator(request()->all(), [
            'handyman' => ['integer'],
            'user' => ['integer'],
        ])->validate();

        $reviews = Review::query()
            ->when(request('handyman'),
                fn($query) => $query->where('handyman_id', request('handyman'))
            )
            ->when(request('user'),
                fn($query) => $query->where('user_id', request('user'))
            )
            ->with(['user', 'handyman'])
            ->paginate();

        return ReviewResource::collection($reviews);
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
    public function store(StoreReviewRequest $request)
    {
        $attributes = $request->validated();

        try {
            $handyman = Handyman::findOrFail($attributes['handyman_id']);
        } catch (ModelNotFoundException $e) {
            throw ValidationException::withMessages([
                'handyman' => 'Handyman does not exist'
            ]);
        }

        if (!isset($attributes['rating']) && !isset($attributes['review'])) {
            throw ValidationException::withMessages([
                'review' => 'Write a review and/or rate the handyman'
            ]);
        }

        $review = auth()->user()->reviews()->create([
            'handyman_id' => $attributes['handyman_id'],
            'rating' => (isset($attributes['rating'])) ? $attributes['rating'] : null,
            'review' => (isset($attributes['review'])) ? $attributes['review'] : null,
        ]);

        return ReviewResource::make($review->load(['user', 'handyman']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $review->load(['user', 'handyman']);

        return ReviewResource::make($review);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        abort_unless(auth()->user()->tokenCan('review.update'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('update', $review);
        
        $attributes = $request->validated();

        $review->fill($attributes);
        if ($review->isDirty(['rating', 'review'])) {
            $review->edited = true;
            $review->save();
        }

        return ReviewResource::make($review->load(['user', 'handyman']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        abort_unless(auth()->user()->tokenCan('review.delete'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('delete', $review);

        $review->delete();
    }

    public function request(StoreReviewRequest $request)
    {
        $review = Review::create(array_merge([
            'requested' => true
        ], $request->validated()));

        return ReviewResource::make(
            $review->load(['user', 'handyman'])
        );
    }

    public function respond(UpdateReviewRequest $request, Review $review)
    {
        abort_unless(auth()->user()->tokenCan('review.update'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('update', $review);

        if ($review->requested == false) {
            return response([
                'message' => 'Not requested'
            ], 400);
        }

        $review->update(
            $request->validated()
        );

        return ReviewResource::make(
            $review->load(['user', 'handyman'])
        );
    }
}
