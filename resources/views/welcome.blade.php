@extends('layouts.base')

@section('title', setting('hero_title', 'Empowering Communities with Complete Transparency'))

@section('content')
<!-- 1. Flagship Hero Section -->
<section class="relative bg-gradient-to-b from-[#03150e] via-[#052117] to-[#041a12] text-white pt-16 pb-28 sm:pt-24 sm:pb-36 overflow-hidden">
    <!-- Ambient Glow & Background Image Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070&auto=format&fit=crop" 
             alt="Community Support & Hope" 
             class="w-full h-full object-cover opacity-20 mix-blend-luminosity filter blur-[0.5px]">
        <!-- <div class="absolute inset-0 bg-gradient-to-t from-[#041a12] via-[#052117]/90 to-[#03150e]/95"></div>
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 -right-32 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div> -->
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <!-- Cursive Accent "Together" Eyebrow -->
        <div class="inline-block mb-3 animate-fade-in">
            <span class="font-handwriting text-emerald-400 text-4xl sm:text-5xl lg:text-6xl font-bold tracking-wide transform -rotate-2 inline-block">
                Together
            </span>
        </div>

        <!-- Hero Headline -->
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight max-w-4xl mx-auto leading-tight sm:leading-none">
            {{ setting('hero_title', 'Direct Impact, Zero Deductions, 100% Transparency') }}
        </h1>

        <!-- Tagline / Subtitle -->
        <p class="mt-6 text-sm sm:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed font-normal">
            {{ setting('hero_subtitle', 'Hope Foundation works for education, healthcare, clean water and a better future. Every rupee donated is verified against bank statements and tracked directly to ground relief with proof bills.') }}
        </p>

        <!-- CTA Buttons -->
        <div class="mt-10 flex flex-wrap justify-center items-center gap-4">
            <a href="{{ route('donate.index') }}"
               class="px-8 py-3.5 rounded-full font-black text-sm sm:text-base text-white bg-emerald-600 hover:bg-emerald-500 shadow-xl shadow-emerald-950/60 hover:shadow-emerald-700/40 transition transform active:scale-95 flex items-center gap-2">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <span>Donate Now</span>
            </a>
            <a href="{{ route('transparency.index') }}"
               class="px-7 py-3.5 rounded-full font-bold text-sm sm:text-base text-slate-200 bg-white/10 hover:bg-white/15 border border-white/20 hover:border-white/30 backdrop-blur-md transition flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8" fill="currentColor"/>
                </svg>
                <span>Watch Our Story & Proofs</span>
            </a>
        </div>

        <!-- Handwritten Heart Tagline -->
        <div class="mt-6 flex justify-center items-center gap-2">
            <span class="font-handwriting text-emerald-300 text-xl font-bold tracking-wide">
                A smile can change a life ♡
            </span>
        </div>

        <!-- Quick Trust Indicators -->
        <div class="mt-12 pt-8 border-t border-white/10 grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto text-left">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Zero Gateway Fees</h4>
                    <p class="text-[11px] text-slate-400">100% of donation reaches ground</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-500/15 border border-blue-500/30 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Public Bill Proofs</h4>
                    <p class="text-[11px] text-slate-400">GST bills & field photos on ledger</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-500/15 border border-purple-500/30 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">80G Tax Exemption</h4>
                    <p class="text-[11px] text-slate-400">Instant compliant PDF receipt</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Floating Elevated Stat Strip -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 sm:-mt-16 relative z-30">
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-100 grid grid-cols-2 lg:grid-cols-4 gap-6 divide-y lg:divide-y-0 lg:divide-x divide-slate-100">
        
        <!-- Stat 1: Verified Raised -->
        <div class="pt-2 lg:pt-0 lg:px-4 text-center">
            <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                ₹{{ number_format($totalRaised, 2) }}
            </div>
            <div class="text-xs font-bold text-emerald-700 uppercase tracking-wider mt-1">Verified Raised</div>
            <p class="text-[11px] text-slate-500 mt-0.5">100% verified via bank records</p>
        </div>

        <!-- Stat 2: Funds Utilized -->
        <div class="pt-4 lg:pt-0 lg:px-4 text-center">
            <div class="text-2xl sm:text-3xl font-black text-emerald-600 tracking-tight">
                ₹{{ number_format($totalDistributed, 2) }}
            </div>
            <div class="text-xs font-bold text-slate-700 uppercase tracking-wider mt-1">Funds Utilized</div>
            <p class="text-[11px] text-slate-500 mt-0.5">Direct to ground relief</p>
        </div>

        <!-- Stat 3: Active Volunteers -->
        <div class="pt-4 lg:pt-0 lg:px-4 text-center">
            <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                {{ number_format($volunteerCount) }}
            </div>
            <div class="text-xs font-bold text-slate-700 uppercase tracking-wider mt-1">Active Volunteers</div>
            <p class="text-[11px] text-slate-500 mt-0.5">Field relief responders</p>
        </div>

        <!-- Stat 4: Donors Support / Active Causes -->
        <div class="pt-4 lg:pt-0 lg:px-4 text-center">
            <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                {{ max(125, $donorsCount) }}+
            </div>
            <div class="text-xs font-bold text-slate-700 uppercase tracking-wider mt-1">Donors & Causes</div>
            <p class="text-[11px] text-slate-500 mt-0.5">{{ $activeCausesCount }} active relief campaigns</p>
        </div>

    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 space-y-28">

    <!-- 3. Our Campaigns Section -->
    <section id="campaigns">
        <div class="text-center max-w-3xl mx-auto mb-10">
            <span class="text-xs font-extrabold text-emerald-700 uppercase tracking-widest block mb-2">Our Campaigns</span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                Support Causes That Change Lives
            </h2>
            <p class="text-sm text-slate-600 mt-3 leading-relaxed">
                Choose an urgent initiative to sponsor directly. Every rupee is verified against bank statements with 0% platform deductions.
            </p>

            <!-- Cause Category Filter Pills -->
            @if(isset($categories) && $categories->isNotEmpty())
                <div class="flex flex-wrap justify-center items-center gap-2 pt-6">
                    <a href="{{ route('campaigns.index') }}" 
                       class="px-4 py-2 rounded-full text-xs font-bold bg-emerald-700 text-white shadow-xs transition">
                        All Causes
                    </a>
                    @foreach($categories->take(5) as $category)
                        <a href="{{ route('campaigns.index', ['category' => $category->slug]) }}" 
                           class="px-4 py-2 rounded-full text-xs font-bold bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 transition">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        @if($urgentCampaigns->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($urgentCampaigns as $campaign)
                    @php
                        $progressPercent = $campaign->goal_amount > 0 ? min(100, round(($campaign->raised_amount / $campaign->goal_amount) * 100)) : 0;
                    @endphp
                    <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <!-- Thumbnail -->
                            <div class="relative aspect-video bg-slate-100 overflow-hidden">
                                @if ($campaign->thumbnail_image)
                                    <img src="{{ asset('storage/' . $campaign->thumbnail_image) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <img src="https://images.unsplash.com/photo-1542810634-71277d95dcbb?q=80&w=800&auto=format&fit=crop" alt="{{ $campaign->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @endif

                                @if($campaign->category)
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-white/95 text-emerald-800 backdrop-blur-xs shadow-xs">
                                            {{ $campaign->category->name }}
                                        </span>
                                    </div>
                                @endif

                                @if ($campaign->is_urgent)
                                    <div class="absolute top-4 right-4">
                                        <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-rose-600 text-white shadow-xs animate-pulse flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                            Urgent Appeal
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <h3 class="text-lg font-black text-slate-900 group-hover:text-emerald-700 transition leading-snug line-clamp-2 mb-2">
                                    <a href="{{ route('campaigns.show', $campaign->slug) }}">
                                        {{ $campaign->title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed mb-6">
                                    {{ $campaign->short_description }}
                                </p>

                                <!-- Financial Progress -->
                                <div class="space-y-2 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <div class="flex justify-between items-baseline text-xs">
                                        <span class="font-black text-slate-900">₹{{ number_format($campaign->raised_amount, 2) }}</span>
                                        <span class="text-slate-500 font-medium">Goal: ₹{{ number_format($campaign->goal_amount, 2) }}</span>
                                    </div>

                                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-emerald-600 h-2 rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                                    </div>

                                    <div class="flex justify-between items-center text-[11px] text-slate-500 font-medium pt-0.5">
                                        <span class="text-emerald-700 font-bold">{{ $progressPercent }}% funded</span>
                                        @if($campaign->end_date)
                                            <span>Ends {{ $campaign->end_date->format('d M Y') }}</span>
                                        @else
                                            <span>Ongoing Drive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer CTA -->
                        <div class="px-6 pb-6 pt-2 flex items-center gap-3">
                            <a href="{{ route('donate.index', ['campaign_id' => $campaign->id]) }}"
                               class="flex-1 py-3 px-4 text-center rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition">
                                Donate Now &rarr;
                            </a>
                            <a href="{{ route('campaigns.show', $campaign->slug) }}"
                               class="py-3 px-4 rounded-full border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-50 transition">
                                Read Story
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center pt-8">
                <a href="{{ route('campaigns.index') }}" 
                   class="inline-flex items-center gap-2 px-7 py-3 rounded-full border-2 border-emerald-600 text-emerald-700 font-bold text-sm hover:bg-emerald-50 transition">
                    <span>View All Active Causes</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        @else
            <div class="p-12 rounded-3xl bg-slate-50 border border-slate-200 text-center text-slate-500 text-sm">
                No active campaigns currently featured.
            </div>
        @endif
    </section>

    <!-- 4. "About Us" Teaser Section -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <!-- Left Photo Collage with Green Badge -->
        <div class="lg:col-span-5 relative">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white aspect-[4/5]">
                <img src="https://images.unsplash.com/photo-1593113598332-cd288d649433?q=80&w=1200&auto=format&fit=crop" 
                     alt="Real People, Real Change" 
                     class="w-full h-full object-cover">
                
                <!-- Green Ribbon Sticker -->
                <div class="absolute bottom-6 left-6 right-6 bg-emerald-700/90 backdrop-blur-md rounded-2xl p-4 text-white shadow-lg flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white text-emerald-700 flex items-center justify-center font-black shrink-0">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>
                    <div>
                        <span class="font-extrabold text-sm block">Real People, Real Change</span>
                        <span class="text-xs text-emerald-200">100% Grassroots Impact in India</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Mission Pillars & Story -->
        <div class="lg:col-span-7 space-y-6">
            <span class="text-xs font-extrabold text-emerald-700 uppercase tracking-widest block">About Us</span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                Passionate About Helping People & Strengthening Communities
            </h2>
            <p class="text-sm text-slate-600 leading-relaxed">
                Hope Foundation was founded with one unwavering principle: complete, verifiable transparency in social welfare. We bridge generous donors with rural schools, hospitals, and disaster relief zones without intermediary fee losses.
            </p>

            <!-- 3 Pillars -->
            <div class="space-y-4 pt-2">
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-100 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-black shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-black text-slate-900 text-sm">Our Mission</h4>
                        <p class="text-xs text-slate-600 mt-0.5">To deliver direct, zero-leakage aid to underprivileged families and rural communities.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-100 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-black shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </div>
                    <div>
                        <h4 class="font-black text-slate-900 text-sm">Our Vision</h4>
                        <p class="text-xs text-slate-600 mt-0.5">A world where quality education, clean water, and timely healthcare are accessible to every soul.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-slate-100 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-black shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <div>
                        <h4 class="font-black text-slate-900 text-sm">Our Values</h4>
                        <p class="text-xs text-slate-600 mt-0.5">Public financial accountability, bank-reconciled donor UTR verification, and compassion.</p>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <a href="{{ Route::has('about') ? route('about') : url('/about') }}" 
                   class="inline-flex items-center gap-2 text-sm font-black text-emerald-700 hover:text-emerald-800 transition">
                    <span>Know More About Us</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- 5. Ground Proof: Transparency Showcase -->
    <section class="bg-[#041a12] text-white rounded-3xl p-8 sm:p-14 border border-emerald-950/60 shadow-2xl relative overflow-hidden">
        <div class="max-w-3xl mb-10">
            <span class="text-xs font-extrabold text-emerald-400 uppercase tracking-widest block mb-2">Ground Proof & Ledger</span>
            <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                Your Trust Drives Real Impact
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 mt-3 leading-relaxed">
                We believe trust is earned through verifiable evidence. Inspect actual vendor invoices, GST receipts, and geotagged field photos for every relief distribution.
            </p>
        </div>

        @if($recentDistributions->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                @foreach ($recentDistributions as $dist)
                    <div class="bg-white/5 rounded-2xl p-5 border border-white/10 hover:border-emerald-500/50 transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between text-xs text-slate-400 mb-2">
                                <span>{{ $dist->distribution_date?->format('d M Y') }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                    Bill Verified
                                </span>
                            </div>
                            <h4 class="font-bold text-white text-sm mb-1 line-clamp-1">{{ $dist->title }}</h4>
                            <p class="text-xs text-slate-400 line-clamp-2 mb-3">{{ $dist->description }}</p>
                            @if($dist->beneficiary_name)
                                <div class="text-[11px] text-slate-500 mb-2">
                                    Beneficiary: <span class="text-slate-300 font-medium">{{ $dist->beneficiary_name }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="pt-3 border-t border-white/10 flex items-center justify-between">
                            <span class="text-xs text-slate-400">Expended</span>
                            <span class="font-mono font-bold text-emerald-400 text-base">₹{{ number_format($dist->amount_spent, 2) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pt-6 border-t border-white/10">
            <div class="text-xs text-slate-400">
                100% of receipts and utilization proofs are published publicly without administrative redactions.
            </div>
            <a href="{{ route('transparency.index') }}"
               class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition shadow-md shrink-0">
                <span>View Full Transparency Ledger</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </section>

    <!-- 6. Join Our Volunteer Community Full-Width Banner -->
    <section class="bg-gradient-to-r from-emerald-800 via-emerald-900 to-slate-900 rounded-3xl p-8 sm:p-14 text-white shadow-2xl relative overflow-hidden">
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <div class="max-w-2xl text-left">
                <span class="text-xs font-extrabold text-emerald-300 uppercase tracking-widest block mb-2">Grassroots Movement</span>
                <h3 class="text-3xl sm:text-4xl font-black text-white tracking-tight mb-3">
                    Become a Volunteer & Change Lives
                </h3>
                <p class="text-xs sm:text-sm text-slate-200 leading-relaxed mb-6">
                    Whether you have medical expertise, teaching skills, or logistics capacity, your time directly transforms lives in our community. Join our screened, passionate volunteers on the ground.
                </p>

                <!-- Program feature badges -->
                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-white/10 text-emerald-200 border border-white/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Community Support
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-white/10 text-emerald-200 border border-white/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Education Programs
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-white/10 text-emerald-200 border border-white/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Environmental Activities
                    </span>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4 shrink-0">
                <a href="{{ route('volunteers.create') }}"
                   class="px-8 py-3.5 rounded-full bg-white text-emerald-900 hover:bg-emerald-50 font-black text-xs sm:text-sm transition shadow-lg flex items-center gap-2">
                    <span>Become a Volunteer</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('events.index') }}"
                   class="px-6 py-3.5 rounded-full bg-emerald-950/60 hover:bg-emerald-950 text-white font-bold text-xs sm:text-sm border border-emerald-700/60 transition">
                    Attend a Drive
                </a>
            </div>
        </div>
    </section>

    <!-- 7. Upcoming Community Relief Drives & Events -->
    @if($upcomingEvents->isNotEmpty())
        <section id="events">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="text-xs font-extrabold text-emerald-700 uppercase tracking-widest block mb-2">On-Ground Engagement</span>
                    <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                        Upcoming Community Drives & Camps
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2">
                        Participate as an attendee or volunteer with our field team.
                    </p>
                </div>
                <a href="{{ route('events.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-800 transition">
                    View All Events &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($upcomingEvents as $event)
                    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-lg transition flex flex-col justify-between">
                        <div>
                            @if($event->banner_image)
                                <div class="aspect-video w-full overflow-hidden bg-slate-100">
                                    <img src="{{ asset('storage/' . $event->banner_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-xs font-bold text-emerald-700 mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>{{ $event->event_date?->format('d M Y') }} &bull; {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</span>
                                </div>
                                <h3 class="text-base font-bold text-slate-900 leading-snug line-clamp-1 mb-2">
                                    {{ $event->title }}
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-2 mb-4">
                                    {{ $event->location_name }} &bull; {{ Str::limit($event->address, 60) }}
                                </p>
                            </div>
                        </div>

                        <div class="px-6 pb-6 pt-2 flex items-center justify-between border-t border-slate-100">
                            <span class="text-[11px] text-slate-500 font-medium">
                                @if($event->max_participants)
                                    Cap: {{ $event->max_participants }} attendees
                                @else
                                    Open to all
                                @endif
                            </span>
                            <a href="{{ route('events.show', $event->slug) }}" class="px-4 py-2 rounded-full text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition">
                                RSVP / Details &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- 8. Stories of Hope: Testimonials -->
    <section>
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-extrabold text-emerald-700 uppercase tracking-widest block mb-2">Testimonials</span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                Stories of Hope & Gratitude
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-2">
                Hear from donors and volunteers who experience our transparent model firsthand.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col justify-between">
                <p class="text-xs text-slate-600 leading-relaxed italic mb-6">
                    "Being able to see the exact GST invoice of the oxygen concentrators we sponsored in Varanasi gives total peace of mind. Plus, the automated 80G tax receipt was delivered straight to my email."
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-sm">
                        AV
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-xs">Dr. Anand Verma</h4>
                        <span class="text-[11px] text-slate-400">Regular Donor &bull; New Delhi</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col justify-between">
                <p class="text-xs text-slate-600 leading-relaxed italic mb-6">
                    "Volunteering with Hope Foundation has opened my eyes. Every weekend drive is structured, safe, and genuinely reaches families who need warm blankets and education stationery."
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-teal-100 text-teal-800 font-bold flex items-center justify-center text-sm">
                        PT
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-xs">Pooja Tiwari</h4>
                        <span class="text-[11px] text-slate-400">Field Volunteer &bull; Varanasi</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col justify-between">
                <p class="text-xs text-slate-600 leading-relaxed italic mb-6">
                    "Zero platform fee deduction is the key reason our family foundation chose Hope Foundation. When you transfer ₹50,000 via UPI, all ₹50,000 goes straight to patient medicine relief."
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-800 font-bold flex items-center justify-center text-sm">
                        RK
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-xs">Rajesh K. Mehta</h4>
                        <span class="text-[11px] text-slate-400">Corporate Philanthropist &bull; Mumbai</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
