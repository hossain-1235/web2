@extends('frontend.master')

@section('content')
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile Info</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Dashboard Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
        
            <div class="col-12 col-md-12 col-lg-4 col-xl-4 text-center miliods">
                <div class="d-block border rounded mfliud-bot">
                    <div class="dashboard_author px-2 py-5">
                        <div class="dash_auth_thumb circle p-1 border d-inline-flex mx-auto mb-2">
                            <img src="{{ asset('uploads/customer') }}/{{ Auth::guard('customer')->user()->photo }}" class="img-fluid circle" width="100" alt="" />
                        </div>
                        <div class="dash_caption">
                            <h4 class="fs-md ft-medium mb-0 lh-1">{{ Auth::guard('customer')->user()->name }}</h4>
                            <span class="text-muted smalls">{{ Auth::guard('customer')->user()->country }}</span>
                        </div>
                    </div>
                    
                    <div class="dashboard_author">
                        <h4 class="px-3 py-2 mb-0 lh-2 gray fs-sm ft-medium text-muted text-uppercase text-left">Dashboard Navigation</h4>
                        <ul class="dahs_navbar">
                            <li><a class="active" href="{{ route('customer.orders') }}"><i class="lni lni-shopping-basket mr-2"></i>My Order</a></li>
                            <li><a href="wishlist.html"><i class="lni lni-heart mr-2"></i>Wishlist</a></li>
                            <li><a href="profile-info.html"><i class="lni lni-user mr-2"></i>Profile Info</a></li>
                            <li><a href="{{ route('customer.logout') }}"><i class="lni lni-power-switch mr-2"></i>Log Out</a></li>
                        </ul>
                    </div>
                    
                </div>
            </div>
            
            <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                <!-- row -->
                @foreach ($myorders as $order)
                <div class="ord_list_wrap border mb-4">
                    <div class="ord_list_head gray d-flex align-items-center justify-content-between px-3 py-3">
                        <div class="olh_flex">
                            <p class="m-0 p-0"><span class="text-muted">Order Number</span></p>
                            <h6 class="mb-0 ft-medium">#{{ $order->order_id }}</h6>
                            <a href="{{ route('invoice.download', $order->order_id) }}" class="badge badge-primary">Download Invoice</a>
                        </div>	
                        <div class="col-xl-2 col-lg-2 col-md-2 col-12 ml-auto">
                            <p class="mb-1 p-0"><span class="text-muted">Status</span></p>
                            <div class="delv_status">
                                @if ($order->status == 0)
                                    <span class="ft-medium small text-white bg-secondary rounded px-3 py-1">
                                        Placed   
                                    </span>
                                @elseif ($order->status == 1)
                                    <span class="ft-medium small text-white bg-info rounded px-3 py-1">
                                        Processing   
                                    </span>
                                @elseif ($order->status == 2)
                                    <span class="ft-medium small text-white bg-warning rounded px-3 py-1">
                                        Shipping   
                                    </span>
                                @elseif ($order->status == 3)
                                    <span class="ft-medium small text-white bg-success rounded px-3 py-1">
                                        Delivered   
                                    </span>
                                @elseif ($order->status == 4)
                                    <span class="ft-medium small text-white bg-danger rounded px-3 py-1">
                                        Cancel   
                                    </span>
                                @endif
                                
                        </div>
                        </div>	
                    </div>
                    
                    <div class="ord_list_footer d-flex align-items-center justify-content-between br-top px-3">
                        <div class="col-xl-12 col-lg-12 col-md-12 pl-0 py-2 olf_flex d-flex align-items-center justify-content-between">
                            <div class="olf_flex_inner"><p class="m-0 p-0"><span class="text-muted medium text-left">Order Date: {{ $order->created_at->format('d-m-Y') }}</span></p></div>
                            <div class="olf_inner_right"><h5 class="mb-0 fs-sm ft-bold">Total: &#2547;{{ $order->total }}</h5></div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- row -->
            </div>
            
        </div>
    </div>
</section>
<!-- ======================= Dashboard Detail End ======================== -->
@endsection