       <!--====== Section 2 ======-->
       <div class="u-s-p-b-60 ">

           <!--====== Section Intro ======-->
           <div class="section__intro u-s-m-b-60">
               <div class="container">
                   <div class="row">
                       <div class="col-lg-12">
                           <div class="section__text-wrap">
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <!--====== End - Section Intro ======-->

           <!--====== Section Content ======-->
           <div class="section__content">
               <div class="container">
                   <div class="row mb-5">
                       <div class="col-lg-12 col-md-12 col-sm-12">

                           @if (\Gloudemans\Shoppingcart\Facades\Cart::instance('wishlist')->count() > 0)
                               @foreach (\Gloudemans\Shoppingcart\Facades\Cart::instance('wishlist')->content() as $item)
                                   <!--====== Wishlist Product ======-->
                                   <div class="w-r u-s-m-b-30">
                                       <div class="w-r__container">
                                           <div class="w-r__wrap-1">
                                               <div class="w-r__img-wrap">

                                                   @php
                                                       $photos = explode(',', @$item->model->image);
                                                   @endphp
                                                   @if (file_exists(public_path() . '/uploads/product/' . @$item->model->image))
                                                       <a href="{{ route('productDetail', @$item->model->slug) }}">

                                                           <img class="u-img-fluid"
                                                               src={{ asset('/uploads/product/' . @$item->model->image) }}>
                                                       </a>
                                                   @else
                                                       <a href="{{ route('productDetail', @$item->model->slug) }}">

                                                           <img class="u-img-fluid" src={{ $photos[0] }}>
                                                       </a>
                                                   @endif

                                               </div>
                                               <div class="w-r__info">

                                                   <span class="w-r__name">

                                                       <a href="">{{ @$item->name }}</a></span>

                                                   {{-- <span class="w-r__category">

                                                <a href="shop-side-version-2.html">{{ @$item-> }}</a></span> --}}

                                                   <span class="w-r__price"> Rs {{ number_format(@$item->price, 2) }}

                                                       {{-- <span class="w-r__discount">$160.00</span></span> --}}
                                               </div>
                                           </div>
                                           <div class="w-r__wrap-2">

                                               <a class="w-r__link btn--e-brand-b-2 move-to-cart" data-modal="modal"
                                                   data-modal-id="#add-to-cart" href="javascript:void(0)"
                                                   data-id="{{ @$item->rowId }}"
                                                   {{ @$item->model->stock > 0 ? '' : 'hidden' }}>ADD TO CART</a>

                                               <button class="w-r__link btn--e-transparent-platinum-b-2 delete_wishlist"
                                                   data-id="{{ @$item->rowId }}">REMOVE</button>
                                           </div>
                                       </div>
                                   </div>
                                   <!--====== End - Wishlist Product ======-->
                               @endforeach
                           @else
                               <div>
                                   <p class="text-center" style="font-weight: bold; color: black; margin-bottom: 60px">
                                       You
                                       don't have any product in your wishlist.</p>
                               </div>
                           @endif
                       </div>
                       <div class="col-lg-12">
                           <div class="route-box">
                               <div class="route-box__g">

                                   <a class="route-box__link" href="{{route('front.home')}}"><i
                                           class="fas fa-long-arrow-alt-left"></i>

                                       <span>CONTINUE SHOPPING</span></a>
                               </div>
                               {{-- <div class="route-box__g">

                            <a class="route-box__link" href="wishlist.html"><i class="fas fa-trash"></i>

                                <span>CLEAR WISHLIST</span></a>
                        </div> --}}
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <!--====== End - Section Content ======-->
       </div>
       <!--====== End - Section 2 ======-->
