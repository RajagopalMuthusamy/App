@extends('layouts.default')
 @section('title','Register')   

 @section('main-content')
 <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
      <h2 class="text-center mb-4">Register</h2>
      <form id="registerForm" method="POST" action="{{ route('store') }}" onsubmit="validateForm(event)">
        @csrf
        <div class="mb-3">
          <label for="username" class="form-label">Name:</label>
          <input type="text"  id="username" name="username" placeholder="Enter your name" required  value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror">
            
          <div id="usernameErrorClient" class="invalid-feedback"></div>
            
          @error('username')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" required value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
            
          <div id="emailErrorClient" class="invalid-feedback"></div>

          @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password:</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required  class="form-control @error('password') is-invalid @enderror">
            
          <div id="passwordErrorClient" class="invalid-feedback"></div>
           
          @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>
      </form>
    </div>
  </div>
  <script>
        function validateForm(event) {
            event.preventDefault();

            // Clear previous client-side validation errors
            document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.innerText = '');

            const username = document.getElementById("username");
            const email = document.getElementById("email");
            const password = document.getElementById("password");

            let isValid = true;

            // Username validation
            if (username.value.trim().length < 3) {
                username.classList.add('is-invalid');
                document.getElementById("usernameErrorClient").innerText = "Username must be at least 3 characters.";
                isValid = false;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value.trim())) {
                email.classList.add('is-invalid');
                document.getElementById("emailErrorClient").innerText = "Enter a valid email address.";
                isValid = false;
            }

            // Password validation
            if (password.value.length < 6) {
                password.classList.add('is-invalid');
                document.getElementById("passwordErrorClient").innerText = "Password must be at least 6 characters.";
                isValid = false;
            }

            if (isValid) {
                document.getElementById("registerForm").submit();
            }
        }
    </script>
@endsection

    

