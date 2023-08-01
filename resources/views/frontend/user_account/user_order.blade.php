@extends('frontend.layouts.master')
@section('title', 'GoodGoods - My Orders')
@section('banner')
    <div class="cmt-page-title-row bg-base-dark cmt-bg cmt-bgimage-yes clearfix mb-5">
        <div class="cmt-titlebar-wrapper-bg-layer cmt-bg-layer"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="cmt-page-title-row-inner">
                        <div class="page-title-heading">
                            <h2 class="title" style="color: white">My Orders</h2>
                        </div>
                        <div class="breadcrumb-wrapper">
                            <span>
                                <a title="Homepage" href="{{ route('front.home') }}">Home</a>
                            </span>
                            <span>My Orders</span>
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
    <style>
        .cancelled.timeline-l-i.timeline-l-i--finish {
            border-color: #f10202;
        }

        .cancelled.timeline-l-i.timeline-l-i--finish .timeline-circle {
            border-color: #f10202;
        }

        .cancelled.timeline-l-i.timeline-l-i--finish .timeline-circle:before {
            background-color: #f10202;
        }
    </style>

@endsection
@section('main-content')
    <!--====== Section 2 ======-->
    <div class="u-s-p-b-60">
        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="dash">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-12">

                            <!--====== Dashboard Features ======-->
                            <div class="dash__box dash__box--bg-white dash__box--shadow u-s-m-b-30">
                                <div class="dash__pad-1">

                                    <span class="dash__text u-s-m-b-16">Hello,
                                        {{ auth()->user()->full_name ?? 'User' }}</span>
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

                                            <a href="{{ route('track.order') }}">Track Order</a>
                                        </li>
                                        <li>

                                            <a class="dash-active" href="#">My Orders</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--====== End - Dashboard Features ======-->
                        </div>
                        <div class="col-lg-9 col-md-12">
                            <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white u-s-m-b-30">
                                <div class="dash__pad-2">
                                    <h1 class="dash__h1 u-s-m-b-14">My Orders</h1>

                                    <span class="dash__text u-s-m-b-30">Here you can see all your orders.</span>
                                    <form action="{{ route('order.filter') }}" method="post">
                                        @csrf
                                        <div class="m-order__select-wrapper">
                                            <label class="u-s-m-r-8" for="my-order-sort">Show:</label><select
                                                class="select-box select-box--primary-style" id="my-order-sort" name="sortBy" onchange="this.form.submit()">
                                                <option selected value="">Last 5 orders</option>
                                                <option {{ \Request::get('sortBy') == 'last_15_days' ? 'selected' : '' }} value="last_15_days">Last 15 days</option>
                                                <option {{ \Request::get('sortBy') == 'last_30_days' ? 'selected' : '' }} value="last_30_days">Last 30 days</option>
                                                <option {{ \Request::get('sortBy') == 'last_6_months' ? 'selected' : '' }} value="last_6_months">Last 6 months</option>
                                                <option {{ \Request::get('sortBy') == 'all_orders' ? 'selected' : '' }} value="all_orders">All Orders</option>
                                            </select>
                                        </div>
                                    </form>
                                    <div class="m-order__list">
                                        @foreach ($orders as $order)
                                            <div class="m-order__get">
                                                <div class="manage-o__header u-s-m-b-30">
                                                    <div class="dash-l-r">
                                                        <div>
                                                            <div class="manage-o__text-2 u-c-secondary">Order
                                                                #{{ $order->order_number }}
                                                            </div>
                                                            <div class="manage-o__text u-c-silver">Placed on
                                                                {{ $order->created_at->format('d M Y H:i:s') }}</div>
                                                        </div>
                                                        <div>
                                                            <div class="dash__link dash__link--brand">

                                                                <a href="{{route('search.order', ['order_number' => $order->order_number])}}">MANAGE</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @foreach ($order->products as $item)
                                                    @php
                                                        $photos = explode(',', $item->image);
                                                    @endphp
                                                    <div class="manage-o__description mb-5">
                                                        <div class="description__container">
                                                            <div class="description__img-wrap">
                                                                @if (file_exists(public_path() . '/uploads/product/Thumb-' . $item->image))
                                                                    <td>
                                                                        <img class="u-img-fluid"
                                                                            src="{{ asset('/uploads/product/Thumb-' . $item->image) }}"
                                                                            alt="product_image">
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <img class="u-img-fluid" src="{{ $photos[0] }}"
                                                                            alt="product_image">
                                                                    </td>
                                                                @endif
                                                            </div>
                                                            <div class="description-title">{{ $item->title }}</div>
                                                        </div>
                                                        <div class="description__info-wrap">
                                                            <div>

                                                                <span
                                                                    class="manage-o__badge @if ($order->condition == 'processing') badge--processing @elseif($order->condition == 'delivered') badge--delivered @elseif($order->condition == 'shipped') badge--shipped @else badge--cancelled @endif">{{ ucfirst($order->condition) }}</span>
                                                            </div>
                                                            <div>

                                                                <span class="manage-o__text-2 u-c-silver">Quantity:

                                                                    <span
                                                                        class="manage-o__text-2 u-c-secondary">{{ $item->pivot->quantity }}</span></span>
                                                            </div>
                                                            <div>

                                                                <span class="manage-o__text-2 u-c-silver">Total:

                                                                    <span class="manage-o__text-2 u-c-secondary">Rs
                                                                        {{ number_format($item->offer_price, 2) }}</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 2 ======-->
@endsection
