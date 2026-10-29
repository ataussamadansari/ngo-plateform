{{-- resources/views/pages/legal.blade.php --}}
@extends('layouts.base')

@section('title', 'Privacy Policy & Terms | ' . setting('ngo_name', 'Hope Foundation'))
@section('meta_description', 'Privacy Policy, Terms & Conditions, Donation Terms, and Legal Compliance of ' . setting('ngo_name', 'Hope Foundation') . '.')

@section('content')
@php
    $ngoName      = setting('ngo_name', 'Hope Foundation');
    $contactEmail = setting('contact_email', 'info@hopefoundation.org');
    $contactUrl   = Route::has('contact.index') ? route('contact.index') : url('/contact');
    $statusUrl    = Route::has('donation.status') ? route('donation.status') : (Route::has('donate.status') ? route('donate.status') : url('/donation-status'));

    $trustBadges = [
        [
            'title'    => 'Your Data is Safe',
            'subtitle' => 'We follow strict security practices',
            'icon'     => 'shield-check',
        ],
        [
            'title'    => 'Used Only for Genuine Purposes',
            'subtitle' => 'Your information helps us create impact',
            'icon'     => 'lock',
        ],
        [
            'title'    => 'Transparent Practices',
            'subtitle' => 'We are open about how we work',
            'icon'     => 'eye',
        ],
        [
            'title'    => 'Your Trust Drives Change',
            'subtitle' => 'Together for a better tomorrow',
            'icon'     => 'users',
        ],
    ];

    $navItems = [
        ['key' => 'privacy',     'label' => 'Privacy Policy',        'icon' => 'shield'],
        ['key' => 'terms',       'label' => 'Terms & Conditions',    'icon' => 'document'],
        ['key' => 'donations',   'label' => 'Donation Terms',        'icon' => 'heart'],
        ['key' => 'volunteers',  'label' => 'Volunteer Terms',       'icon' => 'users'],
        ['key' => 'refunds',     'label' => 'Refund & Cancellation', 'icon' => 'refresh'],
        ['key' => 'cookies',     'label' => 'Cookies Policy',        'icon' => 'cookie'],
        ['key' => 'security',    'label' => 'Data Security',         'icon' => 'lock'],
        ['key' => 'third_party', 'label' => 'Third-Party Services',  'icon' => 'link'],
        ['key' => 'disclaimer',  'label' => 'Disclaimer',            'icon' => 'info'],
        ['key' => 'compliance',  'label' => 'Legal Compliance',      'icon' => 'scale'],
    ];
@endphp

