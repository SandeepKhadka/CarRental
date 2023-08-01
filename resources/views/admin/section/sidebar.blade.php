 <!-- Main Sidebar Container -->
 {{-- <aside class="main-sidebar sidebar-dark elevation-4" style="background-color: #003459;"> --}}
 <aside class="main-sidebar sidebar-dark elevation-4">
     <!-- Brand Logo -->
     <a href="{{ route(auth()->user()->role) }}" class="brand-link">
         {{-- <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="" class="brand-image img-circle elevation-3"
             style="opacity: .8"> --}}
         <span class="brand-text text-dark">GoodGoods</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user panel (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <img src="{{ asset('dist/img/myphoto.jpg') }}" class="img-circle elevation-2" alt="">
             </div>
             <div class="info">
                 <a href="#" class="d-block text-dark">{{ ucfirst(auth()->user()->full_name) }}</a>
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                 <li class="nav-item">
                     <a href="{{ route(auth()->user()->role) }}"
                         class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                         <i class="sidebar-item-icon fa fa-th-large"></i>
                         <span class="nav-label px-2 text-dark">Dashboard</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('banner.index') }}"
                         class="nav-link {{ request()->is('admin/banner*') ? 'active' : '' }}">
                         <i class="sidebar-item-icon fa fa-image"></i>
                         <span class="nav-label px-2 text-dark">Banner Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('category.index') }}"
                         class="nav-link {{ request()->is('admin/category*') ? 'active' : '' }}">
                         <i class="sidebar-item-icon fa fa-sitemap"></i>
                         <span class="nav-label px-1 text-dark">Category Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('apparel.index') }}"
                         class="nav-link {{ request()->is('admin/apparel*') ? 'active' : '' }}">
                         <i class="sidebar-item-icon fa fa-tshirt"></i>
                         <span class="nav-label px-1 text-dark">Apparel Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('brand.index') }}"
                         class="nav-link {{ request()->is('admin/brand*') ? 'active' : '' }}">
                         <i class="sidebar-item-icon fa fa-sitemap"></i>
                         <span class="nav-label px-1 text-dark">Brand Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('product.index') }}"
                         class="nav-link {{ request()->is('admin/product*') ? 'active' : '' }}">
                         <i class="sidebar-item-icon fa fa-shopping-bag"></i>
                         <span class="nav-label px-2 text-dark">Product Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->is('admin/cart*') ? 'active' : '' }}" href="">
                         <i class="sidebar-item-icon fa fa-shopping-cart"></i>
                         <span class="nav-label px-1 text-dark">Cart Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->is('admin/order*') ? 'active' : '' }}" href="{{route('order.index')}}">
                         <i class="sidebar-item-icon fa fa-tachometer"></i>
                         <span class="nav-label px-1 text-dark">Order Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->is('admin/shop*') ? 'active' : '' }}" href="{{route('shop.index')}}">
                         <i class="sidebar-item-icon fa fa-sitemap"></i>
                         <span class="nav-label px-1 text-dark">Shop Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->is('admin/post_tag*') ? 'active' : '' }}" href="">
                         <i class="sidebar-item-icon fa fa-tag"></i>
                         <span class="nav-label px-2 text-dark">Post Tag</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->is('admin/post_management*') ? 'active' : '' }}" href="">
                         <i class="sidebar-item-icon fa fa-envelope"></i>
                         <span class="nav-label px-2 text-dark">Post Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->is('admin/review*') ? 'active' : '' }}" href="">
                         <i class="sidebar-item-icon fa fa-star"></i>
                         <span class="nav-label px-1 text-dark">Review Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->is('admin/coupon*') ? 'active' : '' }}"
                         href="{{ route('coupon.index') }}">
                         <i class="sidebar-item-icon fa fa-ticket"></i>
                         <span class="nav-label px-1 text-dark">Coupon Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('user.index') }}"
                         class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}">
                         <i class="sidebar-item-icon fa fa-users"></i>
                         <span class="nav-label px-1 text-dark">User Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="" class="nav-link {{ request()->is('admin/comment*') ? 'active' : '' }}">
                         <i class="sidebar-item-icon fa fa-comment"></i>
                         <span class="nav-label px-2 text-dark">Comments Management</span>
                     </a>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
