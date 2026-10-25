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

            <nav class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">Home</a>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">80G Certified</span>
            </nav>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-slate-900 text-slate-400 py-10 mt-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <span class="text-white font-semibold">{{ setting('ngo_name', 'NGO Platform') }}</span>
                    <p class="text-xs text-slate-400 mt-1">{{ setting('contact_address', 'Registered Non-Profit Organisation') }}</p>
                </div>
                <div class="text-xs text-slate-500">
                    &copy; {{ date('Y') }} {{ setting('ngo_name') }}. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
