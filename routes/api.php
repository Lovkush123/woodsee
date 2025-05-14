<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderListController;
use App\Http\Controllers\MainCategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BrandController;

// Get all users
Route::get('/users', [UserController::class, 'index']);

// Create a new user
Route::post('/users', [UserController::class, 'store']);

// Get a specific user by ID
Route::get('/users/{id}', [UserController::class, 'show']);

// Update a specific user by ID
Route::post('/users/{id}', [UserController::class, 'update']);

// User authentication
Route::post('/login', [UserController::class, 'login']);        // Login with email or username
// Delete a specific user by ID
Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
Route::post('/reset-password', [UserController::class, 'verifyOtpAndResetPassword']);
Route::post('/send-otp', [OtpController::class, 'sendOtp']);


Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);


Route::get('/sizes', [SizeController::class, 'index']);
Route::post('/sizes', [SizeController::class, 'store']);
Route::get('/sizes/{id}', [SizeController::class, 'show']);
Route::put('/sizes/{id}', [SizeController::class, 'update']); 

Route::get('images', [ImageController::class, 'index']); // List all images
Route::post('images', [ImageController::class, 'store']); // Create a new image
Route::get('images/{image}', [ImageController::class, 'show']); // Show a specific image
Route::put('images/{image}', [ImageController::class, 'update']); // Update a specific image
Route::delete('images/{image}', [ImageController::class, 'destroy']); // Delete a specific image

// Custom routes for Order
Route::get('/orders', [OrderController::class, 'index']);           // Get all orders
Route::post('/orders', [OrderController::class, 'store']);          // Create a new order
Route::get('/orders/{id}', [OrderController::class, 'show']);       // Get a single order
Route::put('/orders/{id}', [OrderController::class, 'update']);     // Update an order
Route::delete('/orders/{id}', [OrderController::class, 'destroy']); // Delete an order



// Fetch all orders
Route::get('/order-list', [OrderListController::class, 'index']);

// Create a new order
Route::post('/order-list', [OrderListController::class, 'store']);

// Fetch a single order by ID
Route::get('/order-list/{id}', [OrderListController::class, 'show']);

// Update an existing order
Route::put('/order-list/{id}', [OrderListController::class, 'update']);
// OR use patch
// Route::patch('/order-list/{id}', [OrderListController::class, 'update']);

// Delete an order
Route::delete('/order-list/{id}', [OrderListController::class, 'destroy']);

Route::post('/generate-invoice', [InvoiceController::class, 'generateInvoice']);
Route::get('/invoice/{id}', [InvoiceController::class, 'getInvoice']);
Route::put('/invoice/{id}/status', [InvoiceController::class, 'updateInvoiceStatus']);



Route::get('/main-categories', [MainCategoryController::class, 'index']);
Route::post('/main-categories', [MainCategoryController::class, 'store']);
Route::get('/main-categories/{id}', [MainCategoryController::class, 'show']);
Route::put('/main-categories/{id}', [MainCategoryController::class, 'update']);
Route::delete('/main-categories/{id}', [MainCategoryController::class, 'destroy']);


// List all subcategories
Route::get('/subcategories', [SubCategoryController::class, 'index']);

// Create new subcategory
Route::post('/subcategories', [SubCategoryController::class, 'store']);

// Show specific subcategory
Route::get('/subcategories/{id}', [SubCategoryController::class, 'show']);

// Update subcategory
Route::put('/subcategories/{id}', [SubCategoryController::class, 'update']);

// Delete subcategory
Route::delete('/subcategories/{id}', [SubCategoryController::class, 'destroy']);

Route::get('/brands', [BrandController::class, 'index']);

// Create new brand
Route::post('/brands', [BrandController::class, 'store']);

// Show specific brand
Route::get('/brands/{id}', [BrandController::class, 'show']);

// Update brand
Route::put('/brands/{id}', [BrandController::class, 'update']);

// Delete brand
Route::delete('/brands/{id}', [BrandController::class, 'destroy']);