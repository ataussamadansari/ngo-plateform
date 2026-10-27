@extends('layouts.base')

@section('title', $campaign->title . ' - ' . (function_exists('setting') ? setting('ngo_name', 'Hope Foundation') : 'Hope Foundation'))

@section('content')
@php
    $title = $campaign->title ?? 'Education for Every Child';
    $categoryName = $campaign->category ? $campaign->category->name : 'Education';
    $raised = (float) ($campaign->raised_amount ?? 0);
    $goal = (float) ($campaign->goal_amount ?? 100000);
    $progress = (float) ($campaign->progress_percentage ?? ($goal > 0 ? min(100, round(($raised / $goal) * 100, 1)) : 0));

    // Calculate days left
    $daysLeft = 42;
    if (!empty($campaign->end_date)) {
        $days = (int) now()->diffInDays(\Carbon\Carbon::parse($campaign->end_date), false);
        $daysLeft = max(0, $days);
    }

    $heroImage = !empty($campaign->thumbnail_image)
        ? (str_starts_with($campaign->thumbnail_image, 'http') ? $campaign->thumbnail_image : asset('storage/' . $campaign->thumbnail_image))
        : 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=2200&q=90';

    $galleryPhotos = collect($campaign->gallery_images ?? [
        'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=900&q=85',
        'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?auto=format&fit=crop&w=900&q=85',
        'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=900&q=85',
        'https://images.unsplash.com/photo-1472162072942-cd5147eb3902?auto=format&fit=crop&w=900&q=85',
    ])->map(fn ($img) => is_string($img) && str_starts_with($img, 'http') ? $img : asset('storage/' . $img));

    // Preset amounts for donation card
    $presetAmounts = [500, 1000, 2000, 5000, 10000];

    // Key Highlights (JSON from campaign or default 4 pillars)
    $keyHighlights = $campaign->key_highlights ?? [
        'School Admission Support',
        'Books & Learning Materials',
        'Uniforms & School Facilities',
        'Mentoring & Career Guidance',
    ];
    $highlightIcons = ['🎓', '📖', '👕', '👥'];

    // Impact Stories (JSON from campaign or default stories matching mockup)
    $impactStories = $campaign->impact_stories ?? [
        [
            'name' => 'Ayesha, 10th Grade',
            'quote' => 'Because of this support, I can continue my education and dream of becoming a doctor one day. Thank you!',
            'photo' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=300&q=80',
        ],
        [
            'name' => 'Rahul, 8th Grade',
            'quote' => 'I received school books and a uniform. Now I can attend school regularly and focus on my studies.',
            'photo' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=300&q=80',
        ],
    ];

    // FAQ Items (JSON or default questions)
    $faqs = $campaign->faq_items ?? [
        [
            'question' => 'Is my donation tax exempt?',
            'answer' => 'Yes, donations to this campaign are 100% tax exempt under Section 80G of the Indian Income Tax Act. An official digital receipt is issued immediately upon verification.',
        ],
        [
            'question' => 'How can I track the utilization of my donation?',
            'answer' => 'We maintain a 100% transparent public ledger with scanned GST vendor bills, utilization dates, and geotagged impact photos under the Transparency section.',
        ],
        [
            'question' => 'What payment methods are supported without fees?',
            'answer' => 'You can donate via Dynamic UPI QR code (Google Pay, PhonePe, Paytm, BHIM) or Direct Bank NEFT/RTGS with zero gateway deduction fees.',
        ],
    ];

    // Content HTML handling (fixes raw <p><strong> tags issue)
    $storyHtml = $campaign->full_story ?? $campaign->short_description ?? '';
    $hasHtmlTags = strip_tags($storyHtml) !== $storyHtml;
@endphp

