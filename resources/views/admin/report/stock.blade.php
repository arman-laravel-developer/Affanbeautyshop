@extends('admin.master')

@section('title')
    Stock Analysis | {{env('APP_NAME')}}
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
                <h4 class="page-title">Stock Analysis</h4>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <form action="{{route('report.category-wise-stock')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <select name="category_id" id="" class="form-control @error('category_id') is-invalid @enderror" required>
                                        @php echo $categories_dropdown @endphp
                                    </select>
                                    @error('category_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-info">Filter</button>
                                    <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('export.products') }}'">Export</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <table class="table table-bordered table-hover mt-3">
                        <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Num Of Sale</th>
                            <th>Total Stock</th>
                            <th>Unit Price</th>
                            <th>Total Stock Value</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{$product->name}}</td>
                            <td>{{$product->num_of_sale}}</td>
                            <td>{{$product->stock}}</td>
                            <td>&#2547; {{number_format($product->sell_price)}}</td>
                            <td>&#2547; {{number_format($product->stock * $product->sell_price)}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
