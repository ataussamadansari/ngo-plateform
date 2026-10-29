@extends('layouts.base')

@section('title', 'Donation Status - ' . (function_exists('setting') ? setting('ngo_name', 'Hope Foundation') : 'Hope Foundation'))

@section('content')
<!-- ================= HERO SECTION ================= -->
<section class="relative isolate overflow-hidden bg-[#041f13] text-white">
    <!-- Background Image with Depth Gradient Overlay -->
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <img src="{{ function_exists('setting') && setting('status_banner_image') ? asset('storage/' . setting('status_banner_image')) : 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=1920&q=85' }}"
             alt="Children smiling together"
             class="h-full w-full object-cover object-[center_35%] opacity-45 mix-blend-luminosity brightness-110 contrast-105 sm:opacity-50">
        <!-- Dual Layer Gradient: solid dark green from left, fading smoothly across children -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#031b10] via-[#052819]/90 to-[#041f13]/40"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#031b10] via-transparent to-transparent opacity-80"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-14 lg:px-8 lg:py-16">
        <div class="grid grid-cols-1 items-center gap-8 lg:grid-cols-12">
            <!-- Left: Hero Headline & Subtitle -->
            <div class="lg:col-span-8">
                <span class="inline-block text-[11px] font-extrabold uppercase tracking-[0.22em] text-[#4ade80] sm:text-xs">
                    DONATION STATUS
                </span>
                <h1 class="mt-2 max-w-xl text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl leading-[1.15]">
                    Your Support Creates Real Change
                </h1>
                <p class="mt-3.5 max-w-xl text-sm leading-relaxed text-emerald-50/90 sm:text-base">
                    Check your donation status, download your receipt and see the impact of your contribution.
                </p>
            </div>

            <!-- Right: Handwritten Script Badge (Desktop Only per Mockup) -->
            <div class="hidden lg:flex lg:col-span-4 justify-end">
                <div class="transform -rotate-6 text-center select-none pointer-events-none pr-4">
                    <p class="font-script text-3xl xl:text-4xl font-normal leading-tight text-white drop-shadow-md">
                        Thank You<br>
                        for Being<br>
                        Part of Our<br>
                        Journey <span class="inline-block text-2xl xl:text-3xl text-[#4ade80]">💚</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= MAIN PORTAL SECTION ================= -->
