@extends('layouts.base')

@section('title', 'Make a Donation - Support Our Mission')

@section('content')
<!-- Hero Header -->
<div class="relative bg-slate-900 text-white py-12 md:py-16 overflow-hidden">
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#16a34a_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="flex items-center text-xs sm:text-sm text-slate-400 mb-4 gap-2">
            <a href="{{ url('/') }}" class="hover:text-white transition">Home</a>
            <span>&rsaquo;</span>
            <span class="text-emerald-400 font-medium">Donate</span>
        </nav>

        <div class="max-w-3xl">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-white mb-3">
                Make a Donation
            </h1>
            <p class="text-base sm:text-lg text-slate-300">
                Your support creates real change in the lives of underprivileged communities. Every contribution is verified with complete transparency.
            </p>
        </div>

        <!-- Trust Badges -->
        <div class="mt-6 flex flex-wrap gap-2 sm:gap-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                100% Transparent
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                80G Tax Benefit
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Secure & Verified
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Real Impact
            </span>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <!-- Flash Success Message -->
    @if(session('success'))
        <div class="mb-8 rounded-2xl bg-emerald-50 border border-emerald-200 p-6 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-emerald-900">Donation Submitted Successfully!</h3>
                    <p class="text-sm text-emerald-700 mt-1">{{ session('success') }}</p>
                    @if(session('submitted_utr'))
                        <div class="mt-2 inline-flex items-center gap-2 px-3 py-1 bg-white rounded-lg border border-emerald-300 text-xs font-mono font-bold text-emerald-800">
                            UTR: {{ session('submitted_utr') }}
                        </div>
                    @endif
                </div>
            </div>
            @if(session('submitted_utr'))
                <a href="{{ route('donation.status', ['query' => session('submitted_utr')]) }}" class="shrink-0 px-5 py-2.5 rounded-xl font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition">
                    Track Verification Status &rarr;
                </a>
            @endif
        </div>
    @endif

    <!-- Validation Errors Notice -->
    @if($errors->any())
        <div class="mb-8 rounded-2xl bg-rose-50 border border-rose-200 p-6 shadow-sm">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div>
                    <h4 class="text-base font-bold text-rose-900">Please correct the following errors before submitting:</h4>
                    <ul class="list-disc list-inside text-sm text-rose-700 mt-2 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Left Column: Choose Payment Method (Step 1) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-7 h-7 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center">1</span>
                    <h2 class="text-xl font-bold text-slate-900">Choose Payment Method</h2>
                </div>

                <!-- Payment Method Tabs -->
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <button type="button" id="tab-upi-btn" onclick="switchPaymentTab('upi')" class="p-3.5 rounded-xl border-2 border-emerald-600 bg-emerald-50 text-left transition flex flex-col justify-between">
                        <div class="flex items-center gap-2 text-emerald-700 font-bold text-sm">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            UPI Payment
                        </div>
                        <span class="text-xs text-slate-500 mt-1 block">Scan QR from any UPI app</span>
                    </button>

                    <button type="button" id="tab-bank-btn" onclick="switchPaymentTab('bank')" class="p-3.5 rounded-xl border-2 border-slate-200 hover:border-slate-300 bg-white text-left transition flex flex-col justify-between">
                        <div class="flex items-center gap-2 text-slate-700 font-bold text-sm">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                            Bank Transfer
                        </div>
                        <span class="text-xs text-slate-500 mt-1 block">NEFT / RTGS / IMPS</span>
                    </button>
                </div>

                <!-- UPI Tab Panel -->
                <div id="panel-upi" class="space-y-4">
                    <div class="bg-slate-50 rounded-xl p-5 border border-slate-200 text-center">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-2">Scan & Pay via UPI</span>
                        <div class="inline-block p-2 bg-white rounded-xl shadow-xs border border-slate-200 mb-3">
                            @if($upiMethod && $upiMethod->qr_image_path)
                                <img src="{{ asset('storage/' . $upiMethod->qr_image_path) }}" alt="UPI QR Code" class="w-48 h-48 mx-auto object-contain">
                            @else
                                <div class="w-48 h-48 bg-slate-100 flex items-center justify-center text-slate-400 text-xs">QR Code</div>
                            @endif
                        </div>

                        <p class="text-xs text-slate-500 mb-3">Use any UPI app like Google Pay, PhonePe, Paytm, BHIM</p>

                        <!-- Copyable UPI ID -->
                        <div class="flex items-center justify-between p-2.5 bg-white rounded-lg border border-slate-200">
                            <span class="font-mono text-sm font-semibold text-slate-800" id="upi-id-text">{{ $upiMethod->upi_id ?? 'kashiseva@upi' }}</span>
                            <button type="button" onclick="copyToClipboard('{{ $upiMethod->upi_id ?? 'kashiseva@upi' }}', this)" class="text-xs px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded font-medium transition flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span>Copy</span>
                            </button>
                        </div>
                    </div>

                    <!-- Supported UPI Badges -->
                    <div class="flex items-center justify-center gap-4 text-xs font-semibold text-slate-400 py-1">
                        <span>GPay</span>
                        <span>&bull;</span>
                        <span>PhonePe</span>
                        <span>&bull;</span>
                        <span>Paytm</span>
                        <span>&bull;</span>
                        <span>BHIM</span>
                    </div>

                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 flex items-start gap-2">
                        <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>After completing the payment on your UPI app, please note the <strong>12-digit UTR / Reference Number</strong> and take a screenshot of the confirmation.</span>
                    </div>
                </div>

                <!-- Bank Transfer Tab Panel -->
                <div id="panel-bank" class="space-y-4 hidden">
                    <div class="bg-slate-50 rounded-xl p-5 border border-slate-200 space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                            <span class="text-xs font-semibold text-slate-500 uppercase">Account Details</span>
                            <button type="button" onclick="copyAllBankDetails()" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Copy All</button>
                        </div>

                        <div class="flex items-center justify-between text-xs sm:text-sm">
                            <span class="text-slate-500">Account Name</span>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-slate-900" id="bank-holder">{{ $bankMethod->account_holder_name ?? setting('ngo_name', 'Kashi Seva Foundation') }}</span>
                                <button type="button" onclick="copyToClipboard('{{ $bankMethod->account_holder_name ?? setting('ngo_name') }}', this)" class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs sm:text-sm">
                            <span class="text-slate-500">Bank Name</span>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-slate-900" id="bank-name">{{ $bankMethod->bank_name ?? 'State Bank of India' }}</span>
                                <button type="button" onclick="copyToClipboard('{{ $bankMethod->bank_name ?? 'State Bank of India' }}', this)" class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs sm:text-sm">
                            <span class="text-slate-500">Account Number</span>
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-slate-900" id="bank-acc">{{ $bankMethod->account_number ?? '41238901234' }}</span>
                                <button type="button" onclick="copyToClipboard('{{ $bankMethod->account_number ?? '41238901234' }}', this)" class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs sm:text-sm">
                            <span class="text-slate-500">IFSC Code</span>
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-slate-900" id="bank-ifsc">{{ $bankMethod->ifsc_code ?? 'SBIN0001234' }}</span>
                                <button type="button" onclick="copyToClipboard('{{ $bankMethod->ifsc_code ?? 'SBIN0001234' }}', this)" class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs sm:text-sm">
                            <span class="text-slate-500">Branch</span>
                            <span class="font-medium text-slate-800" id="bank-branch">{{ $bankMethod->branch_name ?? 'Assi Ghat Branch, Varanasi' }}</span>
                        </div>
                    </div>

                    <button type="button" onclick="copyAllBankDetails()" class="w-full py-2.5 px-4 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Copy All Bank Details
                    </button>
                </div>
            </div>

            <!-- Trust Highlights Strip (Mobile / Sidebar) -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 space-y-3">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">100% Direct & Secure</h4>
                        <p class="text-xs text-slate-500">Zero intermediary payment gateway deductions.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">Manual Bank Verification</h4>
                        <p class="text-xs text-slate-500">Every submission is reconciled with official bank statements.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">80G Tax Exemption</h4>
                        <p class="text-xs text-slate-500">Official receipt with 80G reg. issued upon verification.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Submit Payment Details (Step 2) -->
        <div class="lg:col-span-7">
            <form action="{{ route('donate.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
                @csrf
                <input type="hidden" name="payment_mode" id="form_payment_mode" value="upi_qr">

                <!-- Step 2 Header -->
                <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                    <span class="w-7 h-7 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center">2</span>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Submit Payment Details</h2>
                        <p class="text-xs text-slate-500">Enter your contribution details and transaction proof for instant tracking.</p>
                    </div>
                </div>

                <!-- Donation Amount Preset Selector -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Donation Amount (INR) *</label>
                        <span class="text-xs text-slate-500">Every rupee creates direct relief</span>
                    </div>

                    <div class="grid grid-cols-3 sm:grid-cols-6 gap-2 mb-3">
                        @foreach([500, 1000, 2000, 5000, 10000] as $preset)
                            <button type="button" onclick="setPresetAmount({{ $preset }}, this)" class="amount-preset-btn py-2 px-3 rounded-xl border border-slate-200 text-xs sm:text-sm font-bold text-slate-700 hover:border-emerald-600 transition text-center {{ old('amount', '1000') == $preset ? 'border-emerald-600 bg-emerald-50 text-emerald-700' : '' }}">
                                ₹{{ number_format($preset) }}
                            </button>
                        @endforeach
                        <button type="button" onclick="focusCustomAmount(this)" class="amount-preset-btn py-2 px-3 rounded-xl border border-slate-200 text-xs sm:text-sm font-bold text-slate-700 hover:border-emerald-600 transition text-center">
                            Custom
                        </button>
                    </div>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 font-bold">₹</span>
                        <input type="number" name="amount" id="amount_input" min="1" step="any" required value="{{ old('amount', '1000') }}" placeholder="Enter donation amount" class="w-full pl-8 pr-4 py-3 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-base font-bold text-slate-900">
                    </div>

                    <!-- 80G Notification Callout -->
                    <div class="mt-2.5 p-3 rounded-xl bg-emerald-50/80 border border-emerald-200 text-xs text-emerald-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                        <span>Your donation may be eligible for <strong>80G tax deduction</strong>. Provide your PAN below to receive a certified tax receipt.</span>
                    </div>
                </div>

                <!-- Personal Information Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Full Name *</label>
                        <input type="text" name="donor_name" required value="{{ old('donor_name') }}" placeholder="e.g. Ramesh Kumar" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email Address *</label>
                        <input type="email" name="donor_email" required value="{{ old('donor_email') }}" placeholder="e.g. ramesh@example.com" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Mobile / WhatsApp Number *</label>
                        <input type="tel" name="donor_phone" required value="{{ old('donor_phone') }}" placeholder="e.g. +91 9876543210" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            PAN Number <span class="text-xs font-normal text-slate-400">(for 80G Tax Exemption)</span>
                        </label>
                        <input type="text" name="donor_pan" maxlength="10" value="{{ old('donor_pan') }}" placeholder="e.g. ABCDE1234F" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 uppercase text-sm font-mono">
                    </div>
                </div>

                <!-- Campaign Allocation (Optional) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Support Specific Cause / Campaign</label>
                    <select name="campaign_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm bg-white text-slate-800">
                        <option value="">General Relief & Emergency Fund (Where most needed)</option>
                        @foreach($campaigns as $camp)
                            <option value="{{ $camp->id }}" {{ (old('campaign_id', $selectedCampaignId) == $camp->id) ? 'selected' : '' }}>
                                {{ $camp->title }} ({{ $camp->category->name ?? 'General' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Transaction Proof & UTR Number -->
                <div class="grid grid-cols-1 gap-4 pt-2 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            UTR / Transaction Reference Number *
                        </label>
                        <div class="relative">
                            <input type="text" name="utr_number" required value="{{ old('utr_number') }}" placeholder="e.g. 432198765432 (12-digit UPI / IMPS Ref)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 font-mono text-sm">
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Found in your payment app confirmation under "UPI Ref No" or "Transaction ID".</p>
                    </div>

                    <!-- Payment Proof Screenshot Upload Zone -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Payment Confirmation Screenshot *</label>
                        <div id="dropzone" class="relative border-2 border-dashed border-slate-300 hover:border-emerald-600 rounded-2xl p-6 text-center cursor-pointer transition bg-slate-50 hover:bg-emerald-50/20">
                            <input type="file" name="payment_screenshot" id="payment_screenshot" accept="image/jpeg,image/png,image/webp" required onchange="handleScreenshotPreview(this)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                            <!-- Placeholder view -->
                            <div id="upload-placeholder">
                                <svg class="w-10 h-10 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <span class="text-sm font-semibold text-slate-700 block">Click or drag screenshot here</span>
                                <span class="text-xs text-slate-400 mt-1 block">JPG, PNG, or WEBP (Max 2MB)</span>
                            </div>

                            <!-- Live Preview view -->
                            <div id="upload-preview" class="hidden flex flex-col items-center">
                                <img id="preview-image" src="#" alt="Screenshot Preview" class="max-h-40 rounded-lg shadow-sm border border-slate-200 mb-2 object-contain">
                                <span id="preview-filename" class="text-xs font-mono font-medium text-slate-600"></span>
                                <span class="text-xs text-emerald-600 font-semibold mt-1">Click to change image</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Optional Note and Anonymous Flag -->
                <div class="space-y-3 pt-2 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Message of Encouragement (Optional)</label>
                        <textarea name="donor_message" rows="2" placeholder="Write a few words to the volunteers and beneficiaries..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm">{{ old('donor_message') }}</textarea>
                    </div>

                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }} class="mt-0.5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="text-xs text-slate-600">
                            <strong>Make my donation anonymous</strong> on the public transparent supporters list (your receipt will still carry your legal details).
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-4 px-6 rounded-xl font-bold text-base text-white shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 bg-primary hover:opacity-95">
                        <span>Submit Donation</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    <p class="text-center text-xs text-slate-400 mt-3 flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Your information is safe and secure. We never share your data.
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Recent Donors Carousel / Cards -->
    @if($recentDonations && $recentDonations->count() > 0)
        <div class="mt-16 pt-12 border-t border-slate-200">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Recent Donors</h2>
                    <p class="text-xs text-slate-500">Kind hearts creating real impact in the community</p>
                </div>
                <a href="{{ route('donation.status') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Check Status &rarr;</a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
                @foreach($recentDonations as $recent)
                    <div class="p-3.5 rounded-xl border border-slate-200 bg-white shadow-2xs">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-bold text-xs mb-2">
                            {{ $recent->is_anonymous ? 'A' : substr($recent->donor_name, 0, 1) }}
                        </div>
                        <span class="text-xs font-bold text-slate-900 block truncate">
                            {{ $recent->is_anonymous ? 'Anonymous' : $recent->donor_name }}
                        </span>
                        <span class="text-xs font-semibold text-emerald-600 block mt-0.5">
                            ₹{{ number_format($recent->amount) }}
                        </span>
                        <span class="text-[10px] text-slate-400 block mt-0.5">
                            {{ $recent->created_at->diffForHumans() }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function switchPaymentTab(type) {
        const upiBtn = document.getElementById('tab-upi-btn');
        const bankBtn = document.getElementById('tab-bank-btn');
        const upiPanel = document.getElementById('panel-upi');
        const bankPanel = document.getElementById('panel-bank');
        const formMode = document.getElementById('form_payment_mode');

        if (type === 'upi') {
            upiBtn.classList.add('border-emerald-600', 'bg-emerald-50');
            upiBtn.classList.remove('border-slate-200', 'bg-white');
            bankBtn.classList.remove('border-emerald-600', 'bg-emerald-50');
            bankBtn.classList.add('border-slate-200', 'bg-white');

            upiPanel.classList.remove('hidden');
            bankPanel.classList.add('hidden');
            formMode.value = 'upi_qr';
        } else {
            bankBtn.classList.add('border-emerald-600', 'bg-emerald-50');
            bankBtn.classList.remove('border-slate-200', 'bg-white');
            upiBtn.classList.remove('border-emerald-600', 'bg-emerald-50');
            upiBtn.classList.add('border-slate-200', 'bg-white');

            bankPanel.classList.remove('hidden');
            upiPanel.classList.add('hidden');
            formMode.value = 'bank_transfer';
        }
    }

    function setPresetAmount(amount, btn) {
        document.getElementById('amount_input').value = amount;
        document.querySelectorAll('.amount-preset-btn').forEach(b => {
            b.classList.remove('border-emerald-600', 'bg-emerald-50', 'text-emerald-700');
        });
        btn.classList.add('border-emerald-600', 'bg-emerald-50', 'text-emerald-700');
    }

    function focusCustomAmount(btn) {
        document.querySelectorAll('.amount-preset-btn').forEach(b => {
            b.classList.remove('border-emerald-600', 'bg-emerald-50', 'text-emerald-700');
        });
        btn.classList.add('border-emerald-600', 'bg-emerald-50', 'text-emerald-700');
        const input = document.getElementById('amount_input');
        input.focus();
        input.select();
    }

    function copyToClipboard(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<span class="text-emerald-600 font-bold">Copied!</span>';
            setTimeout(() => {
                btn.innerHTML = originalHTML;
            }, 1800);
        });
    }

    function copyAllBankDetails() {
        const holder = document.getElementById('bank-holder').innerText;
        const name = document.getElementById('bank-name').innerText;
        const acc = document.getElementById('bank-acc').innerText;
        const ifsc = document.getElementById('bank-ifsc').innerText;
        const branch = document.getElementById('bank-branch').innerText;

        const allDetails = `Account Name: ${holder}\nBank Name: ${name}\nAccount Number: ${acc}\nIFSC Code: ${ifsc}\nBranch: ${branch}`;

        navigator.clipboard.writeText(allDetails).then(() => {
            alert('Bank details copied to clipboard!');
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
@endpush
@endsection
