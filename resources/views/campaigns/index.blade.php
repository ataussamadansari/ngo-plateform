@extends('layouts.base')

@section('title', 'Our Campaigns - ' . (function_exists('setting') ? setting('ngo_name', 'Hope Foundation') : 'Hope Foundation'))

@section('content')
    @php
        $heroImage = 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=2200&q=90';
        $currentCategory = request('category');
        $currentSort = request('sort', 'latest');
    @endphp

    <!-- ================= HERO SECTION ================= -->
    <section class="relative isolate overflow-hidden bg-[#041f13] text-white">
        <!-- Background Image with Dark Forest Depth Overlay -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <img src="{{ $heroImage }}" alt="Children smiling together"
                class="h-full w-full object-cover object-[center_38%] opacity-45 mix-blend-luminosity brightness-110 contrast-105 sm:opacity-50">
            <!-- Dual Layer Gradient: solid dark green on left, subtle fade across right -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#031b10] via-[#052819]/90 to-[#041f13]/40"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#031b10] via-transparent to-transparent opacity-80"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-14 lg:px-8 lg:py-16">
            <div class="grid grid-cols-1 items-center gap-8 lg:grid-cols-12">
                <!-- Left: Hero Headline & Subtitle -->
                <div class="lg:col-span-8">
                    <span
                        class="inline-block text-[11px] font-extrabold uppercase tracking-[0.22em] text-[#4ade80] sm:text-xs">
                        OUR CAMPAIGNS
                    </span>
                    <span class="sr-only">Support Our Active Causes</span>
                    <h1
                        class="mt-2 text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl leading-[1.15]">
                        Support Causes<br class="hidden sm:inline"> That Change Lives
                    </h1>
                    <p class="mt-3.5 max-w-xl text-sm leading-relaxed text-emerald-50/90 sm:text-base">
                        Your small contribution can make a big difference.<br class="hidden sm:inline">
                        Choose a campaign and be a part of real change.
                    </p>
                </div>

                <!-- Right: Handwritten Script Badge (Desktop Only per Mockup) -->
                <div class="hidden lg:flex lg:col-span-4 justify-end">
                    <div class="transform -rotate-6 text-center select-none pointer-events-none pr-4">
                        <p class="font-script text-3xl xl:text-4xl font-normal leading-tight text-white drop-shadow-md">
                            Together<br>
                            for a<br>
                            Brighter<br>
                            Tomorrow <span class="inline-block text-2xl xl:text-3xl text-[#4ade80]">💚</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= MAIN CAMPAIGNS DIRECTORY ================= -->
    <main class="bg-[#f8fafc] py-8 sm:py-10 lg:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- ================= CATEGORY FILTER PILLS & SORT BAR ================= -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 mb-8">

                <!-- Category Pills (Horizontal Scroll on Mobile, Flex Wrap on Desktop) -->
                <nav aria-label="Campaign Categories"
                    class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    <!-- All Campaigns Pill -->
                    <a href="{{ route('campaigns.index', request()->except('category', 'page')) }}"
                        class="inline-flex h-10 shrink-0 items-center justify-center rounded-xl px-4 text-xs sm:text-sm font-bold transition shadow-xs {{ empty($currentCategory) ? 'bg-[#16a34a] text-white' : 'bg-white border border-slate-200/90 text-slate-700 hover:border-emerald-500 hover:text-emerald-700' }}">
                        <span class="sm:hidden">All</span>
                        <span class="hidden sm:inline">All Campaigns</span>
                    </a>

                    @if(isset($categories) && $categories->isNotEmpty())
                        @foreach($categories as $cat)
                            @php
                                $catSlug = strtolower(trim($cat->slug ?? $cat->name));
                                $isActive = ($currentCategory === $cat->slug || $currentCategory == $cat->id);
                            @endphp
                            <a href="{{ route('campaigns.index', array_merge(request()->except('category', 'page'), ['category' => $cat->slug])) }}"
                                class="inline-flex h-10 shrink-0 items-center gap-1.5 rounded-xl px-3.5 text-xs sm:text-sm font-bold transition shadow-xs {{ $isActive ? 'bg-[#16a34a] text-white border-transparent' : 'bg-white border border-slate-200/90 text-slate-700 hover:border-emerald-500 hover:text-emerald-700' }}">
                                @if(str_contains($catSlug, 'education') || str_contains($catSlug, 'school') || str_contains($catSlug, 'child'))
                                    <svg class="h-4 w-4 {{ $isActive ? 'text-white' : 'text-blue-500' }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    </svg>
                                @elseif(str_contains($catSlug, 'health') || str_contains($catSlug, 'medical'))
                                    <svg class="h-4 w-4 {{ $isActive ? 'text-white' : 'text-rose-500' }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                @elseif(str_contains($catSlug, 'water'))
                                    <svg class="h-4 w-4 {{ $isActive ? 'text-white' : 'text-sky-500' }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                @elseif(str_contains($catSlug, 'food') || str_contains($catSlug, 'nutrition'))
                                    <svg class="h-4 w-4 {{ $isActive ? 'text-white' : 'text-amber-500' }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @elseif(str_contains($catSlug, 'environment') || str_contains($catSlug, 'tree'))
                                    <svg class="h-4 w-4 {{ $isActive ? 'text-white' : 'text-emerald-600' }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                @elseif(str_contains($catSlug, 'community') || str_contains($catSlug, 'skill'))
                                    <svg class="h-4 w-4 {{ $isActive ? 'text-white' : 'text-purple-600' }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                @else
                                    <svg class="h-4 w-4 {{ $isActive ? 'text-white' : 'text-emerald-600' }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                @endif
                                <span>{{ $cat->name }}</span>
                            </a>
                        @endforeach
                    @else
                        <!-- Fallback Category Pills matching Design Mockup -->
                        @foreach([
                                ['Education', 'education', 'blue'],
                                ['Healthcare', 'healthcare', 'rose'],
                                ['Clean Water', 'clean-water', 'sky'],
                                ['Food', 'food', 'amber'],
                                ['Environment', 'environment', 'emerald'],
                                ['Community', 'community', 'purple'],
                            ] as [$name, $slug, $color])
                            <a href="{{ route('campaigns.index', ['category' => $slug]) }}"
                                class="inline-flex h-10 shrink-0 items-center gap-1.5 rounded-xl border border-slate-200/90 bg-white px-3.5 text-xs sm:text-sm font-bold text-slate-700 shadow-xs hover:border-emerald-500 hover:text-emerald-700 transition">
                                <span class="h-2 w-2 rounded-full bg-{{ $color }}-500"></span>
                                <span>{{ $name }}</span>
                            </a>
                        @endforeach
                    @endif
                </nav>

                <!-- Sort Dropdown on Desktop (matches mockup 'Latest First ▾') -->
                <div class="hidden sm:flex items-center gap-2 shrink-0">
                    <form action="{{ route('campaigns.index') }}" method="GET" class="inline-flex items-center">
                        @if(request()->filled('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request()->filled('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif

                        <label for="campaign-sort" class="sr-only">Sort Campaigns</label>
                        <select id="campaign-sort" name="sort" onchange="this.form.submit()"
                            class="h-10 rounded-xl border border-slate-200/90 bg-white px-3.5 py-2 text-xs sm:text-sm font-semibold text-slate-700 shadow-xs outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition cursor-pointer">
                            <option value="latest" @selected($currentSort === 'latest')>Latest First ▾</option>
                            <option value="oldest" @selected($currentSort === 'oldest')>Oldest First ▾</option>
                            <option value="popular" @selected($currentSort === 'popular')>Most Funded ▾</option>
                            <option value="urgent" @selected($currentSort === 'urgent')>Urgent Causes ▾</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- ================= CAMPAIGNS GRID  ================= -->
            @if(isset($campaigns) && $campaigns->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
                    @foreach($campaigns as $campaign)
                        <x-campaign-card :campaign="$campaign" />
                    @endforeach
                </div>

                <!-- Pagination Bar (Numbered with Arrows per Mockup) -->
                <div class="mt-10 flex justify-center pb-4">
                    <div
                        class="[&_nav]:flex [&_nav]:items-center [&_nav]:gap-1.5 [&_a]:h-9 [&_a]:min-w-[36px] [&_a]:px-3 [&_a]:rounded-lg [&_a]:border [&_a]:border-slate-200 [&_a]:bg-white [&_a]:text-xs [&_a]:font-bold [&_a]:text-slate-700 [&_a]:flex [&_a]:items-center [&_a]:justify-center [&_a:hover]:bg-slate-50 [&_span[aria-current=page]]:h-9 [&_span[aria-current=page]]:min-w-[36px] [&_span[aria-current=page]]:px-3 [&_span[aria-current=page]]:rounded-lg [&_span[aria-current=page]]:bg-[#16a34a] [&_span[aria-current=page]]:text-xs [&_span[aria-current=page]]:font-bold [&_span[aria-current=page]]:text-white [&_span[aria-current=page]]:flex [&_span[aria-current=page]]:items-center [&_span[aria-current=page]]:justify-center [&_span[aria-disabled=true]]:h-9 [&_span[aria-disabled=true]]:min-w-[36px] [&_span[aria-disabled=true]]:px-3 [&_span[aria-disabled=true]]:rounded-lg [&_span[aria-disabled=true]]:border [&_span[aria-disabled=true]]:border-slate-200/60 [&_span[aria-disabled=true]]:text-slate-300 [&_span[aria-disabled=true]]:flex [&_span[aria-disabled=true]]:items-center [&_span[aria-disabled=true]]:justify-center">
                        {{ $campaigns->links() }}
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div
                    class="rounded-2xl sm:rounded-3xl border border-slate-200/90 bg-white p-12 text-center shadow-[0_4px_25px_rgba(15,23,42,0.04)] my-6">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-slate-900">No Campaigns Found</h3>
                    <p class="mx-auto mt-1 max-w-sm text-xs sm:text-sm text-slate-500">
                        No active causes found matching this category filter. Try clearing the filter to view all causes.
                    </p>
                    <div class="mt-5">
                        <a href="{{ route('campaigns.index') }}"
                            class="inline-flex rounded-xl bg-[#16a34a] hover:bg-[#15803d] px-5 py-2.5 text-xs font-bold text-white transition">
                            View All Campaigns
                        </a>
                    </div>
                </div>
            @endif

            <!-- ================= BOTTOM BANNER: CAN'T FIND A CAMPAIGN? ================= -->
            <section aria-label="General Donation Appeal"
                class="relative mt-8 sm:mt-12 overflow-hidden rounded-2xl sm:rounded-3xl border border-[#d8f3df] bg-gradient-to-r from-[#edf7e9] via-[#f7fbf5] to-[#f1f8ed] p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-5">
                <div class="flex items-center gap-4 text-center sm:text-left">
                    <!-- Smiling Children Avatar Shape per Mockup -->
                    <div
                        class="relative h-16 w-16 sm:h-18 sm:w-18 shrink-0 overflow-hidden rounded-2xl border border-emerald-200/60 shadow-xs hidden sm:block">
                        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=350&q=85"
                            alt="Smiling children" loading="lazy" class="h-full w-full object-cover">
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-extrabold tracking-tight text-slate-900">
                            Can’t Find a Campaign?
                        </h3>
                        <p class="mt-0.5 text-xs sm:text-sm text-slate-600">
                            You can make a general donation to support our ongoing initiatives.
                        </p>
                    </div>
                </div>

                <div class="shrink-0 w-full sm:w-auto">
                    <a href="{{ route('donate.index') }}"
                        class="inline-flex w-full sm:w-auto min-h-[44px] items-center justify-center gap-2 rounded-xl bg-[#16a34a] hover:bg-[#15803d] px-7 py-2.5 text-xs sm:text-sm font-bold text-white shadow-sm transition hover:shadow cursor-pointer">
                        <span>Donate Now</span>
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </section>

        </div>
    </main>
@endsection