@extends('frontend.layouts.master')
@section('title', 'GoodGoods - Track Order')
@section('banner')
    <div class="cmt-page-title-row bg-base-dark cmt-bg cmt-bgimage-yes clearfix mb-5">
        <div class="cmt-titlebar-wrapper-bg-layer cmt-bg-layer"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="cmt-page-title-row-inner">
                        <div class="page-title-heading">
                            <h2 class="title" style="color: white">Track Order</h2>
                        </div>
                        <div class="breadcrumb-wrapper">
                            <span>
                                <a title="Homepage" href="{{ route('front.home') }}">Home</a>
                            </span>
                            <span>Track Order</span>
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
    <!--====== Main Section ======-->
    <div class="u-s-p-b-60 mb-5">

        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="dash">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-12">

                            <!--====== Dashboard Features ======-->
                            <div class="dash__box dash__box--bg-white dash__box--shadow u-s-m-b-30">
                                <div class="dash__pad-1">

                                    <span class="dash__text u-s-m-b-16">Hello, {{ auth()->user()->full_name }}</span>
                                    <ul class="dash__f-list">
                                        <li>

                                            <a href="">Manage My Account</a>
                                        </li>
                                        <li>

                                            <a href="">My Profile</a>
                                        </li>
                                        <li>

                                            <a href="">Address Book</a>
                                        </li>
                                        <li>

                                            <a class="dash-active" href="#">Track Order</a>
                                        </li>
                                        <li>

                                            <a href="{{route('my_order.index')}}">My Orders</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--====== End - Dashboard Features ======-->
                        </div>
                        <div class="col-lg-9 col-md-12">
                            <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white">
                                <div class="dash__pad-2">
                                    <h1 class="dash__h1 u-s-m-b-14">Track your Order</h1>

                                    <span class="dash__text u-s-m-b-30">To track your order please enter your Order ID in
                                        the box below and press the "Track" button. This was given to you on your receipt
                                        and in the confirmation email you should have received.</span>
                                    <form class="dash-track-order" action="{{ route('search.order') }}" method="get">
                                        @csrf
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <strong>Oh sorry! </strong>There were some issues with your input.<br><br>
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="gl-inline">
                                            <div class="u-s-m-b-30">

                                                <label class="gl-label" for="order_number">Order ID *</label>

                                                <input
                                                    class="input-text input-text--primary-style @error('order_number') is-invalid @enderror"
                                                    type="text" name="order_number" id="order_number"
                                                    value="{{ old('order_number') }}"
                                                    placeholder="Found in your confirmation email, eg. ORD-N5AZ74" required>
                                                @if (session('error'))
                                                    <span id='alert'
                                                        style="color: red" role="alert">{{ session('error') }}</span>
                                                @endif
                                            </div>
                                            <div class="u-s-m-b-30">

                                            </div>
                                        </div>
                                        <button class="btn btn--e-brand-b-2" type="submit">TRACK</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Main Section ======-->
@endsection
@section('scripts')
    <script>
        setTimeout(function() {
            $("#alert").slideUp();
        }, 3000);
    </script>

@endsection
