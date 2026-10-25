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
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                @if(setting('logo_path') && file_exists(public_path('storage/' . setting('logo_path'))))
                    <img src="{{ asset('storage/' . setting('logo_path')) }}" alt="{{ setting('ngo_name') }}" class="h-10 w-auto object-contain">
                @else
                    <div class="w-10 h-10 rounded-lg bg-primary text-white flex items-center justify-center font-bold text-lg shadow-sm">
                        {{ substr(setting('ngo_name', 'N'), 0, 1) }}
                    </div>
                @endif
                <div>
                    <span class="font-bold text-lg text-slate-900 block leading-tight">{{ setting('ngo_name', 'NGO Platform') }}</span>
                    <span class="text-xs text-slate-500 hidden sm:block">{{ setting('ngo_tagline', 'Serving Humanity') }}</span>
                </div>
            </a>

            <nav class="flex items-center gap-3 sm:gap-6">
                <a href="{{ url('/') }}" class="text-sm font-medium {{ request()->is('/') ? 'text-emerald-600 font-bold' : 'text-slate-600 hover:text-slate-900' }}">Home</a>
                <a href="{{ route('campaigns.index') }}" class="text-sm font-medium {{ request()->is('campaigns*') ? 'text-emerald-600 font-bold' : 'text-slate-600 hover:text-slate-900' }}">Causes</a>
                <a href="{{ route('events.index') }}" class="text-sm font-medium hidden sm:inline-block {{ request()->is('events*') ? 'text-emerald-600 font-bold' : 'text-slate-600 hover:text-slate-900' }}">Events</a>
                <a href="{{ route('transparency.index') }}" class="text-sm font-medium {{ request()->is('transparency*') ? 'text-emerald-600 font-bold' : 'text-slate-600 hover:text-slate-900' }}">Transparency</a>
                <a href="{{ route('volunteers.create') }}" class="text-sm font-medium hidden md:inline-block {{ request()->is('volunteer-join*') ? 'text-emerald-600 font-bold' : 'text-slate-600 hover:text-slate-900' }}">Volunteer</a>
                <a href="{{ route('donate.index') }}" class="text-sm font-medium {{ request()->is('donate') ? 'text-emerald-600 font-bold' : 'text-slate-600 hover:text-slate-900' }}">Donate</a>
                <a href="{{ route('donation.status') }}" class="text-sm font-medium hidden sm:inline-block {{ request()->is('donation-status') ? 'text-emerald-600 font-bold' : 'text-slate-600 hover:text-slate-900' }}">Track Donation</a>

                <a href="{{ route('donate.index') }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold text-white bg-primary hover:opacity-95 shadow-xs transition">
                    Donate Now
                </a>
            </nav>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-slate-900 text-slate-400 py-12 mt-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-8 border-b border-slate-800">
                <div>
                    <span class="text-white font-bold text-lg block">{{ setting('ngo_name', 'NGO Platform') }}</span>
                    <p class="text-xs text-slate-400 mt-2">{{ setting('ngo_tagline', 'Serving Humanity with Complete Transparency') }}</p>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">{{ setting('contact_address', 'Registered Non-Profit Organisation') }}</p>
                </div>

                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-3">Quick Navigation</span>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ url('/') }}" class="hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('campaigns.index') }}" class="hover:text-white transition">Active Causes</a></li>
                        <li><a href="{{ route('events.index') }}" class="hover:text-white transition">Community Events</a></li>
                        <li><a href="{{ route('transparency.index') }}" class="hover:text-white transition">Transparency Ledger</a></li>
                        <li><a href="{{ route('volunteers.create') }}" class="hover:text-white transition">Volunteer With Us</a></li>
                        <li><a href="{{ route('donate.index') }}" class="hover:text-white transition">Make a Donation</a></li>
                        <li><a href="{{ route('donation.status') }}" class="hover:text-white transition">Track Donation Status</a></li>
                    </ul>
                </div>

                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-3">Contact & Legal</span>
                    <ul class="space-y-1.5 text-xs text-slate-400">
                        <li>Email: <a href="mailto:{{ setting('contact_email') }}" class="hover:text-white">{{ setting('contact_email', 'contact@kashiseva.org') }}</a></li>
                        <li>Phone: {{ setting('contact_phone', '+91 9876543210') }}</li>
                        @if(setting('ngo_reg_number'))
                            <li class="pt-2 text-slate-500">Reg No: {{ setting('ngo_reg_number') }}</li>
                        @endif
                        @if(setting('80g_reg_number'))
                            <li class="text-slate-500">80G Reg: {{ setting('80g_reg_number') }}</li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-6 text-xs text-slate-500">
                <div>
                    &copy; {{ date('Y') }} {{ setting('ngo_name') }}. 100% Transparent Non-Profit Platform.
                </div>
                <div class="flex items-center gap-4">
                    <span>80G Tax Exemption Certified</span>
                    <span>&bull;</span>
                    <span>Zero Platform Fees</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
