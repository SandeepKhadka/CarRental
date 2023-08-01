@extends('layouts.admin')
@section('title', 'GoodGoods | Product Form')
@section('scripts')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        window.$('#child_cat_div').hide();
        var child_cat_id = {{ @$product_data->child_cat_id }}
        $('#cat_id').change(function() {
            var cat_id = $(this).val();
            if (cat_id != null) {
                $.ajax({
                    url: "/admin/category/" + cat_id + "/child",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        cat_id: cat_id,
                    },
                    success: function(response) {
                        var html_option = "<option value=''>---Child Category---</option>";
                        if (response.status) {
                            window.$('#child_cat_div').slideToggle();
                            $.each(response.data, function(id, title) {
                                html_option += "<option value='" + id + "' " + (child_cat_id ==
                                        id ? 'selected' : '') + ">" + title +
                                    "</option>"
                            });
                        } else {
                            window.$('#child_cat_div').hide();
                        }
                        $('#child_cat_id').html(html_option);
                    }
                });
            }
        });
        if (child_cat_id != null) {
            $('#cat_id').change();
        }
    </script>
@endsection
@section('main-content')
    <div class="col-lg-12">
        @include('admin.section.notify')
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></li>
            <li class="breadcrumb-item active" aria-current="reply">View Product</li>
        </ol>
    </nav>
    <div class="content">
        <div>
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="m-0 text-left font-weight-bold" style="padding: 10px">Product
                        View</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" id="title" name="title" value="{{ @$product_data->title }}"
                                        class="form-control" disabled placeholder="Title">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="image">Image <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input id="image" class="form-control" type="file" name="image" disabled>
                                    </div>
                                    <div>
                                        <div>
                                            @if (isset($product_data))
                                                <img src="{{ asset('/uploads/product/' . @$product_data->image) }}"
                                                    style="margin-top:15px;max-height:100px;" alt="banner_image">
                                            @else
                                                <img id="holder" src="#" style="margin-top:15px;max-height:100px;"
                                                    alt="" />
                                            @endif
                                        </div>
                                    </div>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="summary">Summary <span class="text-danger">*</span></label>
                                    <textarea type="text" id="summary" name="summary" class="form-control" style="resize: none" rows="5"
                                        cols="10" placeholder="summary">{{ @$product_data->summary }}</textarea>
                                    @error('summary')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description</label>
                                    <textarea type="text" id="description" name="description" class="form-control" style="resize: none" rows="5"
                                        cols="10" placeholder="description">{{ @$product_data->description }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="stock">Stock</label>
                                    <input type="number" id="stock" name="stock" value="{{ @$product_data->stock }}"
                                        class="form-control" disabled placeholder="stock">
                                    @error('stock')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="price">Price <span class="text-danger">*</span></label>
                                    <input type="number" step="any" id="price" name="price"
                                        value="{{ @$product_data->price }}" class="form-control" disabled
                                        placeholder="price">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="points">Redeem Points <span class="text-danger">*</span></label>
                                    <input type="number" step="any" id="points" name="points"
                                        value="{{ @$product_data->points }}" required class="form-control"
                                        placeholder="Enter Redeem points">
                                    @error('points')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="discount">Discount</label>
                                    <input type="number" step="any" id="discount" name="discount"
                                        value="{{ @$product_data->discount }}" class="form-control" disabled
                                        placeholder="discount">
                                    @error('discount')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Brands</label>
                                    <div>
                                        <select disabled name="brand_id" id="brand_id" class="form-control">
                                            <option value="" disabled selected hidden>Select brand</option>
                                            @foreach (\App\Models\Brand::get() as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ old('brand_id') == $brand->id ? 'selected' : '' }}
                                                    {{ $brand->id == @$product_data->brand_id ? 'selected' : '' }}>
                                                    {{ $brand->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Category <span class="text-danger">*</span></label>
                                    <div>
                                        <select disabled name="cat_id" id="cat_id" class="form-control">
                                            <option value="" disabled selected hidden>Select category</option>
                                            @foreach (\App\Models\Category::get() as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ old('cat_id') == $cat->id ? 'selected' : '' }}
                                                    {{ $cat->id == @$product_data->cat_id ? 'selected' : '' }}>
                                                    {{ $cat->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cat_id')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12" id="child_cat_div">
                                    <label>Child category <span class="text-danger">*</span></label>
                                    <div>
                                        <select disabled name="child_cat_id" id="child_cat_id" class="form-control">

                                        </select>
                                        @error('child_cat_id')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Size</label>
                                    <div>
                                        <select disabled name="size" id="size" class="form-control">
                                            <option value="" disabled selected hidden>Select size</option>
                                            <option value="S" {{ @$product_data->size == 'S' ? 'selected' : '' }}>
                                                Small
                                            </option>
                                            <option value="M" {{ @$product_data->size == 'M' ? 'selected' : '' }}>
                                                Medium
                                            </option>
                                            <option value="L" {{ @$product_data->size == 'L' ? 'selected' : '' }}>
                                                Large
                                            </option>
                                            <option value="XL" {{ @$product_data->size == 'XL' ? 'selected' : '' }}>
                                                Extra Large
                                            </option>
                                        </select>
                                        @error('size')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Condition</label>
                                    <div>
                                        <select disabled name="conditions" id="conditions" class="form-control">
                                            <option value="" disabled selected hidden>Select conditions</option>
                                            <option value="hot"
                                                {{ @$product_data->conditions == 'new' ? 'selected' : '' }}>New
                                            </option>
                                            <option value="hot"
                                                {{ @$product_data->conditions == 'hot' ? 'selected' : '' }}>
                                                Hot
                                            </option>
                                            <option value="winter"
                                                {{ @$product_data->conditions == 'winter' ? 'selected' : '' }}>
                                                Winter
                                            </option>
                                        </select>
                                        @error('conditions')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('product.index') }}" type="submit" class="btn btn-primary float-right"
                                style="margin-right: 10px" value="Back">Back</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection