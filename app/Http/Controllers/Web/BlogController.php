<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;

class BlogController extends Controller
{
    /**
     * Display a listing of published blog posts.
     */
    public function index()
    {
        $posts = Post::published()
            ->latest('published_at')
            ->paginate(9);

        return view('landing.blog.index', compact('posts'));
    }

    /**
     * Display the specified blog post.
     */
    public function show(string $slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Get previous post (older)
        $previousPost = Post::published()
            ->where('id', '<', $post->id)
            ->orderBy('id', 'desc')
            ->first();

        // Get next post (newer)
        $nextPost = Post::published()
            ->where('id', '>', $post->id)
            ->orderBy('id', 'asc')
            ->first();

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('landing.blog.show', compact('post', 'previousPost', 'nextPost', 'relatedPosts'));
    }
}
