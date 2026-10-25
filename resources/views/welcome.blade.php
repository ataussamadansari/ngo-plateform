@extends('layouts.base')

@section('title', setting('hero_title', 'Empowering Communities with Complete Transparency'))

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-b from-slate-900 via-slate-900 to-slate-800 text-white py-16 sm:py-24 border-b border-slate-800">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-emerald-500/10 via-transparent to-transparent pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <!-- Tagline Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 mb-6 backdrop-blur-xs">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            {{ setting('ngo_tagline', 'Direct Relief & 100% Verified Transparency') }}
        </div>

        <!-- Hero Title -->
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight max-w-4xl mx-auto leading-tight sm:leading-none">
            {{ setting('hero_title', 'Direct Impact, Zero Deductions, 100% Transparency') }}
        </h1>

        <!-- Subtitle -->
        <p class="mt-6 text-sm sm:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed">
            {{ setting('hero_subtitle', 'Every rupee you donate is verified against bank records and tracked directly to ground relief with proof bills.') }}
        </p>

        <!-- CTA Buttons -->
        <div class="mt-10 flex flex-wrap justify-center items-center gap-4">
            <a href="{{ route('donate.index') }}"
               class="px-8 py-3.5 rounded-2xl font-black text-sm sm:text-base text-white bg-primary hover:opacity-95 shadow-lg hover:shadow-emerald-900/40 transition transform active:scale-98">
                {{ setting('hero_cta_text', 'Donate to Urgent Causes') }}
            </a>
            <a href="{{ route('transparency.index') }}"
               class="px-7 py-3.5 rounded-2xl font-bold text-sm sm:text-base text-slate-200 bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700 hover:border-slate-600 transition backdrop-blur-xs">
                Inspect Public Ledger
            </a>
            <a href="{{ route('volunteers.create') }}"
               class="px-7 py-3.5 rounded-2xl font-bold text-sm sm:text-base text-emerald-300 bg-emerald-950/40 hover:bg-emerald-900/60 border border-emerald-800/50 transition">
                Volunteer With Us &rarr;
            </a>
        </div>

        <!-- Quick Trust Indicators -->
        <div class="mt-14 pt-10 border-t border-slate-800/80 grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto text-left">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Zero Gateway Fees</h4>
                    <p class="text-[11px] text-slate-400">100% of donation reaches ground</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Public Bill Proofs</h4>
                    <p class="text-[11px] text-slate-400">Bills & photos verified on ledger</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">80G Tax Exemption</h4>
                    <p class="text-[11px] text-slate-400">Instant PDF compliant receipt</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Live Impact Metrics Strip -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Verified Raised</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                ₹{{ number_format($totalRaised, 2) }}
            </div>
            <p class="text-[11px] text-emerald-600 font-semibold mt-1">100% verified via bank records</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Distributed to Ground</span>
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-blue-700 tracking-tight">
                ₹{{ number_format($totalDistributed, 2) }}
            </div>
            <p class="text-[11px] text-slate-500 mt-1">Backed by public GST bills & photos</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Active Volunteers</span>
                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-purple-700 tracking-tight">
                {{ number_format($volunteerCount) }}
            </div>
            <p class="text-[11px] text-slate-500 mt-1">Screened community volunteers</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Active Causes</span>
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-amber-600 tracking-tight">
                {{ number_format($activeCausesCount) }}
            </div>
            <p class="text-[11px] text-slate-500 mt-1">Direct community relief campaigns</p>
        </div>

    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-20">

    <!-- Cause Categories / Focus Areas -->
    @if(isset($categories) && $categories->isNotEmpty())
        <section>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider block mb-1">Our Focus Areas</span>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Cause Sectors & Relief Initiatives</h2>
                </div>
                <a href="{{ route('campaigns.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 transition">
                    Browse All &rarr;
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('campaigns.index', ['category' => $category->slug]) }}"
                       class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 text-center shadow-xs hover:border-emerald-500 hover:shadow-md transition-all group">
                        <div class="w-10 h-10 mx-auto rounded-xl bg-emerald-50 text-emerald-700 group-hover:bg-emerald-600 group-hover:text-white flex items-center justify-center font-black text-sm mb-3 transition">
                            {{ substr($category->name, 0, 1) }}
                        </div>
                        <h3 class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-emerald-700 transition">{{ $category->name }}</h3>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Urgent Causes Section -->
    <section id="urgent-causes">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold text-red-600 uppercase tracking-wider block mb-1">Direct Relief Appeals</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Featured & Urgent Campaigns
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Every donation is verified manually with zero fee deductions.
                </p>
            </div>
            <a href="{{ route('campaigns.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-800 transition">
                View All Active Causes &rarr;
            </a>
        </div>

        @if($urgentCampaigns->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($urgentCampaigns as $campaign)
                    @php
                        $progressPercent = $campaign->goal_amount > 0 ? min(100, round(($campaign->raised_amount / $campaign->goal_amount) * 100)) : 0;
                    @endphp
                    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <!-- Thumbnail -->
                            <div class="relative aspect-video bg-slate-100 overflow-hidden">
                                @if ($campaign->thumbnail_image)
                                    <img src="{{ asset('storage/' . $campaign->thumbnail_image) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 font-bold text-xs">No Image</div>
                                @endif

                                @if($campaign->category)
                                    <div class="absolute top-3 left-3">
                                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-900/80 text-white backdrop-blur-xs">
                                            {{ $campaign->category->name }}
                                        </span>
                                    </div>
                                @endif

                                @if ($campaign->is_urgent)
                                    <div class="absolute top-3 right-3">
                                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-red-600 text-white shadow-xs animate-pulse">
                                            Urgent Appeal
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition leading-snug line-clamp-2 mb-2">
                                    <a href="{{ route('campaigns.show', $campaign->slug) }}">
                                        {{ $campaign->title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed mb-6">
                                    {{ $campaign->short_description }}
                                </p>

                                <!-- Financial Progress -->
                                <div class="space-y-2">
                                    <div class="flex justify-between items-baseline text-xs">
                                        <span class="font-bold text-slate-900">₹{{ number_format($campaign->raised_amount, 2) }}</span>
                                        <span class="text-slate-500">Goal: ₹{{ number_format($campaign->goal_amount, 2) }}</span>
                                    </div>

                                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-primary h-2 rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                                    </div>

                                    <div class="flex justify-between items-center text-[11px] text-slate-400">
                                        <span>{{ $progressPercent }}% funded</span>
                                        @if($campaign->end_date)
                                            <span>Ends {{ $campaign->end_date->format('d M Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer CTA -->
                        <div class="px-6 pb-6 pt-2 flex items-center gap-3">
                            <a href="{{ route('donate.index', ['campaign_id' => $campaign->id]) }}"
                               class="flex-1 py-2.5 px-4 text-center rounded-xl bg-primary text-white font-bold text-xs hover:opacity-95 shadow-xs transition">
                                Donate Now
                            </a>
                            <a href="{{ route('campaigns.show', $campaign->slug) }}"
                               class="py-2.5 px-4 rounded-xl border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition">
                                Read Story
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200 text-center text-slate-500 text-xs">
                No active campaigns currently featured.
            </div>
        @endif
    </section>

    <!-- Ground Proof: Real-Time Fund Utilization & Transparency Strip -->
    <section class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-3xl p-8 sm:p-12 border border-slate-800 shadow-xl">
        <div class="max-w-3xl mb-8">
            <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider block mb-1">Ground Proof & Audit Trail</span>
            <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                Recent Fund Utilization & Direct Beneficiary Relief
            </h2>
            <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                We believe trust is earned through verifiable evidence. Inspect actual vendor invoices, GST receipts, and geotagged field photos for every relief distribution.
            </p>
        </div>

        @if($recentDistributions->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach ($recentDistributions as $dist)
                    <div class="bg-slate-800/80 rounded-2xl p-5 border border-slate-700/80 flex flex-col justify-between">
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
                        <div class="pt-3 border-t border-slate-700/60 flex items-center justify-between">
                            <span class="text-xs text-slate-400">Expended</span>
                            <span class="font-mono font-bold text-emerald-400 text-base">₹{{ number_format($dist->amount_spent, 2) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-6 border-t border-slate-800">
            <div class="text-xs text-slate-400">
                100% of receipts and utilization proofs are published publicly without administrative redactions.
            </div>
            <a href="{{ route('transparency.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition shadow-md shrink-0">
                Inspect Public Transparency Ledger &rarr;
            </a>
        </div>
    </section>

    <!-- Upcoming Community Events Section -->
    @if($upcomingEvents->isNotEmpty())
        <section>
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider block mb-1">On-Ground Engagement</span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Upcoming Community Drives & Camps
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
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
                            <span class="text-[11px] text-slate-500">
                                @if($event->max_participants)
                                    Cap: {{ $event->max_participants }} attendees
                                @else
                                    Open to all
                                @endif
                            </span>
                            <a href="{{ route('events.show', $event->slug) }}" class="px-4 py-2 rounded-xl text-xs font-bold text-primary bg-emerald-50 hover:bg-emerald-100 transition">
                                RSVP / Details &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Three Trust Pillars -->
    <section class="py-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider block mb-1">Our Operating Standards</span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Why Donors Choose Our Platform
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xs">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xl mb-4">
                    1
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Zero Payment Gateway Loss</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Unlike standard platforms that cut 2% to 4% in intermediary fees, we accept direct bank transfers and instant dynamic UPI QR codes so 100% of your money reaches beneficiaries.
                </p>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xs">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xl mb-4">
                    2
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Immutable Bank Reconciliation</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Every donation reference (UTR number) is verified by administrators directly against bank account statements before a campaign balance is updated and receipt generated.
                </p>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xs">
                <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-xl mb-4">
                    3
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Audited 80G Tax Exemption</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Indian donors receive an automated, sequentially numbered 80G compliant PDF receipt with government registration credentials for direct income tax exemption claims.
                </p>
            </div>
        </div>
    </section>

    <!-- Volunteer CTA Strip -->
    <section class="bg-gradient-to-r from-emerald-800 to-slate-900 rounded-3xl p-8 sm:p-12 text-white flex flex-col md:flex-row items-center justify-between gap-8 shadow-lg">
        <div class="max-w-xl text-left">
            <span class="text-xs font-bold text-emerald-300 uppercase tracking-wider block mb-1">Grassroots Movement</span>
            <h3 class="text-2xl sm:text-3xl font-black text-white tracking-tight mb-2">
                Join Our Dedicated Volunteer Community
            </h3>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                Whether you have medical expertise, teaching skills, or logistics capacity, your time directly transforms lives in our community.
            </p>
        </div>
        <div class="flex items-center gap-4 shrink-0">
            <a href="{{ route('volunteers.create') }}"
               class="px-8 py-3.5 rounded-2xl bg-white text-slate-900 font-black text-xs sm:text-sm hover:bg-slate-100 transition shadow-md">
                Register as Volunteer
            </a>
            <a href="{{ route('events.index') }}"
               class="px-6 py-3.5 rounded-2xl bg-slate-800/80 hover:bg-slate-700 text-slate-200 font-bold text-xs sm:text-sm border border-slate-700 transition">
                Attend Drive
            </a>
        </div>
    </section>

</div>
@endsection
