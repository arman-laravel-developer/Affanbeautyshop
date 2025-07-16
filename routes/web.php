<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\FrontProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\TrackOrderController;
use App\Http\Controllers\ReturnAndRefundController;

use App\Models\RoleRoute;

function getRoleName($routeName)
{
    $routesData = RoleRoute::where('route_name', $routeName)->get();
    $result = [];
    foreach ($routesData as $routeData) {
        array_push($result, $routeData->role_name);
    }
    return $result;
}
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy.page');
Route::get('/conditions', [HomeController::class, 'condition'])->name('condition.page');
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about.us');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact.us');
Route::get('/category-products/{id}', [HomeController::class, 'category_product'])->name('category.product');
Route::get('/product-show/{id}/{slug}', [FrontProductController::class, 'show'])->name('product.show');
Route::get('/product-quickview', [FrontProductController::class, 'quickview'])->name('product.quickview');
Route::get('/all-products', [FrontProductController::class, 'allProducts'])->name('all.products');
Route::get('/ajax-search', [FrontProductController::class, 'ajaxSearch'])->name('product.ajaxSearch');
Route::get('/search', [FrontProductController::class, 'search'])->name('product.search');

Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart-total', [CartController::class, 'cartTotal'])->name('cart.total');
Route::delete('/cart/remove/{productId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/dropdown', [CartController::class, 'dropdown'])->name('cart.dropdown');
Route::post('/cart/update-size', [CartController::class, 'updateSize'])->name('cart.updateSize');
Route::post('/cart/update-color', [CartController::class, 'updateColor'])->name('cart.updateColor');
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

Route::post('/order-store', [OrderController::class, 'store'])->name('order.store');
Route::post('/order-store-button', [OrderController::class, 'storeBtn'])->name('order.store-button');
Route::get('/order-confirmation', [OrderController::class, 'orderConfirmation'])->name('order.confirmation');
Route::post('/invoice-download/{id}', [OrderController::class, 'invoice'])->name('invoice.download');

Route::get('/cart-page', [CartController::class, 'index'])->name('cart.index');

Route::get('/track-my-order', [TrackOrderController::class, 'index'])->name('track.order');
Route::get('/track-my-order-result', [TrackOrderController::class, 'result'])->name('show.track-result');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

Route::post('/customer-store', [CustomerController::class, 'store'])->name('customer.store');
Route::post('/customer-login', [CustomerController::class, 'loginCheck'])->name('customer.login');

Route::get('/forget-password', [CustomerController::class, 'forget'])->name('forget.password')->middleware('customer.login');
Route::post('/forget-password-send-otp', [CustomerController::class, 'sendCode'])->name('forget.password-send-code')->middleware('customer.login');
Route::get('/forget-password-verify', [CustomerController::class, 'verify'])->name('forget.verify')->middleware('customer.login');
Route::post('/resend-otp', [CustomerController::class, 'resendOtp'])->name('resend.otp')->middleware('customer.login');
Route::post('/otp-check', [CustomerController::class, 'otpCheck'])->name('otp.check')->middleware('customer.login');
Route::get('/set-password', [CustomerController::class, 'setPassword'])->name('set.password')->middleware('customer.login');
Route::post('/save-password', [CustomerController::class, 'savePassword'])->name('save.password')->middleware('customer.login');

Route::post('/contact-form', [ContactFormController::class, 'submit'])->name('contact-form.submit');

Route::middleware('customer.logout')->group(function () {
    Route::get('/customer-dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    Route::post('/customer-logout', [CustomerDashboardController::class, 'logout'])->name('customer.logout');


    Route::post('/profile-update', [CustomerDashboardController::class, 'profileUpdate'])->name('profile.update');
    Route::post('/store-active-tab', [CustomerDashboardController::class, 'storeActiveTab'])->name('store.active.tab');

    Route::post('/password-update', [CustomerDashboardController::class, 'passwordUpdate'])->name('password.update');

});


Route::get('/error', function () {
    return view('errors.404');
});





Route::get('/return-and-refund', [ReturnAndRefundController::class, 'page_view'])->name('return.view');
Route::get('/privacy-policy', [PrivacyController::class, 'page_view'])->name('privacy.view');
Route::get('/terms-and-condition', [PrivacyController::class, 'condition_page_view'])->name('condition.view');

Route::prefix('profile')->group(function () {
    Route::get('/', [HomeController::class, 'profileView'])->name('profile.view');
});


