<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AffiliatesController;
use App\Http\Controllers\Admin\AffiliateWithdrawController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BannarController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CampingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CommissionLevelController;
use App\Http\Controllers\Admin\CommonSectionController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\LegalPolicyController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerContactController;
use App\Http\Controllers\Admin\CustomerReviewController;
use App\Http\Controllers\Admin\LevelSystemController;
use App\Http\Controllers\Admin\LevelSystemWithdrawalController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductCommisionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SellerCommissionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\DetailController;
use App\Http\Controllers\Admin\HowToBuyController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\SubSubCategoryController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\EbookLibraryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\ShowroomController;
use App\Http\Controllers\Admin\VendorsController;
use App\Http\Controllers\Admin\WebController;
use App\Http\Controllers\ShipingController;
use App\Models\EbookLibrary;
use Illuminate\Support\Facades\Route;
// Super Admin Auth
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');


Route::prefix('admin')
    // ->middleware(['auth:admin', 'admin.only', 'role:super-admin'])
    ->middleware(['auth:admin', 'admin.only', 'admin.has.role'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminProfileController::class, 'dashboard'])->name('dashboard');
        // Route::get('/dashboard', function () {
        //     return view('admin.dashboard');
        // })->name('dashboard');

        Route::post('/admin/upload-image', function (\Illuminate\Http\Request $request) {
            $path = $request->file('image')->store('summernote', 'public');
            return response()->json(['url' => Storage::url($path)]);
        })->middleware('auth');

        Route::get('/profile/settings', [AdminProfileController::class, 'settings'])->name('profile.settings');
        Route::put('/profile/settings', [AdminProfileController::class, 'updateSettings'])->name('profile.settings.update');

        Route::get('/change-password', [AdminProfileController::class, 'changePassword'])->name('change.password');
        Route::put('/change-password', [AdminProfileController::class, 'updatePassword'])->name('change.password.update');

        Route::post('/currency-update', [AdminProfileController::class, 'updateCurrency'])->name('currency.update');



        Route::get('/check-email', function(\Illuminate\Http\Request $request) {
            $exists = \App\Models\User::where('email', $request->email)->exists();
            return response()->json(['exists' => $exists]);
        })->name('check-email');

        Route::get('/check-phone', function(\Illuminate\Http\Request $request) {
            $exists = \App\Models\User::where('phone', $request->phone)->exists();
            return response()->json(['exists' => $exists]);
        })->name('check-phone');


        Route::resource('settings', SettingController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('customers', CustomerController::class);

        Route::resource('products', ProductController::class);
        // admin prefix thakle tar moddhei rakho
        Route::delete('/products/remove-image/{id}', [ProductController::class, 'removeImage'])->name('products.removeImage');


        Route::get('/seller/product', [ProductController::class, 'sellerProduct'])->name('seller.product');

        // AJAX routes Category Subcategory Sub Sub Category
        Route::get('ajax/subcategories/{category}', [ProductController::class, 'getSubCategories']);
        Route::get('ajax/subsubcategories/{subcategory}', [ProductController::class, 'getSubSubCategories']);

        Route::post('categories/update-order', [CategoryController::class, 'updateOrder'])->name('categories.updateOrder');
        Route::post('subcategories/update-order', [SubCategoryController::class, 'updateOrder'])->name('subcategories.updateOrder');
        Route::resource('categories', CategoryController::class);
        Route::resource('subcategories', SubCategoryController::class);
        Route::resource('subsubcategories', SubSubCategoryController::class)->parameters(['subsubcategories' => 'subSubCategory']);
        // Ajax for dynamic Product Subcategory
        Route::get('ajax/subcategories/{category}', [SubSubCategoryController::class, 'getSubCategories'])->name('ajax.subcategories');
        Route::get('ajax/subsubcategories/{subcategory}', [SubSubCategoryController::class, 'getSubSubCategories']);


        Route::resource('brands', BrandController::class);
        Route::resource('colors', ColorController::class);
        Route::resource('sizes', SizeController::class);
        Route::resource('customer-review', CustomerReviewController::class);
        Route::resource('blogs', BlogController::class);


        // <<===========WEBSITE===========>>>

        // SMTP
        Route::get('smtp/{id}', [WebController::class, 'smtpindex'])->name('smtp.edit');
        Route::post('smtp/{id}', [WebController::class, 'smtp'])->name('smtp.update');
        // Pixel
        Route::get('pixel/{id}', [WebController::class, 'pixelindex'])->name('pixel.edit');
        Route::post('pixel/{id}', [WebController::class, 'pixel'])->name('pixel.update');


        // Marketing SETUP PAGE
        Route::get('marketing/setup', [WebController::class, 'marketingSetup'])->name('marketing.setup');
        Route::post('facebook/{id}', [WebController::class, 'facebook'])->name('facebook.update');
        Route::post('google/{id}', [WebController::class, 'google'])->name('google.update');
        Route::post('tag-manager/{id}', [WebController::class, 'TagManager'])->name('tag-manager.update');

        // PAYMENT SETUP PAGE
        Route::get('payment/setup', [WebController::class, 'paymentSetup'])->name('payment.setup');
        Route::post('bkash/{id}', [WebController::class, 'bkash'])->name('bkash.update');
        Route::post('nagad/{id}', [WebController::class, 'nagad'])->name('nagad.update');
        Route::post('sslcz/{id}', [WebController::class, 'sslcz'])->name('sslcz.update');
        // CURIORE
        Route::get('courier', [WebController::class, 'curiore'])->name('courier.setup');
        Route::post('stredfast/{id}', [WebController::class, 'stredfast'])->name('stredfast.update');
        Route::post('pathau/{id}', [WebController::class, 'pathau'])->name('pathau.update');
        Route::post('redx/{id}', [WebController::class, 'redx'])->name('redx.update');
        Route::post('curiores/{id}', [WebController::class, 'curiores'])->name('curiores.update');
        //Coupon
        Route::resource('coupons', CouponController::class);
        Route::resource('bannars', BannarController::class);
        Route::resource('details', DetailController::class);
        Route::resource('shiping', ShipingController::class);

        // <<<<<--Orders-->>>>>


        Route::get('orders/create',      [OrderController::class, 'create'])->name('orders-create');
        Route::post('orders',            [OrderController::class, 'store'])->name('orders.store');
        Route::get('orders/{id}/edit',   [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('orders/{id}',        [OrderController::class, 'update'])->name('orders.update');


        Route::get('all-orders', [OrderController::class, 'allOrders'])->name('all-orders');
        Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
         //Pending Orders
        Route::get('pending-orders', [OrderController::class, 'pendingOrders'])->name('pending-orders');
        Route::get('processing-orders', [OrderController::class, 'processingOrders'])->name('processing-orders');
        Route::get('on-the-way-orders', [OrderController::class, 'onTheWayOrders'])->name('on-the-way-orders');
        Route::get('hold-orders', [OrderController::class, 'holdOrders'])->name('hold-orders');
        Route::get('courier-orders', [OrderController::class, 'courierOrders'])->name('courier-orders');
        Route::get('complete-orders', [OrderController::class, 'completeOrders'])->name('complete-orders');
        Route::get('cancelled-orders', [OrderController::class, 'cancelledOrders'])->name('cancelled-orders');




        // routes/web.php or admin routes group
        Route::get('/orders/send-pathao/{id}', [OrderController::class, 'sendToPathao'])->name('orders.sendPathao');


        Route::get('/pathao-stores', [OrderController::class, 'getPathaoStores']);


        // Steadfast - Send Single Order
        Route::get('/orders/steadfast/send/{id}', [OrderController::class, 'sendToSteadfast'])
            ->name('orders.send.steadfast');

        // Steadfast - Check Delivery Status
        Route::get('/orders/steadfast/status/{invoice}', [OrderController::class, 'steadfastStatus'])
            ->name('orders.steadfast.status');

        // Steadfast - Check Balance
        Route::get('/orders/steadfast/balance', [OrderController::class, 'steadfastBalance'])
            ->name('orders.steadfast.balance');

        // Steadfast - Create Return Request
        Route::post('/orders/steadfast/return/{consignment_id}', [OrderController::class, 'steadfastReturn'])
            ->name('orders.steadfast.return');

            Route::get('/orders/send-redx/{id}', [OrderController::class, 'sendToRedX'])->name('orders.sendRedX');






       Route::get('stock-report', [OrderController::class,'stock_report'])->name('stock_report');
       Route::get('order-report', [OrderController::class,'order_report'])->name('order_report');



        // <<<<<--Affiliate-->>>>>
        Route::resource('all-users',AffiliatesController::class);

        // <<<<<--Vendor-->>>>>
        Route::resource('all-sellers',VendorsController::class);
        Route::get('sellers-withdrawal', [VendorsController::class, 'sellersWithdrawal'])->name('sellers-withdrawal');
        Route::post('sellers-withdrawal/{id}/status', [VendorsController::class, 'updateStatus'])->name('sellers-withdrawal.updateStatus');


        // product commision
        Route::resource('product-commission',ProductCommisionController::class);


        Route::resource('marketer-withdraw', AffiliateWithdrawController::class);
        Route::post('marketer-withdraw/{id}/status', [AffiliateWithdrawController::class, 'updateStatus'])->name('marketer-withdraw.updateStatus');

        Route::resource('campings',CampingController::class);


        Route::resource('offers',OfferController::class);
        Route::resource('about-us',AboutUsController::class);
        Route::resource('common-section',CommonSectionController::class);
        Route::resource('commission-level',CommissionLevelController::class);
        Route::resource('seller-commision',SellerCommissionController::class);
        Route::resource('teams',TeamController::class);
        Route::resource('clients',ClientController::class);
        Route::resource('customer-contact',CustomerContactController::class);
        Route::resource('contacts',ContactController::class);
        Route::resource('how-to-buy',HowToBuyController::class);
        Route::resource('legal-policy',LegalPolicyController::class);
        Route::resource('navigation',NavigationController::class);
        Route::resource('showroom',ShowroomController::class);


        Route::resource('levels',LevelSystemController::class);
        Route::get('levels-report',[LevelSystemController::class,'report'])->name('level.report');
        Route::resource('levels-withdrawal',LevelSystemWithdrawalController::class);
        Route::post('levels-withdrawal/{id}/status', [LevelSystemWithdrawalController::class, 'updateStatus'])->name('levels-withdrawal.updateStatus');




       Route::get('about', [App\Http\Controllers\Admin\AboutController::class, 'index'])->name('about.index');
        Route::put('about/{id}', [App\Http\Controllers\Admin\AboutController::class, 'update'])->name('about.update');
        Route::resource('ebook-library',EbookLibraryController::class);
        Route::resource('faqs',FaqController::class);


    });
