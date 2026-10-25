<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ setting('ngo_name', 'NGO Platform') }} - @yield('title', setting('ngo_tagline', 'Charity & Relief'))</title>

    <!-- Dynamic Favicon -->
    <link rel="icon" href="{{ setting('favicon_path') ? asset('storage/' . setting('favicon_path')) : asset('favicon.ico') }}">

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
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased font-sans flex flex-col justify-between">

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
                    <a href="{{ route('admin.dashboard') }}" class="font-bold text-emerald-400 hover:text-emerald-300 transition">Back-Office Command &rarr;</a>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-white transition font-medium">Logout</button>
                    </form>
                </div>
            </div>
        @endif
    @endauth

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between">
            
            <!-- Brand Logo & Name -->
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                @if(setting('logo_path') && file_exists(public_path('storage/' . setting('logo_path'))))
                    <img src="{{ asset('storage/' . setting('logo_path')) }}" alt="{{ setting('ngo_name') }}" class="h-10 w-auto object-contain">
                @else
                    <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-lg shadow-sm">
                        {{ substr(setting('ngo_name', 'N'), 0, 1) }}
                    </div>
                @endif
                <div>
                    <span class="font-extrabold text-lg text-slate-900 block leading-tight tracking-tight">{{ setting('ngo_name', 'NGO Platform') }}</span>
                    <span class="text-[11px] text-slate-500 hidden sm:block">{{ setting('ngo_tagline', 'Serving Humanity with 100% Transparency') }}</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden lg:flex items-center gap-6">
                <a href="{{ url('/') }}" class="text-xs font-bold transition {{ request()->is('/') ? 'text-primary' : 'text-slate-600 hover:text-slate-900' }}">Home</a>
                <a href="{{ route('campaigns.index') }}" class="text-xs font-bold transition {{ request()->is('campaigns*') ? 'text-primary' : 'text-slate-600 hover:text-slate-900' }}">Causes</a>
                <a href="{{ route('events.index') }}" class="text-xs font-bold transition {{ request()->is('events*') ? 'text-primary' : 'text-slate-600 hover:text-slate-900' }}">Events</a>
                <a href="{{ route('transparency.index') }}" class="text-xs font-bold transition {{ request()->is('transparency*') ? 'text-primary' : 'text-slate-600 hover:text-slate-900' }}">Transparency</a>
                <a href="{{ Route::has('about') ? route('about') : url('/about') }}" class="text-xs font-bold transition {{ request()->is('about') ? 'text-primary' : 'text-slate-600 hover:text-slate-900' }}">About Us</a>
                <a href="{{ Route::has('contact.index') ? route('contact.index') : url('/contact') }}" class="text-xs font-bold transition {{ request()->is('contact') ? 'text-primary' : 'text-slate-600 hover:text-slate-900' }}">Contact</a>
                <a href="{{ route('volunteers.create') }}" class="text-xs font-bold transition {{ request()->is('volunteer-join*') ? 'text-primary' : 'text-slate-600 hover:text-slate-900' }}">Volunteer</a>
                <a href="{{ route('donation.status') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition">Track Status</a>
            </nav>

            <!-- Action Area -->
            <div class="flex items-center gap-3">
                <a href="{{ route('donate.index') }}"
                   class="px-5 py-2.5 rounded-xl text-xs font-black text-white bg-primary hover:opacity-95 shadow-xs transition shrink-0">
                    Donate Now
                </a>

                <!-- Mobile Hamburger Button -->
                <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                        aria-label="Toggle Mobile Navigation"
                        class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-2 text-sm shadow-lg">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-xl font-bold {{ request()->is('/') ? 'bg-emerald-50 text-primary' : 'text-slate-700 hover:bg-slate-50' }}">Home</a>
            <a href="{{ route('campaigns.index') }}" class="block px-3 py-2 rounded-xl font-bold {{ request()->is('campaigns*') ? 'bg-emerald-50 text-primary' : 'text-slate-700 hover:bg-slate-50' }}">Active Causes</a>
            <a href="{{ route('events.index') }}" class="block px-3 py-2 rounded-xl font-bold {{ request()->is('events*') ? 'bg-emerald-50 text-primary' : 'text-slate-700 hover:bg-slate-50' }}">Community Events</a>
            <a href="{{ route('transparency.index') }}" class="block px-3 py-2 rounded-xl font-bold {{ request()->is('transparency*') ? 'bg-emerald-50 text-primary' : 'text-slate-700 hover:bg-slate-50' }}">Transparency Ledger</a>
            <a href="{{ Route::has('about') ? route('about') : url('/about') }}" class="block px-3 py-2 rounded-xl font-bold {{ request()->is('about') ? 'bg-emerald-50 text-primary' : 'text-slate-700 hover:bg-slate-50' }}">About Us</a>
            <a href="{{ Route::has('contact.index') ? route('contact.index') : url('/contact') }}" class="block px-3 py-2 rounded-xl font-bold {{ request()->is('contact') ? 'bg-emerald-50 text-primary' : 'text-slate-700 hover:bg-slate-50' }}">Contact Us</a>
            <a href="{{ route('volunteers.create') }}" class="block px-3 py-2 rounded-xl font-bold {{ request()->is('volunteer-join*') ? 'bg-emerald-50 text-primary' : 'text-slate-700 hover:bg-slate-50' }}">Volunteer With Us</a>
            <a href="{{ route('donation.status') }}" class="block px-3 py-2 rounded-xl font-bold {{ request()->is('donation-status') ? 'bg-emerald-50 text-primary' : 'text-slate-700 hover:bg-slate-50' }}">Track Donation Status</a>
        </div>
    </header>

    <!-- Main Content Body -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Global High-Trust Footer -->
    <footer class="bg-slate-900 text-slate-400 py-16 mt-20 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-slate-800">
                
                <!-- Col 1: Organization & Mission -->
                <div class="space-y-3">
                    <span class="text-white font-extrabold text-lg block tracking-tight">{{ setting('ngo_name', 'NGO Platform') }}</span>
                    <p class="text-xs text-emerald-400 font-semibold">{{ setting('ngo_tagline', 'Serving Humanity with Complete Transparency') }}</p>
                    <p class="text-xs text-slate-400 leading-relaxed">{{ setting('contact_address', 'Registered Non-Profit Organisation') }}</p>
                    
                    @if(setting('whatsapp_number'))
                        <div class="pt-2">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp_number')) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-600/20 text-emerald-300 border border-emerald-500/30 text-xs font-bold hover:bg-emerald-600/30 transition">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                WhatsApp Support
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-300 block mb-4">Platform Directory</span>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ url('/') }}" class="hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('campaigns.index') }}" class="hover:text-white transition">Active Causes</a></li>
                        <li><a href="{{ route('events.index') }}" class="hover:text-white transition">Community Relief Drives</a></li>
                        <li><a href="{{ route('transparency.index') }}" class="hover:text-white transition">Public Transparency Ledger</a></li>
                        <li><a href="{{ Route::has('about') ? route('about') : url('/about') }}" class="hover:text-white transition">About Our Mission</a></li>
                        <li><a href="{{ Route::has('contact.index') ? route('contact.index') : url('/contact') }}" class="hover:text-white transition">Contact Us & Office</a></li>
                        <li><a href="{{ route('volunteers.create') }}" class="hover:text-white transition">Volunteer With Us</a></li>
                        <li><a href="{{ route('donation.status') }}" class="hover:text-white transition">Track Donation Status</a></li>
                    </ul>
                </div>

                <!-- Col 3: Compliance & Accreditation -->
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-300 block mb-4">Legal Accreditation</span>
                    <ul class="space-y-2 text-xs text-slate-400">
                        @if(setting('ngo_reg_number'))
                            <li><span class="text-slate-500 block">Registration No:</span> <span class="font-mono text-slate-300">{{ setting('ngo_reg_number') }}</span></li>
                        @endif
                        @if(setting('80g_reg_number'))
                            <li><span class="text-slate-500 block">80G Certificate:</span> <span class="font-mono text-emerald-400">{{ setting('80g_reg_number') }}</span></li>
                        @endif
                        @if(setting('12a_reg_number'))
                            <li><span class="text-slate-500 block">12A Exemption:</span> <span class="font-mono text-slate-300">{{ setting('12a_reg_number') }}</span></li>
                        @endif
                        @if(setting('ngo_darpan_id'))
                            <li><span class="text-slate-500 block">NGO Darpan ID:</span> <span class="font-mono text-slate-300">{{ setting('ngo_darpan_id') }}</span></li>
                        @endif
                        @if(setting('ngo_pan_number'))
                            <li><span class="text-slate-500 block">PAN Number:</span> <span class="font-mono text-slate-300">{{ setting('ngo_pan_number') }}</span></li>
                        @endif
                    </ul>
                </div>

                <!-- Col 4: Contact & Social Handles -->
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-300 block mb-4">Connect & Verify</span>
                    <ul class="space-y-2 text-xs text-slate-400 mb-6">
                        <li>Email: <a href="mailto:{{ setting('contact_email') }}" class="text-slate-300 hover:text-white transition">{{ setting('contact_email', 'contact@kashiseva.org') }}</a></li>
                        <li>Phone: <span class="text-slate-300">{{ setting('contact_phone', '+91 9876543210') }}</span></li>
                        <li>Location: <span class="text-slate-300">{{ setting('office_city', 'Varanasi') }}, India</span></li>
                    </ul>

                    <!-- Social Icons -->
                    <div class="flex items-center gap-3">
                        @if(setting('facebook_url'))
                            <a href="{{ setting('facebook_url') }}" target="_blank" aria-label="Facebook" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-blue-600 text-white flex items-center justify-center transition">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        @endif
                        @if(setting('instagram_url'))
                            <a href="{{ setting('instagram_url') }}" target="_blank" aria-label="Instagram" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-pink-600 text-white flex items-center justify-center transition">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        @endif
                        @if(setting('youtube_url'))
                            <a href="{{ setting('youtube_url') }}" target="_blank" aria-label="YouTube" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-red-600 text-white flex items-center justify-center transition">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Sub Footer -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-8 text-xs text-slate-500">
                <div>
                    &copy; {{ date('Y') }} {{ setting('ngo_name', 'NGO Platform') }}. 100% Transparent Non-Profit Platform.
                </div>
                <div class="flex items-center gap-4">
                    <span>80G Tax Exemption Certified</span>
                    <span>&bull;</span>
                    <span>Zero Platform Fees</span>
                    <span>&bull;</span>
                    <span>Bank Statement Reconciled</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
