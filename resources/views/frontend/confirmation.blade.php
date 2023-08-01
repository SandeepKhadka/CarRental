@include('frontend.layouts.header')

@section('title', 'GoodGoods - Online Shopping for Electronics, Apparel, Computers, Books, DVDs & more')

<!-- app -->
<div id="app">
    <!-- Navbar -->
    @include('frontend.layouts.topnav')
    <!-- Navbar /- -->

    <!-- Bannerr -->
    @yield('banner')
    <!-- Bannerr /- -->

    <!-- content -->
    <div class="page-checkout-confirm">
        <div class="vertical-center">
            <div class="text-center">
                <h2>Thank You!!</h2>
                <h3>You order has been placed successfully with order number <strong>{{@$order_id}}</strong>.</h3>
                <h5>Confimation mail has been send to your email address.
                </h5>
                {{-- <a  class="thank-you-back">Resend confirmation mail</a> --}}
            </div>
        </div>
    </div>
    <!-- content -->

    <!-- Footer -->
</div>
