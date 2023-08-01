@extends('frontend.layouts.master')
@section('title', 'GoodGoods - Cart')
@section('styles')

    <!--====== App ======-->
    <link rel="stylesheet" href="{{ asset('assets/shop/css/app.css') }}">
@endsection

@section('banner')
    <!-- Banner -->
    <div class="cmt-page-title-row bg-base-dark cmt-bg cmt-bgimage-yes clearfix mb-3">
        <div class="cmt-titlebar-wrapper-bg-layer cmt-bg-layer"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="cmt-page-title-row-inner">
                        <div class="page-title-heading">
                            <h2 class="title" style="color: white">Cart</h2>
                        </div>
                        <div class="breadcrumb-wrapper">
                            <span>
                                <a title="Homepage" href="{{ route('front.home') }}">Home</a>
                            </span>
                            <span>Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner /- -->
@endsection

@section('main-content')
    <!-- Cart-Page -->
    <div class="page-cart u-s-p-t-80">
        <div class="container">
            <div class="col-lg-12">
                @include('frontend.layouts.notify')
            </div>
            <br>
            <div class="row mb-5">
                <div class="col-lg-12">
                    {{-- <form> --}}
                    <!-- Products-List-Wrapper -->
                    <div class="table-wrapper u-s-m-b-60" id="cart_list">
                        @include('frontend.layouts.cart_lists')
                    </div>
                    <!-- Products-List-Wrapper /- -->
                </div>
            </div>
        </div>
    </div>
    <!-- Cart-Page /- -->
@endsection

@section('scripts')
    <script script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('click', '.coupon-btn', function(e) {
            e.preventDefault();
            var code = $('input[name=code]').val();
            $('.coupon-btn').html('<i class = "fas fa-spinner fa-spin"></i> Applying...')
            $('#coupon-form').submit();
        });
    </script>
    <script>
        $(document).on('click', '.qty-text', function() {
            var id = $(this).data('id')

            var spinner = $(this),
                input = spinner.closest("div.quantity").find('input[type="number"]');
            if (input.val() == 1) {
                return false;
            }
            if (input.val() != 1) {
                var newVal = parseFloat(input.val());
                $('#qty-input-' + id).val(newVal);
            }

            var productQuantity = $("#update-cart-" + id).data('product-quantity');
            update_cart(id, productQuantity)
        });

        function update_cart(id, productQuantity) {
            var rowId = id;
            var product_qty = $('#qty-input-' + rowId).val();
            var token = "{{ csrf_token() }}";
            var path = "{{ route('cart.update') }}";

            $.ajax({
                url: path,
                type: "POST",
                data: {
                    _token: token,
                    product_qty: product_qty,
                    rowId: rowId,
                    productQuantity: productQuantity,
                },
                success: function(data) {
                    console.log(data);
                    if (data['status']) {
                        $('body #header-ajax').html(data['header']);
                        $('body #cart_counter').html(data['cart_count']);
                        $('body #cart_list').html(data['cart_list']);
                        Swal.fire({
                            icon: 'success',
                            title: 'Great',
                            text: data['message'],
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Great',
                            text: data['message'],
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            })

        }
    </script>
    <script>
        $(document).on('click', '.cart_delete', function(e) {
            e.preventDefault();
            var cart_id = $(this).data('id');
            // alert(product_id);

            var token = "{{ csrf_token() }}";
            var path = "{{ route('cart.delete') }}";

            $.ajax({
                url: path,
                type: "POST",
                dataType: "JSON",
                data: {
                    cart_id: cart_id,
                    _token: token,
                },
                success: function(data) {
                    console.log(data);
                    if (data['status']) {
                        $('body #header-ajax').html(data['header']);
                        $('body #cart_counter').html(data['cart_count']);
                        Swal.fire({
                            icon: 'success',
                            title: 'Great',
                            text: data['message'],
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(err) {
                    console.log(err);
                }
            });

        });
    </script>
@endsection
