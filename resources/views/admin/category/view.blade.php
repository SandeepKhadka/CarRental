@extends('layouts.admin')
@section('title', 'GoodGoods | Category View')
@section('scripts')
    <script>
        if (window.$('#is_parent').is(':checked')) {
            window.$('#parent_cat_div').hide();
        }
        window.$('#is_parent').change(function() {
            window.$('#parent_cat_div').slideToggle();
        })
    </script>
@endsection
@section('main-content')
    <div class="col-lg-12">
        @include('admin.section.notify')
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Category</a></li>
            <li class="breadcrumb-item active" aria-current="reply">View</li>
        </ol>
    </nav>
    <div class="content">
        <div>
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="m-0 text-left font-weight-bold" style="padding: 10px">Category
                        View</h4>
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

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="name">Title</label>
                                    <input type="text" id="title" name="title" value="{{ @$category_data->title }}"
                                        class="form-control" disabled>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="summary">Summary</label>
                                    <textarea type="text" id="summary" name="summary" class="form-control" disabled style="resize: none" rows="5"
                                        cols="10">{{ @$category_data->summary }}</textarea>
                                    @error('summary')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="is_parent">Is parent</label>
                                    <input type="checkbox" id="is_parent" name="is_parent" {{-- value="{{ isset($category_data) ? @$category_data->is_parent : 1 }}" --}}
                                        value="1" {{ @$category_data->is_parent == 1 ? 'checked' : '' }}
                                        class="m-1">Yes
                                    @error('is_parent')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class=" form-group col-md-12" id="parent_cat_div">
                                    <label for="parent_id ">Parent Category</label>
                                    <select name="parent_id" disabled id="parent_id" class="form-control form-control-sm">
                                        <option value="" disabled selected hidden>Select parent category</option>
                                        @if (isset($parent_cats))
                                            @foreach ($parent_cats as $cats)
                                                <option value="{{ $cats->id }}" disabled
                                                    {{ old('parent_id') == $cats->id ? 'selected' : '' }}
                                                    {{ $cats->id == @$category_data->parent_id ? 'selected' : '' }}>
                                                    {{ $cats->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('parent_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class=" form-group col-md-12">
                                    <label for="apparel ">Apparel</label>
                                    <select name="apparel" disabled id="apparel" class="form-control form-control-sm">
                                        <option value="" disabled selected hidden>Select apparel</option>
                                        @if (isset($apparels))
                                            @foreach ($apparels as $apparel)
                                                <option value="{{ $apparel->id }}" disabled
                                                    {{ old('apparel') == $apparel->id ? 'selected' : '' }}
                                                    {{ $apparel->id == @$category_data->apparel ? 'selected' : '' }}>
                                                    {{ $apparel->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('apparel')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="image">Image</label>
                                    <div class="input-group">
                                        <input id="image" class="form-control" disabled type="file" name="image"
                                            {{ isset($category_data) ? '' : '' }} value="{{ @$category_data->image }}">
                                    </div>
                                    <div>
                                        @if (isset($category_data))
                                            <img src="{{ asset('/uploads/category/' . @$category_data->image) }}"
                                                style="margin-top:15px;max-height:100px;" alt="category_image">
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
                            <a href="{{ route('category.index') }}" type="submit" class="btn btn-primary float-right"
                                style="margin-right: 10px" value="Back">Back</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection