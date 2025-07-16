@extends('front.master')

@section('title')
{{$generalSettingView->site_name}} - My Account
@endsection

@section('body')
    <style>
        .profile-container {
            display: flex;
            align-items: center;
            padding: 3%;
            margin-bottom: 2%;
            background-color: #cc9966;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }

        .profile-info h3, .profile-info p {
            margin: 0;
        }

        .dashboard-container {
            max-width: 1200px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 100%;
        }
        .dashboard-header h1 {
            font-size: 2.5em;
            margin: 0;
        }
        .dashboard-stats {
            display: flex;
            justify-content: space-between;
            text-align: center;
        }
        .stat-box {
            width: 30%;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .stat-box h2 {
            font-size: 2em;
            margin: 0;
        }
        .stat-box p {
            font-size: 1.2em;
            margin: 10px 0 0;
        }
    </style>
    <link href="{{asset('/')}}admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <div class="page-header text-center" style="background-image: url('{{asset('/')}}front/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">My Account<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Account</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <div class="row">
                    <aside class="col-md-4 col-lg-3">
                        <div class="profile-container">
                            @if($customer->profile_img == null)
                            <img src="{{asset('/')}}front/assets/images/man.png" alt="Profile Image" class="profile-image">
                            @else
                            <img src="{{asset($customer->profile_img)}}" alt="Profile Image" class="profile-image">
                            @endif
                            <div class="profile-info">
                                <h3>{{$customer->name}}</h3>
                                <p style="color: black">{{$customer->mobile}}</p>
                            </div>
                        </div>
                        <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="true">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-orders-link" data-toggle="tab" href="#tab-orders" role="tab" aria-controls="tab-orders" aria-selected="false">Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="false">Account Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">Sign Out</a>

                                <form action="{{route('customer.logout')}}" method="POST" id="logoutForm" enctype="multipart/form-data">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </aside><!-- End .col-lg-3 -->

                    <div class="col-md-8 col-lg-9">
                        <div class="tab-content">
                            <div class="tab-pane fade show {{ session('active_tab', '#tab-dashboard') == '#tab-dashboard' ? 'active' : '' }}" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
                                <div class="dashboard-container">
                                    <div class="dashboard-stats">
                                        <div class="stat-box">
                                            <h2>৳ {{number_format($totalSpend)}}</h2>
                                            <p>Total Spend</p>
                                        </div>
                                        <div class="stat-box">
                                            <h2>{{$totalOrders}}</h2>
                                            <p>Total Orders</p>
                                        </div>
                                        <div class="stat-box">
                                            <h2>{{$totalDeliveredOrders}}</h2>
                                            <p>Total Delivered Received</p>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .End .tab-pane -->

                            <div class="tab-pane fade {{ session('active_tab') == '#tab-orders' ? 'active' : '' }}" id="tab-orders" role="tabpanel" aria-labelledby="tab-orders-link">
                                @if(count($customerOrders) > 0)
                                    <table class="table table-striped dt-responsive nowrap w-100 text-center">
                                        <thead>
                                        <tr>
                                            <th data-orderable="false">S.N</th>
                                            <th data-orderable="true">Order Code</th>
                                            <th data-orderable="true">Total qty</th>
                                            <th data-orderable="true">Amount</th>
                                            <th data-orderable="true">Order Status</th>
                                            <th data-orderable="true">Payment Method</th>
                                            <th data-orderable="true">Payment Status</th>
                                            <th data-orderable="false" class="action" data-priority="1">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($customerOrders as $order)
                                            <tr style="font-size: 90%">
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$order->order_code}}</td>
                                                <td>{{$order->total_qty}}</td>
                                                <td>&#2547;{{number_format($order->grand_total + $order->shipping_cost)}}</td>
                                                <td>{{$order->order_status}}</td>
                                                <td>{{$order->payment_method}}</td>
                                                <td>{{$order->payment_status}}</td>
                                                <td>
                                                    <a href="" class="action-icon">
                                                        <i class="mdi mdi-eye text-success" style="font-size: 2rem"></i>
                                                    </a>
                                                    <a href="" class="action-icon" onclick="event.preventDefault(); document.getElementById('invoiceDownload{{$order->id}}').submit();">
                                                        <i class="mdi mdi-download text-primary" style="font-size: 2rem;"></i>
                                                    </a>
                                                    <form action="{{route('invoice.download', ['id' => $order->id])}}" method="POST" id="invoiceDownload{{$order->id}}">
                                                        @csrf
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $customerOrders->links('vendor.pagination.custom') }}
                                    </div>
                                @else
                                    <p>No order has been made yet.</p>
                                    <a href="{{route('all.products')}}" class="btn btn-outline-primary-2">
                                        <span>GO SHOP</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </a>
                                @endif
                            </div><!-- .End .tab-pane -->

                            <div class="tab-pane fade {{ session('active_tab') == '#tab-account' ? 'active' : '' }}" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Profile Information</h4>
                                        <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <label>Name *</label>
                                            <input type="text" class="form-control mb-2" required="" name="name" value="{{$customer->name}}">

                                            <label>Email address *</label>
                                            <input type="email" class="form-control mb-2" name="email" required="" value="{{$customer->email}}">

                                            <label>Mobile *</label>
                                            <input type="text" class="form-control mb-2" name="mobile" required="" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="{{$customer->mobile}}">

                                            <label>Address *</label>
                                            <textarea type="text" class="form-control mb-2" name="address" oninput="validateEnglishInput(this)">{{$customer->address}}</textarea>
                                            <small id="error-message" style="color: red; display: none;">Please type in English only.</small>

                                            <script>
                                                function validateEnglishInput(input) {
                                                    const englishPattern = /^[a-zA-Z0-9\s,.-]*$/;
                                                    const errorMessage = document.getElementById('error-message');

                                                    if (!englishPattern.test(input.value)) {
                                                        errorMessage.style.display = 'block';
                                                        input.value = input.value.replace(/[^a-zA-Z0-9\s,.-]/g, ''); // remove non-English characters
                                                    } else {
                                                        errorMessage.style.display = 'none';
                                                    }
                                                }
                                            </script>

                                            <label>Profile Image *</label>
                                            <input type="file" class="form-control mb-2" name="profile_img">

                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>SAVE CHANGES</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Change password</h4>
                                        <form action="{{route('password.update')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <label>Current password (leave blank to leave unchanged)</label>
                                            <input type="password" name="old_password" class="form-control mb-2 @error('old_password') is-invalid @enderror">
                                            @error('old_password')
                                            <div class="alert alert-danger mb-2">{{ $message }}</div>
                                            @enderror

                                            <label>New password (leave blank to leave unchanged)</label>
                                            <input type="password" name="password" class="form-control mb-2 @error('old_password') is-invalid @enderror">
                                            @error('password_confirmation')
                                            <div class="alert alert-danger mb-2">{{ $message }}</div>
                                            @enderror

                                            <label>Confirm new password</label>
                                            <input type="password" name="password_confirmation" class="form-control mb-2 @error('old_password') is-invalid @enderror">
                                            @error('password_confirmation')
                                            <div class="alert alert-danger mb-2">{{ $message }}</div>
                                            @enderror
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>SAVE CHANGES</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- .End .tab-pane -->
                        </div>
                    </div><!-- End .col-lg-9 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .dashboard -->
    </div><!-- End .page-content -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Set the active tab from session or default to dashboard if none
            var activeTab = '{{ session('active_tab', '#tab-dashboard') }}'; // Default to dashboard tab
            $('.nav-link[href="' + activeTab + '"]').addClass('active');
            $('.tab-pane' + activeTab).addClass('show active');

            // Listen for tab click event and save it to session
            $('.nav-link').on('click', function () {
                var tabId = $(this).attr('href');
                $.ajax({
                    url: "{{ route('store.active.tab') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        active_tab: tabId
                    },
                    success: function (response) {
                        console.log('Active tab saved to session.');
                    }
                });
            });
        });
    </script>

@endsection
