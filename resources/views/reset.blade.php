@extends('layouts.default')
 @section('title','Reset')   

 @section('main-content')
 <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
    @if(session('error'))
    <div class='alert alert-danger'>{{session('error')}}</div>
    @endif
      <h2 class="text-center mb-4">Reset Password</h2>
      <form id="resetForm" method="POST" action="{{ route('update-password') }}" >
        @csrf
        <div class="mb-3">
          <label for="oldpassword" class="form-label">Old Password:</label>
          <input type="password" id="oldpassword" name="oldpassword" placeholder="Enter your old password"   class="form-control @error('oldpassword') is-invalid @enderror">
            
          <div id="passwordErrorClient" class="invalid-feedback"></div>
           
          @error('oldpassword')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

        </div>

        <div class="mb-3">
          <label for="newpassword" class="form-label">New Password:</label>
          <input type="password" id="newpassword" name="new_password" placeholder="Enter your new password"   class="form-control @error('new_password') is-invalid @enderror">
            
          <div id="passwordErrorClient" class="invalid-feedback"></div>
           
          @error('new_password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

        </div>

        <div class="mb-3">
          <label for="confirmnewpassword" class="form-label">Confirm Password:</label>
          <input type="password" id="confirmnewpassword" name="new_password_confirmation"  placeholder="confirm new password"  class="form-control @error('new_password_confirmation') is-invalid @enderror">
            
          <div id="passwordErrorClient" class="invalid-feedback"></div>
           
          @error('new_password_confirmation')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

        </div>
        <button type="submit" class="btn btn-primary w-100">change password</button>
      </form>
    </div>
  </div>
  
@endsection

    

