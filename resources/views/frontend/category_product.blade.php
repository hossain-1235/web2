@extends('frontend.master')
@section('content')
<div class="container py-5">
    <div class="row">
    <div class="col-lg-12">
        <div class="pb-5 headline">
            <h3>Category: {{ $category->category_name }}</h3>
        </div>
        <div class="row align-items-center rows-products">		
            @foreach ($products as $product)
            <!-- Single -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                <div class="product_grid card b-0">
                    @if ($product->discount)
                        <div class="text-white badge bg-info position-absolute ft-regular ab-left text-upper">-{{ $product->discount }}%</div>
                    @endif
                    
                    <div class="p-0 card-body">
                        <div class="shop_thumb position-relative">
                            <a class="overflow-hidden card-img-top d-block" href="{{ route('product.details', $product->slug) }}"><img class="card-img-top" src="{{asset('uploads/product/preview')}}/{{ $product->preview }}" alt="..."></a>
                        </div>
                    </div>
                    <div class="p-0 pt-2 bg-white card-footer b-0 d-flex align-items-start justify-content-between">
                        <div class="text-left">
                            <div class="text-left">
                                <div class="elso_titl"><span class="small">{{ $product->rel_to_category->category_name }}</span></div>
                                <h5 class="mb-0 mb-1 fs-md lh-1"><a href="{{ route('product.details', $product->slug) }}">{{ $product->product_name }}</a></h5>
                                <div class="p-0 mb-2 star-rating align-items-center d-flex justify-content-left">
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
            @endforeach

        </div>
    </div>
</div>
</div>
@endsection