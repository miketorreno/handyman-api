<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Response;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::query()
            ->paginate();

        return PostResource::collection(
            $posts
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
    public function store(StorePostRequest $request)
    {
        $post = Post::create(
            $request->validated()
        );

        return PostResource::make(
            $post->load(['user'])
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return PostResource::make(
            $post->load(['user'])
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        abort_unless(auth()->user()->tokenCan('post.update'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('update', $post);

        $post->update(
            $request->validated()
        );

        return PostResource::make(
            $post->load(['user'])
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        abort_unless(auth()->user()->tokenCan('post.delete'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('delete', $post);

        $post->delete();
    }
}
