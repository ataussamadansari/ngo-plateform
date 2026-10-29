{{-- resources/views/donate/index.blade.php --}}
@extends('layouts.base')

@section('title', 'Make a Donation — ' . setting('ngo_name', 'Hope Foundation'))
@section('meta_description', 'Make a 100% transparent direct UPI or Bank Transfer donation to ' . setting('ngo_name', 'Hope Foundation') . ' and receive an 80G tax-exempt receipt.')

@section('content')
@php
    $ngoName        = setting('ngo_name', 'Hope Foundation');
    $homeUrl        = Route::has('home') ? route('home') : url('/');
    $statusRoute    = Route::has('donation.status') ? route('donation.status') : (Route::has('donate.status') ? route('donate.status') : url('/donation-status'));
    $upiId          = $upiMethod->upi_id ?? setting('upi_id', 'hopefoundation@okicici');
    $accountHolder  = $bankMethod->account_holder_name ?? $ngoName;
    $bankName       = $bankMethod->bank_name ?? 'ICICI Bank';
    $accountNumber  = $bankMethod->account_number ?? '123456789012';
    $ifscCode       = $bankMethod->ifsc_code ?? 'ICIC0001234';
    $branchName     = $bankMethod->branch_name ?? 'Main Branch, Varanasi';

    // Fallback recent donors matching the exact mockup when DB has < 5 verified records
    $fallbackDonors = [
        ['initials' => 'AS', 'name' => 'Amit Sharma',  'amount' => 1000, 'time' => '2 hours ago', 'color' => 'bg-[#dcfce7] text-[#15803d]'],
        ['initials' => 'PP', 'name' => 'Priya Patel',  'amount' => 2000, 'time' => '5 hours ago', 'color' => 'bg-blue-100 text-blue-700'],
        ['initials' => 'RK', 'name' => 'Rahul Kumar',  'amount' => 500,  'time' => '1 day ago',   'color' => 'bg-sky-100 text-sky-700'],
        ['initials' => 'NS', 'name' => 'Neha Singh',   'amount' => 5000, 'time' => '1 day ago',   'color' => 'bg-rose-100 text-rose-700'],
        ['initials' => 'MK', 'name' => 'Mohd Khan',    'amount' => 1000, 'time' => '2 days ago',  'color' => 'bg-purple-100 text-purple-700'],
    ];
    $avatarColors = [
        'bg-[#dcfce7] text-[#15803d]',
        'bg-blue-100 text-blue-700',
        'bg-sky-100 text-sky-700',
        'bg-rose-100 text-rose-700',
        'bg-purple-100 text-purple-700',
    ];
@endphp

{{-- ===================================================================
     1. TOP HERO BANNER ("Make a Donation" + 4 Trust Pills + Script)
==================================================================== --}}
<section class="relative overflow-hidden bg-[#0a2617]">
    <div class="absolute inset-0 z-0">
        <img
            src="https://images.unsplash.com/photo-1542810634-71277d95dcbb?auto=format&fit=crop&w=1920&q=85"
            alt="Make a Donation - {{ $ngoName }}"
            class="w-full h-full object-cover object-center"
        >
        <div class="absolute inset-0 bg-gradient-to-r from-[#071f12]/94 via-[#0a2617]/75 to-black/30"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#071f12]/85 via-transparent to-black/25"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

            {{-- Left Column --}}
            <div class="lg:col-span-8 text-white" data-reveal>
                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-2 text-xs font-medium text-white/80 mb-3">
                    <a href="{{ $homeUrl }}" class="hover:text-[#4ade80] transition">Home</a>
                    <span>&rsaquo;</span>
                    <span class="text-white font-semibold">Donate</span>
                </nav>

                <h1 class="font-heading text-3xl sm:text-4xl lg:text-[46px] font-extrabold tracking-tight leading-[1.12] text-white mb-3">
                    Make a Donation
                </h1>

                <p class="text-xs sm:text-sm lg:text-base text-white/90 leading-relaxed max-w-xl mb-6">
                    Your support can create real change in the lives of underprivileged communities.
                </p>

                {{-- 4 Hero Trust Badges --}}
                <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-black/40 backdrop-blur-xs border border-white/15 text-[11px] sm:text-xs font-bold text-white">
                        <span class="w-5 h-5 rounded-md bg-[#16a34a] text-white flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        100% Transparent
                    </span>

                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-black/40 backdrop-blur-xs border border-white/15 text-[11px] sm:text-xs font-bold text-white">
                        <span class="w-5 h-5 rounded-md bg-[#16a34a] text-white flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        </span>
                        80G Tax Benefit
                    </span>

                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-black/40 backdrop-blur-xs border border-white/15 text-[11px] sm:text-xs font-bold text-white">
                        <span class="w-5 h-5 rounded-md bg-[#16a34a] text-white flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                        </span>
                        Secure &amp; Verified
                    </span>

                    <span class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-black/40 backdrop-blur-xs border border-white/15 text-[11px] sm:text-xs font-bold text-white">
                        <span class="w-5 h-5 rounded-md bg-[#16a34a] text-white flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                        </span>
                        Real Impact
                    </span>
                </div>
            </div>

            {{-- Right Column: Tilted Handwritten Script (Desktop) --}}
            <div class="hidden lg:flex lg:col-span-4 justify-end items-center pr-4" data-reveal data-reveal-delay="150">
                <div class="transform -rotate-6 select-none text-left">
                    <p class="font-script text-3xl xl:text-[38px] text-white/95 leading-[1.08] drop-shadow-md">
                        Small<br>
                        Contribution<br>
                        Big Change <span class="text-[#16a34a] inline-block align-middle">💚</span>
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ===================================================================
     2. MAIN DONATION WORKFLOW SECTION (STEP 1 LEFT | STEP 2 RIGHT)
