@extends('layouts.admin')
@section('title', 'GoodGoods | Banner List')
@section('scripts')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        $("input[name=toggle]").change(function() {
            var mode = $(this).prop("checked");
            var id = $(this).val();
            $.ajax({
                url: "{{ route('banner.status') }}",
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
            @include('admin.section.notify')
        </div>
        {{-- BreadCrumb  --}}
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                {{-- <nav aria-label="breadcrumb"> --}}
                <ul class="breadcrumb float-left">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="reply">Banner</a></li>
                </ul>
                <p class="float-right" style="margin: 10px">Total Banners : {{ \App\Models\Banner::count() }}</p>
                {{-- </nav> --}}
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 8px; font-weight: bold;">Banners</h3>
                        <a href="{{ route('banner.create') }}" class="btn btn-success float-right"
                            style="margin-bottom: 0px"><i class="fa fa-plus" style="font-size: 12px">
                                Add Banner
                            </i>
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">S.N.</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th style="width: 90px">Condition</th>
                                    <th style="width: 100px">Status</th>
                                    <th style="width: 120px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($banner_data))
                                    @foreach ($banner_data as $banners => $banner)
                                        <tr>
                                            <td>{{ $banners + 1 }}</td>
                                            <td>{{ $banner->title }}</td>
                                            <td>{!! html_entity_decode($banner->description) !!}</td>
                                            @if (file_exists(public_path() . '/uploads/banner/Thumb-' . $banner->image))
                                                <td>
                                                    <img src="{{ asset('/uploads/banner/Thumb-' . $banner->image) }}"
                                                        alt="banner_image">
                                                </td>
                                            @else
                                                <td>
                                                    <img src="{{ $banner->image}}"
                                                        alt="banner_image" style="max-width: 120px; max-height: 90px">
                                                </td>
                                            @endif
                                            <td><span
                                                    class="{{ @$banner->condition == 'banner' ? 'badge bg-success' : 'badge bg-danger' }}">{{ ucfirst($banner->condition) }}
                                            </td>
                                            <td>
                                                <input type="checkbox" name="toggle" value="{{ @$banner->id }}"
                                                    data-toggle="switchbutton"
                                                    {{ @$banner->status == 'active' ? 'checked' : '' }}
                                                    data-onlabel="Active" data-offlabel="Inactive" data-size="sm"
                                                    data-width="100" data-onstyle="success" data-offstyle="danger">
                                                {{-- <span
                                                    class="{{ @$banner->status == 'active' ? 'badge bg-success' : 'badge bg-danger' }}">{{ ucfirst($banner->status) }} --}}
                                            </td>
                                            <td>
                                                <a href="{{ route('banner.show', $banner->id) }}" class="btn btn-primary">
                                                    <i class="fa fa-eye">

                                                    </i>
                                                </a>
                                                <a href="{{ route('banner.edit', $banner->id) }}" class="btn btn-success">
                                                    <i class="fa fa-pen">

                                                    </i>
                                                </a>
                                                <form action="{{ route('banner.destroy', $banner->id) }}" method="post"
                                                    class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn btn-danger"
                                                        onclick="return confirm('Do you want to delete this banner?');"><i
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
