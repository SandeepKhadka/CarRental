@extends('layouts.admin')
@section('title', 'GoodGoods | Banner Form')
@section('scripts')
    <script></script>
@endsection
@section('main-content')
    <div class="col-lg-12">
        @include('admin.section.notify')
    </div>
    <div class="content">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="m-0 text-left font-weight-bold" style="padding: 10px">Banner
                        View</h4>
                    <div class="card">
                        <div class="card-body">
                            @if (isset($banner_data))
                                <form action="{{ route('banner.update', @$banner_data->id) }}" method="post" class="form"
                                    enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                @else
                                    <form action="{{ route('banner.store') }}" method="post" class="form"
                                        enctype="multipart/form-data">
                                        @csrf
                            @endif
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="name">Title <span class="text-danger">*</span></label>
                                    <input type="text" id="title" name="title" value="{{ @$banner_data->title }}"
                                        required class="form-control" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="image">Image <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input id="image" class="form-control" type="file" name="image" {{ isset($banner_data) ? '' : 'required' }}>
                                    </div>
                                    <img id="holder" src="#" style="margin-top:15px;max-height:100px;"
                                        alt="No preview image" />
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description</label>
                                    <textarea type="text" id="description" name="description" class="form-control" style="resize: none" rows="5"
                                        cols="10">{{ @$banner_data->description }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Condition <span class="text-danger">*</span></label>
                                    <div>
                                        <select name="condition" id="condition" class="form-control">
                                            <option value="" disabled selected hidden>Select condition</option>
                                            <option value="banner"
                                                {{ @$banner_data->condition == 'banner' ? 'selected' : '' }}>Banner
                                            </option>
                                            <option value="promo"
                                                {{ @$banner_data->condition == 'promo' ? 'selected' : '' }}>
                                                Promote
                                            </option>
                                        </select>
                                        @error('condition')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('banner.index') }}" type="submit" class="btn btn-primary float-right"
                                style="margin-right: 10px" value="Back">Back</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
