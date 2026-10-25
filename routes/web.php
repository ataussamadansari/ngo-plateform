<?php

use App\Http\Controllers\Admin\AdminCampaignController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDonationController;
use App\Http\Controllers\Admin\AdminFundDistributionController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationStatusController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\TransparencyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Phase 5: Public Campaigns Directory & High-Conversion Cause Story Portal
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaigns/{campaign:slug}', [CampaignController::class, 'show'])->name('campaigns.show');

// Phase 2: Public Manual Donation Routes
Route::get('/donate', [DonationController::class, 'index'])->name('donate.index');
Route::post('/donate', [DonationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('donate.store');

// Phase 2: Donation Verification Status Lookup Portal
Route::get('/donation-status', [DonationStatusController::class, 'index'])->name('donation.status');

// Phase 4: Public Transparency Ledger & Cause-Specific Utilization
Route::get('/transparency', [TransparencyController::class, 'index'])->name('transparency.index');
Route::get('/campaigns/{campaign:slug}/transparency', [TransparencyController::class, 'campaignLedger'])->name('campaigns.transparency');

// Phase 3, 4 & 5: Administrative Back-Office Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Phase 3: Donation Verification
    Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
    Route::get('/donations/create', [AdminDonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [AdminDonationController::class, 'store'])->name('donations.store');
    Route::post('/donations/{donation}/approve', [AdminDonationController::class, 'approve'])->name('donations.approve');
    Route::post('/donations/{donation}/reject', [AdminDonationController::class, 'reject'])->name('donations.reject');

    // Phase 4: Fund Distribution Ledger
    Route::get('/distributions', [AdminFundDistributionController::class, 'index'])->name('distributions.index');
    Route::get('/distributions/create', [AdminFundDistributionController::class, 'create'])->name('distributions.create');
    Route::post('/distributions', [AdminFundDistributionController::class, 'store'])->name('distributions.store');
    Route::get('/distributions/{distribution}', [AdminFundDistributionController::class, 'show'])->name('distributions.show');

    // Phase 5: Cause Categories Management
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Phase 5: Campaigns Management
    Route::get('/campaigns', [AdminCampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/create', [AdminCampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [AdminCampaignController::class, 'store'])->name('campaigns.store');
    Route::get('/campaigns/{campaign}/edit', [AdminCampaignController::class, 'edit'])->name('campaigns.edit');
    Route::put('/campaigns/{campaign}', [AdminCampaignController::class, 'update'])->name('campaigns.update');
    Route::patch('/campaigns/{campaign}/status', [AdminCampaignController::class, 'toggleStatus'])->name('campaigns.status');
});

// Phase 3: Official 80G PDF Receipt Download and Preview
Route::get('/donations/{donation}/receipt', [ReceiptController::class, 'download'])->name('donation.receipt');
Route::get('/donations/{donation}/receipt/preview', [ReceiptController::class, 'preview'])->name('donation.receipt.preview');
