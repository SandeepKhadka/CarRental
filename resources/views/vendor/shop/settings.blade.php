@extends('layouts.vendor')
@section('title', 'GoodGoods | Shop Setting')

@section('main-content')
    <!-- Content Wrapper. Contains page content -->
    @if (isset($shop_address) && $shop_address != null)
        <form action="{{ route('update.shop.details', @$shop_id) }}" method="post" class="form"
            enctype="multipart/form-data">
            {{-- @method('put') --}}
            @csrf
        @else
            <form action="{{ route('store.shop.details') }}" method="post" class="form" enctype="multipart/form-data">
                @csrf
    @endif
    {{-- <form action="{{ route('store.shop.details') }}" method="post" enctype="multipart/form-data">
        @csrf --}}
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
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="col-lg-12">
                    @include('vendor.section.notify')
                </div>
                <div class="row mb-2">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        {{-- <nav aria-label="breadcrumb"> --}}
                        <ul class="breadcrumb float-left">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="reply">Shop Details</a></li>
                        </ul>
                        {{-- </nav> --}}
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- address card -->
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Shop Address Book</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button> --}}
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address <span class="text-danger">*</span></label>
                                    <input type="text" id="address" name="address"
                                        value="{{ @$shop_address->address }}" required class="form-control"
                                        placeholder="Address">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country Region <span class="text-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" name="country_region">
                                        <option value="Nepal" selected="selected">Nepal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Province <span class="text-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" name="province">
                                        <option value="" disabled selected>--Select Province--</option>
                                        <option value="province_1"
                                            {{ @$shop_address->province == 'province_1' ? 'selected' : '' }}>Province 1
                                        </option>
                                        <option value="province_2"
                                            {{ @$shop_address->province == 'province_2' ? 'selected' : '' }}>Province 2
                                        </option>
                                        <option value="province_3"
                                            {{ @$shop_address->province == 'province_3' ? 'selected' : '' }}>Province 3
                                        </option>
                                        <option value="province_4"
                                            {{ @$shop_address->province == 'province_4' ? 'selected' : '' }}>Province 4
                                        </option>
                                        <option value="province_5"
                                            {{ @$shop_address->province == 'province_5' ? 'selected' : '' }}>Province 5
                                        </option>
                                        <option value="province_6"
                                            {{ @$shop_address->province == 'province_6' ? 'selected' : '' }}>Province 6
                                        </option>
                                        <option value="province_7"
                                            {{ @$shop_address->province == 'province_7' ? 'selected' : '' }}>Province 7
                                        </option>
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>City <span class="text-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" name="city">
                                        <option value="" disabled selected>--Select City--</option>
                                        <option value="pokhara" {{ @$shop_address->city == 'pokhara' ? 'selected' : '' }}>
                                            Pokhara</option>
                                        <option value="kathmandu"
                                            {{ @$shop_address->city == 'kathmandu' ? 'selected' : '' }}>Kathmandu
                                        </option>
                                        <option value="dharan" {{ @$shop_address->city == 'dharan' ? 'selected' : '' }}>
                                            Dharan</option>
                                    </select>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Area <span class="text-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" name="area">
                                        <option value="" disabled selected>--Select Area--</option>
                                        <option value="lakeside"
                                            {{ @$shop_address->area == 'lakeside' ? 'selected' : '' }}>Lakeside
                                        </option>
                                        <option value="new_road"
                                            {{ @$shop_address->area == 'new_road' ? 'selected' : '' }}>New Road
                                        </option>
                                        <option value="bhaktapur"
                                            {{ @$shop_address->area == 'bhaktapur' ? 'selected' : '' }}>Bhaktapur
                                        </option>
                                    </select>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.address card -->

                <!-- file card -->
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Shop Corporate File</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button> --}}
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="legal_name">Legal Name <span class="text-danger">*</span></label>
                                    <input type="text" id="legal_name" name="legal_name"
                                        value="{{ @$shop_file->legal_name }}" required class="form-control"
                                        placeholder="Address">
                                    @error('legal_name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pan_no">Pan No <span class="text-danger">*</span></label>
                                    <input type="text" id="pan_no" name="pan_no"
                                        value="{{ @$shop_file->pan_no }}" required class="form-control"
                                        placeholder="Address">
                                    @error('pan_no')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Business Document <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input id="image" class="form-control" type="file" name="image"
                                            value="{{ @$shop_file->image }}"
                                            {{ isset($shop_file) && $shop_file != null ? '' : 'required' }}>
                                    </div>
                                    <div>
                                        @if (isset($shop_file) && $shop_file != null)
                                            <img src="{{ asset('/uploads/shop/' . @$shop_file->image) }}"
                                                style="margin-top:15px;max-height:100px;" alt="banner_image">
                                        @else
                                            <img id="holder" src="#" style="margin-top:15px;max-height:100px;"
                                                alt="No preview image" />
                                        @endif
                                    </div>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.file card -->

                <!-- bank card -->
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Shop Bank Detail</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button> --}}
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Account Type <span class="text-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" name="account_type">
                                        <option value="" disabled selected>--Select Account Type--</option>
                                        <option value="saving"
                                            {{ @$shop_bank->account_type == 'saving' ? 'selected' : '' }}>Saving
                                        </option>
                                        <option value="fixed_deposit"
                                            {{ @$shop_bank->account_type == 'fixed_deposit' ? 'selected' : '' }}>Fixed
                                            Deposit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_no">Account No <span class="text-danger">*</span></label>
                                    <input type="text" id="account_no" name="account_no"
                                        value="{{ @$shop_bank->account_no }}" required class="form-control"
                                        placeholder="Address">
                                    @error('account_no')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Bank Name <span class="text-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" name="bank_name">
                                        <option value="" disabled selected>--Select Bank--</option>
                                        <option value="mbl" {{ @$shop_bank->bank_name == 'mbl' ? 'selected' : '' }}>
                                            Machhapuchchhre
                                            Bank Limited</option>
                                        <option value="nbl" {{ @$shop_bank->bank_name == 'nbl' ? 'selected' : '' }}>
                                            Nepal Bank Ltd.
                                        </option>
                                        <option value="sbl" {{ @$shop_bank->bank_name == 'sbl' ? 'selected' : '' }}>
                                            Siddhartha Bank
                                            Limited</option>
                                        <option value="nb" {{ @$shop_bank->bank_name == 'nb' ? 'selected' : '' }}>
                                            Nabil Bank</option>
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Branch Name <span class="text-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" name="branch_name">
                                        <option value="" disabled selected>--Select Branch--</option>
                                        <option value="plb" {{ @$shop_bank->branch_name == 'plb' ? 'selected' : '' }}>
                                            Pokhara Lakeside
                                            Branch</option>
                                        <option value="pnb" {{ @$shop_bank->branch_name == 'pnb' ? 'selected' : '' }}>
                                            Pokhara Newroad
                                            Branch</option>
                                        <option value="kbb" {{ @$shop_bank->branch_name == 'kbb' ? 'selected' : '' }}>
                                            Kathmandu
                                            Bhaktapur Branch</option>
                                    </select>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.bank card -->

                <!-- bank card -->
                <div class="card card-default">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success float-right"
                            value="Sumbit">{{ isset($shop_address) && $shop_address != null ? 'Update' : 'Add' }}</button>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.bank card -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    </form>
    <!-- /.content-wrapper -->
@endsection
