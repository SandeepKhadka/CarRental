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
    @yield('main-content')
    <!-- content -->

    <!-- Footer -->
    @include('frontend.layouts.footer')
</div>

@include('frontend.layouts.scripts')
