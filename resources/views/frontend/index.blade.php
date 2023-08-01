@extends('frontend.layouts.master')
@section('title', 'GoodGoods - Online Shopping for Electronics, Apparel, Computers, Books, DVDs & more')
@section('banner')
    @include('frontend.layouts.banner')
@endsection

@section('main-content')
    @include('frontend.layouts.mainContent')
@endsection

@section('scripts')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
    </script>
@endsection
