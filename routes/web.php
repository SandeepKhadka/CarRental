<?php

use App\Http\Controllers\ApparelController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\UserOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Seller\CouponController as SellerCouponController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Frontend Section

Route::get('/', [App\Http\Controllers\Frontend\IndexController::class, 'home'])->name('front.home');
Route::get('/', [App\Http\Controllers\Frontend\IndexController::class, 'home'])->name('front.home');
Route::get('/category', [App\Http\Controllers\Frontend\IndexController::class, 'category'])->name('category');
// Route::get('/cart', [App\Http\Controllers\Frontend\IndexController::class, 'cart'])->name('cart');
// Route::get('/checkout', [App\Http\Controllers\Frontend\IndexController::class, 'checkout'])->name('checkout');
// Route::get('/wishlist', [App\Http\Controllers\Frontend\IndexController::class, 'wishlist'])->name('wishlist');
Route::get('/category/{slug?}/{filter?}', [App\Http\Controllers\Frontend\IndexController::class, 'single_category'])->name('single_category');

// Cart Section
Route::get('cart', [App\Http\Controllers\Frontend\CartController::class, 'cart'])->name('cart');
Route::post('cart/store', [App\Http\Controllers\Frontend\CartController::class, 'cartStore'])->name('cart.store');
Route::post('cart/delete', [App\Http\Controllers\Frontend\CartController::class, 'cartDelete'])->name('cart.delete');
Route::post('cart/update', [App\Http\Controllers\Frontend\CartController::class, 'cartUpdate'])->name('cart.update');

// Wishlist Section
Route::get('wishlist', [\App\Http\Controllers\Frontend\WishlistController::class, 'wishlist'])->name('wishlist');
Route::post('wishlist/store', [\App\Http\Controllers\Frontend\WishlistController::class, 'wishlistStore'])->name('wishlist.store');
Route::post('wishlist/move-to-cart', [\App\Http\Controllers\Frontend\WishlistController::class, 'moveToCart'])->name('wishlist.move.cart');
Route::post('wishlist/delete', [\App\Http\Controllers\Frontend\WishlistController::class, 'wishlistDelete'])->name('wishlist.delete');

// Shop Section
Route::get('shop/{slug?}', [\App\Http\Controllers\Frontend\IndexController::class, 'shop'])->name('shop');
Route::post('shop-filter', [\App\Http\Controllers\Frontend\IndexController::class, 'shopFilter'])->name('shop.filter');

// Search product and auto search product
Route::get('autosearch', [\App\Http\Controllers\Frontend\SearchController::class, 'autoSearch'])->name('autosearch');
Route::get('search/{slug?}/{filter?}/', [\App\Http\Controllers\Frontend\SearchController::class, 'search'])->name('search');
Route::post('search/filter', [\App\Http\Controllers\Frontend\SearchController::class, 'searchFilter'])->name('search.filter');


// Product detail
Route::get('product_detail/{slug}', [\App\Http\Controllers\Frontend\IndexController::class, 'productDetail'])->name('productDetail');
Route::get('refer_product_detail/{slug}/{referer?}', [\App\Http\Controllers\Frontend\ReferAndEarnController::class, 'productDetail'])->name('refer.product');


//Product Review
Route::post('product-review/{slug}', [\App\Http\Controllers\ProductReviewController::class, 'productReview'])->name('product.review');

Route::post('/predict', [\App\Http\Controllers\MachineLearning\FakeReviewDetectionController::class, 'predict1'])->name('predict');
// Route::get('/login', [App\Http\Controllers\Frontend\IndexController::class, 'checkout'])->name('login');

// Seller Registration
Route::get('/seller/register', [\App\Http\Controllers\Seller\SellerRegistrationController::class, 'registerShop'])->name('seller.register');
Route::post('/seller/register/store', [\App\Http\Controllers\Seller\SellerRegistrationController::class, 'storeRegisterDetails'])->name('seller.register.store');

// Reverse Image Search
Route::post('/upload-image', [\App\Http\Controllers\MachineLearning\ReverseImageSearchController::class, 'uploadImage'])->name('upload.image');
Route::get('/similar-image', [\App\Http\Controllers\MachineLearning\ReverseImageSearchController::class, 'similarImageSearch'])->name('similar.image');

