@extends('admin.master')

@section('title')
Dashboard | {{env('APP_NAME')}}
@endsection


@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-light" id="dash-daterange">
                            <span class="input-group-text bg-primary border-primary text-white">
                                                    <i class="mdi mdi-calendar-range font-13"></i>
                                                </span>
                        </div>
                        <a href="{{route('dashboard')}}" class="btn btn-primary ms-2" title="Reload">
                            <i class="mdi mdi-autorenew"></i>
                        </a>
                    </form>
                </div>
                <h4 class="page-title">Dashboard</h4>
                <p>{{Session::get('message')}}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12">

            <div class="row">
                <div class="col-sm-4">
                    <div class="card widget-flat text-bg-secondary">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="fw-normal mt-0" title="Number of Customers">This Month Total Delivered Orders</h5>
                            <h3 class="mt-3 mb-3">{{ $total_orders }}</h3>
                            <p class="mb-0 ">
                                @if ($percentage_delivered_change > 0)
                                    <span class="text-success me-2">
                            <i class="mdi mdi-arrow-up-bold"></i> {{ number_format($percentage_delivered_change, 2) }}%
                        </span>
                                @else
                                    <span class="text-danger me-2">
                            <i class="mdi mdi-arrow-down-bold"></i> {{ number_format($percentage_delivered_change, 2) }}%
                        </span>
                                @endif
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-sm-4">
                    <div class="card widget-flat text-bg-light">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="fw-normal mt-0" title="Number of Customers">This Month Total Pending Orders</h5>
                            <h3 class="mt-3 mb-3">{{ $total_pending_orders }}</h3>
                            <p class="mb-0 ">
                                @if ($percentage_pending_change > 0)
                                    <span class="text-success me-2">
                            <i class="mdi mdi-arrow-up-bold"></i> {{ number_format($percentage_pending_change, 2) }}%
                        </span>
                                @else
                                    <span class="text-danger me-2">
                            <i class="mdi mdi-arrow-down-bold"></i> {{ number_format($percentage_pending_change, 2) }}%
                        </span>
                                @endif
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-sm-4">
                    <div class="card widget-flat text-bg-primary">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-cart-plus widget-icon"></i>
                            </div>
                            <h5 class="fw-normal mt-0" title="Number of Orders">This Month Total Sell Amount</h5>
                            <h3 class="mt-3 mb-3">&#2547; {{ number_format($this_month_sell) }}</h3>
                            <p class="mb-0 ">
                                @if ($percentage_sell_change > 0)
                                    <span class="text-success me-2">
                            <i class="mdi mdi-arrow-up-bold"></i> {{ number_format($percentage_sell_change, 2) }}%
                        </span>
                                @else
                                    <span class="text-danger me-2">
                            <i class="mdi mdi-arrow-down-bold"></i> {{ number_format($percentage_sell_change, 2) }}%
                        </span>
                                @endif
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="card widget-flat text-bg-info">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-currency-usd widget-icon"></i>
                            </div>
                            <h5 class="fw-normal mt-0" title="Average Revenue">Total Sell Amount</h5>
                            <h3 class="mt-3 mb-3">&#2547; {{number_format($total_sell_amount, 2)}}</h3>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
                <div class="col-sm-4">
                    <div class="card widget-flat text-bg-secondary">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-currency-usd widget-icon"></i>
                            </div>
                            <h5 class="fw-normal mt-0" title="Average Revenue">Total Order</h5>
                            <h3 class="mt-3 mb-3">{{$total_order}}</h3>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-sm-4">
                    <div class="card widget-flat text-bg-success">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-pulse widget-icon"></i>
                            </div>
                            <h5 class="fw-normal mt-0" title="Growth">Total Products</h5>
                            <h3 class="mt-3 mb-3">{{$total_products}}</h3>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row -->

            <h4 class="page-title">Top products</h4>
            <hr>
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                @foreach($top_products->chunk(3) as $chunk) <!-- Grouping products into chunks of 3 -->
                    <div class="carousel-item @if ($loop->first) active @endif">
                        <div class="row">
                            @foreach($chunk as $product)
                                <div class="col-md-4">
                                    <a href="{{route('product.show', ['id' => $product->id, 'slug' => $product->id])}}" target="_blank">
                                        <div class="card">
                                            <img src="{{ asset($product->thumbnail_img) }}" class="d-block w-100" alt="{{ $product->name }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $product->name }}</h5>
                                                <p class="card-text">&#2547; {{ number_format($product->sell_price, 2) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Controls for the carousel -->
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>


        </div> <!-- end col -->
    </div>
    <!-- end row -->

@endsection
