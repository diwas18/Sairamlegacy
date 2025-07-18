<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\ReviewController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/',[PagesController::class,'index'])->name('home');
Route::get('/viewproduct/{id}',[PagesController::class,'viewproduct'])->name('viewproduct');
Route::get('/categoryproduct/{id}',[PagesController::class,'categoryproduct'])->name('categoryproduct');
Route::get('/search/',[PagesController::class,'search'])->name('search');


Route::middleware('auth')->group(function(){
    Route::post('cart/store',[CartController::class,'store'])->name('cart.store');
    Route::get('mycart',[CartController::class,'mycart'])->name('mycart');
    Route::get('cart/destroy/{id}',[CartController::class,'destroy'])->name('cart.destroy');
    Route::get('checkout/{cartid}', [PagesController::class, 'checkout'])->name('checkout');
    Route::get('order/{cartid}/store', [OrderController::class, 'store'])->name('order.store');
    Route::post('order/store',[OrderController::class,'storecod'])->name('order.storecod');

});
//category
Route::middleware(['auth','admin'])->group(function(){


Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/create',[CategoryController::class,'create'])->name('category.create');
Route:: post('/category/store',[CategoryController::class,'store'])->name('category.store');
Route:: get('/category/edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
Route:: post('/category/{id}/update',[CategoryController::class,'update'])->name('category.update');
Route:: delete('/category/destroy',[CategoryController::class,'destroy'])->name('category.destroy');
// Product
Route:: get('/product',[ProductController::class,'index'])->name('product.index');
Route:: get('/product/create',[ProductController::class,'create'])->name('product.create');
Route:: post('/product/store',[ProductController::class,'store'])->name('product.store');
Route:: get('/product/edit/{id}',[ProductController::class,'edit'])->name('product.edit');
Route:: post('/product/update/{id}',[ProductController::class,'update'])->name('product.update');
Route:: get('/product/destroy/{id}',[ProductController::class,'destroy'])->name('product.destroy');

// orders
Route::get('/orders',[OrderController::class,'index'])->name('order.index');
Route::get('/prder/{id}/status/{status}',[OrderController::class,'status'])->name('order.status');
});

Route::get('/dashboard',[ DashboardController::class,'dashboard'])
->middleware(['auth','admin' ,'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');    // ✅ GET method to show the form
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // ✅ PATCH method to submit changes
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // ✅ DELETE method to delete
});


Route::get('/notifications', function () {
    return view('notifications.all', [
        'notifications' => Auth::user()->notifications
    ]);
})->middleware('auth')->name('notifications.all');
Route::post('/admin/notify-users', [AdminController::class, 'notifyAllUsers'])
     ->name('admin.notify.users')
     ->middleware('auth');  // add 'admin' middleware if applicable

Route::get('/admin/notify-users', function () {
    return view('admin.notify');
})->middleware('auth')->name('admin.notify.form');
Route::post('/notifications/mark-as-read', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        \Illuminate\Support\Facades\Auth::user()->unreadNotifications->markAsRead();
    }
    return response()->json(['success' => true]);
})->name('notifications.markAsRead');


Route::resource('users', App\Http\Controllers\UserController::class);



Route::get('/auth/google/redirect', [App\Http\Controllers\Auth\GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'callback'])->name('google.callback');
Route::get('/auth/facebook/redirect', [App\Http\Controllers\Auth\FacebookController::class, 'redirect'])->name('facebook.redirect');
Route::get('/auth/facebook/callback', [App\Http\Controllers\Auth\FacebookController::class, 'callback'])->name('facebook.callback');



Route::get('/review/{id}/create', [ReviewController::class, 'create'])->name('review.create');
Route::post('/review/store', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/review/{id}/edit', [ReviewController::class, 'edit'])->name('review.edit');
Route::post('/review/{id}/update', [ReviewController::class, 'update'])->name('review.update');
Route::get('/review/{id}/destroy', [ReviewController::class, 'destroy'])->name('review.destroy');

require __DIR__.'/auth.php';
