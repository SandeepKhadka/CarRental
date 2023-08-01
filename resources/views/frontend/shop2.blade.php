@extends('frontend.layouts.master')
@section('title', 'GoodGoods - Category Shopping')

@section('banner')
    <div class="cmt-page-title-row bg-base-dark cmt-bg cmt-bgimage-yes clearfix">
        <div class="cmt-titlebar-wrapper-bg-layer cmt-bg-layer"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="cmt-page-title-row-inner">
                        <div class="page-title-heading">
                            <h2 class="title" style="color: white">Shop</h2>
                        </div>
                        <div class="breadcrumb-wrapper">
                            <span>
                                <a title="Homepage" href="{{ route('front.home') }}">Home</a>
                            </span>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Banner -->
@endsection
@section('styles')
    <!--====== Vendor Css ======-->
    <link rel="stylesheet" href="{{ asset('assets/shop/css/vendor.css') }}">

    <!--====== Utility-Spacing ======-->
    <link rel="stylesheet" href="{{ asset('assets/shop/css/utility.css') }}">

    <!--====== App ======-->
    <link rel="stylesheet" href="{{ asset('assets/shop/css/app.css') }}">
@endsection
@section('main-content')
    <!--====== App Content ======-->
    <div class="app-content">
        <!--====== Section 1 ======-->
        <div class="u-s-p-y-90">
            <div class="container">
                <form action="{{ route('shop.filter') }}" method="post">
                    @csrf
                    <input type="hidden" name="slug" value="{{ @$slug }}">
                    <div class="row">
                        <div class="col-lg-3 col-md-12">
                            <div class="shop-w-master">
                                <h1 class="shop-w-master__heading u-s-m-b-30"><i class="fas fa-filter u-s-m-r-8"></i>

                                    <span>FILTERS</span>
                                </h1>
                                <div class="shop-w-master__sidebar">
                                    <div class="u-s-m-b-30">
                                        <div class="shop-w shop-w--style">
                                            <div class="shop-w__intro-wrap">
                                                <h1 class="shop-w__h">SIZE</h1>

                                                <span class="fas fa-minus collapsed shop-w__toggle" data-target="#s-size"
                                                    data-toggle="collapse"></span>
                                            </div>
                                            <div class="shop-w__wrap collapse" id="s-size">
                                                <ul class="shop-w__list gl-scroll">
                                                    <li>

                                                        <!--====== Check Box ======-->
                                                        <div class="check-box">

                                                            <input type="checkbox" id="small"
                                                                {{ \Request::get('size') == 'S' ? 'checked' : '' }}
                                                                name="size" value="S" onchange="this.form.submit();"
                                                                class="check-box size-check-box">
                                                            <div class="check-box__state check-box__state--primary">

                                                                <label class="check-box__label" for="small">Small</label>
                                                            </div>
                                                        </div>
                                                        <!--====== End - Check Box ======-->

                                                        <span
                                                            class="shop-w__total-text">({{ \App\Models\Product::where(['size' => 'S', 'cat_id' => @$parent_category, 'status' => 'active'])->count() }})</span>
                                                    </li>
                                                    <li>

                                                        <!--====== Check Box ======-->
                                                        <div class="check-box">

                                                            <input type="checkbox"
                                                                {{ \Request::get('size') == 'M' ? 'checked' : '' }}
                                                                class="check-box size-check-box" id="medium"
                                                                name="size" value="M"
                                                                onchange="this.form.submit();">
                                                            <div class="check-box__state check-box__state--primary">

                                                                <label class="check-box__label"
                                                                    for="medium">Medium</label>
                                                            </div>
                                                        </div>
                                                        <!--====== End - Check Box ======-->

                                                        <span
                                                            class="shop-w__total-text">({{ \App\Models\Product::where(['size' => 'M', 'cat_id' => @$parent_category, 'status' => 'active'])->count() }})</span>
                                                    </li>
                                                    <li>

                                                        <!--====== Check Box ======-->
                                                        <div class="check-box">

                                                            <input type="checkbox"
                                                                {{ \Request::get('size') == 'L' ? 'checked' : '' }}
                                                                class="check-box size-check-box" id="large"
                                                                name="size" value="L"
                                                                onchange="this.form.submit();">
                                                            <div class="check-box__state check-box__state--primary">

                                                                <label class="check-box__label" for="large">Large</label>
                                                            </div>
                                                        </div>
                                                        <!--====== End - Check Box ======-->

                                                        <span
                                                            class="shop-w__total-text">({{ \App\Models\Product::where(['size' => 'L', 'cat_id' => @$parent_category, 'status' => 'active'])->count() }})</span>
                                                    </li>
                                                    <li>

                                                        <!--====== Check Box ======-->
                                                        <div class="check-box">

                                                            <input type="checkbox"
                                                                {{ \Request::get('size') == 'XL' ? 'checked' : '' }}
                                                                class="check-box size-check-box" id="extra_large"
                                                                name="size" value="XL"
                                                                onchange="this.form.submit();">
                                                            <div class="check-box__state check-box__state--primary">

                                                                <label class="check-box__label" for="extra_large">Extra
                                                                    Large</label>
                                                            </div>
                                                        </div>
                                                        <!--====== End - Check Box ======-->

                                                        <span
                                                            class="shop-w__total-text">({{ \App\Models\Product::where(['size' => 'XL', 'cat_id' => @$parent_category, 'status' => 'active'])->count() }})</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="u-s-m-b-30">
                                        <div class="shop-w shop-w--style">
                                            <div class="shop-w__intro-wrap">
                                                <h1 class="shop-w__h">SHIPPING</h1>

                                                <span class="fas fa-minus shop-w__toggle" data-target="#s-shipping"
                                                    data-toggle="collapse"></span>
                                            </div>
                                            <div class="shop-w__wrap collapse show" id="s-shipping">
                                                <ul class="shop-w__list gl-scroll">
                                                    <li>

                                                        <!--====== Check Box ======-->
                                                        <div class="check-box">

                                                            <input type="checkbox" id="free-shipping">
                                                            <div class="check-box__state check-box__state--primary">

                                                                <label class="check-box__label" for="free-shipping">Free
                                                                    Shipping</label>
                                                            </div>
                                                        </div>
                                                        <!--====== End - Check Box ======-->
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="u-s-m-b-30">
                                        <div class="shop-w shop-w--style">
                                            <div class="shop-w__intro-wrap">
                                                <h1 class="shop-w__h">PRICE (in Rs)</h1>

                                                <span class="fas fa-minus shop-w__toggle" data-target="#s-price"
                                                    data-toggle="collapse"></span>
                                            </div>
                                            <div class="shop-w__wrap collapse show" id="s-price">

                                                <div class="price-input">
                                                    <div class="field">
                                                        <span>Min</span>
                                                        <input type="number" class="input-min" name="min_price"
                                                            value="{{ \Request::get('min_price') != null ? \Request::get('min_price') : minPrice() }}">
                                                    </div>
                                                    <div class="separator">-</div>
                                                    <div class="field">
                                                        <span>Max</span>
                                                        <input type="number" class="input-max" name="max_price"
                                                            value="{{ \Request::get('max_price') != null ? \Request::get('max_price') : maxPrice() }}">
                                                    </div>
                                                </div>
                                                <div class="price-slider">
                                                    <div class="progress"></div>
                                                </div>
                                                <div class="range-input">
                                                    <input type="range" class="range-min" min="{{ minPrice() }}"
                                                        max="{{ maxPrice() }}"
                                                        value="{{ \Request::get('min_price') != null ? \Request::get('min_price') : minPrice() }}"
                                                        step="10">
                                                    <input type="range" class="range-max" min="{{ minPrice() }}"
                                                        max="{{ maxPrice() }}"
                                                        value="{{ \Request::get('max_price') != null ? \Request::get('max_price') : maxPrice() }}"
                                                        step="10">
                                                </div>
                                                <button type="submit" class="button button-primary"
                                                    style="margin-top: 20px">Filter</button>
                                            </div>
                                            <!-- Filter-Price /- -->
                                        </div>
                                    </div>
                                    <div class="u-s-m-b-30">
                                        <div class="shop-w shop-w--style">
                                            <div class="shop-w__intro-wrap">
                                                <h1 class="shop-w__h">BRAND</h1>

                                                <span class="fas fa-minus shop-w__toggle" data-target="#s-manufacturer"
                                                    data-toggle="collapse"></span>
                                            </div>
                                            @if (isset($brands) && count($brands) > 0)
                                                <div class="shop-w__wrap collapse show" id="s-manufacturer">
                                                    @if (!empty($_GET['brand']))
                                                        @php
                                                            $filter_brands = explode(',', $_GET['brand']);
                                                        @endphp
                                                    @endif
                                                    <ul class="shop-w__list-2">
                                                        @foreach ($brands as $brand => $item)
                                                            <li>
                                                                <div class="list__content">

                                                                    <input type="checkbox"
                                                                        @if (!empty($filter_brands) && in_array($item['slug'], $filter_brands)) checked @endif
                                                                        class="check-box" id="{{ $item['slug'] }}"
                                                                        name="brand[]" value="{{ $item['slug'] }}"
                                                                        onchange="this.form.submit();">

                                                                    <span>{{ $item['title'] }}</span>
                                                                </div>

                                                                <span
                                                                    class="shop-w__total-text">({{ \App\Models\Product::where(['brand_id' => $item['id'], 'cat_id' => @$parent_category, 'status' => 'active'])->count() }})</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="u-s-m-b-30">
                                        <div class="shop-w shop-w--style">
                                            <div class="shop-w__intro-wrap">
                                                <h1 class="shop-w__h">RATING</h1>

                                                <span class="fas fa-minus shop-w__toggle" data-target="#s-rating"
                                                    data-toggle="collapse"></span>
                                            </div>
                                            <div class="shop-w__wrap collapse show" id="s-rating">
                                                <ul class="shop-w__list gl-scroll">
                                                    <li>
                                                        <div class="rating__check">

                                                            <input type="checkbox">
                                                            <div class="rating__check-star-wrap"><i
                                                                    class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                                    class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                                    class="fas fa-star"></i></div>
                                                        </div>

                                                        <span class="shop-w__total-text">(2)</span>
                                                    </li>
                                                    <li>
                                                        <div class="rating__check">

                                                            <input type="checkbox">
                                                            <div class="rating__check-star-wrap"><i
                                                                    class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                                    class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                                    class="far fa-star"></i>

                                                                <span>& Up</span>
                                                            </div>
                                                        </div>

                                                        <span class="shop-w__total-text">(8)</span>
                                                    </li>
                                                    <li>
                                                        <div class="rating__check">

                                                            <input type="checkbox">
                                                            <div class="rating__check-star-wrap"><i
                                                                    class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                                    class="fas fa-star"></i><i class="far fa-star"></i><i
                                                                    class="far fa-star"></i>

                                                                <span>& Up</span>
                                                            </div>
                                                        </div>

                                                        <span class="shop-w__total-text">(10)</span>
                                                    </li>
                                                    <li>
                                                        <div class="rating__check">

                                                            <input type="checkbox">
                                                            <div class="rating__check-star-wrap"><i
                                                                    class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                                    class="far fa-star"></i><i class="far fa-star"></i><i
                                                                    class="far fa-star"></i>

                                                                <span>& Up</span>
                                                            </div>
                                                        </div>

                                                        <span class="shop-w__total-text">(12)</span>
                                                    </li>
                                                    <li>
                                                        <div class="rating__check">

                                                            <input type="checkbox">
                                                            <div class="rating__check-star-wrap"><i
                                                                    class="fas fa-star"></i><i class="far fa-star"></i><i
                                                                    class="far fa-star"></i><i class="far fa-star"></i><i
                                                                    class="far fa-star"></i>

                                                                <span>& Up</span>
                                                            </div>
                                                        </div>

                                                        <span class="shop-w__total-text">(1)</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-12">
                            <div class="shop-p">
                                <div class="shop-p__toolbar u-s-m-b-30">
                                    <div class="shop-p__meta-wrap u-s-m-b-60">

                                        <span class="shop-p__meta-text-1">FOUND {{$category_products->count()}} RESULTS</span>
                                        <div class="shop-p__meta-text-2">

                                            <span>Related Searches:</span>

                                            <a class="gl-tag btn--e-brand-shadow" href="#">men's clothing</a>

                                            <a class="gl-tag btn--e-brand-shadow" href="#">mobiles & tablets</a>

                                            <a class="gl-tag btn--e-brand-shadow" href="#">books & audible</a>
                                        </div>
                                    </div>
                                    <div class="shop-p__tool-style">
                                        <div class="tool-style__group u-s-m-b-8">

                                            <span id="grid-anchor" class="js-shop-grid-target is-active">Grid</span>

                                            <span id="list-anchor" class="js-shop-list-target">List</span>
                                        </div>
                                        <form>
                                            <div class="tool-style__form-wrap">
                                                {{-- <div class="u-s-m-b-8"><select
                                                        class="select-box select-box--transparent-b-2">
                                                        <option>Show: 8</option>
                                                        <option selected>Show: 12</option>
                                                        <option>Show: 16</option>
                                                        <option>Show: 28</option>
                                                    </select></div> --}}
                                                <div class="u-s-m-b-8">
                                                    <select class="select-box select-box--transparent-b-2" name="sortBy"
                                                        onchange="this.form.submit()">
                                                        <option selected="selected" value="">Sort By: Latest
                                                        </option>
                                                        <option
                                                            {{ \Request::get('sortBy') == 'priceAsc' ? 'selected' : '' }}
                                                            value="priceAsc">
                                                            Sort By: Lowest Price</option>
                                                        <option
                                                            {{ \Request::get('sortBy') == 'priceDesc' ? 'selected' : '' }}
                                                            value="priceDesc">
                                                            Sort By: Highest Price</option>
                                                        <option
                                                            {{ \Request::get('sortBy') == 'highRating' ? 'selected' : '' }}
                                                            value="highRating">Sort By: Best Rating</option>
                                                        <option
                                                            {{ \Request::get('sortBy') == 'discAsc' ? 'selected' : '' }}
                                                            value="discAsc">
                                                            Sort By: Low Discount</option>
                                                        <option
                                                            {{ \Request::get('sortBy') == 'discDesc' ? 'selected' : '' }}
                                                            value="discDesc">
                                                            Sort By: High Discount</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Row-of-Product-Container -->
                                <div class="row product-container grid-style" id="product-data">
                                    @include('frontend.layouts._single_product')
                                </div>
                                <div class="ajax-load text-center" style="display: none">
                                    <img src="{{ asset('frontend/images/loader.gif') }}" style="width: 10%">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--====== End - Section 1 ======-->
    </div>
    <!--====== End - App Content ======-->
