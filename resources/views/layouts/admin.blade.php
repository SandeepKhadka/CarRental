@include('admin.section.header')

@section('title' , 'GoodGoods | Admin')
<div class="wrapper">

    @include('admin.section.topnav')

    @include('admin.section.sidebar')
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @yield('main-content')
    </div>
    
    <!-- /.content-wrapper -->

    @include('admin.section.footer')

    <!-- ./wrapper -->
    
  </div>
  @include('admin.section.scripts')
