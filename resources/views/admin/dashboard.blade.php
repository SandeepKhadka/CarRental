@extends('layouts.admin')
@section('title', 'GoodGoods | Dashboard')
@section('main-content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-lg-12">
                @include('admin.section.notify')
            </div>
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <br>
                    <h3 class="m-0">Dashboard</h3>
                    <br>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ \App\Models\Order::where('condition', 'processing')->count() }}</h3>

                            <p>New Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('order.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ \App\Models\Shop::where('status', 'not verified')->count() }}</h3>

                            <p>New Seller Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('shop.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            @php
                                use Illuminate\Support\Carbon;
                                $oneWeekAgo = Carbon::now()->subDays(7);
                            @endphp
                            <h3>{{ \App\Models\User::where('created_at', '>=', $oneWeekAgo)->count() }}</h3>

                            <p>New Customer Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $monthlyUniqueVisitorsCount }}</h3>

                            <p>Monthly Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Sales
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body" style="height: 400px;">
                            <div class="tab-content p-0">
                                <div class="chart tab-pane active" id="revenue-chart">
                                    <canvas id="revenue-chart-canvas" style="width: 800px;"></canvas>
                                </div>
                                <div class="chart tab-pane" id="sales-chart">
                                    <canvas id="sales-chart-canvas"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.card -->
                    <br>
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Latest Orders</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Order No</th>
                                            <th>Placed By</th>
                                            <th>Condition</th>
                                            <th>Payment Status</th>
                                        </tr>
                                    </thead>
                                    @if (isset($orders) && $orders != null)
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td><a href="#">{{ @$order->order_number }}</a>
                                                    </td>
                                                    <td>{{ \App\Models\User::where('id', $order->user_id)->value('full_name') }}
                                                    <td>
                                                        @if (@$order->condition == 'delivered')
                                                            <span class="badge bg-success">{{ ucfirst($order->condition) }}
                                                            </span>
                                                        @elseif(@$order->condition == 'shipped')
                                                            <span class="badge bg-primary">{{ ucfirst($order->condition) }}
                                                            </span>
                                                        @elseif(@$order->condition == 'processing')
                                                            <span class="badge bg-yellow">{{ ucfirst($order->condition) }}
                                                            </span>
                                                        @elseif(@$order->condition == 'cancelled')
                                                            <span class="badge bg-danger">{{ ucfirst($order->condition) }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (@$order->payment_status == 'paid')
                                                            <span
                                                                class="badge bg-success">{{ ucfirst($order->payment_status) }}
                                                            </span>
                                                        @elseif(@$order->payment_status == 'unpaid')
                                                            <span
                                                                class="badge bg-danger">{{ ucfirst($order->payment_status) }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="{{ route('order.index') }}" class="btn btn-sm btn-secondary float-right">View
                                All Orders</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
                <section class="col-lg-5 connectedSortable">
                    <!-- solid sales graph -->
                    <div class="card bg-gradient-info">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-th mr-1"></i>
                                Sales Graph
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- <canvas id="line-chart"></canvas> --}}
                            <canvas class="chart" id="line-chart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class=""></i>
                                Online Store Visitors
                            </h3>
                            <!-- card tools -->
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                                    <i class="far fa-calendar-alt"></i>
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse"
                                    title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <div class="card-header border-0">
                            {{-- <div class="d-flex justify-content-between">
                                <h3 class="card-title"></h3>
                                <a href="javascript:void(0);">View Report</a>
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('line-chart').getContext('2d');

        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Sales',
                    data: @json($the_sales),
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                datasets: [{
                    label: 'Last Year',
                    data: [450, 350, 400, 600, 550, 700, 800, 850],
                    backgroundColor: 'rgba(255, 99, 132, 1)'
                }, {
                    label: 'This Year',
                    data: [500, 400, 450, 700, 600, 750, 900, 950],
                    backgroundColor: 'rgba(54, 162, 235, 1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        // Define data for the charts
        const areaData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Sales',
                data: [20, 25, 18, 30, 22, 35, 40],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        const donutData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                data: @json($revenue),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(255, 99, 132, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Create the charts
        const revenueChart = new Chart(document.getElementById('revenue-chart-canvas'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: @json($revenue),
                    // backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    backgroundColor: 'rgba(54, 162, 235, 1)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    fill: true, // Set to true to fill area under the line
                    tension: 0.4 // Set the curve tension
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                aspectRatio: 2, // Set the aspect ratio of the chart
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        const salesChart = new Chart(document.getElementById('sales-chart-canvas'), {
            type: 'doughnut',
            data: donutData,
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Switch between charts when tabs are clicked
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            const target = $(e.target).attr('href');

            switch (target) {
                case '#revenue-chart':
                    revenueChart.resize();
                    break;
                case '#sales-chart':
                    salesChart.resize();
                    break;
                default:
                    break;
            }
        });
    </script>
@endsection
