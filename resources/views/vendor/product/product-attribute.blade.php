@extends('layouts.vendor')
@section('title', 'GoodGoods | Product Attribute')
@section('main-content')
    <div class="container-fluid">
        <div class="col-lg-12">
            @include('vendor.section.notify')
        </div>
        {{-- BreadCrumb  --}}
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                {{-- <nav aria-label="breadcrumb"> --}}
                <ul class="breadcrumb float-left">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="reply">Product Attribute</a></li>
                </ul>
                {{-- </nav> --}}
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 8px; font-weight: bold;">{{ ucfirst(@$product->title) }}
                        </h3>
                    </div>
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
                        <div class="row">
                            <div class="col-md-7">
                                <form action="{{ route('seller.addProduct.attribute', $product->id) }}" method="post">
                                    @csrf
                                    <div id="product-attribute" class="content"
                                        data-mfield-options='{"section": ".group","btnAdd":"#btnAdd-1","btnRemove":".btnRemove"}'>
                                        <div class="row">
                                            <div class="col-md-12"><button type="button" id="btnAdd-1"
                                                    class="btn btn-primary" style="margin-bottom: 10px"><i
                                                        class="fas fa-plus-circle"></i></button>
                                            </div>
                                        </div>
                                        <div class="row group">
                                            <div class="col-md-2">
                                                <label for="">Size</label>
                                                <input class="form-control form-control-sm" placeholder="eg. S"
                                                    name="size[]" type="text">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Original Price</label>
                                                <input class="form-control form-control-sm" type="number"
                                                    name="original_price[]" placeholder="eg. 1200">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Offer Price</label>
                                                <input class="form-control form-control-sm" type="number"
                                                    name="offer_price[]" placeholder="eg. 400">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Stock</label>
                                                <input class="form-control form-control-sm" type="number" name="stock[]"
                                                    placeholder="eg. 4">
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-danger btnRemove"
                                                    style="margin-top: 30px"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info" style="margin-top: 10px">Submit</button>
                                    <a href="{{ route('seller-product.index') }}" type="submit" class="btn btn-primary"
                                    style="margin-top:10px" value="Back">Back</a>
                                </form>
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <table id="" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">S.N.</th>
                                                <th>Original</th>
                                                <th>Offer</th>
                                                <th>Stock</th>
                                                <th style="width: 100px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($productattr) > 0)
                                                @foreach ($productattr as $item)
                                                    <tr>
                                                        <td>{{ $item->size }}</td>
                                                        <td>Rs {{ number_format($item->original_price, 2) }}</td>
                                                        <td>Rs {{ number_format($item->offer_price, 2) }}</td>
                                                        <td>{{ $item->stock }}</td>
                                                        <td>
                                                            <form action="{{ route('seller.product.attribute.destroy', $item->id) }}"
                                                                method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button class="btn btn-danger"
                                                                    onclick="return confirm('Do you want to delete this product?');"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/jquery.multifield.min.js') }}"></script>
    <script>
        $('#product-attribute').multifield();
    </script>
@endsection
