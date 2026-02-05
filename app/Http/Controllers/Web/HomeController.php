<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $latestPosts = Post::published()
            ->latest('published_at')
            ->limit(3)
            ->get();
            
        return view('landing.home', compact('latestPosts'));
    }
}
