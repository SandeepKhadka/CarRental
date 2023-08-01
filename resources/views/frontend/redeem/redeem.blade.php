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
                <form action="{{ route('search.filter') }}" method="post">
                    @csrf
                    <input type="hidden" name="slug" value="{{ @$slug }}">
                    <div class="row">
                        <div class="col-lg-1 col-md-1">
                        </div>
                        <div class="col-lg-11 col-md-11">
                            <div class="shop-p">
                                <div class="shop-p__toolbar u-s-m-b-30">
                                    <div class="shop-p__meta-wrap u-s-m-b-60">
                                        <span class="shop-p__meta-text-1">Your Total Reedem Points :
                                            {{ \App\Models\ReferralLink::where('user_id', auth()->user()->id)->sum('points') ?? 0 }}</span>
                                    </div>
                                </div>
                                <!-- Row-of-Product-Container -->
                                <div class="row product-container grid-style" id="product-data">
                                    @include('frontend.redeem.redeem_product')
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
    <script>
        $('.redeem').on('click', function(e) {
            e.preventDefault();

            // Get the user ID from the ReferralLink table
            var userId = "{{ auth()->user()->id }}";
            var product_id = $(this).data('id');
            var token = "{{ csrf_token() }}";


            // Send an AJAX request to the controller
            $.ajax({
                url: "{{ route('check.referral') }}",
                type: "POST",
                data: {
                    user_id: userId,
                    product_id: product_id,
                    _token: token,
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 'success') {
                        // Redirect to the checkout page
                        window.location.href = "{{ route('reedem.checkout') }}?user_id=" + userId +
                            "&product_id=" + product_id;
                    } else {
                        // Show a Sweet Alert with the error message
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
