@extends('layouts.vendor')
@section('title', 'GoodGoods | Coupon list')
@section('scripts')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        $("input[name=toggle]").change(function() {
            var mode = $(this).prop("checked");
            var id = $(this).val();
            $.ajax({
                url: "{{ route('seller.coupon.status') }}",
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
                    <li class="breadcrumb-item active" aria-current="reply">Coupon</a></li>
                </ul>
                <p class="float-right" style="margin: 10px">Total Coupons : {{ \App\Models\Coupon::count() }}</p>
                {{-- </nav> --}}
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 8px; font-weight: bold;">Coupon</h3>
                        <a href="{{ route('seller-coupon.create') }}" class="btn btn-success float-right"
                            style="margin-bottom: 0px"><i class="fa fa-plus" style="font-size: 14px">
                                Add Coupon
                            </i>
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">S.N.</th>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th style="width: 100px">Status</th>
                                    <th style="width: 200px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($coupon_data))
                                    @foreach ($coupon_data as $coupons => $coupon)
                                        <tr>
                                            <td>{{ $coupons + 1 }}</td>
                                            <td>{{ $coupon->code }}</td>
                                            <td>
                                                @if (@$coupon->type == 'fixed')
                                                    <span class="badge bg-success">{{ ucfirst($coupon->type) }}
                                                    </span>
                                                @elseif(@$coupon->type == 'percent')
                                                    <span class="badge bg-danger">{{ ucfirst($coupon->type) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $coupon->value }}</td>
                                            <td>
                                                <input type="checkbox" name="toggle" value="{{ @$coupon->id }}"
                                                    data-toggle="switchbutton"
                                                    {{ @$coupon->status == 'active' ? 'checked' : '' }}
                                                    data-onlabel="Active" data-offlabel="Inactive" data-size="sm"
                                                    data-width="100" data-onstyle="success" data-offstyle="danger">
                                                {{-- <span
                                                    class="{{ @$coupon->status == 'active' ? 'badge bg-success' : 'badge bg-danger' }}">{{ ucfirst($coupon->status) }} --}}
                                            </td>
                                            <td>
                                                <a href="{{ route('seller-coupon.show', $coupon->id) }}" class="btn btn-primary">
                                                    <i class="fa fa-eye">

                                                    </i>
                                                </a>
                                                <a href="{{ route('seller-coupon.edit', $coupon->id) }}" class="btn btn-success">
                                                    <i class="fa fa-pen">

                                                    </i>
                                                </a>
                                                <form action="{{ route('seller-coupon.destroy', $coupon->id) }}" method="post"
                                                    class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn btn-danger"
                                                        onclick="return confirm('Do you want to delete this coupon?');"><i
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
