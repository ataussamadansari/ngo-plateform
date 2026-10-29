<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', (function_exists('setting') ? setting('ngo_name', 'Hope Foundation') : 'Hope Foundation') . ' — ' . (function_exists('setting') ? setting('ngo_tagline', 'For a Better Tomorrow') : 'For a Better Tomorrow'))</title>

    @if(function_exists('setting') && setting('favicon_path'))
        <link rel="icon" href="{{ asset('storage/' . setting('favicon_path')) }}">
    @endif

    <!-- Google Fonts: Plus Jakarta Sans (UI/Headings) + Caveat (Handwritten Script Accents) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Alpine.js for Carousels, Mobile Menu & Video Modal -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-primary: {{ function_exists('setting') ? setting('primary_color', '#16a34a') : '#16a34a' }};
            --color-secondary: {{ function_exists('setting') ? setting('secondary_color', '#0f172a') : '#0f172a' }};
            --color-primary-dark: {{ function_exists('setting') ? setting('primary_dark_color', '#15803d') : '#15803d' }};
            --color-forest: {{ function_exists('setting') ? setting('forest_bg_color', '#041f13') : '#041f13' }};
            --color-footer: {{ function_exists('setting') ? setting('footer_bg_color', '#071f12') : '#071f12' }};
            --color-mint-bg: {{ function_exists('setting') ? setting('mint_bg_color', '#eef8f1') : '#eef8f1' }};
            --color-mint-border: {{ function_exists('setting') ? setting('mint_border_color', '#d8f3df') : '#d8f3df' }};
            --color-accent: {{ function_exists('setting') ? setting('accent_color', '#4ade80') : '#4ade80' }};
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #0f172a;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        .font-script {
            font-family: 'Caveat', cursive;
        }

        /* Smooth Scroll-Reveal Animations */
        [data-reveal] {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        [data-reveal].is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Brush-Stroke Badge Effect for "Real People, Real Change" */
        .brush-badge {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            border-radius: 14px 4px 16px 6px;
            box-shadow: 0 10px 25px -5px rgba(22, 163, 74, 0.45);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body x-data="{ mobileMenuOpen: false, videoModalOpen: false, searchOpen: false }" class="antialiased selection:bg-[#16a34a] selection:text-white">

    @php
        $ngoName = function_exists('setting') ? setting('ngo_name', 'Hope Foundation') : 'Hope Foundation';
        $ngoTagline = function_exists('setting') ? setting('ngo_tagline', 'For a Better Tomorrow') : 'For a Better Tomorrow';
        $contactPhone = function_exists('setting') ? setting('contact_phone', '+91 87654 32109') : '+91 87654 32109';
        $contactEmail = function_exists('setting') ? setting('contact_email', 'info@hopefoundation.org') : 'info@hopefoundation.org';
        $officeAddress = function_exists('setting') ? setting('office_address', '123 NGO Street, Varanasi, Uttar Pradesh - 221001') : '123 NGO Street, Varanasi, Uttar Pradesh - 221001';
        $ngoRegNumber = function_exists('setting') ? setting('ngo_reg_number', 'UP/2024/0045891') : 'UP/2024/0045891';
        $reg80g = function_exists('setting') ? setting('80g_reg_number', 'AABTK1234FF20241') : 'AABTK1234FF20241';
        $panNumber = function_exists('setting') ? setting('ngo_pan_number', 'AABTK1234F') : 'AABTK1234F';

        $navLinks = [
            ['label' => 'Home', 'url' => Route::has('home') ? route('home') : url('/'), 'active' => request()->routeIs('home') || request()->is('/')],
            ['label' => 'About Us', 'url' => Route::has('about') ? route('about') : url('/about'), 'active' => request()->routeIs('about') || request()->is('about')],
            ['label' => 'Campaigns', 'url' => Route::has('campaigns.index') ? route('campaigns.index') : url('/campaigns'), 'active' => request()->routeIs('campaigns.*') || request()->is('campaigns*')],
            ['label' => 'Transparency', 'url' => Route::has('transparency.index') ? route('transparency.index') : url('/transparency'), 'active' => request()->routeIs('transparency.*') || request()->is('transparency*')],
            ['label' => 'Events', 'url' => Route::has('events.index') ? route('events.index') : url('/events'), 'active' => request()->routeIs('events.*') || request()->is('events*')],
            ['label' => 'Volunteer', 'url' => Route::has('volunteers.create') ? route('volunteers.create') : url('/volunteer-join'), 'active' => request()->routeIs('volunteers.*') || request()->is('volunteer*')],
            ['label' => 'Contact', 'url' => Route::has('contact.index') ? route('contact.index') : url('/contact'), 'active' => request()->routeIs('contact.*') || request()->is('contact*')],
        ];
        $donateUrl = Route::has('donate.index') ? route('donate.index') : url('/donate');
    @endphp

    <!-- ================= STICKY HEADER / NAVBAR ================= -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Left: Brand Logo -->
                <a href="{{ Route::has('home') ? route('home') : url('/') }}" class="flex items-center gap-3 group shrink-0">
                    <div class="w-11 h-11 rounded-full bg-[#eef8f1] border border-[#bbf7d0] flex items-center justify-center text-[#16a34a] shadow-xs group-hover:bg-[#16a34a] group-hover:text-white transition-all duration-300">
                        <!-- Heart in Hand Sprout Icon -->
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-lg font-extrabold text-slate-900 tracking-tight leading-none">{{ $ngoName }}</span>
                        <span class="block text-[11px] font-medium text-slate-500 mt-1">{{ $ngoTagline }}</span>
                    </div>
                </a>

                <!-- Center: Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-7">
                    @foreach($navLinks as $link)
                        <a href="{{ $link['url'] }}"
                           class="relative py-2 text-sm font-semibold transition-colors duration-200 {{ $link['active'] ? 'text-[#16a34a]' : 'text-slate-600 hover:text-[#16a34a]' }}">
                            {{ $link['label'] }}
                            @if($link['active'])
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#16a34a] rounded-full"></span>
                            @endif
                        </a>
                    @endforeach
                </nav>

                <!-- Right: Search + Donate CTA Button -->
                <div class="hidden lg:flex items-center gap-4">
                    <a href="{{ Route::has('donate.status') ? route('donate.status') : url('/donation-status') }}"
                       title="Track Donation / Search"
                       class="w-10 h-10 rounded-full text-slate-600 hover:text-[#16a34a] hover:bg-[#eef8f1] flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                        </svg>
                    </a>

                    <a href="{{ $donateUrl }}"
                       class="inline-flex items-center justify-center rounded-full bg-[#16a34a] hover:bg-[#15803d] text-white text-sm font-bold px-6 py-2.5 shadow-md shadow-green-600/20 hover:shadow-lg hover:shadow-green-600/30 hover:-translate-y-0.5 transition-all duration-300">
                        Donate Now
                    </a>
                </div>

                <!-- Mobile Hamburger Trigger -->
                <div class="flex items-center gap-2 lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                            type="button"
                            aria-label="Toggle Menu"
                            class="p-2.5 rounded-xl text-slate-700 hover:bg-slate-100 focus:outline-none">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div x-show="mobileMenuOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-3"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-3"
             @click.away="mobileMenuOpen = false"
             class="lg:hidden bg-white border-b border-slate-200 px-4 pt-3 pb-6 space-y-2 shadow-xl">
            @foreach($navLinks as $link)
                <a href="{{ $link['url'] }}"
                   class="block px-4 py-2.5 rounded-xl text-sm font-semibold {{ $link['active'] ? 'bg-[#eef8f1] text-[#16a34a]' : 'text-slate-700 hover:bg-slate-50' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2.5">
                <a href="{{ Route::has('donate.status') ? route('donate.status') : url('/donation-status') }}"
                   class="w-full py-2.5 text-center rounded-xl border border-slate-200 text-slate-700 text-sm font-semibold">
                    Track Donation Status
                </a>
                <a href="{{ $donateUrl }}"
                   class="w-full py-3 text-center rounded-xl bg-[#16a34a] text-white text-sm font-bold shadow-md">
                    ♡ Donate Now
                </a>
            </div>
        </div>
    </header>

    <!-- ================= MAIN PAGE CONTENT ================= -->
    <main>
        @yield('content')
    </main>

    <!-- ================= DEEP FOREST GREEN FOOTER ================= -->
    <footer class="bg-[#071f12] text-white pt-16 pb-10 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Institutional Credentials & Compliance Strip -->
            <div class="border-b border-white/10 pb-8 mb-10 grid grid-cols-2 sm:grid-cols-4 gap-6 text-center sm:text-left">
                <div>
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-emerald-400">Registration No.</span>
                    <span class="text-sm font-semibold text-slate-200">{{ $ngoRegNumber }}</span>
                </div>
                <div>
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-emerald-400">80G Tax Exemption Certified</span>
                    <span class="text-sm font-semibold text-slate-200">{{ $reg80g }}</span>
                </div>
                <div>
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-emerald-400">PAN Number</span>
                    <span class="text-sm font-semibold text-slate-200">{{ $panNumber }}</span>
                </div>
                <div>
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-emerald-400">Zero Platform Fees</span>
                    <span class="text-sm font-semibold text-slate-200">100% Direct Impact</span>
                </div>
            </div>
    
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-white/10">

                <!-- Col 1: Brand & Socials (4 Cols) -->
                <div class="lg:col-span-4 space-y-4">
                    <a href="{{ Route::has('home') ? route('home') : url('/') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#16a34a] flex items-center justify-center text-white shadow-md">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="block text-lg font-extrabold text-white leading-none">{{ $ngoName }}</span>
                            <span class="block text-xs text-emerald-300/80 mt-1">{{ $ngoTagline }}</span>
                        </div>
                    </a>

                    <p class="text-sm text-slate-300/85 leading-relaxed max-w-sm">
                        We work for education, health, environment and a better future for underprivileged communities with 100% ground transparency.
                    </p>

                    <!-- 5 Social Icons -->
                    <div class="flex items-center gap-2.5 pt-2">
                        @foreach(['facebook', 'instagram', 'youtube', 'linkedin', 'x'] as $social)
                            <a href="#" aria-label="{{ ucfirst($social) }}"
                               class="w-9 h-9 rounded-full bg-white/10 hover:bg-[#16a34a] text-white flex items-center justify-center transition-all duration-300 hover:-translate-y-0.5">
                                @if($social === 'facebook')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                                @elseif($social === 'instagram')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                                @elseif($social === 'youtube')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                @elseif($social === 'linkedin')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                                @else
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Col 2: Quick Links (2 Cols) -->
                <div class="lg:col-span-2 space-y-3">
                    <h4 class="text-sm font-bold text-white tracking-wide">Quick Links</h4>
                    <ul class="space-y-2.5 text-sm text-slate-300/85">
                        @foreach($navLinks as $link)
                            <li>
                                <a href="{{ $link['url'] }}" class="hover:text-[#86efac] transition-colors">{{ $link['label'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Col 3: Our Work (3 Cols) -->
                <div class="lg:col-span-3 space-y-3">
                    <h4 class="text-sm font-bold text-white tracking-wide">Our Work</h4>
                    <ul class="space-y-2.5 text-sm text-slate-300/85">
                        <li><a href="{{ Route::has('campaigns.index') ? route('campaigns.index', ['category' => 'education']) : url('/campaigns') }}" class="hover:text-[#86efac] transition-colors">Education</a></li>
                        <li><a href="{{ Route::has('campaigns.index') ? route('campaigns.index', ['category' => 'healthcare']) : url('/campaigns') }}" class="hover:text-[#86efac] transition-colors">Healthcare</a></li>
                        <li><a href="{{ Route::has('campaigns.index') ? route('campaigns.index', ['category' => 'clean-water']) : url('/campaigns') }}" class="hover:text-[#86efac] transition-colors">Clean Water</a></li>
                        <li><a href="{{ Route::has('campaigns.index') ? route('campaigns.index', ['category' => 'environment']) : url('/campaigns') }}" class="hover:text-[#86efac] transition-colors">Environment</a></li>
                        <li><a href="{{ Route::has('campaigns.index') ? route('campaigns.index') : url('/campaigns') }}" class="hover:text-[#86efac] transition-colors">Community Support</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact Us (3 Cols) -->
                <div class="lg:col-span-3 space-y-4">
                    <h4 class="text-sm font-bold text-white tracking-wide">Contact Us</h4>
                    <ul class="space-y-3 text-sm text-slate-300/90">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-[#4ade80] shrink-0 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $officeAddress }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-[#4ade80] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>{{ $contactPhone }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-[#4ade80] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ $contactEmail }}</span>
                        </li>
                    </ul>

                    <div class="pt-1">
                        <a href="{{ $donateUrl }}"
                           class="inline-flex items-center gap-2 rounded-xl bg-[#16a34a] hover:bg-[#15803d] text-white text-sm font-bold px-6 py-2.5 shadow-md transition-all duration-300 group">
                            <span>Donate Now</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright & Legal Bar -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
                <p>© {{ date('Y') }} {{ $ngoName }}. All rights reserved.</p>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ Route::has('legal.privacy') ? route('legal.privacy') : url('/privacy') }}" class="hover:text-white transition-colors">Privacy Policy</a>
                    <span>|</span>
                    <a href="{{ Route::has('legal.terms') ? route('legal.terms') : url('/terms') }}" class="hover:text-white transition-colors">Terms & Conditions</a>
                    <span>|</span>
                    <a href="{{ Route::has('legal.disclaimer') ? route('legal.disclaimer') : (Route::has('transparency.index') ? route('transparency.index') : url('/transparency')) }}" class="hover:text-white transition-colors">Disclaimer</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ================= STORY VIDEO LIGHTBOX MODAL ================= -->
    <div x-show="videoModalOpen"
         x-cloak
         @keydown.escape.window="videoModalOpen = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
        <div @click.away="videoModalOpen = false"
             class="relative w-full max-w-3xl bg-slate-900 rounded-3xl overflow-hidden shadow-2xl border border-white/15 p-6 text-center text-white">
            <button @click="videoModalOpen = false"
                    class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white">
                ✕
            </button>
            <div class="py-12 space-y-4">
                <div class="w-16 h-16 rounded-full bg-[#16a34a]/20 border border-[#16a34a] text-[#4ade80] flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </div>
                <h3 class="text-2xl font-bold">{{ $ngoName }} — Impact Story</h3>
                <p class="text-sm text-slate-300 max-w-md mx-auto">
                    Every rupee contributed goes directly to ground relief campaigns with 100% verified vendor bills and public transparency.
                </p>
                <div class="pt-4">
                    <a href="{{ $donateUrl }}" class="inline-flex items-center gap-2 rounded-xl bg-[#16a34a] px-6 py-3 text-sm font-bold text-white">
                        Support a Cause Today &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= SCROLL-REVEAL INTERSECTION OBSERVER ================= -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const revealElements = document.querySelectorAll('[data-reveal]');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const delay = entry.target.getAttribute('data-reveal-delay') || 0;
                        setTimeout(() => {
                            entry.target.classList.add('is-visible');
                        }, delay);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            revealElements.forEach((el) => observer.observe(el));
        });
    </script>
</body>
</html>