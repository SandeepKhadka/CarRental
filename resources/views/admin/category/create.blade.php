@extends('layouts.admin')
@section('title', 'GoodGoods | Category Form')
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
            <li class="breadcrumb-item active" aria-current="reply">{{ isset($category_data) ? 'Update' : 'Add' }}</li>
        </ol>
    </nav>
    <div class="content">
        <div>
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="m-0 text-left font-weight-bold" style="padding: 10px">Category
                        {{ isset($category_data) ? 'Update' : 'Add' }}</h4>
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

                            @if (isset($category_data))
                                <form action="{{ route('category.update', @$category_data->id) }}" method="post"
                                    class="form" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                @else
                                    <form action="{{ route('category.store') }}" method="post" class="form"
                                        enctype="multipart/form-data">
                                        @csrf
                            @endif
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="name">Title <span class="text-danger">*</span></label>
                                    <input type="text" id="title" name="title" value="{{ @$category_data->title }}"
                                        required class="form-control" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="image">Image <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="image" data-preview="holder"
                                                class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="image" class="form-control" type="text" name="image">
                                    </div>
                                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}
                            {{-- <img id="holder" /> --}}
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="summary">Summary</label>
                                    <textarea type="text" id="summary" name="summary" class="form-control" style="resize: none" rows="5"
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
                                    <select name="parent_id" id="parent_id" class="form-control form-control-sm">
                                        <option value="" disabled selected hidden>Select parent category</option>
                                        @if (isset($parent_cats))
                                            @foreach ($parent_cats as $cats)
                                                <option value="{{ $cats->id }}"
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
                                    <select name="apparel" id="apparel" class="form-control form-control-sm">
                                        <option value="" disabled selected hidden>Select apparel</option>
                                        @if (isset($apparels))
                                            @foreach ($apparels as $apparel)
                                                <option value="{{ $apparel->id }}"
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
                                    <label for="image">Image </label>
                                    <div class="input-group">
                                        <input id="image" class="form-control" type="file" name="image"
                                            {{ isset($category_data) ? '' : '' }}
                                            value="{{ @$category_data->image }}">
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
                            {{-- <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Condition <span class="text-danger">*</span></label>
                                    <div>
                                        <select name="condition" id="condition" class="form-control">
                                            <option value="" disabled selected hidden>Select condition</option>
                                            <option value="category"
                                                {{ @$category_data->condition == 'category' ? 'selected' : '' }}>Category
                                            </option>
                                            <option value="promo"
                                                {{ @$category_data->condition == 'promo' ? 'selected' : '' }}>
                                                Promote
                                            </option>
                                        </select>
                                        @error('condition')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div> --}}

                            {{-- @if (isset($category_data))
                                <div class="row">
                                    <div class=" form-group col-md-12">
                                        <label for="status ">Status</label>
                                        <select name="status" id="status" class="form-control form-control-sm">
                                            <option value="active"
                                                {{ @$category_data->status == 'active' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="inactive"
                                                {{ @$category_data->status == 'inactive' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif --}}
                            <button type="submit" class="btn btn-success float-right"
                                value="Sumbit">{{ isset($category_data) ? 'Update' : 'Add' }}</button>
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

{{-- @section('scripts')
    <script>
        alert('Hello');
        var loadFile = function(event){
            var holder = document.getElementById('holder');
            holder.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection --}}
