@extends('frontend.layouts.master')
@section('title', 'GoodGoods - Order Detail')
@section('banner')
    <div class="cmt-page-title-row bg-base-dark cmt-bg cmt-bgimage-yes clearfix mb-5">
        <div class="cmt-titlebar-wrapper-bg-layer cmt-bg-layer"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="cmt-page-title-row-inner">
                        <div class="page-title-heading">
                            <h2 class="title" style="color: white">Order Detail</h2>
                        </div>
                        <div class="breadcrumb-wrapper">
                            <span>
                                <a title="Homepage" href="{{ route('front.home') }}">Home</a>
                            </span>
                            <span>Order Detail</span>
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

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
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

        .btn-no-border {
            border: none;
            background: none;
            padding: 0;
            font-size: inherit;
            cursor: pointer;
        }
    </style>
    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

@endsection
@section('main-content')
    <!--====== Order Detail ======-->
    <div class="u-s-p-b-60">
        @if (session('success'))
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                });
            </script>
        @elseif(session('error'))
            <script>
                Swal.fire({
                    icon: 'eroor',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                });
            </script>
        @endif
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

                                            <a href="{{ route('track.order') }}">Track Order</a>
                                        </li>
                                        <li>

                                            <a class="dash-active" href="{{ route('my_order.index') }}">My Orders</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--====== End - Dashboard Features ======-->
                        </div>
                        <div class="col-lg-9 col-md-12">
                            <h1 class="dash__h1 u-s-m-b-30">Order Details</h1>
                            <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white u-s-m-b-30">
                                <div class="dash__pad-2">
                                    <div class="dash-l-r">
                                        <div>
                                            <div class="manage-o__text-2 u-c-secondary">Order #{{ $order->order_number }}
                                            </div>
                                            <div class="manage-o__text u-c-silver">Placed on {{ $orderDate }}</div>
                                        </div>
                                        <div>
                                            <div class="manage-o__text-2 u-c-silver">Total:

                                                <span class="manage-o__text-2 u-c-secondary">Rs
                                                    {{ $order->total_amount }}</span>
                                            </div>
                                            @if ($order->condition == 'processing')
                                                <div>
                                                    <span class="manage-o__text u-c-silver">
                                                        <form id="cancel-form" method="POST"
                                                            action="{{ route('my_order.update', $order->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <!-- Add your form fields here -->
                                                            <button type="submit" id=""
                                                                class="manage-o__text btn-no-border">Cancel</button>
                                                        </form>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white u-s-m-b-30">
                                <div class="dash__pad-2">
                                    <div class="manage-o">
                                        <div class="manage-o__header u-s-m-b-30">
                                            <div class="manage-o__icon"><i class="fas fa-box u-s-m-r-5"></i>

                                                <span class="manage-o__text">Package(s)</span>
                                            </div>
                                        </div>
                                        <div class="">
                                            @if (isset($deliveredDate) && $deliveredDate != null)
                                                <div class="manage-o__text u-c-secondary">Delivered on {{ $deliveredDate }}
                                            @endif
                                        </div>
                                        <div class="manage-o__timeline">
                                            <div class="timeline-row">
                                                @if ($order->condition != 'cancelled')
                                                    <div class="col-lg-4 u-s-m-b-30">
                                                        <div class="timeline-step">
                                                            <div class="timeline-l-i timeline-l-i--finish">

                                                                <span class="timeline-circle"></span>
                                                            </div>

                                                            <span class="timeline-text">Processing</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 u-s-m-b-30">
                                                        <div class="timeline-step">
                                                            <div
                                                                class="timeline-l-i {{ $order->condition == 'shipped' || $order->condition == 'out for delivery' || $order->condition == 'delivered' ? 'timeline-l-i--finish' : '' }}">

                                                                <span class="timeline-circle"></span>
                                                            </div>

                                                            <span class="timeline-text">Shipped</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 u-s-m-b-30">
                                                        <div class="timeline-step">
                                                            <div
                                                                class="timeline-l-i {{ $order->condition == 'delivered' ? 'timeline-l-i--finish' : '' }}">

                                                                <span class="timeline-circle"></span>
                                                            </div>

                                                            <span class="timeline-text">Delivered</span>
                                                        </div>
                                                    </div>
                                                @elseif($order->condition == 'cancelled')
                                                    <div class="col-lg-4 u-s-m-b-30">
                                                        <div class="timeline-step">
                                                            <div class="cancelled timeline-l-i timeline-l-i--finish">

                                                                <span class="timeline-circle"></span>
                                                            </div>

                                                            <span class="timeline-text">Cancellation in Process</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 u-s-m-b-30">
                                                        <div class="cancelled timeline-l-i timeline-l-i--finish">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 u-s-m-b-30">
                                                        <div class="timeline-step">
                                                            <div class="cancelled timeline-l-i timeline-l-i--finish">

                                                                <span class="timeline-circle"></span>
                                                            </div>

                                                            <span class="timeline-text">Cancelled</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- @php
                                            $count = 0;
                                        @endphp --}}
                                        @foreach ($order->products as $item)
                                            @php
                                                $photos = explode(',', $item->image);
                                                $count = count($order->products);
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
                                                </div>
                                                <div class="description__info-wrap">
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
                                                    @if ($order->condition == 'processing' && $count > 1)
                                                        <div>
                                                            <span class="manage-o__text u-c-silver">
                                                                <form id="remove-form" method="POST"
                                                                    action="{{ route('my_order.destroy', $item->id) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <!-- Add your form fields here -->
                                                                    <input type="hidden" name="order_id"
                                                                        value="{{ $order->id }}">
                                                                    <button type="submit" id="remove-button"
                                                                        class="manage-o__text btn-no-border">Remove</button>
                                                                </form>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="dash__box dash__box--bg-white dash__box--shadow u-s-m-b-30">
                                        <div class="dash__pad-3">
                                            <h2 class="dash__h2 u-s-m-b-8">Shipping Address</h2>
                                            <h2 class="dash__h2 u-s-m-b-8">
                                                {{ $order->sfirst_name . ' ' . $order->slast_name }}</h2>

                                            <span
                                                class="dash__text-2">{{ $order->spostcode . ' ' . $order->saddress . ' ' . $order->scity . ' - ' . $order->sstate . ' - ' . $order->scountry }}</span>

                                            <span class="dash__text-2">(+977) {{ $order->sphone }}</span>
                                            <span class="dash__text-2">{{ $order->semail }}</span>
                                        </div>
                                    </div>
                                    <div class="dash__box dash__box--bg-white dash__box--shadow dash__box--w">
                                        <div class="dash__pad-3">
                                            <h2 class="dash__h2 u-s-m-b-8">Billing Address</h2>
                                            <h2 class="dash__h2 u-s-m-b-8">
                                                {{ $order->first_name . ' ' . $order->last_name }}</h2>

                                            <span
                                                class="dash__text-2">{{ $order->postcode . ' ' . $order->address . ' ' . $order->city . ' - ' . $order->state . ' - ' . $order->country }}</span>

                                            <span class="dash__text-2">(+977) {{ $order->phone }}</span>
                                            <span class="dash__text-2">{{ $order->email }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="dash__box dash__box--bg-white dash__box--shadow u-h-100">
                                        <div class="dash__pad-3">
                                            <h2 class="dash__h2 u-s-m-b-8">Total Summary</h2>
                                            <div class="dash-l-r u-s-m-b-8">
                                                <div class="manage-o__text-2 u-c-secondary">Subtotal</div>
                                                <div class="manage-o__text-2 u-c-secondary">Rs {{ $order->sub_total }}
                                                </div>
                                            </div>
                                            <div class="dash-l-r u-s-m-b-8">
                                                <div class="manage-o__text-2 u-c-secondary">Shipping Fee</div>
                                                <div class="manage-o__text-2 u-c-secondary">Rs
                                                    {{ $order->delivery_charge }}</div>
                                            </div>
                                            <div class="dash-l-r u-s-m-b-8">
                                                <div class="manage-o__text-2 u-c-secondary">Total</div>
                                                <div class="manage-o__text-2 u-c-secondary">Rs {{ $order->total_amount }}
                                                </div>
                                            </div>

                                            <span class="dash__text-2">
                                                @if ($order->condition == 'cancelled')
                                                    Cancelled
                                                @else
                                                    Paid by
                                                    {{ $order->payment_method == 'cod' ? 'Cash on Delivery' : 'Esewa' }}
                                                @endif
                                            </span>
                                        </div>
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
    <!--====== End - Order Detail ======-->
@endsection
@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('cancel-form').addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to cancel this order',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, cancel the process
                    this.submit();
                }
            });
        });
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('remove-form').addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to remove this order product',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, cancel the process
                    this.submit();
                }
            });
        });
    </script>

@endsection
