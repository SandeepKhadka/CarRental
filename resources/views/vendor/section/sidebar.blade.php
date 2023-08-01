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
                 <img src="{{ asset('dist/img/avatar4.png') }}" class="img-circle elevation-2" alt="">
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
                         class="nav-link {{ request()->is('seller') ? 'active' : '' }}">
                         <i class="sidebar-item-icon fa fa-th-large"></i>
                         <span class="nav-label px-2 text-dark">Dashboard</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('seller-product.index') }}"
                         class="nav-link {{ request()->is('seller/seller-product*') || request()->is('seller/product_attribute*') ? 'active' : '' }}">
                         <i class="sidebar-item-icon fa fa-shopping-bag"></i>
                         <span class="nav-label px-2 text-dark">Products</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->is('seller/seller-order*') ? 'active' : '' }}"
                         href="{{ route('seller-order.index') }}">
                         <i class="sidebar-item-icon fa fa-shopping-basket"></i>
                         <span class="nav-label px-1 text-dark">Orders</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="">
                         <i class="sidebar-item-icon fa fa-retweet"></i>
                         <span class="nav-label px-1 text-dark">Return orders</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->is('seller/seller-coupon*') ? 'active' : '' }}"
                         href="{{ route('seller-coupon.index') }}">
                         <i class="sidebar-item-icon fa fa-ticket"></i>
                         <span class="nav-label px-1 text-dark">Coupon Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="">
                         <i class="sidebar-item-icon fa fa-star"></i>
                         <span class="nav-label px-1 text-dark">Review Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="" class="nav-link">
                         <i class="sidebar-item-icon fa fa-comment"></i>
                         <span class="nav-label px-2 text-dark">Comments Management</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->is('seller/shop*') ? 'active' : '' }} "
                         href="{{ route('display.shop.setting') }}">
                         <i class="sidebar-item-icon fa fa-gear"></i>
                         <span class="nav-label px-1 text-dark">Shop settings</span>
                     </a>
                 </li>
                 {{-- <li class="nav-item">
                    <a href="{{ route('index.index') }}" class="nav-link">
                        <i class="sidebar-item-icon fa fa-home"></i>
                        <p>Home Manager</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('gallery.index') }}" class="nav-link">
                        <i class="sidebar-item-icon fa fa-images"></i>
                        <p>Gallery Manager</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category.index') }}" class="nav-link">
                        <i class="sidebar-item-icon fa fa-sitemap"></i>
                        <p>Category Manager</p>
                    </a>
                </li> --}}
                 {{-- <div class="nav-item dropdown-show">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown">
                        <i class="sidebar-item-icon fa fa-cog"></i>
                        <p>Service Manager</p>
                    </a>
                    <div class="dropdown-menu bg-secondary">
                        <a class="nav-item dropdown-item btn btn-secondary" href="">Service Listing
                            Manager</a>
                        <a class="nav-item dropdown-item btn btn-secondary" href="">Service Description
                            Manager</a>
                    </div>
                </div> --}}
                 {{-- <li class="nav-item">
                    <a href="{{ route('page.index') }}" class="nav-link">
                        <i class="sidebar-item-icon fa fa-file"></i>
                        <p>Page Manager</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('price.index') }}" class="nav-link">
                        <i class="sidebar-item-icon fa fa-dollar"></i>
                        <p>Pricing Manager</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('testimonial.index') }}" class="nav-link">
                        <i class="sidebar-item-icon fa fa-comments"></i>
                        <p>Testimonial Manager</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('menu.index') }}" class="nav-link">
                        <i class="sidebar-item-icon fa fa-bars"></i>
                        <p>Menu Manager</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contact.index') }}" class="nav-link">
                        <i class="sidebar-item-icon fa fa-id-badge"></i>
                        <p>Contact Manager</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('site_config.index') }}" class="nav-link">
                        <i class="sidebar-item-icon fa fa-satellite"></i>
                        <p>Site config Manager</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('footer.index') }}" class="nav-link">
                        <i class="sidebar-item-icon fa fa-whatsapp"></i>
                        <p>Footer Manager</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link">
                        <i class="sidebar-item-icon fa fa-users"></i>
                        <p>Users Manager</p>
                    </a>
                </li> --}}
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
