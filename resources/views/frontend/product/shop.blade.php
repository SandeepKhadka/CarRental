@extends('frontend.layouts.master')
@section('title', 'GoodGoods - Shop')

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
    <!-- Banner /- -->
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
                    <li class="is-marked">
                        <a>{{ \App\Models\Category::where('slug', $slug)->value('title') }}</a>
                    </li>
                </ul>
            </div>
            <!-- Shop-Intro /- -->
            <div class="row">
                <!-- Shop-Left-Side-Bar-Wrapper -->
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <!-- Fetch-Categories-from-Root-Category  -->
                    <div class="fetch-categories">
                        @php
                            $apparel_lists = [];
                            $apparels_child = [];
                            $total_products = 0;
                        @endphp
                        <h3 class="title-name">Browse Categories</h3>
                        <!-- Level-2 -->
                        @if (isset($child_categories) && count($child_categories) > 0)
                            @foreach ($child_categories as $child_category)
                                @php
                                    $apparel = \App\Models\Apparel::where('id', $child_category->apparel)->value('title');
                                    $apparel_total = \App\Models\Category::where(['parent_id' => @$parent_category, 'status' => 'active', 'apparel' => $child_category->apparel])->value('id');
                                @endphp
                                <h3 class="fetch-mark-category">
                                    @if (!in_array($apparel, $apparel_lists))
                                        <a>{{ $apparel }}</a>
                                        @php
                                            $apparel_lists[] = $apparel;
                                        @endphp
                                    @endif
                                </h3>
                                <!-- Level-2 /- -->
                                <ul>
                                    @foreach ($child_categories as $child_cat)
                                        @php
                                            $child_apparel = \App\Models\Apparel::where('id', $child_cat->apparel)->value('title');
                                        @endphp
                                        @if ($apparel == $child_apparel)
                                            @if (!in_array($child_cat->title, $apparels_child))
                                                <li>
                                                    <a {{-- href="shop-v3-sub-sub-category.html">{{ \App\Models\Category::where('id', $child_category->apparel)->value('title') }}</a> --}}
                                                        href="{{ route('single_category', ['slug' => $child_cat->slug]) }}">{{ $child_cat->title }}</a>
                                                    @php
                                                        $apparels_child[] = $child_cat->title;
                                                    @endphp
                                                    <span
                                                        class="total-fetch-items">({{ \App\Models\Product::where(['cat_id' => @$parent_category, 'child_cat_id' => $child_cat->id, 'status' => 'active'])->count() }})</span>

                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            @endforeach
                        @endif
                    </div>
                    <!-- Fetch-Categories-from-Root-Category  /- -->
                </div>
                <!-- Shop-Left-Side-Bar-Wrapper /- -->
                <!-- Shop-Right-Wrapper -->
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <!-- Page-Bar -->
                    <div class="page-bar clearfix">
                        <div class="shop-settings">
                            <a id="list-anchor">
                                <i class="fas fa-th-list"></i>
                            </a>
                            <a id="grid-anchor" class="active">
                                <i class="fas fa-th"></i>
                            </a>
                        </div>
                        <!-- Toolbar Sorter 1  -->
                        <div class="toolbar-sorter">
                            <div class="select-box-wrapper">
                                <label class="sr-only" for="sortBy">Sort By</label>
                                <select class="select-box" id="sortBy">
                                    <option selected="selected" value="">Sort By: Latest</option>
                                    <option {{ \Request::get('sort') == 'priceAsc' ? 'selected' : '' }} value="priceAsc">
                                        Sort By: Lowest Price</option>
                                    <option {{ \Request::get('sort') == 'priceDesc' ? 'selected' : '' }} value="priceDesc">
                                        Sort By: Highest Price</option>
                                    <option {{ \Request::get('sort') == 'highRating' ? 'selected' : '' }}
                                        value="highRating">Sort By: Best Rating</option>
                                    <option {{ \Request::get('sort') == 'discAsc' ? 'selected' : '' }} value="discAsc">
                                        Sort By: Low Discount</option>
                                    <option {{ \Request::get('sort') == 'discDesc' ? 'selected' : '' }} value="discDesc">
                                        Sort By: High Discount</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Page-Bar /- -->
                    <!-- Row-of-Product-Container -->
                    <div class="row product-container grid-style" id="product-data">
                        @include('frontend.layouts._single_product')
                    </div>
                    <!-- Row-of-Product-Container /- -->
                </div>
                {{ $category_products->links('vendor.pagination.custom_pagination') }}
                <br>
                <!-- Shop-Right-Wrapper /- -->
            </div>
        </div>
    </div>
    <!-- Shop-Page /- -->
@endsection

@section('scripts')

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('#sortBy').change(function() {
            var sort = $('#sortBy').val();
            window.location = "{{ url('' . $route . '') }}/{{ $slug }}?sort=" + sort;
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


@endsection
