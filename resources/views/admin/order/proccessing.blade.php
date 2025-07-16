@extends('admin.master')
@section('title')
    Proccessing Orders | {{env('APP_NAME')}}
@endsection

@section('body')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Proccessing Orders</h4>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                        <tr style="font-size: 90%">
                            <th data-orderable="false">S.n</th>
                            <th data-orderable="true">Order Code</th>
                            <th data-orderable="true">Total qty</th>
                            <th data-orderable="true">Customer</th>
                            <th data-orderable="true">Amount</th>
                            <th data-orderable="true">Order Status</th>
                            <th data-orderable="true">Payment Method</th>
                            <th data-orderable="true">Payment Status</th>
                            <th data-orderable="false" class="action" data-priority="1">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr style="font-size: 90%">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$order->order_code}}</td>
                                <td>{{$order->total_qty}}</td>
                                <td>{{$order->name}}</td>
                                <td>&#2547;{{number_format($order->grand_total + $order->shipping_cost)}}</td>
                                <td>{{$order->order_status}}</td>
                                <td>{{$order->payment_method}}</td>
                                <td>{{$order->payment_status}}</td>
                                <td>
                                    <a href="{{route('order.show', ['id' => $order->id])}}" class="action-icon">
                                        <i class="mdi mdi-eye text-success"></i>
                                    </a>
                                    <a href="" class="action-icon">
                                        <i class="mdi mdi-square-edit-outline text-primary"></i>
                                    </a>
                                    <a href="#" onclick="confirmDelete({{$order->id}});" class="action-icon">
                                        <i class="mdi mdi-delete text-danger"></i>
                                    </a>
                                    <form action="{{route('order.delete', ['id' => $order->id])}}" method="POST" id="orderDeleteForm{{$order->id}}">
                                        @csrf
                                    </form>
                                    <script>
                                        function confirmDelete(orderId) {
                                            var confirmDelete = confirm('Are you sure you want to delete this?');
                                            if (confirmDelete) {
                                                document.getElementById('orderDeleteForm' + orderId).submit();
                                            } else {
                                                return false;
                                            }
                                        }
                                    </script>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>


@endsection
