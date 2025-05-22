<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Post::create([
            'content' => $request->content,
        ]);

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }
}
