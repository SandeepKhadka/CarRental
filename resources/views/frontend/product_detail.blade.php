@extends('frontend.layouts.master')
@section('title', 'GoodGoods - Product Detail')
@section('styles')
    <!--====== Vendor Css ======-->
    <link rel="stylesheet" href="{{ asset('assets/shop/css/vendor.css') }}">

    <!--====== Utility-Spacing ======-->
    <link rel="stylesheet" href="{{ asset('assets/shop/css/utility.css') }}">
    <!--====== App ======-->
    <link rel="stylesheet" href="{{ asset('assets/shop/css/app.css') }}">
    <style>
        /* Styles for the popup modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            position: relative;
            max-width: 600px;
            width: 90%;
        }

        .close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="email"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-group-addon {
            position: absolute;
            left: 0;
            padding: 10px;
            font-size: 16px;
            background-color: #ccc;
            color: #fff;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .submit-btn {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #4CAF50;
        }

        .submit-btn:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.5);
        }
    </style>

@endsection

@section('main-content')
    <!--====== App Content ======-->
    <div class="app-content">
        <div class="col-lg-12" style="z-index: 1">
            @include('admin.section.notify')
        </div>
        <!--====== Section 1 ======-->
        <div class="u-s-p-t-90">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">

                        <!--====== Product Breadcrumb ======-->
                        <div class="pd-breadcrumb u-s-m-b-30">
                            <ul class="pd-breadcrumb__list">
                                <li class="has-separator">

                                    <a href="{{ route('front.home') }}">Home</a>
                                </li>
                                <li class="has-separator">

                                    <a
                                        href="">{{ \App\Models\Category::where('id', @$product->cat_id)->value('title') }}</a>
                                </li>
                                <li class="has-separator">

                                    <a
                                        href="">{{ \App\Models\Category::where('id', @$product->child_cat_id)->value('title') }}</a>
                                </li>
                                <li class="is-marked">

                                    <a href="">{{ @$product->title }}</a>
                                </li>
                            </ul>
                        </div>
                        <!--====== End - Product Breadcrumb ======-->


                        @php
                            $photos = explode(',', $product->image);
                        @endphp
                        <!--====== Product Detail Zoom ======-->
                        <div class="pd u-s-m-b-30">
                            <div class="slider-fouc pd-wrap">
                                <div id="pd-o-initiate">
                                    @foreach ($photos as $key => $photo)
                                        <div class="pd-o-img-wrap {{ $key == 0 ? 'active' : '' }}"
                                            data-src="{{ asset('/uploads/product/' . @$product->image) }}">
                                            @if (file_exists(public_path() . '/uploads/product/' . $product->image))
                                                <td>
                                                    <img class="u-img-fluid"
                                                        src="{{ asset('/uploads/product/' . @$product->image) }}"
                                                        data-zoom-image="{{ asset('/uploads/product/' . @$product->image) }}"
                                                        alt="" id="product-image">
                                                </td>
                                            @else
                                                <td>
                                                    <img src="{{ $photo }}" alt="{{ $product->title }}">
                                                </td>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="u-s-m-t-15">
                                <div class="slider-fouc">
                                    <div id="pd-o-thumbnail">
                                        @foreach ($photos as $key => $photo)
                                            <div>

                                                @if (file_exists(public_path() . '/uploads/product/' . $product->image))
                                                    <img class="u-img-fluid"
                                                        src="{{ asset('/uploads/product/' . @$product->image) }}"
                                                        data-zoom-image="{{ asset('/uploads/product/' . @$product->image) }}"
                                                        alt="">
                                                @else
                                                    <img class="u-img-fluid" src="{{ $photo }}"
                                                        alt="{{ $product->title }}" id="product-name">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--====== End - Product Detail Zoom ======-->
                    </div>
                    <div class="col-lg-5">

                        <!--====== Product Right Side Details ======-->
                        <div class="pd-detail">
                            <div>

                                <span class="pd-detail__name">{{ @$product->title }}</span>
                            </div>
                            <div>
                                <div class="pd-detail__inline">

                                    <span class="pd-detail__price">Rs {{ @$product->offer_price }}</span>

                                    <span class="pd-detail__discount">({{ @$product->discount }}% OFF)</span><del
                                        class="pd-detail__del">Rs {{ @$product->price }}</del>
                                </div>
                            </div>
                            @php
                                $avg_rating = \App\Models\ProductReview::where('product_id', @$product->id)->avg('rate');
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
                                        <i class="fas fa-star" style="margin-right: -4px;"></i>
                                    @endfor
                                    @if (isset($rating[1]) && $rating[1] > 0)
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif

                                    <span class="pd-detail__review u-s-m-l-4">

                                        <a data-click-scroll="#view-review">{{ \App\Models\ProductReview::where('product_id', @$product->id)->count() }}
                                            Reviews</a></span>
                                </div>
                            </div>
                            <div class="u-s-m-b-15">
                                <div class="pd-detail__inline">

                                    <span class="pd-detail__stock">{{ @$product->stock }} in stock</span>

                                </div>
                            </div>
                            <div class="u-s-m-b-15">

                                <span class="pd-detail__preview-desc">{!! html_entity_decode(@$product->summary) !!}</span>
                            </div>
                            <div class="u-s-m-b-15">
                                <div class="pd-detail__inline">
                                    @php
                                        $wishlist = [];
                                        if (\Gloudemans\Shoppingcart\Facades\Cart::instance('wishlist')->count() > 0) {
                                            foreach (\Gloudemans\Shoppingcart\Facades\Cart::instance('wishlist')->content() as $item) {
                                                $wishlist[] = $item->model->id;
                                            }
                                        }
                                    @endphp

                                    @if (in_array(@$product->id, $wishlist))
                                        <span class="pd-detail__click-wrap">
                                            <a class="add_to_wishlist" href="javascript:void(0)" data-quantity="1"
                                                data-id="{{ $product->id }}" id="add_to_wishlist_{{ $product->id }}"><i
                                                    class="fa fa-heart u-s-m-r-6">
                                                </i></a>
                                        @else
                                            <span class="pd-detail__click-wrap">
                                                <a class="add_to_wishlist" href="javascript:void(0)" data-quantity="1"
                                                    data-id="{{ $product->id }}"
                                                    id="add_to_wishlist_{{ $product->id }}">Add
                                                    to Wishlist</a>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="u-s-m-b-15">
                                <form class="pd-detail__form">
                                    @csrf
                                    <div class="u-s-m-b-15">
                                        <span class="pd-detail__label u-s-m-b-8">Size:</span>
                                        <div class="pd-detail__size">
                                            @php
                                                $product_attr = \App\Models\ProductAttribute::where('product_id', @$product->id)->get();
                                            @endphp
                                            <input type="hidden" name="product_id" value="{{ @$product->id }}">
                                            <input type="hidden" name="price" value="{{ @$product->offer_price }}">
                                            <div class="size__radio">
                                                <select name="size" class="select-box select-box--primary-style"
                                                    style="width: 8rem;" id="prod_size">
                                                    @foreach ($product_attr as $size)
                                                        <option value="{{ $size->size }}">{{ $size->size }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pd-detail-inline-2">
                                        <div class="u-s-m-b-15">

                                            <!--====== Input Counter ======-->
                                            <div class="input-counter">

                                                <span class="input-counter__minus fas fa-minus"></span>

                                                <input class="input-counter__text input-counter--text-primary-style"
                                                    type="text" id="prod_qty" value="1" data-min="1"
                                                    data-max="1000" name="quantity">

                                                <span class="input-counter__plus fas fa-plus"></span>
                                            </div>
                                            <!--====== End - Input Counter ======-->
                                        </div>
                                        <div class="u-s-m-b-15">

                                            <a class="add_to_cart text-white btn btn--e-brand-b-2"
                                                href="javascript:void(0)" data-quantity="1"
                                                data-product-id="{{ $product->id }}"
                                                id="add_to_cart{{ $product->id }}" data-size="{{ $product->size }}">Add
                                                to Cart</a>
                                            {{-- </button> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="u-s-m-b-15">

                                <span class="pd-detail__label u-s-m-b-8">Product Policy:</span>
                                <ul class="pd-detail__policy-list">
                                    <li><i class="fas fa-check-circle u-s-m-r-8"></i>

                                        <span>Buyer Protection.</span>
                                    </li>
                                    <li><i class="fas fa-check-circle u-s-m-r-8"></i>

                                        <span>Full Refund if you don't receive your order.</span>
                                    </li>
                                    <li><i class="fas fa-check-circle u-s-m-r-8"></i>

                                        <span>Returns accepted if product not as described.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <a class="refer_and_earn text-white btn btn-success" href="javascript:void(0)" data-quantity="1"
                            id="create-referal-link">Refer And Earn</a>
                        <!--====== End - Product Right Side Details ======-->
                    </div>
                    <!-- Popup Modal -->
                    <div id="refer-modal" class="modal">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <form action="{{ route('send.link') }}" method="post" class="refer-form"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="product_id" id="refered_product"
                                    value="{{ @$product->id }}">
                                <input type="hidden" name="refered_by" id="refered_by"
                                    value="{{ auth()->user()->id ?? '' }}">
                                <div class="form-group">
                                    <p><i>❗Note: We will sent a referral link to the given user gmail.</i></p>
                                    <label for="discount-price">Enter user email</label>
                                    <div class="input-group">
                                        <input type="email" id="email" name="email"
                                            placeholder="eg. sandeepkhadka@gmail.com" required>
                                    </div>
                                </div>
                                <button id="send_referral_link" type="submit" class="send_referral_link submit-btn">Send
                                    Link</button>
                            </form>
                        </div>
                    </div>
                    <!-- End Popup Modal -->
                    <div class="col-lg-2">
                        <div class="card w-100 mb-2" style="background-color: rgba(243, 243, 243, 0.5);">
                            <div class="card-body">
                                <h5 class="card-title">Sold By</h5>
                                <span
                                    class="card-text pd-detail__name mb-2">{{ \App\Models\Shop::where('user_id', @$product->vendor_id)->value('shop_name') ?? 'GoodGoods' }}</span>
                                <p class="card-text mb-2"><a href="">View Store</a></p>
                                <form id="my-form"
                                    action="{{ url('http://127.0.0.1:8000/chatify/' . @$product->vendor_id) }}"
                                    method="get" target="_blank">
                                    <input type="hidden" value="{{ @$product->id }}" name="product_id">
                                    <a class="btn btn--e-brand-b-2" href="#"
                                        onclick="if (confirm('Do you want to start a conversation about this product?')) { submitForm(); }">Chat
                                        Now</a>
                                </form>
                            </div>
                        </div>
                        <span class="card-text pd-detail__name mb-2">Similar Product :</span>
                        <div class="card w-100 mb-2">
                            <div class="card-body">
                                @if (file_exists(public_path() . '/uploads/product/' . $product->image))
                                    <a href="{{ route('productDetail', @$product->slug) }}"><img class="u-img-fluid"
                                            src="{{ asset('/uploads/product/Product-2023032904031242_.jpg') }}"
                                            alt="{{ @$product->title }}"></a>
                                @else
                                    <a href="{{ route('productDetail', @$product->slug) }}"><img class="u-img-fluid"
                                            src="{{ @$product->image }}" alt="{{ $product->title }}"></a>
                                @endif
                            </div>
                        </div>
                        <div class="card w-100 mb-2">
                            <div class="card-body">
                                @if (file_exists(public_path() . '/uploads/product/' . $product->image))
                                    <a href="{{ route('productDetail', @$product->slug) }}"><img class="u-img-fluid"
                                            src="{{ asset('/uploads/product/Product-2023032906535336_.jpg') }}"
                                            alt="{{ @$product->title }}"></a>
                                @else
                                    <a href="{{ route('productDetail', @$product->slug) }}"><img class="u-img-fluid"
                                            src="{{ @$product->image }}" alt="{{ $product->title }}"></a>
                                @endif
                            </div>
                        </div>
                        <div class="card w-100 mb-2">
                            <div class="card-body">
                                @if (file_exists(public_path() . '/uploads/product/' . $product->image))
                                    <a href="{{ route('productDetail', @$product->slug) }}"><img class="u-img-fluid"
                                            src="{{ asset('/uploads/product/Product-2023033006272655_.jpg') }}"
                                            alt="{{ @$product->title }}"></a>
                                @else
                                    <a href="{{ route('productDetail', @$product->slug) }}"><img class="u-img-fluid"
                                            src="{{ @$product->image }}" alt="{{ $product->title }}"></a>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!--====== Product Detail Tab ======-->
        <div class="u-s-p-y-90">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pd-tab">
                            <div class="u-s-m-b-30">
                                <ul class="nav pd-tab__list">
                                    <li class="nav-item">

                                        <a class="nav-link" data-toggle="tab" href="#pd-desc">DESCRIPTION</a>
                                    </li>
                                    <li class="nav-item">

                                        <a class="nav-link active" id="view-review" data-toggle="tab"
                                            href="#pd-rev">REVIEWS

                                            <span>({{ \App\Models\ProductReview::where('product_id', @$product->id)->count() }})</span></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">

                                <!--====== Tab 1 ======-->
                                <div class="tab-pane" id="pd-desc">
                                    <div class="pd-tab__desc">
                                        <div class="u-s-m-b-15">
                                            <p>{!! html_entity_decode(@$product->description) !!}</p>
                                        </div>
                                        <div class="u-s-m-b-30"><iframe src="https://www.youtube.com/embed/qKqSBm07KZk"
                                                allowfullscreen></iframe></div>
                                    </div>
                                </div>
                                <!--====== End - Tab 1 ======-->

                                <!--====== Tab 3 ======-->
                                @php
                                    if (auth()->user() != null) {
                                        $valid_customer = \App\Models\Order::select('orders.id', 'orders.condition', 'orders.user_id', 'product_orders.product_id')
                                            ->join('product_orders', 'orders.id', '=', 'product_orders.order_id')
                                            ->where(['product_id' => @$product->id, 'condition' => 'delivered', 'user_id' => auth()->user()->id])
                                            ->value('user_id');
                                    }
                                @endphp
                                <div class="tab-pane fade show active" id="pd-rev">
                                    <div class="pd-tab__rev">
                                        <div class="u-s-m-b-30">
                                            <form class="pd-tab__rev-f1">
                                                <div class="rev-f1__group">
                                                    <div class="u-s-m-b-15">
                                                        <h2>{{ \App\Models\ProductReview::where('product_id', @$product->id)->count() }}
                                                            Review(s) for {{ @$product->title }}</h2>
                                                    </div>
                                                </div>
                                                <div class="rev-f1__review">
                                                    @php
                                                        $reviews = \App\Models\ProductReview::where('product_id', $product->id)
                                                            ->latest()
                                                            ->paginate(8);
                                                    @endphp
                                                    @if (count($reviews) > 0)
                                                        @foreach ($reviews as $review)
                                                            <div class="review-o u-s-m-b-15">
                                                                <div class="review-o__info u-s-m-b-8">

                                                                    <span
                                                                        class="review-o__name">{{ \App\Models\User::where('id', $review->user_id)->value('full_name') }}</span>

                                                                    <span
                                                                        class="review-o__date">{{ \Carbon\Carbon::parse($review->created_at)->format('M d Y h:m:s') }}</span>
                                                                </div>
                                                                <div class="review-o__rating gl-rating-style u-s-m-b-8">
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        @if ($review->rate > $i)
                                                                            <i class="fas fa-star"></i>
                                                                        @else
                                                                            <i class="far fa-star"></i>
                                                                        @endif
                                                                    @endfor
                                                                    <span>({{ $review->rate }})</span> <span
                                                                        class="review-o__date">for
                                                                        {{ $review->reason }}</span>

                                                                </div>
                                                                <p class="review-o__text">{{ $review->review }}</p>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </form>
                                            <div style="margin: auto">
                                                {{ $reviews->links('vendor.pagination.custom_pagination') }}
                                            </div>
                                        </div>
                                        @if (auth()->user() != null)
                                            @if (strval($valid_customer) == auth()->user()->id)
                                                {{-- @auth --}}
                                                <div class="u-s-m-b-30">
                                                    <form method="POST" action="{{ route('predict') }}"
                                                        class="pd-tab__rev-f2">
                                                        @csrf
                                                        @if ($errors->any())
                                                            <div class="alert alert-danger">
                                                                <strong>Oh sorry! </strong>There were some issues with your
                                                                input.<br><br>
                                                                <ul>
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                        <h2 class="u-s-m-b-15">Add a Review</h2>

                                                        <div class="u-s-m-b-30">
                                                            <div class="rev-f2__table-wrap gl-scroll">
                                                                <table class="rev-f2__table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>
                                                                                <div class="gl-rating-style-2"><i
                                                                                        class="fas fa-star"></i>

                                                                                    <span>(1)</span>
                                                                                </div>
                                                                            </th>
                                                                            <th>
                                                                                <div class="gl-rating-style-2"><i
                                                                                        class="fas fa-star"></i><i
                                                                                        class="fas fa-star"></i>

                                                                                    <span>(2)</span>
                                                                                </div>
                                                                            </th>
                                                                            <th>
                                                                                <div class="gl-rating-style-2"><i
                                                                                        class="fas fa-star"></i><i
                                                                                        class="fas fa-star"></i><i
                                                                                        class="fas fa-star"></i>

                                                                                    <span>(3)</span>
                                                                                </div>
                                                                            </th>
                                                                            <th>
                                                                                <div class="gl-rating-style-2"><i
                                                                                        class="fas fa-star"></i><i
                                                                                        class="fas fa-star"></i><i
                                                                                        class="fas fa-star"></i><i
                                                                                        class="fas fa-star"></i>

                                                                                    <span>(4)</span>
                                                                                </div>
                                                                            </th>
                                                                            <th>
                                                                                <div class="gl-rating-style-2"><i
                                                                                        class="fas fa-star"></i><i
                                                                                        class="fas fa-star"></i><i
                                                                                        class="fas fa-star"></i><i
                                                                                        class="fas fa-star"></i><i
                                                                                        class="fas fa-star"></i>

                                                                                    <span>(5)</span>
                                                                                </div>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>

                                                                                <!--====== Radio Box ======-->
                                                                                <div class="radio-box">

                                                                                    <input type="radio" id="star-1"
                                                                                        name="rating" required
                                                                                        value="1">
                                                                                    <div
                                                                                        class="radio-box__state radio-box__state--primary">

                                                                                        <label class="radio-box__label"
                                                                                            for="star-1"></label>
                                                                                    </div>
                                                                                </div>
                                                                                <!--====== End - Radio Box ======-->
                                                                            </td>
                                                                            <td>

                                                                                <!--====== Radio Box ======-->
                                                                                <div class="radio-box">

                                                                                    <input type="radio" id="star-2"
                                                                                        name="rating" required
                                                                                        value="2">
                                                                                    <div
                                                                                        class="radio-box__state radio-box__state--primary">

                                                                                        <label class="radio-box__label"
                                                                                            for="star-2"></label>
                                                                                    </div>
                                                                                </div>
                                                                                <!--====== End - Radio Box ======-->
                                                                            </td>
                                                                            <td>

                                                                                <!--====== Radio Box ======-->
                                                                                <div class="radio-box">

                                                                                    <input type="radio" id="star-3"
                                                                                        name="rating" required
                                                                                        value="3">
                                                                                    <div
                                                                                        class="radio-box__state radio-box__state--primary">

                                                                                        <label class="radio-box__label"
                                                                                            for="star-3"></label>
                                                                                    </div>
                                                                                </div>
                                                                                <!--====== End - Radio Box ======-->
                                                                            </td>
                                                                            <td>

                                                                                <!--====== Radio Box ======-->
                                                                                <div class="radio-box">

                                                                                    <input type="radio" id="star-4"
                                                                                        name="rating" required
                                                                                        value="4">
                                                                                    <div
                                                                                        class="radio-box__state radio-box__state--primary">

                                                                                        <label class="radio-box__label"
                                                                                            for="star-4"></label>
                                                                                    </div>
                                                                                </div>
                                                                                <!--====== End - Radio Box ======-->
                                                                            </td>
                                                                            <td>
                                                                                <!--====== Radio Box ======-->
                                                                                <div class="radio-box">

                                                                                    <input type="radio" id="star-5"
                                                                                        name="rating" required
                                                                                        value="5">
                                                                                    <div
                                                                                        class="radio-box__state radio-box__state--primary">

                                                                                        <label class="radio-box__label"
                                                                                            for="star-5"></label>
                                                                                    </div>
                                                                                </div>
                                                                                <!--====== End - Radio Box ======-->
                                                                            </td>
                                                                            @error('rate')
                                                                                <span class="invalid-feedback"
                                                                                    role="alert">{{ $message }}</span>
                                                                            @enderror
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="rev-f2__group">
                                                            <div class="u-s-m-b-15">

                                                                <label class="gl-label" for="reviewer-text">YOUR
                                                                    REVIEW</label>
                                                                <textarea class="text-area text-area--primary-style" id="reviewer-text" name="text_"></textarea>
                                                                @error('review')
                                                                    <span class="invalid-feedback"
                                                                        role="alert">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div>
                                                                <p class="u-s-m-b-30">

                                                                    <label class="gl-label"
                                                                        for="reviewer-name">REASON</label>

                                                                    <select name="reason"
                                                                        class="select-box select-box--primary-style"
                                                                        style="width: 25rem;">
                                                                        <option value="quality"
                                                                            {{ old('reason') == 'quality' ? 'selected' : '' }}>
                                                                            Quality
                                                                        </option>
                                                                        <option value="design"
                                                                            {{ old('reason') == 'design' ? 'selected' : '' }}>
                                                                            Design
                                                                        </option>
                                                                        <option value="value"
                                                                            {{ old('reason') == 'value' ? 'selected' : '' }}>
                                                                            Value
                                                                        </option>
                                                                        <option value="price"
                                                                            {{ old('reason') == 'price' ? 'selected' : '' }}>
                                                                            Price
                                                                        </option>
                                                                        <option value="others"
                                                                            {{ old('reason') == 'others' ? 'selected' : '' }}>
                                                                            Others</option>
                                                                    </select>
                                                                    @error('reason')
                                                                        <span class="invalid-feedback"
                                                                            role="alert">{{ $message }}</span>
                                                                    @enderror
                                                                </p>

                                                                <input type="hidden" name="user_id"
                                                                    value="{{ auth()->user()->id }}">
                                                                <input type="hidden" name="product_id"
                                                                    value="{{ @$product->id }}">
                                                                <input type="hidden" id="category"
                                                                    value={{ \App\Models\Category::where('id', @$product->cat_id)->value('title') }}
                                                                    name="category" />
                                                            </div>
                                                        </div>
                                                        <div>

                                                            <button class="btn btn--e-brand-shadow"
                                                                type="submit">SUBMIT</button>
                                                        </div>

                                                    </form>
                                                </div>

                                            @endif
                                        @else
                                            <p class="py-3">Login to post a review. <a
                                                    href="{{ route('login') }}">Click Here!</a> to login</p>
                                        @endif
                                    </div>
                                    <!--====== End - Tab 3 ======-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - App Content ======-->
    @endsection
    @section('scripts')

        <!--====== Vendor Js ======-->
        <script src="{{ asset('assets/shop/js/vendor.js') }}"></script>

        <!--====== jQuery Shopnav plugin ======-->
        <script src="{{ asset('assets/shop/js/jquery.shopnav.js') }}"></script>

        <!--====== App ======-->
        <script src="{{ asset('assets/shop/js/app.js') }}"></script>

        {{-- Add to wishlist --}}
        <script>
            $(document).on('click', '.add_to_wishlist', function(e) {
                e.preventDefault();
                var product_id = $(this).data('id');
                var product_qty = $(this).data('quantity');
                // alert(product_id);

                var token = "{{ csrf_token() }}";
                var path = "{{ route('wishlist.store') }}";

                $.ajax({
                    url: path,
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        product_id: product_id,
                        product_qty: product_qty,
                        _token: token,
                    },
                    beforeSend: function() {
                        $('#add_to_wishlist_' + product_id).html(
                            '<i class ="fas fa-spinner fa-spin">..</i>');
                    },
                    complete: function() {
                        $('#add_to_wishlist_' + product_id).html('<i class="fa fa-heart u-s-m-r-6">');
                    },
                    success: function(data) {
                        console.log(data);
                        if (data['status']) {
                            $('body #header-ajax').html(data['header'])
                            $('body #wishlist_counter').html(data['wishlist_count'])
                            Swal.fire({
                                icon: 'success',
                                title: 'Great',
                                text: data['message'],
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (data['present']) {
                            $('body #header-ajax').html(data['header'])
                            $('body #wishlist_counter').html(data['wishlist_count'])
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops',
                                text: data['message'],
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Sorry',
                                text: "You cannot add that product",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
        </script>

        {{-- Add to cart --}}
        <script>
            $(document).on('click', '.add_to_cart', function(e) {
                e.preventDefault();
                const product_qty = document.getElementById("prod_qty");
                const product_size = document.getElementById("prod_size");
                var product_id = $(this).data('product-id');

                var token = "{{ csrf_token() }}";
                var path = "{{ route('cart.store') }}";

                $.ajax({
                    url: path,
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        product_id: product_id,
                        product_qty: product_qty.value,
                        product_size: product_size.value,
                        _token: token,
                    },
                    beforeSend: function() {
                        $('#add_to_cart' + product_id).html('<i class ="fas fa-spinner fa-spin">..</i>');
                    },
                    complete: function() {
                        $('#add_to_cart' + product_id).html('Add to cart');
                    },
                    success: function(data) {
                        console.log(data);
                        $('body #header-ajax').html(data['header'])
                        if (data['status']) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Great',
                                text: data['message'],
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
        </script>
        <script>
            function submitForm() {
                document.getElementById("my-form").submit();
            }
        </script>
        <script>
            // Get the modal
            var modal = document.getElementById("refer-modal");

            // Get the button that opens the modal
            var btn = document.getElementById("create-referal-link");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal
            btn.onclick = function() {
                modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
        <script>
            $(document).on('click', '.send_referral_link', function(e) {
                e.preventDefault();

                var path = "{{ route('send.link') }}";
                var token = "{{ csrf_token() }}";

                $.ajax({
                    url: path,
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        product_id: $('#refered_product').val(),
                        refered_by: $('#refered_by').val(),
                        email: $('#email').val(),
                        _token: token,
                    },
                    beforeSend: function() {
                        $('#send_referral_link').html('<i class ="fas fa-spinner fa-spin">..</i>');
                    },
                    complete: function() {
                        $('#send_referral_link').html('Send Link');
                    },
                    success: function(data) {
                        console.log(data);
                        // $('body #header-ajax').html(data['header'])
                        if (data['status']) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Great',
                                text: data['message'],
                                showConfirmButton: true,
                                timer: 1500
                            })
                        }
                    },
                    error: function(err) {
                        console.log(err);
                        Swal.fire({
                                icon: 'error',
                                title: 'Oops',
                                text: 'Please Login First',
                                showConfirmButton: true,
                                timer: 1500
                            })
                    }
                });
            });
        </script>

    @endsection
