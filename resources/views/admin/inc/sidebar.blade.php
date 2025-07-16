<!--- Sidemenu -->
<ul class="side-nav">

    <li class="side-nav-title side-nav-item">Navigation</li>
    @php
        // Fetch the user type of the authenticated user
        $userType = auth()->user()->user_type;

        // Initialize roleRoutes variable
        $roleRoutes = [];

        // If user_type is not 1, fetch the role IDs and route names
        if ($userType !== 1) {
            $roleIds = DB::table('user_role')->where('user_id', auth()->user()->id)->pluck('role_id')->toArray();
            $roleRoutes = DB::table('role_routes')->whereIn('role_id', $roleIds)->pluck('route_name')->toArray();
        }
    @endphp
    <li class="side-nav-item">
        <a href="{{route('dashboard')}}" class="side-nav-link">
            <i class="uil-home-alt"></i>
            <span> Dashboards </span>
        </a>
    </li>

    @if ($userType == 1 || !empty(array_filter(['role.add', 'role.manage', 'user.add', 'user.manage'], fn($route) => in_array($route, $roleRoutes))))
    <li class="side-nav-item">
        <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false"
           aria-controls="sidebarEcommerce" class="side-nav-link">
            <i class="uil-users-alt"></i>
            <span> User Module </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse" id="sidebarEcommerce">
            <ul class="side-nav-second-level">
                @if ($userType == 1 || in_array('role.add', $roleRoutes))
                    <li>
                        <a href="{{ route('role.add') }}">Add Role</a>
                    </li>
                @endif
                @if ($userType == 1 || in_array('role.manage', $roleRoutes))
                    <li>
                        <a href="{{ route('role.manage') }}">Manage Role</a>
                    </li>
                @endif
                @if ($userType == 1 || in_array('user.add', $roleRoutes))
                    <li>
                        <a href="{{ route('user.add') }}">Add User</a>
                    </li>
                @endif
                @if ($userType == 1 || in_array('user.manage', $roleRoutes))
                    <li>
                        <a href="{{ route('user.manage') }}">Manage User</a>
                    </li>
                @endif
            </ul>
        </div>
    </li>
    @endif

    @if ($userType == 1 || !empty(array_filter(['slider.add', 'slider.manage'], fn($route) => in_array($route, $roleRoutes))))
        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarSlider" aria-expanded="false" aria-controls="sidebarSlider" class="side-nav-link">
                <i class="uil-sliders-v"></i>
                <span> Slider </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarSlider">
                <ul class="side-nav-second-level">
                    @if ($userType == 1 || in_array('slider.add', $roleRoutes))
                        <li>
                            <a href="{{ route('slider.add') }}">Add Slider</a>
                        </li>
                    @endif
                    @if ($userType == 1 || in_array('slider.manage', $roleRoutes))
                        <li>
                            <a href="{{ route('slider.manage') }}">Manage Slider</a>
                        </li>
                    @endif
                </ul>
            </div>
        </li>
    @endif

    @if ($userType == 1 || !empty(array_filter(['product.add', 'product.manage', 'category.manage','brand.add', 'color.add', 'size.add'], fn($route) => in_array($route, $roleRoutes))))
    <li class="side-nav-item">
        <a data-bs-toggle="collapse" href="#sidebarCategory" aria-expanded="false" aria-controls="sidebarEmail"
           class="side-nav-link">
            <i class="uil-list-ul"></i>
            <span> Products </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse" id="sidebarCategory">
            <ul class="side-nav-second-level">
                @if ($userType == 1 || in_array('product.add', $roleRoutes))
                <li>
                    <a href="{{route('product.add')}}">Add Product</a>
                </li>
                @endif
                    @if ($userType == 1 || in_array('product.manage', $roleRoutes))
                <li>
                    <a href="{{route('product.manage')}}">Products</a>
                </li>
                    @endif
                    @if ($userType == 1 || in_array('category.manage', $roleRoutes))
                <li>
                    <a href="{{route('category.manage')}}">Category</a>
                </li>
                    @endif
                    @if ($userType == 1 || in_array('brand.add', $roleRoutes))
                <li>
                    <a href="{{route('brand.add')}}">Brand</a>
                </li>
                    @endif
                    @if ($userType == 1 || in_array('color.add', $roleRoutes))
                <li>
                    <a href="{{route('color.add')}}">Color</a>
                </li>
                    @endif
                    @if ($userType == 1 || in_array('size.add', $roleRoutes))
                <li>
                    <a href="{{route('size.add')}}">Size</a>
                </li>
                    @endif
            </ul>
        </div>
    </li>
    @endif
    @if ($userType == 1 || !empty(array_filter(['order.manage','order.pending','order.confirmed','order.proccessing','order.delivered','order.shipped','order.canceled','order.in_completed'], fn($route) => in_array($route, $roleRoutes))))
    <li class="side-nav-item">
        <a data-bs-toggle="collapse" href="#sidebarOrder" aria-expanded="false" aria-controls="sidebarOrder"
           class="side-nav-link">
            <i class="uil-money-bill"></i>
            <span> All Orders </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse" id="sidebarOrder">
            <ul class="side-nav-second-level">
                @if ($userType == 1 || in_array('order.pending', $roleRoutes))
                    <li>
                        <a href="{{route('order.pending')}}">Pending Orders</a>
                    </li>
                @endif
                @if ($userType == 1 || in_array('order.confirmed', $roleRoutes))
                    <li>
                        <a href="{{route('order.confirmed')}}">Confirmed Orders</a>
                    </li>
                @endif
                @if ($userType == 1 || in_array('order.proccessing', $roleRoutes))
                    <li>
                        <a href="{{route('order.proccessing')}}">Proccessing Orders</a>
                    </li>
                @endif
                @if ($userType == 1 || in_array('order.delivered', $roleRoutes))
                    <li>
                        <a href="{{route('order.delivered')}}">Delivered Orders</a>
                    </li>
                @endif
                @if ($userType == 1 || in_array('order.shipped', $roleRoutes))
                    <li>
                        <a href="{{route('order.shipped')}}">Shipped Orders</a>
                    </li>
                @endif
                @if ($userType == 1 || in_array('order.canceled', $roleRoutes))
                    <li>
                        <a href="{{route('order.canceled')}}">Canceled Orders</a>
                    </li>
                @endif
                @if ($userType == 1 || in_array('order.in_completed', $roleRoutes))
                    <li>
                        <a href="{{route('order.in_completed')}}">In Completed Orders</a>
                    </li>
                @endif
                @if ($userType == 1 || in_array('order.manage', $roleRoutes))
                    <li>
                        <a href="{{route('order.manage')}}">All Orders</a>
                    </li>
                @endif
            </ul>
        </div>
    </li>
    @endif
    @if ($userType == 1 || in_array('dashboard.manage', $roleRoutes))
    <li class="side-nav-item">
        <a href="{{route('dashboard.customer')}}" class="side-nav-link">
            <i class="uil-users-alt"></i>
            <span> Customers </span>
        </a>
    </li>
    @endif
    @if ($userType == 1 || in_array('dashboard.contact-form', $roleRoutes))
    <li class="side-nav-item">
        <a href="{{route('dashboard.contact-form')}}" class="side-nav-link">
            <i class="uil-question-circle"></i>
            <span> Customer Queries </span>
        </a>
    </li>
    @endif
    @if ($userType == 1 || !empty(array_filter(['privacy.add', 'return.manage'], fn($route) => in_array($route, $roleRoutes))))
        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarPrivacy" aria-expanded="false" aria-controls="sidebarPrivacy" class="side-nav-link">
                <i class="uil-lock"></i>
                <span> Privacy & Policy </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarPrivacy">
                <ul class="side-nav-second-level">
                    @if ($userType === 1 || in_array('privacy.add', $roleRoutes))
                        <li>
                            <a href="{{ route('privacy.add') }}">Manage Privacy</a>
                        </li>
                    @endif
                    @if ($userType === 1 || in_array('return.add', $roleRoutes))
                        <li>
                            <a href="{{ route('return.add') }}">Manage Return</a>
                        </li>
                    @endif
                </ul>
            </div>
        </li>
    @endif
    @if ($userType == 1 || !empty(array_filter(['report.sales','report.products-stock'], fn($route) => in_array($route, $roleRoutes))))
    <li class="side-nav-item">
        <a data-bs-toggle="collapse" href="#sidebarReport" aria-expanded="false" aria-controls="sidebarReport"
           class="side-nav-link">
            <i class="uil-bill"></i>
            <span>Report Analysis </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse" id="sidebarReport">
            <ul class="side-nav-second-level">
                @if ($userType == 1 || in_array('report.sales', $roleRoutes))
                <li>
                    <a href="{{route('report.sales')}}">Sales Analysis</a>
                </li>
                @endif
                    @if ($userType == 1 || in_array('report.products-stock', $roleRoutes))
                <li>
                    <a href="{{route('report.products-stock')}}">Products Stock Analysis</a>
                </li>
                    @endif
            </ul>
        </div>
    </li>
    @endif
    @if ($userType == 1 || !empty(array_filter(['shipping-free.add'], fn($route) => in_array($route, $roleRoutes))))
    <li class="side-nav-item">
        <a data-bs-toggle="collapse" href="#sidebarFreeShipping" aria-expanded="false" aria-controls="sidebarFreeShipping"
           class="side-nav-link">
            <i class="uil-bill"></i>
            <span>Offer Module </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse" id="sidebarFreeShipping">
            <ul class="side-nav-second-level">
                @if ($userType == 1 || in_array('shipping-free.add', $roleRoutes))
                <li>
                    <a href="{{route('shipping-free.add')}}">Free Shipping</a>
                </li>
                @endif
            </ul>
        </div>
    </li>
    @endif
    @if ($userType == 1 || !empty(array_filter(['google-analytic.add','about-us.add','setting.add','setting.smtp','shipping-cost.manage'], fn($route) => in_array($route, $roleRoutes))))
    <li class="side-nav-item">
        <a data-bs-toggle="collapse" href="#sidebarSetup" aria-expanded="false" aria-controls="sidebarSetup"
           class="side-nav-link">
            <i class="uil-wrench"></i>
            <span> Setup & Configarations </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse" id="sidebarSetup">
            <ul class="side-nav-second-level">
                @if ($userType == 1 || in_array('google-analytic.add', $roleRoutes))
                <li>
                    <a href="{{route('google-analytic.add')}}">Google Analytics</a>
                </li>
                @endif
                    @if ($userType == 1 || in_array('about-us.add', $roleRoutes))
                <li>
                    <a href="{{route('about-us.add')}}">About us</a>
                </li>
                    @endif
                    @if ($userType == 1 || in_array('setting.add', $roleRoutes))
                <li>
                    <a href="{{route('setting.add')}}">General Settings</a>
                </li>
                    @endif
                    @if ($userType == 1 || in_array('setting.smtp', $roleRoutes))
                <li>
                    <a href="{{route('setting.smtp')}}">SMTP Settings</a>
                </li>
                    @endif
                    @if ($userType == 1 || in_array('shipping-cost.manage', $roleRoutes))
                <li>
                    <a href="{{route('shipping-cost.manage')}}">Shipping Cost</a>
                </li>
                    @endif
            </ul>
        </div>
    </li>
    @endif
</ul>