<main class="bg-[#f8fafc] py-8 sm:py-10 lg:py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-12 lg:gap-8">

            <!-- ================= LEFT COLUMN: SEARCH & STATUS ================= -->
            <div class="space-y-6 lg:col-span-8">

                <!-- 1. Check Donation Status (Search Card) -->
                <section aria-labelledby="search-heading" class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-7 shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                    <div class="flex items-start gap-4">
                        <!-- Green Document + Magnifying Glass Icon -->
                        <div class="flex h-12 w-12 sm:h-14 sm:w-14 shrink-0 items-center justify-center rounded-2xl border border-emerald-100 bg-[#ecfdf5] text-[#059669] shadow-xs">
                            <svg class="h-6 w-6 sm:h-7 sm:w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h4m3 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                <circle cx="16" cy="16" r="3" stroke-width="1.8"/>
                                <path stroke-linecap="round" stroke-width="1.8" d="M18.5 18.5l2.5 2.5"/>
                            </svg>
                        </div>
                        <div>
                            <h2 id="search-heading" class="text-lg sm:text-xl font-bold tracking-tight text-slate-900">
                                Check Donation Status
                            </h2>
                            <p class="mt-1 text-xs sm:text-sm text-slate-500 leading-normal">
                                Enter your UTR number or reference number to check your donation status and download the receipt.
                            </p>
                        </div>
                    </div>

                    <!-- Search Input & CTA Button Form -->
                    <form action="{{ route('donation.status') }}" method="GET" class="mt-5 sm:mt-6" role="search" aria-label="Donation status lookup">
                        <div class="flex flex-col sm:flex-row items-stretch gap-2.5 sm:gap-3">
                            <div class="relative flex-1">
                                <input type="text"
                                       name="query"
                                       value="{{ $query }}"
                                       required
                                       placeholder="Enter UTR number or reference number"
                                       aria-label="Enter UTR number or reference number"
                                       autocomplete="off"
                                       class="w-full rounded-xl border border-slate-200/90 bg-slate-50/50 px-4 py-3 sm:py-3.5 text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-emerald-600 focus:ring-4 focus:ring-emerald-600/10 focus:outline-none transition-all duration-200">
                            </div>
                            <button type="submit"
                                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#16a34a] hover:bg-[#15803d] active:scale-[0.99] px-6 sm:px-7 py-3 sm:py-3.5 text-sm font-bold text-white shadow-sm hover:shadow transition-all duration-200 cursor-pointer">
                                <span>Check Status</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Helper Tip -->
                        <div class="mt-3 flex items-center gap-1.5 text-[11px] sm:text-xs text-slate-500">
                            <svg class="h-4 w-4 shrink-0 text-slate-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <span>You can also check using your registered mobile number or email ID.</span>
                        </div>
                    </form>
                </section>

                <!-- ================= SEARCH RESULTS AREA ================= -->
                @if($query !== '')
                    @if($donations->isNotEmpty())
                        <div class="space-y-6">
                            @foreach($donations as $donation)

                                <!-- STATE A: DONATION VERIFIED -->
                                @if($donation->isVerified())
                                    <div class="overflow-hidden rounded-2xl sm:rounded-3xl border border-emerald-100 bg-[#f0fdf4]/50 p-5 sm:p-7 shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                                        <!-- Header Row -->
                                        <div class="flex flex-wrap items-center justify-between gap-3 pb-5 border-b border-emerald-100">
                                            <div class="flex items-center gap-3">
                                                <!-- Green Circle Checkmark -->
                                                <div class="flex h-9 w-9 sm:h-10 sm:w-10 shrink-0 items-center justify-center rounded-full bg-[#16a34a] text-white shadow-xs">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-base sm:text-lg font-bold text-slate-900">Donation Verified</h3>
                                                    <p class="text-xs sm:text-sm text-slate-500">
                                                        Thank you for your generous support! Your donation has been successfully processed and verified.
                                                    </p>
                                                </div>
                                            </div>

                                            <span class="inline-flex items-center rounded-full bg-[#dcfce7] px-3 py-1 text-xs font-semibold text-[#15803d] border border-emerald-200/60 shadow-2xs">
                                                Receipt Available
                                            </span>
                                        </div>

                                        <!-- Main Details & Mini-Receipt Layout -->
                                        <div class="pt-5 flex flex-col lg:flex-row items-stretch justify-between gap-6">

                                            <!-- 2x3 Grid of Donation Details -->
                                            <div class="flex-1 grid grid-cols-2 sm:grid-cols-3 gap-y-4 gap-x-5">
                                                <div>
                                                    <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-400">Donor Name</span>
                                                    <span class="mt-0.5 block text-sm sm:text-base font-bold text-slate-900 truncate">
                                                        {{ $donation->is_anonymous ? 'Anonymous Supporter' : $donation->donor_name }}
                                                    </span>
                                                </div>

                                                <div>
                                                    <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-400">Amount</span>
                                                    <span class="mt-0.5 block text-sm sm:text-base font-bold text-slate-900">
                                                        ₹{{ number_format($donation->amount, 2) }}
                                                    </span>
                                                </div>

                                                <div>
                                                    <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-400">Payment Method</span>
                                                    <span class="mt-0.5 block text-sm sm:text-base font-bold text-slate-900">
                                                        {{ $donation->payment_mode === 'upi_qr' ? 'UPI' : 'Bank Transfer' }}
                                                    </span>
                                                </div>

                                                <div>
                                                    <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-400">UTR / Reference No.</span>
                                                    <span class="mt-0.5 block text-xs sm:text-sm font-mono font-bold text-slate-900 break-all">
                                                        {{ $donation->utr_number }}
                                                    </span>
                                                </div>

                                                <div>
                                                    <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-400">Date & Time</span>
                                                    <span class="mt-0.5 block text-xs sm:text-sm font-medium text-slate-800">
                                                        {{ $donation->created_at->format('d M Y, h:i A') }}
                                                    </span>
                                                </div>

                                                <div>
                                                    <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-400">Campaign</span>
                                                    <span class="mt-0.5 block text-xs sm:text-sm font-semibold text-slate-900 truncate">
                                                        {{ $donation->campaign ? $donation->campaign->title : 'Education for Every Child' }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Mini-Receipt Preview Card (Desktop View per Mockup) -->
                                            <div class="hidden sm:block w-72 shrink-0 rounded-2xl border border-slate-200/90 bg-white p-4 shadow-sm text-center">
                                                <div class="flex items-center justify-center gap-1.5 mb-2">
                                                    <div class="flex h-5 w-5 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                                    </div>
                                                    <div class="text-left">
                                                        <span class="block text-[11px] font-extrabold text-slate-900 leading-tight">{{ setting('ngo_name', 'Hope Foundation') }}</span>
                                                        <span class="block text-[8px] text-slate-400 leading-none">{{ setting('ngo_tagline', 'For a Better Tomorrow') }}</span>
                                                    </div>
                                                </div>

                                                <div class="text-[10px] font-bold text-slate-700 uppercase tracking-wider py-1 border-y border-dashed border-slate-200 mb-2">
                                                    Donation Receipt
                                                </div>

                                                <div class="space-y-1 text-[10px] text-left">
                                                    <div class="flex justify-between text-slate-500">
                                                        <span>Receipt No:</span>
                                                        <span class="font-mono font-semibold text-slate-800">{{ $donation->receipt_number ?? 'HF'.date('Y').'/00'.$donation->id }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-slate-500">
                                                        <span>Date:</span>
                                                        <span class="font-medium text-slate-800">{{ $donation->verified_at ? $donation->verified_at->format('d M Y') : $donation->created_at->format('d M Y') }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-slate-500">
                                                        <span>Donor Name:</span>
                                                        <span class="font-bold text-slate-800 truncate max-w-[130px]">{{ $donation->donor_name }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-slate-500">
                                                        <span>Amount:</span>
                                                        <span class="font-bold text-emerald-700">₹{{ number_format($donation->amount, 2) }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-slate-500">
                                                        <span>Payment Mode:</span>
                                                        <span class="font-medium text-slate-800">{{ $donation->payment_mode === 'upi_qr' ? 'UPI' : 'Bank Transfer' }}</span>
                                                    </div>
                                                </div>

                                                <div class="mt-3 pt-2 border-t border-slate-100">
                                                    <span class="font-script text-base text-slate-800 block">Thank You</span>
                                                    <span class="text-[9px] text-slate-400 block">Your support helps us create a brighter tomorrow.</span>
                                                </div>

                                                <a href="{{ route('donation.receipt', $donation->id) }}"
                                                   class="mt-3 inline-flex w-full items-center justify-center gap-1.5 rounded-xl bg-[#16a34a] hover:bg-[#15803d] px-3 py-2.5 text-xs font-bold text-white shadow-xs transition">
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    <span>Download Receipt (PDF)</span>
                                                </a>
                                            </div>

                                            <!-- Mobile View Download Button (Matches Mobile Mockup) -->
                                            <div class="mt-2 sm:hidden w-full">
                                                <a href="{{ route('donation.receipt', $donation->id) }}"
                                                   class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#16a34a] hover:bg-[#15803d] px-4 py-3 text-sm font-bold text-white shadow-sm transition">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    <span>Download Receipt (PDF)</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                <!-- STATE B: DONATION PENDING -->
                                @elseif($donation->isPending())
                                    <div class="overflow-hidden rounded-2xl sm:rounded-3xl border border-amber-200 bg-amber-50/40 p-5 sm:p-7 shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                                        <div class="flex flex-wrap items-center justify-between gap-3 pb-5 border-b border-amber-200/80">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-9 w-9 sm:h-10 sm:w-10 shrink-0 items-center justify-center rounded-full bg-amber-500 text-white shadow-xs">
                                                    <svg class="h-5 w-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-base sm:text-lg font-bold text-slate-900">Verification in Progress</h3>
                                                    <p class="text-xs sm:text-sm text-slate-500">
                                                        Your payment proof has been submitted and is currently being verified against our bank records.
                                                    </p>
                                                </div>
                                            </div>

                                            <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800 border border-amber-200">
                                                Pending Verification
                                            </span>
                                        </div>

                                        <div class="pt-5 grid grid-cols-2 sm:grid-cols-3 gap-y-4 gap-x-5">
                                            <div>
                                                <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-400">Donor Name</span>
                                                <span class="mt-0.5 block text-sm sm:text-base font-bold text-slate-900 truncate">{{ $donation->donor_name }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-400">Amount</span>
                                                <span class="mt-0.5 block text-sm sm:text-base font-bold text-slate-900">₹{{ number_format($donation->amount, 2) }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-400">UTR / Ref No.</span>
                                                <span class="mt-0.5 block text-xs sm:text-sm font-mono font-bold text-slate-900 break-all">{{ $donation->utr_number }}</span>
                                            </div>
                                        </div>

                                        <!-- Verification Timeline Note -->
                                        <div class="mt-5 rounded-xl border border-amber-200/80 bg-white p-4 text-xs text-amber-900">
                                            <p class="font-bold flex items-center gap-1.5">
                                                <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                                                Reconciling with Bank Statement...
                                            </p>
                                            <p class="mt-1 text-slate-600">
                                                Our accounts team reconciles donations manually against bank credit records. Verification typically completes within <strong>2 to 4 hours</strong> during business hours.
                                            </p>
                                        </div>
                                    </div>

                                <!-- STATE C: DONATION REJECTED -->
                                @elseif($donation->isRejected())
                                    <div class="overflow-hidden rounded-2xl sm:rounded-3xl border border-rose-200 bg-rose-50/40 p-5 sm:p-7 shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                                        <div class="flex flex-wrap items-center justify-between gap-3 pb-5 border-b border-rose-200/80">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-9 w-9 sm:h-10 sm:w-10 shrink-0 items-center justify-center rounded-full bg-rose-600 text-white shadow-xs">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-base sm:text-lg font-bold text-rose-900">Verification Unsuccessful</h3>
                                                    <p class="text-xs sm:text-sm text-slate-500">
                                                        We could not reconcile this donation with our bank records.
                                                    </p>
                                                </div>
                                            </div>

                                            <span class="inline-flex items-center rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-800 border border-rose-200">
                                                Rejected
                                            </span>
                                        </div>

                                        <div class="mt-5 rounded-xl border border-rose-200 bg-white p-4">
                                            <span class="block text-[11px] font-bold uppercase tracking-wider text-rose-800">Reason / Remarks:</span>
                                            <p class="mt-1 text-sm text-rose-700 font-medium">
                                                {{ $donation->admin_remarks ?? 'Transaction not found in bank statement or UTR mismatch.' }}
                                            </p>
                                        </div>

                                        <p class="mt-4 text-xs text-slate-500">
                                            If funds were debited from your account, please contact our donor care team at
                                            <a href="mailto:{{ setting('contact_email', 'contact@hopefoundation.org') }}" class="font-semibold text-emerald-700 underline">
                                                {{ setting('contact_email', 'contact@hopefoundation.org') }}
                                            </a>
                                            with your bank debit statement.
                                        </p>
                                    </div>
                                @endif

                            @endforeach
                        </div>
                    @else
                        <!-- No Matching Result Found -->
                        <div class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-8 text-center shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-bold text-slate-900">No Donations Found</h3>
                            <p class="mx-auto mt-1 max-w-md text-xs sm:text-sm text-slate-500">
                                We could not find any transaction matching <span class="font-mono font-semibold text-slate-800">"{{ $query }}"</span>. Please double-check your 12-digit UTR number or enter your registered phone number.
                            </p>
                            <div class="mt-5 flex justify-center gap-3">
                                <a href="{{ route('donate.index') }}" class="rounded-xl bg-[#16a34a] hover:bg-[#15803d] px-5 py-2.5 text-xs font-bold text-white transition">
                                    Make a Donation
                                </a>
                                <a href="{{ route('donation.status') }}" class="rounded-xl bg-slate-100 hover:bg-slate-200 px-5 py-2.5 text-xs font-semibold text-slate-700 transition">
                                    Clear Search
                                </a>
                            </div>
                        </div>
                    @endif
                @endif

                <!-- ================= 2. RECENT DONATIONS TABLE ================= -->
                <section aria-labelledby="recent-donations-heading" class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-7 shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 id="recent-donations-heading" class="text-base sm:text-lg font-bold text-slate-900">
                            Recent Donations
                        </h3>
                        <a href="{{ route('transparency.index') }}" class="inline-flex items-center gap-1 text-xs sm:text-sm font-semibold text-[#16a34a] hover:text-[#15803d] transition">
                            <span>View All</span>
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>

                    <!-- Responsive Table Container -->
                    <div class="mt-4 -mx-5 sm:mx-0 overflow-x-auto">
                        <table class="w-full min-w-[620px] text-left text-xs sm:text-sm">
                            <thead>
                                <tr class="text-[11px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                                    <th scope="col" class="py-3 px-4">Date</th>
                                    <th scope="col" class="py-3 px-4">Donor Name</th>
                                    <th scope="col" class="py-3 px-4">Amount</th>
                                    <th scope="col" class="py-3 px-4">Campaign</th>
                                    <th scope="col" class="py-3 px-4 text-center">Status</th>
                                    <th scope="col" class="py-3 px-4 text-right">Receipt</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @if(isset($recentDonations) && $recentDonations->isNotEmpty())
                                    @foreach($recentDonations as $recent)
                                        <tr class="hover:bg-slate-50/70 transition-colors">
                                            <td class="py-3.5 px-4 font-medium text-slate-600 whitespace-nowrap">
                                                {{ $recent->created_at->format('d M Y') }}
                                            </td>
                                            <td class="py-3.5 px-4 font-bold text-slate-800">
                                                {{ $recent->is_anonymous ? 'Anonymous' : $recent->donor_name }}
                                            </td>
                                            <td class="py-3.5 px-4 font-bold text-slate-900 whitespace-nowrap">
                                                ₹{{ number_format($recent->amount, 0) }}
                                            </td>
                                            <td class="py-3.5 px-4 text-slate-600 truncate max-w-[180px]">
                                                {{ $recent->campaign ? $recent->campaign->title : 'Education for Every Child' }}
                                            </td>
                                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                                <span class="inline-flex items-center rounded-full bg-[#dcfce7] px-2.5 py-0.5 text-[11px] font-semibold text-[#15803d]">
                                                    Verified
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                                <a href="{{ route('donation.receipt', $recent->id) }}" class="inline-flex items-center gap-1 font-semibold text-[#16a34a] hover:text-[#15803d] text-xs">
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    <span>Download</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <!-- Fallback Sample Recent Donations per Design Mockup -->
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="py-3.5 px-4 font-medium text-slate-600 whitespace-nowrap">15 Oct 2025</td>
                                        <td class="py-3.5 px-4 font-bold text-slate-800">Mohd. Ayaan Khan</td>
                                        <td class="py-3.5 px-4 font-bold text-slate-900 whitespace-nowrap">₹2,000</td>
                                        <td class="py-3.5 px-4 text-slate-600">Education for Every Child</td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center rounded-full bg-[#dcfce7] px-2.5 py-0.5 text-[11px] font-semibold text-[#15803d]">
                                                Verified
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 font-semibold text-[#16a34a] cursor-pointer">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                Download
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="py-3.5 px-4 font-medium text-slate-600 whitespace-nowrap">12 Oct 2025</td>
                                        <td class="py-3.5 px-4 font-bold text-slate-800">Priya Sharma</td>
                                        <td class="py-3.5 px-4 font-bold text-slate-900 whitespace-nowrap">₹1,000</td>
                                        <td class="py-3.5 px-4 text-slate-600">Food Distribution</td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center rounded-full bg-[#dcfce7] px-2.5 py-0.5 text-[11px] font-semibold text-[#15803d]">
                                                Verified
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 font-semibold text-[#16a34a] cursor-pointer">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                Download
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="py-3.5 px-4 font-medium text-slate-600 whitespace-nowrap">10 Oct 2025</td>
                                        <td class="py-3.5 px-4 font-bold text-slate-800">Rahul Verma</td>
                                        <td class="py-3.5 px-4 font-bold text-slate-900 whitespace-nowrap">₹5,000</td>
                                        <td class="py-3.5 px-4 text-slate-600">Health Camp Support</td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center rounded-full bg-[#dcfce7] px-2.5 py-0.5 text-[11px] font-semibold text-[#15803d]">
                                                Verified
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 font-semibold text-[#16a34a] cursor-pointer">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                Download
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="py-3.5 px-4 font-medium text-slate-600 whitespace-nowrap">08 Oct 2025</td>
                                        <td class="py-3.5 px-4 font-bold text-slate-800">Neha Singh</td>
                                        <td class="py-3.5 px-4 font-bold text-slate-900 whitespace-nowrap">₹500</td>
                                        <td class="py-3.5 px-4 text-slate-600">Clean Water Initiative</td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center rounded-full bg-[#dcfce7] px-2.5 py-0.5 text-[11px] font-semibold text-[#15803d]">
                                                Verified
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 font-semibold text-[#16a34a] cursor-pointer">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                Download
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>

            <!-- ================= RIGHT COLUMN: SIDEBAR ================= -->
            <aside class="space-y-6 lg:col-span-4" aria-label="Portal assistance and impact">

                <!-- 1. Your Impact Card -->
                <div class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-6 shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 pb-3 border-b border-slate-100">
                        Your Impact
                    </h3>

                    <div class="mt-4 space-y-3.5">
                        <!-- Impact 1: Education Support (Green) -->
                        <div class="flex items-center justify-between gap-3 group">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900">Education Support</h4>
                                    <p class="text-[11px] sm:text-xs text-slate-500 leading-tight mt-0.5">Helps provide books, uniforms and quality education.</p>
                                </div>
                            </div>
                            <span class="sm:hidden text-slate-400 font-bold" aria-hidden="true">›</span>
                        </div>

                        <!-- Impact 2: Healthcare Support (Blue) -->
                        <div class="flex items-center justify-between gap-3 group">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600 border border-sky-100">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900">Healthcare Support</h4>
                                    <p class="text-[11px] sm:text-xs text-slate-500 leading-tight mt-0.5">Supports medical camps and essential medicines.</p>
                                </div>
                            </div>
                            <span class="sm:hidden text-slate-400 font-bold" aria-hidden="true">›</span>
                        </div>

                        <!-- Impact 3: Food & Nutrition (Amber) -->
                        <div class="flex items-center justify-between gap-3 group">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 border border-amber-100">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900">Food & Nutrition</h4>
                                    <p class="text-[11px] sm:text-xs text-slate-500 leading-tight mt-0.5">Provides nutritious meals to underprivileged families.</p>
                                </div>
                            </div>
                            <span class="sm:hidden text-slate-400 font-bold" aria-hidden="true">›</span>
                        </div>

                        <!-- Impact 4: Community Development (Purple) -->
                        <div class="flex items-center justify-between gap-3 group">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600 border border-purple-100">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900">Community Development</h4>
                                    <p class="text-[11px] sm:text-xs text-slate-500 leading-tight mt-0.5">Builds stronger and self-reliant communities.</p>
                                </div>
                            </div>
                            <span class="sm:hidden text-slate-400 font-bold" aria-hidden="true">›</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Need Help? Card -->
                <div class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-6 shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                    <div class="flex items-center gap-3 mb-2.5">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900">Need Help?</h4>
                            <p class="text-[11px] text-slate-500">Donor Support Care</p>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-slate-600 leading-normal mb-4">
                        If you are facing any issue in checking your donation status or downloading your receipt, feel free to contact us.
                    </p>

                    <a href="{{ route('contact.index') }}"
                       class="inline-flex w-full items-center justify-center gap-1.5 rounded-xl border border-emerald-600 bg-white px-4 py-2.5 text-xs sm:text-sm font-bold text-emerald-700 hover:bg-emerald-50 active:scale-[0.99] transition shadow-xs">
                        <span>Contact Support</span>
                        <span aria-hidden="true">→</span>
                    </a>
                </div>

                <!-- 3. Important Information Card -->
                <div class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-6 shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                    <h4 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span>💡</span>
                        <span>Important Information</span>
                    </h4>

                    <ol class="space-y-3 text-xs sm:text-sm text-slate-600">
                        <li class="flex items-start gap-2.5">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-slate-900 text-[11px] font-bold text-white mt-0.5">
                                1
                            </span>
                            <span class="leading-relaxed">It may take a few minutes to update your donation status.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-slate-900 text-[11px] font-bold text-white mt-0.5">
                                2
                            </span>
                            <span class="leading-relaxed">Please enter the correct UTR number or reference number.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-slate-900 text-[11px] font-bold text-white mt-0.5">
                                3
                            </span>
                            <span class="leading-relaxed">If you donated via bank transfer, the status will be updated after verification.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-slate-900 text-[11px] font-bold text-white mt-0.5">
                                4
                            </span>
                            <span class="leading-relaxed">For any issues, please contact our support team.</span>
                        </li>
                    </ol>
                </div>

            </aside>

        </div>
    </div>
</main>
@endsection
