<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Phase 2: Public Manual Donation Routes
Route::get('/donate', [DonationController::class, 'index'])->name('donate.index');
Route::post('/donate', [DonationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('donate.store');

// Phase 2: Donation Verification Status Lookup Portal
Route::get('/donation-status', [DonationStatusController::class, 'index'])->name('donation.status');
