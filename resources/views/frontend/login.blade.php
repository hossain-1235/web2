@extends('frontend.master')
@section('content')
<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Login Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
        
            <div class="col-xl-6 m-auto col-lg-6 col-md-12 col-sm-12">
                <div class="mb-3">
                    <h3>Login</h3>
                </div>
                <form class="border p-3 rounded" action="{{ route('customer.signin') }}" method="POST">
                    @csrf				
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="text" name="email" class="form-control" placeholder="Email*">
                        @error('email')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        @if (session('nt_exists'))
                            <div class="alert alert-danger">{{ session('nt_exists') }}</div>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" name="password" class="form-control" placeholder="Password*">
                        @error('email')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        @if (session('wrong_pass'))
                            <div class="alert alert-danger">{{ session('wrong_pass') }}</div>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="eltio_k2">
                                <a href="{{ route('forgot.password') }}">Lost Your Password?</a>
                            </div>	
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</section>
<!-- ======================= Login End ======================== -->
@endsection