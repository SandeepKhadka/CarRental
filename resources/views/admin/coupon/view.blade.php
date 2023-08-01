@extends('layouts.admin')
@section('title', 'GoodGoods | Coupon')
@section('scripts')
@endsection
@section('main-content')
    <div class="col-lg-12">
        @include('admin.section.notify')
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('coupon.index') }}"> Coupon</a></li>
            <li class="breadcrumb-item active" aria-current="reply">View</li>
        </ol>
    </nav>
    <div class="content">
        <div>
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="m-0 text-left font-weight-bold" style="padding: 10px"> Coupon
                        View</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="code">Coupon Code <span class="text-danger">*</span></label>
                                    <input type="text" id="code" name="code" value="{{ @$coupon_data->code }}"
                                        class="form-control" disabled>
                                    @error('code')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class=" form-group col-md-12">
                                    <label for="type ">Coupon Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-control form-control-sm" disabled>
                                        <option value="" disabled selected>--Select type--</option>
                                        <option value="fixed" {{ @$coupon_data->type == 'fixed' ? 'selected' : '' }}>Fixed
                                        </option>
                                        <option value="percent" {{ @$coupon_data->type == 'percent' ? 'selected' : '' }}>
                                            Percent
                                        </option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="value">Coupon Value <span class="text-danger">*</span></label>
                                    <input type="number" id="value" name="value" value="{{ @$coupon_data->value }}"
                                        step="any" min="0" class="form-control" disabled>
                                    @error('value')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @php
                                $created_by = \App\Models\User::where('id', @$coupon_data->user_id)->value('full_name') ?? '';
                            @endphp
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="value">Created By <span class="text-danger">*</span></label>
                                    <input type="text" id="value" name="value" value={{ @$created_by }}
                                        step="any" min="0" class="form-control" disabled>
                                    @error('value')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @if (@$coupon_data->customer_id != null && @$coupon_data->product_id != null)
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="value">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" id="value" name="value"
                                            value={{ \App\Models\Product::where('id', @$coupon_data->product_id)->value('title') }}
                                            step="any" min="0" class="form-control" disabled>
                                        @error('value')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="value">For <span class="text-danger">*</span></label>
                                        <input type="text" id="value" name="value"
                                            value={{ \App\Models\User::where('id', @$coupon_data->customer_id)->value('full_name') }}
                                            step="any" min="0" class="form-control" disabled>
                                        @error('value')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <a href="{{ route('coupon.index') }}" type="submit" class="btn btn-primary float-right"
                                style="margin-right: 10px" value="Back">Back</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
