 @extends('layouts.default')
 @section('title','Login')   

 @section('main-content')
 <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
      <h2 class="text-center mb-4">Login</h2>
      <form id="loginForm" method="POST" action="{{ route('authenticate') }}">
       
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required value="{{ old('email') }}">
        
          @error('email')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>
        
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
          
          @error('password')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>

      <div class="mt-3">
      <p>Don't have an account? <a href="{{route('register')}}"> Register here</a></p>
        </div>

       
    </div>
  </div>
    
@endsection

    