<!-- ================= HERO SECTION ================= -->
<section class="relative isolate overflow-hidden bg-[#041f13] text-white">
    <!-- Background Image with Forest Depth Gradient Overlay -->
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <img src="{{ $heroImage }}"
             alt="{{ $title }}"
             class="h-full w-full object-cover object-[center_35%] opacity-40 mix-blend-luminosity brightness-110 contrast-105 sm:opacity-50">
        <!-- Dual Layer Gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#031b10] via-[#052819]/90 to-[#041f13]/40"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#031b10] via-transparent to-transparent opacity-80"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8 lg:pb-28 lg:pt-14">
        <!-- Breadcrumbs Navigation -->
        <nav aria-label="Breadcrumb" class="mb-4 flex flex-wrap items-center gap-1.5 text-xs font-medium text-emerald-100/80">
            <a href="{{ url('/') }}" class="hover:text-white transition">Home</a>
            <span aria-hidden="true">›</span>
            <a href="{{ route('campaigns.index') }}" class="hover:text-white transition">Campaigns</a>
            <span aria-hidden="true">›</span>
            <span aria-current="page" class="text-emerald-300 truncate max-w-xs sm:max-w-md">{{ $title }}</span>
        </nav>

        <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
            <!-- Left: Hero Headline, Eyebrow & Badges -->
            <div class="lg:col-span-8">
                <!-- Category Pill -->
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/95 backdrop-blur-xs px-3.5 py-1 text-xs font-bold text-emerald-800 shadow-sm border border-white/20">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                    {{ $categoryName }}
                </span>

                <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl leading-[1.15]">
                    {{ $title }}
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-relaxed text-emerald-50/90 sm:text-base">
                    {{ $campaign->short_description ?? 'Help provide quality education, books and school facilities to underprivileged children.' }}
                </p>

                <!-- 3 Trust Accreditations -->
                <div class="mt-4 flex flex-wrap items-center gap-3 text-xs font-semibold text-white/95">
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-white/15 bg-white/10 px-3 py-1">
                        <svg class="h-3.5 w-3.5 text-[#4ade80]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Verified Campaign</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-white/15 bg-white/10 px-3 py-1">
                        <svg class="h-3.5 w-3.5 text-[#4ade80]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>80G Eligible</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-white/15 bg-white/10 px-3 py-1">
                        <span class="text-[#4ade80] font-bold">₹</span>
                        <span>Tax Benefit Available</span>
                    </span>
                </div>
            </div>

            <!-- Right: Handwritten Script Badge (Desktop Only per Mockup) -->
            <div class="hidden lg:flex lg:col-span-4 justify-end">
                <div class="transform -rotate-6 text-center select-none pointer-events-none pr-8 pt-2">
                    <p class="font-script text-3xl xl:text-4xl font-normal leading-tight text-white drop-shadow-md">
                        Every<br>
                        Child<br>
                        Deserves<br>
                        a Chance <span class="inline-block text-2xl xl:text-3xl text-[#4ade80]">💚</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= MAIN CONTENT + FLOATING DONATION CARD ================= -->
