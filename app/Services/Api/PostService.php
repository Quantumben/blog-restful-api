<?php
namespace App\Services\Api;

use App\Models\User;
use App\Models\Post;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PostService extends BaseService
{
    public function index()
    {
        // Retrieve all posts with their associated user
        return Post::with('user')->get();
    }

    public function show(Post $post)
    {
        // Load the user relationship
        $post->load('user');

        return $post;
    }

    public function store(array $data)
    {
        // Create the post for the authenticated user
        return Auth::user()->posts()->create([
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
    }

    public function update(array $data, Post $post)
    {
        // Update the post
        $post->update($data);

        return $post;
    }

    public function destroy(Post $post)
    {
        // Delete the post
        $post->delete();

        return ['message' => 'Post deleted successfully'];
    }
}
