@extends('layouts.base')

@section('title', 'About Us - Our Mission, Vision & Accreditations')

@section('content')
<!-- Header Banner -->
<div class="bg-gradient-to-b from-slate-900 to-slate-800 text-white py-14 sm:py-20 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 mb-4">
            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
            About {{ setting('ngo_name', 'Our Organization') }}
        </span>
        <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight max-w-3xl mx-auto leading-tight">
            Serving Humanity with Uncompromising Transparency
        </h1>
        <p class="mt-4 text-sm sm:text-base text-slate-300 max-w-2xl mx-auto leading-relaxed">
            Founded with the belief that non-profit work should be 100% accountable, zero-fee, and open to public audit at every step.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20 space-y-16">

    <!-- Mission & Vision Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Mission -->
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200 shadow-xs relative overflow-hidden group">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xl mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 mb-4">Our Mission</h2>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                {{ setting('about_mission', 'To alleviate suffering, provide immediate emergency healthcare, sponsor education for underprivileged children, and deliver humanitarian disaster relief directly to grassroots communities without intermediaries or deductions.') }}
            </p>
            <div class="mt-6 pt-6 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-emerald-700">
                <span>Direct Field Intervention</span> &bull; <span>Zero Gateway Losses</span>
            </div>
        </div>

        <!-- Vision -->
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200 shadow-xs relative overflow-hidden group">
            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xl mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 mb-4">Our Vision</h2>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                {{ setting('about_vision', 'A society where every vulnerable citizen has access to healthcare and education, and every donor can trace their contribution from bank deposit to ground distribution receipt with complete confidence.') }}
            </p>
            <div class="mt-6 pt-6 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-blue-700">
                <span>Total Public Accountability</span> &bull; <span>Dignified Relief</span>
            </div>
        </div>
    </div>

    <!-- The Founder's Story -->
    <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-3xl p-8 sm:p-14 border border-slate-800 shadow-xl">
        <div class="max-w-3xl">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 block mb-2">Our Origins</span>
            <h2 class="text-2xl sm:text-4xl font-black text-white tracking-tight mb-6">
                The Grassroots Story of {{ setting('ngo_name') }}
            </h2>
            <div class="space-y-4 text-xs sm:text-sm text-slate-300 leading-relaxed">
                <p>
                    {{ setting('about_founder_story', 'Founded in Varanasi by passionate community social workers, our organization started as a small volunteer group delivering food packages and medicines to impoverished ghat dwellers and street children.') }}
                </p>
                <p>
                    Over time, we saw the recurring challenge in India’s philanthropic sector: traditional platforms charged hefty commissions, and donors rarely knew whether their hard-earned money reached actual beneficiaries. We resolved to change this fundamentally.
                </p>
                <p>
                    Today, our operations are 100% manual payment-verified without gateway fees, supported by hundreds of background-checked volunteers and documented by publicly verifiable GST invoices for every single disbursement.
                </p>
            </div>

            <div class="mt-8 pt-8 border-t border-slate-800 grid grid-cols-2 sm:grid-cols-3 gap-6">
                <div>
                    <span class="text-slate-400 text-xs block">Established In</span>
                    <span class="font-bold text-white text-sm sm:text-base">Varanasi, UP</span>
                </div>
                <div>
                    <span class="text-slate-400 text-xs block">Fee Deductions</span>
                    <span class="font-bold text-emerald-400 text-sm sm:text-base">0% Commission</span>
                </div>
                <div>
                    <span class="text-slate-400 text-xs block">Audit Method</span>
                    <span class="font-bold text-white text-sm sm:text-base">Bank Reconciled</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Official Legal Accreditations & Credentials Strip -->
    <section>
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider block mb-1">Government Compliance</span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Legal Accreditations & Registrations
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Fully registered and compliant non-profit organisation under the laws of India.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- 80G Certificate -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-100 text-emerald-800">
                            Income Tax Exemption
                        </span>
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Section 80G Approval</h3>
                    <p class="text-xs text-slate-500 mb-4">
                        50% tax deduction on donations for Indian individual and corporate taxpayers.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100">
                    <span class="text-[11px] text-slate-400 block">Registration Number</span>
                    <span class="font-mono font-bold text-slate-900 text-sm">{{ setting('80g_reg_number', 'AABTK1234FF20241') }}</span>
                </div>
            </div>

            <!-- 12A Registration -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-blue-100 text-blue-800">
                            Charitable Trust Status
                        </span>
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Section 12A Registration</h3>
                    <p class="text-xs text-slate-500 mb-4">
                        Certified tax-exempt non-profit trust status under the Income Tax Act, 1961.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100">
                    <span class="text-[11px] text-slate-400 block">Registration Number</span>
                    <span class="font-mono font-bold text-slate-900 text-sm">{{ setting('12a_reg_number', 'AABTK1234FE20241') }}</span>
                </div>
            </div>

            <!-- NGO Darpan -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-amber-100 text-amber-800">
                            NITI Aayog Portal
                        </span>
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">NGO Darpan Registration</h3>
                    <p class="text-xs text-slate-500 mb-4">
                        Official registration with NITI Aayog, Government of India NGO portal.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100">
                    <span class="text-[11px] text-slate-400 block">Darpan Unique ID</span>
                    <span class="font-mono font-bold text-slate-900 text-sm">{{ setting('ngo_darpan_id', 'UP/2024/0091823') }}</span>
                </div>
            </div>

            <!-- Society Registration -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-purple-100 text-purple-800">
                            State Registry
                        </span>
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Societies Registration Act</h3>
                    <p class="text-xs text-slate-500 mb-4">
                        Registered with Registrar of Societies, Uttar Pradesh.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100">
                    <span class="text-[11px] text-slate-400 block">Registration Number</span>
                    <span class="font-mono font-bold text-slate-900 text-sm">{{ setting('ngo_reg_number', 'UP/2024/0045891') }}</span>
                </div>
            </div>

            <!-- PAN -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 text-slate-800">
                            Permanent Account Number
                        </span>
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Entity PAN Card</h3>
                    <p class="text-xs text-slate-500 mb-4">
                        Dedicated non-profit financial entity PAN for audited filings.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100">
                    <span class="text-[11px] text-slate-400 block">PAN Identifier</span>
                    <span class="font-mono font-bold text-slate-900 text-sm">{{ setting('ngo_pan_number', 'AABTK1234F') }}</span>
                </div>
            </div>

            <!-- Authorized Signatory -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-rose-100 text-rose-800">
                            Leadership Trust
                        </span>
                        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Authorized Representative</h3>
                    <p class="text-xs text-slate-500 mb-4">
                        Authorized signatory issuing compliant 80G tax receipts and reports.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100">
                    <span class="text-[11px] text-slate-400 block">Name & Role</span>
                    <span class="font-bold text-slate-900 text-sm">{{ setting('authorized_sign_name', 'R. K. Sharma (President)') }}</span>
                </div>
            </div>

        </div>
    </section>

    <!-- Call to Action Banner -->
    <div class="bg-gradient-to-r from-emerald-800 to-slate-900 rounded-3xl p-8 sm:p-12 text-white flex flex-col sm:flex-row items-center justify-between gap-6">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight mb-1">Support Our Transparent Initiatives</h3>
            <p class="text-xs sm:text-sm text-slate-300">Donate directly without platform fees or apply as a community volunteer.</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('donate.index') }}" class="px-6 py-3 rounded-xl bg-white text-slate-900 font-bold text-xs hover:bg-slate-100 transition shadow-md">
                Donate Now
            </a>
            <a href="{{ route('volunteers.create') }}" class="px-6 py-3 rounded-xl bg-slate-800 text-white font-bold text-xs hover:bg-slate-700 transition border border-slate-700">
                Join Volunteers
            </a>
        </div>
    </div>

</div>
@endsection