<div x-data="{ activeTab: '{{ $initialTab ?? request('tab', 'privacy') }}', mobileSection: 1 }" class="bg-[#fcfdfc]">

    {{-- ===================================================================
         1. TOP HERO BANNER (Smiling Child + Dark Forest Overlay + Script)
    ==================================================================== --}}
    <section class="relative overflow-hidden bg-[#0a2617] print:hidden">
        <div class="absolute inset-0 z-0">
            <img
                src="https://images.unsplash.com/photo-1542810634-71277d95dcbb?auto=format&fit=crop&w=1920&q=85"
                alt="Privacy Policy & Terms - {{ $ngoName }}"
                class="w-full h-full object-cover object-center"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-[#071f12]/94 via-[#0a2617]/75 to-black/30"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#071f12]/80 via-transparent to-black/20"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-11 sm:py-16 lg:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                {{-- Left Column --}}
                <div class="lg:col-span-7 text-white" data-reveal>
                    <span class="block text-[11px] sm:text-xs font-extrabold uppercase tracking-[0.2em] text-[#4ade80] mb-2.5">
                        PRIVACY POLICY &amp; TERMS
                    </span>

                    <h1 class="font-heading text-3xl sm:text-4xl lg:text-[44px] font-extrabold tracking-tight leading-[1.12] text-white mb-3.5">
                        Your Trust Matters<br>
                        We Value Your Privacy
                    </h1>

                    <p class="text-xs sm:text-sm lg:text-[15px] text-white/90 leading-relaxed max-w-xl">
                        We are committed to protecting your personal information and ensuring transparency in everything we do.
                    </p>
                </div>

                {{-- Right Column: Tilted Handwritten Script (Desktop) --}}
                <div class="hidden lg:flex lg:col-span-5 justify-end items-center pr-6" data-reveal data-reveal-delay="150">
                    <div class="transform -rotate-3 select-none text-left">
                        <p class="font-script text-3xl xl:text-[36px] text-white/95 leading-[1.12] drop-shadow-md">
                            Trust<br>
                            Transparency<br>
                            Stronger<br>
                            Communities <span class="text-[#16a34a] inline-block align-middle">💚</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================================================================
         2. 4-COLUMN SOFT-MINT TRUST BADGES STRIP (Desktop / Tablet)
    ==================================================================== --}}
    <section class="hidden sm:block pt-7 pb-2 print:hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5" data-reveal>
                @foreach($trustBadges as $badge)
                    <div class="bg-[#f2fbf5] rounded-2xl px-4 py-3.5 border border-[#d8f3df] shadow-2xs flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                            @if($badge['icon'] === 'shield-check')
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"/>
                                </svg>
                            @elseif($badge['icon'] === 'lock')
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd"/>
                                </svg>
                            @elseif($badge['icon'] === 'eye')
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z"/>
                                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-1.01.75.75 0 00.42-.643 4.875 4.875 0 00-6.957-4.611 8.586 8.586 0 011.71 5.157v.003z"/>
                                </svg>
                            @endif
                        </div>

                        <div class="min-w-0">
                            <h2 class="text-xs lg:text-[13.5px] font-extrabold text-[#14291b] leading-snug truncate">
                                {{ $badge['title'] }}
                            </h2>
                            <p class="text-[11px] text-slate-600 mt-0.5 leading-snug truncate">
                                {{ $badge['subtitle'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================================================================
         3. MAIN 2-COLUMN LAYOUT: SIDEBAR NAVIGATION + POLICY CONTENT CARD
    ==================================================================== --}}
    <section class="py-5 sm:py-7 pb-14 sm:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                {{-- LEFT COLUMN (3.5 / 4 Cols): Policy & Legal Navigation + Support Box --}}
                <aside class="lg:col-span-4 space-y-5 print:hidden" data-reveal>
                    <div class="bg-white rounded-3xl p-3.5 sm:p-6 border border-slate-200/80 shadow-xs">
                        <h2 class="hidden sm:block font-heading text-lg font-extrabold text-[#14291b] px-2 mb-3.5">
                            Policy &amp; Legal
                        </h2>

                        <nav class="divide-y divide-slate-100" aria-label="Policy Navigation">
                            @foreach($navItems as $item)
                                <button
                                    type="button"
                                    @click="activeTab = '{{ $item['key'] }}'"
                                    :class="activeTab === '{{ $item['key'] }}'
                                        ? 'bg-[#dcfce7]/80 text-[#15803d] font-extrabold rounded-xl border-transparent'
                                        : 'text-slate-700 hover:bg-slate-50 font-semibold'"
                                    class="w-full flex items-center justify-between px-3.5 py-3 text-xs sm:text-[13.5px] transition-all duration-150 text-left"
                                >
                                    <span class="flex items-center gap-3 min-w-0">
                                        {{-- Icon --}}
                                        <span :class="activeTab === '{{ $item['key'] }}' ? 'text-[#16a34a]' : 'text-slate-600'" class="shrink-0">
                                            @switch($item['icon'])
                                                @case('shield')
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"/></svg>
                                                    @break
                                                @case('document')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                                    @break
                                                @case('heart')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                                                    @break
                                                @case('users')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                                                    @break
                                                @case('refresh')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                                                    @break
                                                @case('cookie')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><circle cx="9" cy="10" r="1" fill="currentColor"/><circle cx="14" cy="9" r="1" fill="currentColor"/><circle cx="11" cy="14" r="1" fill="currentColor"/><circle cx="15" cy="14" r="1" fill="currentColor"/></svg>
                                                    @break
                                                @case('lock')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                                    @break
                                                @case('link')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                                                    @break
                                                @case('info')
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/></svg>
                                                    @break
                                                @default
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971z"/></svg>
                                            @endswitch
                                        </span>
                                        <span class="truncate">{{ $item['label'] }}</span>
                                    </span>

                                    {{-- Mobile Chevron Indicator --}}
                                    <span class="sm:hidden text-slate-400">
                                        <svg x-show="activeTab === '{{ $item['key'] }}'" class="w-4 h-4 text-[#16a34a]" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                        </svg>
                                        <svg x-show="activeTab !== '{{ $item['key'] }}'" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                        </svg>
                                    </span>
                                </button>
                            @endforeach
                        </nav>

                        {{-- Desktop Bottom Support Box ("Have any questions?") --}}
                        <div class="hidden sm:block mt-6 bg-[#f2fbf5] rounded-2xl p-4 border border-[#d8f3df]">
                            <div class="flex items-center gap-3 mb-3.5">
                                <span class="w-9 h-9 rounded-full bg-[#16a34a] text-white flex items-center justify-center shrink-0 text-sm font-extrabold">
                                    ?
                                </span>
                                <div>
                                    <h3 class="text-xs sm:text-sm font-extrabold text-[#14291b] leading-tight">
                                        Have any questions?
                                    </h3>
                                    <p class="text-[11px] text-slate-600 mt-0.5">
                                        Contact our support team.
                                    </p>
                                </div>
                            </div>

                            <a
                                href="{{ $contactUrl }}"
                                class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-white hover:bg-[#16a34a] text-[#16a34a] hover:text-white border border-[#16a34a] text-xs font-extrabold transition-all duration-200"
                            >
                                <span>Contact Us</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </aside>

                {{-- RIGHT COLUMN (8 Cols): Policy Content Card --}}
                <div class="lg:col-span-8" data-reveal data-reveal-delay="100">
                    <div class="bg-white rounded-3xl p-5 sm:p-8 lg:p-10 border border-slate-200/80 shadow-xs">

                        {{-- Card Header + Print Page Button --}}
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 pb-5 mb-6 border-b border-slate-100">
                            <div>
                                <h2
                                    class="font-heading text-2xl sm:text-[28px] font-extrabold text-[#14291b] tracking-tight"
                                    x-text="activeTab === 'privacy' ? 'Privacy Policy' :
                                            activeTab === 'terms' ? 'Terms & Conditions' :
                                            activeTab === 'donations' ? 'Donation Terms' :
                                            activeTab === 'volunteers' ? 'Volunteer Terms' :
                                            activeTab === 'refunds' ? 'Refund & Cancellation' :
                                            activeTab === 'cookies' ? 'Cookies Policy' :
                                            activeTab === 'security' ? 'Data Security' :
                                            activeTab === 'third_party' ? 'Third-Party Services' :
                                            activeTab === 'disclaimer' ? 'Disclaimer' : 'Legal Compliance'"
                                >
                                    Privacy Policy
                                </h2>
                                <p class="text-xs text-slate-500 mt-1">
                                    Last Updated: 15 October 2025
                                </p>
                            </div>

                            <button
                                type="button"
                                onclick="window.print()"
                                class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs shadow-2xs transition cursor-pointer print:hidden"
                            >
                                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"/>
                                </svg>
                                <span>Print Page</span>
                            </button>
                        </div>

                        {{-- =======================================================
                             TAB 1: PRIVACY POLICY (Desktop Full + Mobile Accordions)
                        ======================================================== --}}
                        <div x-show="activeTab === 'privacy'">

                            {{-- A. DESKTOP EXPANDED LAYOUT (Visible on sm and up) --}}
                            <div class="hidden sm:block space-y-7 text-slate-600 text-xs sm:text-[13.5px] leading-relaxed">

                                {{-- 1. Introduction --}}
                                <div class="space-y-2">
                                    <h3 class="text-base font-extrabold text-[#15803d]">
                                        1. Introduction
                                    </h3>
                                    <p>
                                        {{ $ngoName }} is committed to protecting your personal information and your right to privacy. This Privacy Policy explains how we collect, use, disclose and safeguard your information when you visit our website, make a donation, register for events, volunteer with us, or interact with our services.
                                    </p>
                                </div>

                                {{-- 2. Information We Collect --}}
                                <div class="space-y-3">
                                    <h3 class="text-base font-extrabold text-[#15803d]">
                                        2. Information We Collect
                                    </h3>
                                    <p class="text-slate-600">
                                        We may collect the following types of information:
                                    </p>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5 pt-1">
                                        {{-- Personal Information --}}
                                        <div class="bg-[#f7faf8] rounded-2xl p-4 border border-slate-200/70 flex items-start gap-3.5">
                                            <div class="w-10 h-10 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0 mt-0.5">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-extrabold text-[#14291b] text-xs sm:text-sm">Personal Information</h4>
                                                <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                                                    Name, email address, phone number, address and other details you provide through forms.
                                                </p>
                                            </div>
                                        </div>

                                        {{-- Payment Information --}}
                                        <div class="bg-[#f7faf8] rounded-2xl p-4 border border-slate-200/70 flex items-start gap-3.5">
                                            <div class="w-10 h-10 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0 mt-0.5">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M4.5 3.75a3 3 0 00-3 3v.75h21v-.75a3 3 0 00-3-3h-15z"/>
                                                    <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 003 3h15a3 3 0 003-3v-7.5zm-18 3.75a.75.75 0 01.75-.75h6a.75.75 0 010 1.5h-6a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-extrabold text-[#14291b] text-xs sm:text-sm">Payment Information</h4>
                                                <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                                                    Transaction details, UTR/reference number and payment method for donation verification.
                                                </p>
                                            </div>
                                        </div>

                                        {{-- Usage Information --}}
                                        <div class="bg-[#f7faf8] rounded-2xl p-4 border border-slate-200/70 flex items-start gap-3.5">
                                            <div class="w-10 h-10 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0 mt-0.5">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-extrabold text-[#14291b] text-xs sm:text-sm">Usage Information</h4>
                                                <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                                                    IP address, browser type, pages visited, and device information to improve our website.
                                                </p>
                                            </div>
                                        </div>

                                        {{-- Volunteering & Event Information --}}
                                        <div class="bg-[#f7faf8] rounded-2xl p-4 border border-slate-200/70 flex items-start gap-3.5">
                                            <div class="w-10 h-10 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0 mt-0.5">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-1.01.75.75 0 00.42-.643 4.875 4.875 0 00-6.957-4.611 8.586 8.586 0 011.71 5.157v.003z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-extrabold text-[#14291b] text-xs sm:text-sm">Volunteering &amp; Event Information</h4>
                                                <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                                                    Details you provide when registering for events or volunteer opportunities.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- 3. How We Use Your Information --}}
                                <div class="space-y-3">
                                    <h3 class="text-base font-extrabold text-[#15803d]">
                                        3. How We Use Your Information
                                    </h3>

                                    <ul class="space-y-2.5">
                                        @php
                                            $uses = [
                                                'To process and verify donations and issue receipts.',
                                                'To communicate with you about your donations, events, volunteering opportunities and our impact.',
                                                'To improve our website, services and user experience.',
                                                'To comply with legal and regulatory requirements.',
                                                'To send important updates, newsletters or appeals (only with your consent).',
                                            ];
                                        @endphp
                                        @foreach($uses as $use)
                                            <li class="flex items-start gap-2.5">
                                                <span class="w-4 h-4 rounded-full bg-[#16a34a] text-white flex items-center justify-center shrink-0 mt-0.5">
                                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                    </svg>
                                                </span>
                                                <span class="text-slate-700">{{ $use }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                {{-- 4. Data Sharing and Disclosure --}}
                                <div class="space-y-3">
                                    <h3 class="text-base font-extrabold text-[#15803d]">
                                        4. Data Sharing and Disclosure
                                    </h3>
                                    <p class="text-slate-600">
                                        We do not sell, rent or trade your personal information. We may share your information only in the following cases:
                                    </p>

                                    <div class="bg-[#f8fafc] rounded-2xl p-4 sm:p-5 border border-slate-200/80 space-y-3 text-xs sm:text-[13px] text-slate-700">
                                        <div class="flex items-start gap-3">
                                            <svg class="w-4 h-4 text-slate-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122z"/></svg>
                                            <span>With trusted payment partners (e.g., Razorpay, Paytm, banks) for processing donations.</span>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <svg class="w-4 h-4 text-slate-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                            <span>With service providers who help us operate our website, send emails or manage events (under confidentiality agreements).</span>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <svg class="w-4 h-4 text-slate-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25a.75.75 0 01.369.098l8.25 4.5a.75.75 0 01-.369 1.402H3.75a.75.75 0 01-.369-1.402l8.25-4.5A.75.75 0 0112 2.25zM4.5 9.75v8.25h3V9.75h-3zm6 0v8.25h3V9.75h-3zm6 0v8.25h3V9.75h-3zM2.25 19.5a.75.75 0 000 1.5h19.5a.75.75 0 000-1.5H2.25z" clip-rule="evenodd"/></svg>
                                            <span>When required by law, government authorities or regulatory bodies.</span>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <svg class="w-4 h-4 text-slate-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/></svg>
                                            <span>To protect our legal rights, safety and the security of our users and organization.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- B. MOBILE ACCORDION LAYOUT (Matches Mobile Mockup 1:1 on < sm) --}}
                            @php
                                $mobilePrivacySections = [
                                    [
                                        'num'   => 1,
                                        'title' => '1. Introduction',
                                        'body'  => $ngoName . ' is committed to protecting your personal information and your right to privacy. This Privacy Policy explains how we collect, use, disclose and safeguard your information when you visit our website, make a donation, register for events, volunteer with us, or interact with our services.',
                                    ],
                                    [
                                        'num'   => 2,
                                        'title' => '2. Information We Collect',
                                        'body'  => 'We collect Personal Information (name, email, phone, PAN, address), Payment Information (UTR/reference number and screenshot for donation verification), Usage Information (IP address, browser type), and Volunteering & Event registration details.',
                                    ],
                                    [
                                        'num'   => 3,
                                        'title' => '3. How We Use Your Information',
                                        'body'  => 'To process and verify donations and issue 80G receipts, communicate about events and volunteering, improve our website experience, and comply with statutory regulatory requirements.',
                                    ],
                                    [
                                        'num'   => 4,
                                        'title' => '4. Data Sharing and Disclosure',
                                        'body'  => 'We do not sell, rent or trade your personal information. We only share data with trusted banking/payment verification partners, bound service providers, or when required by law and regulatory bodies.',
                                    ],
                                    [
                                        'num'   => 5,
                                        'title' => '5. Data Security',
                                        'body'  => 'We follow strict security practices including SSL/TLS encryption and restricted administrative access to safeguard your personal and donation records.',
                                    ],
                                    [
                                        'num'   => 6,
                                        'title' => '6. Your Rights',
                                        'body'  => 'You have the right to access, update, or request deletion of your personal information, or opt out of newsletters at any time by contacting us at ' . $contactEmail . '.',
                                    ],
                                    [
                                        'num'   => 7,
                                        'title' => '7. Cookies',
                                        'body'  => 'We use essential cookies to keep our website secure, remember your preferences, and analyze aggregate traffic.',
                                    ],
                                    [
                                        'num'   => 8,
                                        'title' => '8. Third-Party Services',
                                        'body'  => 'Our website may contain links to third-party services such as Google Maps or social media platforms governed by their own privacy policies.',
                                    ],
                                    [
                                        'num'   => 9,
                                        'title' => '9. Updates to This Policy',
                                        'body'  => 'We may update this Privacy Policy periodically. Any changes will be posted on this page with an updated revision date.',
                                    ],
                                ];
                            @endphp

                            <div class="sm:hidden space-y-2.5">
                                @foreach($mobilePrivacySections as $sec)
                                    <div class="rounded-xl border border-slate-200/80 overflow-hidden bg-white">
                                        <button
                                            type="button"
                                            @click="mobileSection = (mobileSection === {{ $sec['num'] }} ? null : {{ $sec['num'] }})"
                                            :class="mobileSection === {{ $sec['num'] }} ? 'bg-[#f2fbf5] text-[#15803d]' : 'bg-white text-[#14291b]'"
                                            class="w-full px-3.5 py-3 flex items-center justify-between gap-2 text-left text-xs font-extrabold transition"
                                        >
                                            <span class="flex items-center gap-2">
                                                <span :class="mobileSection === {{ $sec['num'] }} ? 'bg-[#16a34a] text-white' : 'bg-slate-200 text-slate-700'" class="w-4 h-4 rounded-full flex items-center justify-center text-[10px]">
                                                    •
                                                </span>
                                                <span>{{ $sec['title'] }}</span>
                                            </span>
                                            <span class="text-sm font-bold" x-text="mobileSection === {{ $sec['num'] }} ? '−' : '+'"></span>
                                        </button>

                                        <div
                                            x-show="mobileSection === {{ $sec['num'] }}"
                                            x-collapse
                                            class="px-3.5 py-3 text-xs text-slate-600 leading-relaxed border-t border-slate-100"
                                        >
                                            {{ $sec['body'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- =======================================================
                             TAB 2: TERMS & CONDITIONS
                        ======================================================== --}}
                        <div x-show="activeTab === 'terms'" x-cloak class="space-y-6 text-slate-700 leading-relaxed text-xs sm:text-sm">
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">1. Acceptance of Terms</h3>
                                <p>
                                    By accessing or using the {{ $ngoName }} platform, you agree to comply with and be bound by these Terms &amp; Conditions. If you do not agree to these terms, please refrain from using our online services.
                                </p>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">2. Fee-Free Manual Donation Protocol</h3>
                                <p>
                                    All donations made on this website occur via direct UPI QR scanning or NEFT/IMPS/RTGS bank transfers directly to our non-profit bank account. Donors are responsible for submitting accurate UTR reference numbers to facilitate bank verification.
                                </p>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">3. Integrity of Proof Submissions</h3>
                                <p>
                                    Submitting fabricated, duplicate, or fraudulent UTR numbers or payment screenshots is strictly prohibited and will result in immediate rejection of the donation claim.
                                </p>
                            </div>
                        </div>

                        {{-- =======================================================
                             TAB 3: DONATION TERMS & 80G
                        ======================================================== --}}
                        <div x-show="activeTab === 'donations'" x-cloak class="space-y-6 text-slate-700 leading-relaxed text-xs sm:text-sm">
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">1. 80G Tax Exemption Eligibility</h3>
                                <p>
                                    {{ $ngoName }} is registered under Section 80G of the Income Tax Act, 1961 (Registration No: <span class="font-mono font-bold text-[#15803d]">{{ setting('80g_reg_number', 'AAATH1234AF') }}</span>). Eligible Indian tax residents can claim a 50% tax deduction on verified contributions.
                                </p>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">2. PAN Mandatory for Tax Receipts</h3>
                                <p>
                                    As per Government of India CBDT guidelines, a valid 10-digit Permanent Account Number (PAN) is required to issue Form 10BE compliant tax exemption certificates.
                                </p>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">3. Verification Timelines</h3>
                                <p>
                                    Because all donations are verified directly against our bank statement, verification typically concludes within 24 to 48 hours. You can check your verification status anytime via our <a href="{{ $statusUrl }}" class="text-[#16a34a] font-bold hover:underline">Track Donation Status</a> portal.
                                </p>
                            </div>
                        </div>

                        {{-- =======================================================
                             TAB 4: VOLUNTEER TERMS
                        ======================================================== --}}
                        <div x-show="activeTab === 'volunteers'" x-cloak class="space-y-6 text-slate-700 leading-relaxed text-xs sm:text-sm">
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">1. Voluntary Service</h3>
                                <p>
                                    Volunteering with {{ $ngoName }} is an honorary, uncompensated humanitarian service. Volunteers commit their time, skills, and passion to support community welfare drives.
                                </p>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">2. Code of Conduct &amp; Dignity</h3>
                                <p>
                                    Volunteers must treat every community member, child, patient, and beneficiary with utmost dignity, empathy, and respect.
                                </p>
                            </div>
                        </div>

                        {{-- =======================================================
                             TAB 5: REFUND & CANCELLATION
                        ======================================================== --}}
                        <div x-show="activeTab === 'refunds'" x-cloak class="space-y-6 text-slate-700 leading-relaxed text-xs sm:text-sm">
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">1. Non-Profit Donation Nature</h3>
                                <p>
                                    As voluntary philanthropic contributions immediately earmarked for ongoing community relief drives, donations are generally non-refundable once disbursed to beneficiaries.
                                </p>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">2. Accidental Duplicate Transfers</h3>
                                <p>
                                    In the event of an accidental duplicate transfer, please notify our team at <a href="mailto:{{ $contactEmail }}" class="text-[#16a34a] font-bold hover:underline">{{ $contactEmail }}</a> within 7 days with bank transaction proof for prompt resolution.
                                </p>
                            </div>
                        </div>

                        {{-- =======================================================
                             TAB 6: COOKIES POLICY
                        ======================================================== --}}
                        <div x-show="activeTab === 'cookies'" x-cloak class="space-y-6 text-slate-700 leading-relaxed text-xs sm:text-sm">
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">1. Essential Cookies Only</h3>
                                <p>
                                    We use strictly essential cookies and local browser storage to manage sessions, remember UI preferences, and maintain anti-CSRF security tokens. We do not use intrusive third-party advertising trackers.
                                </p>
                            </div>
                        </div>

                        {{-- =======================================================
                             TAB 7: DATA SECURITY
                        ======================================================== --}}
                        <div x-show="activeTab === 'security'" x-cloak class="space-y-6 text-slate-700 leading-relaxed text-xs sm:text-sm">
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">1. Encryption &amp; Safeguards</h3>
                                <p>
                                    All web traffic is transmitted over 256-bit TLS/SSL encryption. Database records and uploaded UTR screenshots are secured with strict role-based access control.
                                </p>
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">2. Zero Card Storage</h3>
                                <p>
                                    By utilizing direct bank UPI and account transfers, we never collect or store credit/debit card numbers, CVVs, or banking passwords on our servers.
                                </p>
                            </div>
                        </div>

                        {{-- =======================================================
                             TAB 8: THIRD-PARTY SERVICES
                        ======================================================== --}}
                        <div x-show="activeTab === 'third_party'" x-cloak class="space-y-6 text-slate-700 leading-relaxed text-xs sm:text-sm">
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">1. External Services</h3>
                                <p>
                                    We may utilize trusted third-party providers for transactional email delivery (SMTP) and interactive mapping. These providers are bound to uphold data confidentiality and never use donor data for advertising.
                                </p>
                            </div>
                        </div>

                        {{-- =======================================================
                             TAB 9: DISCLAIMER
                        ======================================================== --}}
                        <div x-show="activeTab === 'disclaimer'" x-cloak class="space-y-6 text-slate-700 leading-relaxed text-xs sm:text-sm">
                            <div class="space-y-2">
                                <h3 class="text-base font-extrabold text-[#15803d]">1. General Information</h3>
                                <p>
                                    Information published on this website regarding ongoing relief drives, medical camps, and community projects is provided in good faith and verified through our public transparency ledger.
                                </p>
                            </div>
                        </div>

                        {{-- =======================================================
                             TAB 10: LEGAL COMPLIANCE
                        ======================================================== --}}
                        <div x-show="activeTab === 'compliance'" x-cloak class="space-y-6 text-slate-700 leading-relaxed text-xs sm:text-sm">
                            <div class="space-y-4">
                                <h3 class="text-base font-extrabold text-[#15803d]">1. Statutory Accreditations Summary</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                    <div class="p-4 rounded-2xl bg-[#f7faf8] border border-slate-200/80">
                                        <span class="text-slate-500 block">Trust Registration</span>
                                        <span class="font-mono font-extrabold text-[#14291b] text-sm mt-0.5 block">{{ setting('ngo_reg_number', 'UP/2024/0045891') }}</span>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-[#f7faf8] border border-slate-200/80">
                                        <span class="text-slate-500 block">Section 80G Registration</span>
                                        <span class="font-mono font-extrabold text-[#15803d] text-sm mt-0.5 block">{{ setting('80g_reg_number', 'AAATH1234AF') }}</span>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-[#f7faf8] border border-slate-200/80">
                                        <span class="text-slate-500 block">Section 12A Registration</span>
                                        <span class="font-mono font-extrabold text-[#14291b] text-sm mt-0.5 block">{{ setting('12a_reg_number', 'AAATH1234A') }}</span>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-[#f7faf8] border border-slate-200/80">
                                        <span class="text-slate-500 block">FCRA Registration</span>
                                        <span class="font-mono font-extrabold text-[#14291b] text-sm mt-0.5 block">{{ setting('fcra_number', '123456789') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Mobile Bottom Support Bar ("Still have questions? Contact Us ->") --}}
                    <div class="sm:hidden mt-5 bg-[#f2fbf5] rounded-2xl p-4 border border-[#d8f3df] flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="w-8 h-8 rounded-full bg-[#16a34a] text-white flex items-center justify-center shrink-0 text-xs font-extrabold">
                                ?
                            </span>
                            <div class="min-w-0">
                                <h3 class="text-xs font-extrabold text-[#14291b] truncate">Still have questions?</h3>
                                <p class="text-[10.5px] text-slate-600 truncate">Contact our support team.</p>
                            </div>
                        </div>

                        <a
                            href="{{ $contactUrl }}"
                            class="shrink-0 inline-flex items-center gap-1 px-3.5 py-2 rounded-xl bg-white text-[#16a34a] border border-[#16a34a] text-xs font-extrabold"
                        >
                            <span>Contact Us</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </section>

</div>
@endsection