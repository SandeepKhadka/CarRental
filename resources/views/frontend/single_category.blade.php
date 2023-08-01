@extends('frontend.layouts.master')
@section('title', 'GoodGoods - Category Shopping')

@section('banner')
    <!-- Page Banner -->
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

@section('main-content')
    <!-- Shop-Page -->
    <div class="page-shop u-s-p-t-80">
        <div class="container">
            <!-- Shop-Intro -->
            <div class="shop-intro">
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <a href="{{ route('front.home') }}">Home</a>
                    </li>
                    <li class="has-separator">
                        @php
                            $parent_cat = App\Models\Category::where('id', @$parent_category)->value('slug');
                        @endphp
                        <a
                            href="{{ route('shop', $parent_cat) }}">{{ ucfirst(\App\Models\Category::where('id', @$parent_category)->value('title')) }}</a>
                    </li>
                    <li class="is-marked">
                        <a>{{ ucfirst(\App\Models\Apparel::where('id', @$sub_category)->value('title')) }}</a>
                    </li>
                </ul>
            </div>
            <!-- Shop-Intro /- -->
            <form action="{{ route('shop.filter') }}" method="post">
                @csrf
                <div class="row">
                    <input type="hidden" name="slug" value="{{ @$slug }}">
                    <!-- Shop-Left-Side-Bar-Wrapper -->
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="facet-form">
                            <!-- Filters -->
                            <!-- Filter-Size -->
                            <div class="facet-filter-associates">
                                <h3 class="title-name">Size</h3>
                                {{-- <form class="facet-form" action="#" method="post"> --}}
                                <div class="associate-wrapper">
                                    <input type="checkbox" {{ \Request::get('size') == 'S' ? 'checked' : '' }}
                                        class="check-box size-check-box" id="small" name="size" value="S"
                                        onchange="this.form.submit();">
                                    <label class="label-text" for="small">Small
                                        <span
                                            class="total-fetch-items">({{ \App\Models\Product::where(['size' => 'S', 'cat_id' => @$parent_category, 'status' => 'active'])->count() }})</span>
                                    </label>
                                    <input type="checkbox" {{ \Request::get('size') == 'M' ? 'checked' : '' }}
                                        class="check-box size-check-box" id="medium" name="size" value="M"
                                        onchange="this.form.submit();">
                                    <label class="label-text" for="medium">Medium
                                        <span
                                            class="total-fetch-items">({{ \App\Models\Product::where(['size' => 'M', 'cat_id' => @$parent_category, 'status' => 'active'])->count() }})</span>
                                    </label>
                                    <input type="checkbox" {{ \Request::get('size') == 'L' ? 'checked' : '' }}
                                        class="check-box size-check-box" id="large" name="size" value="L"
                                        onchange="this.form.submit();">
                                    <label class="label-text" for="large">Large
                                        <span
                                            class="total-fetch-items">({{ \App\Models\Product::where(['size' => 'L', 'cat_id' => @$parent_category, 'status' => 'active'])->count() }})</span>
                                    </label>
                                    <input type="checkbox" {{ \Request::get('size') == 'XL' ? 'checked' : '' }}
                                        class="check-box size-check-box" id="extra_large" name="size" value="XL"
                                        onchange="this.form.submit();">
                                    <label class="label-text" for="extra_large">Extra Large
                                        <span
                                            class="total-fetch-items">({{ \App\Models\Product::where(['size' => 'XL', 'cat_id' => @$parent_category, 'status' => 'active'])->count() }})</span>
                                    </label>
                                </div>
                                {{-- </form> --}}
                            </div>
                            <!-- Filter-Price -->
                            <div class="facet-filter-by-price">
                                <h3 class="title-name">Price (in Rs)</h3>
                                {{-- @csrf --}}
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
                            <!-- Filter-Size -->
                            <!-- Filter-Color -->
                            <div class="facet-filter-associates">
                                <h3 class="title-name">Color</h3>
                                <div class="associate-wrapper">
                                    <input type="checkbox" class="check-box" id="cbs-16">
                                    <label class="label-text" for="cbs-16">Heather Grey
                                        <span class="total-fetch-items">(1)</span>
                                    </label>
                                    <input type="checkbox" class="check-box" id="cbs-17">
                                    <label class="label-text" for="cbs-17">Black
                                        <span class="total-fetch-items">(1)</span>
                                    </label>
                                    <input type="checkbox" class="check-box" id="cbs-18">
                                    <label class="label-text" for="cbs-18">White
                                        <span class="total-fetch-items">(3)</span>
                                    </label>
                                    <input type="checkbox" class="check-box" id="cbs-19">
                                    <label class="label-text" for="cbs-19">Mischka Plain
                                        <span class="total-fetch-items">(1)</span>
                                    </label>
                                    <input type="checkbox" class="check-box" id="cbs-20">
                                    <label class="label-text" for="cbs-20">Black Bean
                                        <span class="total-fetch-items">(1)</span>
                                    </label>
                                </div>
                            </div>
                            <!-- Filter-Color /- -->
                            <!-- Filter-Brand -->
                            <div class="facet-filter-associates">
                                <h3 class="title-name">Brand</h3>
                                @if (isset($brands) && count($brands) > 0)
                                    <div class="associate-wrapper">
                                        @if (!empty($_GET['brand']))
                                            @php
                                                $filter_brands = explode(',', $_GET['brand']);
                                            @endphp
                                        @endif
                                        @foreach ($brands as $brand => $item)
                                            <input type="checkbox" @if (!empty($filter_brands) && in_array($item['slug'], $filter_brands)) checked @endif
                                                class="check-box" id="{{ $item['slug'] }}" name="brand[]"
                                                value="{{ $item['slug'] }}" onchange="this.form.submit();">
                                            <label class="label-text" for="{{ $item['slug'] }}">{{ $item['title'] }}
                                                <span
                                                    class="total-fetch-items">({{ \App\Models\Product::where(['brand_id' => $item['id'], 'cat_id' => @$parent_category, 'status' => 'active'])->count() }})</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <!-- Filter-Brand /- -->
                            <!-- Filter-Rating -->
                            <div class="facet-filter-by-rating">
                                <h3 class="title-name">Rating</h3>
                                <div class="facet-form">
                                    <!-- 5 Stars -->
                                    <div class="facet-link">
                                        <div class="item-stars">
                                            <div class='star'>
                                                <span style='width:76px'></span>
                                            </div>
                                        </div>
                                        <span class="total-fetch-items">(0)</span>
                                    </div>
                                    <!-- 5 Stars /- -->
                                    <!-- 4 & Up Stars -->
                                    <div class="facet-link">
                                        <div class="item-stars">
                                            <div class='star'>
                                                <span style='width:60px'></span>
                                            </div>
                                        </div>
                                        <span class="total-fetch-items">& Up (5)</span>
                                    </div>
                                    <!-- 4 & Up Stars /- -->
                                    <!-- 3 & Up Stars -->
                                    <div class="facet-link">
                                        <div class="item-stars">
                                            <div class='star'>
                                                <span style='width:45px'></span>
                                            </div>
                                        </div>
                                        <span class="total-fetch-items">& Up (0)</span>
                                    </div>
                                    <!-- 3 & Up Stars /- -->
                                    <!-- 2 & Up Stars -->
                                    <div class="facet-link">
                                        <div class="item-stars">
                                            <div class='star'>
                                                <span style='width:30px'></span>
                                            </div>
                                        </div>
                                        <span class="total-fetch-items">& Up (0)</span>
                                    </div>
                                    <!-- 2 & Up Stars /- -->
                                    <!-- 1 & Up Stars -->
                                    <div class="facet-link">
                                        <div class="item-stars">
                                            <div class='star'>
                                                <span style='width:15px'></span>
                                            </div>
                                        </div>
                                        <span class="total-fetch-items">& Up (0)</span>
                                    </div>
                                    <!-- 1 & Up Stars /- -->
                                </div>
                            </div>
                            <!-- Filter-Rating -->
                            <!-- Filters /- -->
                        </div>
                    </div>
                    <!-- Shop-Left-Side-Bar-Wrapper /- -->
                    <!-- Shop-Right-Wrapper -->
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <!-- Page-Bar -->
                        <div class="page-bar clearfix">
                            <div class="shop-settings">
                                <a id="grid-anchor" class="active">
                                    <i class="fas fa-th"></i>
                                </a>
                                <a id="list-anchor">
                                    <i class="fas fa-th-list"></i>
                                </a>
                            </div>
                            <!-- Toolbar Sorter 1  -->
                            <div class="toolbar-sorter">
                                <div class="select-box-wrapper">
                                    <label class="sr-only" for="sortBy">Sort By</label>
                                    <select class="select-box" id="sortBy" name="sortBy"
                                        onchange="this.form.submit()">
                                        <option selected="selected" value="">Sort By: Latest</option>
                                        <option {{ \Request::get('sortBy') == 'priceAsc' ? 'selected' : '' }}
                                            value="priceAsc">
                                            Sort By: Lowest Price</option>
                                        <option {{ \Request::get('sortBy') == 'priceDesc' ? 'selected' : '' }}
                                            value="priceDesc">
                                            Sort By: Highest Price</option>
                                        <option {{ \Request::get('sortBy') == 'highRating' ? 'selected' : '' }}
                                            value="highRating">Sort By: Best Rating</option>
                                        <option {{ \Request::get('sortBy') == 'discAsc' ? 'selected' : '' }}
                                            value="discAsc">
                                            Sort By: Low Discount</option>
                                        <option {{ \Request::get('sortBy') == 'discDesc' ? 'selected' : '' }}
                                            value="discDesc">
                                            Sort By: High Discount</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row product-container grid-style" id="product-data">
                            @include('frontend.layouts._single_product')
                        </div>
                        <div class="ajax-load text-center" style="display: none">
                            <img src="{{ asset('frontend/images/loader.gif') }}" style="width: 10%">
                        </div>
                        <!-- Row-of-Product-Container /- -->
                    </div>
                    <!-- Shop-Right-Wrapper /- -->
                </div>
            </form>
        </div>
    </div>
    <br>
    <!-- Shop-Page /- -->
@endsection
@section('scripts')
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
                    priceInput[1].value = maxVal;
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
                    // setTimeout(function() {
                    //     location.reload();
                    // }, 1500);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
    </script>
@endsection
