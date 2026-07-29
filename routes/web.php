<?php


use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SslCommerzPaymentController;

Route::get('auth/{provider}', [WebsiteController::class, 'redirect'])->name('social.redirect');
Route::get('auth/{provider}/callback', [WebsiteController::class, 'callback'])->name('social.callback');

Route::get('/cmd', function () {
   
    Artisan::call('storage:link');
    Artisan::call('optimize:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    return 'Done';
});



Route::post('/set-locale', function () {
    session(['locale' => request('locale')]);
    return back();
})->name('setLocale');





Route::get('/', [WebsiteController::class, 'index'])->name('index');
Route::post('/category-sizes', [WebsiteController::class, 'categorySizes'])->name('category.sizes');
Route::post('/category-products-by-size', [WebsiteController::class, 'categoryProductsBySize'])->name('category.products.bySize');
Route::get('/brands', [WebsiteController::class, 'brands'])->name('brands');
Route::get('/showrooms', [WebsiteController::class, 'showrooms'])->name('showrooms');
Route::get('/showrooms/{id}', [WebsiteController::class, 'showroomDetail'])->name('showroom.detail');

Route::get('/about', [WebsiteController::class, 'about'])->name('about');
Route::get('/sellers', [WebsiteController::class, 'sellers'])->name('sellers');
Route::get('/seller/{slug}', [WebsiteController::class, 'shop'])->name('seller.show');
Route::get('/seller-register', [WebsiteController::class, 'sellerRegister'])->name('seller.register');
Route::get('/seller-login', [WebsiteController::class, 'sellerLogin'])->name('seller.login');
Route::post('/seller/register', [WebsiteController::class, 'storeSeller'])->name('seller.register.store');


Route::get('/affiliate-register', [WebsiteController::class, 'affiliateRegister'])->name('affiliate.register');
Route::get('/affiliate-login', [WebsiteController::class, 'affiliateLogin'])->name('affiliate.login');
Route::post('/affiliate/register', [WebsiteController::class, 'storeaffiliate'])->name('affiliate.register.store');


// routes/web.php
Route::post('/review/store', [WebsiteController::class, 'reviewstore'])->name('review.store');


Route::get('/products', [WebsiteController::class, 'products'])->name('products');
Route::get('/blogs/{slug}', [WebsiteController::class, 'singleBlog'])->name('blogs-single');
Route::get('blogs', [WebsiteController::class, 'blogs'])->name('all-blogs');

Route::get('/product/{slug}/ref/{referal_code}', [WebsiteController::class, 'productSingleAffiliateReferal'])->name('referal.product');
Route::get('/product/{slug}/user/{referal_code}', [WebsiteController::class, 'productSingleAffiliateReferalUser'])->name('user.referal.product');
Route::get('/product/{slug}/affiliate/{affiliate_id}', [WebsiteController::class, 'productSingleAffiliate'])->name('product.show');
Route::get('/product/{slug}', [WebsiteController::class, 'productSingle'])->name('product.single');

Route::get('/checkout', [WebsiteController::class, 'checkout'])->name('checkout');
Route::post('/order-store', [WebsiteController::class, 'orderStore'])->name('order.store');

// Track Order
Route::get('/track-order', [WebsiteController::class, 'trackorder'])->name('track.order');
Route::get('/success/{order_id}', [WebsiteController::class, 'orderSuccess'])->name('order.success');




// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/pay', [SslCommerzPaymentController::class, 'pay'])->name('pay');
Route::post('/fail', [SslCommerzPaymentController::class, 'fail'])->name('fail');
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel'])->name('cancel');
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);

//SSLCOMMERZ END





Route::get('categories/{slug}', [WebsiteController::class, 'categories'])->name('categories');
Route::get('/subcategory/{id}/products', [WebsiteController::class, 'subcategoryProducts'])->name('subcategory.products');
Route::get('/live-search', [WebsiteController::class, 'liveSearch'])->name('product.liveSearch');
Route::post('/coupon/validate', [WebsiteController::class, 'validateCoupon'])->name('coupon.validate');



Route::get('/reviews', [WebsiteController::class, 'reviews'])->name('reviews');
Route::get('/contacts', [WebsiteController::class, 'contacts'])->name('contacts');
Route::post('/contacts-store', [WebsiteController::class, 'contactStore'])->name('contact.store');
Route::get('/how-to-buy', [WebsiteController::class, 'howToBuy'])->name('how.to.buy');


Route::get('/delivery-policy', [WebsiteController::class, 'deliveryPolicy'])->name('delivery-policy');
Route::get('/return-policy', [WebsiteController::class, 'returnPolicy'])->name('return-policy');
Route::get('/refund-policy', [WebsiteController::class, 'refundPolicy'])->name('refund-policy');
Route::get('/warranty-policy', [WebsiteController::class, 'warrantyPolicy'])->name('warranty-policy');
Route::get('/privacy-policy', [WebsiteController::class, 'privacyPolicy'])->name('privacy-policy');


Route::get('/about-us', [WebsiteController::class, 'aboutUs'])->name('about-us');
Route::get('/complaint', [WebsiteController::class, 'complaint'])->name('complaint');
Route::POST('/complaint-store', [WebsiteController::class, 'complaintStore'])->name('complaint.store');


Auth::routes(); // ✅ Removed ['verify' => true]



// User Dashboard
Route::middleware(['auth', 'no.admin'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::post('/user/location/save', [HomeController::class, 'saveLocation'])->name('user.location.save');
    Route::get('settings', [HomeController::class, 'settings'])->name('user.settings');
    Route::get('profile', [HomeController::class, 'profile'])->name('user.profile');
    Route::get('profile/edit', [HomeController::class, 'profileEdit'])->name('user.profile.edit');
    Route::put('/profile/update', [HomeController::class, 'update'])->name('user.profile.update');
    Route::get('password/edit', [HomeController::class, 'passwordEdit'])->name('user.password.edit');
    Route::post('/password-update', [HomeController::class, 'updatePassword'])->name('user.password.update');
    Route::post('/wishlist/add', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::get('/wishlist/list', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::get('/order/list', [WishlistController::class, 'Orderindex'])->name('order.index');
    Route::get('/order/view/{id}', [WishlistController::class, 'orderView'])->name('order.view');

    Route::get('/levels', [WishlistController::class, 'level'])->name('levels');
    Route::get('/sales-products', [WishlistController::class, 'salesProducts'])->name('sales-products');

    Route::get('sales-earning', [WishlistController::class, 'salesProductsEarning'])->name('sales-earning');
    Route::get('sales-withdrawal-history', [WishlistController::class, 'salesProductsWithdrawalHistory'])->name('sales-withdrawal-history');
    Route::get('level-withdrawal', [WishlistController::class, 'levelWithdrawal'])->name('level-withdraw');
    Route::post('/withdraw-level-store', [WishlistController::class, 'storeWithdrawLevel'])->name('withdraw-level.store');



});

require __DIR__.'/admin.php';
require __DIR__.'/vendor.php';
require __DIR__.'/affiliate.php';




// php artisan migrate:refresh --path=database/migrations/2026_07_20_173442_create_showrooms_table.php