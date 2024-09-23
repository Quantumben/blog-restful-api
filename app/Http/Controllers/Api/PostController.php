<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\Api\PostService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends BaseController
{
    use AuthorizesRequests;

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(): JsonResponse
    {
        $posts = $this->postService->index();

        // Fetch all Post using resource
        return response()->json([
            'message' => 'Posts retrieved successfully',
            'data' => PostResource::collection($posts),
        ], 200);
    }

    public function show(Post $post): JsonResponse
    {
        $post = $this->postService->show($post);

        return response()->json([
            'message' => 'Post retrieved successfully',
            'data' => new PostResource($post),
        ], 200);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $post = $this->postService->store($request->validated());

        return response()->json([
            'message' => 'Post created successfully',
            'data' => new PostResource($post),
        ], 201);
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $this->authorize('update', $post);

        $updatedPost = $this->postService->update($request->validated(), $post);

        return response()->json([
            'message' => 'Post updated successfully',
            'data' => new PostResource($updatedPost),
        ], 200);
    }

    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);

        $this->postService->destroy($post);

        return response()->json([
            'message' => 'Post deleted successfully',
        ], 200);
    }
}
