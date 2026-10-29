@extends('layouts.base')

@section('title', $campaign->title . ' - ' . (function_exists('setting') ? setting('ngo_name', 'Hope Foundation') : 'Hope Foundation'))

@section('content')
@php
    $title = $campaign->title;
    $categoryName = $campaign->category ? $campaign->category->name : null;
    $raised = (float) ($campaign->raised_amount ?? 0);
    $goal = (float) ($campaign->goal_amount ?? 0);
    $progress = (float) ($campaign->progress_percentage ?? ($goal > 0 ? min(100, round(($raised / $goal) * 100, 1)) : 0));

    // Calculate days left only if end_date exists
    $daysLeft = null;
    if (!empty($campaign->end_date)) {
        $days = (int) now()->diffInDays(\Carbon\Carbon::parse($campaign->end_date), false);
        $daysLeft = max(0, $days);
    }

    $heroImage = !empty($campaign->thumbnail_image)
        ? (str_starts_with($campaign->thumbnail_image, 'http') ? $campaign->thumbnail_image : asset('storage/' . $campaign->thumbnail_image))
        : null;

    // Gallery Photos: strictly from campaign gallery_images without hardcoded dummy fallbacks
    $galleryPhotos = collect($campaign->gallery_images ?? [])
        ->filter()
        ->map(fn ($img) => is_string($img) && str_starts_with($img, 'http') ? $img : asset('storage/' . $img));

    // Preset amounts for donation card
    $presetAmounts = [500, 1000, 2000, 5000, 10000];

    // Key Highlights: strictly from campaign key_highlights without hardcoded dummy fallbacks
    $rawHighlights = $campaign->key_highlights ?? [];

    $keyHighlights = collect($rawHighlights)->map(function ($item, $index) {
        if (is_string($item)) {
            $lower = strtolower($item);
            $icon = 'graduation-cap';
            if (str_contains($lower, 'book') || str_contains($lower, 'study') || str_contains($lower, 'material')) {
                $icon = 'book-open';
            } elseif (str_contains($lower, 'uniform') || str_contains($lower, 'cloth') || str_contains($lower, 'dress') || str_contains($lower, 'facilit')) {
                $icon = 'shirt';
            } elseif (str_contains($lower, 'mentor') || str_contains($lower, 'guid') || str_contains($lower, 'team') || str_contains($lower, 'career')) {
                $icon = 'users';
            } elseif (str_contains($lower, 'health') || str_contains($lower, 'medic') || str_contains($lower, 'doctor') || str_contains($lower, 'oxygen') || str_contains($lower, 'patient')) {
                $icon = 'heart';
            } elseif (str_contains($lower, 'water') || str_contains($lower, 'clean')) {
                $icon = 'droplet';
            } elseif (str_contains($lower, 'tax') || str_contains($lower, 'exemption') || str_contains($lower, '80g') || str_contains($lower, 'audit') || str_contains($lower, 'verif')) {
                $icon = 'shield-check';
            } elseif ($index === 1) {
                $icon = 'book-open';
            } elseif ($index === 2) {
                $icon = 'shirt';
            } elseif ($index === 3) {
                $icon = 'users';
            }

            return [
                'title' => $item,
                'icon' => $icon,
                'custom_icon' => null,
                'description' => null,
            ];
        }

        return [
            'title' => $item['title'] ?? $item['text'] ?? '',
            'icon' => $item['icon'] ?? 'graduation-cap',
            'custom_icon' => $item['custom_icon'] ?? null,
            'description' => $item['description'] ?? $item['subtitle'] ?? null,
        ];
    })->filter(fn ($hl) => !empty($hl['title']));

    // Impact Stories: strictly from campaign impact_stories without hardcoded dummy fallbacks
    $impactStories = collect($campaign->impact_stories ?? [])->filter(fn ($story) => !empty($story['quote']) || !empty($story['name']));

    // FAQ Items: strictly from campaign faq_items without hardcoded dummy fallbacks
    $faqs = collect($campaign->faq_items ?? [])->filter(fn ($faq) => !empty($faq['question']));

    // Content HTML handling
    $storyHtml = $campaign->full_story ?? $campaign->short_description ?? '';
    $hasHtmlTags = strip_tags($storyHtml) !== $storyHtml;

    // Existence checks for sections
    $hasFundDistributions = isset($fundDistributions) && $fundDistributions->count() > 0;
    $hasImpactStories = $impactStories->isNotEmpty();
    $hasRecentDonations = isset($recentDonations) && $recentDonations->count() > 0;
    $hasGallery = $galleryPhotos->isNotEmpty();
    $hasFaqs = $faqs->isNotEmpty();
    $hasVideo = !empty($campaign->video_url);
