<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\KycController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\StoreProfileController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\VendorDashboardController;

Route::get('/', function () {
    return view('frontend.home.index');
});


Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    /** Profile Routes */

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'profileUpdate'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'passwordUpdate'])->name('password.update');
    Route::get('/kyc-verification', [KycController::class, 'index'])->name('kyc.index');
    Route::post('/kyc-verification', [KycController::class, 'store'])->name('kyc.store');
});

/** Vendor Routes */

Route::group(['prefix' => 'vendor', 'as' => 'vendor.',  'middleware' => ['auth', 'verified','user_role:vendor']], function () {

    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');

    Route::resource('store-profile',StoreProfileController::class);

});

/**Admin Routes */

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard.index');
})->middleware(['auth:admin', 'verified'])->name('admin.dashboard');


require __DIR__.'/auth.php';
