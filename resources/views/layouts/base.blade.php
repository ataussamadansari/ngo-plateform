<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ setting('ngo_name', 'Hope Foundation') }} - @yield('title', setting('ngo_tagline', 'For a Better Tomorrow'))</title>

    <!-- Dynamic Favicon -->
    <link rel="icon" href="{{ setting('favicon_path') ? asset('storage/' . setting('favicon_path')) : asset('favicon.ico') }}">

    <!-- Google Fonts: Inter & Caveat (Cursive Accent) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Dynamic CSS Custom Properties from White-Label Settings -->
    <style>
        :root {
            --color-primary: {{ setting('primary_color', '#16a34a') }};
            --color-secondary: {{ setting('secondary_color', '#0f172a') }};
        }
    </style>

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased font-sans flex flex-col justify-between selection:bg-emerald-500 selection:text-white"
      x-data="{ mobileMenuOpen: false, searchOpen: false }"
      @keydown.escape="mobileMenuOpen = false; searchOpen = false">

    @auth
        @if(auth()->user()->isSuperAdmin() || auth()->user()->isManager())
            <!-- Admin Global Command Strip -->
            <div class="bg-slate-900 text-slate-300 text-xs py-1.5 px-4 sm:px-6 lg:px-8 flex items-center justify-between border-b border-slate-800 relative z-50">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span class="font-bold text-white">{{ auth()->user()->isSuperAdmin() ? 'Super Admin' : 'Manager' }}:</span>
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ url('/admin') }}" class="font-bold text-emerald-400 hover:text-emerald-300 transition">Back-Office Command &rarr;</a>
                    <form action="{{ url('/admin/logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-white transition font-medium">Logout</button>
                    </form>
                </div>
            </div>
        @endif
    @endauth

    <!-- Top Navigation Header -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-100 sticky top-0 z-40 shadow-xs transition">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- Brand Logo & Name -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                @if(setting('logo_path') && file_exists(public_path('storage/' . setting('logo_path'))))
                    <img src="{{ asset('storage/' . setting('logo_path')) }}" alt="{{ setting('ngo_name', 'Hope Foundation') }}" class="h-11 w-auto object-contain">
                @else
                    <div class="w-11 h-11 rounded-full bg-emerald-600 text-white flex items-center justify-center shadow-md group-hover:scale-105 transition-transform shrink-0">
                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/>
                            <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                        </svg>
                    </div>
                @endif
                <div>
                    <span class="font-black text-xl text-slate-900 block leading-tight tracking-tight">{{ setting('ngo_name', 'Hope Foundation') }}</span>
                    <span class="text-xs font-semibold text-emerald-700 tracking-wide block">{{ setting('ngo_tagline', 'For a Better Tomorrow') }}</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden lg:flex items-center gap-8">
                <a href="{{ url('/') }}"
                   class="text-sm font-bold transition pb-1 {{ request()->is('/') ? 'text-emerald-700 border-b-2 border-emerald-600' : 'text-slate-700 hover:text-emerald-700' }}">
                    Home
                </a>
                <a href="{{ Route::has('about') ? route('about') : url('/about') }}"
                   class="text-sm font-bold transition pb-1 {{ request()->is('about*') ? 'text-emerald-700 border-b-2 border-emerald-600' : 'text-slate-700 hover:text-emerald-700' }}">
                    About Us
                </a>
                <a href="{{ route('campaigns.index') }}"
                   class="text-sm font-bold transition pb-1 {{ request()->is('campaigns*') ? 'text-emerald-700 border-b-2 border-emerald-600' : 'text-slate-700 hover:text-emerald-700' }}">
                    Campaigns
                </a>
                <a href="{{ route('transparency.index') }}"
                   class="text-sm font-bold transition pb-1 {{ request()->is('transparency*') ? 'text-emerald-700 border-b-2 border-emerald-600' : 'text-slate-700 hover:text-emerald-700' }}">
                    Transparency
                </a>
                <a href="{{ route('events.index') }}"
                   class="text-sm font-bold transition pb-1 {{ request()->is('events*') ? 'text-emerald-700 border-b-2 border-emerald-600' : 'text-slate-700 hover:text-emerald-700' }}">
                    Events
                </a>
                <a href="{{ route('volunteers.create') }}"
                   class="text-sm font-bold transition pb-1 {{ request()->is('volunteer-join*') ? 'text-emerald-700 border-b-2 border-emerald-600' : 'text-slate-700 hover:text-emerald-700' }}">
                    Volunteer
                </a>
                <a href="{{ Route::has('contact.index') ? route('contact.index') : url('/contact') }}"
                   class="text-sm font-bold transition pb-1 {{ request()->is('contact*') ? 'text-emerald-700 border-b-2 border-emerald-600' : 'text-slate-700 hover:text-emerald-700' }}">
                    Contact
                </a>
            </nav>

            <!-- Action Area -->
            <div class="flex items-center gap-3">
                <!-- Quick Search Toggle -->
                <button type="button" 
                        @click="searchOpen = !searchOpen" 
                        aria-label="Search Causes" 
                        class="w-10 h-10 rounded-full text-slate-600 hover:text-emerald-700 hover:bg-slate-100 flex items-center justify-center transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.3-4.3"/>
                    </svg>
                </button>

                <!-- Solid Emerald Donate Now Pill Button -->
                <a href="{{ route('donate.index') }}"
                   class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-black px-6 py-2.5 rounded-full shadow-md hover:shadow-emerald-600/30 transition transform active:scale-95 shrink-0">
                    <svg class="w-4 h-4 fill-current text-white/95" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span>Donate Now</span>
                </a>

                <!-- Mobile Hamburger Button -->
                <button type="button" 
                        @click="mobileMenuOpen = true"
                        aria-label="Toggle Mobile Navigation"
                        class="lg:hidden p-2 rounded-xl text-slate-700 hover:text-emerald-700 hover:bg-slate-100 focus:outline-none transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Quick Search Dropdown Overlay -->
        <div x-show="searchOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="absolute inset-x-0 top-full bg-white border-b border-slate-200 shadow-xl py-4 px-4 sm:px-6 lg:px-8 z-30"
             @click.away="searchOpen = false"
             style="display: none;">
            <div class="max-w-3xl mx-auto">
                <form action="{{ route('campaigns.index') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Search campaigns, causes, or initiatives..." 
                           class="w-full bg-slate-50 border border-slate-300 rounded-full pl-12 pr-28 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                    </svg>
                    <button type="submit" class="absolute right-2 top-2 px-5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full text-xs font-bold transition">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Slide-Out Mobile Drawer (Alpine.js Off-Canvas) -->
    <div x-show="mobileMenuOpen" 
         class="fixed inset-0 z-50 lg:hidden overflow-hidden" 
         role="dialog" 
         aria-modal="true"
         style="display: none;">
        
        <!-- Backdrop Overlay -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity ease-linear duration-300" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" 
             @click="mobileMenuOpen = false"></div>

        <!-- Sliding Off-Canvas Menu -->
        <div class="fixed inset-y-0 right-0 max-w-xs w-full bg-white shadow-2xl flex flex-col justify-between overflow-y-auto"
             x-show="mobileMenuOpen" 
             x-transition:enter="transform transition ease-in-out duration-300" 
             x-transition:enter-start="translate-x-full" 
             x-transition:enter-end="translate-x-0" 
             x-transition:leave="transform transition ease-in-out duration-300" 
             x-transition:leave-start="translate-x-0" 
             x-transition:leave-end="translate-x-full">
            
            <div>
                <!-- Drawer Header -->
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full bg-emerald-600 text-white flex items-center justify-center font-black">
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/>
                            </svg>
                        </div>
                        <span class="font-extrabold text-base text-slate-900">{{ setting('ngo_name', 'Hope Foundation') }}</span>
                    </div>
                    <button type="button" 
                            @click="mobileMenuOpen = false"
                            class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <nav class="p-6 space-y-1.5">
                    <a href="{{ url('/') }}" 
                       class="flex items-center justify-between px-4 py-3 rounded-xl font-bold text-sm transition {{ request()->is('/') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>Home</span>
                        @if(request()->is('/'))
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        @endif
                    </a>
                    <a href="{{ Route::has('about') ? route('about') : url('/about') }}" 
                       class="flex items-center justify-between px-4 py-3 rounded-xl font-bold text-sm transition {{ request()->is('about*') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>About Us</span>
                        @if(request()->is('about*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        @endif
                    </a>
                    <a href="{{ route('campaigns.index') }}" 
                       class="flex items-center justify-between px-4 py-3 rounded-xl font-bold text-sm transition {{ request()->is('campaigns*') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>Campaigns</span>
                        @if(request()->is('campaigns*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        @endif
                    </a>
                    <a href="{{ route('transparency.index') }}" 
                       class="flex items-center justify-between px-4 py-3 rounded-xl font-bold text-sm transition {{ request()->is('transparency*') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>Transparency Ledger</span>
                        @if(request()->is('transparency*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        @endif
                    </a>
                    <a href="{{ route('events.index') }}" 
                       class="flex items-center justify-between px-4 py-3 rounded-xl font-bold text-sm transition {{ request()->is('events*') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>Events</span>
                        @if(request()->is('events*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        @endif
                    </a>
                    <a href="{{ route('volunteers.create') }}" 
                       class="flex items-center justify-between px-4 py-3 rounded-xl font-bold text-sm transition {{ request()->is('volunteer-join*') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>Volunteer</span>
                        @if(request()->is('volunteer-join*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        @endif
                    </a>
                    <a href="{{ Route::has('contact.index') ? route('contact.index') : url('/contact') }}" 
                       class="flex items-center justify-between px-4 py-3 rounded-xl font-bold text-sm transition {{ request()->is('contact*') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>Contact</span>
                        @if(request()->is('contact*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        @endif
                    </a>
                    <a href="{{ route('donation.status') }}" 
                       class="flex items-center justify-between px-4 py-3 rounded-xl font-bold text-sm transition {{ request()->is('donation-status') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50' }}">
                        <span>Track Status</span>
                    </a>
                </nav>
            </div>

            <!-- Drawer Bottom Action -->
            <div class="p-6 border-t border-slate-100 space-y-4">
                <a href="{{ route('donate.index') }}"
                   class="w-full py-3.5 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-black text-sm flex items-center justify-center gap-2 shadow-md transition">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span>Donate Now</span>
                </a>

                @if(setting('contact_phone'))
                    <div class="text-center text-xs text-slate-500">
                        Need Help? Call <a href="tel:{{ setting('contact_phone') }}" class="font-bold text-emerald-700">{{ setting('contact_phone') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content Body -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Global High-Trust 4-Column Footer -->
    <footer class="bg-[#061a14] text-slate-300 pt-16 pb-12 mt-20 border-t border-emerald-950/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-14 border-b border-white/10">
                
                <!-- Col 1: Organization & Mission -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-black shadow-md shrink-0">
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-white font-black text-xl block leading-tight tracking-tight">{{ setting('ngo_name', 'Hope Foundation') }}</span>
                            <span class="text-xs text-emerald-400 font-semibold">{{ setting('ngo_tagline', 'For a Better Tomorrow') }}</span>
                        </div>
                    </div>

                    <p class="text-xs text-slate-400 leading-relaxed">
                        Dedicated to creating sustainable grassroots impact through 100% transparent donations, verified bank-reconciled ledgers, and direct relief for education, healthcare, and clean water.
                    </p>

                    <!-- Social Handles -->
                    <div class="pt-2 flex items-center gap-3">
                        @if(setting('facebook_url'))
                            <a href="{{ setting('facebook_url') }}" target="_blank" aria-label="Facebook" class="w-9 h-9 rounded-full bg-white/5 hover:bg-emerald-600 text-slate-300 hover:text-white flex items-center justify-center transition">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        @endif
                        @if(setting('instagram_url'))
                            <a href="{{ setting('instagram_url') }}" target="_blank" aria-label="Instagram" class="w-9 h-9 rounded-full bg-white/5 hover:bg-emerald-600 text-slate-300 hover:text-white flex items-center justify-center transition">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        @endif
                        @if(setting('youtube_url'))
                            <a href="{{ setting('youtube_url') }}" target="_blank" aria-label="YouTube" class="w-9 h-9 rounded-full bg-white/5 hover:bg-emerald-600 text-slate-300 hover:text-white flex items-center justify-center transition">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <span class="text-sm font-bold uppercase tracking-wider text-white block mb-5">Quick Links</span>
                    <ul class="space-y-3 text-xs text-slate-400">
                        <li><a href="{{ url('/') }}" class="hover:text-emerald-400 transition">Home</a></li>
                        <li><a href="{{ Route::has('about') ? route('about') : url('/about') }}" class="hover:text-emerald-400 transition">About Us</a></li>
                        <li><a href="{{ route('campaigns.index') }}" class="hover:text-emerald-400 transition">Campaigns</a></li>
                        <li><a href="{{ route('transparency.index') }}" class="hover:text-emerald-400 transition">Transparency Ledger</a></li>
                        <li><a href="{{ route('events.index') }}" class="hover:text-emerald-400 transition">Community Events</a></li>
                        <li><a href="{{ route('volunteers.create') }}" class="hover:text-emerald-400 transition">Volunteer With Us</a></li>
                        <li><a href="{{ Route::has('contact.index') ? route('contact.index') : url('/contact') }}" class="hover:text-emerald-400 transition">Contact Us</a></li>
                        <li><a href="{{ route('donation.status') }}" class="hover:text-emerald-400 transition">Track Donation Status</a></li>
                    </ul>
                </div>

                <!-- Col 3: Our Work Categories -->
                <div>
                    <span class="text-sm font-bold uppercase tracking-wider text-white block mb-5">Our Work</span>
                    <ul class="space-y-3 text-xs text-slate-400">
                        <li><a href="{{ route('campaigns.index') }}" class="hover:text-emerald-400 transition">Education Support</a></li>
                        <li><a href="{{ route('campaigns.index') }}" class="hover:text-emerald-400 transition">Healthcare & Medical Relief</a></li>
                        <li><a href="{{ route('campaigns.index') }}" class="hover:text-emerald-400 transition">Clean Water Initiatives</a></li>
                        <li><a href="{{ route('campaigns.index') }}" class="hover:text-emerald-400 transition">Environmental Sustainability</a></li>
                        <li><a href="{{ route('campaigns.index') }}" class="hover:text-emerald-400 transition">Community Development</a></li>
                        <li><a href="{{ route('campaigns.index') }}" class="hover:text-emerald-400 transition">Emergency Relief Appeals</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact & Coordinates -->
                <div class="space-y-4">
                    <span class="text-sm font-bold uppercase tracking-wider text-white block mb-5">Contact Us</span>
                    <ul class="space-y-3 text-xs text-slate-400">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                            <span>{{ setting('contact_address', 'Registered Non-Profit Organisation, India') }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <a href="tel:{{ setting('contact_phone', '+91 9876543210') }}" class="hover:text-emerald-400 transition">{{ setting('contact_phone', '+91 9876543210') }}</a>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <a href="mailto:{{ setting('contact_email', 'contact@hopefoundation.org') }}" class="hover:text-emerald-400 transition">{{ setting('contact_email', 'contact@hopefoundation.org') }}</a>
                        </li>
                    </ul>

                    <div class="pt-2">
                        <a href="{{ route('donate.index') }}"
                           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs px-5 py-2.5 rounded-full shadow-md transition">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                            <span>Donate to a Cause</span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Legal Credentials Strip -->
            <div class="py-6 border-b border-white/10 flex flex-wrap items-center justify-between gap-4 text-xs text-slate-400">
                <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
                    @if(setting('ngo_reg_number'))
                        <div><span class="text-slate-500">Registration:</span> <span class="font-mono text-slate-200">{{ setting('ngo_reg_number') }}</span></div>
                    @endif
                    @if(setting('80g_reg_number'))
                        <div><span class="text-slate-500">80G Reg:</span> <span class="font-mono text-emerald-400 font-bold">{{ setting('80g_reg_number') }}</span></div>
                    @endif
                    @if(setting('12a_reg_number'))
                        <div><span class="text-slate-500">12A Reg:</span> <span class="font-mono text-slate-200">{{ setting('12a_reg_number') }}</span></div>
                    @endif
                    @if(setting('ngo_darpan_id'))
                        <div><span class="text-slate-500">Darpan ID:</span> <span class="font-mono text-slate-200">{{ setting('ngo_darpan_id') }}</span></div>
                    @endif
                    @if(setting('ngo_pan_number'))
                        <div><span class="text-slate-500">PAN:</span> <span class="font-mono text-slate-200">{{ setting('ngo_pan_number') }}</span></div>
                    @endif
                </div>

                <div class="flex items-center gap-3 text-emerald-400 font-bold text-xs">
                    <span class="inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        80G Tax Exemption Certified
                    </span>
                    <span>&bull;</span>
                    <span>Zero Platform Fees</span>
                    <span>&bull;</span>
                    <span>Bank Statement Reconciled</span>
                </div>
            </div>

            <!-- Sub Footer -->
            <div class="pt-6 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <div>
                    &copy; {{ date('Y') }} {{ setting('ngo_name', 'Hope Foundation') }}. All rights reserved. 100% Transparent Non-Profit Platform.
                </div>
                <div class="flex items-center gap-5 text-slate-400">
                    <a href="{{ url('/privacy') }}" class="hover:text-emerald-400 transition">Privacy Policy</a>
                    <span>|</span>
                    <a href="{{ url('/terms') }}" class="hover:text-emerald-400 transition">Terms & Conditions</a>
                    <span>|</span>
                    <a href="{{ url('/disclaimer') }}" class="hover:text-emerald-400 transition">Disclaimer</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
