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



    <h3 class="mt-4">All Posts</h3>
    @foreach ($posts as $post)
        <div class="col-8 post mb-1 p-1 border rounded">
            @if ($post->user_id != auth()->id())
            <h6 class='text-primary'>{{ $post->user->username }}</h6>
            @endif
            <div class='d-flex justify-content-between align-items-center'>
                <p>{{ $post->content }}</p>
                @if ($post->user_id == auth()->id())
                    <form action="{{ route('delete', $post->id) }}" method="POST" >
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach

    <form action="{{ route('posts') }}" method="POST">
            @csrf
            <div class="col-8">
                <div class="mb-3">
                    <label for="content" class="form-label">What's on your mind?</label>
                    <textarea name="content" id="content" class="form-control" rows="4" placeholder="Share your thoughts..." required></textarea>
                </div>
                <div class="mb-3">
                    <label for="visibility" class="form-label">Visibility</label>
                    <select name="visibility" id="visibility" class="form-control" required>
                        <option value="public" >Public</option>
                        <option value="private">Private</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100 ">Post</button>
            </div>
    </form>
    
</div>
    
@endsection

    

