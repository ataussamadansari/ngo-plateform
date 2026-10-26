<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationStatusController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\TransparencyController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

// Phase 7: Flagship Public Homepage with Live Impact Metrics
Route::get('/', [HomeController::class, 'index'])->name('home');

// Phase 7: Institutional About Us & Contact Portals
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

// Phase 14: Institutional Legal, Privacy & Compliance Showcase
Route::get('/legal', [PageController::class, 'legal'])->name('legal.index');
Route::get('/privacy', [PageController::class, 'privacy'])->name('legal.privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('legal.terms');
Route::get('/disclaimer', [PageController::class, 'disclaimer'])->name('legal.disclaimer');

// Phase 6: Public Events Directory & RSVP Registration
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');
Route::post('/events/{event:slug}/register', [EventController::class, 'register'])
    ->middleware('throttle:5,1')
    ->name('events.register');

// Phase 6: Public Volunteer Registration Portal
Route::get('/volunteer-join', [VolunteerController::class, 'create'])->name('volunteers.create');
Route::post('/volunteer-join', [VolunteerController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('volunteers.store');
Route::get('/volunteer-join/success', [VolunteerController::class, 'success'])->name('volunteers.success');

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

// Native Filament Authentication & Dashboard Integration
Route::get('/login', fn () => redirect('/admin/login'))->name('login');

// Phase 3: Official 80G PDF Receipt Download and Preview
Route::get('/donations/{donation}/receipt', [ReceiptController::class, 'download'])->name('donation.receipt');
Route::get('/donations/{donation}/receipt/preview', [ReceiptController::class, 'preview'])->name('donation.receipt.preview');
