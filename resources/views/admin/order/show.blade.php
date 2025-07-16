@extends('admin.master')
@section('title')
    Order show | {{env('APP_NAME')}}
@endsection

@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item active">Order details</li>
                    </ol>
                </div>
                <h4 class="page-title">Order Details</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <!-- Invoice Logo-->
                    <div class="clearfix">
                        <div class="float-end">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="{{route('order-payment-status.update')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$order->id}}">
                                        <label for="">Payment Status</label>
                                        <select name="payment_status" id="payment_status" class="form-control" @if($order->order_status == 'cancel') disabled @endif onchange="this.form.submit()">
                                            <option value="" selected disabled>Select payment status</option>
                                            <option value="pending" {{$order->payment_status == 'pending' ? 'selected' : ''}}>Pending</option>
                                            <option value="paid" {{$order->payment_status == 'paid' ? 'selected' : ''}}>Paid</option>
                                            <option value="un_paid" {{$order->payment_status == 'un_paid' ? 'selected' : ''}}>Un-paid</option>
                                        </select>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form action="{{route('order-status.update')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$order->id}}">
                                        <label for="">Order Status</label>
                                        <select name="order_status" id="order_status" class="form-control" @if($order->order_status == 'cancel') disabled @elseif($order->order_status == 'delivered') disabled @endif onchange="this.form.submit()">
                                            <option value="" selected disabled>Select order status</option>
                                            <option value="pending" {{$order->order_status == 'pending' ? 'selected' : ''}}>Pending</option>
                                            <option value="in_completed" {{$order->order_status == 'in_completed' ? 'selected' : ''}} disabled>In completed</option>
                                            <option value="confirmed" {{$order->order_status == 'confirmed' ? 'selected' : ''}}>Confirmed</option>
                                            <option value="proccessing" {{$order->order_status == 'proccessing' ? 'selected' : ''}}>Proccessing</option>
                                            <option value="shipped" {{$order->order_status == 'shipped' ? 'selected' : ''}}>Shipped</option>
                                            <option value="delivered" {{$order->order_status == 'delivered' ? 'selected' : ''}}>Delivered</option>
                                            <option value="cancel" {{$order->order_status == 'cancel' ? 'selected' : ''}}>Canceled</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Detail-->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="float-start mt-3">
                                <p style="margin-bottom: 0.2em"><strong>To:</strong></p>
                                <p style="margin-bottom: 0.2em"><strong>Name: {{$order->name}}</strong></p>
                                <p style="margin-bottom: 0.2em"><strong>Address:</strong> {{$order->address}}</p>
{{--                                <p style="margin-bottom: 0.2em"><strong>City:</strong> {{$order->district->name}}</p>--}}
                                <p style="margin-bottom: 0.2em"><strong>Contact Number:</strong> {{$order->mobile}}</p>
                                <p style="margin-bottom: 0.2em"><strong>Email:</strong> {{$order->email}}</p>
                            </div>

                        </div><!-- end col -->
                        <div class="col-sm-4 offset-sm-2">
                            <div class="mt-3 float-sm-end">
                                <p class="font-13" style="margin-bottom: 0.2em"><strong>Order Date: </strong> &nbsp;&nbsp;&nbsp; {{$order->created_at->format('d M Y h:i:s A')}}</p>
                                <p class="font-13" style="margin-bottom: 0.2em"><strong>Order Status: </strong>
                                    @if($order->order_status == 'pending')
                                        <span class="badge bg-danger float-end">Pending</span>
                                    @elseif($order->order_status == 'delivered')
                                        <span class="badge bg-success float-end">Delivered</span>
                                    @elseif($order->order_status == 'cancel')
                                        <span class="badge bg-danger float-end">Canceled</span>
                                    @elseif($order->order_status == 'shipped')
                                        <span class="badge bg-primary float-end">shipped</span>
                                    @elseif($order->order_status == 'in_completed')
                                        <span class="badge bg-primary float-end">In completed</span>
                                    @else
                                        <span class="badge bg-warning float-end">Proccessing</span>
                                    @endif
                                </p>
                                <p class="font-13" style="margin-bottom: 0.2em"><strong>Order Code: </strong> <span class="float-end">#{{$order->order_code}}</span></p>
                                <p class="font-13" style="margin-bottom: 0.2em"><strong>Payment Status: </strong>
                                    @if($order->payment_status == 'pending')
                                        <span class="badge bg-danger float-end">Pending</span>
                                    @elseif($order->payment_status == 'paid')
                                        <span class="badge bg-success float-end">Paid</span>
                                    @else
                                        <span class="badge bg-warning float-end">Un-paid</span>
                                    @endif
                                </p>
                            </div>
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped dt-responsive nowrap w-100 mt-4">
                                    <thead>
                                    <tr>
                                        <th>Img</th>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Variant</th>
                                        <th>Unit Cost</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $totalWithoutDiscount = 0;
                                        $totalDiscount = 0;
                                    @endphp
                                    @foreach($order->orderDetails as $orderDetail)
                                        @php
                                            $product = \App\Models\Product::find($orderDetail->product_id);
                                        if ($orderDetail->discount_type == 2) {
                                            $newDiscount = ($orderDetail->price * ($orderDetail->discount / 100));
                                        } else {
                                            $newDiscount = $orderDetail->discount;
                                        }
                                            $totalPrice = $orderDetail->price+$newDiscount;
                                            $totalWithoutDiscount +=  $totalPrice * $orderDetail->qty;
                                        $totalDiscount += $newDiscount * $orderDetail->qty;
                                        @endphp
                                        <tr>
                                            <td>
                                                <img src="{{ asset($orderDetail->product->thumbnail_img) }}" alt="" style="height: 45px">
                                            </td>
                                            <td>
                                                <b>{{ $orderDetail->product->category->category_name }}</b> <br>
                                                {{ $orderDetail->product->name }}
                                            </td>
                                            <td>{{ $orderDetail->qty }}</td>
                                            <td>
                                                {{ $orderDetail->size_id ? $orderDetail->size->name : '' }}
                                                {{ $orderDetail->size_id && $orderDetail->color_id ? ' / ' : '' }}
                                                {{ $orderDetail->color_id ? $orderDetail->color->name : '' }}
                                            </td>
                                            <td>
                                                @if($orderDetail->discount > 0)
                                                    <del class="text-danger">&#2547; {{ number_format($orderDetail->price+$newDiscount, 2) }}</del><br>
                                                @endif
                                                &#2547; {{ number_format($orderDetail->price, 2) }}
                                            </td>
                                            <td class="text-end">
                                                @if($orderDetail->discount > 0)
                                                    <del class="text-danger">&#2547; {{ number_format($totalPrice*$orderDetail->qty, 2) }}</del><br>
                                                @endif
                                                &#2547; {{ number_format($orderDetail->price*$orderDetail->qty, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="clearfix pt-3"></div>
                        </div> <!-- end col -->
                        <div class="col-sm-6">
                            @php
                                $grandTotal = $totalWithoutDiscount + $order->shipping_cost - $totalDiscount;
                            @endphp
                            <div class="float-end mt-3 mt-sm-0">
                                <p><b>Sub-total:</b> <span class="float-end">&#2547; {{ number_format($totalWithoutDiscount, 2) }}</span></p>
                                <p><b>Shipping cost:</b>
                                    <span class="float-end">&#2547; {{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 2) : 'Free' }}</span>
                                </p>
                                <p><b>Discount:</b> <span class="float-end">&#2547; {{ number_format($totalDiscount, 2) }}</span></p>
                                <hr>
                                <p><b>Grand Total:</b> <span class="float-end">&#2547; {{ number_format($grandTotal, 2) }}</span></p>
                            </div>
                            <div class="clearfix"></div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row-->

                    <div class="d-print-none mt-4">
                        <div class="text-end">
                            <a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i> Print</a>
                            <a href="#" class="btn btn-info" onclick="event.preventDefault(); document.getElementById('invoiceDownload').submit();"><i class="mdi mdi-download"></i> Download</a>
                            <form action="{{route('invoice.download', ['id' => $order->id])}}" method="POST" id="invoiceDownload">
                                @csrf
                            </form>

                        </div>
                    </div>
                    <!-- end buttons -->

                </div> <!-- end card-body-->
            </div> <!-- end card -->
            @php
                $ordersByMobile = \App\Models\Order::where('mobile', $order->mobile)->get();
            @endphp
            <div class="card">
                <!-- Clickable Header -->
                <div class="card-header text-center" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#courierModal" onclick="loadCourierReport({{ $order->id }})">
                    <strong>Click for Courier Analyzing [ {{ $order->mobile }} ]</strong>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="courierModal" tabindex="-1" aria-labelledby="courierModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="courierModalLabel">Courier Report</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body" id="courierReportBody">
                                <p>Loading...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Flexbox for inline Total Orders and Search Input -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Order Total Section -->
                        <div class="order-total">
                            <h5>Total Orders: <span class="badge bg-secondary">{{ count($ordersByMobile) }}</span></h5>
                        </div>

                        <!-- Search Input Section -->
                        <div class="search-input">
                            <input type="text" class="form-control" placeholder="Search Orders" id="orderSearch" onkeyup="searchOrder()">
                        </div>
                    </div>

                    <!-- Order Table -->
                    <div class="table-responsive">
                        <table class="table table-striped text-center" id="orderTable">
                            <thead>
                            <tr>
                                <th>OrderID</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ordersByMobile as $orderDetail)
                                <tr class="order-row">
                                    <td>#{{ $orderDetail->order_code }}</td>
                                    <td>&#2547; {{ number_format($orderDetail->grand_total, 2) }}/-</td>
                                    <td>
                                        @if($orderDetail->order_status == 'pending')
                                            <span class="badge bg-danger">Pending</span>
                                        @elseif($orderDetail->order_status == 'delivered')
                                            <span class="badge bg-success">Delivered</span>
                                        @elseif($orderDetail->order_status == 'cancel')
                                            <span class="badge bg-danger">Canceled</span>
                                        @elseif($orderDetail->order_status == 'shipped')
                                            <span class="badge bg-primary">Shipped</span>
                                        @elseif($orderDetail->order_status == 'in_completed')
                                            <span class="badge bg-primary">In Completed</span>
                                        @else
                                            <span class="badge bg-warning">Processing</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <script>
                function searchOrder() {
                    let input = document.getElementById('orderSearch').value.toLowerCase();
                    let rows = document.querySelectorAll('.order-row');

                    rows.forEach(row => {
                        let orderCode = row.cells[0].textContent.toLowerCase();
                        let amount = row.cells[1].textContent.toLowerCase();
                        let status = row.cells[2].textContent.toLowerCase();

                        if (orderCode.includes(input) || amount.includes(input) || status.includes(input)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }
            </script>
        </div> <!-- end col-->
    </div>
    <!-- end row -->

            <script>
        // Base URL for fetching courier report
        const courierReportUrl = "{{ route('order.courier.report', ['id' => '__ID__']) }}";

        // Function to load and render courier report
        function loadCourierReport(orderId) {
            const body = document.getElementById('courierReportBody');
            body.innerHTML = '<p>Loading...</p>'; // Show loading message

            const url = courierReportUrl.replace('__ID__', orderId);
            console.log('Loading from:', url); // Debugging

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Calculate overall success rate
                        let successRate = 0;
                        if (data.data.total_order > 0) {
                            successRate = (data.data.total_delivered / data.data.total_order) * 100;
                        }

                        // Generate Bangla comment based on success rate
                        let comment = '';
                        if (successRate < 50) {
                            comment = '<li class="text-danger fw-bold">⚠️ এই মানুষকে অর্ডার পাঠানো রিস্কি</li>';
                        } else if (successRate < 80) {
                            comment = '<li class="text-warning fw-semibold">⛔ অর্ডার পাঠানো কিছুটা ঝুঁকি আছে</li>';
                        } else {
                            comment = '<li class="text-success">✅ অর্ডার পাঠানো নিরাপদ</li>';
                        }

                        // Build HTML content
                        let html = `
                        <ul>
                            <li>Total Orders: ${data.data.total_order}</li>
                            <li>Delivered: ${data.data.total_delivered}</li>
                            <li>Cancelled: ${data.data.total_cancelled}</li>
                            ${comment}
                        </ul>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Courier</th>
                                        <th>Orders</th>
                                        <th>Delivered</th>
                                        <th>Cancelled</th>
                                        <th>Success Rate</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                        // Loop through courier data and build table rows
                        for (let courier in data.data.couriers) {
                            let c = data.data.couriers[courier];
                            html += `<tr>
                            <td>${courier}</td>
                            <td>${c.order}</td>
                            <td>${c.delivered}</td>
                            <td>${c.cancelled}</td>
                            <td>${c.success_rate}%</td>
                        </tr>`;
                        }

                        // Close table
                        html += `</tbody></table></div>`;
                        body.innerHTML = html;

                    } else {
                        body.innerHTML = '<p class="text-danger">Failed to fetch courier data.</p>';
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    body.innerHTML = '<p class="text-danger">Error loading data.</p>';
                });
        }
    </script>

@endsection