// Chatify section
// Route::get('/chatify/user/{id?}', function ($id = null) {
//     return view('chatify.index', ['id' => $id]);
// })->name('chatify.user');

// End frontend section

// Auth::routes(['register' => false]);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/logout', [App\Http\Controllers\HomeController::class, 'index'])->name('logout');


// Admin Dashboard
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin');

    //Banner Section
    Route::resource('banner', BannerController::class);
    Route::post('banner_status', [App\Http\Controllers\BannerController::class, 'bannerStatus'])->name('banner.status');

    //Category Section
    Route::resource('category', CategoryController::class);
    Route::post('category_status', [App\Http\Controllers\CategoryController::class, 'categoryStatus'])->name('category.status');

    Route::post('category/{id}/child', [\App\Http\Controllers\CategoryController::class, 'getChildByParentID']);

    //Brand Section
    Route::resource('brand', BrandController::class);
    Route::post('brand_status', [App\Http\Controllers\BrandController::class, 'brandStatus'])->name('brand.status');

    //Product Section
    Route::resource('product', ProductController::class);
    Route::post('product_status', [App\Http\Controllers\ProductController::class, 'productStatus'])->name('product.status');

    //Product Attribute Section
    Route::get('product_attribute/{id}', [App\Http\Controllers\ProductController::class, 'productAttribute'])->name('product.attribute');
    Route::post('add_product_attribute/{id}', [App\Http\Controllers\ProductController::class, 'addProductAttribute'])->name('addProduct.attribute');
    Route::delete('product_attribute_delete/{id}', [App\Http\Controllers\ProductController::class, 'deleteProductAttribute'])->name('product.attribute.destroy');

    //User Section
    Route::resource('user', UserController::class);
    Route::post('user_status', [App\Http\Controllers\UserController::class, 'userStatus'])->name('user.status');

    //Apparel Section
    Route::resource('apparel', ApparelController::class);
    Route::post('apparel_status', [App\Http\Controllers\ApparelController::class, 'apparelStatus'])->name('apparel.status');

    //Coupon Section
    Route::resource('coupon', CouponController::class);
    Route::post('coupon_status', [App\Http\Controllers\CouponController::class, 'couponStatus'])->name('coupon.status');

    //Shipping Section
    Route::resource('shipping', ShippingController::class);
    Route::post('shipping_status', [App\Http\Controllers\ShippingController::class, 'shippingStatus'])->name('shipping.status');

    //Order Section
    Route::resource('order', OrderController::class);
    Route::post('order_status/{id}', [App\Http\Controllers\OrderController::class, 'orderStatus'])->name('order.status');
    Route::get('order_details/{id}', [App\Http\Controllers\OrderController::class, 'orderDetails'])->name('order.details');

    //Shop Section
    Route::resource('shop', ShopController::class);
    Route::post('shop_status/{id?}', [App\Http\Controllers\ShopController::class, 'shopStatus'])->name('shop.status');
    Route::post('shop_update_status/{id?}', [App\Http\Controllers\ShopController::class, 'shopUpdateStatus'])->name('shop.update.status');
});

// Seller Dashboard
Route::group(['prefix' => 'seller', 'middleware' => ['auth', 'seller']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'seller'])->name('vendor');

    //Category Section
    Route::resource('seller-category', CategoryController::class);
    Route::post('category_status', [App\Http\Controllers\CategoryController::class, 'categoryStatus'])->name('category.status');
    Route::post('category/{id}/child', [\App\Http\Controllers\CategoryController::class, 'getChildByParentID']);

    //Product Section
    Route::resource('seller-product', SellerProductController::class);
    Route::post('seller_product_status', [App\Http\Controllers\Seller\ProductController::class, 'productStatus'])->name('seller.product.status');

    //Product Attribute Section
    Route::get('product_attribute/{id}', [App\Http\Controllers\Seller\ProductController::class, 'productAttribute'])->name('seller.product.attribute');
    Route::post('add_product_attribute/{id}', [App\Http\Controllers\Seller\ProductController::class, 'addProductAttribute'])->name('seller.addProduct.attribute');
    Route::delete('product_attribute_delete/{id}', [App\Http\Controllers\Seller\ProductController::class, 'deleteProductAttribute'])->name('seller.product.attribute.destroy');

    //Order Section
    Route::resource('seller-order', SellerOrderController::class);
    // Route::post('order_status/{id}', [App\Http\Controllers\Seller\OrderController::class, 'orderStatus'])->name('order.status');
    Route::get('order_details/{id}', [App\Http\Controllers\Seller\OrderController::class, 'orderDetails'])->name('seller.order.details');

    //Shop Settings Section
    Route::get('shop/display_setting', [App\Http\Controllers\Seller\ShopSettingContoller::class, 'displayShopSetting'])->name('display.shop.setting');
    Route::post('shop/store_details', [App\Http\Controllers\Seller\ShopSettingContoller::class, 'storeShopDetails'])->name('store.shop.details');
    Route::post('shop/update_details/{id}', [App\Http\Controllers\Seller\ShopSettingContoller::class, 'updateShopDetails'])->name('update.shop.details');

    //Coupon Section
    Route::resource('seller-coupon', SellerCouponController::class);
    Route::post('seller_coupon_status', [App\Http\Controllers\Seller\CouponController::class, 'sellerCouponStatus'])->name('seller.coupon.status');
    Route::post('private_coupon', [App\Http\Controllers\CouponController::class, 'privateCoupon'])->name('private.coupon');
});