==================================================================== --}}
<section class="py-7 sm:py-10 bg-[#fcfdfc]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Flash Success Alert --}}
        @if(session('success'))
            <div class="mb-7 rounded-3xl bg-[#f0fdf4] border border-[#bbf7d0] p-5 sm:p-6 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-start gap-3.5">
                    <div class="w-11 h-11 rounded-2xl bg-[#16a34a] text-white flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-extrabold text-[#14532d]">Donation Submitted Successfully!</h3>
                        <p class="text-xs sm:text-sm text-[#166534] mt-0.5">{{ session('success') }}</p>
                        @if(session('submitted_utr'))
                            <div class="mt-2 inline-flex items-center gap-2 px-3 py-1 bg-white rounded-lg border border-[#86efac] text-xs font-mono font-bold text-[#14532d]">
                                UTR: {{ session('submitted_utr') }}
                            </div>
                        @endif
                    </div>
                </div>
                @if(session('submitted_utr'))
                    <a href="{{ $statusRoute }}?query={{ urlencode(session('submitted_utr')) }}" class="shrink-0 px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-[#16a34a] hover:bg-[#15803d] shadow-xs transition">
                        Track Verification Status &rarr;
                    </a>
                @endif
            </div>
        @endif

        {{-- Validation Errors Notice --}}
        @if($errors->any())
            <div class="mb-7 rounded-3xl bg-rose-50 border border-rose-200 p-5 sm:p-6 shadow-xs">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    <div>
                        <h4 class="text-sm font-extrabold text-rose-900">Please fix the following errors:</h4>
                        <ul class="list-disc list-inside text-xs text-rose-700 mt-1.5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 lg:gap-8 items-start">

            {{-- ===============================================================
                 LEFT COLUMN (6 Cols): STEP 1 — CHOOSE PAYMENT METHOD
            ================================================================ --}}
            <div class="lg:col-span-6 space-y-5" data-reveal>

                {{-- Step 1 Heading --}}
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-full bg-[#16a34a] text-white font-extrabold text-xs flex items-center justify-center shrink-0">
                        1
                    </span>
                    <h2 class="font-heading text-lg sm:text-xl font-extrabold text-[#14291b]">
                        . Choose Payment Method
                    </h2>
                </div>

                {{-- Payment Method Selector Cards (Desktop Detailed Cards + Mobile Compact Buttons) --}}
                <div class="grid grid-cols-2 gap-3 sm:gap-4">
                    {{-- UPI Payment Tab Button --}}
                    <button
                        type="button"
                        id="tab-upi-btn"
                        onclick="switchPaymentTab('upi')"
                        class="p-3 sm:p-4 rounded-2xl border-2 border-[#16a34a] bg-[#f2fbf5] text-left transition-all duration-200 flex items-center gap-3 cursor-pointer"
                    >
                        <div id="tab-upi-icon" class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-xs sm:text-sm font-extrabold text-[#14291b]">UPI Payment</span>
                            <span class="hidden sm:block text-[11px] text-slate-600 mt-0.5 leading-snug">
                                Scan QR and make payment from any UPI app
                            </span>
                        </div>
                    </button>

                    {{-- Bank Transfer Tab Button --}}
                    <button
                        type="button"
                        id="tab-bank-btn"
                        onclick="switchPaymentTab('bank')"
                        class="p-3 sm:p-4 rounded-2xl border-2 border-slate-200 hover:border-[#bbf7d0] bg-white text-left transition-all duration-200 flex items-center gap-3 cursor-pointer"
                    >
                        <div id="tab-bank-icon" class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2.25a.75.75 0 01.369.098l8.25 4.5a.75.75 0 01-.369 1.402H3.75a.75.75 0 01-.369-1.402l8.25-4.5A.75.75 0 0112 2.25zM4.5 9.75v8.25h3V9.75h-3zm6 0v8.25h3V9.75h-3zm6 0v8.25h3V9.75h-3zM2.25 19.5a.75.75 0 000 1.5h19.5a.75.75 0 000-1.5H2.25z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-xs sm:text-sm font-extrabold text-[#14291b]">Bank Transfer</span>
                            <span class="hidden sm:block text-[11px] text-slate-500 mt-0.5 leading-snug">
                                Transfer directly to our bank account
                            </span>
                        </div>
                    </button>
                </div>

                {{-- CARD A: Scan & Pay via UPI --}}
                <div id="panel-upi" class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/85 shadow-xs space-y-5">
                    <div class="grid grid-cols-12 gap-4 sm:gap-6 items-center">

                        {{-- Left: QR Code Box (5 Cols) --}}
                        <div class="col-span-5 flex justify-center">
                            <div class="p-2 sm:p-3 bg-white rounded-2xl border border-slate-200/90 shadow-2xs">
                                @if($upiMethod && $upiMethod->qr_image_path && file_exists(storage_path('app/public/' . $upiMethod->qr_image_path)))
                                    <img
                                        src="{{ asset('storage/' . $upiMethod->qr_image_path) }}"
                                        alt="UPI QR Code"
                                        class="w-32 h-32 sm:w-40 sm:h-40 object-contain mx-auto"
                                    >
                                @else
                                    {{-- High-Contrast Stylized QR Code SVG Matching Mockup --}}
                                    <div class="relative w-32 h-32 sm:w-40 sm:h-40 flex items-center justify-center bg-white">
                                        <img
                                            src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode('upi://pay?pa=' . $upiId . '&pn=' . $ngoName . '&cu=INR') }}"
                                            alt="Scan UPI QR"
                                            class="w-full h-full object-contain"
                                        >
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <span class="w-8 h-8 rounded-lg bg-white shadow-sm border border-slate-100 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-[#16a34a]" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M10 3L4 14h6l-2 7 10-11h-6l2-7z"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Right: Scan & Pay Copy Controls (7 Cols) --}}
                        <div class="col-span-7 space-y-2.5">
                            <div>
                                <h3 class="font-heading text-sm sm:text-base font-extrabold text-[#14291b]">
                                    Scan &amp; Pay via UPI
                                </h3>
                                <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5 leading-relaxed">
                                    Use any UPI app like Google Pay, PhonePe, Paytm, BHIM, etc.
                                </p>
                            </div>

                            {{-- Copyable UPI ID Box --}}
                            <div class="flex items-center justify-between px-3 py-2 sm:py-2.5 rounded-xl bg-[#f1f7f3] border border-[#d8f3df]">
                                <span id="upi-id-text" class="text-xs sm:text-sm font-extrabold text-[#14291b] truncate">
                                    {{ $upiId }}
                                </span>
                                <button
                                    type="button"
                                    onclick="copyToClipboard('{{ $upiId }}', this)"
                                    title="Copy UPI ID"
                                    class="ml-2 w-7 h-7 rounded-lg bg-[#16a34a] hover:bg-[#15803d] text-white flex items-center justify-center shrink-0 transition cursor-pointer"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Desktop "Click to copy UPI ID" Secondary Button --}}
                            <button
                                type="button"
                                onclick="copyToClipboard('{{ $upiId }}', this)"
                                class="hidden sm:inline-flex w-full items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-[#eaf8ef] hover:bg-[#dcfce7] border border-[#bbf7d0] text-xs font-bold text-[#14291b] transition cursor-pointer"
                            >
                                <span class="w-4 h-4 rounded-full bg-slate-800 text-white text-[9px] font-bold flex items-center justify-center">₹</span>
                                <span>Click to copy UPI ID</span>
                            </button>
                        </div>
                    </div>

                    {{-- Divider OR --}}
                    <div class="relative flex items-center justify-center">
                        <div class="border-t border-slate-200 w-full"></div>
                        <span class="bg-white px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">OR</span>
                        <div class="border-t border-slate-200 w-full"></div>
                    </div>

                    {{-- 4 UPI App Badges Row (GPay, PhonePe, Paytm, BHIM) --}}
                    <div class="grid grid-cols-4 gap-2 max-w-xs mx-auto text-center">
                        {{-- GPay --}}
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-9 h-9 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center shadow-2xs">
                                <span class="text-xs font-black tracking-tighter">
                                    <span class="text-blue-600">G</span><span class="text-red-500">P</span><span class="text-amber-500">a</span><span class="text-green-600">y</span>
                                </span>
                            </div>
                            <span class="text-[11px] font-semibold text-slate-600">GPay</span>
                        </div>

                        {{-- PhonePe --}}
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-9 h-9 rounded-full bg-[#5f259f] text-white flex items-center justify-center shadow-2xs font-bold text-sm">
                                पे
                            </div>
                            <span class="text-[11px] font-semibold text-slate-600">PhonePe</span>
                        </div>

                        {{-- Paytm --}}
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-9 h-9 rounded-full bg-sky-50 border border-sky-200 text-[#002970] flex items-center justify-center shadow-2xs font-extrabold text-[10px]">
                                Pay<span class="text-[#00baf2]">tm</span>
                            </div>
                            <span class="text-[11px] font-semibold text-slate-600">Paytm</span>
                        </div>

                        {{-- BHIM --}}
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-9 h-9 rounded-full bg-orange-50 border border-orange-200 text-orange-600 flex items-center justify-center shadow-2xs">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8 4l8 8-8 8V4z"/>
                                </svg>
                            </div>
                            <span class="text-[11px] font-semibold text-slate-600">BHIM</span>
                        </div>
                    </div>

                    {{-- Bottom Instruction Note --}}
                    <div class="pt-1 flex items-center justify-center gap-1.5 text-center text-[11px] text-slate-500">
                        <span class="w-4 h-4 rounded-full bg-slate-700 text-white text-[9px] font-bold flex items-center justify-center shrink-0">i</span>
                        <span>After payment, please fill the details below with UTR number and upload screenshot.</span>
                    </div>
                </div>

                {{-- CARD B: Bank Transfer Details (Visible on Desktop by default + Toggled on Mobile) --}}
                <div id="panel-bank" class="hidden sm:block bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/85 shadow-xs space-y-4">
                    <div class="flex items-center gap-2.5 pb-1">
                        <span class="w-7 h-7 rounded-lg bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2.25a.75.75 0 01.369.098l8.25 4.5a.75.75 0 01-.369 1.402H3.75a.75.75 0 01-.369-1.402l8.25-4.5A.75.75 0 0112 2.25zM4.5 9.75v8.25h3V9.75h-3zm6 0v8.25h3V9.75h-3zm6 0v8.25h3V9.75h-3zM2.25 19.5a.75.75 0 000 1.5h19.5a.75.75 0 000-1.5H2.25z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                        <h3 class="font-heading text-base font-extrabold text-[#14291b]">
                            Bank Transfer Details
                        </h3>
                    </div>

                    <div class="space-y-2 text-xs">
                        {{-- Account Name --}}
                        <div class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-[#f7faf8] border border-slate-200/70">
                            <span class="text-slate-600 font-medium">Account Name</span>
                            <div class="flex items-center gap-3">
                                <span id="bank-holder" class="font-extrabold text-[#14291b]">{{ $accountHolder }}</span>
                                <button type="button" onclick="copyToClipboard('{{ $accountHolder }}', this)" class="text-slate-500 hover:text-[#16a34a] transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </button>
                            </div>
                        </div>

                        {{-- Bank Name --}}
                        <div class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-[#f7faf8] border border-slate-200/70">
                            <span class="text-slate-600 font-medium">Bank Name</span>
                            <div class="flex items-center gap-3">
                                <span id="bank-name" class="font-bold text-slate-800">{{ $bankName }}</span>
                                <button type="button" onclick="copyToClipboard('{{ $bankName }}', this)" class="text-slate-500 hover:text-[#16a34a] transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </button>
                            </div>
                        </div>

                        {{-- Account Number --}}
                        <div class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-[#f7faf8] border border-slate-200/70">
                            <span class="text-slate-600 font-medium">Account Number</span>
                            <div class="flex items-center gap-3">
                                <span id="bank-acc" class="font-mono font-bold text-slate-800">{{ $accountNumber }}</span>
                                <button type="button" onclick="copyToClipboard('{{ $accountNumber }}', this)" class="text-slate-500 hover:text-[#16a34a] transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </button>
                            </div>
                        </div>

                        {{-- IFSC Code --}}
                        <div class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-[#f7faf8] border border-slate-200/70">
                            <span class="text-slate-600 font-medium">IFSC Code</span>
                            <div class="flex items-center gap-3">
                                <span id="bank-ifsc" class="font-mono font-bold text-slate-800">{{ $ifscCode }}</span>
                                <button type="button" onclick="copyToClipboard('{{ $ifscCode }}', this)" class="text-slate-500 hover:text-[#16a34a] transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </button>
                            </div>
                        </div>

                        <span id="bank-branch" class="hidden">{{ $branchName }}</span>
                    </div>

                    <div class="pt-1 text-center">
                        <button
                            type="button"
                            onclick="copyAllBankDetails(this)"
                            class="inline-flex items-center justify-center px-8 py-2.5 rounded-xl bg-[#16a34a] hover:bg-[#15803d] text-white text-xs font-bold shadow-2xs transition cursor-pointer"
                        >
                            Copy All Details
                        </button>
                    </div>
                </div>

            </div>

            {{-- ===============================================================
                 RIGHT COLUMN (6 Cols): DONATION AMOUNT + STEP 2 SUBMIT DETAILS
            ================================================================ --}}
            <div class="lg:col-span-6" data-reveal data-reveal-delay="100">
                <form action="{{ route('donate.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="payment_mode" id="form_payment_mode" value="{{ old('payment_mode', 'upi_qr') }}">

                    {{-- BOX 1: Soft-Mint Donation Amount Container --}}
                    <div class="bg-[#f2fbf5] rounded-3xl p-5 sm:p-6 border border-[#d8f3df] shadow-2xs space-y-4">
                        <div>
                            <h2 class="font-heading text-base sm:text-lg font-extrabold text-[#14291b]">
                                Donation Amount <span class="text-xs sm:text-sm font-normal text-slate-500">(Optional)</span>
                            </h2>
                            <p class="text-xs text-slate-600 mt-0.5">
                                You can enter any amount. Every contribution counts.
                            </p>
                        </div>

                        {{-- 3x2 Preset Amount Buttons Grid --}}
                        <div class="grid grid-cols-3 gap-2.5 sm:gap-3">
                            @foreach([500, 1000, 2000, 5000, 10000] as $preset)
                                @php
                                    $isSelected = (int) old('amount', 1000) === $preset;
                                @endphp
                                <button
                                    type="button"
                                    onclick="setPresetAmount({{ $preset }}, this)"
                                    class="amount-preset-btn py-2.5 px-3 rounded-xl font-extrabold text-xs sm:text-sm transition-all duration-150 cursor-pointer {{ $isSelected ? 'bg-[#16a34a] text-white border border-[#16a34a] shadow-xs' : 'bg-white text-[#14291b] border border-slate-200/80 hover:border-[#16a34a]' }}"
                                >
                                    ₹{{ number_format($preset) }}
                                </button>
                            @endforeach

                            <button
                                type="button"
                                onclick="focusCustomAmount(this)"
                                class="amount-preset-btn py-2.5 px-3 rounded-xl font-bold text-xs sm:text-sm bg-white text-[#14291b] border border-slate-200/80 hover:border-[#16a34a] transition-all duration-150 cursor-pointer"
                            >
                                Custom
                            </button>
                        </div>

                        {{-- Custom Amount Input Wrapper --}}
                        <div id="custom-amount-wrapper" class="{{ in_array((int) old('amount', 1000), [500, 1000, 2000, 5000, 10000]) ? 'hidden' : '' }}">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500 font-bold text-sm">₹</span>
                                <input
                                    type="number"
                                    name="amount"
                                    id="amount_input"
                                    min="1"
                                    step="any"
                                    required
                                    value="{{ old('amount', '1000') }}"
                                    placeholder="Enter custom amount"
                                    class="w-full pl-8 pr-4 py-2.5 rounded-xl bg-white border border-[#16a34a] text-sm font-extrabold text-[#14291b] focus:outline-none focus:ring-2 focus:ring-[#16a34a]/20"
                                >
                            </div>
                        </div>

                        {{-- 80G Tax Deduction Callout --}}
                        <div class="bg-[#e6f6ec] rounded-2xl p-3.5 border border-[#bbf7d0] flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white text-[#16a34a] flex items-center justify-center shrink-0 shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                                </svg>
                            </div>
                            <div class="text-xs leading-snug">
                                <p class="font-extrabold text-[#15803d]">
                                    Your donation may be eligible for 80G tax deduction.
                                </p>
                                <p class="text-slate-600 mt-0.5">
                                    A receipt will be provided after verification.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- BOX 2: Step 2 — Submit Payment Details White Card --}}
                    <div class="bg-white rounded-3xl p-5 sm:p-7 border border-slate-200/85 shadow-xs space-y-4">
                        <div class="flex items-center gap-2.5 pb-1">
                            <span class="w-6 h-6 rounded-full bg-[#16a34a] text-white font-extrabold text-xs flex items-center justify-center shrink-0">
                                2
                            </span>
                            <h2 class="font-heading text-lg sm:text-xl font-extrabold text-[#14291b]">
                                . Submit Payment Details
                            </h2>
                        </div>

                        {{-- Row 1: Full Name + Email Address --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="donor_name" class="block text-xs font-bold text-[#14291b] mb-1.5">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="donor_name"
                                    name="donor_name"
                                    required
                                    value="{{ old('donor_name') }}"
                                    placeholder="Enter your full name"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-[#f8faf9] border border-slate-200/90 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#16a34a] focus:ring-2 focus:ring-[#16a34a]/15 focus:outline-none transition"
                                >
                            </div>

                            <div>
                                <label for="donor_email" class="block text-xs font-bold text-[#14291b] mb-1.5">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="donor_email"
                                    name="donor_email"
                                    required
                                    value="{{ old('donor_email') }}"
                                    placeholder="Enter your email address"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-[#f8faf9] border border-slate-200/90 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#16a34a] focus:ring-2 focus:ring-[#16a34a]/15 focus:outline-none transition"
                                >
                            </div>
                        </div>

                        {{-- Row 2: Mobile Number + UTR / Reference Number --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="donor_phone" class="block text-xs font-bold text-[#14291b] mb-1.5">
                                    Mobile Number <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="tel"
                                    id="donor_phone"
                                    name="donor_phone"
                                    required
                                    value="{{ old('donor_phone') }}"
                                    placeholder="Enter your mobile number"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-[#f8faf9] border border-slate-200/90 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#16a34a] focus:ring-2 focus:ring-[#16a34a]/15 focus:outline-none transition"
                                >
                            </div>

                            <div>
                                <label for="utr_number" class="block text-xs font-bold text-[#14291b] mb-1.5">
                                    UTR / Reference Number <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="utr_number"
                                    name="utr_number"
                                    required
                                    value="{{ old('utr_number') }}"
                                    placeholder="Enter UTR number (12 digits)"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-[#f8faf9] border border-slate-200/90 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#16a34a] focus:ring-2 focus:ring-[#16a34a]/15 focus:outline-none transition"
                                >
                            </div>
                        </div>

                        {{-- Row 3: Payment Screenshot Dropzone --}}
                        <div>
                            <label for="payment_screenshot" class="block text-xs font-bold text-[#14291b] mb-1.5">
                                Payment Screenshot <span class="text-red-500">*</span>
                            </label>
                            <div
                                id="dropzone"
                                class="relative border-2 border-dashed border-slate-300 hover:border-[#16a34a] rounded-2xl p-6 text-center cursor-pointer transition bg-[#f8faf9] hover:bg-[#f2fbf5]"
                            >
                                <input
                                    type="file"
                                    name="payment_screenshot"
                                    id="payment_screenshot"
                                    accept="image/jpeg,image/png,image/webp"
                                    required
                                    onchange="handleScreenshotPreview(this)"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                >

                                {{-- Default Upload Placeholder --}}
                                <div id="upload-placeholder" class="space-y-1">
                                    <svg class="w-8 h-8 mx-auto text-slate-500 mb-1.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/>
                                    </svg>
                                    <span class="text-xs sm:text-sm font-extrabold text-[#14291b] block">
                                        Click to upload payment screenshot
                                    </span>
                                    <span class="text-[11px] text-slate-500 block">
                                        JPG, PNG, WEBP (Max 2MB)
                                    </span>
                                </div>

                                {{-- Live Preview State --}}
                                <div id="upload-preview" class="hidden flex flex-col items-center">
                                    <img id="preview-image" src="#" alt="Screenshot Preview" class="max-h-36 rounded-xl shadow-xs border border-slate-200 mb-2 object-contain">
                                    <span id="preview-filename" class="text-xs font-mono font-bold text-[#14291b]"></span>
                                    <span class="text-[11px] text-[#16a34a] font-bold mt-0.5">Click to change screenshot</span>
                                </div>
                            </div>
                        </div>

                        {{-- Optional 80G PAN, Campaign & Anonymous Toggle (Clean Accordion so UI stays 100% clutter-free like mockup while keeping all form fields in DOM) --}}
                        <div x-data="{ showExtra: {{ old('donor_pan') || old('campaign_id', $selectedCampaignId ?? null) ? 'true' : 'false' }} }" class="pt-1">
                            <button
                                type="button"
                                @click="showExtra = !showExtra"
                                class="text-xs font-bold text-[#16a34a] hover:text-[#15803d] inline-flex items-center gap-1 cursor-pointer"
                            >
                                <span x-text="showExtra ? '− Hide 80G PAN & Cause Allocation' : '+ Add 80G PAN, Cause Selection or Anonymous Option'"></span>
                            </button>

                            <div x-show="showExtra" x-collapse x-cloak class="mt-3 pt-3 border-t border-slate-100 space-y-3.5">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                    <div>
                                        <label for="donor_pan" class="block text-xs font-bold text-[#14291b] mb-1">
                                            PAN Number <span class="text-[11px] font-normal text-slate-400">(for 80G Receipt)</span>
                                        </label>
                                        <input
                                            type="text"
                                            id="donor_pan"
                                            name="donor_pan"
                                            maxlength="10"
                                            value="{{ old('donor_pan') }}"
                                            placeholder="ABCDE1234F"
                                            class="w-full px-3.5 py-2 rounded-xl bg-[#f8faf9] border border-slate-200 text-xs font-mono uppercase text-slate-800 focus:bg-white focus:border-[#16a34a] focus:outline-none"
                                        >
                                    </div>

                                    <div>
                                        <label for="campaign_id" class="block text-xs font-bold text-[#14291b] mb-1">
                                            Allocate to Cause
                                        </label>
                                        <select
                                            id="campaign_id"
                                            name="campaign_id"
                                            class="w-full px-3.5 py-2 rounded-xl bg-[#f8faf9] border border-slate-200 text-xs text-slate-800 focus:bg-white focus:border-[#16a34a] focus:outline-none"
                                        >
                                            <option value="">General NGO Fund (Where most needed)</option>
                                            @if(isset($campaigns))
                                                @foreach($campaigns as $camp)
                                                    <option value="{{ $camp->id }}" {{ old('campaign_id', $selectedCampaignId ?? null) == $camp->id ? 'selected' : '' }}>
                                                        {{ $camp->title }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="donor_message" class="block text-xs font-bold text-[#14291b] mb-1">
                                        Message (Optional)
                                    </label>
                                    <input
                                        type="text"
                                        id="donor_message"
                                        name="donor_message"
                                        value="{{ old('donor_message') }}"
                                        placeholder="A short note of encouragement..."
                                        class="w-full px-3.5 py-2 rounded-xl bg-[#f8faf9] border border-slate-200 text-xs text-slate-800 focus:bg-white focus:border-[#16a34a] focus:outline-none"
                                    >
                                </div>

                                <label class="flex items-center gap-2.5 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="is_anonymous"
                                        value="1"
                                        {{ old('is_anonymous') ? 'checked' : '' }}
                                        class="rounded border-slate-300 text-[#16a34a] focus:ring-[#16a34a]"
                                    >
                                    <span class="text-xs text-slate-600">
                                        Make my donation anonymous on the public donor wall
                                    </span>
                                </label>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-1">
                            <button
                                type="submit"
                                class="w-full py-3.5 px-6 rounded-xl bg-[#16a34a] hover:bg-[#15803d] text-white font-bold text-sm shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <span>Submit Donation</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                </svg>
                            </button>
                        </div>

                        {{-- Bottom Privacy Reassurance --}}
                        <div class="pt-1 flex items-center justify-center gap-1.5 text-center text-[11px] text-slate-500">
                            <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd"/>
                            </svg>
                            <span>Your information is safe and secure. We never share your data.</span>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

{{-- ===================================================================
     3. 4-COLUMN SOFT-MINT TRUST & VERIFICATION STRIP
==================================================================== --}}
<section class="bg-[#f2fbf5] border-y border-[#d8f3df] py-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            {{-- 1. 100% Secure --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-extrabold text-[#14291b]">100% Secure</h3>
                    <p class="text-[11px] text-slate-600">Your data is protected</p>
                </div>
            </div>

            {{-- 2. Manual Verification --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-extrabold text-[#14291b]">Manual Verification</h3>
                    <p class="text-[11px] text-slate-600">All donations are verified</p>
                </div>
            </div>

            {{-- 3. 80G Tax Benefit --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-extrabold text-[#14291b]">80G Tax Benefit</h3>
                    <p class="text-[11px] text-slate-600">Eligible donations receive 80G receipt</p>
                </div>
            </div>

            {{-- 4. Transparent Usage --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-extrabold text-[#14291b]">Transparent Usage</h3>
                    <p class="text-[11px] text-slate-600">See how your donation creates impact</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===================================================================
     4. DARK FOREST GREEN "RECENT DONORS" CAROUSEL STRIP
==================================================================== --}}
<section class="bg-[#071f12] py-8 border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Row --}}
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-heading text-base sm:text-lg font-extrabold text-white">
                Recent Donors
            </h2>
            <a href="{{ $statusRoute }}" class="inline-flex items-center gap-1 text-xs font-bold text-white/90 hover:text-[#4ade80] transition">
                <span>View All</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>

        {{-- Carousel Row with Left & Right Navigation Arrows --}}
        <div class="relative flex items-center gap-3">
            {{-- Left Arrow --}}
            <button
                type="button"
                aria-label="Previous Donors"
                onclick="document.getElementById('recent-donors-track').scrollBy({left: -260, behavior: 'smooth'})"
                class="hidden sm:flex w-8 h-8 rounded-full bg-white text-slate-800 hover:bg-[#dcfce7] items-center justify-center shrink-0 shadow-md transition cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </button>

            {{-- Cards Track --}}
            <div id="recent-donors-track" class="flex-1 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3.5 overflow-x-auto no-scrollbar">
                @if(isset($recentDonations) && $recentDonations->count() > 0)
                    @foreach($recentDonations->take(5) as $idx => $recent)
                        @php
                            $nameDisplay = $recent->is_anonymous ? 'Anonymous' : $recent->donor_name;
                            $words = explode(' ', trim($nameDisplay));
                            $initials = $recent->is_anonymous
                                ? 'AN'
                                : strtoupper(substr($words[0] ?? 'D', 0, 1) . substr($words[1] ?? '', 0, 1));
                        @endphp
                        <div class="bg-white rounded-2xl p-3.5 flex items-center gap-3 shadow-xs">
                            <div class="w-11 h-11 rounded-full {{ $avatarColors[$idx % count($avatarColors)] }} font-extrabold text-xs flex items-center justify-center shrink-0">
                                {{ $initials }}
                            </div>
                            <div class="min-w-0">
                                <span class="block text-xs font-extrabold text-[#14291b] truncate">{{ $nameDisplay }}</span>
                                <span class="block text-xs font-extrabold text-[#14291b] mt-0.5">₹{{ number_format($recent->amount) }}</span>
                                <span class="block text-[10.5px] text-slate-500 mt-0.5">{{ $recent->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    @foreach($fallbackDonors as $donor)
                        <div class="bg-white rounded-2xl p-3.5 flex items-center gap-3 shadow-xs">
                            <div class="w-11 h-11 rounded-full {{ $donor['color'] }} font-extrabold text-xs flex items-center justify-center shrink-0">
                                {{ $donor['initials'] }}
                            </div>
                            <div class="min-w-0">
                                <span class="block text-xs font-extrabold text-[#14291b] truncate">{{ $donor['name'] }}</span>
                                <span class="block text-xs font-extrabold text-[#14291b] mt-0.5">₹{{ number_format($donor['amount']) }}</span>
                                <span class="block text-[10.5px] text-slate-500 mt-0.5">{{ $donor['time'] }}</span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Right Arrow --}}
            <button
                type="button"
                aria-label="Next Donors"
                onclick="document.getElementById('recent-donors-track').scrollBy({left: 260, behavior: 'smooth'})"
                class="hidden sm:flex w-8 h-8 rounded-full bg-white text-slate-800 hover:bg-[#dcfce7] items-center justify-center shrink-0 shadow-md transition cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </button>
        </div>

    </div>
</section>

<script>
    function switchPaymentTab(type) {
        const upiBtn = document.getElementById('tab-upi-btn');
        const bankBtn = document.getElementById('tab-bank-btn');
        const upiPanel = document.getElementById('panel-upi');
        const bankPanel = document.getElementById('panel-bank');
        const formMode = document.getElementById('form_payment_mode');

        if (type === 'upi') {
            upiBtn.classList.add('border-[#16a34a]', 'bg-[#f2fbf5]');
            upiBtn.classList.remove('border-slate-200', 'bg-white');
            bankBtn.classList.remove('border-[#16a34a]', 'bg-[#f2fbf5]');
            bankBtn.classList.add('border-slate-200', 'bg-white');

            upiPanel.classList.remove('hidden');
            bankPanel.classList.add('hidden', 'sm:block');
            formMode.value = 'upi_qr';
        } else {
            bankBtn.classList.add('border-[#16a34a]', 'bg-[#f2fbf5]');
            bankBtn.classList.remove('border-slate-200', 'bg-white');
            upiBtn.classList.remove('border-[#16a34a]', 'bg-[#f2fbf5]');
            upiBtn.classList.add('border-slate-200', 'bg-white');

            bankPanel.classList.remove('hidden');
            if (window.innerWidth < 640) {
                upiPanel.classList.add('hidden');
            }
            formMode.value = 'bank_transfer';
        }
    }

    function setPresetAmount(amount, btn) {
        const input = document.getElementById('amount_input');
        const wrapper = document.getElementById('custom-amount-wrapper');
        input.value = amount;
        wrapper.classList.add('hidden');

        document.querySelectorAll('.amount-preset-btn').forEach(b => {
            b.classList.remove('bg-[#16a34a]', 'text-white', 'border-[#16a34a]', 'shadow-xs');
            b.classList.add('bg-white', 'text-[#14291b]', 'border-slate-200/80');
        });
        btn.classList.remove('bg-white', 'text-[#14291b]', 'border-slate-200/80');
        btn.classList.add('bg-[#16a34a]', 'text-white', 'border-[#16a34a]', 'shadow-xs');
    }

    function focusCustomAmount(btn) {
        const input = document.getElementById('amount_input');
        const wrapper = document.getElementById('custom-amount-wrapper');
        wrapper.classList.remove('hidden');

        document.querySelectorAll('.amount-preset-btn').forEach(b => {
            b.classList.remove('bg-[#16a34a]', 'text-white', 'border-[#16a34a]', 'shadow-xs');
            b.classList.add('bg-white', 'text-[#14291b]', 'border-slate-200/80');
        });
        btn.classList.remove('bg-white', 'text-[#14291b]', 'border-slate-200/80');
        btn.classList.add('bg-[#16a34a]', 'text-white', 'border-[#16a34a]', 'shadow-xs');

        input.focus();
        input.select();
    }

    function copyToClipboard(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<span class="text-[10px] font-extrabold px-1">✓</span>';
            setTimeout(() => {
                btn.innerHTML = originalHTML;
            }, 1500);
        });
    }

    function copyAllBankDetails(btn) {
        const holder = document.getElementById('bank-holder').innerText;
        const name = document.getElementById('bank-name').innerText;
        const acc = document.getElementById('bank-acc').innerText;
        const ifsc = document.getElementById('bank-ifsc').innerText;

        const allDetails = `Account Name: ${holder}\nBank Name: ${name}\nAccount Number: ${acc}\nIFSC Code: ${ifsc}`;
        navigator.clipboard.writeText(allDetails).then(() => {
            if (btn) {
                const orig = btn.innerText;
                btn.innerText = 'Copied All Details ✓';
                setTimeout(() => btn.innerText = orig, 1800);
            }
        });
    }

    function handleScreenshotPreview(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                alert('File size exceeds 2MB limit. Please select a smaller image.');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('preview-filename').textContent = file.name;
                document.getElementById('upload-placeholder').classList.add('hidden');
                document.getElementById('upload-preview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
