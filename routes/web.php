<?php

use App\Http\Controllers\Admin\AdminDonationController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationStatusController;
use App\Http\Controllers\ReceiptController;
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

// Phase 3: Administrative Donation Verification Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
    Route::get('/donations/create', [AdminDonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [AdminDonationController::class, 'store'])->name('donations.store');
    Route::post('/donations/{donation}/approve', [AdminDonationController::class, 'approve'])->name('donations.approve');
    Route::post('/donations/{donation}/reject', [AdminDonationController::class, 'reject'])->name('donations.reject');
});

// Phase 3: Official 80G PDF Receipt Download and Preview
Route::get('/donations/{donation}/receipt', [ReceiptController::class, 'download'])->name('donation.receipt');
Route::get('/donations/{donation}/receipt/preview', [ReceiptController::class, 'preview'])->name('donation.receipt.preview');