// Customer
Route::group(['prefix' => 'customer', 'middleware' => ['auth', 'customer']], function () {
    // Route::get('/', [App\Http\Controllers\HomeController::class, 'customer'])->name('customer');
    Route::get('/', [App\Http\Controllers\Frontend\IndexController::class, 'home'])->name('customer');
    Route::get('/category', [App\Http\Controllers\Frontend\IndexController::class, 'category'])->name('category');
    // Route::get('/category/{slug}', [App\Http\Controllers\Frontend\IndexController::class, 'single_category'])->name('single_category');

    // Route::get('/', [App\Http\Controllers\Frontend\IndexController::class, 'home'])->name('front.home');

    //Checkout Section
    Route::get('checkout', [App\Http\Controllers\Frontend\CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('refer-checkout/{referrer}', [App\Http\Controllers\Frontend\ReferAndEarnController::class, 'checkout'])->name('refer.checkout');
    Route::post('checkout/store', [App\Http\Controllers\Frontend\CheckoutController::class, 'checkoutStore'])->name('checkout.store');
    Route::get('payment/response', [App\Http\Controllers\PaymentController::class, 'paymentResponse'])->name('esewa.pay');

    //Cart Section
    Route::get('cart/store/details', [App\Http\Controllers\Frontend\CartController::class, 'addToCart'])->name('cart.store.details');

    // Track Order Section
    Route::get('track/order', [\App\Http\Controllers\Frontend\TrackOrderController::class, 'trackOrder'])->name('track.order');
    Route::get('search/order/{order_number?}', [\App\Http\Controllers\Frontend\TrackOrderController::class, 'searchOrder'])->name('search.order');

    // User Order Section
    Route::resource('my_order', UserOrderController::class);
    Route::post('order-filter', [\App\Http\Controllers\Frontend\UserOrderController::class, 'orderFilter'])->name('order.filter');
    // Route::get('my/orders', [\App\Http\Controllers\Frontend\UserOrderController::class, 'myOrders'])->name('my.order');

    // Coupon Section
    Route::post('coupon/add', [App\Http\Controllers\Frontend\CartController::class, 'couponAdd'])->name('coupon.add');

    // Refer And Earn Section
    Route::post('send_link', [App\Http\Controllers\Frontend\ReferAndEarnController::class, 'sendLink'])->name('send.link');

    //Reedem Page
    Route::get('reedem', [\App\Http\Controllers\Frontend\ReedemController::class, 'reedem'])->name('reedem');
    Route::get('reedem/checkout', [\App\Http\Controllers\Frontend\ReedemController::class, 'checkout'])->name('reedem.checkout');
    Route::post('reedem/checkout/store', [\App\Http\Controllers\Frontend\ReedemController::class, 'storeCheckout'])->name('reedem.checkout.store');
    Route::post('check/referral', [\App\Http\Controllers\Frontend\ReedemController::class, 'checkReferral'])->name('check.referral');
});


//Esewa Payment
Route::get('/success', [App\Http\Controllers\Frontend\CheckoutController::class, 'esewaPaySuccess']);
Route::get('/failure', [App\Http\Controllers\Frontend\CheckoutController::class, 'esewaPayFailed']);
