@extends('frontend.layouts.master')
@section('title', 'GoodGoods - Wishlist')

@section('banner')
    <!-- Banner -->
    <div class="cmt-page-title-row bg-base-dark cmt-bg cmt-bgimage-yes clearfix mb-4">
        <div class="cmt-titlebar-wrapper-bg-layer cmt-bg-layer"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="cmt-page-title-row-inner">
                        <div class="page-title-heading">
                            <h2 class="title" style="color: white">Wishlist</h2>
                        </div>
                        <div class="breadcrumb-wrapper">
                            <span>
                                <a title="Homepage" href="{{ route('front.home') }}">Home</a>
                            </span>
                            <span>Wishlist</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('main-content')
    <div class="page-wishlist u-s-p-t-80">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-12">
                    <!-- Products-List-Wrapper -->
                    <div class="table-wrapper u-s-m-b-60" id="wishlist_list">
                        @include('frontend.layouts._wishlist')
                    </div>
                    <!-- Products-List-Wrapper /- -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Add to cart --}}
    <script>
        $('.move-to-cart').on('click', function(e) {
            e.preventDefault();
            var rowId = $(this).data('id');
            var token = "{{ csrf_token() }}";
            var path = "{{ route('wishlist.move.cart') }}";

            $.ajax({
                url: path,
                type: 'POST',
                data: {
                    _token: token,
                    rowId: rowId,
                },
                beforeSend: function() {
                    $(this).html('<i class="fas fa-spinner fa-spin"></i> Moving to Cart..');
                },
                success: function(data) {
                    if (data['status']) {
                        $('body #header-ajax').html(data['header']);
                        $('body #cart_counter').html(data['cart_count']);
                        $('body #wishlist_counter').html(data['wishlist_count']);
                        $('body #wishlist_list').html(data['wishlist_list']);
                        Swal.fire({
                            icon: 'success',
                            title: 'Great',
                            text: data['message'],
                            showConfirmButton: false,
                            timer: 1500
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops',
                            text: 'Something went wrong',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: 'Error processing',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });
    </script>

    {{-- Delete wishlist --}}
    <script>
        $('.delete_wishlist').on('click', function(e) {
            e.preventDefault();
            var rowId = $(this).data('id');
            var token = "{{ csrf_token() }}";
            var path = "{{ route('wishlist.delete') }}";

            $.ajax({
                url: path,
                type: 'POST',
                data: {
                    _token: token,
                    rowId: rowId,
                },
                success: function(data) {
                    if (data['status']) {
                        $('body #header-ajax').html(data['header']);
                        $('body #cart_counter').html(data['cart_count']);
                        $('body #wishlist_counter').html(data['wishlist_count']);
                        $('body #wishlist_list').html(data['wishlist_list']);
                        Swal.fire({
                            icon: 'success',
                            title: 'Great',
                            text: data['message'],
                            showConfirmButton: false,
                            timer: 1500
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops',
                            text: 'Something went wrong',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: 'Error processing',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });
    </script>
@endsection
