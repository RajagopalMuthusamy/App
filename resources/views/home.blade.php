@extends('layouts.default')
 @section('title','Home')   

 @section('main-content')
 
 <div class="container py-2">

    <div class="position-absolute top-0 end-0 p-3">
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            Welcome, {{ auth()->user()->username }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="{{ route('change-password') }}">Change Password</a></li>
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </li>
        </ul>
    </div>
</div>



    <h3 class="mt-5" >All Posts</h3>
    @foreach ($posts as $post)
    <div class="post mb-2 p-2 border rounded">
        <p>{{ $post->content }}</p>
        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
        </form>
    </div>
@endforeach

   

<form action="{{ route('posts') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="content" class="form-label">What's on your mind?</label>
            <textarea name="content" id="content" class="form-control" rows="4" placeholder="Share your thoughts..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100 ">Post</button>
    </form>

    
</div>

    
@endsection

    

