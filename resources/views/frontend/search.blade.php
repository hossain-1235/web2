@extends('frontend.master')
@section('content')
<div class="container">
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="sec_title position-relative text-center">
            <h2 class="off_title">Home</h2>
            <h3 class="ft-bold pt-3">Search Product</h3>
        </div>
    </div>
</div>
<div class="row align-items-center rows-products">		
    @forelse ($search_products as $product)
    <!-- Single -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-6">
        <div class="product_grid card b-0">
            @if ($product->discount)
                <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">-{{ $product->discount }}%</div>
            @endif
            
            <div class="card-body p-0">
                <div class="shop_thumb position-relative">
                    <a class="card-img-top d-block overflow-hidden" href="{{ route('product.details', $product->slug) }}"><img class="card-img-top" src="{{asset('uploads/product/preview')}}/{{ $product->preview }}" alt="..."></a>
                </div>
            </div>
            <div class="card-footer b-0 p-0 pt-2 bg-white d-flex align-items-start justify-content-between">
                <div class="text-left">
                    <div class="text-left">
                        <div class="elso_titl"><span class="small">{{ $product->rel_to_category->category_name }}</span></div>
                        <h5 class="fs-md mb-0 lh-1 mb-1"><a href="{{ route('product.details', $product->slug) }}">{{ $product->product_name }}</a></h5>
                        <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="elis_rty">
                            <span class="ft-bold text-dark fs-sm">&#2547;{{ optional($product->rel_to_inv->first())->price }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @empty
    <div class="py-5 text-center w-100">
        <img width="500" src="{{ asset('frontend_asset/img/notfound.webp') }}" alt="">
    </div>
    @endforelse

   </div>
</div>
@endsection