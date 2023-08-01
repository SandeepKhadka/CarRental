@extends('layouts.vendor')
@section('title', 'GoodGoods | Product List')
@section('scripts')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        $("input[name=toggle]").change(function() {
            var mode = $(this).prop("checked");
            var id = $(this).val();
            $.ajax({
                url: "{{ route('seller.product.status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    mode: mode,
                    id: id,
                },
                success: function(response) {
                    if (response.status) {
                        alert(response.msg);
                    } else {
                        alert('Please try again!');
                    }

                }
            });
        });
    </script>
@endsection
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
                    <li class="breadcrumb-item active" aria-current="reply">Product</a></li>
                </ul>
                <p class="float-right" style="margin: 10px">Total Products :
                    {{ \App\Models\Product::where('vendor_id', auth()->user()->id)->count() }}</p>
                {{-- </nav> --}}
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 8px; font-weight: bold;">Products</h3>
                        <a href="{{ route('seller-product.create') }}" class="btn btn-success float-right"
                            style="margin-bottom: 0px"><i class="fa fa-plus" style="font-size: 12px">
                                Add Product
                            </i>
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">S.N.</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Size</th>
                                    <th style="width: 90px">Condition</th>
                                    <th style="width: 100px">Status</th>
                                    <th style="width: 200px">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if (isset($product_data))
                                    @foreach ($product_data as $products => $product)
                                        {{-- {{ dd($product->image) }} --}}
                                        @php
                                            $photos = explode(',', $product->image);
                                        @endphp
                                        <tr>
                                            <td>{{ $products + 1 }}</td>
                                            <td>{{ $product->title }}</td>
                                            {{-- <td>
                                                <img src="{{ asset('/uploads/product/Thumb-' . $product->image) }}"
                                                    alt="product_image">
                                            </td> --}}
                                            @if (file_exists(public_path() . '/uploads/product/Thumb-' . $product->image))
                                                <td>
                                                    <img src="{{ asset('/uploads/product/Thumb-' . $product->image) }}"
                                                        alt="product_image">
                                                </td>
                                            @else
                                                <td>
                                                    <img src="{{ $photos[0] }}" alt="product_image"
                                                        style="max-width: 120px; max-height: 90px">
                                                </td>
                                            @endif
                                            <td>Rs {{ number_format($product->price, 2) }}</td>
                                            <td>{{ $product->discount }}%</td>
                                            <td>{{ $product->size }}</td>
                                            <td>
                                                @if (@$product->conditions == 'new')
                                                    <span class="badge bg-success">{{ ucfirst($product->conditions) }}
                                                    </span>
                                                @elseif(@$product->conditions == 'hot')
                                                    <span class="badge bg-danger">{{ ucfirst($product->conditions) }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-yellow">{{ ucfirst($product->conditions) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="toggle" value="{{ @$product->id }}"
                                                    data-toggle="switchbutton"
                                                    {{ @$product->status == 'active' ? 'checked' : '' }}
                                                    data-onlabel="Active" data-offlabel="Inactive" data-size="sm"
                                                    data-width="100" data-onstyle="success" data-offstyle="danger">
                                                {{-- <span
                                                    class="{{ @$product->status == 'active' ? 'badge bg-success' : 'badge bg-danger' }}">{{ ucfirst($product->status) }} --}}
                                            </td>
                                            <td>
                                                <a href="{{ route('seller.product.attribute', $product->id) }}"
                                                    class="btn btn-info" title="add attribute">
                                                    <i class="fa fa-plus-circle">

                                                    </i>
                                                </a>
                                                <a href="{{ route('seller-product.show', $product->id) }}"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-eye">

                                                    </i>
                                                </a>
                                                <a href="{{ route('seller-product.edit', $product->id) }}"
                                                    class="btn btn-success">
                                                    <i class="fa fa-pen">

                                                    </i>
                                                </a>
                                                <form action="{{ route('seller-product.destroy', $product->id) }}"
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
@endsection
