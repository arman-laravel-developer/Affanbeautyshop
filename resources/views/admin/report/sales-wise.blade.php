@extends('admin.master')

@section('title')
    Sales Report Analysis | {{env('APP_NAME')}}
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
                        <a href="javascript: void(0);" class="btn btn-primary ms-2">
                            <i class="mdi mdi-autorenew"></i>
                        </a>
                        <a href="javascript: void(0);" class="btn btn-primary ms-1">
                            <i class="mdi mdi-filter-variant"></i>
                        </a>
                    </form>
                </div>
                <h4 class="page-title">Sales Report Analysis</h4>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-9">
                            <form action="{{ route('report.sales-wise') }}" method="GET" id="filterForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <select name="order_status" id="order_status" class="form-control" onchange="this.form.submit()">
                                            <option value="" >Select order status</option>
                                            <option value="pending" {{ request('order_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ request('order_status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ request('order_status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ request('order_status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancel" {{ request('order_status') == 'cancel' ? 'selected' : '' }}>Canceled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="payment_status" id="payment_status" class="form-control" onchange="this.form.submit()">
                                            <option value="" >Select payment status</option>
                                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="un_paid" {{ request('payment_status') == 'un_paid' ? 'selected' : '' }}>Un-paid</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="date_range" name="date_range" placeholder="Select date range" autocomplete="off" />
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <div class="text-sm-end">
                                <button type="button" onclick="event.preventDefault(); document.getElementById('filterForm').submit();" class="btn btn-success mb-2 me-1">
                                    <i class="mdi mdi-filter"></i>
                                </button>
                                <a href="{{route('report.sales')}}" class="btn btn-danger mb-2">reset</a>
                                <a href="#" type="button" class="btn btn-light mb-2" onclick="event.preventDefault(); document.getElementById('exportForm').submit();">Export</a>
                                <form action="{{route('report.filtered-sales-export')}}" method="GET" id="exportForm">
                                    @csrf
                                    <input type="hidden" name="order_status" value="{{$order_status}}">
                                    <input type="hidden" name="payment_status" value="{{$payment_status}}">
                                    <input type="hidden" name="date_range" value="{{$selectedDate}}">
                                </form>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered w-100 dt-responsive nowrap" >
                            <thead class="table-light">
                            <tr>
                                <th class="all" style="width: 20px;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck1">
                                        <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                    </div>
                                </th>
                                <th class="all">Order Code</th>
                                <th>Num of Qty</th>
                                <th>Order Total</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="customCheck2">
                                            <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        {{$order->order_code}}
                                    </td>
                                    <td>
                                        {{$order->total_qty}}
                                    </td>
                                    <td>
                                        &#2547; {{number_format($order->grand_total)}}
                                    </td>
                                    <td>
                                        {{$order->created_at->format('d/m/Y')}}
                                    </td>
                                    <td>
                                        @if($order->order_status == 'delivered')
                                            <span class="badge bg-success">Deliveried</span>
                                        @elseif($order->order_status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($order->order_status == 'proccessing')
                                            <span class="badge bg-black">Proccessing</span>
                                        @elseif($order->order_status == 'shipped')
                                            <span class="badge bg-primary">Shipped</span>
                                        @else
                                            <span class="badge bg-danger">Canceled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->payment_status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($order->payment_status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @else
                                            <span class="badge bg-danger">Unpaid</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <p class="badge bg-success" style="font-size: 1.5em;">Total Sell: &#2547; {{number_format($grandTotal)}}</p>
                    </div>
                </div> <!-- end card-body-->
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#date_range').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                autoUpdateInput: false,
                defaultDate: "{{ $selectedDate ?? '' }}" // Pre-select the date if available
            });

            // Update the form input with the selected date range
            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
                // Submit form if needed
                $('#filterForm').submit();
            });

            // Clear the date picker input on cancel
            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            // Set the value in the input to the selected date (if available)
            $('#date_range').val("{{ $selectedDate ?? '' }}");
        });
    </script>




@endsection
