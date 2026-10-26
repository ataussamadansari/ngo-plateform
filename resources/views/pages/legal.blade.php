@extends('layouts.base')

@section('title', 'Policy & Legal - Privacy, Terms & Compliance | ' . setting('ngo_name', 'Hope Foundation'))

@section('content')
<div x-data="{ activeTab: '{{ $initialTab ?? 'privacy' }}' }">

    <!-- 1. Flagship Hero Section -->
    <section class="relative bg-gradient-to-b from-[#03150e] via-[#052117] to-[#041a12] text-white pt-16 pb-24 sm:pt-20 sm:pb-32 overflow-hidden print:hidden">
        <!-- Ambient Glow & Background Image Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070&auto=format&fit=crop" 
                 alt="Legal & Transparency" 
                 class="w-full h-full object-cover opacity-15 mix-blend-luminosity filter blur-[0.5px]">
            <!-- <div class="absolute inset-0 bg-gradient-to-t from-[#041a12] via-[#052117]/90 to-[#03150e]/95"></div>
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute top-1/2 -right-32 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div> -->
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-white/10 pb-10">
                <div>
                    <!-- Subtitle / Breadcrumbs -->
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 mb-3 tracking-wider uppercase">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Privacy Policy & Terms
                    </span>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight">
                        Your Trust Matters<br class="hidden sm:inline"> We Value Your Privacy
                    </h1>
                    <p class="mt-2 text-sm sm:text-base text-emerald-300/90 font-medium">
                        We are committed to protecting your personal information and ensuring complete transparency in everything we do.
                    </p>
                </div>

                <!-- Right Visual Accent -->
                <div class="inline-flex items-center gap-3 bg-white/5 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/10 self-start md:self-end">
                    <div class="w-10 h-10 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-wider text-emerald-400">Governance & Trust</span>
                        <span class="text-sm font-extrabold text-white">Stronger Communities 🌿</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20 space-y-12">

        <!-- 2. Top Trust Guarantee Badges (4 Cards) matching Mockup -->
        <section class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 print:hidden">
            <!-- 1. Your Data is Safe -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div>
                    <span class="text-xs sm:text-sm font-bold text-slate-900 block">Your Data is Safe</span>
                    <span class="text-[11px] text-slate-500 block">We follow strict security practices</span>
                </div>
            </div>

            <!-- 2. Used Only for Genuine Purposes -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <div>
                    <span class="text-xs sm:text-sm font-bold text-slate-900 block">Genuine Purposes</span>
                    <span class="text-[11px] text-slate-500 block">Directly tied to verified relief</span>
                </div>
            </div>

            <!-- 3. Transparent Practices -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                </div>
                <div>
                    <span class="text-xs sm:text-sm font-bold text-slate-900 block">Transparent Practices</span>
                    <span class="text-[11px] text-slate-500 block">Open public bank reconciliation</span>
                </div>
            </div>

            <!-- 4. Your Trust Drives Change -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <span class="text-xs sm:text-sm font-bold text-slate-900 block">Trust Drives Change</span>
                    <span class="text-[11px] text-slate-500 block">Together for a better tomorrow</span>
                </div>
            </div>
        </section>

        <!-- 3. Main Layout: Sidebar Navigation + Policy Content Area -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">

            <!-- Left: Sidebar with 10 Tabs (Sticky on Desktop) -->
            <aside class="lg:col-span-4 space-y-6 print:hidden">
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest px-3 block mb-3">
                        Policy & Legal
                    </span>

                    <nav class="space-y-1">
                        <!-- 1. Privacy Policy -->
                        <button type="button" @click="activeTab = 'privacy'"
                                :class="activeTab === 'privacy' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600' : 'text-slate-600 hover:bg-slate-50 font-medium'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs sm:text-sm transition text-left">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                Privacy Policy
                            </span>
                            <span class="text-slate-400 text-xs">&rarr;</span>
                        </button>

                        <!-- 2. Terms & Conditions -->
                        <button type="button" @click="activeTab = 'terms'"
                                :class="activeTab === 'terms' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600' : 'text-slate-600 hover:bg-slate-50 font-medium'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs sm:text-sm transition text-left">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                Terms & Conditions
                            </span>
                            <span class="text-slate-400 text-xs">&rarr;</span>
                        </button>

                        <!-- 3. Donation Terms -->
                        <button type="button" @click="activeTab = 'donations'"
                                :class="activeTab === 'donations' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600' : 'text-slate-600 hover:bg-slate-50 font-medium'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs sm:text-sm transition text-left">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                Donation Terms & 80G
                            </span>
                            <span class="text-slate-400 text-xs">&rarr;</span>
                        </button>

                        <!-- 4. Volunteer Terms -->
                        <button type="button" @click="activeTab = 'volunteers'"
                                :class="activeTab === 'volunteers' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600' : 'text-slate-600 hover:bg-slate-50 font-medium'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs sm:text-sm transition text-left">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                Volunteer Terms
                            </span>
                            <span class="text-slate-400 text-xs">&rarr;</span>
                        </button>

                        <!-- 5. Refund & Cancellation -->
                        <button type="button" @click="activeTab = 'refunds'"
                                :class="activeTab === 'refunds' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600' : 'text-slate-600 hover:bg-slate-50 font-medium'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs sm:text-sm transition text-left">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                                Refund & Cancellation
                            </span>
                            <span class="text-slate-400 text-xs">&rarr;</span>
                        </button>

                        <!-- 6. Cookies Policy -->
                        <button type="button" @click="activeTab = 'cookies'"
                                :class="activeTab === 'cookies' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600' : 'text-slate-600 hover:bg-slate-50 font-medium'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs sm:text-sm transition text-left">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="8" cy="9" r="1"/><circle cx="15" cy="10" r="1"/><circle cx="11" cy="15" r="1.5"/></svg>
                                Cookies Policy
                            </span>
                            <span class="text-slate-400 text-xs">&rarr;</span>
                        </button>

                        <!-- 7. Data Security -->
                        <button type="button" @click="activeTab = 'security'"
                                :class="activeTab === 'security' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600' : 'text-slate-600 hover:bg-slate-50 font-medium'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs sm:text-sm transition text-left">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Data Security
                            </span>
                            <span class="text-slate-400 text-xs">&rarr;</span>
                        </button>

                        <!-- 8. Third-Party Services -->
                        <button type="button" @click="activeTab = 'third_party'"
                                :class="activeTab === 'third_party' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600' : 'text-slate-600 hover:bg-slate-50 font-medium'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs sm:text-sm transition text-left">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                Third-Party Services
                            </span>
                            <span class="text-slate-400 text-xs">&rarr;</span>
                        </button>

                        <!-- 9. Disclaimer -->
                        <button type="button" @click="activeTab = 'disclaimer'"
                                :class="activeTab === 'disclaimer' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600' : 'text-slate-600 hover:bg-slate-50 font-medium'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs sm:text-sm transition text-left">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                Disclaimer
                            </span>
                            <span class="text-slate-400 text-xs">&rarr;</span>
                        </button>

                        <!-- 10. Legal Compliance -->
                        <button type="button" @click="activeTab = 'compliance'"
                                :class="activeTab === 'compliance' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600' : 'text-slate-600 hover:bg-slate-50 font-medium'"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs sm:text-sm transition text-left">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"/></svg>
                                Legal Compliance
                            </span>
                            <span class="text-slate-400 text-xs">&rarr;</span>
                        </button>
                    </nav>
                </div>

                <!-- Have any questions? Card -->
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-3xl p-6 border border-emerald-100/90 shadow-2xs space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold">
                        ?
                    </div>
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-sm">Have any questions?</h4>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            Need specific compliance documentation, Form 10BE filing certificates, or donor verification details?
                        </p>
                    </div>
                    <div class="pt-2">
                        <a href="{{ route('contact.index') }}" 
                           class="inline-flex items-center justify-center w-full px-4 py-2.5 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition">
                            Contact Support &rarr;
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Right: Content Area -->
            <main class="lg:col-span-8 bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/90 shadow-sm space-y-8">

                <!-- Header Strip with Print Action -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight"
                            x-text="activeTab === 'privacy' ? 'Privacy Policy' :
                                    activeTab === 'terms' ? 'Terms & Conditions' :
                                    activeTab === 'donations' ? 'Donation Terms & 80G Tax Exemption' :
                                    activeTab === 'volunteers' ? 'Volunteer Code of Conduct & Terms' :
                                    activeTab === 'refunds' ? 'Refund & Cancellation Policy' :
                                    activeTab === 'cookies' ? 'Cookies & Storage Policy' :
                                    activeTab === 'security' ? 'Data Security & Storage Protocols' :
                                    activeTab === 'third_party' ? 'Third-Party Services & Payment Verifications' :
                                    activeTab === 'disclaimer' ? 'Legal & Financial Disclaimer' : 'Statutory & Legal Compliance'">
                            Privacy Policy
                        </h2>
                        <span class="text-xs font-semibold text-slate-400 block mt-1">Last Updated: 15 October 2025</span>
                    </div>

                    <button type="button" onclick="window.print()" 
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold text-xs transition shrink-0 print:hidden">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                        <span>Print Policy</span>
                    </button>
                </div>

                <!-- TAB 1: PRIVACY POLICY -->
                <div x-show="activeTab === 'privacy'" class="space-y-8 text-slate-700 leading-relaxed text-sm">
                    <!-- 1. Introduction -->
                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                            <span class="text-emerald-700 font-black">1.</span> Introduction
                        </h3>
                        <p>
                            {{ setting('ngo_name', 'Hope Foundation') }} is dedicated to maintaining the highest ethical and regulatory standards of non-profit governance. This Privacy Policy outlines how our organization collects, handles, stores, and protects donor and volunteer personal information across our website and public verification portals.
                        </p>
                    </div>

                    <!-- 2. Information We Collect (4 Cards) matching Mockup -->
                    <div class="space-y-4">
                        <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                            <span class="text-emerald-700 font-black">2.</span> Information We Collect
                        </h3>
                        <p class="text-xs text-slate-500">We collect only necessary information required for statutory verification and impact communication:</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Personal Information -->
                            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200/80 flex items-start gap-3.5">
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-xs sm:text-sm">Personal Information</h4>
                                    <p class="text-xs text-slate-500 mt-1">Full name, email address, mobile number, PAN (for Section 80G tax receipt), and residential address.</p>
                                </div>
                            </div>

                            <!-- Payment Information -->
                            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200/80 flex items-start gap-3.5">
                                <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-xs sm:text-sm">Payment Information</h4>
                                    <p class="text-xs text-slate-500 mt-1">UTR / Bank reference number and payment screenshots for manual reconciliation. No debit/credit card pins are stored.</p>
                                </div>
                            </div>

                            <!-- Usage Information -->
                            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200/80 flex items-start gap-3.5">
                                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-xs sm:text-sm">Usage Information</h4>
                                    <p class="text-xs text-slate-500 mt-1">IP address, browser type, request timestamps, and rate-limiting security identifiers to prevent form spam.</p>
                                </div>
                            </div>

                            <!-- Volunteering & Event Information -->
                            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200/80 flex items-start gap-3.5">
                                <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-xs sm:text-sm">Volunteer & Event Information</h4>
                                    <p class="text-xs text-slate-500 mt-1">Application bio, areas of interest, emergency phone, event attendance, and optional identity proof documents.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. How We Use Your Information (Checklist) -->
                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                            <span class="text-emerald-700 font-black">3.</span> How We Use Your Information
                        </h3>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-slate-600">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>To manually verify donor bank transfer UTR submissions against organizational bank statements.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>To issue compliant Section 80G digital donation receipts containing official signatures and registration identifiers.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>To synchronize public transparency ledger counters and verified donor wall recognitions (with anonymous opt-out).</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>To dispatch volunteer deployment alerts, health camp schedules, and community relief mobilization calls.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>To fulfill statutory compliance obligations with the Income Tax Department (Form 10BD / 10BE filings).</span>
                            </li>
                        </ul>
                    </div>

                    <!-- 4. Data Sharing and Disclosure -->
                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                            <span class="text-emerald-700 font-black">4.</span> Data Sharing & Zero-Commercialization Guarantee
                        </h3>
                        <p>
                            <strong>We never sell, rent, monetize, or trade donor or volunteer personal information.</strong> Information is shared solely under mandatory statutory circumstances:
                        </p>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2 text-xs">
                            <p>• <strong>Statutory Regulatory Bodies:</strong> Reporting PAN details to the Income Tax Department for annual 80G donor statements.</p>
                            <p>• <strong>Direct Relief Logistics:</strong> Operational volunteer coordinates shared strictly with verified local field coordinators for relief deployment.</p>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: TERMS & CONDITIONS -->
                <div x-show="activeTab === 'terms'" class="space-y-6 text-slate-700 leading-relaxed text-sm" style="display: none;">
                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">1. Acceptance of Terms</h3>
                        <p>
                            By accessing or using the {{ setting('ngo_name', 'Hope Foundation') }} platform, you agree to comply with and be bound by these terms. If you do not agree to these terms, please refrain from using our online services.
                        </p>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">2. Fee-Free Manual Donation Protocol</h3>
                        <p>
                            All donations made on this website occur via direct UPI QR scanning or NEFT/IMPS/RTGS bank transfers directly to our non-profit bank account. We do not use intermediary private payment gateways that charge transaction fees. Donors are responsible for submitting accurate UTR reference numbers to facilitate bank verification.
                        </p>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">3. Integrity of Proof Submissions</h3>
                        <p>
                            Submitting fabricated, duplicate, or fraudulent UTR numbers or screenshots is strictly prohibited and constitutes an offence under Indian cyber and criminal laws. Fraudulent submissions will result in immediate IP banning and reporting to law enforcement.
                        </p>
                    </div>
                </div>

                <!-- TAB 3: DONATION TERMS & 80G -->
                <div x-show="activeTab === 'donations'" class="space-y-6 text-slate-700 leading-relaxed text-sm" style="display: none;">
                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">1. 80G Tax Exemption Eligibility</h3>
                        <p>
                            {{ setting('ngo_name', 'Hope Foundation') }} is registered under Section 80G of the Income Tax Act, 1961 (Registration No: <span class="font-mono font-bold text-emerald-800">{{ setting('80g_reg_number', 'AAATH1234AF') }}</span>). Donors who are Indian tax residents are eligible for a 50% tax deduction on eligible voluntary contributions.
                        </p>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">2. PAN Mandatory for Tax Receipts</h3>
                        <p>
                            As per Government of India CBDT guidelines, a valid 10-digit Permanent Account Number (PAN) is required to issue Form 10BE compliant tax exemption certificates. If you choose not to provide a PAN, a standard contribution receipt will be issued without 80G tax benefit claimability.
                        </p>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">3. Verification Timelines</h3>
                        <p>
                            Because all donations are verified directly against our physical bank statement by our accounts team, verification typically concludes within 24 to 48 business hours. Donors can check verification status at any time via our <a href="{{ route('donation.status') }}" class="text-emerald-700 font-bold hover:underline">Track Donation Status</a> portal.
                        </p>
                    </div>
                </div>

                <!-- TAB 4: VOLUNTEER TERMS -->
                <div x-show="activeTab === 'volunteers'" class="space-y-6 text-slate-700 leading-relaxed text-sm" style="display: none;">
                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">1. Voluntary Service</h3>
                        <p>
                            Volunteering with {{ setting('ngo_name', 'Hope Foundation') }} is an honorary, uncompensated humanitarian service. Volunteers commit their time, skills, and energy without financial remuneration or employment guarantees.
                        </p>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">2. Code of Conduct & Dignity</h3>
                        <p>
                            Volunteers must treat every community member, patient, and beneficiary with utmost dignity, empathy, and respect. Any discrimination based on caste, religion, gender, or socioeconomic status is strictly grounds for immediate disqualification.
                        </p>
                    </div>
                </div>

                <!-- TAB 5: REFUND & CANCELLATION -->
                <div x-show="activeTab === 'refunds'" class="space-y-6 text-slate-700 leading-relaxed text-sm" style="display: none;">
                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">1. Non-Profit Donation Nature</h3>
                        <p>
                            As voluntary philanthropic contributions immediately earmarked for ongoing community relief drives, donations are generally non-refundable once disbursed to vendors or beneficiaries.
                        </p>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">2. Accidental Duplicate Transfers</h3>
                        <p>
                            In the event of an accidental technical duplicate transfer or incorrect transfer amount, donors must notify our administrative team at <a href="mailto:{{ setting('contact_email') }}" class="text-emerald-700 font-bold hover:underline">{{ setting('contact_email') }}</a> within 7 calendar days with bank transaction proof. Validated refund claims will be returned directly to the originating bank account within 10 business days.
                        </p>
                    </div>
                </div>

                <!-- TAB 6: COOKIES POLICY -->
                <div x-show="activeTab === 'cookies'" class="space-y-6 text-slate-700 leading-relaxed text-sm" style="display: none;">
                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">1. Essential Cookies Only</h3>
                        <p>
                            We only use strictly essential cookies and local browser storage to manage authentication sessions, remember UI preferences (such as mobile drawer states), and maintain anti-CSRF security tokens. We do not use intrusive third-party commercial ad trackers.
                        </p>
                    </div>
                </div>

                <!-- TAB 7: DATA SECURITY -->
                <div x-show="activeTab === 'security'" class="space-y-6 text-slate-700 leading-relaxed text-sm" style="display: none;">
                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">1. Encryption & Safeguards</h3>
                        <p>
                            All web traffic is transmitted over 256-bit TLS/SSL encryption. Database records are secured in production environments with access control protocols restricted exclusively to authorized administrators.
                        </p>
                    </div>
                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">2. Zero Gateway Attack Surface</h3>
                        <p>
                            By utilizing direct bank UPI and account transfers, we eliminate the need to collect or store card numbers, CVVs, or online banking passwords on our servers, eliminating a major attack vector for donor payment compromise.
                        </p>
                    </div>
                </div>

                <!-- TAB 8: THIRD-PARTY SERVICES -->
                <div x-show="activeTab === 'third_party'" class="space-y-6 text-slate-700 leading-relaxed text-sm" style="display: none;">
                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">1. External Services</h3>
                        <p>
                            We may utilize trusted third-party providers for transactional email delivery (SMTP) and interactive mapping (Google Maps). These providers are legally bound to uphold data confidentiality and cannot utilize donor data for independent advertising.
                        </p>
                    </div>
                </div>

                <!-- TAB 9: DISCLAIMER -->
                <div x-show="activeTab === 'disclaimer'" class="space-y-6 text-slate-700 leading-relaxed text-sm" style="display: none;">
                    <div class="space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900">1. General Information</h3>
                        <p>
                            Information published on this website regarding ongoing relief drives, medical camps, and community projects is provided in good faith. While we ensure all financial metrics on our transparency ledger reflect verified receipts, estimates on beneficiary reach may vary based on terrain and seasonal realities.
                        </p>
                    </div>
                </div>

                <!-- TAB 10: LEGAL COMPLIANCE -->
                <div x-show="activeTab === 'compliance'" class="space-y-6 text-slate-700 leading-relaxed text-sm" style="display: none;">
                    <div class="space-y-4">
                        <h3 class="text-base font-extrabold text-slate-900">1. Statutory Accreditations Summary</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                                <span class="text-slate-400 block">Trust Registration</span>
                                <span class="font-mono font-bold text-slate-900">{{ setting('ngo_reg_number', 'UP/2024/0045891') }}</span>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                                <span class="text-slate-400 block">Section 80G Registration</span>
                                <span class="font-mono font-bold text-emerald-700">{{ setting('80g_reg_number', 'AAATH1234AF') }}</span>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                                <span class="text-slate-400 block">Section 12A Registration</span>
                                <span class="font-mono font-bold text-slate-900">{{ setting('12a_reg_number', 'AAATH1234A') }}</span>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                                <span class="text-slate-400 block">FCRA Registration</span>
                                <span class="font-mono font-bold text-slate-900">{{ setting('fcra_number', '123456789') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </section>

    </div>
</div>
@endsection
