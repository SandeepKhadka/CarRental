@extends('layouts.vendor')
@section('title', 'GoodGoods | Order List')
@section('scripts')
    {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        $("input[name=toggle]").change(function() {
            var mode = $(this).prop("checked");
            var id = $(this).val();
            $.ajax({
                url: "{{ route('seller-order.status') }}",
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
    </script> --}}
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
                    <li class="breadcrumb-item active" aria-current="reply">Order</a></li>
                </ul>
                <p class="float-right" style="margin: 10px">Total Orders : {{ \App\Models\Order::count() }}</p>
                {{-- </nav> --}}
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 8px; font-weight: bold;">Order List</h3>
                        <a href="{{ route('seller-order.index') }}" class="btn btn-primary float-right"
                            style="margin-bottom: 0px">
                            Back
                            </i>
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">S.N.</th>
                                    <th>Order Number</th>
                                    <th>User</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
                                    <th>Sub-total</th>
                                    <th>Total</th>
                                    <th style="width: 90px">Condition</th>
                                    <th style="width: 160px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($order_data))
                                    <tr>
                                        <td>{{ 1 }}</td>
                                        <td>{{ $order_data->order_number }}</td>
                                        <td>{{ \App\Models\User::where('id', $order_data->user_id)->value('full_name') }}
                                        </td>
                                        <td>{{ $order_data->payment_method }}</td>
                                        <td>
                                            @if (@$order_data->payment_status == 'paid')
                                                <span class="badge bg-success">{{ ucfirst($order_data->payment_status) }}
                                                </span>
                                            @elseif(@$order_data->payment_status == 'unpaid')
                                                <span class="badge bg-danger">{{ ucfirst($order_data->payment_status) }}
                                                </span>
                                            @elseif(@$order_data->payment_status == 'redeem')
                                                <span class="badge bg-warning">{{ ucfirst($order_data->payment_status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>Rs {{ number_format($order_data->sub_total, 2) }}</td>
                                        <td>Rs {{ number_format($order_data->total_amount, 2) }}</td>
                                        <td>
                                            @if (@$order_data->condition == 'delivered')
                                                <span class="badge bg-success">{{ ucfirst($order_data->condition) }}
                                                </span>
                                            @elseif(@$order_data->condition == 'shipped')
                                                <span class="badge bg-primary">{{ ucfirst($order_data->condition) }}
                                                </span>
                                            @elseif(@$order_data->condition == 'out for delivery')
                                                <span class="badge bg-info">{{ ucfirst($order_data->condition) }}
                                                </span>
                                            @elseif(@$order_data->condition == 'processing')
                                                <span class="badge bg-yellow">{{ ucfirst($order_data->condition) }}
                                                </span>
                                            @elseif(@$order_data->condition == 'cancelled')
                                                <span class="badge bg-danger">{{ ucfirst($order_data->condition) }}
                                                </span>
                                            @endif
                                        </td>
                                        {{-- <td>
                                                <input type="checkbox" name="toggle" value="{{ @$order_data->id }}"
                                                    data-toggle="switchbutton"
                                                    {{ @$order_data->status == 'active' ? 'checked' : '' }}
                                                    data-onlabel="Active" data-offlabel="Inactive" data-size="sm"
                                                    data-width="100" data-onstyle="success" data-offstyle="danger">
                                            </td> --}}
                                        <td>
                                            <a href="{{ route('seller.order.details', $order_data->id) }}"
                                                class="btn btn-primary">
                                                <i class="fa fa-eye">

                                                </i>
                                            </a>
                                            <a href="#" class="btn btn-warning" title="download">
                                                <i class="fa fa-download">

                                                </i>
                                            </a>
                                            {{-- <a href="{{ route('order_data.edit', $order_data->id) }}" class="btn btn-success">
                                                    <i class="fa fa-pen">

                                                    </i>
                                                </a> --}}
                                            <form action="{{ route('seller-order.destroy', $order_data->id) }}"
                                                method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger"
                                                    onclick="return confirm('Do you want to delete this order_data?');"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">S.N.</th>
                                    <th>Product Image</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($order_data))
                                    @foreach ($order_data->products as $item)
                                        @if ($item->vendor_id == auth()->user()->id)
                                            @php
                                                $photos = explode(',', $item->image);
                                            @endphp
                                            <tr>
                                                <td></td>
                                                @if (file_exists(public_path() . '/uploads/product/Thumb-' . $item->image))
                                                    <td>
                                                        <img src="{{ asset('/uploads/product/Thumb-' . $item->image) }}"
                                                            alt="product_image">
                                                    </td>
                                                @else
                                                    <td>
                                                        <img src="{{ $photos[0] }}" alt="product_image"
                                                            style="max-width: 120px; max-height: 90px">
                                                    </td>
                                                @endif
                                                <td>{{ $item->title }}
                                                </td>
                                                <td>{{ $item->pivot->quantity }}</td>
                                                <td>Rs {{ number_format($item->price, 2) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-5 border px-3 py-3">
                            {{-- <p>
                                <strong>Sub-total</strong>: Rs {{ number_format($order_data->sub_total, 2) }}
                            </p>
                            @if ($order_data->delivery_charge > 0)
                                <p>
                                    <strong>Shipping cost</strong>: Rs {{ number_format($order_data->delivery_charge, 2) }}
                                </p>
                            @endif
                            @if ($order_data->coupon > 0)
                                <p>
                                    <strong>Coupon</strong>: Rs {{ number_format($order_data->coupon, 2) }}
                                </p>
                            @endif
                            <p>
                                <strong>Total</strong>: Rs {{ number_format($order_data->total_amount, 2) }}
                            </p> --}}

                            {{-- <form action="{{ route('order.status', $order_data->id) }}" method="post">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order_data->id }}">
                                <strong>Status</strong>
                                <select name="condition" id="" class="form-control form-control-sm"
                                    style="margin: 10px 0px">
                                    <option value="Pending" disabled selected>Pending</option>
                                    <option value="shipped"
                                        {{ $order_data->condition == 'delivered' || $order_data->condition == 'cancelled' || $order_data->condition == 'out for delivery' ? 'disabled' : '' }}
                                        {{ $order_data->condition == 'shipped' ? 'selected' : '' }} hidden>Shipped</option>
                                    <option value="shipped"
                                        {{ $order_data->condition == 'delivered' || $order_data->condition == 'cancelled' ? 'disabled' : '' }}
                                        {{ $order_data->condition == 'out for delivery' ? 'selected' : '' }} hidden>Out for
                                        Delivery</option>
                                    <option value="processing"
                                        {{ $order_data->condition == 'delivered' || $order_data->condition == 'cancelled' || $order_data->condition == 'out for delivery' ? 'disabled' : '' }}
                                        {{ $order_data->condition == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="delivered" {{ $order_data->condition == 'cancelled' ? 'disabled' : '' }}
                                        {{ $order_data->condition == 'delivered' ? 'selected' : '' }} hidden>Delivered</option>
                                    <option value="cancelled" {{ $order_data->condition == 'delivered' ? 'disabled' : '' }}
                                        {{ $order_data->condition == 'cancelled' ? 'selected' : '' }} hidden>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-success" value="Sumbit">Update</button>
                            </form> --}}
                        </div>
                        <div class="col-1"></div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
