@extends('layouts.admin')
@section('title', 'GoodGoods | Order Form')
@section('scripts')
@endsection
@section('main-content')
    <div class="col-lg-12">
        @include('admin.section.notify')
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('seller-order.index') }}">Order</a></li>
            <li class="breadcrumb-item active" aria-current="reply">View</li>
        </ol>
    </nav>
    <div class="content">
        <div>
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="m-0 text-left font-weight-bold" style="padding: 10px">Order
                        View</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="order_number">Order Number</label>
                                    <input type="text" id="order_number" name="order_number" disabled
                                        value="{{ @$order_data->order_number }}" class="form-control">
                                    @error('order_number')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="user_id">User</label>
                                    <input type="text" id="user_id" name="user_id" disabled
                                        value={{ \App\Models\User::where('id', $order_data->user_id)->value('full_name') }}
                                        class="form-control">
                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="coupon">Coupon</label>
                                    <input type="text" id="coupon" name="coupon" disabled
                                        value="{{ @$order_data->coupon }}" class="form-control">
                                    @error('coupon')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="delivery_charge">Delivery Charge</label>
                                    <input type="text" id="delivery_charge" name="delivery_charge" disabled
                                        value="{{ @$order_data->delivery_charge }}" class="form-control">
                                    @error('delivery_charge')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="payment_method">Payment method</label>
                                    <input type="text" id="payment_method" name="payment_method" disabled
                                        value="{{ @$order_data->payment_method }}" class="form-control">
                                    @error('payment_method')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="payment_status">Payment status</label>
                                    <input type="text" id="payment_status" name="payment_status" disabled
                                        value="{{ @$order_data->payment_status }}" class="form-control">
                                    @error('payment_status')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="condition">Condition</label>
                                    <input type="text" id="condition" name="condition" disabled
                                        value="{{ @$order_data->condition }}" class="form-control">
                                    @error('condition')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="sub_total">Sub-total</label>
                                    <input type="text" id="sub_total" name="sub_total" disabled
                                        value="{{ @$order_data->sub_total }}" class="form-control">
                                    @error('sub_total')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="total_amount">Total Amount</label>
                                    <input type="text" id="total_amount" name="total_amount" disabled
                                        value="{{ @$order_data->total_amount }}" class="form-control">
                                    @error('total_amount')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <h5>Billing Details</h5>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="first_name">First Name</label>
                                    <input type="text" id="first_name" name="first_name" disabled
                                        value="{{ @$order_data->first_name }}" class="form-control">
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" disabled
                                        value="{{ @$order_data->last_name }}" class="form-control">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="email">Email</label>
                                    <input type="text" id="email" name="email" disabled
                                        value="{{ @$order_data->email }}" class="form-control">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="phone">Phone</label>
                                    <input type="text" id="phone" name="phone" disabled
                                        value="{{ @$order_data->phone }}" class="form-control">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="country">Country</label>
                                    <input type="text" id="country" name="country" disabled
                                        value="{{ @$order_data->country }}" class="form-control">
                                    @error('country')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="address">Street address</label>
                                    <input type="text" id="address" name="address" disabled
                                        value="{{ @$order_data->address }}" class="form-control">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city" disabled
                                        value="{{ @$order_data->city }}" class="form-control">
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="state">State</label>
                                    <input type="text" id="state" name="state" disabled
                                        value="{{ @$order_data->state }}" class="form-control">
                                    @error('state')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="postcode">Post code</label>
                                    <input type="text" id="postcode" name="postcode" disabled
                                        value="{{ @$order_data->postcode }}" class="form-control">
                                    @error('postcode')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="note">Note <span class="text-danger">*</span></label>
                                    <textarea type="text" id="note" name="note" class="form-control" disabled style="resize: none" rows="5"
                                        cols="10" placeholder="note">{{ @$order_data->note }}</textarea>
                                    @error('note')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <h5>Shipping Details</h5>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="first_name">First Name</label>
                                    <input type="text" id="first_name" name="first_name" disabled
                                        value="{{ @$order_data->sfirst_name }}" class="form-control">
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" disabled
                                        value="{{ @$order_data->slast_name }}" class="form-control">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="email">Email</label>
                                    <input type="text" id="email" name="email" disabled
                                        value="{{ @$order_data->semail }}" class="form-control">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="phone">Phone</label>
                                    <input type="text" id="phone" name="phone" disabled
                                        value="{{ @$order_data->sphone }}" class="form-control">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="country">Country</label>
                                    <input type="text" id="country" name="country" disabled
                                        value="{{ @$order_data->scountry }}" class="form-control">
                                    @error('country')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="address">Street address</label>
                                    <input type="text" id="address" name="address" disabled
                                        value="{{ @$order_data->saddress }}" class="form-control">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city" disabled
                                        value="{{ @$order_data->scity }}" class="form-control">
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="state">State</label>
                                    <input type="text" id="state" name="state" disabled
                                        value="{{ @$order_data->sstate }}" class="form-control">
                                    @error('state')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="postcode">Post code</label>
                                    <input type="text" id="postcode" name="postcode" disabled
                                        value="{{ @$order_data->spostcode }}" class="form-control">
                                    @error('postcode')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <a href="{{ route('seller-order.index') }}" type="submit" class="btn btn-primary float-right"
                                style="margin-right: 10px" disabled value="Back">Back</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
