@extends('layouts.admin')
@section('title', 'GoodGoods | Shop List')
@section('scripts')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        $("input[name=toggle]").change(function() {
            var mode = $(this).prop("checked");
            var id = $(this).val();
            $.ajax({
                url: "{{ route('shop.status') }}",
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
                    <li class="breadcrumb-item active" aria-current="reply">Shop</a></li>
                </ul>
                <p class="float-right" style="margin: 10px">Total Shops : {{ \App\Models\Shop::count() }}</p>
                {{-- </nav> --}}
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 8px; font-weight: bold;">Shops</h3>
                    </div>
                    <div class="card-body">
                        <table id="table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">S.N.</th>
                                    <th>Shop Name</th>
                                    <th>Shop Owner</th>
                                    <th>Shop Banner</th>
                                    <th style="width: 90px">Shop Type</th>
                                    <th style="width: 100px">Status</th>
                                    <th style="width: 120px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($shop_data))
                                    @foreach ($shop_data as $shops => $shop)
                                        <tr>
                                            <td>{{ $shops + 1 }}</td>
                                            <td>{{ $shop->shop_name }}</td>
                                            <td>{{ \App\Models\ShopCorporateFile::where('shop_id',$shop->id)->value('legal_name') ??  ''}}</td>
                                            @if (file_exists(public_path() . '/uploads/shop/Thumb-' . $shop->image))
                                                <td>
                                                    <img src="{{ asset('/uploads/shop/Thumb-' . $shop->image) }}"
                                                        alt="banner_image">
                                                </td>
                                            @else
                                                <td>
                                                    <img src="{{ $shop->image}}"
                                                        alt="banner_image" style="max-width: 120px; max-height: 90px">
                                                </td>
                                            @endif
                                            <td>{{ ucfirst($shop->shop_type) }}</td>
                                            <td>
                                                <input type="checkbox" name="toggle" value="{{ @$shop->id }}"
                                                    data-toggle="switchbutton"
                                                    {{ @$shop->status == 'verified' ? 'checked' : '' }}
                                                    data-onlabel="Verified" data-offlabel="Not Verified" data-size="sm"
                                                    data-width="120" data-onstyle="success" data-offstyle="danger">
                                            </td>
                                            <td>
                                                <a href="{{ route('shop.show', $shop->id) }}" class="btn btn-primary">
                                                    <i class="fa fa-eye">

                                                    </i>
                                                </a>
                                                <form action="{{ route('shop.destroy', $shop->id) }}" method="post"
                                                    class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn btn-danger"
                                                        onclick="return confirm('Do you want to delete this shop?');"><i
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
