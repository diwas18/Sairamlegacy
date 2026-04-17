<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VirtualTryOnController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', [PagesController::class, 'index'])->name('home');
Route::get('/viewproduct/{id}', [PagesController::class, 'viewproduct'])->name('viewproduct');
Route::get('/categoryproduct/{id}', [PagesController::class, 'categoryproduct'])->name('categoryproduct');
Route::get('/search/', [PagesController::class, 'search'])->name('search');
Route::get('/vieworder', [PagesController::class, 'vieworder'])->name('vieworder');

Route::middleware('auth')->group(function () {
    Route::post('cart/store', [CartController::class, 'store'])->name('cart.store');
    Route::get('mycart', [CartController::class, 'mycart'])->name('mycart');
    Route::get('cart/destroy/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('checkout/{cartid}', [PagesController::class, 'checkout'])->name('checkout');
    Route::get('order/{cartid}/store', [OrderController::class, 'store'])->name('order.store');
    Route::post('order/store', [OrderController::class, 'storecod'])->name('order.storecod');
});

// Category & Product & Orders — Admin only
Route::middleware(['auth', 'admin'])->group(function () {

    // Category
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/{id}/update', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');

    // Product
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
// bookings
Route::get('/bookings', [BookingController::class, 'index'])->name('booking.index');
Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('booking.status');
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/{id}/status/{status}', [OrderController::class, 'status'])->name('order.status');

    // Dashboard Export
    Route::get('/dashboard/export', [DashboardController::class, 'exportCsv'])->name('dashboard.export');
    Route::get('/admin/search', [DashboardController::class, 'search'])->name('admin.search');
    // Users
    Route::resource('users', UserController::class);

    // Admin Notifications
    Route::post('/admin/notify-users', [AdminController::class, 'notifyAllUsers'])
        ->name('admin.notify.users');
    Route::get('/admin/notify-users', function () {
        return view('admin.notify');
    })->name('admin.notify.form');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'admin', 'verified'])
    ->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications', function () {
        return view('notifications.all', [
            'notifications' => Auth::user()->notifications
        ]);
    })->name('notifications.all');

    Route::post('/notifications/mark-as-read', function () {
        if (Auth::check()) {
            Auth::user()->unreadNotifications->markAsRead();
        }
        return response()->json(['success' => true]);
    })->name('notifications.markAsRead');
});

// Virtual Try-On
Route::get('/virtual-try-on', [VirtualTryOnController::class, 'index'])->name('virtual.index');

// Social Auth
// Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
// Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
// Route::get('/auth/facebook/redirect', [FacebookController::class, 'redirect'])->name('facebook.redirect');
// Route::get('/auth/facebook/callback', [FacebookController::class, 'callback'])->name('facebook.callback');

// Reviews
Route::get('/review/{id}/create', [ReviewController::class, 'create'])->name('review.create');
Route::post('/review/store', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/review/{id}/edit', [ReviewController::class, 'edit'])->name('review.edit');
Route::post('/review/{id}/update', [ReviewController::class, 'update'])->name('review.update');
Route::get('/review/{id}/destroy', [ReviewController::class, 'destroy'])->name('review.destroy');
// routes/web.php

Route::get('/book-appointment', [BookingController::class, 'create'])->name('booking.create');
Route::post('/book-appointment', [BookingController::class, 'store'])->name('booking.store');



require __DIR__ . '/auth.php';
