@extends('frontend.master')

@section('content')
<!-- ======================= Top Breadcrubms ======================== -->
<div class="py-3 gray">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Library</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Product Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="row justify-content-between">
        
            <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                <div class="quick_view_slide">
                    @foreach ($product_info->rel_to_gallery as $gallery)
                    <div class="single_view_slide"><a href="{{ asset('uploads/product/gallery') }}/{{ $gallery->gallery }}" data-lightbox="roadtrip" class="mb-4 d-block"><img src="{{ asset('uploads/product/gallery') }}/{{ $gallery->gallery }}" class="rounded img-fluid" alt="" /></a></div>
                    @endforeach
                </div>
            </div>

            @php
                $avg = '';
                if($total_reviews == 0){
                    $avg = 0;
                }
                else{
                    $avg = round($total_stars/$total_reviews);
                }
                
            @endphp
            <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                <div class="pl-3 prd_details">
                    
                    <div class="mb-1 prt_01"><span class="px-2 py-1 rounded text-light bg-info">{{ $product_info->rel_to_category->category_name }}</span></div>
                    <div class="mb-3 prt_02">
                        <h2 class="mb-1 ft-bold">{{ $product_info->product_name }}</h2>
                        <div class="text-left">
                            <div class="p-0 mb-1 star-rating align-items-center d-flex justify-content-left">
                                @for ($i = 1; $i <= $avg; $i++)
                                    <i class="fas fa-star filled"></i>
                                @endfor
                                @for ($avg; $avg<5; $avg++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                <span class="small">({{ $total_reviews }} Reviews)</span>
                            </div>
                            <div class="elis_rty">
                                <span class="mr-2 line-through ft-medium text-muted fs-md ">&#2547;<span class="o-price">{{ optional($product_info->rel_to_inv->first())->price }}</span></span>

                                <span class="mr-2 ft-bold theme-cl fs-lg ">&#2547;<span class="d-price">{{ optional($product_info->rel_to_inv->first())->discount_price }}</span></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4 prt_03">
                        <p>{{ $product_info->short_desp }}</p>
                    </div>
                    <form action="{{ route('add.cart') }}" method="POST">
                        @csrf
                        <div class="mb-2 prt_04">
                            <p class="mb-0 d-flex align-items-center text-dark ft-medium">Color:</p>
                            <div class="text-left">
                                @foreach ($available_colors as $color)
                                @if ($color->rel_to_color->color_name == 'NA')
                                <div class="mb-1 form-check form-option form-check-inline" >
                                    <input class="form-check-input color_id" type="radio" name="color_id" id="color{{ $color->color_id }}" value="{{ $color->color_id }}" checked>
                                    <label class="form-option-label rounded-circle" for="color{{ $color->color_id }}"><span class="form-option-color rounded-circle" style="background: {{ $color->rel_to_color->color_code }}">NA</span></label>
                                </div>
                                @else
                                    <div class="mb-1 form-check form-option form-check-inline">
                                        <input class="form-check-input color_id" type="radio" name="color_id" id="color{{ $color->color_id }}" value="{{ $color->color_id }}">
                                        <label class="form-option-label rounded-circle" for="color{{ $color->color_id }}"><span class="form-option-color rounded-circle" style="background: {{ $color->rel_to_color->color_code }}"></span></label>
                                    </div>
                                @endif
                                
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="mb-4 prt_04">
                            <p class="mb-0 d-flex align-items-center text-dark ft-medium">Size:</p>
                            <div class="pt-2 pb-0 text-left size_here">
                                @foreach ($available_sizes as $size)
                                @if ($size->rel_to_size->size_name == 'NA')
                                    <div class="mb-2 form-check size-option form-option form-check-inline">
                                    <input class="form-check-input size_id" type="radio" name="size_id" id="size{{ $size->size_id }}" value="{{ $size->size_id }}" checked>
                                    <label class="form-option-label" for="size{{ $size->size_id }}">{{ $size->rel_to_size->size_name }}</label>
                                </div>
                                @else
                                <div class="mb-2 form-check size-option form-option form-check-inline">
                                    <input class="form-check-input size_id" type="radio" name="size_id" id="size{{ $size->size_id }}" value="{{ $size->size_id }}">
                                    <label class="form-option-label" for="size{{ $size->size_id }}">{{ $size->rel_to_size->size_name }}</label>
                                </div>
                                @endif
                                
                                @endforeach
                            </div>
                            <div class="quan"></div>
                            @if (session('outstock'))
                                <strong class="text-danger">{{ session('outstock') }}</strong>
                            @endif
                            <div class="aa"></div>
                        </div>
                        
                        <div class="mb-4 prt_05">
                            <div class="form-row mb-7">
                                <div class="col-12 col-lg-auto">
                                    <!-- Quantity -->
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-top: 7px; font-family: Arial, sans-serif;">
                                    <button type="button" id="decrementBtn" 
                                        style="background-color: #ff4d4d; border: none; color: white; font-size: 20px; width: 40px; height: 40px; border-radius: 8px; cursor: pointer; transition: 0.3s;">
                                        -
                                    </button>

                                    <input id="counter" name="quantity" type="text" value="1" readonly
                                        style="width: 60px; text-align: center; font-size: 22px; font-weight: bold; border: 2px solid #ccc; border-radius: 8px; padding: 5px; background-color: #f9f9f9; color: #333;">
                                    
                                    <button type="button" id="incrementBtn" 
                                        style="background-color: #4CAF50; border: none; color: white; font-size: 20px; width: 40px; height: 40px; border-radius: 8px; cursor: pointer; transition: 0.3s;">
                                        +
                                    </button>
                                    </div>
                                </div>
                                <input type="hidden" value="{{ $product_info->id }}" name="product_id">
                                <div class="col-12 col-lg">
                                    <!-- Submit -->
                                    @auth('customer')
                                        <button type="submit" class="mb-2 btn btn-block custom-height bg-dark">
                                            <i class="mr-2 lni lni-shopping-basket"></i>Add to Cart 
                                        </button>
                                    @else
                                        <button id="cart" type="buttton" class="mb-2 btn btn-block custom-height bg-dark">
                                            <i class="mr-2 lni lni-shopping-basket"></i>Add to Cart 
                                        </button>
                                    @endauth
                                    
                                </div>
                                <div class="col-12 col-lg-auto">
                                    <!-- Wishlist -->
                                    <button class="mb-2 btn custom-height btn-default btn-block text-dark" data-toggle="button">
                                        <i class="mr-2 lni lni-heart"></i>Wishlist
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="prt_06 d-flex align-items-center">
                            <p class="mb-0 d-flex align-items-center">
                                <span class="">Share:</span>

                            </p>
                            <p>
                                {!! Share::page(url('/product/details/'. $product_info->slug))->facebook()->twitter()->whatsapp() !!}
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Product Detail End ======================== -->

<!-- ======================= Product Description ======================= -->
<section class="middle">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12">
                <ul class="mb-4 nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="description-tab" href="#description" data-toggle="tab" role="tab" aria-controls="description" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#information" id="information-tab" data-toggle="tab" role="tab" aria-controls="information" aria-selected="false">Additional information</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#reviews" id="reviews-tab" data-toggle="tab" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                    </li>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    
                    <!-- Description Content -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <div class="description_info">
                            {!! $product_info->long_desp !!}
                        </div>
                    </div>
                    
                    <!-- Additional Content -->
                    <div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
                        <div class="additionals">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th class="ft-medium text-dark">ID</th>
                                        <td>#1253458</td>
                                    </tr>
                                    <tr>
                                        <th class="ft-medium text-dark">SKU</th>
                                        <td>KUM125896</td>
                                    </tr>
                                    <tr>
                                        <th class="ft-medium text-dark">Color</th>
                                        <td>Sky Blue</td>
                                    </tr>
                                    <tr>
                                        <th class="ft-medium text-dark">Size</th>
                                        <td>Xl, 42</td>
                                    </tr>
                                    <tr>
                                        <th class="ft-medium text-dark">Weight</th>
                                        <td>450 Gr</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Reviews Content -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="reviews_info">
                            <!-- Single Review -->
                            @foreach ($reviews as $review)
                            <div class="py-3 single_rev d-flex align-items-start br-bottom">
                                <div class="single_rev_thumb">
                                    @if ($review->rel_to_customer->photo == null)
                                        <img src="{{ asset('frontend_asset') }}/img/team-2.jpg" class="img-fluid circle" width="90" alt="" /></div>
                                    @else
                                        <img src="{{ asset('uploads/customer') }}/{{ $review->rel_to_customer->photo }}" class="img-fluid circle" width="90" alt="" /></div>
                                    @endif
                                    
                                <div class="pl-3 single_rev_caption d-flex align-items-start">
                                    <div class="single_capt_left">
                                        <h5 class="mb-0 fs-md ft-medium lh-1">{{ $review->rel_to_customer->name }}</h5>
                                        <span class="small">{{ $review->updated_at->diffForHumans() }}</span>
                                        <p>{{ $review->review }}</p>
                                    </div>
                                    <div class="single_capt_right">
                                        <div class="p-0 mb-1 star-rating align-items-center d-flex justify-content-left">
                                            @for ($i=1; $i<=$review->rating; $i++)
                                                <i class="fas fa-star filled"></i>
                                            @endfor
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @auth('customer')
                            @if (App\Models\OrderProduct::where('customer_id', Auth::guard('customer')->id())->where('product_id', $product_info->id)->exists())
                            <div class="reviews_rate">
                                <form class="row" action="{{ route('review', $product_info->id) }}" method="POST">
                                    @csrf
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <h4>Submit Rating</h4>
                                    </div>
                                    
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="px-2 py-2 mt-1 mb-2 rounded revie_stars d-flex align-items-center justify-content-between gray">
                                            <div class="srt_013">
                                                <div class="submit-rating">
                                                    <input class="rating" id="star-5" type="radio" name="rating" value="5" />
                                                    <label for="star-5" title="5 stars">
                                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                                    </label>
                                                    <input class="rating" id="star-4" type="radio" name="rating" value="4" />
                                                    <label for="star-4" title="4 stars">
                                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                                    </label>
                                                    <input class="rating" id="star-3" type="radio" name="rating" value="3" />
                                                    <label for="star-3" title="3 stars">
                                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                                    </label>
                                                    <input class="rating" id="star-2" type="radio" name="rating" value="2" />
                                                    <label for="star-2" title="2 stars">
                                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                                    </label>
                                                    <input class="rating" id="star-1" type="radio" name="rating" value="1" />
                                                    <label for="star-1" title="1 star">
                                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="srt_014">
                                                <h6 class="mb-0"><span id="total">0</span> Star</h6>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="medium text-dark ft-medium">Full Name</label>
                                            <input type="text" value="{{ Auth::guard('customer')->user()->name }}" class="form-control" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="medium text-dark ft-medium">Email Address</label>
                                            <input type="email"  value="{{ Auth::guard('customer')->user()->email }}" class="form-control" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="medium text-dark ft-medium">Description</label>
                                            <textarea name="review" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="m-0 form-group">
                                            <button type="submit" class="btn btn-white stretched-link hover-black">Submit Review <i class="lni lni-arrow-right"></i></button>
                                        </div>
                                    </div>
                                    
                                </form>
                            </div>
                             @else
                                <h3>You did not purchase this product yet</h3>
                            @endif
                        @else
                            <h3>Please Login to write review</h3>
                        @endauth
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Product Description End ==================== -->

<!-- ======================= Similar Products Start ============================ -->
<section class="pt-0 middle">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center sec_title position-relative">
                    <h2 class="off_title">Similar Products</h2>
                    <h3 class="pt-3 ft-bold">Matching Producta</h3>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="slide_items">
                    
                    @foreach ($similler_products as $similler)
                    <!-- single Item -->
                    <div class="single_itesm">
                        <div class="mb-0 product_grid card b-0">
                            @if ($similler->discount)
                                <div class="text-white badge bg-success position-absolute ft-regular ab-left text-upper">-{{ $similler->discount }}%</div>
                            @endif
                            
                            <div class="p-0 card-body">
                                <div class="shop_thumb position-relative">
                                    <a class="overflow-hidden card-img-top d-block" href="{{route('product.details', $similler->slug)}}"><img class="card-img-top" src="{{ asset('uploads/product/preview') }}/{{ $similler->preview }}" alt="..."></a>
                                </div>
                            </div>
                            <div class="p-3 pb-0 card-footer b-0 d-flex align-items-start justify-content-center">
                                <div class="text-left">
                                    <div class="text-center">
                                        <h5 class="mb-0 mb-1 fw-bolder fs-md lh-1"><a href="{{route('product.details', $similler->slug)}}">{{ $similler->product_name }}</a></h5>
                                        <div class="elis_rty"><span class="ft-bold fs-md text-dark">&#2547;{{ optional($similler->rel_to_inv->first())->price }}</span></div>
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
</section>
<!-- ======================= Similar Products Start ============================ -->


<!-- ======================= Customer Features ======================== -->
<section class="px-0 py-3 br-top">
    <div class="container">
        <div class="row">
            
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="py-2 d-flex align-items-center justify-content-start">
                    <div class="d_ico">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                    <div class="d_capt">
                        <h5 class="mb-0">Free Shipping</h5>
                        <span class="text-muted">Capped at $10 per order</span>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="py-2 d-flex align-items-center justify-content-start">
                    <div class="d_ico">
                        <i class="far fa-credit-card"></i>
                    </div>
                    <div class="d_capt">
                        <h5 class="mb-0">Secure Payments</h5>
                        <span class="text-muted">Up to 6 months installments</span>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="py-2 d-flex align-items-center justify-content-start">
                    <div class="d_ico">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="d_capt">
                        <h5 class="mb-0">15-Days Returns</h5>
                        <span class="text-muted">Shop with fully confidence</span>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="py-2 d-flex align-items-center justify-content-start">
                    <div class="d_ico">
                        <i class="fas fa-headphones-alt"></i>
                    </div>
                    <div class="d_capt">
                        <h5 class="mb-0">24x7 Fully Support</h5>
                        <span class="text-muted">Get friendly support</span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
<!-- ======================= Customer Features ======================== -->
@endsection

@section('footer_script')
@if (session('review'))
    <script>
        Swal.fire({
        title: "Good job!",
        text: "{{ session('review') }}",
        icon: "success"
        });
    </script>
@endif
<script>
    $('#cart').click(function(){
        Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Please Login to add Cart",
        footer: '<a href={{route('customer.login')}}>Click to Login</a>'
        });
    })