@endphp

{{-- ================= HERO SECTION ================= --}}
<section class="relative isolate overflow-hidden bg-[#041f13] text-white">
    {{-- Background Image with Forest Depth Gradient Overlay --}}
    <div class="absolute inset-0 -z-10 overflow-hidden">
        @if($heroImage)
            <img src="{{ $heroImage }}"
                 alt="{{ $title }}"
                 class="h-full w-full object-cover object-[center_35%] opacity-40 mix-blend-luminosity brightness-110 contrast-105 sm:opacity-50">
        @endif
        {{-- Dual Layer Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-r from-[#031b10] via-[#052819]/90 to-[#041f13]/40"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#031b10] via-transparent to-transparent opacity-80"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8 lg:pb-28 lg:pt-14">
        {{-- Breadcrumbs Navigation --}}
        <nav aria-label="Breadcrumb" class="mb-4 flex flex-wrap items-center gap-1.5 text-xs font-medium text-emerald-100/80">
            <a href="{{ url('/') }}" class="hover:text-white transition">Home</a>
            <span aria-hidden="true">›</span>
            <a href="{{ route('campaigns.index') }}" class="hover:text-white transition">Campaigns</a>
            <span aria-hidden="true">›</span>
            <span aria-current="page" class="text-emerald-300 truncate max-w-xs sm:max-w-md">{{ $title }}</span>
        </nav>

        <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
            {{-- Left: Hero Headline, Eyebrow & Badges --}}
            <div class="lg:col-span-8">
                @if($categoryName)
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/95 backdrop-blur-xs px-3.5 py-1 text-xs font-bold text-emerald-800 shadow-sm border border-white/20">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                        {{ $categoryName }}
                    </span>
                @endif

                <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl leading-[1.15]">
                    {{ $title }}
                </h1>

                @if(!empty($campaign->short_description))
                    <p class="mt-3 max-w-xl text-sm leading-relaxed text-emerald-50/90 sm:text-base">
                        {{ $campaign->short_description }}
                    </p>
                @endif

                {{-- Trust Accreditations (Rendered only when applicable) --}}
                <div class="mt-4 flex flex-wrap items-center gap-3 text-xs font-semibold text-white/95">
                    @if($campaign->status === 'active' || $campaign->is_featured)
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-white/15 bg-white/10 px-3 py-1">
                            <svg class="h-3.5 w-3.5 text-[#4ade80]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Verified Campaign</span>
                        </span>
                    @endif

                    @if(function_exists('setting') ? setting('tax_exemption_80g', true) : true)
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-white/15 bg-white/10 px-3 py-1">
                            <svg class="h-3.5 w-3.5 text-[#4ade80]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>80G Eligible</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-white/15 bg-white/10 px-3 py-1">
                            <span class="text-[#4ade80] font-bold">₹</span>
                            <span>Tax Benefit Available</span>
                        </span>
                    @endif
                </div>
            </div>

            {{-- Right: Handwritten Script Badge (Desktop Only per Mockup) --}}
            <div class="hidden lg:flex lg:col-span-4 justify-end">
                <div class="transform -rotate-6 text-center select-none pointer-events-none pr-8 pt-2">
                    <p class="font-script text-3xl xl:text-4xl font-normal leading-tight text-white drop-shadow-md">
                        @if($categoryName && str_contains(strtolower($categoryName), 'education'))
                            Every<br>Child<br>Deserves<br>a Chance <span class="inline-block text-2xl xl:text-3xl text-[#4ade80]">💚</span>
                        @elseif($categoryName && (str_contains(strtolower($categoryName), 'medic') || str_contains(strtolower($categoryName), 'health')))
                            Every<br>Life<br>Matters<br>Deeply <span class="inline-block text-2xl xl:text-3xl text-[#4ade80]">❤️</span>
                        @else
                            Every<br>Rupee<br>Makes<br>Impact <span class="inline-block text-2xl xl:text-3xl text-[#4ade80]">✨</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= MAIN CONTENT + FLOATING DONATION CARD ================= --}}
<div class="bg-[#f8fafc] py-6 sm:py-8 lg:py-10"
     x-data="{
        videoModalOpen: false,
        activeNav: 'overview',
        isScrolling: false,
        scrollToSection(id) {
            this.activeNav = id;
            this.isScrolling = true;
            const el = document.getElementById(id);
            if (el) {
                const yOffset = -120;
                const y = el.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({ top: y, behavior: 'smooth' });
                setTimeout(() => {
                    this.isScrolling = false;
                }, 800);
            }
        },
        initScrollSpy() {
            const sectionIds = ['overview', 'impact', 'donors', 'gallery', 'faqs'];
            const onScroll = () => {
                if (this.isScrolling) return;
                const scrollPos = window.pageYOffset || document.documentElement.scrollTop;
                const offset = 140;
                let current = this.activeNav;
                for (let i = 0; i < sectionIds.length; i++) {
                    const el = document.getElementById(sectionIds[i]);
                    if (el) {
                        const top = el.offsetTop - offset;
                        const bottom = top + el.offsetHeight;
                        if (scrollPos >= top && scrollPos < bottom) {
                            current = sectionIds[i];
                            break;
                        } else if (scrollPos >= top) {
                            current = sectionIds[i];
                        }
                    }
                }
                if (current && this.activeNav !== current) {
                    this.activeNav = current;
                }
            };
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        }
     }"
     x-init="initScrollSpy()">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-12">

            {{-- ================= LEFT COLUMN: NARRATIVE & CONTENT ================= --}}
            <div class="space-y-8 lg:col-span-8">

                {{-- Smooth Sticky Sub-Navigation Bar (Scrolls without creating #hash in URL) --}}
                <nav aria-label="Campaign sections"
                     class="sticky top-20 z-30 -mx-4 sm:mx-0 flex items-center gap-2 overflow-x-auto bg-[#f8fafc]/95 backdrop-blur-md px-4 sm:px-0 py-2.5 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden border-b border-slate-200/80">
                    <button type="button"
                            @click="scrollToSection('overview')"
                            :class="activeNav === 'overview' ? 'bg-[#16a34a] text-white border-[#16a34a] shadow-xs' : 'bg-white border-slate-200/90 text-slate-700 hover:border-emerald-300 hover:text-emerald-700'"
                            class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border px-3.5 sm:px-4 text-xs font-bold transition-all duration-200 cursor-pointer">
                        <svg :class="activeNav === 'overview' ? 'text-white' : 'text-emerald-600'" class="h-3.5 w-3.5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Overview</span>
                    </button>

                    @if($hasFundDistributions || $hasImpactStories)
                        <button type="button"
                                @click="scrollToSection('impact')"
                                :class="activeNav === 'impact' ? 'bg-[#16a34a] text-white border-[#16a34a] shadow-xs' : 'bg-white border-slate-200/90 text-slate-700 hover:border-emerald-300 hover:text-emerald-700'"
                                class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border px-3.5 sm:px-4 text-xs font-bold transition-all duration-200 cursor-pointer">
                            <svg :class="activeNav === 'impact' ? 'text-white' : 'text-emerald-600'" class="h-3.5 w-3.5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            <span>Our Impact</span>
                        </button>
                    @endif

                    @if($hasRecentDonations)
                        <button type="button"
                                @click="scrollToSection('donors')"
                                :class="activeNav === 'donors' ? 'bg-[#16a34a] text-white border-[#16a34a] shadow-xs' : 'bg-white border-slate-200/90 text-slate-700 hover:border-emerald-300 hover:text-emerald-700'"
                                class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border px-3.5 sm:px-4 text-xs font-bold transition-all duration-200 cursor-pointer">
                            <svg :class="activeNav === 'donors' ? 'text-white' : 'text-emerald-600'" class="h-3.5 w-3.5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span>Donors</span>
                        </button>
                    @endif

                    @if($hasGallery)
                        <button type="button"
                                @click="scrollToSection('gallery')"
                                :class="activeNav === 'gallery' ? 'bg-[#16a34a] text-white border-[#16a34a] shadow-xs' : 'bg-white border-slate-200/90 text-slate-700 hover:border-emerald-300 hover:text-emerald-700'"
                                class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border px-3.5 sm:px-4 text-xs font-bold transition-all duration-200 cursor-pointer">
                            <svg :class="activeNav === 'gallery' ? 'text-white' : 'text-emerald-600'" class="h-3.5 w-3.5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Gallery</span>
                        </button>
                    @endif

                    @if($hasFaqs)
                        <button type="button"
                                @click="scrollToSection('faqs')"
                                :class="activeNav === 'faqs' ? 'bg-[#16a34a] text-white border-[#16a34a] shadow-xs' : 'bg-white border-slate-200/90 text-slate-700 hover:border-emerald-300 hover:text-emerald-700'"
                                class="inline-flex h-9 shrink-0 items-center gap-1.5 rounded-xl border px-3.5 sm:px-4 text-xs font-bold transition-all duration-200 cursor-pointer">
                            <svg :class="activeNav === 'faqs' ? 'text-white' : 'text-emerald-600'" class="h-3.5 w-3.5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>FAQs</span>
                        </button>
                    @endif
                </nav>

                {{-- 1. About This Campaign Section (#overview) --}}
                <section id="overview"
                         aria-labelledby="overview-heading"
                         class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-[0_4px_25px_rgba(15,23,42,0.04)] scroll-mt-28">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                        {{-- Story Narrative (Full width if no video, 7 cols if video exists) --}}
                        <div class="{{ $hasVideo ? 'md:col-span-7' : 'md:col-span-12' }}">
                            <h2 id="overview-heading" class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                                About This Campaign
                            </h2>

                            {{-- Dynamic Story Narrative (Supports RichEditor HTML tags) --}}
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

                        {{-- Right: Story Video Card (Rendered ONLY if video_url is present) --}}
                        @if($hasVideo)
                            <div class="md:col-span-5">
                                <div class="relative h-48 sm:h-56 w-full overflow-hidden rounded-2xl border border-slate-200/80 bg-slate-900 shadow-sm group">
                                    @if($heroImage)
                                        <img src="{{ $heroImage }}"
                                             alt="Video story thumbnail"
                                             class="h-full w-full object-cover transition duration-500 group-hover:scale-105 opacity-85">
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>

                                    {{-- Center Play Button --}}
                                    <button type="button"
                                            @click="videoModalOpen = true"
                                            class="absolute inset-0 m-auto h-12 w-12 rounded-full bg-white/90 backdrop-blur-xs text-emerald-600 flex items-center justify-center shadow-lg hover:scale-110 transition cursor-pointer"
                                            aria-label="Play Campaign Video">
                                        <svg class="h-6 w-6 ml-0.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </button>

                                    {{-- Bottom Badge CTA --}}
                                    <button type="button"
                                            @click="videoModalOpen = true"
                                            class="absolute bottom-3 right-3 rounded-xl bg-[#16a34a] hover:bg-[#15803d] text-white text-xs font-bold px-3 py-2 flex items-center gap-1.5 shadow-sm transition">
                                        <span>▶ Watch Our Story</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Key Highlights (Rendered ONLY if key_highlights exists and not empty) --}}
                    @if($keyHighlights->isNotEmpty())
                        @php
                            $hlCount = $keyHighlights->count();
                            $gridColsClass = match(true) {
                                $hlCount === 1 => 'grid-cols-1',
                                $hlCount === 2 => 'grid-cols-1 sm:grid-cols-2',
                                $hlCount === 3 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
                                default => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
                            };
                        @endphp
                        <div class="mt-8 rounded-2xl bg-[#ecfdf5]/80 border border-emerald-100/90 p-4 sm:p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-emerald-950 flex items-center gap-2">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                    <span>Key Highlights</span>
                                </h3>
                                <span class="text-[11px] font-bold text-emerald-700 bg-white px-2.5 py-0.5 rounded-full border border-emerald-200/80 shadow-2xs">
                                    {{ $keyHighlights->count() }} Key {{ \Illuminate\Support\Str::plural('Point', $keyHighlights->count()) }}
                                </span>
                            </div>

                            <div class="grid {{ $gridColsClass }} gap-3.5">
                                @foreach($keyHighlights as $hl)
                                    <div class="flex items-center gap-3.5 rounded-xl border border-slate-200/80 bg-white p-3.5 shadow-2xs hover:border-emerald-400 hover:shadow-xs transition-all duration-200 group">
                                        <div class="flex h-11 w-11 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100/90 group-hover:bg-[#16a34a] group-hover:text-white transition-all duration-200">
                                            @if(!empty($hl['custom_icon']))
                                                <img src="{{ str_starts_with($hl['custom_icon'], 'http') ? $hl['custom_icon'] : asset('storage/' . $hl['custom_icon']) }}"
                                                     alt="{{ $hl['title'] }}"
                                                     class="h-6 w-6 object-contain">
                                            @elseif($hl['icon'] === 'graduation-cap')
                                                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                            @elseif($hl['icon'] === 'book-open')
                                                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                            @elseif($hl['icon'] === 'shirt')
                                                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 3l4 4-2 2-2-1v13H8V8L6 9 4 7l4-4h2a2 2 0 004 0h2z"/></svg>
                                            @elseif($hl['icon'] === 'users')
                                                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            @elseif($hl['icon'] === 'heart')
                                                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                            @elseif($hl['icon'] === 'droplet')
                                                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                            @elseif($hl['icon'] === 'shield-check')
                                                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                            @else
                                                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <span class="block text-xs sm:text-[13px] font-bold text-slate-900 group-hover:text-emerald-950 leading-snug break-words">
                                                {{ $hl['title'] }}
                                            </span>
                                            @if(!empty($hl['description']))
                                                <span class="block text-[11px] text-slate-500 mt-0.5 line-clamp-2 leading-tight break-words">{{ $hl['description'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </section>

                {{-- 2. Audited Ground Relief Section (Public Ledger & Bills - Rendered ONLY if fund distributions exist) --}}
                @if($hasFundDistributions)
                    <section id="impact"
                             class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-[0_4px_25px_rgba(15,23,42,0.04)] scroll-mt-28">
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
                                        <span class="text-[11px] text-slate-500">
                                            {{ $dist->beneficiary_name }}
                                            @if($dist->distribution_date)
                                                &bull; {{ $dist->distribution_date->format('d M Y') }}
                                            @endif
                                        </span>
                                    </div>
                                    <span class="font-mono font-bold text-slate-900 text-sm">₹{{ number_format($dist->amount_spent, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- 3. Beneficiary Impact Stories Section (Carousel Slider) --}}
                @if($hasImpactStories)
                    <section @if(!$hasFundDistributions) id="impact" @endif
                             x-data="{
                                activeSlide: 0,
                                total: {{ $impactStories->count() }},
                                isDesktop: window.innerWidth >= 768,
                                touchStartX: 0,
                                maxSlide() {
                                    return this.isDesktop ? Math.max(0, this.total - 2) : Math.max(0, this.total - 1);
                                },
                                prev() {
                                    this.activeSlide = (this.activeSlide <= 0) ? this.maxSlide() : this.activeSlide - 1;
                                },
                                next() {
                                    this.activeSlide = (this.activeSlide >= this.maxSlide()) ? 0 : this.activeSlide + 1;
                                },
                                slidesList() {
                                    return Array.from({ length: this.maxSlide() + 1 }, (_, i) => i);
                                }
                             }"
                             @resize.window="isDesktop = window.innerWidth >= 768; if (activeSlide > maxSlide()) activeSlide = maxSlide()"
                             class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-[0_4px_25px_rgba(15,23,42,0.04)] scroll-mt-28">

                        {{-- Carousel Header with Title, Status & Navigation Arrows --}}
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                                    <span>Impact Stories</span>
                                    @if($impactStories->count() > 1)
                                        <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/80">
                                            <span x-text="activeSlide + 1"></span> of {{ $impactStories->count() }}
                                        </span>
                                    @endif
                                </h2>
                                <p class="text-xs text-slate-500 mt-0.5">Real voices and journeys transformed by your contribution</p>
                            </div>

                            <template x-if="maxSlide() > 0">
                                {{-- Arrow Navigation Buttons --}}
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <button type="button"
                                            @click="prev()"
                                            aria-label="Previous story"
                                            class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-xl border border-slate-200/90 bg-white text-slate-700 shadow-2xs hover:bg-emerald-50 hover:border-emerald-300 hover:text-emerald-700 active:scale-95 transition-all duration-200 cursor-pointer">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    <button type="button"
                                            @click="next()"
                                            aria-label="Next story"
                                            class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-xl border border-slate-200/90 bg-white text-slate-700 shadow-2xs hover:bg-emerald-50 hover:border-emerald-300 hover:text-emerald-700 active:scale-95 transition-all duration-200 cursor-pointer">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                </div>
                            </template>
                        </div>

                        {{-- Carousel Slider Viewport --}}
                        <div class="relative overflow-hidden rounded-2xl"
                             @touchstart="touchStartX = $event.touches[0].clientX"
                             @touchend="if (touchStartX - $event.changedTouches[0].clientX > 40) next(); if ($event.changedTouches[0].clientX - touchStartX > 40) prev();">

                            {{-- Slider Track --}}
                            <div class="flex transition-transform duration-500 ease-out -mx-2"
                                 :style="'transform: translateX(-' + (activeSlide * (isDesktop ? 50 : 100)) + '%)'">
                                @foreach($impactStories as $index => $story)
                                    <div class="w-full shrink-0 px-2 flex {{ $impactStories->count() > 1 ? 'md:w-1/2' : 'w-full' }}">
                                        <article class="flex flex-col sm:flex-row gap-3.5 sm:gap-4 items-start rounded-2xl border border-slate-200/80 bg-slate-50/70 p-4 sm:p-5 hover:bg-slate-50 hover:border-emerald-300 transition-all duration-300 shadow-2xs w-full">
                                            @if(!empty($story['photo']))
                                                <img src="{{ str_starts_with($story['photo'], 'http') ? $story['photo'] : asset('storage/' . $story['photo']) }}"
                                                     alt="{{ $story['name'] ?? 'Beneficiary' }}"
                                                     loading="lazy"
                                                     class="h-16 w-16 sm:h-20 sm:w-20 rounded-2xl object-cover shrink-0 border border-slate-200 bg-slate-200 shadow-sm">
                                            @endif
                                            <div class="min-w-0 flex-1">
                                                @if(!empty($story['quote']))
                                                    <p class="text-xs sm:text-[13px] text-slate-700 leading-relaxed italic line-clamp-4">
                                                        “{{ $story['quote'] }}”
                                                    </p>
                                                @endif
                                                @if(!empty($story['name']))
                                                    <div class="mt-2.5 flex items-center gap-1.5">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                        <p class="text-xs font-extrabold text-slate-900 truncate">
                                                            {{ $story['name'] }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Dots Pagination Indicator --}}
                        <template x-if="maxSlide() > 0">
                            <div class="mt-4 flex items-center justify-center gap-1.5">
                                <template x-for="slideIdx in slidesList()" :key="slideIdx">
                                    <button type="button"
                                            @click="activeSlide = slideIdx"
                                            :class="activeSlide === slideIdx ? 'w-6 bg-[#16a34a]' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                                            class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                                            :aria-label="'Go to story slide ' + (slideIdx + 1)">
                                    </button>
                                </template>
                            </div>
                        </template>
                    </section>
                @endif

                {{-- 4. Recent Verified Donors Stream (Rendered ONLY if verified donations exist) --}}
                @if($hasRecentDonations)
                    <section id="donors"
                             class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-[0_4px_25px_rgba(15,23,42,0.04)] scroll-mt-28">
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

                {{-- 5. Gallery Section (Rendered ONLY if gallery_images exist and not empty) --}}
                @if($hasGallery)
                    <section id="gallery"
                             aria-labelledby="gallery-heading"
                             class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-[0_4px_25px_rgba(15,23,42,0.04)] scroll-mt-28">
                        <div class="flex items-center justify-between mb-4">
                            <h2 id="gallery-heading" class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                                Gallery
                            </h2>
                            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg">
                                {{ $galleryPhotos->count() }} {{ \Illuminate\Support\Str::plural('Photo', $galleryPhotos->count()) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach($galleryPhotos->take(8) as $photoUrl)
                                <a href="{{ $photoUrl }}" target="_blank" rel="noopener" class="group h-32 sm:h-36 overflow-hidden rounded-2xl bg-slate-100 shadow-2xs block">
                                    <img src="{{ $photoUrl }}"
                                         alt="Campaign field photo"
                                         loading="lazy"
                                         class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- 6. Frequently Asked Questions (Rendered ONLY if faq_items exist and not empty) --}}
                @if($hasFaqs)
                    <section id="faqs"
                             aria-labelledby="faqs-heading"
                             class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-[0_4px_25px_rgba(15,23,42,0.04)] scroll-mt-28">
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
                                        {{ $faq['answer'] ?? '' }}
                                    </p>
                                </details>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- 7. More Campaigns You Might Like (Rendered ONLY if related campaigns exist) --}}
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
                                    $relGoal = (float) ($related->goal_amount ?? 0);
                                    $relProg = $relGoal > 0 ? min(100, round(($relRaised / $relGoal) * 100)) : 0;
                                    $relImage = !empty($related->thumbnail_image)
                                        ? (str_starts_with($related->thumbnail_image, 'http') ? $related->thumbnail_image : asset('storage/' . $related->thumbnail_image))
                                        : null;
                                @endphp
                                <article class="flex flex-col rounded-2xl border border-slate-200/90 bg-white p-3 shadow-xs hover:shadow-md transition">
                                    @if($relImage)
                                        <img src="{{ $relImage }}"
                                             alt="{{ $related->title }}"
                                             loading="lazy"
                                             class="h-28 w-full rounded-xl object-cover mb-2.5">
                                    @endif
                                    <h3 class="text-xs font-bold text-slate-900 line-clamp-1 hover:text-emerald-700">
                                        <a href="{{ route('campaigns.show', $related->slug) }}">{{ $related->title }}</a>
                                    </h3>
                                    @if(!empty($related->short_description))
                                        <p class="text-[11px] text-slate-500 line-clamp-2 mt-0.5 leading-snug">
                                            {{ $related->short_description }}
                                        </p>
                                    @endif
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

            {{-- ================= RIGHT COLUMN: OVERLAPPING STICKY DONATION CARD & INFO ================= --}}
            <aside class="space-y-6 lg:col-span-4 lg:-mt-44 z-20 sticky top-24" aria-label="Donation checkout and campaign information">

                {{-- 1. Floating Donation Checkout Card --}}
                <div id="donate" class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-6 shadow-[0_12px_40px_rgba(15,23,42,0.12)]">
                    {{-- Raised Amount & Percentage Header --}}
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

                    {{-- Progress Bar --}}
                    <div class="mt-3 h-2.5 w-full overflow-hidden rounded-full bg-slate-100" role="progressbar" aria-valuenow="{{ (int)$progress }}" aria-valuemin="0" aria-valuemax="100">
                        <div class="h-full rounded-full bg-[#16a34a] transition-all duration-700 ease-out" style="width: {{ $progress }}%"></div>
                    </div>

                    {{-- 3-Column Stats Row (Only display Days Left if end_date exists) --}}
                    <div class="mt-4 grid grid-cols-3 divide-x divide-emerald-200/60 rounded-xl bg-[#ecfdf5]/80 border border-emerald-100/80 py-2.5 text-center">
                        <div>
                            <p class="text-base font-extrabold text-slate-900">{{ number_format($donorsCount ?? 0) }}</p>
                            <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">Donors</p>
                        </div>
                        <div>
                            <p class="text-base font-extrabold text-slate-900">
                                {{ $daysLeft !== null ? $daysLeft : 'Ongoing' }}
                            </p>
                            <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                                {{ $daysLeft !== null ? 'Days Left' : 'Schedule' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-base font-extrabold text-slate-900">₹{{ number_format(max(0, $goal - $raised), 0) }}</p>
                            <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">Still Needed</p>
                        </div>
                    </div>

                    {{-- Make a Donation Form with Preset Amount Buttons --}}
                    <form action="{{ route('donate.index') }}" method="GET" class="mt-5" x-data="{ selectedAmount: 1000, isCustom: false }">
                        <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                        <p class="text-sm font-bold text-slate-900 mb-2.5">Make a Donation</p>

                        {{-- Presets in 2x3 Grid --}}
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

                        {{-- Amount Input --}}
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

                        {{-- Primary CTA Button --}}
                        <button type="submit"
                                class="mt-3.5 inline-flex w-full min-h-[44px] items-center justify-center gap-2 rounded-xl bg-[#16a34a] hover:bg-[#15803d] active:scale-[0.99] px-4 py-3 text-sm font-bold text-white shadow-sm hover:shadow transition cursor-pointer">
                            <span>Donate Now</span>
                            <span aria-hidden="true">→</span>
                        </button>
                    </form>

                    {{-- Trust Accreditations List --}}
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

                        @if(function_exists('setting') ? setting('tax_exemption_80g', true) : true)
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">80G Tax Benefit</p>
                                    <p class="text-[11px] text-slate-500">Get instant receipt for tax exemption</p>
                                </div>
                            </div>
                        @endif

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

                {{-- 2. Campaign Information Card (Strictly conditional rows - no dummy fallbacks) --}}
                <div class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-6 shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 mb-3.5 pb-2.5 border-b border-slate-100">
                        Campaign Information
                    </h4>

                    <dl class="space-y-3 text-xs sm:text-[13px]">
                        @if($categoryName)
                            <div class="flex items-center justify-between">
                                <dt class="flex items-center gap-2 text-slate-500">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                    <span>Category</span>
                                </dt>
                                <dd class="font-bold text-slate-800">{{ $categoryName }}</dd>
                            </div>
                        @endif

                        @if($campaign->start_date)
                            <div class="flex items-center justify-between">
                                <dt class="flex items-center gap-2 text-slate-500">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>Started On</span>
                                </dt>
                                <dd class="font-medium text-slate-700">{{ $campaign->start_date->format('d M Y') }}</dd>
                            </div>
                        @endif

                        @if($campaign->end_date)
                            <div class="flex items-center justify-between">
                                <dt class="flex items-center gap-2 text-slate-500">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Last Date</span>
                                </dt>
                                <dd class="font-medium text-slate-700">{{ $campaign->end_date->format('d M Y') }}</dd>
                            </div>
                        @endif

                        @if(!empty($campaign->location))
                            <div class="flex items-center justify-between">
                                <dt class="flex items-center gap-2 text-slate-500">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>Location</span>
                                </dt>
                                <dd class="font-medium text-slate-700">{{ $campaign->location }}</dd>
                            </div>
                        @endif

                        @if(!empty($campaign->beneficiary_summary))
                            <div class="flex items-center justify-between">
                                <dt class="flex items-center gap-2 text-slate-500">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    <span>Beneficiaries</span>
                                </dt>
                                <dd class="font-medium text-slate-700">{{ $campaign->beneficiary_summary }}</dd>
                            </div>
                        @endif

                        @if(function_exists('setting') && setting('ngo_name'))
                            <div class="flex items-center justify-between">
                                <dt class="flex items-center gap-2 text-slate-500">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    <span>Campaign By</span>
                                </dt>
                                <dd class="font-medium text-slate-700">{{ setting('ngo_name') }}</dd>
                            </div>
                        @endif

                        @if($campaign->status === 'active' || $campaign->is_featured)
                            <div class="flex items-center justify-between pt-1">
                                <dt class="flex items-center gap-2 text-slate-500">
                                    <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Verified</span>
                                </dt>
                                <dd class="font-bold text-emerald-700">Yes</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                {{-- 3. Share This Campaign Card --}}
                <div class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-5 sm:p-6 shadow-[0_4px_25px_rgba(15,23,42,0.04)]">
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 mb-3">
                        Share This Campaign
                    </h4>

                    <div class="flex items-center gap-2.5">
                        {{-- WhatsApp --}}
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($title . ' - Support here: ' . url()->current()) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="flex h-9 w-9 items-center justify-center rounded-full bg-[#25D366] text-white hover:scale-105 transition shadow-2xs"
                           title="Share on WhatsApp">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.299.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.303c-.087.087-.179.182-.077.357.101.174.449.741.964 1.201.662.591 1.221.774 1.394.861.173.087.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.043.073.043.419-.101.824z"/></svg>
                        </a>

                        {{-- Facebook --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="flex h-9 w-9 items-center justify-center rounded-full bg-[#1877F2] text-white hover:scale-105 transition shadow-2xs"
                           title="Share on Facebook">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>

                        {{-- X / Twitter --}}
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($title . ' ' . url()->current()) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-white hover:scale-105 transition shadow-2xs"
                           title="Share on X">
                            <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>

                        {{-- LinkedIn --}}
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="flex h-9 w-9 items-center justify-center rounded-full bg-[#0A66C2] text-white hover:scale-105 transition shadow-2xs"
                           title="Share on LinkedIn">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.738-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>

                        {{-- Copy Link --}}
                        <button type="button"
                                @click="navigator.clipboard.writeText(window.location.href); alert('Link copied to clipboard!')"
                                class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-slate-700 hover:bg-slate-200 transition shadow-2xs"
                                title="Copy Campaign Link">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </button>
                    </div>

                    <p class="text-[11px] text-slate-400 mt-3">
                        Help us spread the word and reach more people.
                    </p>
                </div>
            </aside>
        </div>
    </div>

    {{-- ================= STORY VIDEO LIGHTBOX MODAL (Rendered ONLY if video_url exists) ================= --}}
    @if($hasVideo)
        <div x-show="videoModalOpen"
             x-cloak
             @keydown.escape.window="videoModalOpen = false"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
            <div @click.away="videoModalOpen = false"
                 class="relative w-full max-w-3xl bg-slate-900 rounded-3xl overflow-hidden shadow-2xl border border-white/15 p-6 text-center text-white">
                <button @click="videoModalOpen = false"
                        class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white cursor-pointer">
                    ✕
                </button>
                <div class="py-12 space-y-4">
                    <div class="w-16 h-16 rounded-full bg-[#16a34a]/20 border border-[#16a34a] text-[#4ade80] flex items-center justify-center mx-auto">
                        <svg class="h-8 w-8 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold">{{ $title }}</h3>
                    <p class="text-sm text-slate-300 max-w-md mx-auto">
                        Watch ground relief progress, beneficiary interviews, and verifiable milestone deliveries.
                    </p>
                    <div class="pt-4 flex items-center justify-center gap-3">
                        <a href="{{ $campaign->video_url }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 rounded-xl bg-[#16a34a] px-6 py-3 text-sm font-bold text-white hover:bg-[#15803d] transition">
                            <span>Watch Video on External Player</span>
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

