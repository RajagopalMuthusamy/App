<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
            'visibility' => 'required|in:public,private',
        ]);

        Post::create([
            'user_id' =>auth()->id(),
            'content' => $request->content,
            'visibility' => $request->visibility,
        ]);

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('home')->with('success', 'Post deleted successfully.');
    }
}