<div class="bg-[#f8fafc] py-6 sm:py-8 lg:py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-12">

            <!-- ================= LEFT COLUMN: NARRATIVE & CONTENT ================= -->
            <div class="space-y-8 lg:col-span-8">

                <!-- Sticky Anchor Navigation Bar -->
                <nav aria-label="Campaign sections"
                     class="sticky top-20 z-30 -mx-4 sm:mx-0 flex items-center gap-2 overflow-x-auto bg-[#f8fafc]/95 backdrop-blur-md px-4 sm:px-0 py-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden border-b border-slate-200/80">
                    <a href="#overview" class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl bg-[#16a34a] px-4 text-xs font-bold text-white shadow-xs">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Overview</span>
                    </a>
                    <a href="#impact" class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border border-slate-200/90 bg-white px-4 text-xs font-bold text-slate-700 hover:border-emerald-500 hover:text-emerald-700 transition shadow-xs">
                        <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span>Our Impact</span>
                    </a>
                    <a href="#updates" class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border border-slate-200/90 bg-white px-4 text-xs font-bold text-slate-700 hover:border-emerald-500 hover:text-emerald-700 transition shadow-xs">
                        <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <span>Updates</span>
                    </a>
                    <a href="#gallery" class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border border-slate-200/90 bg-white px-4 text-xs font-bold text-slate-700 hover:border-emerald-500 hover:text-emerald-700 transition shadow-xs">
                        <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Gallery</span>
                    </a>
                    <a href="#faqs" class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border border-slate-200/90 bg-white px-4 text-xs font-bold text-slate-700 hover:border-emerald-500 hover:text-emerald-700 transition shadow-xs">
                        <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>FAQs</span>
                    </a>
                </nav>

                <!-- 1. About This Campaign Section (#overview) -->
                <section id="overview" aria-labelledby="overview-heading" class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-[0_4px_25px_rgba(15,23,42,0.04)] scroll-mt-28">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                        <!-- Left Story (Takes 7 Cols on Desktop) -->
                        <div class="md:col-span-7">
                            <h2 id="overview-heading" class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                                About This Campaign
                            </h2>

                            <!-- Dynamic Story Narrative (Supports ALL Filament RichEditor formats: headings, lists, tables, images, blockquotes, code, highlights, links) -->
                            <div class="mt-3 leading-relaxed">
                                @if($hasHtmlTags)
                                    <div class="rich-story-content prose prose-slate max-w-none text-slate-700">
                                        {!! $storyHtml !!}
                                    </div>
                                @else
                                    <div class="rich-story-content space-y-3 text-slate-600">
                                        {!! nl2br(e($storyHtml)) !!}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Right: Story Video Card (Takes 5 Cols on Desktop) -->
                        <div class="md:col-span-5">
                            <div class="relative h-48 sm:h-56 w-full overflow-hidden rounded-2xl border border-slate-200/80 bg-slate-900 shadow-sm group">
                                <img src="{{ $heroImage }}"
                                     alt="Video story thumbnail"
                                     class="h-full w-full object-cover transition duration-500 group-hover:scale-105 opacity-85">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>

                                <!-- Center Play Button -->
                                <button type="button"
                                        @click="videoModalOpen = true"
                                        class="absolute inset-0 m-auto h-12 w-12 rounded-full bg-white/90 backdrop-blur-xs text-emerald-600 flex items-center justify-center shadow-lg hover:scale-110 transition cursor-pointer"
                                        aria-label="Play Campaign Video">
                                    <svg class="h-6 w-6 ml-0.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </button>

                                <!-- Bottom Badge CTA -->
                                <button type="button"
                                        @click="videoModalOpen = true"
                                        class="absolute bottom-3 right-3 rounded-xl bg-[#16a34a] hover:bg-[#15803d] text-white text-xs font-bold px-3 py-2 flex items-center gap-1.5 shadow-sm transition">
                                    <span>▶ Watch Our Story</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Key Highlights (4 Pillars matching Mockup) -->
                    <div class="mt-8 rounded-2xl bg-[#ecfdf5]/70 border border-emerald-100 p-4 sm:p-5">
                        <h3 class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-emerald-900 mb-3">
                            Key Highlights
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            @foreach($keyHighlights as $index => $highlight)
                                @php
                                    $highlightTitle = is_array($highlight) ? ($highlight['title'] ?? $highlight['text'] ?? '') : $highlight;
                                    $icon = $highlightIcons[$index % count($highlightIcons)];
                                @endphp
                                <div class="flex items-center gap-3 rounded-xl bg-white p-3 border border-slate-100 shadow-2xs">
                                    <span class="text-2xl shrink-0">{{ $icon }}</span>
                                    <span class="text-xs font-bold text-slate-800 leading-snug">{{ $highlightTitle }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <!-- 2. Audited Ground Relief Section (Public Ledger & Bills) -->
                @if(isset($fundDistributions) && $fundDistributions->count())
                    <section class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block mb-0.5">Audited Financials</span>
                                <h3 class="text-lg sm:text-xl font-bold text-slate-900">Fund Utilization & Ground Impact</h3>
                            </div>
                            <a href="{{ route('campaigns.transparency', $campaign->slug) }}"
                               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition border border-emerald-200/60">
                                <span>View Public Ledger & Bills</span>
                                <span aria-hidden="true">→</span>
                            </a>
                        </div>

                        <div class="mt-4 space-y-2.5">
                            @foreach($fundDistributions as $dist)
                                <div class="flex items-center justify-between p-3 rounded-xl border border-slate-100 bg-slate-50/60 text-xs">
                                    <div>
                                        <span class="font-bold text-slate-800 block text-sm">{{ $dist->title }}</span>
                                        <span class="text-[11px] text-slate-500">{{ $dist->beneficiary_name }} &bull; {{ $dist->distribution_date ? $dist->distribution_date->format('d M Y') : '' }}</span>
                                    </div>
                                    <span class="font-mono font-bold text-slate-900 text-sm">₹{{ number_format($dist->amount_spent, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- 3. Impact Stories Section (#impact) -->
                <section id="impact" aria-labelledby="impact-heading" class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-[0_4px_25px_rgba(15,23,42,0.04)] scroll-mt-28">
                    <h2 id="impact-heading" class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight mb-4">
                        Impact Stories
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($impactStories as $story)
                            <article class="flex gap-4 items-start rounded-2xl border border-slate-200/80 bg-slate-50/50 p-4 hover:bg-slate-50 transition">
                                <img src="{{ !empty($story['photo']) ? (str_starts_with($story['photo'], 'http') ? $story['photo'] : asset('storage/' . $story['photo'])) : 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=200&q=80' }}"
                                     alt="{{ $story['name'] }}"
                                     loading="lazy"
                                     class="h-20 w-20 sm:h-22 sm:w-22 rounded-xl object-cover shrink-0 border border-slate-200 bg-slate-200 shadow-2xs">
                                <div class="min-w-0">
                                    <p class="text-xs sm:text-[13px] text-slate-600 leading-relaxed italic">
                                        “{{ $story['quote'] }}”
                                    </p>
                                    <p class="mt-2 text-xs font-extrabold text-slate-900">
                                        — {{ $story['name'] }}
                                    </p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <!-- 4. Recent Verified Donors Stream -->
                @if(isset($recentDonations) && $recentDonations->count())
                    <section class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div>
                                <h3 class="text-base sm:text-lg font-bold text-slate-900">Recent Verified Donors ({{ $donorsCount ?? $recentDonations->count() }})</h3>
                                <p class="text-xs text-slate-500">Bank verified community contributions</p>
                            </div>
                            <span class="inline-flex items-center rounded-full bg-[#dcfce7] px-3 py-1 text-xs font-semibold text-[#15803d]">
                                100% Reconciled
                            </span>
                        </div>

                        <div class="mt-4 space-y-2.5">
                            @foreach($recentDonations as $donation)
                                <div class="flex items-start justify-between p-3 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-slate-50 transition">
                                    <div class="flex items-start gap-3">
                                        <div class="h-9 w-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                                            {{ substr($donation->is_anonymous ? 'A' : $donation->donor_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="text-xs sm:text-sm font-bold text-slate-900 block">
                                                {{ $donation->is_anonymous ? 'Anonymous Supporter' : $donation->donor_name }}
                                            </span>
                                            <span class="text-[11px] text-slate-400 block">{{ $donation->created_at->diffForHumans() }}</span>
                                            @if($donation->donor_message)
                                                <p class="text-xs text-slate-600 italic mt-0.5">"{{ $donation->donor_message }}"</p>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="font-mono font-bold text-slate-900 text-xs sm:text-sm">
                                        ₹{{ number_format($donation->amount, 2) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- 5. Campaign Updates Section (#updates) -->
                <section id="updates" aria-labelledby="updates-heading" class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-[0_4px_25px_rgba(15,23,42,0.04)] scroll-mt-28">
                    <h2 id="updates-heading" class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight mb-3">
                        Campaign Updates
                    </h2>
                    <div class="rounded-xl border border-slate-200/80 bg-slate-50/60 p-4 text-xs sm:text-sm leading-relaxed text-slate-600">
                        <p class="font-semibold text-slate-800 mb-1">Latest Field Verification Report</p>
                        Your contribution helps us provide essential learning materials, school supplies and ongoing educational support directly to children in verified need. Check back for real-time field receipts and utilization entries.
                    </div>
                </section>

                <!-- 6. Gallery Section (#gallery) -->
                <section id="gallery" aria-labelledby="gallery-heading" class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-[0_4px_25px_rgba(15,23,42,0.04)] scroll-mt-28">
                    <div class="flex items-center justify-between mb-4">
                        <h2 id="gallery-heading" class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                            Gallery
                        </h2>
                        <a href="#gallery" class="text-xs sm:text-sm font-bold text-[#16a34a] hover:text-[#15803d] transition">
                            View All Photos →
                        </a>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach($galleryPhotos->take(4) as $photoUrl)
                            <a href="{{ $photoUrl }}" target="_blank" rel="noopener" class="group h-32 sm:h-36 overflow-hidden rounded-2xl bg-slate-100 shadow-2xs block">
                                <img src="{{ $photoUrl }}"
                                     alt="Campaign field photo"
                                     loading="lazy"
                                     class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            </a>
                        @endforeach
                    </div>
                </section>

                <!-- 7. Frequently Asked Questions (#faqs) -->
                <section id="faqs" aria-labelledby="faqs-heading" class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-[0_4px_25px_rgba(15,23,42,0.04)] scroll-mt-28">
                    <h2 id="faqs-heading" class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight mb-4">
                        Frequently Asked Questions
                    </h2>

                    <div class="divide-y divide-slate-100">
                        @foreach($faqs as $faq)
                            <details class="group py-3.5" @if($loop->first) open @endif>
                                <summary class="flex items-center justify-between cursor-pointer font-bold text-xs sm:text-sm text-slate-900 list-none">
                                    <span>{{ $faq['question'] }}</span>
                                    <span class="transition group-open:rotate-180 text-slate-400">▾</span>
                                </summary>
                                <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed pr-4">
                                    {{ $faq['answer'] }}
                                </p>
                            </details>
                        @endforeach
                    </div>
                </section>

                <!-- 8. More Campaigns You Might Like -->
                @if(isset($relatedCampaigns) && $relatedCampaigns->isNotEmpty())
                    <section aria-labelledby="related-heading" class="pt-2">
                        <div class="flex items-center justify-between mb-4">
                            <h2 id="related-heading" class="text-lg sm:text-xl font-bold text-slate-900">
                                More Campaigns You Might Like
                            </h2>
                            <a href="{{ route('campaigns.index') }}" class="text-xs sm:text-sm font-semibold text-[#16a34a] hover:text-[#15803d] transition">
                                View All Campaigns →
                            </a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @foreach($relatedCampaigns->take(3) as $related)
                                @php
                                    $relRaised = (float) ($related->raised_amount ?? 0);
                                    $relGoal = (float) ($related->goal_amount ?? 100000);
                                    $relProg = $relGoal > 0 ? min(100, round(($relRaised / $relGoal) * 100)) : 0;
                                    $relImage = !empty($related->thumbnail_image)
                                        ? (str_starts_with($related->thumbnail_image, 'http') ? $related->thumbnail_image : asset('storage/' . $related->thumbnail_image))
                                        : 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=400&q=80';
                                @endphp
                                <article class="flex flex-col rounded-2xl border border-slate-200/90 bg-white p-3 shadow-xs hover:shadow-md transition">
                                    <img src="{{ $relImage }}"
                                         alt="{{ $related->title }}"
                                         loading="lazy"
                                         class="h-28 w-full rounded-xl object-cover mb-2.5">
                                    <h3 class="text-xs font-bold text-slate-900 line-clamp-1 hover:text-emerald-700">
                                        <a href="{{ route('campaigns.show', $related->slug) }}">{{ $related->title }}</a>
                                    </h3>
                                    <p class="text-[11px] text-slate-500 line-clamp-2 mt-0.5 leading-snug">
                                        {{ $related->short_description }}
                                    </p>
                                    <div class="mt-3 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                                        <span class="font-extrabold text-slate-900">₹{{ number_format($relRaised, 0) }}</span>
                                        <span class="text-slate-500 font-bold">{{ $relProg }}%</span>
                                    </div>
                                    <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden mt-1">
                                        <div class="h-full rounded-full bg-[#16a34a]" style="width: {{ $relProg }}%"></div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif

            </div>

            <!-- ================= RIGHT COLUMN: OVERLAPPING STICKY DONATION CARD & INFO ================= -->
            <aside class="space-y-6 lg:col-span-4 lg:-mt-44 z-20 sticky top-24" aria-label="Donation checkout and campaign information">

                <!-- 1. Floating Donation Checkout Card (Matches Mockup) -->
                <div id="donate" class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-6 shadow-[0_12px_40px_rgba(15,23,42,0.12)]">
                    <!-- Raised Amount & Percentage Header -->
                    <div class="flex items-baseline justify-between gap-2">
                        <div>
                            <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                                ₹{{ number_format($raised, 0) }}
                            </p>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">
                                raised of ₹{{ number_format($goal, 0) }}
                            </p>
                            <span class="sr-only">{{ number_format($raised, 2) }} of {{ number_format($goal, 2) }}</span>
                        </div>
                        <span class="text-sm font-extrabold text-slate-800">
                            {{ $progress }}%
                        </span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-3 h-2.5 w-full overflow-hidden rounded-full bg-slate-100" role="progressbar" aria-valuenow="{{ (int)$progress }}" aria-valuemin="0" aria-valuemax="100">
                        <div class="h-full rounded-full bg-[#16a34a] transition-all duration-700 ease-out" style="width: {{ $progress }}%"></div>
                    </div>

                    <!-- 3-Column Stats Row -->
                    <div class="mt-4 grid grid-cols-3 divide-x divide-emerald-200/60 rounded-xl bg-[#ecfdf5]/80 border border-emerald-100/80 py-2.5 text-center">
                        <div>
                            <p class="text-base font-extrabold text-slate-900">{{ number_format($donorsCount ?? 245) }}</p>
                            <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">Donors</p>
                        </div>
                        <div>
                            <p class="text-base font-extrabold text-slate-900">{{ $daysLeft }}</p>
                            <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">Days Left</p>
                        </div>
                        <div>
                            <p class="text-base font-extrabold text-slate-900">₹{{ number_format(max(0, $goal - $raised), 0) }}</p>
                            <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">Still Needed</p>
                        </div>
                    </div>

                    <!-- Make a Donation Form with Preset Amount Buttons -->
                    <form action="{{ route('donate.index') }}" method="GET" class="mt-5" x-data="{ selectedAmount: 1000, isCustom: false }">
                        <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                        <p class="text-sm font-bold text-slate-900 mb-2.5">Make a Donation</p>

                        <!-- 6 Presets in 2x3 Grid -->
                        <div class="grid grid-cols-3 gap-2">
                            @foreach($presetAmounts as $amt)
                                <button type="button"
                                        @click="selectedAmount = {{ $amt }}; isCustom = false"
                                        :class="{ 'bg-[#16a34a] text-white border-transparent shadow-xs': selectedAmount === {{ $amt }} && !isCustom, 'bg-white border-slate-200 text-slate-700 hover:border-emerald-500': selectedAmount !== {{ $amt }} || isCustom }"
                                        class="py-2.5 px-2 rounded-xl border text-xs font-bold transition text-center cursor-pointer">
                                    ₹{{ number_format($amt) }}
                                </button>
                            @endforeach
                            <button type="button"
                                    @click="isCustom = true"
                                    :class="{ 'bg-[#16a34a] text-white border-transparent shadow-xs': isCustom, 'bg-white border-slate-200 text-slate-700 hover:border-emerald-500': !isCustom }"
                                    class="py-2.5 px-2 rounded-xl border text-xs font-bold transition text-center cursor-pointer">
                                Custom
                            </button>
                        </div>

                        <!-- Amount Input -->
                        <div class="mt-3">
                            <label for="donation-amount-input" class="sr-only">Donation Amount in INR</label>
                            <div class="relative rounded-xl border border-slate-200 bg-slate-50/50 overflow-hidden focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/10">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-sm font-bold text-slate-500">₹</span>
                                <input type="number"
                                       id="donation-amount-input"
                                       name="amount"
                                       min="1"
                                       step="1"
                                       :value="selectedAmount"
                                       @input="selectedAmount = $event.target.value; isCustom = true"
                                       placeholder="Enter custom amount"
                                       required
                                       class="w-full pl-8 pr-4 py-2.5 text-sm font-bold text-slate-900 bg-transparent outline-none">
                            </div>
                        </div>

                        <!-- Primary CTA Button -->
                        <button type="submit"
                                class="mt-3.5 inline-flex w-full min-h-[44px] items-center justify-center gap-2 rounded-xl bg-[#16a34a] hover:bg-[#15803d] active:scale-[0.99] px-4 py-3 text-sm font-bold text-white shadow-sm hover:shadow transition cursor-pointer">
                            <span>Donate Now</span>
                            <span aria-hidden="true">→</span>
                        </button>
                    </form>

                    <!-- Trust Accreditations List -->
                    <div class="mt-5 space-y-3 border-t border-slate-100 pt-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">UPI / Bank Transfer</p>
                                <p class="text-[11px] text-slate-500">Scan QR or use direct bank details</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">80G Tax Benefit</p>
                                <p class="text-[11px] text-slate-500">Get instant receipt for tax exemption</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">100% Transparency</p>
                                <p class="text-[11px] text-slate-500">See how your donation is used on ground</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Campaign Information Card -->
                <div class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-6 shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 mb-3.5 pb-2.5 border-b border-slate-100">
                        Campaign Information
                    </h4>

                    <dl class="space-y-3 text-xs sm:text-[13px]">
                        <div class="flex items-center justify-between">
                            <dt class="flex items-center gap-2 text-slate-500">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                <span>Category</span>
                            </dt>
                            <dd class="font-bold text-slate-800">{{ $categoryName }}</dd>
                        </div>

                        <div class="flex items-center justify-between">
                            <dt class="flex items-center gap-2 text-slate-500">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Started On</span>
                            </dt>
                            <dd class="font-medium text-slate-700">{{ $campaign->start_date ? $campaign->start_date->format('d M Y') : '15 Aug 2025' }}</dd>
                        </div>

                        <div class="flex items-center justify-between">
                            <dt class="flex items-center gap-2 text-slate-500">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Last Date</span>
                            </dt>
                            <dd class="font-medium text-slate-700">{{ $campaign->end_date ? $campaign->end_date->format('d M Y') : '31 Dec 2026' }}</dd>
                        </div>

                        <div class="flex items-center justify-between">
                            <dt class="flex items-center gap-2 text-slate-500">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Location</span>
                            </dt>
                            <dd class="font-medium text-slate-700">{{ $campaign->location ?? 'Uttar Pradesh, India' }}</dd>
                        </div>

                        <div class="flex items-center justify-between">
                            <dt class="flex items-center gap-2 text-slate-500">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <span>Beneficiaries</span>
                            </dt>
                            <dd class="font-medium text-slate-700">{{ $campaign->beneficiary_summary ?? '500+ Children' }}</dd>
                        </div>

                        <div class="flex items-center justify-between">
                            <dt class="flex items-center gap-2 text-slate-500">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <span>Campaign By</span>
                            </dt>
                            <dd class="font-medium text-slate-700">{{ setting('ngo_name', 'Hope Foundation') }}</dd>
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <dt class="flex items-center gap-2 text-slate-500">
                                <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Verified</span>
                            </dt>
                            <dd class="font-bold text-emerald-700">Yes</dd>
                        </div>
                    </dl>
                </div>

                <!-- 3. Share This Campaign Card -->
                <div class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-6 shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 mb-3">
                        Share This Campaign
                    </h4>

                    <div class="flex items-center gap-2.5">
                        <!-- WhatsApp -->
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($title . ' - Support here: ' . url()->current()) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="flex h-9 w-9 items-center justify-center rounded-full bg-[#25D366] text-white hover:scale-105 transition shadow-2xs"
                           title="Share on WhatsApp">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.299.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.303c-.087.087-.179.182-.077.357.101.174.449.741.964 1.201.662.591 1.221.774 1.394.861.173.087.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.043.073.043.419-.101.824z"/></svg>
                        </a>

                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="flex h-9 w-9 items-center justify-center rounded-full bg-[#1877F2] text-white hover:scale-105 transition shadow-2xs"
                           title="Share on Facebook">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>

                        <!-- Twitter / X -->
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($title) }}&url={{ urlencode(url()->current()) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-white hover:scale-105 transition shadow-2xs"
                           title="Share on Twitter / X">
                            <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>

                        <!-- LinkedIn -->
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="flex h-9 w-9 items-center justify-center rounded-full bg-[#0A66C2] text-white hover:scale-105 transition shadow-2xs"
                           title="Share on LinkedIn">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>

                        <!-- Copy Link -->
                        <button type="button"
                                onclick="navigator.clipboard.writeText(window.location.href); alert('Campaign link copied to clipboard!');"
                                class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100 transition shadow-2xs cursor-pointer"
                                title="Copy Campaign Link">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                    </div>

                    <p class="mt-2 text-xs text-slate-500">
                        Help us spread the word and reach more people.
                    </p>
                </div>

            </aside>

        </div>
    </div>
</div>

<!-- ================= STICKY MOBILE DONATE FOOTER BAR ================= -->
<div class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-slate-200 p-3 z-40 sm:hidden flex items-center justify-between gap-3 shadow-lg">
    <div>
        <p class="text-[11px] text-slate-500 font-medium">Raised of ₹{{ number_format($goal, 0) }}</p>
        <p class="text-sm font-extrabold text-slate-900">₹{{ number_format($raised, 0) }} ({{ $progress }}%)</p>
    </div>
    <a href="#donate" class="inline-flex min-h-[40px] items-center justify-center gap-1.5 rounded-xl bg-[#16a34a] hover:bg-[#15803d] px-6 py-2.5 text-xs font-bold text-white shadow-sm transition">
        <span>Donate Now</span>
        <span aria-hidden="true">→</span>
    </a>
</div>

@endsection
