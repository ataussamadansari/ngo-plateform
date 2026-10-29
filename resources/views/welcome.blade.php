@extends('layouts.base')

@section('content')
@php
    $ngoName = function_exists('setting') ? setting('ngo_name', 'Hope Foundation') : 'Hope Foundation';
    $donateUrl = Route::has('donate.index') ? route('donate.index') : url('/donate');
    $campaignsUrl = Route::has('campaigns.index') ? route('campaigns.index') : url('/campaigns');
    $transparencyUrl = Route::has('transparency.index') ? route('transparency.index') : url('/transparency');
    $volunteerUrl = Route::has('volunteers.create') ? route('volunteers.create') : url('/volunteer-join');
    $aboutUrl = Route::has('about') ? route('about') : url('/about');
    $eventsUrl = Route::has('events.index') ? route('events.index') : url('/events');

    // Default showcase campaigns matching the exact mockup if DB has < 3 records
    $fallbackCampaigns = [
        [
            'title' => 'Education for Every Child',
            'category' => 'Education',
            'description' => 'Help us provide quality education, books and school facilities.',
            'image' => 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?auto=format&fit=crop&w=900&q=80',
            'raised' => 1250000,
            'goal' => 2000000,
            'percentage' => 62,
            'donateUrl' => $donateUrl,
            'detailUrl' => $campaignsUrl,
        ],
        [
            'title' => 'Clean Water Initiative',
            'category' => 'Clean Water',
            'description' => 'Provide clean and safe drinking water to rural communities.',
            'image' => 'https://images.unsplash.com/photo-1541544741938-0af808871cc0?auto=format&fit=crop&w=900&q=80',
            'raised' => 820000,
            'goal' => 1500000,
            'percentage' => 55,
            'donateUrl' => $donateUrl,
            'detailUrl' => $campaignsUrl,
        ],
        [
            'title' => 'Healthcare for All',
            'category' => 'Medical Aid',
            'description' => 'Support free medical camps and essential treatment.',
            'image' => 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=900&q=80',
            'raised' => 440000,
            'goal' => 1000000,
            'percentage' => 44,
            'donateUrl' => $donateUrl,
            'detailUrl' => $campaignsUrl,
        ],
    ];
@endphp

