@extends('frontend.layouts.master')
@section('title', 'GoodGoods - Checkout')

@section('banner')
    <div class="cmt-page-title-row bg-base-dark cmt-bg cmt-bgimage-yes clearfix">
        <div class="cmt-titlebar-wrapper-bg-layer cmt-bg-layer"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="cmt-page-title-row-inner">
                        <div class="page-title-heading">
                            <h2 class="title" style="color: white">Checkout</h2>
                        </div>
                        <div class="breadcrumb-wrapper">
                            <span>
                                <a title="Homepage" href="{{ route('front.home') }}">Home</a>
                            </span>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<div class="col-lg-12">
    @include('frontend.layouts.notify')
</div>

@section('main-content')
    <!-- Checkout-Page -->
    <div class="page-checkout u-s-p-t-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <form action="{{ route('checkout.store') }}" method="post">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Oh sorry!</strong>There were some issues with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            @php
                                $name = explode(' ', $user->full_name);
                            @endphp
                            <!-- Billing-&-Shipping-Details -->
                            <div class="col-lg-6">
                                <h4 class="section-h4">Billing Details</h4>
                                <!-- Form-Fields -->
                                <div class="group-inline u-s-m-b-13">
                                    <div class="group-1 u-s-p-r-16">
                                        <label for="first_name">First Name
                                            <span class="astk">*</span>
                                        </label>
                                        <input type="text" id="first_name" class="text-field" value="{{ $name[0] }}"
                                            name="first_name" required>
                                    </div>
                                    <div class="group-2">
                                        <label for="last_name">Last Name
                                            <span class="astk">*</span>
                                        </label>
                                        <input type="text" id="last_name" class="text-field" value="{{ $name[1] }}"
                                            name="last_name" required>
                                    </div>
                                </div>
                                <div class="u-s-m-b-13">
                                    <label for="select-country">Country
                                        <span class="astk">*</span>
                                    </label>
                                    <div class="select-box-wrapper">
                                        <select class="select-box" id="country" name="country">
                                            <option selected="selected" value="Nepal">Nepal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="street-address u-s-m-b-13">
                                    <label for="req-st-address">Street Address
                                        <span class="astk">*</span>
                                    </label>
                                    <input type="text" id="address" class="text-field" value="{{ $user->address }}"
                                        required placeholder="Street Address" name="address">
                                    <label class="sr-only" for="opt-st-address"></label>
                                </div>
                                <div class="u-s-m-b-13">
                                    <label for="town-city">Town / City
                                        <span class="astk">*</span>
                                    </label>
                                    <input type="text" id="city" class="text-field" value="{{ $user->city }}"
                                        name="city" placeholder="city" required>
                                </div>
                                <div class="u-s-m-b-13">
                                    <label for="select-state">State
                                    </label>
                                    <div class="select-box-wrapper">
                                        <select class="select-box" id="state" name="state">
                                            <option selected="selected" value="">Choose your state...</option>
                                            <option value="gandaki" {{ $user->state == 'gandaki' ? 'selected' : '' }}>
                                                Gandaki</option>
                                            <option value="lumbini" {{ $user->state == 'lumbini' ? 'selected' : '' }}>
                                                Lumbini</option>
                                            <option value="bagmati" {{ $user->state == 'bagmati' ? 'selected' : '' }}>
                                                Bagmati</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="u-s-m-b-13">
                                    <label for="postcode">Postcode / Zip
                                    </label>
                                    <input type="text" id="postcode" class="text-field" value="{{ $user->postcode }}"
                                        name="postcode" placeholder="postcode">
                                </div>
                                <div class="group-inline u-s-m-b-13">
                                    <div class="group-1 u-s-p-r-16">
                                        <label for="email">Email address
                                            <span class="astk">*</span>
                                        </label>
                                        <input type="text" id="email" class="text-field" value="{{ $user->email }}"
                                            readonly name="email" required>
                                    </div>
                                    <div class="group-2">
                                        <label for="phone">Phone
                                            <span class="astk">*</span>
                                        </label>
                                        <input type="text" id="phone" class="text-field"
                                            value="{{ $user->phone }}" name="phone" placeholder="phone" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="order-notes">Order Notes</label>
                                    <textarea class="text-area" id="order-notes" name="note"placeholder="Write a short note for your order delivery."
                                        style="resize: none"></textarea>
                                </div>
                                <br>
                                <!-- Form-Fields /- -->
                                <h4 class="section-h4">Shipping Details</h4>
                                <div class="u-s-m-b-24">
                                    <input type="checkbox" class="check-box" id="ship-to-different-address">
                                    <label class="label-text" for="ship-to-different-address">Ship to a same
                                        address?</label>
                                </div>
                                <div>
                                    <!-- Form-Fields -->
                                    <div class="group-inline u-s-m-b-13">
                                        <div class="group-1 u-s-p-r-16">
                                            <label for="first-name">First Name
                                                <span class="astk">*</span>
                                            </label>
                                            <input type="text" id="sfirst_name" class="text-field"
                                                value="{{ $name[0] }}" name="sfirst_name" placeholder="First Name"
                                                required>
                                        </div>
                                        <div class="group-2">
                                            <label for="slast_name">Last Name
                                                <span class="astk">*</span>
                                            </label>
                                            <input type="text" id="slast_name" class="text-field"
                                                value="{{ $name[1] }}" name="slast_name" placeholder="Last Name"
                                                required>
                                        </div>
                                    </div>
                                    <div class="u-s-m-b-13">
                                        <label for="scountry">Country
                                            <span class="astk">*</span>
                                        </label>
                                        <div class="select-box-wrapper">
                                            <select class="select-box" id="scountry" name="scountry">
                                                <option selected="selected" value="Nepal">Nepal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="street-address u-s-m-b-13">
                                        <label for="req-st-address">Street Address
                                            <span class="astk">*</span>
                                        </label>
                                        <input type="text" id="saddress" class="text-field"
                                            value="{{ $user->sstreet }}" placeholder="Street No" name="saddress"
                                            required>
                                        <label class="sr-only" for="opt-st-address"></label>
                                    </div>
                                    <div class="u-s-m-b-13">
                                        <label for="town-city">Town / City
                                            <span class="astk">*</span>
                                        </label>
                                        <input type="text" id="scity" class="text-field"
                                            value="{{ $user->scity }}" name="scity" placeholder="city" required>
                                    </div>
                                    <div class="u-s-m-b-13">
                                        <label for="select-state">State
                                        </label>
                                        <div class="select-box-wrapper">
                                            <select class="select-box" id="sstate" name="sstate">
                                                <option selected="selected" value="" disabled>Choose your state...
                                                </option>
                                                <option value="gandaki"
                                                    {{ $user->sstate == 'gandaki' ? 'selected' : '' }}>
                                                    Gandaki</option>
                                                <option value="lumbini"
                                                    {{ $user->sstate == 'lumbini' ? 'selected' : '' }}>
                                                    Lumbini</option>
                                                <option value="bagmati"
                                                    {{ $user->sstate == 'bagmati' ? 'selected' : '' }}>
                                                    Bagmati</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="u-s-m-b-13">
                                        <label for="spostcode">Postcode / Zip
                                        </label>
                                        <input type="text" id="spostcode" class="text-field"
                                            value="{{ $user->spostcode }}" name="spostcode" placeholder="postcode">
                                    </div>
                                    <div class="group-inline u-s-m-b-13">
                                        <div class="group-1 u-s-p-r-16">
                                            <label for="semail">Email address
                                                <span class="astk">*</span>
                                            </label>
                                            <input type="text" id="semail" class="text-field"
                                                value="{{ $user->email }}" readonly name="semail" placeholder="email"
                                                required>
                                        </div>
                                        <div class="group-2">
                                            <label for="sphone">Phone
                                                <span class="astk">*</span>
                                            </label>
                                            <input type="text" id="sphone" class="text-field"
                                                value="{{ $user->phone }}" name="sphone" placeholder="phone" required>
                                        </div>
                                    </div>
                                    <!-- Form-Fields /- -->
                                </div>
                            </div>
                            <!-- Billing-&-Shipping-Details /- -->
                            <!-- Checkout -->
                            <div class="col-lg-6">
                                <h4 class="section-h4">Your Order</h4>
                                <div class="order-table">
                                    <table class="u-s-m-b-13">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (\Gloudemans\Shoppingcart\Facades\Cart::instance('shopping')->content() as $item)
                                                @php
                                                    $title_size = explode(',', @$item->name);
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <h6 class="order-h6">{{ $title_size[0] }}</h6>
                                                        <span class="order-span-quantity"> x {{ $item->qty }}</span>
                                                    </td>
                                                    <td>
                                                        <h6 class="order-h6">{{ $item->price }}</h6>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td>
                                                    <h3 class="order-h3">Subtotal</h3>
                                                </td>
                                                <td>
                                                    <h3 class="order-h3">{{ Cart::subtotal() }}</h3>
                                                    <input type="hidden" name="sub_total" id=""
                                                        value={{ Cart::subtotal() }}>
                                                </td>
                                            </tr>
                                            @php
                                                // add 3 days to date
                                                $ArrivalDate1 = Date('d M', strtotime('+3 days'));
                                                $ArrivalDate2 = Date('d M', strtotime('+5 days'));
                                            @endphp
                                            <tr>
                                                <td>
                                                    <h3 class="order-h3">Product Arrival</h3>
                                                </td>
                                                <td>
                                                    <h3 class="order-h3">{{ $ArrivalDate1 . ' - ' . $ArrivalDate2 }}</h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h3 class="order-h3">Shipping Amount</h3>
                                                </td>
                                                <td>
                                                    <h3 class="order-h3">Rs 100</h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h3 class="order-h3">Total</h3>
                                                </td>
                                                <td>
                                                    @if (session()->has('coupon'))
                                                        <h3 class="order-h3">
                                                            {{ number_format((float) str_replace(',', '', Cart::subtotal()) - session('coupon')['value'] + 100, 2) }}
                                                        </h3>
                                                    @else
                                                        <h3 class="order-h3">
                                                            {{ number_format((float) str_replace(',', '', Cart::subtotal()) + 100, 2) }}
                                                        </h3>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="u-s-m-b-13">
                                        <label class="label-text no-color">Choose Payment Method
                                        </label>
                                    </div>
                                    <div class="u-s-m-b-13">
                                        <input type="radio" class="radio-box" name="payment_method" value="cod"
                                            id="cash-on-delivery">
                                        <label class="label-text" for="cash-on-delivery">Cash on Delivery</label>
                                    </div>
                                    <div class="u-s-m-b-13">
                                        <input type="radio" class="radio-box" name="payment_method" id="esewa"
                                            value="esewa">
                                        <label class="label-text" for="esewa">Esewa</label>
                                    </div>
                                    {{-- <div class="u-s-m-b-13">
                                        <input type="radio" class="radio-box" name="payment_method" id="khalti"
                                            value="khalti">
                                        <label class="label-text" for="khalti">Khalti</label>
                                    </div> --}}
                                    <button type="submit" class="button button-outline-secondary">Place Order</button>
                                </div>
                            </div>
                            <!-- Checkout /- -->
                        </div>
                    </form>
                </div>
            </div>
            <hr>
        </div>
    </div>
    <!-- Checkout-Page /- -->
@endsection

@section('scripts')
    <script script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        $('#ship-to-different-address').on('change', function(e) {
            e.preventDefault();
            if (this.checked) {
                $('#sfirst_name').val($('#first_name').val());
                $('#slast_name').val($('#last_name').val());
                $('#scountry').val($('#country').val());
                $('#saddress').val($('#address').val());
                $('#spostcode').val($('#postcode').val());
                $('#semail').val($('#email').val());
                $('#sphone').val($('#phone').val());
                $('#scity').val($('#city').val());
                $('#sstate').val($('#state').val());

            } else {
                $('#sfirst_name').val("");
                $('#slast_name').val("");
                $('#scountry').val("");
                $('#saddress').val("");
                $('#spostcode').val("");
                $('#semail').val("");
                $('#sphone').val("");
                $('#scity').val("");
                $('#sstate').val("");
            }
        })
    </script>
@endsection
