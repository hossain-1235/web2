<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\SslCommerzPaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/product/details/{slug}', [FrontendController::class, 'product_details'])->name('product.details');
Route::get('customer/register', [FrontendController::class, 'customer_register'])->name('customer.register');
Route::get('customer/login', [FrontendController::class, 'customer_login'])->name('customer.login');
Route::get('checkout', [FrontendController::class, 'checkout'])->name('checkout');
Route::get('search/products', [FrontendController::class, 'search_product'])->name('search.product');
Route::post('review/{id}', [FrontendController::class, 'review'])->name('review');
Route::get('category/product/{slug}', [FrontendController::class, 'category_product'])->name('category.product');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// user
Route::get('/edit/profile', [UserController::class, 'edit_profile'])->middleware(['auth', 'verified'])->name('edit.profile');
Route::post('/update/profile', [UserController::class, 'update_profile'])->middleware(['auth', 'verified'])->name('update.profile');
Route::post('/update/password', [UserController::class, 'update_password'])->middleware(['auth', 'verified'])->name('update.password');

//Category
Route::get('add/category', [CategoryController::class, 'add_category'])->name('add.category');
Route::post('store/category', [CategoryController::class, 'store_category'])->name('store.category');
Route::get('category/delete/{id}', [CategoryController::class, 'category_delete'])->name('category.delete');
Route::get('permanent/delete/{id}', [CategoryController::class, 'permanent_delete'])->name('permanent.delete');
Route::get('restore/{id}', [CategoryController::class, 'restore'])->name('restore');
Route::get('add/subcategory', [CategoryController::class, 'add_subcategory'])->name('add.subcategory');
Route::post('store/subcategory', [CategoryController::class, 'store_subcategory'])->name('store.subcategory');
Route::get('del/subcategory/{id}', [CategoryController::class, 'del_subcategory'])->name('del.subcategory');

//Tag
Route::get('add/tag', [TagController::class, 'add_tag'])->name('add.tag');
Route::post('store/tag', [TagController::class, 'store_tag'])->name('store.tag');
Route::get('delete/tag/{id}', [TagController::class, 'delete_tag'])->name('delete.tag');

//Product
Route::get('add/product', [ProductController::class, 'add_product'])->name('add.product');
Route::post('store/product', [ProductController::class, 'store_product'])->name('store.product');
Route::get('product/list', [ProductController::class, 'product_list'])->name('product.list');
Route::get('add/variant', [ProductController::class, 'add_variant'])->name('add.variant');
Route::post('add/color', [ProductController::class, 'add_color'])->name('add.color');
Route::post('add/size', [ProductController::class, 'add_size'])->name('add.size');
Route::get('inventory/{id}', [ProductController::class, 'inventory'])->name('inventory');
Route::post('inventory/store/{id}', [ProductController::class, 'inventory_store'])->name('inventory.store');

//Customer
Route::post('customer/store', [CustomerController::class, 'customer_store'])->name('customer.store');
Route::post('customer/signin', [CustomerController::class, 'customer_signin'])->name('customer.signin');
Route::get('customer/profile', [CustomerController::class, 'customer_profile'])->name('customer.profile');
Route::get('customer/logout', [CustomerController::class, 'customer_logout'])->name('customer.logout');
Route::post('customer/update', [CustomerController::class, 'customer_update'])->name('customer.update');
Route::get('customer/orders', [CustomerController::class, 'customer_orders'])->name('customer.orders');
Route::get('invoice/download/{order_id}', [CustomerController::class, 'invoice_dowload'])->name('invoice.download');

//passreset
Route::get('forgot/password', [CustomerController::class, 'forgot_password'])->name('forgot.password');
Route::post('send/password/request', [CustomerController::class, 'send_password_request'])->name('send.password.request');
Route::get('pass_reset_form/{token}', [CustomerController::class, 'pass_reset_form'])->name('pass.reset.form');
Route::post('pass_reset_confirm/{token}', [CustomerController::class, 'pass_reset_confirm'])->name('pass.reset.confirm');

//Cart
Route::post('/getSize', [CartController::class, 'getSize']);
Route::post('/getQuantity', [CartController::class, 'getQuantity']);
Route::post('/add/cart', [CartController::class, 'add_cart'])->name('add.cart');
Route::get('/remove/cart/{id}', [CartController::class, 'remove_cart'])->name('remove.cart');

//Coupon
Route::get('coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('add/coupon', [CouponController::class, 'add_coupon'])->name('add.coupon');
 
// Checkout
Route::post('getCity', [CheckoutController::class, 'getCity']);
Route::post('store/checkout', [CheckoutController::class, 'store_checkout'])->name('store.checkout');
Route::get('order/success/{id}', [CheckoutController::class, 'order_success'])->name('order.success');

//Order
Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
Route::post('/order/status/{id}', [OrderController::class, 'order_status'])->name('order.status');


//stripe
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe/{id}', 'stripe')->name('stripe');
    Route::post('stripe/{order_id}', 'stripePost')->name('stripe.post');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



// SSLCOMMERZ Start
Route::get('/pay/{order_id}', [SslCommerzPaymentController::class, 'index'])->name('pay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

//Role Manager
Route::get('role/manager', [RoleController::class, 'role_manager'])->name('role.manager');
Route::post('create/permission', [RoleController::class, 'create_permission'])->name('create.permission');
Route::post('add/role', [RoleController::class, 'add_role'])->name('add.role');
Route::post('assign/role', [RoleController::class, 'assign_role'])->name('assign.role');
Route::get('remove/role/{id}', [RoleController::class, 'remove_role'])->name('remove.role');
Route::get('delete/role/{role_id}', [RoleController::class, 'delete_role'])->name('delete.role');

require __DIR__.'/auth.php';
