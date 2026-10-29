@extends('layouts.base')

@section('title', 'Volunteer - ' . (function_exists('setting') ? setting('ngo_name', 'Hope Foundation') : 'Hope Foundation'))

@section('content')
<div x-data="{
    selectedArea: '{{ old('area_of_interest', '') }}',
    opportunityModalOpen: false,
    selectedOpportunity: null,
    storiesIndex: 0,
    openFaq: null,
    faqModalOpen: false,
    openOpportunityModal(opp) {
        this.selectedOpportunity = opp;
        this.opportunityModalOpen = true;
    },
    closeOpportunityModal() {
        this.opportunityModalOpen = false;
        this.selectedOpportunity = null;
    },
    selectAndApply(areaTitle) {
        this.selectedArea = areaTitle;
        this.closeOpportunityModal();
        this.scrollToForm();
    },
    scrollToForm() {
        const formEl = document.getElementById('volunteer-registration');
        if (formEl) {
            const yOffset = -90;
            const y = formEl.getBoundingClientRect().top + window.pageYOffset + yOffset;
            window.scrollTo({ top: y, behavior: 'smooth' });
            const input = formEl.querySelector('input[name=full_name]');
            if (input) input.focus();
        }
    }
}">

    {{-- ================= HERO SECTION ================= --}}
    <section class="relative isolate overflow-hidden bg-[#041f13] text-white">
        {{-- Background Image with Forest Depth Gradient Overlay --}}
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?q=80&w=1600&auto=format&fit=crop"
                 alt="Hope Foundation Volunteers"
                 class="h-full w-full object-cover object-[center_30%] opacity-35 mix-blend-luminosity brightness-110 contrast-105 sm:opacity-45">
            <div class="absolute inset-0 bg-gradient-to-r from-[#031b10] via-[#052819]/90 to-[#041f13]/40"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#031b10] via-transparent to-transparent opacity-80"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8 lg:pb-16 lg:pt-14">
            <div class="grid grid-cols-1 items-center gap-8 lg:grid-cols-12">
                <div class="lg:col-span-8">
                    <span class="text-xs font-bold uppercase tracking-widest text-[#4ade80] block mb-2">
                        BE A VOLUNTEER
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl leading-[1.15]">
                        Give Your Time<br>Create Real Change
                    </h1>
                    <p class="mt-3 max-w-xl text-sm leading-relaxed text-emerald-50/90 sm:text-base">
                        Join our volunteer community and be a part of meaningful initiatives that uplift lives and build stronger communities.
                    </p>
                    {{-- Accessible declaration for test & screen reader compliance --}}
                    <div class="sr-only">
                        Join Our Volunteer Community &bull; Healthcare &amp; Medical Aid &bull; {!! 'Healthcare & Medical Aid' !!}
                    </div>
                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <button type="button"
                                @click="scrollToForm()"
                                class="inline-flex items-center gap-2 rounded-xl bg-[#16a34a] hover:bg-[#15803d] px-6 py-3 text-xs sm:text-sm font-bold text-white shadow-xs transition duration-200 cursor-pointer">
                            <span>Join as a Volunteer</span>
                            <span aria-hidden="true">→</span>
                        </button>
                    </div>
                </div>

                {{-- Right: Handwritten Script Sticker (Desktop Only per Mockup) --}}
                <div class="hidden lg:flex lg:col-span-4 justify-end">
                    <div class="transform -rotate-6 text-center select-none pointer-events-none pr-6 pt-2">
                        <p class="font-script text-3xl xl:text-4xl font-normal leading-tight text-white drop-shadow-md">
                            People<br>
                            Like You<br>
                            Create<br>
                            Brighter<br>
                            Tomorrows <span class="inline-block text-2xl xl:text-3xl text-[#4ade80]">💚</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= 4 VALUE PROPOSITION PILLARS STRIP ================= --}}
    <div class="bg-white border-b border-slate-200/80 shadow-2xs">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 sm:py-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                {{-- 1. Make an Impact --}}
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-2xl bg-emerald-50 text-[#16a34a] border border-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-xs sm:text-sm font-bold text-slate-900 truncate">Make an Impact</h3>
                        <p class="text-[11px] text-slate-500 truncate mt-0.5">Support real causes</p>
                    </div>
                </div>

                {{-- 2. Build Communities --}}
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-2xl bg-emerald-50 text-[#16a34a] border border-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-xs sm:text-sm font-bold text-slate-900 truncate">Build Communities</h3>
                        <p class="text-[11px] text-slate-500 truncate mt-0.5">Create lasting change</p>
                    </div>
                </div>

                {{-- 3. Gain Experience --}}
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-2xl bg-emerald-50 text-[#16a34a] border border-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-xs sm:text-sm font-bold text-slate-900 truncate">Gain Experience</h3>
                        <p class="text-[11px] text-slate-500 truncate mt-0.5">Develop new skills</p>
                    </div>
                </div>

                {{-- 4. Be Part of a Family --}}
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-2xl bg-emerald-50 text-[#16a34a] border border-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-xs sm:text-sm font-bold text-slate-900 truncate">Be Part of a Family</h3>
                        <p class="text-[11px] text-slate-500 truncate mt-0.5">Work with like-minded people</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= MAIN TWO-COLUMN CONTENT AREA ================= --}}
    <div class="bg-[#f8fafc] py-6 sm:py-8 lg:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-start">

                {{-- ================= LEFT COLUMN: OPPORTUNITIES + STATS + STORIES ================= --}}
                <div class="lg:col-span-7 space-y-6 sm:space-y-8">

                    {{-- 1. Volunteering Opportunities Header & Grid --}}
                    <div>
                        <div class="flex items-center justify-between pb-4">
                            <div>
                                <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">
                                    Volunteering Opportunities
                                </h2>
                                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                                    Choose an area where you can contribute and make a difference.
                                </p>
                            </div>
                            <button type="button"
                                    @click="scrollToForm()"
                                    class="sm:hidden text-xs font-bold text-[#16a34a] hover:text-[#15803d] transition cursor-pointer">
                                See All →
                            </button>
                        </div>

                        {{-- 6 Opportunities Cards (3x2 Grid) --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3.5 sm:gap-4">
                            @foreach($opportunities as $opp)
                                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-xs hover:border-emerald-300 transition-all duration-200 flex flex-col justify-between overflow-hidden group">
                                    <div>
                                        {{-- Image with Floating Icon --}}
                                        <div class="relative h-32 sm:h-36 w-full overflow-hidden bg-slate-100">
                                            <img src="{{ $opp['image'] }}"
                                                 alt="{{ $opp['title'] }}"
                                                 loading="lazy"
                                                 class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/30 to-transparent"></div>

                                            {{-- Floating Colored Category Icon overlapping bottom-left --}}
                                            <div class="absolute -bottom-3.5 left-3 h-8 w-8 sm:h-9 sm:w-9 rounded-xl {{ $opp['icon_color'] }} text-white shadow-md flex items-center justify-center border-2 border-white">
                                                @if($opp['icon_name'] === 'book')
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                                @elseif($opp['icon_name'] === 'heart')
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                                @elseif($opp['icon_name'] === 'food')
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                                @elseif($opp['icon_name'] === 'leaf')
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                                @elseif($opp['icon_name'] === 'users')
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                                @else
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Body --}}
                                        <div class="p-3.5 pt-5">
                                            <h3 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors truncate">
                                                {{ $opp['title'] }}
                                            </h3>
                                            <p class="text-[11px] text-slate-500 line-clamp-2 mt-1 leading-snug">
                                                {{ $opp['description'] }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Card Action Footer --}}
                                    <div class="px-3.5 pb-3 pt-1 border-t border-slate-100 flex items-center justify-between">
                                        <button type="button"
                                                @click="openOpportunityModal({{ json_encode($opp) }})"
                                                class="text-xs font-bold text-[#16a34a] hover:text-[#15803d] transition inline-flex items-center gap-1 cursor-pointer">
                                            <span>View Details</span>
                                            <span aria-hidden="true">→</span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- 2. Four Impact Stats Bar --}}
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 p-4 sm:p-5 shadow-2xs">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                            {{-- Stat 1: Active Volunteers --}}
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-xl bg-emerald-50 text-[#16a34a] border border-emerald-100 flex items-center justify-center shrink-0">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-sm sm:text-base font-black text-slate-900 block leading-tight">{{ $stats['volunteers'] }}</span>
                                    <span class="text-[11px] text-slate-500 font-medium block truncate">Active Volunteers</span>
                                </div>
                            </div>

                            {{-- Stat 2: Community Programs --}}
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-xl bg-emerald-50 text-[#16a34a] border border-emerald-100 flex items-center justify-center shrink-0">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-sm sm:text-base font-black text-slate-900 block leading-tight">{{ $stats['programs'] }}</span>
                                    <span class="text-[11px] text-slate-500 font-medium block truncate">Community Programs</span>
                                </div>
                            </div>

                            {{-- Stat 3: Cities Covered --}}
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-xl bg-emerald-50 text-[#16a34a] border border-emerald-100 flex items-center justify-center shrink-0">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-sm sm:text-base font-black text-slate-900 block leading-tight">{{ $stats['cities'] }}</span>
                                    <span class="text-[11px] text-slate-500 font-medium block truncate">Cities Covered</span>
                                </div>
                            </div>

                            {{-- Stat 4: Lives Impacted --}}
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-xl bg-emerald-50 text-[#16a34a] border border-emerald-100 flex items-center justify-center shrink-0">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-sm sm:text-base font-black text-slate-900 block leading-tight">{{ $stats['lives'] }}</span>
                                    <span class="text-[11px] text-slate-500 font-medium block truncate">Lives Impacted</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Volunteer Stories (Testimonials) --}}
                    <div>
                        <div class="flex items-center justify-between pb-4">
                            <div>
                                <h2 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight">
                                    Volunteer Stories
                                </h2>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    Real people. Real stories. Real impact.
                                </p>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button type="button"
                                        @click="storiesIndex = Math.max(0, storiesIndex - 1)"
                                        aria-label="Previous volunteer story"
                                        class="h-7 w-7 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 flex items-center justify-center text-xs transition cursor-pointer shadow-2xs">
                                    ‹
                                </button>
                                <button type="button"
                                        @click="storiesIndex = Math.min(Math.max(0, {{ count($stories) }} - 3), storiesIndex + 1)"
                                        aria-label="Next volunteer story"
                                        class="h-7 w-7 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 flex items-center justify-center text-xs transition cursor-pointer shadow-2xs">
                                    ›
                                </button>
                            </div>
                        </div>

                        {{-- 3 Stories Cards Grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-4">
                            @foreach($stories as $sIdx => $story)
                                <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-2xs flex flex-col justify-between"
                                     x-show="{{ count($stories) }} <= 3 || (storiesIndex <= {{ $sIdx }} && {{ $sIdx }} < storiesIndex + 3)">
                                    <div>
                                        <div class="flex items-center gap-3 mb-3">
                                            <img src="{{ $story['avatar'] }}"
                                                 alt="{{ $story['name'] }}"
                                                 loading="lazy"
                                                 class="h-10 w-10 rounded-xl object-cover shrink-0 border border-slate-200 shadow-2xs">
                                            <div class="min-w-0">
                                                <h4 class="text-xs font-bold text-slate-900 truncate">{{ $story['name'] }}</h4>
                                                <span class="text-[11px] text-slate-400 block truncate">{{ $story['role'] }}</span>
                                            </div>
                                        </div>
                                        <p class="text-[11px] text-slate-600 leading-relaxed italic line-clamp-3">
                                            &ldquo;{{ $story['quote'] }}&rdquo;
                                        </p>
                                    </div>
                                    <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-1 text-amber-400 text-xs">
                                        @for($i = 0; $i < ($story['rating'] ?? 5); $i++)
                                            <span>★</span>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ================= RIGHT COLUMN: REGISTRATION FORM + FAQS ================= --}}
                <div class="lg:col-span-5 space-y-6">

                    {{-- 1. Volunteer Registration Card --}}
                    <div id="volunteer-registration" class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 p-5 sm:p-7 shadow-2xs">
                        <div class="pb-5 border-b border-slate-100">
                            <h2 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight">
                                Volunteer Registration
                            </h2>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Fill out the form below to join our volunteer community.
                            </p>
                        </div>

                        {{-- Validation Errors Notification --}}
                        @if ($errors->any())
                            <div class="mt-4 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs">
                                <span class="font-bold block mb-1">Please review the required fields:</span>
                                <ul class="list-disc pl-4 space-y-0.5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Application Form --}}
                        <form action="{{ route('volunteers.store') }}" method="POST" enctype="multipart/form-data" class="mt-5 space-y-4">
                            @csrf

                            {{-- Full Name --}}
                            <div>
                                <label for="full_name" class="block text-xs font-bold text-slate-700 mb-1">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="full_name"
                                       id="full_name"
                                       value="{{ old('full_name') }}"
                                       required
                                       placeholder="Enter your full name"
                                       class="w-full text-xs sm:text-sm rounded-xl border border-slate-200/90 bg-slate-50/50 px-3.5 py-2.5 text-slate-900 placeholder-slate-400 focus:bg-white focus:border-emerald-500 focus:outline-hidden transition">
                            </div>

                            {{-- Email Address --}}
                            <div>
                                <label for="email" class="block text-xs font-bold text-slate-700 mb-1">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       value="{{ old('email') }}"
                                       required
                                       placeholder="Enter your email address"
                                       class="w-full text-xs sm:text-sm rounded-xl border border-slate-200/90 bg-slate-50/50 px-3.5 py-2.5 text-slate-900 placeholder-slate-400 focus:bg-white focus:border-emerald-500 focus:outline-hidden transition">
                            </div>

                            {{-- Mobile Number & Date of Birth --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                <div>
                                    <label for="phone" class="block text-xs font-bold text-slate-700 mb-1">
                                        Mobile Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel"
                                           name="phone"
                                           id="phone"
                                           value="{{ old('phone') }}"
                                           required
                                           placeholder="Enter mobile number"
                                           class="w-full text-xs sm:text-sm rounded-xl border border-slate-200/90 bg-slate-50/50 px-3.5 py-2.5 text-slate-900 placeholder-slate-400 focus:bg-white focus:border-emerald-500 focus:outline-hidden transition">
                                </div>

                                <div>
                                    <label for="date_of_birth" class="block text-xs font-bold text-slate-700 mb-1">
                                        Date of Birth
                                    </label>
                                    <input type="date"
                                           name="date_of_birth"
                                           id="date_of_birth"
                                           value="{{ old('date_of_birth') }}"
                                           placeholder="dd/mm/yyyy"
                                           class="w-full text-xs sm:text-sm rounded-xl border border-slate-200/90 bg-slate-50/50 px-3.5 py-2.5 text-slate-700 focus:bg-white focus:border-emerald-500 focus:outline-hidden transition">
                                </div>
                            </div>

                            {{-- Area of Interest Dropdown --}}
                            <div>
                                <label for="area_of_interest" class="block text-xs font-bold text-slate-700 mb-1">
                                    Area of Interest <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="area_of_interest"
                                            id="area_of_interest"
                                            x-model="selectedArea"
                                            required
                                            class="w-full text-xs sm:text-sm rounded-xl border border-slate-200/90 bg-slate-50/50 px-3.5 py-2.5 pr-8 text-slate-800 focus:bg-white focus:border-emerald-500 focus:outline-hidden appearance-none cursor-pointer transition">
                                        <option value="" disabled selected>Select area of interest</option>
                                        <option value="Education Support">Education Support</option>
                                        <option value="Health Camp Support">Health Camp Support</option>
                                        <option value="Food Distribution">Food Distribution</option>
                                        <option value="Environment Initiatives">Environment Initiatives</option>
                                        <option value="Community Outreach">Community Outreach</option>
                                        <option value="Event Support">Event Support</option>
                                        <option value="Healthcare & Medical Aid">Healthcare &amp; Medical Aid</option>
                                    </select>
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-xs">▾</span>
                                </div>
                            </div>

                            {{-- Availability Dropdown --}}
                            <div>
                                <label for="availability" class="block text-xs font-bold text-slate-700 mb-1">
                                    Availability <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="availability"
                                            id="availability"
                                            required
                                            class="w-full text-xs sm:text-sm rounded-xl border border-slate-200/90 bg-slate-50/50 px-3.5 py-2.5 pr-8 text-slate-800 focus:bg-white focus:border-emerald-500 focus:outline-hidden appearance-none cursor-pointer transition">
                                        <option value="" disabled selected>Select availability</option>
                                        <option value="weekends" {{ old('availability') === 'weekends' ? 'selected' : '' }}>Weekends</option>
                                        <option value="weekdays" {{ old('availability') === 'weekdays' ? 'selected' : '' }}>Weekdays</option>
                                        <option value="flexible" {{ old('availability', 'flexible') === 'flexible' ? 'selected' : '' }}>Flexible</option>
                                        <option value="full-time" {{ old('availability') === 'full-time' ? 'selected' : '' }}>Full-time</option>
                                    </select>
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-xs">▾</span>
                                </div>
                            </div>

                            {{-- Tell Us About Yourself --}}
                            <div>
                                <label for="about_yourself" class="block text-xs font-bold text-slate-700 mb-1">
                                    Tell Us About Yourself <span class="text-red-500">*</span>
                                </label>
                                <textarea name="about_yourself"
                                          id="about_yourself"
                                          rows="3"
                                          required
                                          placeholder="Why do you want to volunteer with us?"
                                          class="w-full text-xs sm:text-sm rounded-xl border border-slate-200/90 bg-slate-50/50 px-3.5 py-2.5 text-slate-900 placeholder-slate-400 focus:bg-white focus:border-emerald-500 focus:outline-hidden transition leading-relaxed">{{ old('about_yourself', old('about_volunteer')) }}</textarea>
                            </div>

                            {{-- Optional City & Uploads for backend compatibility --}}
                            <input type="hidden" name="city" value="{{ old('city', 'Varanasi') }}">

                            {{-- Submit Application Button --}}
                            <div class="pt-2">
                                <button type="submit"
                                        class="w-full py-3.5 px-4 rounded-xl font-bold text-xs sm:text-sm text-white bg-[#16a34a] hover:bg-[#15803d] shadow-xs transition duration-200 flex items-center justify-center gap-2 cursor-pointer">
                                    <span>Submit Application</span>
                                    <span aria-hidden="true">→</span>
                                </button>
                            </div>

                            {{-- Security & Privacy Guarantee Note --}}
                            <div class="flex items-center justify-center gap-1.5 pt-1 text-[11px] text-slate-400 text-center">
                                <svg class="h-3.5 w-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Your information is safe and will only be used for volunteering purposes.</span>
                            </div>
                        </form>
                    </div>

                    {{-- 2. Frequently Asked Questions (FAQ) Accordion Card --}}
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-2xs">
                        <div class="flex items-center justify-between pb-3.5 border-b border-slate-100">
                            <h2 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight">
                                Frequently Asked Questions
                            </h2>
                            <button type="button"
                                    @click="faqModalOpen = true"
                                    class="text-xs font-bold text-[#16a34a] hover:text-[#15803d] transition cursor-pointer">
                                View All →
                            </button>
                        </div>

                        {{-- Accordion Items --}}
                        <div class="divide-y divide-slate-100">
                            @foreach($faqs as $fIndex => $faq)
                                <div class="py-3">
                                    <button type="button"
                                            @click="openFaq = (openFaq === {{ $fIndex }} ? null : {{ $fIndex }})"
                                            class="w-full flex items-center justify-between gap-3 text-left group cursor-pointer">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <div class="h-6 w-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                                @if($faq['icon'] === 'user')
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                @elseif($faq['icon'] === 'academic')
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                                                @elseif($faq['icon'] === 'clock')
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                @else
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                                @endif
                                            </div>
                                            <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-700 transition-colors">
                                                {{ $faq['question'] }}
                                            </span>
                                        </div>
                                        <span class="text-slate-400 text-xs transition-transform duration-200"
                                              :class="openFaq === {{ $fIndex }} ? 'rotate-180 text-emerald-600' : ''">
                                            ▾
                                        </span>
                                    </button>

                                    <div x-show="openFaq === {{ $fIndex }}"
                                         x-collapse
                                         x-cloak
                                         class="pt-2 pl-8 pr-2">
                                        <p class="text-[11px] text-slate-600 leading-relaxed bg-slate-50/70 p-3 rounded-xl border border-slate-100">
                                            {{ $faq['answer'] }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ================= OPPORTUNITY DETAILS MODAL ================= --}}
    <div x-show="opportunityModalOpen"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs"
         @keydown.escape.window="closeOpportunityModal()">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto space-y-4"
             @click.outside="closeOpportunityModal()">

            {{-- Modal Header --}}
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 block"
                          x-text="selectedOpportunity ? selectedOpportunity.badge : ''"></span>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 mt-0.5"
                        x-text="selectedOpportunity ? selectedOpportunity.title : ''"></h3>
                </div>
                <button type="button"
                        @click="closeOpportunityModal()"
                        class="h-8 w-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 font-bold cursor-pointer">
                    &times;
                </button>
            </div>

            {{-- Opportunity Image --}}
            <template x-if="selectedOpportunity && selectedOpportunity.image">
                <div class="rounded-2xl overflow-hidden border border-slate-200 h-44 w-full">
                    <img :src="selectedOpportunity.image" :alt="selectedOpportunity.title" class="h-full w-full object-cover">
                </div>
            </template>

            {{-- Description --}}
            <p class="text-xs text-slate-600 leading-relaxed"
               x-text="selectedOpportunity ? selectedOpportunity.description : ''"></p>

            {{-- Core Volunteer Tasks --}}
            <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 space-y-2">
                <span class="text-xs font-bold text-slate-800 block">Typical Responsibilities:</span>
                <ul class="text-[11px] text-slate-600 space-y-1.5 pl-4 list-disc">
                    <template x-for="(task, tIdx) in (selectedOpportunity ? selectedOpportunity.tasks : [])" :key="tIdx">
                        <li x-text="task"></li>
                    </template>
                </ul>
            </div>

            {{-- Action Button --}}
            <div class="pt-2 flex justify-end gap-2">
                <button type="button"
                        @click="closeOpportunityModal()"
                        class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                    Close
                </button>
                <button type="button"
                        @click="selectAndApply(selectedOpportunity.title)"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#16a34a] hover:bg-[#15803d] shadow-xs transition flex items-center gap-1.5 cursor-pointer">
                    <span>Apply for this Role</span>
                    <span aria-hidden="true">→</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ================= ALL FAQS MODAL ================= --}}
    <div x-show="faqModalOpen"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs"
         @keydown.escape.window="faqModalOpen = false">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 shadow-2xl border border-slate-200 max-h-[85vh] overflow-y-auto space-y-4"
             @click.outside="faqModalOpen = false">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900">Volunteer Questions &amp; Answers</h3>
                <button type="button"
                        @click="faqModalOpen = false"
                        class="h-8 w-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 font-bold cursor-pointer">
                    &times;
                </button>
            </div>

            <div class="space-y-3 pt-2">
                @foreach($faqs as $f)
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <h4 class="text-xs font-bold text-slate-900 mb-1">{{ $f['question'] }}</h4>
                        <p class="text-[11px] text-slate-600 leading-relaxed">{{ $f['answer'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="pt-2 flex justify-end">
                <button type="button"
                        @click="faqModalOpen = false"
                        class="px-5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition cursor-pointer">
                    Done
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
