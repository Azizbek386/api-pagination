<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $posts = Post::paginate($perPage);
        return response()->json([
            
            'message' => 'Posts retrieved successfully',
            'posts' => $posts,
        ]);
        
    }




     public function search(Request $request)
{
    $query = $request->input('query');

    $posts = Post::where('title', 'like', "%$query%")
                ->orWhere('body', 'like', "%$query%")
                ->paginate(20); // har sahifada 20 ta

    return response()->json([
        'message' => 'Search results',
        'posts' => $posts
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $posts = Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
        return response()->json([
            'message' => 'Post created successfully',
            'post' => $posts,
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if ($post) {
            return response()->json([
                'message' => 'Post found',
                'post' => $post,
            ]);
        } else {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        if ($post) {
            $post->update([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
            ]);
            return response()->json([
                'message' => 'Post updated successfully',
                'post' => $post,
            ]);
        } else {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if ($post) {
            $post->delete();
            return response()->json([
                'message' => 'Post deleted successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }
    }
}