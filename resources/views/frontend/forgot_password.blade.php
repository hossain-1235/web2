@extends('frontend.master')
@section('content')
<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
        
            <div class="col-xl-6 m-auto col-lg-6 col-md-12 col-sm-12">
                <div class="mb-3">
                    <h3>Request for Password Reset</h3>
                </div>
                <form class="border p-3 rounded" action="{{ route('send.password.request') }}" method="POST">
                    @csrf				
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="text" name="email" class="form-control" placeholder="Email*">
                        @if (session('notExist'))
                            <strong class="text-danger">{{ session('notExist') }}</strong>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Send Request</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</section>
@endsection