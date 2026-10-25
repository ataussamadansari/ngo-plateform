@extends('layouts.base')

@section('title', 'Track Donation Status - ' . setting('ngo_name', 'NGO Platform'))

@section('content')
<!-- Hero Header -->
<div class="relative bg-slate-900 text-white py-12 md:py-16 overflow-hidden">
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#16a34a_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="flex items-center text-xs sm:text-sm text-slate-400 mb-4 gap-2">
            <a href="{{ url('/') }}" class="hover:text-white transition">Home</a>
            <span>&rsaquo;</span>
            <a href="{{ route('donate.index') }}" class="hover:text-white transition">Donate</a>
            <span>&rsaquo;</span>
            <span class="text-emerald-400 font-medium">Donation Status</span>
        </nav>

        <div class="max-w-3xl">
            <span class="text-xs font-bold tracking-widest text-emerald-400 uppercase block mb-2">DONATION STATUS</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-white mb-3">
                Your Support Creates Real Change
            </h1>
            <p class="text-base sm:text-lg text-slate-300">
                Check your donation status, download your receipt and track the direct impact of your contribution.
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Left / Main Column: Search & Results -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Search Card -->
            <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200">
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Check Donation Status</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Enter your UTR number or transaction reference number to check verification status and download your receipt.
                        </p>
                    </div>
                </div>

                <form action="{{ route('donation.status') }}" method="GET" class="space-y-3">
                    <div class="flex flex-col sm:flex-row gap-2">
                        <input type="text" name="query" value="{{ $query }}" required placeholder="Enter UTR number or reference number (e.g. 432198765432)" class="flex-grow px-4 py-3 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm font-mono text-slate-900">
                        <button type="submit" class="px-6 py-3 rounded-xl font-bold text-white shadow-sm transition bg-primary hover:opacity-95 shrink-0 flex items-center justify-center gap-2">
                            <span>Check Status</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                    <p class="text-xs text-slate-400 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        You can also check using your registered mobile number or receipt number.
                    </p>
                </form>
            </div>

            <!-- Search Results Display -->
            @if($query !== '')
                @if($donations->isNotEmpty())
                    <div class="space-y-6">
                        @foreach($donations as $donation)

                            <!-- Status: VERIFIED -->
                            @if($donation->isVerified())
                                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-emerald-200">
                                    <div class="flex flex-wrap items-center justify-between gap-3 pb-6 border-b border-slate-100">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-bold text-slate-900">Donation Verified</h3>
                                                <p class="text-xs text-slate-500">Thank you for your generous support! Your donation has been verified.</p>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            Receipt Available
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 my-6">
                                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                            <span class="text-[11px] font-semibold text-slate-400 uppercase block">Donor Name</span>
                                            <span class="text-sm font-bold text-slate-900 block truncate">
                                                {{ $donation->is_anonymous ? 'Anonymous Supporter' : $donation->donor_name }}
                                            </span>
                                        </div>

                                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                            <span class="text-[11px] font-semibold text-slate-400 uppercase block">Amount</span>
                                            <span class="text-sm font-bold text-emerald-600 block">
                                                ₹{{ number_format($donation->amount, 2) }}
                                            </span>
                                        </div>

                                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                            <span class="text-[11px] font-semibold text-slate-400 uppercase block">Payment Method</span>
                                            <span class="text-sm font-bold text-slate-800 block">
                                                {{ $donation->payment_mode === 'upi_qr' ? 'UPI' : 'Bank Transfer' }}
                                            </span>
                                        </div>

                                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                            <span class="text-[11px] font-semibold text-slate-400 uppercase block">UTR / Ref No.</span>
                                            <span class="text-xs font-mono font-bold text-slate-800 block truncate">
                                                {{ $donation->utr_number }}
                                            </span>
                                        </div>

                                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                            <span class="text-[11px] font-semibold text-slate-400 uppercase block">Date & Time</span>
                                            <span class="text-xs font-medium text-slate-700 block">
                                                {{ $donation->created_at->format('d M Y, h:i A') }}
                                            </span>
                                        </div>

                                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                            <span class="text-[11px] font-semibold text-slate-400 uppercase block">Campaign</span>
                                            <span class="text-xs font-medium text-slate-800 block truncate">
                                                {{ $donation->campaign ? $donation->campaign->title : 'General Relief' }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Receipt Download Container -->
                                    <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                                        <div>
                                            <span class="text-xs font-bold text-emerald-900 block">Official 80G Receipt</span>
                                            <span class="text-xs text-emerald-700 font-mono">Receipt No: {{ $donation->receipt_number ?? (setting('receipt_prefix', 'KSF') . '-' . date('Y') . '-' . str_pad($donation->id, 4, '0', STR_PAD_LEFT)) }}</span>
                                        </div>
                                        <button type="button" onclick="alert('80G Receipt PDF download will be activated in Phase 3.')" class="w-full sm:w-auto px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-emerald-600 hover:bg-emerald-700 shadow-xs transition flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Download Receipt (PDF)
                                        </button>
                                    </div>
                                </div>

                            <!-- Status: PENDING -->
                            @elseif($donation->isPending())
                                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-amber-200">
                                    <div class="flex flex-wrap items-center justify-between gap-3 pb-6 border-b border-slate-100">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                                                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-bold text-slate-900">Verification in Progress</h3>
                                                <p class="text-xs text-slate-500">Your donation proof has been received and is awaiting bank verification.</p>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                            Pending Verification
                                        </span>
                                    </div>

                                    <div class="p-4 bg-amber-50 rounded-xl border border-amber-200 my-6 text-xs text-amber-800 space-y-1">
                                        <p class="font-semibold">Reconciling with Bank Statement...</p>
                                        <p>Our volunteer finance team reconciles donations manually against bank credit records. This typically takes <strong>2 to 4 hours</strong> during working hours.</p>
                                    </div>

                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                            <span class="text-[11px] font-semibold text-slate-400 uppercase block">Donor Name</span>
                                            <span class="text-sm font-bold text-slate-900 block truncate">{{ $donation->donor_name }}</span>
                                        </div>
                                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                            <span class="text-[11px] font-semibold text-slate-400 uppercase block">Amount</span>
                                            <span class="text-sm font-bold text-slate-900 block">₹{{ number_format($donation->amount, 2) }}</span>
                                        </div>
                                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                            <span class="text-[11px] font-semibold text-slate-400 uppercase block">UTR / Ref No.</span>
                                            <span class="text-xs font-mono font-bold text-slate-800 block truncate">{{ $donation->utr_number }}</span>
                                        </div>
                                    </div>
                                </div>

                            <!-- Status: REJECTED -->
                            @elseif($donation->isRejected())
                                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-rose-200">
                                    <div class="flex flex-wrap items-center justify-between gap-3 pb-6 border-b border-slate-100">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-bold text-rose-900">Verification Unsuccessful</h3>
                                                <p class="text-xs text-slate-500">We could not reconcile this donation with our bank records.</p>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                                            Rejected
                                        </span>
                                    </div>

                                    <div class="p-4 bg-rose-50 rounded-xl border border-rose-200 my-6">
                                        <span class="text-xs font-bold uppercase tracking-wider text-rose-800 block mb-1">Reason / Remarks:</span>
                                        <p class="text-sm text-rose-700">{{ $donation->admin_remarks ?? 'Transaction not found in bank statement or UTR mismatch.' }}</p>
                                    </div>

                                    <p class="text-xs text-slate-500">
                                        If money was debited from your account, please reach out to our team at
                                        <a href="mailto:{{ setting('contact_email') }}" class="font-semibold text-slate-700 underline">{{ setting('contact_email', 'contact@kashiseva.org') }}</a>
                                        with your bank debit advice.
                                    </p>
                                </div>
                            @endif

                        @endforeach
                    </div>
                @else
                    <!-- No Results Found -->
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200 text-center space-y-4">
                        <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">No Donations Found</h3>
                            <p class="text-sm text-slate-500 max-w-md mx-auto mt-1">
                                We could not find any transaction matching <span class="font-mono font-semibold text-slate-800">"{{ $query }}"</span>. Please check for typos in the 12-digit UTR number or enter your registered phone number.
                            </p>
                        </div>
                        <div class="pt-2 flex justify-center gap-3">
                            <a href="{{ route('donate.index') }}" class="px-5 py-2.5 rounded-xl font-semibold text-xs text-white bg-emerald-600 hover:bg-emerald-700 transition">
                                Make a Donation
                            </a>
                            <a href="{{ route('donation.status') }}" class="px-5 py-2.5 rounded-xl font-semibold text-xs text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                                Clear Search
                            </a>
                        </div>
                    </div>
                @endif
            @endif

        </div>

        <!-- Right Column: Sidebar (Impact & Support) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Your Impact Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 space-y-4">
                <h3 class="text-base font-bold text-slate-900 pb-2 border-b border-slate-100">Your Direct Impact</h3>

                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900">Child Education</h4>
                            <p class="text-[11px] text-slate-500">Helps provide notebooks, uniforms and tuition support.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900">Medical Assistance</h4>
                            <p class="text-[11px] text-slate-500">Funds emergency surgery, dialysis and essential medicines.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900">Food & Nutrition</h4>
                            <p class="text-[11px] text-slate-500">Provides fresh meals and winter ration kits.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Need Help? Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Need Assistance?</h4>
                        <p class="text-xs text-slate-500">Have questions about your donation?</p>
                    </div>
                </div>
                <p class="text-xs text-slate-600 mb-4">
                    If you are facing any difficulty verifying your payment or downloading your receipt, reach out to our donor care team directly.
                </p>
                @if(setting('whatsapp_number'))
                    <a href="https://wa.me/{{ setting('whatsapp_number') }}?text=Hello,%20I%20need%20help%20checking%20my%20donation%20status." target="_blank" class="w-full py-2.5 px-4 rounded-xl border border-slate-200 hover:border-emerald-500 text-slate-700 font-semibold text-xs transition flex items-center justify-center gap-2 mb-2">
                        <span>Chat on WhatsApp</span>
                    </a>
                @endif
                <a href="mailto:{{ setting('contact_email', 'contact@kashiseva.org') }}" class="w-full py-2.5 px-4 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-700 font-semibold text-xs transition flex items-center justify-center gap-2">
                    <span>Email Support</span>
                </a>
            </div>

            <!-- Important Information Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Important Information</h4>
                <ol class="text-xs text-slate-600 space-y-2 list-decimal list-inside">
                    <li>It may take a few minutes to hours to update your status after submission.</li>
                    <li>Please enter the correct 12-digit UTR or transaction ID.</li>
                    <li>If you donated via bank transfer, the status will update after bank clearance.</li>
                    <li>All verified donations will receive an automated 80G tax receipt.</li>
                </ol>
            </div>
        </div>

    </div>
</div>
@endsection
