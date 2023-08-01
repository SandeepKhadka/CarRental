 <!-- Latest Products-->
 <section class="section-maker">
     <div>
         <div class="container">
             <div class="sec-maker-header text-center">
                 <h3 class="sec-maker-h3 u-s-m-b-22">Latest Products</h3>
             </div>
         </div>
         <!-- Offer Sidebar -->
         <div class="float-right d-none d-md-block">
             <div>
                 <div class="card shadow-sm"
                     style="width: 12rem; height: 345px; margin: 0px 0px 0px 5px; border: 2px solid #dcdcdd; background-image: url('{{ asset('dist/img/side_banner3.png') }}'); background-repeat: no-repeat; background-size: cover;">
                     <div class="card-body" style="padding-top: 150px">
                         <div class="d-flex justify-content-center">
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!-- View More Sidebar -->
         <div class="float-left d-none d-md-block">
             <div class="card shadow-sm"
                 style="width: 12rem; height: 345px; margin: 0px 0px 0px 5px; border: 2px solid #dcdcdd; background-image: url('{{ asset('dist/img/side_banner1.png') }}'); background-repeat: no-repeat; background-size: cover;">
                 <div class="card-body" style="padding-top: 150px">
                     <div class="d-flex justify-content-center">
                     </div>
                 </div>
             </div>

         </div>
         <!-- Carousel -->
         <div class="container ">
             <div class="slider-fouc">
                 <div class="products-slider owl-carousel" data-item="6">
                     @if (isset($hot_products) && $hot_products != null)
                         @foreach ($hot_products as $hot_product)
                             @php
                                 $photos = explode(',', $hot_product->image);
                             @endphp
                             <div class="item" style="max-height: 350px">
                                 <div class="image-container">
                                     @if (file_exists(public_path() . '/uploads/product/' . $hot_product->image))
                                         <a class="item-img-wrapper-link"
                                             href="{{ route('productDetail', $hot_product->slug) }}">
                                             <img class="img-fluid"
                                                 src={{ asset('/uploads/product/' . $hot_product->image) }}
                                                 alt="Product">
                                         </a>
                                     @else
                                         <a class="item-img-wrapper-link"
                                             href="{{ route('productDetail', $hot_product->slug) }}">
                                             <img class="img-fluid" src={{ $photos[0] }} alt="Product">
                                         </a>
                                     @endif
                                     <div class="item-action-behaviors">
                                         <form id="my-form"
                                             action="{{ url('http://127.0.0.1:8000/chatify/' . @$hot_product->vendor_id) }}"
                                             method="get" target="_blank">
                                             <input type="hidden" value="{{ @$hot_product->id }}" name="product_id">
                                             <a class="item-mail d-none d-md-block" href="#"
                                                 onclick="if (confirm('Do you want to start a conversation about this product?')) { submitForm(); }">Chat</a>
                                         </form>
                                         <a class="item-addwishlist add_to_wishlist" href="javascript:void(0)"
                                             data-quantity="1" data-id="{{ $hot_product->id }}"
                                             id="add_to_wishlist_{{ $hot_product->id }}">Add to Wishlist</a>
                                         <a class="item-addCart add_to_cart" href="javascript:void(0)" data-quantity="1"
                                             data-product-id="{{ $hot_product->id }}"
                                             id="add_to_cart{{ $hot_product->id }}">Add to Cart</a>
                                     </div>
                                 </div>
                                 <div class="item-content">
                                     <div class="what-product-is">
                                         <ul class="bread-crumb">
                                             <li>
                                                 <a href="shop-v3-sub-sub-category.html">{{ $hot_product->title }}</a>
                                             </li>
                                         </ul>
                                         <h6 class="item-title">

                                             <a href="single-product.html">{!! html_entity_decode(Str::limit($hot_product->summary, 20)) !!}
                                             </a>
                                         </h6>
                                         @php
                                             $avg_rating = \App\Models\ProductReview::where('product_id', @$hot_product->id)->avg('rate');
                                             $avg_rating = floatval($avg_rating);
                                             $rating = explode('.', $avg_rating);
                                             $rating[0] = intval($rating[0]);
                                             if (isset($rating[1])) {
                                                 $rating[1] = intval($rating[1]);
                                             }
                                         @endphp
                                         <div class="u-s-m-b-15">
                                             <div class="pd-detail__rating gl-rating-style">
                                                 @for ($i = 0; $i < $rating[0]; $i++)
                                                     <i class="fas fa-star"
                                                         style="font-size: 14px; color: orange; margin-right: -4px;"></i>
                                                 @endfor
                                                 @if (isset($rating[1]) && $rating[1] > 0)
                                                     <i class="fas fa-star-half-alt"
                                                         style="font-size: 14px; color: orange; margin-right: -4px;"></i>
                                                 @endif
                                             </div>
                                         </div>

                                     </div>
                                     <div class="price-template">
                                         <div class="item-new-price">
                                             Rs {{ $hot_product->price }}
                                         </div>
                                         <div class="item-old-price">
                                             Rs {{ $hot_product->discount }}
                                         </div>
                                     </div>
                                 </div>
                                 <div class="tag hot">
                                     <span>{{ $hot_product->conditions }}</span>
                                 </div>
                             </div>
                         @endforeach
                     @endif
                 </div>
             </div>
         </div>
         <!-- Carousel /- -->
     </div>
     <div class="product-list">

     </div>
 </section>
 <!-- Latest Products/- -->

 <!-- For You -->
 <section class="section-maker">
     <div>
         <div class="container">
             <div class="sec-maker-header text-center">
                 <h3 class="sec-maker-h3">JUST FOR YOU</h3>
             </div>
         </div>
         <!-- Offer Sidebar -->
         <div class="float-right d-none d-md-block">
             <div>
                 <div class="card shadow-sm"
                     style="width: 12rem; height: 345px; margin: 0px 0px 0px 5px; border: 2px solid #dcdcdd; background-image: url('{{ asset('dist/img/side_banner4.png') }}'); background-repeat: no-repeat; background-size: cover;">
                     <div class="card-body" style="padding-top: 150px">
                         <div class="d-flex justify-content-center">
                             <p class="text-dark">Best Offer</p>
                             {{-- <button>View more</button> --}}
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!-- View More Sidebar -->
         <div class="float-left d-none d-md-block">
             <div>
                 <div class="card shadow-sm"
                     style="width: 12rem; height: 345px; margin: 0px 0px 0px 5px; border: 2px solid #dcdcdd; background-image: url('{{ asset('dist/img/side_banner5.png') }}'); background-repeat: no-repeat; background-size: cover;">
                     <div class="card-body" style="padding-top: 150px">
                     </div>
                 </div>
             </div>
         </div>
         <!-- Carousel -->
         <div class="container ">
             <div class="slider-fouc">
                 <div class="products-slider owl-carousel" data-item="6">
                     @if (isset($redeem_products) && $redeem_products != null)
                         @foreach ($redeem_products as $redeem_product)
                             @php
                                 $photos = explode(',', $redeem_product->image);
                             @endphp
                             <div class="item" style="max-height: 350px">
                                 <div class="image-container">
                                     @if (file_exists(public_path() . '/uploads/product/' . $redeem_product->image))
                                         <a class="item-img-wrapper-link"
                                             href="{{ route('productDetail', $redeem_product->slug) }}">
                                             <img class="img-fluid"
                                                 src={{ asset('/uploads/product/' . $redeem_product->image) }}
                                                 alt="Product">
                                         </a>
                                     @else
                                         <a class="item-img-wrapper-link"
                                             href="{{ route('productDetail', $redeem_product->slug) }}">
                                             <img class="img-fluid" src={{ $photos[0] }} alt="Product">
                                         </a>
                                     @endif
                                     <div class="item-action-behaviors">
                                         <form id="my-form"
                                             action="{{ url('http://127.0.0.1:8000/chatify/' . @$redeem_product->vendor_id) }}"
                                             method="get" target="_blank">
                                             <input type="hidden" value="{{ @$redeem_product->id }}"
                                                 name="product_id">
                                             <a class="item-mail d-none d-md-block" href="#"
                                                 onclick="if (confirm('Do you want to start a conversation about this product?')) { submitForm(); }">Chat</a>
                                         </form>
                                         <a class="item-addwishlist add_to_wishlist" href="javascript:void(0)"
                                             data-quantity="1" data-id="{{ $redeem_product->id }}"
                                             id="add_to_wishlist_{{ $redeem_product->id }}">Add to Wishlist</a>
                                         <a class="item-addCart add_to_cart" href="javascript:void(0)"
                                             data-quantity="1" data-product-id="{{ $redeem_product->id }}"
                                             id="add_to_cart{{ $redeem_product->id }}">Add to Cart</a>
                                     </div>
                                 </div>
                                 <div class="item-content">
                                     <div class="what-product-is">
                                         <ul class="bread-crumb">
                                             <li>
                                                 <a href="shop-v3-sub-sub-category.html">{{ $redeem_product->title }}</a>
                                             </li>
                                         </ul>
                                         <h6 class="item-title">

                                             <a href="single-product.html">{!! html_entity_decode(Str::limit($redeem_product->summary, 20)) !!}
                                             </a>
                                         </h6>
                                         @php
                                             $avg_rating = \App\Models\ProductReview::where('product_id', @$redeem_product->id)->avg('rate');
                                             $avg_rating = floatval($avg_rating);
                                             $rating = explode('.', $avg_rating);
                                             $rating[0] = intval($rating[0]);
                                             if (isset($rating[1])) {
                                                 $rating[1] = intval($rating[1]);
                                             }
                                         @endphp
                                         <div class="u-s-m-b-15">
                                             <div class="pd-detail__rating gl-rating-style">
                                                 @for ($i = 0; $i < $rating[0]; $i++)
                                                     <i class="fas fa-star"
                                                         style="font-size: 14px; color: orange; margin-right: -4px;"></i>
                                                 @endfor
                                                 @if (isset($rating[1]) && $rating[1] > 0)
                                                     <i class="fas fa-star-half-alt"
                                                         style="font-size: 14px; color: orange; margin-right: -4px;"></i>
                                                 @endif
                                             </div>
                                         </div>

                                     </div>
                                     <div class="price-template">
                                         <div class="item-new-price">
                                             Rs {{ $redeem_product->price }}
                                         </div>
                                         <div class="item-old-price">
                                             Rs {{ $redeem_product->discount }}
                                         </div>
                                     </div>
                                 </div>
                                 <div class="tag hot">
                                     <span>{{ $redeem_product->conditions }}</span>
                                 </div>
                             </div>
                         @endforeach
                     @endif
                 </div>
             </div>
         </div>
         <!-- Carousel /- -->
         <div class="redirect-link-wrapper text-center u-s-p-t-25 u-s-p-b-80">
             <a class="redirect-link" href="store-directory.html">
                 {{-- <span>View more</span> --}}
                 <span></span>
             </a>
         </div>
     </div>
 </section>
