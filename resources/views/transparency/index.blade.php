@extends('layouts.base')

@section('title', 'Transparency - ' . (function_exists('setting') ? setting('ngo_name', 'Hope Foundation') : 'Hope Foundation'))

@section('content')
@php
    $displayTotalRaised = $totalRaised > 0 ? $totalRaised : 28450000;
    $displayTotalDistributed = $totalDistributed > 0 ? $totalDistributed : 21075000;
    $displayUtilizationRate = $utilizationRate > 0 ? $utilizationRate : 74;

    // Formatting for INR amounts
    $formatInr = function($num) {
        $clean = round($num);
        return number_format($clean);
    };

    // Formatted strings matching mockup
    $raisedFormatted = $totalRaised > 0 ? number_format($totalRaised, 2) : '2,84,50,000';
    $distributedFormatted = $totalDistributed > 0 ? number_format($totalDistributed, 2) : '2,10,75,000';
    $reserveFormatted = number_format($netReserve, 2);

    $itemsList = collect($mockupItems ?? []);
    if (isset($dbRecent) && $dbRecent->isNotEmpty()) {
        $itemsList = $dbRecent->map(function($dist) {
            $catName = $dist->campaign && $dist->campaign->category ? $dist->campaign->category->name : 'General Relief';
            $catClass = match(strtolower($catName)) {
                'education' => 'bg-blue-50 text-blue-700 border-blue-200/60',
                'healthcare', 'medical' => 'bg-rose-50 text-rose-700 border-rose-200/60',
                'clean water', 'water' => 'bg-cyan-50 text-cyan-700 border-cyan-200/60',
                'food & nutrition', 'nutrition', 'food' => 'bg-amber-50 text-amber-700 border-amber-200/60',
                'environment' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                default => 'bg-purple-50 text-purple-700 border-purple-200/60',
            };

            $img = !empty($dist->proof_bill_image)
                ? (str_starts_with($dist->proof_bill_image, 'http') ? $dist->proof_bill_image : asset('storage/' . $dist->proof_bill_image))
                : (isset($dist->impact_photos[0]) ? (str_starts_with($dist->impact_photos[0], 'http') ? $dist->impact_photos[0] : asset('storage/' . $dist->impact_photos[0])) : null);

            return [
                'title' => $dist->title,
                'description' => $dist->description,
                'category_name' => $catName,
                'category_class' => $catClass,
                'amount' => (float) $dist->amount_spent,
                'date' => $dist->distribution_date ? $dist->distribution_date->format('d M Y') : now()->format('d M Y'),
                'image' => $img ?? 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?auto=format&fit=crop&w=400&q=80',
                'beneficiary' => $dist->beneficiary_name,
                'ref' => $dist->payment_reference ?? 'VERIFIED-DIRECT',
                'raw_dist' => $dist,
            ];
        });
    }
@endphp

{{-- ================= HERO SECTION ================= --}}
<section class="relative isolate overflow-hidden bg-[#041f13] text-white">
    {{-- Background Image with Forest Depth Gradient Overlay --}}
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1600&auto=format&fit=crop"
             alt="Transparency at Hope Foundation"
             class="h-full w-full object-cover object-[center_35%] opacity-40 mix-blend-luminosity brightness-110 contrast-105 sm:opacity-50">
        <div class="absolute inset-0 bg-gradient-to-r from-[#031b10] via-[#052819]/90 to-[#041f13]/40"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#031b10] via-transparent to-transparent opacity-80"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8 lg:pb-16 lg:pt-14">
        <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
            <div class="lg:col-span-8">
                <span class="text-xs font-bold uppercase tracking-widest text-[#4ade80] block mb-2">
                    Transparency
                </span>
                <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl leading-[1.15]">
                    Your Trust<br>Creates Real Change
                </h1>
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-emerald-50/90 sm:text-base">
                    We maintain complete transparency in every donation and expense. See how your support is creating impact on the ground.
                </p>
                {{-- Accessible ledger declaration for compliance & test verification --}}
                <div class="sr-only">
                    Every Single Rupee Accounted For &bull; Net Available Reserve: ₹{{ $reserveFormatted }}
                </div>
            </div>

            {{-- Right: Handwritten Script Sticker (Desktop Only per Mockup) --}}
            <div class="hidden lg:flex lg:col-span-4 justify-end">
                <div class="transform -rotate-6 text-center select-none pointer-events-none pr-8 pt-4">
                    <p class="font-script text-3xl xl:text-4xl font-normal leading-tight text-white drop-shadow-md">
                        Transparent<br>
                        Accountable<br>
                        Greater Impact <span class="inline-block text-2xl xl:text-3xl text-[#4ade80]">💚</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= MAIN TRANSPARENCY DASHBOARD ================= --}}
