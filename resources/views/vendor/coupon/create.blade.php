@extends('layouts.vendor')
@section('title', 'GoodGoods | Coupon')
@section('scripts')
@endsection
@section('main-content')
    <div class="col-lg-12">
        @include('vendor.section.notify')
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('seller-coupon.index') }}"> Coupon</a></li>
            <li class="breadcrumb-item active" aria-current="reply">{{ isset($coupon_data) ? 'Update' : 'Add' }}</li>
        </ol>
    </nav>
    <div class="content">
        <div>
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="m-0 text-left font-weight-bold" style="padding: 10px"> Coupon
                        {{ isset($coupon_data) ? 'Update' : 'Add' }}</h4>
                    <div class="card">
                        <div class="card-body">
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
                            @if (isset($coupon_data))
                                <form action="{{ route('seller-coupon.update', @$coupon_data->id) }}" method="post" class="form"
                                    enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                @else
                                    <form action="{{ route('seller-coupon.store') }}" method="post" class="form"
                                        enctype="multipart/form-data">
                                        @csrf
                            @endif
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="code">Coupon Code <span class="text-danger">*</span></label>
                                    <input type="text" id="code" name="code" value="{{ @$coupon_data->code }}"
                                        required class="form-control" required>
                                    @error('code')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class=" form-group col-md-12">
                                    <label for="type ">Coupon Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-control form-control-sm">
                                        <option value="" disabled selected>--Select type--</option>
                                        <option value="fixed"
                                            {{ @$coupon_data->type == 'fixed' ? 'selected' : '' }}>Fixed
                                        </option>
                                        <option value="percent"
                                            {{ @$coupon_data->type == 'percent' ? 'selected' : '' }}>
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
                                    <input type="number" id="value" name="value"
                                        value="{{ @$coupon_data->value }}" step="any" min="0"
                                        class="form-control" required>
                                    @error('value')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success float-right"
                                value="Sumbit">{{ isset($coupon_data) ? 'Update' : 'Add' }}</button>
                            <a href="{{ route('seller-coupon.index') }}" type="submit" class="btn btn-primary float-right"
                                style="margin-right: 10px" value="Back">Back</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
