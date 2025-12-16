@extends('layouts.admin')
@section('content')
<div class="row">
    @can('coupon')
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Coupon List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Coupon</th>
                        <th>Amount</th>
                        <th>Validity</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($coupons as $coupon)                        
                    <tr>
                        <td>{{ $coupon->coupon }}</td>
                        <td>{{ $coupon->amount }}%</td>
                        <td>
                            @if (Carbon\Carbon::now()->diffInDays($coupon->validity) < 1 )
                                <span class="badge badge-danger">Expired {{ round(Carbon\Carbon::now()->diffInDays($coupon->validity))}} days ego</span>
                            @else
                                <span class="badge badge-success">{{ round(Carbon\Carbon::now()->diffInDays($coupon->validity))}} days left</span>
                            @endif
                        </td>
                        <td>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Coupon</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('add.coupon') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Coupon Name</label>
                        <input type="text" name="coupon" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount %</label>
                        <input type="text" name="amount" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Validity</label>
                        <input type="date" name="validity" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <div>
        <h3>dure ja tor permission nai</h3>
    </div>
    @endcan
</div>
@endsection