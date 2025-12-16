@extends('frontend.master')
@section('content')
<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
        
            <div class="col-xl-6 m-auto col-lg-6 col-md-12 col-sm-12">
                <div class="mb-3">
                    <h3>Password Reset Form</h3>
                </div>
                @if (session('expired'))
                    <div class="alert alert-danger">{{session('expired')}}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                <form class="border p-3 rounded" action="{{ route('pass.reset.confirm', $token) }}" method="POST">
                    @csrf				
                    <div class="form-group">
                        <label>New Password *</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter New Password*">
                        @error('password')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Confirm Password *</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Enter Confirm Password*">
                        @error('password_confirmation')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Reset Password</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</section>
@endsection