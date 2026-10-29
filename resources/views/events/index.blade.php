@extends('layouts.base')

@section('title', 'Events - ' . (function_exists('setting') ? setting('ngo_name', 'Hope Foundation') : 'Hope Foundation'))

@section('content')
<div x-data="{
    activeType: '{{ $type }}',
    activeCategory: '{{ $category }}',
    activeLocation: '{{ $location }}',
    locationDropdownOpen: false,
    mobileFilterOpen: false,
    upcomingIndex: 0,
    pastIndex: 0,
    upcomingTotal: {{ count($upcomingEvents) }},
    pastTotal: {{ count($pastEvents) }},
    filterCategory(cat) {
        this.activeCategory = cat;
        const url = new URL(window.location.href);
        if (cat === 'all') {
            url.searchParams.delete('category');
        } else {
            url.searchParams.set('category', cat);
        }
        window.location.href = url.toString();
    },
    filterType(t) {
        this.activeType = t;
        const url = new URL(window.location.href);
        if (t === 'all') {
            url.searchParams.delete('type');
        } else {
            url.searchParams.set('type', t);
        }
        window.location.href = url.toString();
    },
    filterLocation(loc) {
        this.activeLocation = loc;
        this.locationDropdownOpen = false;
        const url = new URL(window.location.href);
        if (loc === 'all' || loc === 'All Locations') {
            url.searchParams.delete('location');
        } else {
            url.searchParams.set('location', loc);
        }
        window.location.href = url.toString();
    }
}">

    {{-- ================= HERO SECTION ================= --}}
    <section class="relative isolate overflow-hidden bg-[#041f13] text-white">
        {{-- Background Image with Forest Depth Gradient Overlay --}}
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1600&auto=format&fit=crop"
                 alt="Hope Foundation Events"
                 class="h-full w-full object-cover object-[center_30%] opacity-25 mix-blend-luminosity brightness-110 contrast-105">
            <div class="absolute inset-0 bg-gradient-to-r from-[#031b10] via-[#052819]/90 to-[#041f13]/50"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#031b10] via-transparent to-transparent opacity-80"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8 lg:pb-16 lg:pt-14">
            <div class="grid grid-cols-1 items-center gap-8 lg:grid-cols-12">
                <div class="lg:col-span-8">
                    <span class="text-xs font-bold uppercase tracking-widest text-[#4ade80] block mb-2">
                        OUR EVENTS
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl leading-[1.15]">
                        Join Our Events<br>Be a Part of Change
                    </h1>
                    <p class="mt-3 max-w-xl text-sm leading-relaxed text-emerald-50/90 sm:text-base">
                        From awareness drives to community support programs, our events bring people together for a better tomorrow.
                    </p>
                </div>

                {{-- Right: Playful Handwritten Sticker (Desktop) --}}
                <div class="hidden lg:flex lg:col-span-4 flex-col items-end justify-center select-none pl-6">
                    <div class="text-right font-serif italic text-emerald-200/90 text-3xl leading-snug tracking-wide">
                        <span>People</span><br>
                        <span>Events <span class="text-emerald-400 not-italic">💚</span></span><br>
                        <span>Impact</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= MAIN CONTENT ================= --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

        {{-- ================= FILTER & NAVIGATION BAR ================= --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 sm:mb-10">
            
            {{-- Filter Pills (Horizontal Scroll on Mobile) --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-none">
                {{-- All Events --}}
                <button type="button" @click="filterType('all')"
                        :class="(activeType === 'all' && activeCategory === 'all') ? 'bg-[#16a34a] text-white shadow-xs font-semibold' : 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-medium'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm whitespace-nowrap transition cursor-pointer shrink-0">
                    All Events
                </button>

                {{-- Upcoming --}}
                <button type="button" @click="filterType('upcoming')"
                        :class="(activeType === 'upcoming') ? 'bg-[#16a34a] text-white shadow-xs font-semibold' : 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-medium'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm whitespace-nowrap transition cursor-pointer flex items-center gap-1.5 shrink-0">
                    <svg class="w-4 h-4 text-slate-500" :class="activeType === 'upcoming' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Upcoming</span>
                </button>

                {{-- Past Events --}}
                <button type="button" @click="filterType('past')"
                        :class="(activeType === 'past') ? 'bg-[#16a34a] text-white shadow-xs font-semibold' : 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-medium'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm whitespace-nowrap transition cursor-pointer flex items-center gap-1.5 shrink-0">
                    <svg class="w-4 h-4 text-slate-500" :class="activeType === 'past' ? 'text-white' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Past Events</span>
                </button>

                {{-- Education --}}
                <button type="button" @click="filterCategory('education')"
                        :class="(activeCategory === 'education') ? 'bg-[#16a34a] text-white shadow-xs font-semibold' : 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-medium'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm whitespace-nowrap transition cursor-pointer flex items-center gap-1.5 shrink-0">
                    <svg class="w-4 h-4 text-blue-500" :class="activeCategory === 'education' ? 'text-white' : 'text-blue-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5"/></svg>
                    <span>Education</span>
                </button>

                {{-- Healthcare --}}
                <button type="button" @click="filterCategory('healthcare')"
                        :class="(activeCategory === 'healthcare') ? 'bg-[#16a34a] text-white shadow-xs font-semibold' : 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-medium'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm whitespace-nowrap transition cursor-pointer flex items-center gap-1.5 shrink-0">
                    <svg class="w-4 h-4 text-rose-500" :class="activeCategory === 'healthcare' ? 'text-white' : 'text-rose-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <span>Healthcare</span>
                </button>

                {{-- Environment --}}
                <button type="button" @click="filterCategory('environment')"
                        :class="(activeCategory === 'environment') ? 'bg-[#16a34a] text-white shadow-xs font-semibold' : 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-medium'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm whitespace-nowrap transition cursor-pointer flex items-center gap-1.5 shrink-0">
                    <svg class="w-4 h-4 text-emerald-500" :class="activeCategory === 'environment' ? 'text-white' : 'text-emerald-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    <span>Environment</span>
                </button>

                {{-- Community --}}
                <button type="button" @click="filterCategory('community')"
                        :class="(activeCategory === 'community') ? 'bg-[#16a34a] text-white shadow-xs font-semibold' : 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-medium'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm whitespace-nowrap transition cursor-pointer flex items-center gap-1.5 shrink-0">
                    <svg class="w-4 h-4 text-purple-500" :class="activeCategory === 'community' ? 'text-white' : 'text-purple-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Community</span>
                </button>
            </div>

            {{-- Right: Locations Dropdown --}}
            <div class="relative shrink-0 flex items-center justify-end">
                <button type="button" @click="locationDropdownOpen = !locationDropdownOpen"
                        class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-medium bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 flex items-center gap-2 cursor-pointer shadow-2xs">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span x-text="activeLocation === 'all' ? 'All Locations' : activeLocation">
                        {{ $location === 'all' ? 'All Locations' : $location }}
                    </span>
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                {{-- Dropdown Menu --}}
                <div x-show="locationDropdownOpen" @click.away="locationDropdownOpen = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     style="display: none;"
                     class="absolute right-0 top-full mt-2 w-56 rounded-2xl bg-white shadow-xl border border-slate-200 py-2 z-30">
                    @foreach($locations as $loc)
                        <button type="button" @click="filterLocation('{{ $loc }}')"
                                class="w-full text-left px-4 py-2 text-xs sm:text-sm hover:bg-emerald-50 hover:text-emerald-800 transition flex items-center justify-between {{ ($location === $loc || ($loc === 'All Locations' && $location === 'all')) ? 'font-bold text-emerald-700 bg-emerald-50/50' : 'text-slate-700' }}">
                            <span>{{ $loc }}</span>
                            @if($location === $loc || ($loc === 'All Locations' && $location === 'all'))
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ================= UPCOMING EVENTS SECTION ================= --}}
        @if($type === 'all' || $type === 'upcoming')
            <section class="mb-12 sm:mb-16">
                <div class="flex items-center justify-between mb-5 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                        Upcoming Events
                    </h2>
                    <button type="button" @click="filterType('upcoming')"
                            class="text-xs sm:text-sm font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 transition">
                        <span>View All</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </div>

                {{-- Desktop Grid (4 Columns) --}}
                <div class="hidden sm:grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($upcomingEvents as $event)
                        <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                {{-- Card Image with Date Sticker & Category Badge --}}
                                <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                                    <img src="{{ $event['banner_image'] }}"
                                         alt="{{ $event['title'] }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    
                                    {{-- Top-Left Date Sticker --}}
                                    <div class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs rounded-xl px-2.5 py-1.5 shadow-sm text-center border border-slate-100 min-w-[50px]">
                                        <div class="text-base sm:text-lg font-black text-slate-900 leading-none">
                                            {{ $event['day'] }}
                                        </div>
                                        <div class="text-[10px] font-semibold text-slate-500 leading-none mt-1">
                                            {{ $event['month_year'] }}
                                        </div>
                                    </div>

                                    {{-- Bottom-Right Category Badge --}}
                                    <div class="absolute bottom-3 right-3 bg-white/95 backdrop-blur-xs rounded-full px-2.5 py-1 shadow-xs border border-slate-100 flex items-center gap-1.5 text-[11px] font-semibold text-slate-700">
                                        @if($event['category_color'] === 'blue')
                                            <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5"/></svg>
                                        @elseif($event['category_color'] === 'rose')
                                            <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        @elseif($event['category_color'] === 'emerald')
                                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                        @else
                                            <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        @endif
                                        <span>{{ $event['category_name'] }}</span>
                                    </div>
                                </div>

                                {{-- Card Content --}}
                                <div class="p-4 sm:p-5">
                                    <h3 class="font-bold text-slate-900 text-sm sm:text-base leading-snug line-clamp-1 group-hover:text-emerald-700 transition">
                                        <a href="{{ route('events.show', $event['slug']) }}">
                                            {{ $event['title'] }}
                                        </a>
                                    </h3>
                                    <p class="text-xs text-slate-500 line-clamp-2 mt-1.5 leading-relaxed">
                                        {{ $event['description'] }}
                                    </p>

                                    {{-- Meta Details --}}
                                    <div class="mt-3.5 space-y-1.5 text-xs text-slate-600 font-medium">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <span class="truncate">{{ $event['formatted_date'] }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span class="truncate">{{ $event['time_range'] }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span class="truncate">{{ $event['location_name'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Button at bottom --}}
                            <div class="px-4 pb-4 sm:px-5 sm:pb-5">
                                <a href="{{ route('events.show', $event['slug']) }}"
                                   class="w-full py-2.5 bg-[#16a34a] hover:bg-emerald-700 text-white font-semibold text-xs sm:text-sm rounded-xl transition text-center shadow-xs flex items-center justify-center gap-1.5">
                                    <span>Register Now</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-10 text-center bg-white rounded-2xl border border-slate-200 p-6">
                            <p class="text-xs sm:text-sm text-slate-500">No upcoming events found matching the selected filters.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Mobile Carousel (1 Card visible at a time with indicator dots) --}}
                <div class="block sm:hidden">
                    <div class="relative overflow-hidden">
                        @foreach($upcomingEvents as $index => $event)
                            <div x-show="upcomingIndex === {{ $index }}"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-x-4"
                                 x-transition:enter-end="opacity-100 translate-x-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-x-0"
                                 x-transition:leave-end="opacity-0 -translate-x-4"
                                 class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs">
                                <div>
                                    <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                                        <img src="{{ $event['banner_image'] }}"
                                             alt="{{ $event['title'] }}"
                                             class="w-full h-full object-cover">
                                        <div class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs rounded-xl px-2.5 py-1.5 shadow-sm text-center border border-slate-100 min-w-[50px]">
                                            <div class="text-base font-black text-slate-900 leading-none">{{ $event['day'] }}</div>
                                            <div class="text-[10px] font-semibold text-slate-500 leading-none mt-1">{{ $event['month_year'] }}</div>
                                        </div>
                                        <div class="absolute bottom-3 right-3 bg-white/95 backdrop-blur-xs rounded-full px-2.5 py-1 shadow-xs border border-slate-100 flex items-center gap-1.5 text-[11px] font-semibold text-slate-700">
                                            <span>{{ $event['category_name'] }}</span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-bold text-slate-900 text-sm leading-snug line-clamp-1">
                                            <a href="{{ route('events.show', $event['slug']) }}">{{ $event['title'] }}</a>
                                        </h3>
                                        <p class="text-xs text-slate-500 line-clamp-2 mt-1.5 leading-relaxed">{{ $event['description'] }}</p>
                                        <div class="mt-3.5 space-y-1.5 text-xs text-slate-600 font-medium">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                <span>{{ $event['formatted_date'] }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <span>{{ $event['time_range'] }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                <span>{{ $event['location_name'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 pb-4">
                                    <a href="{{ route('events.show', $event['slug']) }}"
                                       class="w-full py-2.5 bg-[#16a34a] hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl transition text-center shadow-xs flex items-center justify-center gap-1.5">
                                        <span>Register Now</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Carousel Dots Indicator --}}
                    @if(count($upcomingEvents) > 1)
                        <div class="flex items-center justify-center gap-1.5 mt-4">
                            @foreach($upcomingEvents as $index => $event)
                                <button type="button" @click="upcomingIndex = {{ $index }}"
                                        :class="upcomingIndex === {{ $index }} ? 'w-5 bg-[#16a34a]' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                                        class="h-2 rounded-full transition-all cursor-pointer">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @endif

        {{-- ================= PAST EVENTS SECTION ================= --}}
        @if($type === 'all' || $type === 'past')
            <section class="mb-12 sm:mb-16">
                <div class="flex items-center justify-between mb-5 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                        Past Events
                    </h2>
                    <button type="button" @click="filterType('past')"
                            class="text-xs sm:text-sm font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 transition">
                        <span>View All</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </div>

                {{-- Desktop Grid (4 Columns) --}}
                <div class="hidden sm:grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($pastEvents as $event)
                        <div class="bg-white rounded-2xl border border-slate-200/80 p-3 sm:p-3.5 shadow-xs hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                {{-- Top Split: Left Photo & Right Date Block --}}
                                <div class="flex items-stretch gap-3">
                                    <div class="w-1/2 aspect-[4/3] rounded-xl overflow-hidden bg-slate-100 shrink-0">
                                        <img src="{{ $event['banner_image'] }}"
                                             alt="{{ $event['title'] }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                    <div class="w-1/2 flex flex-col items-center justify-center text-center pl-1">
                                        <div class="text-2xl sm:text-3xl font-black text-slate-900 leading-none">
                                            {{ $event['day'] }}
                                        </div>
                                        <div class="text-xs font-medium text-slate-500 mt-1">
                                            {{ $event['month_year'] }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Title & Summary --}}
                                <div class="mt-3">
                                    <h3 class="font-bold text-slate-900 text-sm sm:text-base leading-snug line-clamp-1 group-hover:text-emerald-700 transition">
                                        <a href="{{ route('events.show', $event['slug']) }}">
                                            {{ $event['title'] }}
                                        </a>
                                    </h3>
                                    <p class="text-xs text-slate-500 line-clamp-2 mt-1 leading-relaxed">
                                        {{ $event['outcome_summary'] }}
                                    </p>
                                </div>
                            </div>

                            {{-- View Highlights Link --}}
                            <div class="mt-3.5 pt-2">
                                <a href="{{ route('events.show', $event['slug']) }}"
                                   class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1 transition">
                                    <span>View Highlights</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-10 text-center bg-white rounded-2xl border border-slate-200 p-6">
                            <p class="text-xs sm:text-sm text-slate-500">No past events found matching the selected filters.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Mobile Carousel (1 Card visible at a time with indicator dots) --}}
                <div class="block sm:hidden">
                    <div class="relative overflow-hidden">
                        @foreach($pastEvents as $index => $event)
                            <div x-show="pastIndex === {{ $index }}"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-x-4"
                                 x-transition:enter-end="opacity-100 translate-x-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-x-0"
                                 x-transition:leave-end="opacity-0 -translate-x-4"
                                 class="bg-white rounded-2xl border border-slate-200/80 p-3.5 shadow-xs">
                                <div>
                                    <div class="flex items-stretch gap-3">
                                        <div class="w-1/2 aspect-[4/3] rounded-xl overflow-hidden bg-slate-100 shrink-0">
                                            <img src="{{ $event['banner_image'] }}"
                                                 alt="{{ $event['title'] }}"
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <div class="w-1/2 flex flex-col items-center justify-center text-center pl-1">
                                            <div class="text-2xl font-black text-slate-900 leading-none">{{ $event['day'] }}</div>
                                            <div class="text-xs font-medium text-slate-500 mt-1">{{ $event['month_year'] }}</div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h3 class="font-bold text-slate-900 text-sm leading-snug line-clamp-1">
                                            <a href="{{ route('events.show', $event['slug']) }}">{{ $event['title'] }}</a>
                                        </h3>
                                        <p class="text-xs text-slate-500 line-clamp-2 mt-1 leading-relaxed">{{ $event['outcome_summary'] }}</p>
                                    </div>
                                </div>
                                <div class="mt-3 pt-2">
                                    <a href="{{ route('events.show', $event['slug']) }}"
                                       class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1">
                                        <span>View Highlights</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Carousel Dots Indicator --}}
                    @if(count($pastEvents) > 1)
                        <div class="flex items-center justify-center gap-1.5 mt-4">
                            @foreach($pastEvents as $index => $event)
                                <button type="button" @click="pastIndex = {{ $index }}"
                                        :class="pastIndex === {{ $index }} ? 'w-5 bg-[#16a34a]' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                                        class="h-2 rounded-full transition-all cursor-pointer">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @endif

        {{-- ================= CALL TO ACTION BANNER ================= --}}
        <section class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 mt-12 mb-8 shadow-xs">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                
                {{-- Left: Children Avatar & Heading --}}
                <div class="flex items-center gap-4 sm:gap-5">
                    <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=300&auto=format&fit=crop"
                         alt="Community Impact"
                         class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover shrink-0 border-2 border-emerald-500/20 shadow-2xs">
                    <div>
                        <h3 class="text-base sm:text-xl font-bold text-slate-900 leading-snug">
                            Want to Organize an Event with Us?
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                            Become a volunteer or partner with us to create impactful events in your community.
                        </p>
                    </div>
                </div>

                {{-- Right: Action Buttons --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 shrink-0">
                    <a href="{{ route('volunteers.create') }}"
                       class="py-2.5 px-5 bg-[#16a34a] hover:bg-emerald-700 text-white font-semibold text-xs sm:text-sm rounded-xl transition shadow-xs flex items-center justify-center gap-1.5">
                        <span>Become a Volunteer</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ route('contact.index') }}"
                       class="hidden sm:inline-flex py-2.5 px-5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-xs sm:text-sm rounded-xl transition items-center justify-center gap-1.5">
                        <span>Contact Us</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </section>

    </main>
</div>
@endsection