@endsection

@section('scripts')
    <!--====== Google Analytics: change UA-XXXXX-Y to be your site's ID ======-->
    <script>
        window.ga = function() {
            ga.q.push(arguments)
        };
        ga.q = [];
        ga.l = +new Date;
        ga('create', 'UA-XXXXX-Y', 'auto');
        ga('send', 'pageview')
    </script>
    <script src="https://www.google-analytics.com/analytics.js" async defer></script>
    <link src="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <!--====== Vendor Js ======-->
    <script src="{{ asset('assets/shop/js/vendor.js') }}"></script>

    <!--====== jQuery Shopnav plugin ======-->
    <script src="{{ asset('assets/shop/js/jquery.shopnav.js') }}"></script>

    <!--====== App ======-->
    <script src="{{ asset('assets/shop/js/app.js') }}"></script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Price Filter

        const rangeInput = document.querySelectorAll(".range-input input"),
            priceInput = document.querySelectorAll(".price-input input"),
            progress = document.querySelector(".price-slider .progress");

        let priceGap = 100;

        priceInput.forEach(input => {
            input.addEventListener("input", e => {
                // getting two ranges value and parsing them to number
                let minVal = parseInt(priceInput[0].value),
                    maxVal = parseInt(priceInput[1].value);

                if ((maxVal - minVal >= priceGap) && maxVal <= {{ maxPrice() }}) {
                    if (e.target.className === "input-min") {
                        rangeInput[0].value = minVal;
                        progress.style.left = (minVal / rangeInput[0].max) * 10 + "%";
                    } else {
                        rangeInput[1].value = maxVal;
                        progress.style.right = 10 - (maxVal / rangeInput[1].max) * 10 + "%";
                    }
                }
            });

        });

        rangeInput.forEach(input => {
            input.addEventListener("input", e => {
                // getting two ranges value and parsing them to number
                let minVal = parseInt(rangeInput[0].value),
                    maxVal = parseInt(rangeInput[1].value);

                if (maxVal - minVal < priceGap) {
                    if (e.target.className === "range-min") {
                        rangeInput[0].value = maxVal - priceGap;
                    } else {
                        rangeInput[1].value = minVal + priceGap;
                    }
                } else {
                    priceInput[0].value = minVal;
                    priceInput[1].value = maxVal + 8;
                    progress.style.left = (minVal / rangeInput[0].max) * 100 + "%";
                    progress.style.right = (maxVal / rangeInput[1].max) * 100 + "%";
                }
            });

        });
    </script>

    <script>
        $(function() {
            $('.size-check-box').bind('click', function() {
                $('.size-check-box').not(this).prop("checked", false);
            });
        });
    </script>
    <script>
        function loadmoreData(page) {
            $.ajax({
                    url: '?page=' + page,
                    type: 'get',
                    beforeSend: function() {
                        $('.ajax-load').show();
                    },
                })
                .done(function(data) {
                    if (data.html == '') {
                        $('.ajax-load').html('No more products available');
                        return;
                    }
                    $('.ajax-load').hide();
                    $('#product-data').append(data.html);
                })
                .fail(function() {
                    alert('Something went wrong!! Please try again.')
                });
        }

        var page = 1;
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() + 120 >= $(document).height()) {
                page++;
                loadmoreData(page);
            }
        })
    </script>

    {{-- Add to cart --}}
    <script>
        $(document).on('click', '.add_to_cart', function(e) {
            e.preventDefault();
            var product_id = $(this).data('product-id');
            var product_qty = $(this).data('quantity');
            var product_size = $(this).data('size');
            // alert(product_id);

            var token = "{{ csrf_token() }}";
            var path = "{{ route('cart.store') }}";

            $.ajax({
                url: path,
                type: "POST",
                dataType: "JSON",
                data: {
                    product_id: product_id,
                    product_qty: product_qty,
                    product_size: product_size,
                    _token: token,
                },
                beforeSend: function() {
                    $('#add_to_cart' + product_id).html('<i class ="fas fa-spinner fa-spin">..</i>');
                },
                complete: function() {
                    $('#add_to_cart' + product_id).html('<i class ="fas fa-cart-plus"></i>');
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
                    $('#add_to_wishlist_' + product_id).html('<i class =""></i>');
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
@endsection