</script>
<script>

    $('.rating').click(function(){
        let total = $(this).val();
        document.getElementById('total').textContent = total
        
        
    })

    $('.color_id').click(function(){
        let color_id =$(this).val();
        let product_id = '{{$product_info->id}}';
   
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:'/getSize',
            type:'POST',
            data:{'color_id':color_id, 'product_id':product_id},
            success: function (data) {
                $('.size_here').html(data);

                $('.size_id').click(function(){
                    let size_id = $(this).val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url:'/getQuantity',
                        type:'POST',
                        data:{'size_id':size_id, 'product_id':product_id, 'color_id':color_id,},
                        success: function (data) {
                            $('.quan').html(data.quantity)
                            $('.o-price').html(data.price)
                            $('.d-price').html(data.discount_price)
                        }
                    })

                })
            }
        })

    })
</script>
<script>
  const counter = document.getElementById("counter");
  const incrementBtn = document.getElementById("incrementBtn");
  const decrementBtn = document.getElementById("decrementBtn");

  incrementBtn.onclick = () => counter.value = parseInt(counter.value) + 1;

  decrementBtn.onclick = () => {
    let value = parseInt(counter.value);
    if (value > 1) counter.value = value - 1;
  };
</script>

@if (session('cart'))
    <script>
        const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
        icon: "success",
        title: "{{ session('cart') }}"
        });
    </script>
@endif

@endsection