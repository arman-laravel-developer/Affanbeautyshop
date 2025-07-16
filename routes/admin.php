<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\GoogleAnalyticController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\ShippingCostController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReturnAndRefundController;
use App\Http\Controllers\ReportAnalysisController;
use App\Http\Controllers\HomeCategoryController;
use App\Http\Controllers\ShippingFreeController;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('migrate', function() {
        $exitCode = Artisan::call('migrate');

        if ($exitCode === 0) {
            $output = Artisan::output();
            return response()->json(['status' => 'success', 'message' => $output]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Migration failed'], 500);
        }
    })->name('migrate');
    Route::get('migrate-seed', function() {
        $exitCode = Artisan::call('migrate --seed');

        if ($exitCode === 0) {
            $output = Artisan::output();
            return response()->json(['status' => 'success', 'message' => $output]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Migration failed'], 500);
        }
    })->name('migrate-seed');
    Route::get('migrate-rollback', function() {
        $exitCodeRollBack = Artisan::call('migrate:rollback');

        if ($exitCodeRollBack === 0) {
            $output = Artisan::output();
            return response()->json(['status' => 'success', 'message' => $output]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Migration failed'], 500);
        }
    })->name('migrate-rollback');
    Route::get('clear',function() {
        Artisan::call('optimize:clear');
        flash()->success('Cache Clear', 'Cache clear successfully');
        return redirect()->back();
//    dd('cleared');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/user/profile/{id}', [DashboardController::class, 'profile'])->name('user.profile');
        Route::post('/user/profile/update/{id}', [DashboardController::class, 'profileUpdate'])->name('user.profile-update');
    Route::get('/contact-form-queries', [DashboardController::class, 'contactFormShow'])->name('dashboard.contact-form');
    Route::get('/contact-form-detail/{id}', [DashboardController::class, 'contactFormDetail'])->name('contactForm.detail');
    Route::post('/contact-form-replay/{id}', [DashboardController::class, 'contactFormReplay'])->name('contactForm.replay');
    Route::get('/customer-manage', [DashboardController::class, 'customer'])->name('dashboard.customer');
    Route::post('/customer-delete/{id}', [DashboardController::class, 'customerDelete'])->name('dashboard.customer-delete');
    Route::get('/customer-login/{id}', [DashboardController::class, 'customerLogin'])->name('customer.login-admin');
    Route::post('/test-mail', [DashboardController::class, 'testMail'])->name('test.mail');
    Route::get('/getAttributeValues/{id}', [ProductController::class, 'getAttributeValues'])->name('get.attribute-value');

    Route::post('/update-status', [ProductController::class, 'updateStatus'])->name('product.updateStatus');
    Route::post('/update-featured', [ProductController::class, 'updateFeatured'])->name('product.updateFeatured');
    Route::post('/update-you-may-also', [ProductController::class, 'updateYouMayAlso'])->name('product.updateYouMayAlso');
    Route::post('/update-stock', [ProductController::class, 'updateStock'])->name('product.updateStock');

    Route::get('/backup', [GeneralSettingController::class, 'backup'])->name('setting.backup');
    Route::get('/smtp', [GeneralSettingController::class, 'smtp'])->name('setting.smtp');
    Route::post('/smtp-update', [GeneralSettingController::class, 'smtpUpdate'])->name('setting.smtp-update');

    Route::middleware(['roles'])->group(function () {
        Route::group(['prefix' => 'role', 'as' => 'role.'], function(){
            Route::get('/add', [RoleController::class, 'index'])->name('add');
            Route::post('/new', [RoleController::class, 'create'])->name('new');
            Route::get('/manage', [RoleController::class, 'manage'])->name('manage');
            Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [RoleController::class, 'delete'])->name('delete');
        });

        Route::prefix('user')->group(function () {
            Route::get('/add', [UserController::class, 'index'])->name('user.add');
            Route::post('/new', [UserController::class, 'create'])->name('user.new');
            Route::get('/manage', [UserController::class, 'manage'])->name('user.manage');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
            Route::get('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
        });
        Route::prefix('report')->group(function () {
            Route::get('/sales-report', [ReportAnalysisController::class, 'index'])->name('report.sales');
            Route::get('/sales-report-wise', [ReportAnalysisController::class, 'salesWiseReport'])->name('report.sales-wise');

            Route::get('/sales-report-export', [ReportAnalysisController::class, 'salesReportExport'])->name('report.sales-export');
            Route::get('/filtered-sales-report-export', [ReportAnalysisController::class, 'FilteredSalesReportExport'])->name('report.filtered-sales-export');

            Route::post('/home-category-update', [HomeCategoryController::class, 'update'])->name('home-category.update');

            Route::get('/products-stock-analysis', [ReportAnalysisController::class, 'stock'])->name('report.products-stock');
            Route::get('/export-products-stock', [ReportAnalysisController::class, 'exportProducts'])->name('export.products');
            Route::get('/export-products-stock-category-wise', [ReportAnalysisController::class, 'exportProductsCategoryWise'])->name('export.products-category-wise');
            Route::post('/category-wise-stock', [ReportAnalysisController::class, 'categoryWiseStock'])->name('report.category-wise-stock');
        });
        Route::prefix('slider')->group(function () {
            Route::get('/add', [SliderController::class, 'index'])->name('slider.add');
            Route::post('/new', [SliderController::class, 'create'])->name('slider.new');
            Route::get('/manage', [SliderController::class, 'manage'])->name('slider.manage');
            Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
            Route::post('/update/{id}', [SliderController::class, 'update'])->name('slider.update');
            Route::get('/delete/{id}', [SliderController::class, 'delete'])->name('slider.delete');
        });
        Route::prefix('category')->group(function () {
            Route::get('/add', [CategoryController::class, 'index'])->name('category.add');
            Route::post('/new', [CategoryController::class, 'create'])->name('category.new');
            Route::get('/manage', [CategoryController::class, 'manage'])->name('category.manage');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
            Route::post('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
        });
        Route::prefix('brand')->group(function () {
            Route::get('/add', [BrandController::class, 'index'])->name('brand.add');
            Route::post('/new', [BrandController::class, 'create'])->name('brand.new');
            Route::get('/manage', [BrandController::class, 'manage'])->name('brand.manage');
            Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
            Route::post('/update/{id}', [BrandController::class, 'update'])->name('brand.update');
            Route::post('/delete/{id}', [BrandController::class, 'delete'])->name('brand.delete');
        });
        Route::prefix('product')->group(function () {
            Route::get('/add', [ProductController::class, 'index'])->name('product.add');
            Route::post('/new', [ProductController::class, 'create'])->name('product.new');
            Route::get('/manage', [ProductController::class, 'manage'])->name('product.manage');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
            Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
            Route::post('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
        });
        Route::prefix('color')->group(function () {
            Route::get('/add', [ColorController::class, 'index'])->name('color.add');
            Route::post('/new', [ColorController::class, 'create'])->name('color.new');
            Route::get('/manage', [ColorController::class, 'manage'])->name('color.manage');
            Route::get('/edit/{id}', [ColorController::class, 'edit'])->name('color.edit');
            Route::post('/update', [ColorController::class, 'update'])->name('color.update');
            Route::post('/delete/{id}', [ColorController::class, 'delete'])->name('color.delete');
        });
        Route::prefix('attribute')->group(function () {
            Route::get('/add', [AttributeController::class, 'index'])->name('attribute.add');
            Route::post('/new', [AttributeController::class, 'create'])->name('attribute.new');
            Route::get('/manage', [AttributeController::class, 'manage'])->name('attribute.manage');
            Route::get('/edit/{id}', [AttributeController::class, 'edit'])->name('attribute.edit');
            Route::post('/update', [AttributeController::class, 'update'])->name('attribute.update');
            Route::post('/delete/{id}', [AttributeController::class, 'delete'])->name('attribute.delete');
        });
        Route::prefix('size')->group(function () {
            Route::get('/add', [SizeController::class, 'index'])->name('size.add');
            Route::post('/new', [SizeController::class, 'create'])->name('size.new');
            Route::get('/manage', [SizeController::class, 'manage'])->name('size.manage');
            Route::get('/edit/{id}', [SizeController::class, 'edit'])->name('size.edit');
            Route::post('/update', [SizeController::class, 'update'])->name('size.update');
            Route::post('/delete/{id}', [SizeController::class, 'delete'])->name('size.delete');
        });
        Route::prefix('shipping-cost')->group(function () {
            Route::get('/add', [ShippingCostController::class, 'manage'])->name('shipping-cost.add');
            Route::post('/new', [ShippingCostController::class, 'create'])->name('shipping-cost.new');
            Route::get('/manage', [ShippingCostController::class, 'index'])->name('shipping-cost.manage');
            Route::get('/edit/{id}', [ShippingCostController::class, 'edit'])->name('shipping-cost.edit');
            Route::post('/update', [ShippingCostController::class, 'update'])->name('shipping-cost.update');
            Route::post('/delete/{id}', [ShippingCostController::class, 'delete'])->name('shipping-cost.delete');
        });
        Route::prefix('shipping-free')->group(function () {
            Route::get('/add', [ShippingFreeController::class, 'index'])->name('shipping-free.add');
            Route::post('/update', [ShippingFreeController::class, 'update'])->name('shipping-free.update');
        });
        Route::prefix('attribute-value')->group(function () {
            Route::get('/add/{id}', [AttributeDetailController::class, 'index'])->name('attribute-detail.add');
            Route::post('/new', [AttributeDetailController::class, 'create'])->name('attribute-detail.new');
            Route::get('/manage', [AttributeDetailController::class, 'manage'])->name('attribute-detail.manage');
            Route::get('/edit/{id}', [AttributeDetailController::class, 'edit'])->name('attribute-detail.edit');
            Route::post('/update', [AttributeDetailController::class, 'update'])->name('attribute-detail.update');
            Route::post('/delete/{id}', [AttributeDetailController::class, 'delete'])->name('attribute-detail.delete');
        });

        Route::prefix('privacy')->group(function () {
            Route::get('/add', [PrivacyController::class, 'index'])->name('privacy.add');
            Route::post('/new', [PrivacyController::class, 'create'])->name('privacy.new');
            Route::get('/manage', [PrivacyController::class, 'manage'])->name('privacy.manage');
            Route::get('/edit/{id}', [PrivacyController::class, 'edit'])->name('privacy.edit');
            Route::post('/update', [PrivacyController::class, 'update'])->name('privacy.update');
            Route::post('/delete/{id}', [PrivacyController::class, 'delete'])->name('privacy.delete');
        });

        Route::prefix('return-and-refund')->group(function () {
            Route::get('/add', [ReturnAndRefundController::class, 'index'])->name('return.add');
            Route::post('/new', [ReturnAndRefundController::class, 'create'])->name('return.new');
            Route::get('/manage', [ReturnAndRefundController::class, 'manage'])->name('return.manage');
            Route::get('/edit/{id}', [ReturnAndRefundController::class, 'edit'])->name('return.edit');
            Route::post('/update', [ReturnAndRefundController::class, 'update'])->name('return.update');
            Route::post('/delete/{id}', [ReturnAndRefundController::class, 'delete'])->name('return.delete');
        });

        Route::prefix('general-settings')->group(function () {
            Route::get('/add', [GeneralSettingController::class, 'index'])->name('setting.add');
            Route::post('/new', [GeneralSettingController::class, 'create'])->name('setting.new');
            Route::get('/manage', [GeneralSettingController::class, 'manage'])->name('setting.manage');
            Route::get('/edit/{id}', [GeneralSettingController::class, 'edit'])->name('setting.edit');
            Route::post('/update', [GeneralSettingController::class, 'update'])->name('setting.update');
            Route::post('/delete/{id}', [GeneralSettingController::class, 'delete'])->name('setting.delete');
        });

        Route::prefix('about-us-admin')->group(function () {
            Route::get('/add', [AboutUsController::class, 'index'])->name('about-us.add');
            Route::post('/new', [AboutUsController::class, 'create'])->name('about-us.new');
            Route::get('/manage', [AboutUsController::class, 'manage'])->name('about-us.manage');
            Route::get('/edit/{id}', [AboutUsController::class, 'edit'])->name('about-us.edit');
            Route::post('/update/{id}', [AboutUsController::class, 'update'])->name('about-us.update');
            Route::post('/delete/{id}', [AboutUsController::class, 'delete'])->name('about-us.delete');
        });

        Route::prefix('google-analytics')->group(function () {
            Route::get('/add', [GoogleAnalyticController::class, 'index'])->name('google-analytic.add');
            Route::post('/new', [GoogleAnalyticController::class, 'create'])->name('google-analytic.new');
            Route::get('/manage', [GoogleAnalyticController::class, 'manage'])->name('google-analytic.manage');
            Route::get('/edit/{id}', [GoogleAnalyticController::class, 'edit'])->name('google-analytic.edit');
            Route::post('/update', [GoogleAnalyticController::class, 'update'])->name('google-analytic.update');
            Route::post('/delete/{id}', [GoogleAnalyticController::class, 'delete'])->name('google-analytic.delete');
        });

        Route::prefix('orders')->group(function (){
            Route::get('/all-orders', [OrderController::class, 'index'])->name('order.manage');
            Route::get('/pending-orders', [OrderController::class, 'pending'])->name('order.pending');
            Route::get('/in-completed-orders', [OrderController::class, 'in_completed'])->name('order.in_completed');
            Route::get('/confirmed-orders', [OrderController::class, 'confirmed'])->name('order.confirmed');
            Route::get('/proccessing-orders', [OrderController::class, 'proccessing'])->name('order.proccessing');
            Route::get('/delivered-orders', [OrderController::class, 'delivered'])->name('order.delivered');
            Route::get('/shipped-orders', [OrderController::class, 'shipped'])->name('order.shipped');
            Route::get('/canceled-orders', [OrderController::class, 'canceled'])->name('order.canceled');
            Route::get('/order-show/{id}', [OrderController::class, 'show'])->name('order.show');
            Route::post('/order-delete/{id}', [OrderController::class, 'delete'])->name('order.delete');
            Route::get('/order/{id}/courier-reports', [OrderController::class, 'fetchCourierReport'])->name('order.courier.report');
            Route::post('/order-payment-status-update', [OrderController::class, 'paymentStatusUpdate'])->name('order-payment-status.update');
            Route::post('/order-status-update', [OrderController::class, 'orderStatusUpdate'])->name('order-status.update');
        });
    });
});