<!-- ================= 1. HERO BANNER SECTION ================= -->
<section class="relative min-h-[500px] lg:min-h-[540px] flex items-center overflow-hidden bg-[#0a2617]">
    <!-- Background Image + Warm Dark Left-to-Right Gradient -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=1920&q=85"
             alt="Smiling children"
             class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-gradient-to-r from-[#071f12]/95 via-[#0a2617]/75 to-black/25"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

            <!-- Left Column: Handwritten "Together" + Headline + CTAs -->
            <div class="lg:col-span-7 space-y-4" data-reveal>
                <span class="block font-script text-4xl sm:text-5xl text-[#86efac] leading-none -mb-2">
                    Together
                </span>
                <h1 class="text-3xl sm:text-5xl lg:text-[54px] font-extrabold text-white tracking-tight leading-[1.12]">
                    {{ function_exists('setting') ? setting('hero_title', 'Direct Impact, Zero Deductions, 100% Transparency') : 'Direct Impact, Zero Deductions, 100% Transparency' }}
                </h1>
                <p class="text-sm sm:text-base lg:text-lg text-white/85 max-w-xl leading-relaxed">
                    {{ function_exists('setting') ? setting('hero_subtitle', $ngoName . ' works for education, health, clean water and a better future for underprivileged communities.') : $ngoName . ' works for education, health, clean water and a better future for underprivileged communities.' }}
                </p>

                <div class="pt-3 flex flex-wrap items-center gap-3.5">
                    <a href="{{ $donateUrl }}"
                       class="inline-flex items-center justify-center gap-2.5 rounded-xl bg-[#16a34a] hover:bg-[#15803d] text-white text-sm sm:text-base font-bold px-7 py-3.5 shadow-lg shadow-green-900/40 hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>Donate Now</span>
                    </a>

                    <button @click="videoModalOpen = true"
                            type="button"
                            class="inline-flex items-center justify-center gap-2.5 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/40 text-white text-sm sm:text-base font-semibold px-6 py-3.5 transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                        </svg>
                        <span>Watch Our Story</span>
                    </button>
                </div>
            </div>

            <!-- Right Column: Center Frosted Play Button & Handwritten "A smile can change a life" -->
            <div class="lg:col-span-5 relative flex flex-col items-center lg:items-start justify-center min-h-[160px] lg:min-h-[300px]">
                <!-- Pulsing Play Button -->
                <button @click="videoModalOpen = true"
                        type="button"
                        aria-label="Play Story Video"
                        class="relative group w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-white/25 backdrop-blur-md border-2 border-white flex items-center justify-center text-white shadow-2xl hover:scale-110 transition-all duration-300">
                    <span class="absolute inset-0 rounded-full bg-white/30 animate-ping"></span>
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 ml-1 relative z-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </button>

                <!-- Bottom-Right Handwritten Annotation + Hand-drawn Arrow -->
                <div class="hidden sm:flex flex-col items-center absolute bottom-0 right-4 -rotate-6 select-none">
                    <!-- Curved SVG Arrow -->
                    <svg class="w-8 h-8 text-white/90 -mb-1 -ml-12" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 40 40">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 30 C12 14, 24 10, 34 12 M28 7 L34 12 L29 17"/>
                    </svg>
                    <p class="font-script text-2xl lg:text-3xl text-white leading-6 text-center drop-shadow">
                        A smile <br>can change <br>a life <span class="text-[#86efac]">🌱</span>
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= 2. 4-COLUMN SOFT-MINT IMPACT COUNTER BAR ================= -->
<section class="bg-[#eef8f1] border-b border-[#d8f3df] py-6 sm:py-7">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-0 lg:divide-x lg:divide-[#cdebd3]">

            <!-- Metric 1: Verified Raised -->
            <div class="flex items-center justify-center gap-3.5 px-4" data-reveal data-reveal-delay="0">
                <div class="w-12 h-12 rounded-2xl bg-white/80 border border-[#bbf7d0] flex items-center justify-center text-[#16a34a] shrink-0 shadow-2xs">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <div>
                    <span class="block text-xl sm:text-2xl font-extrabold text-slate-900 leading-tight">
                        {{ isset($totalRaised) && $totalRaised > 0 ? '₹' . number_format($totalRaised, 2) : '12,500+' }}
                    </span>
                    <span class="block text-xs font-medium text-slate-600">Verified Raised</span>
                </div>
            </div>

            <!-- Metric 2: Funds Distributed -->
            <div class="flex items-center justify-center gap-3.5 px-4" data-reveal data-reveal-delay="100">
                <div class="w-12 h-12 rounded-2xl bg-white/80 border border-[#bbf7d0] flex items-center justify-center text-[#16a34a] shrink-0 shadow-2xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <span class="block text-xl sm:text-2xl font-extrabold text-slate-900 leading-tight">
                        {{ isset($totalDistributed) && $totalDistributed > 0 ? '₹' . number_format($totalDistributed, 2) : '₹2.8 Cr+' }}
                    </span>
                    <span class="block text-xs font-medium text-slate-600">Funds Distributed</span>
                </div>
            </div>

            <!-- Metric 3: Active Volunteers -->
            <div class="flex items-center justify-center gap-3.5 px-4" data-reveal data-reveal-delay="200">
                <div class="w-12 h-12 rounded-2xl bg-white/80 border border-[#bbf7d0] flex items-center justify-center text-[#16a34a] shrink-0 shadow-2xs">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div>
                    <span class="block text-xl sm:text-2xl font-extrabold text-slate-900 leading-tight">
                        {{ isset($volunteerCount) && $volunteerCount > 0 ? number_format($volunteerCount) : '150+' }}
                    </span>
                    <span class="block text-xs font-medium text-slate-600">Active Volunteers</span>
                </div>
            </div>

            <!-- Metric 4: Active Causes -->
            <div class="flex items-center justify-center gap-3.5 px-4" data-reveal data-reveal-delay="300">
                <div class="w-12 h-12 rounded-2xl bg-white/80 border border-[#bbf7d0] flex items-center justify-center text-[#16a34a] shrink-0 shadow-2xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div>
                    <span class="block text-xl sm:text-2xl font-extrabold text-slate-900 leading-tight">
                        {{ isset($activeCausesCount) && $activeCausesCount > 0 ? $activeCausesCount . '+' : '5,000+' }}
                    </span>
                    <span class="block text-xs font-medium text-slate-600">Active Causes</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= 3. OUR CAMPAIGNS SECTION ================= -->
<section class="py-14 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-section-heading
            eyebrow="OUR CAMPAIGNS"
            title="Support Causes That Change Lives"
            subtitle="Your small contribution can make a big difference. Choose a campaign and be a part of real change."
            align="center"
            actionText="View All Campaigns"
            :actionUrl="$campaignsUrl"
            data-reveal
        />

        <!-- 3-Column Campaigns Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
            @if(isset($urgentCampaigns) && $urgentCampaigns->count() > 0)
                @foreach($urgentCampaigns as $index => $campaign)
                    <x-campaign-card
                        :title="$campaign->title"
                        :category="$campaign->category->name ?? 'Relief Cause'"
                        :description="$campaign->short_description"
                        :image="$campaign->thumbnail_image ? asset('storage/' . $campaign->thumbnail_image) : $fallbackCampaigns[$index % 3]['image']"
                        :raised="$campaign->raised_amount"
                        :goal="$campaign->goal_amount"
                        :percentage="$campaign->progress_percentage"
                        :donateUrl="Route::has('donate.index') ? route('donate.index', ['campaign' => $campaign->slug]) : $donateUrl"
                        :detailUrl="Route::has('campaigns.show') ? route('campaigns.show', $campaign->slug) : $campaignsUrl"
                        :isUrgent="(bool) $campaign->is_urgent"
                        data-reveal
                        data-reveal-delay="{{ $index * 100 }}"
                    />
                @endforeach
            @else
                @foreach($fallbackCampaigns as $index => $item)
                    <x-campaign-card
                        :title="$item['title']"
                        :category="$item['category']"
                        :description="$item['description']"
                        :image="$item['image']"
                        :raised="$item['raised']"
                        :goal="$item['goal']"
                        :percentage="$item['percentage']"
                        :donateUrl="$item['donateUrl']"
                        :detailUrl="$item['detailUrl']"
                        data-reveal
                        data-reveal-delay="{{ $index * 100 }}"
                    />
                @endforeach
            @endif
        </div>

    </div>
</section>

<!-- ================= 4. ABOUT US 3-COLUMN ASYMMETRIC SECTION ================= -->
<section class="py-10 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">

            <!-- Left (5 Cols): Video Image Card + Overlapping Tilted Brush Badge -->
            <div class="lg:col-span-5 relative pb-6 sm:pb-8" data-reveal>
                <div class="relative rounded-3xl overflow-hidden shadow-lg aspect-4/3 bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1542810634-71277d95dcbb?auto=format&fit=crop&w=1000&q=80"
                         alt="Children smiling together"
                         loading="lazy"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/15 flex items-center justify-center">
                        <button @click="videoModalOpen = true"
                                type="button"
                                aria-label="Watch About Video"
                                class="w-14 h-14 rounded-full bg-white/30 backdrop-blur-md border-2 border-white flex items-center justify-center text-white shadow-xl hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Overlapping Tilted Green Brush Badge -->
                <div class="brush-badge absolute -bottom-1 right-4 sm:right-6 px-6 py-2.5 text-white -rotate-3 select-none">
                    <p class="font-script text-2xl sm:text-3xl leading-none font-bold tracking-wide">
                        Real People <br>Real Change <span class="text-emerald-200">🌿</span>
                    </p>
                </div>
            </div>

            <!-- Middle (4 Cols): Story Copy -->
            <div class="lg:col-span-4 space-y-4" data-reveal data-reveal-delay="100">
                <span class="block text-xs font-extrabold uppercase tracking-[0.18em] text-[#16a34a]">
                    ABOUT US
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Creating Opportunities for a Better Tomorrow
                </h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    {{ $ngoName }} is a non-profit organization working towards education, health, environmental sustainability and community development. We believe in a world where every individual gets equal opportunities to live a healthy, educated and dignified life.
                </p>
                <div class="pt-1">
                    <a href="{{ $aboutUrl }}"
                       class="inline-flex items-center gap-1.5 text-sm font-extrabold text-[#16a34a] hover:text-[#15803d] group">
                        <span>Know More About Us</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Right (3 Cols): 3 Stacked Mission / Vision / Values Cards -->
            <div class="lg:col-span-3 space-y-3.5" data-reveal data-reveal-delay="200">
                <!-- Our Mission -->
                <div class="bg-[#f4fbf6] rounded-2xl p-4 border border-[#dcfce7] flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold text-slate-900">Our Mission</h4>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">To empower underprivileged communities.</p>
                    </div>
                </div>

                <!-- Our Vision -->
                <div class="bg-[#f4fbf6] rounded-2xl p-4 border border-[#dcfce7] flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold text-slate-900">Our Vision</h4>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">A healthier, educated and more equal society.</p>
                    </div>
                </div>

                <!-- Our Values -->
                <div class="bg-[#f4fbf6] rounded-2xl p-4 border border-[#dcfce7] flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold text-slate-900">Our Values</h4>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Integrity, Transparency, Compassion, Impact.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= 5. ROUNDED MINT TRANSPARENCY CONTAINER ================= -->
<section class="py-10 lg:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#eef8f1] rounded-3xl p-6 sm:p-8 lg:p-10 border border-[#d8f3df]" data-reveal>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

                <!-- Left (4 Cols): Transparency Copy & CTA -->
                <div class="lg:col-span-4 space-y-4">
                    <span class="block text-xs font-extrabold uppercase tracking-[0.18em] text-[#16a34a]">
                        TRANSPARENCY
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Your Trust Drives Real Impact
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        We maintain complete transparency in every donation and expense. See how your support is creating change on the ground.
                    </p>
                    <div class="pt-2">
                        <a href="{{ $transparencyUrl }}"
                           class="inline-flex items-center gap-2 rounded-xl bg-[#16a34a] hover:bg-[#15803d] text-white text-sm font-bold px-6 py-3.5 shadow-md transition-all duration-300 group">
                            <span>View Full Transparency</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Right (8 Cols): 3 Metric Cards + 3-Image Ground Proof Carousel -->
                <div class="lg:col-span-8 space-y-5">

                    <!-- Top Row: 3 White Summary Metric Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Card 1: Total Donations -->
                        <div class="bg-white rounded-2xl p-4 border border-emerald-100/80 shadow-2xs flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-xl bg-amber-50 border border-amber-200/60 text-amber-500 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                            </div>
                            <div>
                                <span class="block text-[11px] font-semibold text-slate-400">Total Donations</span>
                                <span class="block text-base sm:text-lg font-extrabold text-slate-900">
                                    ₹{{ isset($totalRaised) && $totalRaised > 0 ? number_format($totalRaised) : '2,84,50,000' }}
                                </span>
                            </div>
                        </div>

                        <!-- Card 2: Total Distributed -->
                        <div class="bg-white rounded-2xl p-4 border border-emerald-100/80 shadow-2xs flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-xl bg-amber-50 border border-amber-200/60 text-amber-500 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                            </div>
                            <div>
                                <span class="block text-[11px] font-semibold text-slate-400">Total Distributed</span>
                                <span class="block text-base sm:text-lg font-extrabold text-slate-900">
                                    ₹{{ isset($totalDistributed) && $totalDistributed > 0 ? number_format($totalDistributed) : '2,10,75,000' }}
                                </span>
                            </div>
                        </div>

                        <!-- Card 3: Active Projects -->
                        <div class="bg-white rounded-2xl p-4 border border-emerald-100/80 shadow-2xs flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-xl bg-[#eef8f1] border border-[#bbf7d0] text-[#16a34a] flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <span class="block text-[11px] font-semibold text-slate-400">Active Projects</span>
                                <span class="block text-base sm:text-lg font-extrabold text-slate-900">
                                    {{ isset($activeCausesCount) && $activeCausesCount > 0 ? $activeCausesCount : '25' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Row: 3-Image Ground Proof Carousel with Left/Right Arrows -->
                    @php
                        $proofItems = [
                            ['label' => 'Food Distribution', 'image' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=600&q=80'],
                            ['label' => 'Education Support', 'image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=600&q=80'],
                            ['label' => 'Tree Plantation', 'image' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=600&q=80'],
                        ];
                    @endphp

                    <div class="relative">
                        <!-- Left Arrow -->
                        <button type="button"
                                aria-label="Previous Proof"
                                onclick="document.getElementById('proof-carousel').scrollBy({left: -260, behavior: 'smooth'})"
                                class="hidden sm:flex absolute -left-4 top-12 z-10 w-9 h-9 rounded-full bg-white border border-slate-200 shadow-md items-center justify-center text-slate-600 hover:text-[#16a34a] transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </button>

                        <div id="proof-carousel" class="grid grid-cols-1 sm:grid-cols-3 gap-4 overflow-x-auto no-scrollbar">
                            @if(isset($recentDistributions) && $recentDistributions->count() >= 3)
                                @foreach($recentDistributions->take(3) as $idx => $dist)
                                    <a href="{{ $transparencyUrl }}" class="group block">
                                        <div class="h-32 rounded-xl overflow-hidden bg-white shadow-xs">
                                            <img src="{{ $proofItems[$idx % 3]['image'] }}"
                                                 alt="{{ $dist->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                        <p class="mt-2 text-xs font-bold text-slate-700 flex items-center gap-1">
                                            <span class="text-[#16a34a] font-extrabold">+</span> {{ $dist->title }}
                                        </p>
                                    </a>
                                @endforeach
                            @else
                                @foreach($proofItems as $proof)
                                    <a href="{{ $transparencyUrl }}" class="group block">
                                        <div class="h-32 rounded-xl overflow-hidden bg-white shadow-xs">
                                            <img src="{{ $proof['image'] }}"
                                                 alt="{{ $proof['label'] }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                        <p class="mt-2 text-xs font-bold text-slate-700 flex items-center gap-1">
                                            <span class="text-[#16a34a] font-extrabold">+</span> {{ $proof['label'] }}
                                        </p>
                                    </a>
                                @endforeach
                            @endif
                        </div>

                        <!-- Right Arrow -->
                        <button type="button"
                                aria-label="Next Proof"
                                onclick="document.getElementById('proof-carousel').scrollBy({left: 260, behavior: 'smooth'})"
                                class="hidden sm:flex absolute -right-4 top-12 z-10 w-9 h-9 rounded-full bg-white border border-slate-200 shadow-md items-center justify-center text-slate-600 hover:text-[#16a34a] transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>

<!-- ================= 6. DARK FOREST VOLUNTEER BANNER ================= -->
<section class="relative bg-[#0a2617] text-white py-14 lg:py-16 overflow-hidden">
    <!-- Subtle Background Volunteer Photo Overlay -->
    <div class="absolute inset-0 z-0 opacity-20 mix-blend-luminosity">
        <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?auto=format&fit=crop&w=1800&q=80"
             alt="Volunteers in green t-shirts"
             class="w-full h-full object-cover">
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

            <!-- Left (7 Cols): Callout & Buttons -->
            <div class="lg:col-span-7 space-y-4" data-reveal>
                <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight">
                    Join Our Volunteer Community
                </h2>
                <p class="text-sm sm:text-base text-slate-200/90 max-w-xl leading-relaxed">
                    Be a part of our journey and contribute your time, skills and passion to create a better society.
                </p>
                <div class="pt-2 flex flex-wrap items-center gap-3.5">
                    <a href="{{ $volunteerUrl }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-[#16a34a] hover:bg-[#15803d] text-white text-sm font-bold px-6 py-3.5 shadow-lg transition-all duration-300 group">
                        <span>Become a Volunteer</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                    <a href="{{ $aboutUrl }}"
                       class="inline-flex items-center justify-center rounded-xl bg-white/5 hover:bg-white/15 border border-white/30 text-white text-sm font-semibold px-6 py-3.5 transition-colors">
                        Learn More
                    </a>
                </div>
            </div>

            <!-- Right (5 Cols): 3 Glassmorphic Role Badges -->
            <div class="lg:col-span-5 grid grid-cols-3 gap-4" data-reveal data-reveal-delay="150">
                <div class="flex flex-col items-center text-center space-y-2.5">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-[#4ade80]">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold text-white/95 leading-snug">Community <br>Support</span>
                </div>

                <div class="flex flex-col items-center text-center space-y-2.5">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-[#4ade80]">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold text-white/95 leading-snug">Education <br>Programs</span>
                </div>

                <div class="flex flex-col items-center text-center space-y-2.5">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-[#4ade80]">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold text-white/95 leading-snug">Environmental <br>Activities</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= UPCOMING COMMUNITY DRIVES & EVENTS ================= -->
@if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
<section class="py-14 bg-[#fcfdfc] border-y border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-section-heading
            eyebrow="COMMUNITY DRIVES"
            title="Upcoming Community Relief Drives & Events"
            subtitle="Join our ground volunteer forces in Varanasi and nearby districts to create real impact."
            align="left"
            actionText="View All Events"
            :actionUrl="Route::has('events.index') ? route('events.index') : url('/events')"
            data-reveal
        />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6" data-reveal data-reveal-delay="100">
            @foreach($upcomingEvents as $event)
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="text-xs font-bold text-[#16a34a] bg-[#f0fdf4] px-3 py-1 rounded-full">
                                {{ $event->event_date?->format('d M Y') }}
                            </span>
                            <span class="text-xs text-slate-500 font-semibold">
                                {{ $event->location_name }}
                            </span>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900 group-hover:text-[#16a34a] transition-colors line-clamp-1 mb-2">
                            {{ $event->title }}
                        </h3>
                        <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                            {{ $event->description }}
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500 truncate max-w-[180px]">{{ $event->address }}</span>
                        <a href="{{ Route::has('events.show') ? route('events.show', $event->slug) : url('/events/' . $event->slug) }}"
                           class="font-bold text-[#16a34a] hover:underline inline-flex items-center gap-1">
                            RSVP &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ================= 7. TESTIMONIALS ("STORIES OF HOPE") ================= -->
<section class="pt-14 pb-8 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-section-heading
            eyebrow="TESTIMONIALS"
            title="Stories of Hope"
            align="left"
            actionText="View All"
            :actionUrl="$aboutUrl"
            data-reveal
        />

        @php
            $activeTestimonials = \App\Models\Testimonial::active()->take(3)->get();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-reveal data-reveal-delay="100">
            @forelse($activeTestimonials as $t)
                <x-testimonial-card
                    :quote="$t->quote"
                    :name="$t->name"
                    :role="$t->role ?? 'Supporter'"
                    :avatar="$t->avatar ? (str_starts_with($t->avatar, 'http') ? $t->avatar : asset('storage/' . $t->avatar)) : 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&q=80'"
                />
            @empty
                <x-testimonial-card
                    quote="Hope Foundation changed my child's life. Today she is in school and dreams of becoming a doctor."
                    name="Ritika Sharma"
                    role="Parent"
                    avatar="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&q=80"
                />
                <x-testimonial-card
                    quote="Their medical camps are a blessing for our village. We got proper treatment and support."
                    name="Suresh Kumar"
                    role="Community Member"
                    avatar="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80"
                />
                <x-testimonial-card
                    quote="I volunteer with Hope Foundation and it has been the most rewarding experience of my life."
                    name="Anjali Verma"
                    role="Volunteer"
                    avatar="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80"
                />
            @endforelse
        </div>

    </div>
</section>

<!-- ================= 8. LATEST UPDATES ("NEWS & STORIES") ================= -->
<section class="py-10 pb-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <x-section-heading
            eyebrow="LATEST UPDATES"
            title="News & Stories"
            align="left"
            actionText="View All"
            :actionUrl="$eventsUrl"
            data-reveal
        />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-reveal data-reveal-delay="100">
            @if(isset($upcomingEvents) && $upcomingEvents->count() >= 3)
                @foreach($upcomingEvents->take(3) as $event)
                    <x-news-card
                        :title="$event->title"
                        :date="$event->event_date ? $event->event_date->format('d M Y') : '15 Nov 2026'"
                        :image="$event->banner_image ? asset('storage/' . $event->banner_image) : 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=400&q=80'"
                        :url="Route::has('events.show') ? route('events.show', $event->slug) : $eventsUrl"
                    />
                @endforeach
            @else
                <x-news-card
                    title="Free Health Checkup Camp Held in Varanasi"
                    date="15 Nov 2026"
                    image="https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=400&q=80"
                    :url="$eventsUrl"
                />
                <x-news-card
                    title="New School Supplies Distributed"
                    date="10 Nov 2026"
                    image="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=400&q=80"
                    :url="$eventsUrl"
                />
                <x-news-card
                    title="Tree Plantation Drive with Local Community"
                    date="05 Nov 2026"
                    image="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=400&q=80"
                    :url="$eventsUrl"
                />
            @endif
        </div>

    </div>
</section>
@endsection