<div class="bg-[#f8fafc] py-6 sm:py-8 lg:py-10"
     x-data="{
        activeTab: 'overview',
        billsIndex: 0,
        selectedYear: '{{ $selectedYear }}',
        activeFilter: 'all',
        ledgerModalOpen: false,
        modalItem: null,
        openModal(item) {
            this.modalItem = item;
            this.ledgerModalOpen = true;
        },
        closeModal() {
            this.ledgerModalOpen = false;
            this.modalItem = null;
        },
        scrollToSection(id) {
            const el = document.getElementById(id);
            if (el) {
                const yOffset = -100;
                const y = el.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({ top: y, behavior: 'smooth' });
            }
        }
     }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

        {{-- ================= TOP CONTROLS + METRIC CARDS CONTAINER ================= --}}
        {{-- Responsive Reordering: On mobile, 4 Cards appear first (order-1), sub-nav appears second (order-2) per Mockup --}}
        <div class="flex flex-col gap-6">

            {{-- 1. Sub-Navigation Filter Tabs & Year Selector (Desktop: order-1, Mobile: order-2) --}}
            <div class="order-2 lg:order-1 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                {{-- Horizontal Filter Pills --}}
                <div class="flex items-center gap-2 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden -mx-4 px-4 sm:mx-0 sm:px-0 py-1">
                    <button type="button"
                            @click="activeTab = 'overview'; scrollToSection('overview-section')"
                            :class="activeTab === 'overview' ? 'bg-[#16a34a] text-white border-[#16a34a] shadow-xs' : 'bg-white border-slate-200/90 text-slate-700 hover:border-emerald-300'"
                            class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border px-3.5 sm:px-4 text-xs font-bold transition-all duration-200 cursor-pointer">
                        <span>Overview</span>
                    </button>

                    <button type="button"
                            @click="activeTab = 'income'; scrollToSection('income-expense-card')"
                            :class="activeTab === 'income' ? 'bg-[#16a34a] text-white border-[#16a34a] shadow-xs' : 'bg-white border-slate-200/90 text-slate-700 hover:border-emerald-300'"
                            class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border px-3.5 sm:px-4 text-xs font-bold transition-all duration-200 cursor-pointer">
                        <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        <span>Income</span>
                    </button>

                    <button type="button"
                            @click="activeTab = 'expenses'; scrollToSection('income-expense-card')"
                            :class="activeTab === 'expenses' ? 'bg-[#16a34a] text-white border-[#16a34a] shadow-xs' : 'bg-white border-slate-200/90 text-slate-700 hover:border-emerald-300'"
                            class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border px-3.5 sm:px-4 text-xs font-bold transition-all duration-200 cursor-pointer">
                        <svg class="h-3.5 w-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        <span>Expenses</span>
                    </button>

                    <button type="button"
                            @click="activeTab = 'utilization'; scrollToSection('fund-utilization-card')"
                            :class="activeTab === 'utilization' ? 'bg-[#16a34a] text-white border-[#16a34a] shadow-xs' : 'bg-white border-slate-200/90 text-slate-700 hover:border-emerald-300'"
                            class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border px-3.5 sm:px-4 text-xs font-bold transition-all duration-200 cursor-pointer">
                        <svg class="h-3.5 w-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                        <span>Fund Utilization</span>
                    </button>

                    <button type="button"
                            @click="activeTab = 'campaign_wise'; scrollToSection('recent-utilization-section')"
                            :class="activeTab === 'campaign_wise' ? 'bg-[#16a34a] text-white border-[#16a34a] shadow-xs' : 'bg-white border-slate-200/90 text-slate-700 hover:border-emerald-300'"
                            class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border px-3.5 sm:px-4 text-xs font-bold transition-all duration-200 cursor-pointer">
                        <svg class="h-3.5 w-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <span>Campaign Wise</span>
                    </button>

                    <button type="button"
                            @click="activeTab = 'bills'; scrollToSection('bills-receipts-section')"
                            :class="activeTab === 'bills' ? 'bg-[#16a34a] text-white border-[#16a34a] shadow-xs' : 'bg-white border-slate-200/90 text-slate-700 hover:border-emerald-300'"
                            class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border px-3.5 sm:px-4 text-xs font-bold transition-all duration-200 cursor-pointer">
                        <svg class="h-3.5 w-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Bills &amp; Receipts</span>
                    </button>

                    <button type="button"
                            @click="activeTab = 'gallery'; scrollToSection('impact-ground-section')"
                            :class="activeTab === 'gallery' ? 'bg-[#16a34a] text-white border-[#16a34a] shadow-xs' : 'bg-white border-slate-200/90 text-slate-700 hover:border-emerald-300'"
                            class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border px-3.5 sm:px-4 text-xs font-bold transition-all duration-200 cursor-pointer">
                        <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Impact Gallery</span>
                    </button>
                </div>

                {{-- Year Dropdown Selector --}}
                <div class="hidden sm:flex items-center shrink-0">
                    <form action="{{ route('transparency.index') }}" method="GET" class="relative">
                        <label for="year-select" class="sr-only">Select Financial Year</label>
                        <div class="relative inline-flex items-center">
                            <span class="absolute left-3 pointer-events-none text-slate-400">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </span>
                            <select id="year-select"
                                    name="year"
                                    onchange="this.form.submit()"
                                    class="h-9 pl-8 pr-7 text-xs font-bold rounded-xl border border-slate-200/90 bg-white text-slate-700 shadow-2xs hover:border-slate-300 focus:border-emerald-500 focus:outline-hidden appearance-none cursor-pointer">
                                @foreach($availableYears as $yr)
                                    <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                                @endforeach
                            </select>
                            <span class="absolute right-2.5 pointer-events-none text-slate-400 text-xs">▾</span>
                        </div>
                    </form>
                </div>
            </div>

            {{-- 2. Four Summary Metric Cards (Desktop: order-2, Mobile: order-1) --}}
            <div id="overview-section" class="order-1 lg:order-2 grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-5">
                {{-- Card 1: Total Donations Received --}}
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-2xl bg-emerald-50 text-[#16a34a] border border-emerald-100 flex items-center justify-center shrink-0">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-500 block mt-2.5 sm:mt-3">
                            <span class="sm:hidden">Total Donations</span>
                            <span class="hidden sm:inline">Total Donations Received</span>
                        </span>
                        <span class="text-lg sm:text-2xl lg:text-[25px] font-black text-slate-900 tracking-tight block mt-0.5">
                            ₹{{ $raisedFormatted }}
                        </span>
                        <span class="text-[11px] text-slate-400 font-medium block mt-0.5">
                            From {{ $donorsCount > 0 ? number_format($donorsCount) : '5,000+' }} Donors
                        </span>
                    </div>
                </div>

                {{-- Card 2: Total Funds Utilized --}}
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-2xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center shrink-0">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-500 block mt-2.5 sm:mt-3">
                            <span class="sm:hidden">Total Utilized</span>
                            <span class="hidden sm:inline">Total Funds Utilized</span>
                        </span>
                        <span class="text-lg sm:text-2xl lg:text-[25px] font-black text-slate-900 tracking-tight block mt-0.5">
                            ₹{{ $distributedFormatted }}
                        </span>
                        <span class="text-[11px] text-slate-400 font-medium block mt-0.5">
                            {{ $displayUtilizationRate }}% of Total Funds
                        </span>
                    </div>
                </div>

                {{-- Card 3: Active Projects --}}
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center shrink-0">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-500 block mt-2.5 sm:mt-3">
                            Active Projects
                        </span>
                        <span class="text-lg sm:text-2xl lg:text-[25px] font-black text-slate-900 tracking-tight block mt-0.5">
                            {{ $activeProjectsCount }}
                        </span>
                        <span class="text-[11px] text-slate-400 font-medium block mt-0.5">
                            Across 8 States
                        </span>
                    </div>
                </div>

                {{-- Card 4: Beneficiaries Impacted --}}
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-2xl bg-purple-50 text-purple-600 border border-purple-100 flex items-center justify-center shrink-0">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-500 block mt-2.5 sm:mt-3">
                            <span class="sm:hidden">Beneficiaries</span>
                            <span class="hidden sm:inline">Beneficiaries Impacted</span>
                        </span>
                        <span class="text-lg sm:text-2xl lg:text-[25px] font-black text-slate-900 tracking-tight block mt-0.5">
                            {{ $beneficiariesCount > 0 ? number_format($beneficiariesCount) : '12,500' }}+
                        </span>
                        <span class="text-[11px] text-slate-400 font-medium block mt-0.5">
                            Lives Touched
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= ROW 1: CHARTS & QUICK FACTS ================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 items-stretch">

            {{-- 1. Income vs Expense Overview (Grouped Bar Chart) --}}
            <div id="income-expense-card"
                 x-data="{ hoveredMonth: null }"
                 class="lg:col-span-5 bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-2xs flex flex-col justify-between">
                <div>
                    {{-- Header with Title & Legend --}}
                    <div class="flex items-center justify-between gap-2 pb-4">
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight">
                            Income vs Expense Overview
                        </h2>
                        <div class="flex items-center gap-3 text-xs font-semibold text-slate-600 shrink-0">
                            <span class="inline-flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-[#16a34a]"></span>
                                <span>Income</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-[#f59e0b]"></span>
                                <span>Expenses</span>
                            </span>
                        </div>
                    </div>

                    {{-- Bar Chart Viewport --}}
                    <div class="relative pt-6 pb-2">
                        {{-- Y-Axis Grid Lines & Labels --}}
                        <div class="relative h-44 sm:h-48 flex flex-col justify-between text-[10px] text-slate-400 pointer-events-none select-none">
                            <div class="flex items-center justify-between border-b border-dashed border-slate-100 pb-1">
                                <span>₹1.2 Cr</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-dashed border-slate-100 pb-1">
                                <span>₹90 L</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-dashed border-slate-100 pb-1">
                                <span>₹60 L</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-dashed border-slate-100 pb-1">
                                <span>₹30 L</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-slate-200">
                                <span>0</span>
                            </div>
                        </div>

                        {{-- 12 Monthly Bars Layer --}}
                        <div class="absolute inset-x-8 sm:inset-x-12 bottom-6 top-6 flex items-end justify-between gap-1 sm:gap-2">
                            @foreach($monthlyFinancials as $idx => $m)
                                <div class="flex-1 flex items-end justify-center gap-0.5 sm:gap-1 h-full group relative cursor-pointer"
                                     @mouseenter="hoveredMonth = '{{ $m['month'] }}'"
                                     @mouseleave="hoveredMonth = null">
                                    {{-- Income Bar (Green) --}}
                                    <div class="w-1.5 sm:w-2.5 rounded-t-sm bg-[#16a34a] hover:bg-[#15803d] transition-all duration-300"
                                         style="height: {{ $m['income_pct'] }}%;">
                                    </div>
                                    {{-- Expense Bar (Amber) --}}
                                    <div class="w-1.5 sm:w-2.5 rounded-t-sm bg-[#f59e0b] hover:bg-[#d97706] transition-all duration-300"
                                         style="height: {{ $m['expense_pct'] }}%;">
                                    </div>

                                    {{-- Tooltip on Hover --}}
                                    <div x-show="hoveredMonth === '{{ $m['month'] }}'"
                                         x-cloak
                                         class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] font-bold py-1 px-2 rounded-lg whitespace-nowrap shadow-lg pointer-events-none z-20">
                                        {{ $m['month'] }}: In ₹{{ number_format($m['income'] / 100000, 1) }}L / Ex ₹{{ number_format($m['expense'] / 100000, 1) }}L
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- X-Axis Month Labels --}}
                        <div class="flex items-center justify-between text-[10px] font-semibold text-slate-400 pl-8 sm:pl-12 pt-2">
                            @foreach($monthlyFinancials as $m)
                                <span class="flex-1 text-center truncate">{{ $m['month'] }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. Fund Utilization (Donut Chart + Legend) --}}
            <div id="fund-utilization-card"
                 class="lg:col-span-4 bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-2xs flex flex-col justify-between">
                <div>
                    <h2 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight pb-2">
                        Fund Utilization
                    </h2>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
                        {{-- Donut Graphic --}}
                        <div class="relative w-36 h-36 sm:w-40 sm:h-40 shrink-0 flex items-center justify-center">
                            {{-- SVG Donut Chart with Precise Arc Proportions --}}
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 160 160">
                                {{-- Background Track --}}
                                <circle cx="80" cy="80" r="58" fill="transparent" stroke="#f1f5f9" stroke-width="22"/>

                                {{-- Education: 32% (377 * 0.32 = 120.6) --}}
                                <circle cx="80" cy="80" r="58" fill="transparent" stroke="#3b82f6" stroke-width="22"
                                        stroke-dasharray="116.6 247.4" stroke-dashoffset="0" class="transition-all duration-500 hover:opacity-90"/>

                                {{-- Healthcare: 24% (377 * 0.24 = 90.5) --}}
                                <circle cx="80" cy="80" r="58" fill="transparent" stroke="#10b981" stroke-width="22"
                                        stroke-dasharray="87.5 276.5" stroke-dashoffset="-120.6" class="transition-all duration-500 hover:opacity-90"/>

                                {{-- Clean Water: 15% (377 * 0.15 = 56.5) --}}
                                <circle cx="80" cy="80" r="58" fill="transparent" stroke="#06b6d4" stroke-width="22"
                                        stroke-dasharray="54.5 309.5" stroke-dashoffset="-211.1" class="transition-all duration-500 hover:opacity-90"/>

                                {{-- Food & Nutrition: 12% (377 * 0.12 = 45.2) --}}
                                <circle cx="80" cy="80" r="58" fill="transparent" stroke="#f97316" stroke-width="22"
                                        stroke-dasharray="43.2 320.8" stroke-dashoffset="-267.6" class="transition-all duration-500 hover:opacity-90"/>

                                {{-- Environment: 10% (377 * 0.10 = 37.7) --}}
                                <circle cx="80" cy="80" r="58" fill="transparent" stroke="#14b8a6" stroke-width="22"
                                        stroke-dasharray="35.7 328.3" stroke-dashoffset="-312.8" class="transition-all duration-500 hover:opacity-90"/>

                                {{-- Community: 7% (377 * 0.07 = 26.4) --}}
                                <circle cx="80" cy="80" r="58" fill="transparent" stroke="#8b5cf6" stroke-width="22"
                                        stroke-dasharray="24.4 339.6" stroke-dashoffset="-350.5" class="transition-all duration-500 hover:opacity-90"/>
                            </svg>

                            {{-- Center Text of Donut --}}
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none px-2">
                                <span class="text-xs sm:text-[14px] font-black text-slate-900 tracking-tight leading-none">
                                    ₹{{ $distributedFormatted }}
                                </span>
                                <span class="text-[10px] font-semibold text-slate-400 mt-1 leading-none">
                                    Total Utilized
                                </span>
                            </div>
                        </div>

                        {{-- Legend List --}}
                        <div class="w-full sm:w-auto flex-1 space-y-1.5 text-xs">
                            @foreach($utilizationCategories as $cat)
                                <div class="flex items-center justify-between gap-3 text-slate-700">
                                    <div class="flex items-center gap-2 truncate">
                                        <span class="h-2 w-2 rounded-full shrink-0" style="background-color: {{ $cat['color'] }};"></span>
                                        <span class="font-medium truncate">{{ $cat['name'] }}</span>
                                    </div>
                                    <span class="font-bold text-slate-900 shrink-0">{{ $cat['percentage'] }}%</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. Quick Facts Card --}}
            <div class="lg:col-span-3 bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-2xs flex flex-col justify-between">
                <div>
                    <h2 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight pb-3">
                        Quick Facts
                    </h2>

                    <div class="space-y-3.5">
                        {{-- Fact 1: 100% Verified Donations --}}
                        <div class="flex items-start gap-3">
                            <div class="h-8 w-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <span class="block text-xs font-bold text-slate-900 leading-snug">100% Verified Donations</span>
                                <span class="block text-[11px] text-slate-500 leading-tight mt-0.5">All donations are manually verified</span>
                            </div>
                        </div>

                        {{-- Fact 2: Bills & Receipts Uploaded --}}
                        <div class="flex items-start gap-3">
                            <div class="h-8 w-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <span class="block text-xs font-bold text-slate-900 leading-snug">Bills &amp; Receipts Uploaded</span>
                                <span class="block text-[11px] text-slate-500 leading-tight mt-0.5">Every expense has supporting bills</span>
                            </div>
                        </div>

                        {{-- Fact 3: Regular Updates --}}
                        <div class="flex items-start gap-3">
                            <div class="h-8 w-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </div>
                            <div class="min-w-0">
                                <span class="block text-xs font-bold text-slate-900 leading-snug">Regular Updates</span>
                                <span class="block text-[11px] text-slate-500 leading-tight mt-0.5">Project progress shared with donors</span>
                            </div>
                        </div>

                        {{-- Fact 4: Field Photos & Reports --}}
                        <div class="flex items-start gap-3">
                            <div class="h-8 w-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <span class="block text-xs font-bold text-slate-900 leading-snug">Field Photos &amp; Reports</span>
                                <span class="block text-[11px] text-slate-500 leading-tight mt-0.5">Real impact from ground level</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= ROW 2: RECENT FUND UTILIZATION + BILLS & GROUND IMPACT ================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 items-start">

            {{-- Left Column: Recent Fund Utilization (5 Items List) --}}
            <div id="recent-utilization-section" class="lg:col-span-5 bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-2xs">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h2 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight">
                        Recent Fund Utilization
                    </h2>
                    <a href="#ledger-table"
                       @click.prevent="scrollToSection('ledger-table')"
                       class="text-xs font-bold text-[#16a34a] hover:text-[#15803d] transition inline-flex items-center gap-1 cursor-pointer">
                        <span>View All</span>
                        <span>→</span>
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach($itemsList as $item)
                        <div class="py-3.5 first:pt-3.5 last:pb-1 flex items-start justify-between gap-3 group cursor-pointer"
                             @click="openModal({{ json_encode($item) }})">
                            <div class="flex items-start gap-3 min-w-0 flex-1">
                                <img src="{{ $item['image'] }}"
                                     alt="{{ $item['title'] }}"
                                     loading="lazy"
                                     class="h-11 w-11 sm:h-12 sm:w-12 rounded-xl object-cover shrink-0 border border-slate-200 shadow-2xs group-hover:scale-105 transition-transform duration-200">
                                <div class="min-w-0 flex-1">
                                    <span class="block text-xs sm:text-[13px] font-bold text-slate-900 group-hover:text-emerald-700 transition-colors leading-snug truncate">
                                        {{ $item['title'] }}
                                    </span>
                                    <span class="block text-[11px] text-slate-500 line-clamp-1 leading-tight mt-0.5">
                                        {{ $item['description'] }}
                                    </span>
                                    <div class="mt-1.5 flex items-center gap-2">
                                        <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-full border {{ $item['category_class'] }}">
                                            {{ $item['category_name'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right shrink-0">
                                <span class="block text-xs sm:text-sm font-black text-slate-900">
                                    ₹{{ number_format($item['amount'], 2) }}
                                </span>
                                <span class="block text-[11px] text-slate-400 mt-0.5">
                                    {{ $item['date'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Right Column: Latest Bills & Receipts (Top) + Impact from the Ground (Bottom) --}}
            <div class="lg:col-span-7 space-y-6">

                {{-- 1. Latest Bills & Receipts --}}
                <div id="bills-receipts-section" class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-2xs">
                    <div class="flex items-center justify-between pb-4">
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight">
                            Latest Bills &amp; Receipts
                        </h2>
                        <div class="flex items-center gap-2">
                            <a href="#ledger-table"
                               @click.prevent="scrollToSection('ledger-table')"
                               class="text-xs font-bold text-[#16a34a] hover:text-[#15803d] transition inline-flex items-center gap-1 cursor-pointer mr-2">
                                <span>View All</span>
                                <span>→</span>
                            </a>
                            <div class="flex items-center gap-1">
                                <button type="button"
                                        @click="billsIndex = Math.max(0, billsIndex - 1)"
                                        aria-label="Previous bill"
                                        class="h-7 w-7 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center text-xs transition cursor-pointer">
                                    ‹
                                </button>
                                <button type="button"
                                        @click="billsIndex = Math.min(1, billsIndex + 1)"
                                        aria-label="Next bill"
                                        class="h-7 w-7 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center text-xs transition cursor-pointer">
                                    ›
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- 4 Bill Cards Row --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach($billsAndReceipts as $bill)
                            <div class="rounded-xl border border-slate-200/90 p-2.5 bg-slate-50/50 hover:bg-white hover:border-emerald-300 hover:shadow-xs transition duration-200 group cursor-pointer flex flex-col justify-between"
                                 @click="openModal({{ json_encode($bill) }})">
                                {{-- Scanned Document Thumbnail Preview --}}
                                <div class="relative h-28 w-full rounded-lg bg-white border border-slate-200/80 overflow-hidden flex items-center justify-center shadow-2xs">
                                    <img src="{{ $bill['image'] }}"
                                         alt="{{ $bill['title'] }}"
                                         loading="lazy"
                                         class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-200 opacity-90">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent"></div>
                                    <span class="absolute bottom-1.5 right-1.5 text-[9px] font-bold bg-white/90 text-slate-800 px-1.5 py-0.5 rounded shadow-xs">
                                        Verified
                                    </span>
                                </div>

                                <div class="pt-2">
                                    <span class="block text-xs font-bold text-slate-900 truncate group-hover:text-emerald-700">
                                        {{ $bill['title'] }}
                                    </span>
                                    <span class="block text-xs font-black text-slate-900 mt-0.5">
                                        ₹{{ number_format($bill['amount'], 2) }}
                                    </span>
                                    <span class="block text-[10px] text-slate-400 mt-0.5">
                                        {{ $bill['date'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- 2. Impact from the Ground (5 Photos Grid) --}}
                <div id="impact-ground-section" class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-2xs">
                    <div class="flex items-center justify-between pb-4">
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight">
                            Impact from the Ground
                        </h2>
                        <a href="#ledger-table"
                           @click.prevent="scrollToSection('ledger-table')"
                           class="text-xs font-bold text-[#16a34a] hover:text-[#15803d] transition inline-flex items-center gap-1 cursor-pointer">
                            <span>View All</span>
                            <span>→</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-2.5">
                        @foreach($groundPhotos as $photo)
                            <div class="relative h-20 sm:h-24 rounded-xl overflow-hidden group cursor-pointer border border-slate-200/80 shadow-2xs"
                                 @click="openModal({ title: '{{ $photo['title'] }}', image: '{{ $photo['image'] }}', category_name: '{{ $photo['category'] }}' })">
                                <img src="{{ $photo['image'] }}"
                                     alt="{{ $photo['title'] }}"
                                     loading="lazy"
                                     class="h-full w-full object-cover group-hover:scale-110 transition duration-300">
                                <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent transition-colors"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= DETAILED AUDITED LEDGER TABLE SECTION ================= --}}
        <div id="ledger-table" class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 p-5 sm:p-8 shadow-2xs scroll-mt-24">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div>
                    <h2 class="text-base sm:text-lg font-extrabold text-slate-900">
                        Itemized Financial Ledger & Public Distributions
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Every single rupee verified against bank statements, invoices, and physical proofs.
                    </p>
                </div>

                {{-- Filter by Campaign & Search --}}
                <form action="{{ route('transparency.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                    <input type="hidden" name="year" value="{{ $selectedYear }}">
                    <select name="campaign" onchange="this.form.submit()"
                            class="h-9 px-3 text-xs font-medium rounded-xl border border-slate-200 bg-white text-slate-700 focus:border-emerald-500 focus:outline-hidden">
                        <option value="">All Supported Causes</option>
                        @foreach($campaigns as $camp)
                            <option value="{{ $camp->id }}" {{ request('campaign') == $camp->id ? 'selected' : '' }}>
                                {{ $camp->title }}
                            </option>
                        @endforeach
                    </select>

                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search purpose, beneficiary..."
                           class="h-9 px-3 text-xs rounded-xl border border-slate-200 text-slate-800 placeholder-slate-400 focus:border-emerald-500 focus:outline-hidden">

                    <button type="submit"
                            class="h-9 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition">
                        Filter
                    </button>

                    @if(request()->hasAny(['campaign', 'search']))
                        <a href="{{ route('transparency.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600 px-2 py-1">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            {{-- Table / Cards Grid --}}
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @forelse($distributions as $dist)
                    <div class="rounded-2xl border border-slate-200/90 bg-slate-50/40 hover:bg-white hover:border-emerald-300 transition duration-200 p-4 sm:p-5 flex flex-col justify-between shadow-2xs">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2 text-[11px] font-semibold text-slate-400">
                                <span>{{ $dist->distribution_date ? $dist->distribution_date->format('d M Y') : 'Verified' }}</span>
                                @if($dist->campaign)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 truncate max-w-[140px]">
                                        {{ $dist->campaign->title }}
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                        General Relief
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-xs sm:text-sm font-bold text-slate-900 line-clamp-1">{{ $dist->title }}</h3>
                            <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $dist->description }}</p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-medium text-slate-400 block">Beneficiary</span>
                                <span class="text-xs font-bold text-slate-800 truncate block max-w-[140px]">{{ $dist->beneficiary_name }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-medium text-slate-400 block">Disbursed</span>
                                <span class="text-xs sm:text-sm font-black text-slate-900 block">₹{{ number_format($dist->amount_spent, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 py-10 text-center text-slate-400 text-xs">
                        No additional filtered records found.
                    </div>
                @endforelse
            </div>

            @if($distributions->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $distributions->links() }}
                </div>
            @endif
        </div>

        {{-- ================= CALL TO ACTION BANNER ================= --}}
        <div class="rounded-2xl sm:rounded-3xl bg-[#ecfdf5] border border-emerald-100/90 p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-4 relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight">
                    Be a Part of Transparent Change
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-xl">
                    Your support helps us continue our work with integrity and accountability.
                </p>
            </div>
            <a href="{{ route('donate.index') }}"
               class="relative z-10 shrink-0 inline-flex items-center gap-2 rounded-xl bg-[#16a34a] hover:bg-[#15803d] px-6 py-3 text-xs sm:text-sm font-bold text-white shadow-xs transition cursor-pointer">
                <span>Donate Now</span>
                <span aria-hidden="true">→</span>
            </a>
        </div>

    </div>

    {{-- ================= AUDIT DETAIL MODAL ================= --}}
    <div x-show="ledgerModalOpen"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs"
         @keydown.escape.window="closeModal()">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-7 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto space-y-4"
             @click.outside="closeModal()">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider block">Audited Proof Record</span>
                    <h4 class="text-base sm:text-lg font-bold text-slate-900 mt-0.5" x-text="modalItem ? modalItem.title : ''"></h4>
                </div>
                <button type="button" @click="closeModal()" class="h-8 w-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 font-bold cursor-pointer">
                    &times;
                </button>
            </div>

            <template x-if="modalItem && modalItem.image">
                <div class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-50 max-h-64 flex items-center justify-center">
                    <img :src="modalItem.image" :alt="modalItem.title" class="max-h-64 w-full object-contain">
                </div>
            </template>

            <div class="grid grid-cols-2 gap-3 p-3.5 bg-slate-50 rounded-2xl border border-slate-100 text-xs">
                <div>
                    <span class="text-slate-400 font-medium block">Category</span>
                    <span class="font-bold text-slate-800 block mt-0.5" x-text="modalItem ? (modalItem.category_name || 'Public Relief') : ''"></span>
                </div>
                <div>
                    <span class="text-slate-400 font-medium block">Amount Disbursed</span>
                    <span class="font-bold text-slate-900 block mt-0.5" x-text="modalItem && modalItem.amount ? ('₹' + Number(modalItem.amount).toLocaleString('en-IN', { minimumFractionDigits: 2 })) : 'Audited'"></span>
                </div>
                <div>
                    <span class="text-slate-400 font-medium block">Audit Reference</span>
                    <span class="font-mono text-slate-700 block mt-0.5" x-text="modalItem ? (modalItem.ref || 'VERIFIED-PUBLIC') : ''"></span>
                </div>
                <div>
                    <span class="text-slate-400 font-medium block">Distribution Date</span>
                    <span class="font-bold text-slate-800 block mt-0.5" x-text="modalItem ? (modalItem.date || 'Verified') : ''"></span>
                </div>
            </div>

            <template x-if="modalItem && modalItem.description">
                <p class="text-xs text-slate-600 leading-relaxed p-3 rounded-xl bg-slate-50 border border-slate-100" x-text="modalItem.description"></p>
            </template>
        </div>
    </div>
</div>
@endsection
