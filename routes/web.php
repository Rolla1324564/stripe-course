<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;

// Home page - redirect to courses
Route::redirect('/', '/courses');

// Course Routes
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

// Payment Routes
Route::get('/payment/{course}', [PaymentController::class, 'buyNow'])->name('payment.buy-now');
Route::get('/payment-friend/{course}', [PaymentController::class, 'buyForFriend'])->name('payment.buy-for-friend');
Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/payment-success/{order}', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment-cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

// Admin Routes
Route::get('/admin/login', [AdminController::class, 'loginPage'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/orders/pending', [AdminController::class, 'ordersPending'])->name('admin.orders.pending');
    Route::get('/admin/orders/processing', [AdminController::class, 'ordersProcessing'])->name('admin.orders.processing');
    Route::get('/admin/payments', [AdminController::class, 'payments'])->name('admin.payments');
    Route::get('/admin/payments/completed', [AdminController::class, 'paymentsCompleted'])->name('admin.payments.completed');
    Route::get('/admin/payments/incomplete', [AdminController::class, 'paymentsIncomplete'])->name('admin.payments.incomplete');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    
    // Course routes
    Route::get('/admin/courses', [AdminController::class, 'courseIndex'])->name('admin.courses.index');
    Route::get('/admin/courses/create', [AdminController::class, 'courseCreate'])->name('admin.courses.create');
    Route::post('/admin/courses', [AdminController::class, 'courseStore'])->name('admin.courses.store');
    Route::get('/admin/courses/{course}/edit', [AdminController::class, 'courseEdit'])->name('admin.courses.edit');
    Route::put('/admin/courses/{course}', [AdminController::class, 'courseUpdate'])->name('admin.courses.update');
    Route::delete('/admin/courses/{course}', [AdminController::class, 'courseDestroy'])->name('admin.courses.destroy');
    
    // Order details
    Route::get('/admin/orders/{order}', [AdminController::class, 'orderDetails'])->name('admin.orderDetails');
    Route::patch('/admin/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

Route::get('/admin/login', [AdminController::class, 'loginPage'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
