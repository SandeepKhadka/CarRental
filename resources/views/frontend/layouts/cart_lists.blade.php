<!--====== App Content ======-->
<div class="app-content">
    <div class="u-s-p-b-60">
        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 u-s-m-b-30">
                        <div class="table-responsive">
                            <table class="table-p">
                                <tbody>
                                    @if (\Gloudemans\Shoppingcart\Facades\Cart::instance('shopping')->count() > 0)
                                        @foreach (\Gloudemans\Shoppingcart\Facades\Cart::instance('shopping')->content() as $item)
                                            <!--====== Row ======-->
                                            <tr>
                                                <td>
                                                    <div class="table-p__box">
                                                        <div class="table-p__img-wrap">
                                                            @php
                                                                $photos = explode(',', @$item->model->image);
                                                            @endphp
                                                            @if (file_exists(public_path() . '/uploads/product/' . @$item->model->image))
                                                                <a
                                                                    href="{{ route('productDetail', @$item->model->slug) }}">

                                                                    <img class="u-img-fluid"
                                                                        src={{ asset('/uploads/product/' . @$item->model->image) }}>
                                                                </a>
                                                            @else
                                                                <a
                                                                    href="{{ route('productDetail', @$item->model->slug) }}">

                                                                    <img class="u-img-fluid" src={{ $photos[0] }}>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div class="table-p__info">
                                                            @php
                                                                $title_size = explode(',', @$item->name);
                                                            @endphp

                                                            <span class="table-p__name">
                                                                <a
                                                                    href="{{ route('productDetail', @$item->model->slug) }}">{{ $title_size[0] }}</a></span>
                                                            <ul class="table-p__variant-list">
                                                                <li>
                                                                    <span>Unit price: {{ $item->price }}</span>
                                                                </li>
                                                                <li>
                                                                    <span>Size:
                                                                        {{ isset($title_size[1]) && $title_size[1] != '' ? $title_size[1] : $item->model->size }}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>

                                                    <span class="table-p__price">Rs {{ $item->subtotal() }}</span>
                                                </td>
                                                <td>
                                                    <div>
                                                        <div class="quantity">
                                                            <input type="number" data-id="{{ $item->rowId }}"
                                                                class="quantity-text-field qty-text"
                                                                id="qty-input-{{ $item->rowId }}"
                                                                value="{{ $item->qty }}">
                                                            <a class="plus-a qty-text"
                                                                id="qty-input-{{ $item->rowId }}"
                                                                data-id="{{ $item->rowId }}" data-max="1000">&#43;</a>
                                                            <a class="minus-a" data-min="1">&#45;</a>
                                                            <input type="hidden" data-id="{{ $item->rowId }}"
                                                                data-product-quantity="{{ $item->model->stock }}"
                                                                id="update-cart-{{ $item->rowId }}">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-p__del-wrap">

                                                        <button
                                                            class="far fa-trash-alt table-p__delete-link cart_delete"
                                                            data-id="{{ $item->rowId }}"style="cursor: pointer"></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!--====== End - Row ======-->
                                        @endforeach
                                    @else
                                        <div>
                                            <p class="text-center"
                                                style="font-weight: bold; color: black; margin-bottom: 60px">You
                                                don't have any product in your cart.</p>
                                        </div>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="route-box">
                            <div class="route-box__g1">

                                <a class="route-box__link" href="{{route('front.home')}}"><i
                                        class="fas fa-long-arrow-alt-left"></i>

                                    <span>CONTINUE SHOPPING</span></a>
                            </div>
                            {{-- <div class="route-box__g2">

                                <a class="route-box__link" href="cart.html"><i class="fas fa-trash"></i>

                                    <span>CLEAR CART</span></a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Content ======-->
    </div>

    <!--====== End - Section 2 ======-->

    @if (\Gloudemans\Shoppingcart\Facades\Cart::instance('shopping')->count() > 0)

        <!--====== Section 3 ======-->
        <div class="u-s-p-b-60">

            <!--====== Section Content ======-->
            <div class="section__content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 u-s-m-b-30">
                            <div class="f-cart">
                                <div class="row">
                                    <div class="col-lg-8 col-md-12 u-s-m-b-30">
                                        <div class="coupon-area">
                                            <h6>Enter your coupon code if you have one.</h6>
                                            <div class="coupon-field">
                                                <form action="{{ route('coupon.add') }}" id="coupon-form"
                                                    method="post">
                                                    @csrf
                                                    <label class="sr-only" for="coupon-code">Apply Coupon</label>
                                                    <input id="coupon-code" type="text" class="text-field"
                                                        name="code" placeholder="Coupon Code">
                                                    <button type="submit" class="coupon-btn button">Apply
                                                        Coupon</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 u-s-m-b-30">
                                        <div class="f-cart__pad-box">
                                            <div class="u-s-m-b-30">
                                                <table class="f-cart__table">
                                                    <tbody>
                                                        <tr>
                                                            <td>SUBTOTAL</td>
                                                            <td>Rs {{ Cart::subtotal() }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>SAVE AMOUNT</td>
                                                            <td>
                                                                @if (session()->has('coupon'))
                                                                    <span class="calc-text">Rs
                                                                        {{ session('coupon')['value'] }}</span>
                                                                @else
                                                                    <span class="calc-text">Rs 0</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>GRAND TOTAL</td>
                                                            <td>
                                                                @if (session()->has('coupon'))
                                                                    <span class="calc-text">Rs
                                                                        {{ number_format((float) str_replace(',', '', Cart::subtotal()) - session('coupon')['value'], 2) }}</span>
                                                                @else
                                                                    <span
                                                                        class="calc-text">{{ Cart::subtotal() }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div>
                                                <a href="{{ route('checkout') }}" class="btn btn--e-brand-b-2"
                                                    type="submit"> PROCEED TO
                                                    CHECKOUT</a>
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
    @endif
    <!--====== End - Section 3 ======-->
</div>
<!--====== End - App Content ======-->
