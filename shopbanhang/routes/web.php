<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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

//frontend
Route::get('/', [HomeController::class,'index']);

Route::get('/trang-chu', [HomeController::class,'index']);
Route::get('/danh-muc-san-pham/{category_id}', [CategoryProduct::class,'show_category_home']);
Route::get('/thuong-hieu-san-pham/{brand_id}', [BrandProduct::class,'show_brand_home']);
Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class,'details_product']);
Route::post('/tim-kiem', [HomeController::class,'search']);
//backend

Route::get('/admin',[AdminController::class, 'index']);
Route::get('/dashboard',[AdminController::class, 'show_dashboard']);
Route::get('/logout',[AdminController::class, 'logout']);
Route::post('/admin-dashboard',[AdminController::class, 'dashboard']);

//category-product
Route::get('/add-category-product',[CategoryProduct::class, 'add_category_product']);
Route::get('/all-category-product',[CategoryProduct::class, 'all_category_product']);
Route::post('/save-category-product',[CategoryProduct::class, 'save_category_product']);

Route::get('/active-category-product/{category_product_id}',[CategoryProduct::class, 'active_category_product']);
Route::get('/unactive-category-product/{category_product_id}',[CategoryProduct::class, 'unactive_category_product']);

Route::get('/edit-category-product/{category_product_id}',[CategoryProduct::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}',[CategoryProduct::class, 'delete_category_product']);
Route::post('/update-category-product/{category_product_id}',[CategoryProduct::class, 'update_category_product']);

//Brand

Route::get('/add-brand-product',[BrandProduct::class, 'add_brand_product']);
Route::get('/all-brand-product',[BrandProduct::class, 'all_brand_product']);
Route::post('/save-brand-product',[BrandProduct::class, 'save_brand_product']);

Route::get('/active-brand-product/{brand_product_id}',[BrandProduct::class, 'active_brand_product']);
Route::get('/unactive-brand-product/{brand_product_id}',[BrandProduct::class, 'unactive_brand_product']);

Route::get('/edit-brand-product/{brand_product_id}',[BrandProduct::class, 'edit_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}',[BrandProduct::class, 'delete_brand_product']);
Route::post('/update-brand-product/{brand_product_id}',[BrandProduct::class, 'update_brand_product']);

//Product
Route::get('/add-product',[ProductController::class, 'add_product']);
Route::get('/all-product',[ProductController::class, 'all_product']);
Route::post('/save-product',[ProductController::class, 'save_product']);

Route::get('/active-product/{product_id}',[ProductController::class, 'active_product']);
Route::get('/unactive-product/{product_id}',[ProductController::class, 'unactive_product']);

Route::get('/edit-product/{product_id}',[ProductController::class, 'edit_product']);
Route::get('/delete-product/{product_id}',[ProductController::class, 'delete_product']);
Route::post('/update-product/{product_id}',[ProductController::class, 'update_product']);

//cart
Route::post('/save-cart',[CartController::class, 'save_cart']);
Route::get('/show-cart',[CartController::class, 'show_cart']);
Route::get('/delete-to-cart/{rowId}',[CartController::class, 'delete_to_cart']);
Route::post('/update-cart-quanlity',[CartController::class, 'update_cart_quanlity']);

//checkout

Route::get('/login-checkout',[CheckoutController::class, 'login_checkout']);
Route::get('/logout-checkout',[CheckoutController::class, 'logout_checkout']);
Route::post('/add-customer',[CheckoutController::class, 'add_customer']);
Route::get('/checkout',[CheckoutController::class, 'checkout']);
Route::post('/save-checkout-customer',[CheckoutController::class, 'save_checkout_customer']);
Route::post('/login-customer',[CheckoutController::class, 'login_customer']);
Route::get('/payment',[CheckoutController::class, 'payment']);
Route::post('/order-place',[CheckoutController::class, 'order_place']);

//order
Route::get('/manage-order',[CheckoutController::class, 'manage_order']);
Route::get('/view-order/{order_id}',[CheckoutController::class, 'view_order']);