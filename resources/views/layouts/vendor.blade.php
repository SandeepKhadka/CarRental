@include('vendor.section.header')

@section('title' , 'GoodGoods | Admin')
<div class="wrapper">

    @include('vendor.section.topnav')

    @include('vendor.section.sidebar')
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @yield('main-content')
    </div>
    
    <!-- /.content-wrapper -->

    @include('vendor.section.footer')

    <!-- ./wrapper -->
    
  </div>
  @include('vendor.section.scripts')
