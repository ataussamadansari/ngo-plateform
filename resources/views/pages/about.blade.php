@extends('layouts.base')

@section('title', 'About Us - People, Purpose & Positive Change | ' . setting('ngo_name', 'Hope Foundation'))

@section('content')
<!-- 1. Flagship Hero Section -->
<section class="relative bg-gradient-to-b from-[#03150e] via-[#052117] to-[#041a12] text-white pt-16 pb-24 sm:pt-20 sm:pb-32 overflow-hidden">
    <!-- Ambient Glow & Background Image Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070&auto=format&fit=crop" 
             alt="About Hope Foundation" 
             class="w-full h-full object-cover opacity-15 mix-blend-luminosity filter blur-[0.5px]">
        <!-- <div class="absolute inset-0 bg-gradient-to-t from-[#041a12] via-[#052117]/90 to-[#03150e]/95"></div>
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 -right-32 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div> -->
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-white/10 pb-10">
            <div>
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs font-semibold text-emerald-400 mb-3 tracking-wide">
                    <a href="{{ url('/') }}" class="hover:text-emerald-300 transition">Home</a>
                    <span class="text-slate-500">&gt;</span>
                    <span class="text-slate-200">About Us</span>
                </nav>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight">
                    About Us
                </h1>
                <p class="mt-2 text-base sm:text-lg text-emerald-300 font-medium tracking-wide">
                    People | Purpose | Positive Change
                </p>
            </div>

            <!-- Right Visual Accent: Real People, Real Change -->
            <div class="inline-flex items-center gap-3 bg-white/5 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/10 self-start md:self-end">
                <div class="w-10 h-10 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-emerald-400">Our Belief</span>
                    <span class="text-sm font-extrabold text-white">Real People, Real Change</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Page Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 space-y-20 lg:space-y-28">

    <!-- 2. Our Story Narrative & Mission / Vision / Values Grid -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
        <!-- Left: Story Narrative -->
        <div class="lg:col-span-5 space-y-6">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 tracking-wider uppercase">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                Our Story
            </span>

            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-snug">
                A Small Step Towards a Brighter Tomorrow
            </h2>
            <div class="text-xs sm:text-sm font-bold text-emerald-700 uppercase tracking-wider">
                The Grassroots Story of {{ setting('ngo_name', 'Hope Foundation') }}
            </div>

            <div class="space-y-4 text-sm sm:text-base text-slate-600 leading-relaxed">
                <p>
                    {{ setting('ngo_name', 'Hope Foundation') }} is a non-profit organization dedicated to grassroots child education, emergency healthcare, rural environmental conservation, and dignified community development. We believe in a world where every single human being has equal opportunities to thrive with health, education, and dignity.
                </p>
                <p>
                    What started as a modest volunteer initiative in Varanasi has evolved into a nationwide movement of thousands of verified donors, ground field workers, and passionate volunteers. We coordinate directly with local schools, health centers, and community leaders—ensuring zero intermediary leakage and total transparency.
                </p>
            </div>

            <div class="pt-2">
                <a href="#our-journey" 
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md transition group">
                    <span>Our Journey</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Center: Photo with Polaroid Overlay Badge -->
        <div class="lg:col-span-4 relative">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white aspect-[4/5] max-w-md mx-auto">
                <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1200&auto=format&fit=crop" 
                     alt="Children Empowered by Hope Foundation" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>

                <!-- Tilted Polaroid Badge matching Mockup -->
                <div class="absolute bottom-6 inset-x-6 bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-xl border border-slate-100 text-center transform -rotate-1 hover:rotate-0 transition-transform">
                    <p class="font-extrabold text-slate-900 text-sm leading-snug">
                        "Because every child deserves a brighter tomorrow" 🌿
                    </p>
                    <span class="text-[11px] font-semibold text-emerald-700 uppercase tracking-widest mt-1 block">
                        Direct Grassroots Impact
                    </span>
                </div>
            </div>
        </div>

        <!-- Right: 3 Mission / Vision / Values Cards -->
        <div class="lg:col-span-3 space-y-5">
            <!-- Mission Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-md transition">
                <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><path d="m12 8 4 4-4 4M8 12h8"/>
                    </svg>
                </div>
                <h3 class="text-lg font-black text-slate-900 mb-1.5">Our Mission</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    To empower underprivileged communities through quality child education, emergency healthcare, clean drinking water, and sustainable environmental stewardship.
                </p>
            </div>

            <!-- Vision Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-md transition">
                <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                </div>
                <h3 class="text-lg font-black text-slate-900 mb-1.5">Our Vision</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    A healthier, educated, and more equal society where every individual has the dignity and tools to reach their full potential without barriers.
                </p>
            </div>

            <!-- Values Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-md transition">
                <div class="w-11 h-11 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-black text-slate-900 mb-1.5">Our Values</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Integrity, Complete Transparency, Ground Compassion, Zero-Deduction Impact, and Community First.
                </p>
            </div>
        </div>
    </section>

    <!-- 3. Our Impact In Numbers Strip -->
    <section class="bg-gradient-to-r from-emerald-50/80 via-teal-50/50 to-emerald-50/80 border border-emerald-100/90 rounded-3xl p-8 sm:p-12 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
            <!-- Left Header -->
            <div class="md:col-span-4 space-y-2 border-b md:border-b-0 md:border-r border-emerald-200/70 pb-6 md:pb-0 md:pr-8">
                <span class="text-xs font-extrabold uppercase tracking-widest text-emerald-700 block">Verified Data</span>
                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Our Impact In Numbers</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Together with our transparent donors, we are creating real, verified change in people's lives every single day.
                </p>
            </div>

            <!-- Right 4 Stats -->
            <div class="md:col-span-8 grid grid-cols-2 sm:grid-cols-4 gap-6 text-center sm:text-left">
                <!-- Stat 1 -->
                <div class="space-y-1">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto sm:mx-0 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight block">
                        {{ setting('total_lives_impacted', '12,500+') }}
                    </span>
                    <span class="text-xs font-semibold text-slate-600 block">Lives Impacted</span>
                </div>

                <!-- Stat 2 -->
                <div class="space-y-1">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto sm:mx-0 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight block">
                        ₹2.8 Cr+
                    </span>
                    <span class="text-xs font-semibold text-slate-600 block">Funds Utilized</span>
                </div>

                <!-- Stat 3 -->
                <div class="space-y-1">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto sm:mx-0 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight block">
                        {{ setting('total_projects_completed', '150+') }}
                    </span>
                    <span class="text-xs font-semibold text-slate-600 block">Projects Completed</span>
                </div>

                <!-- Stat 4 -->
                <div class="space-y-1">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto sm:mx-0 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    </div>
                    <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight block">
                        5,000+
                    </span>
                    <span class="text-xs font-semibold text-slate-600 block">Supporters & Donors</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Our Journey: Milestone Timeline -->
    <section id="our-journey" class="space-y-10 scroll-mt-24">
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                Milestones
            </span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                Our Journey
            </h2>
            <p class="text-sm sm:text-base text-slate-600">
                From a small grassroots idea to a growing nationwide movement, here are some key milestones of our journey.
            </p>
        </div>

        <!-- Horizontal Timeline on Desktop, Stacked on Mobile -->
        <div class="relative bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-xs">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6 relative">
                <!-- Timeline Connecting Line (Hidden on tiny screens) -->
                <div class="hidden lg:block absolute top-7 inset-x-8 h-1 bg-emerald-100 z-0"></div>

                <!-- 2018 -->
                <div class="relative z-10 text-center space-y-2">
                    <div class="w-12 h-12 rounded-full bg-emerald-600 text-white font-black text-sm flex items-center justify-center mx-auto shadow-md border-4 border-white">
                        2018
                    </div>
                    <div class="pt-1">
                        <span class="text-sm font-extrabold text-slate-900 block">Foundation</span>
                        <p class="text-xs text-slate-500 mt-0.5">Started volunteer operations in Varanasi</p>
                    </div>
                </div>

                <!-- 2019 -->
                <div class="relative z-10 text-center space-y-2">
                    <div class="w-12 h-12 rounded-full bg-emerald-600 text-white font-black text-sm flex items-center justify-center mx-auto shadow-md border-4 border-white">
                        2019
                    </div>
                    <div class="pt-1">
                        <span class="text-sm font-extrabold text-slate-900 block">First Education Program</span>
                        <p class="text-xs text-slate-500 mt-0.5">Sponsored 50 rural girl students</p>
                    </div>
                </div>

                <!-- 2020 -->
                <div class="relative z-10 text-center space-y-2">
                    <div class="w-12 h-12 rounded-full bg-emerald-600 text-white font-black text-sm flex items-center justify-center mx-auto shadow-md border-4 border-white">
                        2020
                    </div>
                    <div class="pt-1">
                        <span class="text-sm font-extrabold text-slate-900 block">Healthcare Camps</span>
                        <p class="text-xs text-slate-500 mt-0.5">Mobile clinics during emergency waves</p>
                    </div>
                </div>

                <!-- 2021 -->
                <div class="relative z-10 text-center space-y-2">
                    <div class="w-12 h-12 rounded-full bg-emerald-600 text-white font-black text-sm flex items-center justify-center mx-auto shadow-md border-4 border-white">
                        2021
                    </div>
                    <div class="pt-1">
                        <span class="text-sm font-extrabold text-slate-900 block">Clean Water Projects</span>
                        <p class="text-xs text-slate-500 mt-0.5">Installed 15 rural community RO plants</p>
                    </div>
                </div>

                <!-- 2023 -->
                <div class="relative z-10 text-center space-y-2">
                    <div class="w-12 h-12 rounded-full bg-emerald-600 text-white font-black text-sm flex items-center justify-center mx-auto shadow-md border-4 border-white">
                        2023
                    </div>
                    <div class="pt-1">
                        <span class="text-sm font-extrabold text-slate-900 block">Expanded to 5+ States</span>
                        <p class="text-xs text-slate-500 mt-0.5">Over 200 partner field volunteers</p>
                    </div>
                </div>

                <!-- 2025 -->
                <div class="relative z-10 text-center space-y-2">
                    <div class="w-12 h-12 rounded-full bg-emerald-700 text-white font-black text-sm flex items-center justify-center mx-auto shadow-md border-4 border-white ring-4 ring-emerald-100">
                        2025
                    </div>
                    <div class="pt-1">
                        <span class="text-sm font-extrabold text-emerald-800 block">12,500+ Impacted</span>
                        <p class="text-xs text-slate-500 mt-0.5">Zero platform fee public ledger launch</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Our Team: Leadership & Ground Changemakers -->
    <section class="space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wider mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                    Leadership
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Our Team
                </h2>
                <p class="text-sm sm:text-base text-slate-600 mt-1">
                    A dedicated team of changemakers working for a better tomorrow.
                </p>
            </div>
            <div>
                <a href="{{ route('volunteers.create') }}" 
                   class="inline-flex items-center gap-2 text-xs font-bold text-emerald-700 hover:text-emerald-800 transition">
                    <span>Join As Volunteer</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($teamMembers as $member)
                <div class="bg-white rounded-3xl overflow-hidden border border-slate-200/90 shadow-xs hover:shadow-md transition-all flex flex-col group">
                    <div class="aspect-[4/3] bg-slate-100 relative overflow-hidden">
                        @if($member->photo && file_exists(storage_path('app/public/' . $member->photo)))
                            <img src="{{ asset('storage/' . $member->photo) }}" 
                                 alt="{{ $member->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-emerald-100 to-teal-50 flex items-center justify-center text-emerald-700 font-black text-4xl">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
                                {{ $member->name }}
                            </h3>
                            <span class="text-xs font-bold text-emerald-700 block mt-0.5">
                                {{ $member->role }}
                            </span>
                            @if($member->bio)
                                <p class="text-xs text-slate-500 mt-2 line-clamp-3 leading-relaxed">
                                    {{ $member->bio }}
                                </p>
                            @endif
                        </div>

                        <!-- Social Handles -->
                        <div class="pt-3 border-t border-slate-100 flex items-center gap-3 text-slate-400">
                            @if(isset($member->social_links['linkedin']))
                                <a href="{{ $member->social_links['linkedin'] }}" target="_blank" rel="noopener" class="hover:text-blue-600 transition" aria-label="LinkedIn">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                </a>
                            @endif
                            @if(isset($member->social_links['twitter']))
                                <a href="{{ $member->social_links['twitter'] }}" target="_blank" rel="noopener" class="hover:text-slate-800 transition" aria-label="X / Twitter">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-slate-200 text-slate-500 text-sm">
                    Leadership members will be listed shortly.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 6. Our Registration & Legal Details (Accreditations Grid) -->
    <section class="space-y-8">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                Legal Accreditations & Registrations
            </span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                Our Registration & Legal Details
            </h2>
            <p class="text-xs sm:text-sm text-slate-500">
                We are a registered non-profit organization, committed to complete statutory compliance and 100% public audit transparency.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Registered Trust -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Registered Trust</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Reg. No: <span class="font-mono font-bold text-slate-800">{{ setting('ngo_reg_number', '1234/2018') }}</span></p>
                </div>
            </div>

            <!-- 12A Certificate -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">12A Certificate</h3>
                    <p class="text-xs text-slate-500 mt-0.5">No. <span class="font-mono font-bold text-slate-800">{{ setting('12a_reg_number', 'AAATH1234A') }}</span></p>
                </div>
            </div>

            <!-- 80G Certificate -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">80G Certificate</h3>
                    <p class="text-xs text-slate-500 mt-0.5">No. <span class="font-mono font-bold text-emerald-700">{{ setting('80g_reg_number', 'AAATH1234AF') }}</span></p>
                </div>
            </div>

            <!-- FCRA Registration -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">FCRA Registration</h3>
                    <p class="text-xs text-slate-500 mt-0.5">No. <span class="font-mono font-bold text-slate-800">{{ setting('fcra_number', '123456789') }}</span></p>
                </div>
            </div>
        </div>

        <!-- Extra Credentials Strip: PAN & NGO Darpan -->
        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 flex flex-wrap items-center justify-between gap-4 text-xs text-slate-600">
            <div class="flex items-center gap-6">
                <div><span class="text-slate-400">Entity PAN:</span> <span class="font-mono font-bold text-slate-800">{{ setting('ngo_pan_number', 'AABTK1234F') }}</span></div>
                <div><span class="text-slate-400">NGO Darpan ID:</span> <span class="font-mono font-bold text-slate-800">{{ setting('ngo_darpan_id', 'UP/2024/0091823') }}</span></div>
            </div>
            <div class="flex items-center gap-2 text-emerald-700 font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                <span>50% Tax Exemption Under Section 80G</span>
            </div>
        </div>
    </section>

    <!-- 7. Bottom Conversion Banner: Be a Part of Our Journey -->
    <section class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-emerald-900 via-emerald-800 to-slate-900 text-white p-8 sm:p-14 shadow-2xl">
        <div class="absolute inset-0 z-0 opacity-15">
            <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070&auto=format&fit=crop" 
                 alt="Community Empowerment" 
                 class="w-full h-full object-cover">
        </div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
            <div class="space-y-2 max-w-2xl">
                <h3 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                    Be a Part of Our Journey
                </h3>
                <p class="text-sm sm:text-base text-emerald-100 leading-relaxed">
                    Your support can help us create more opportunities, better communities, and a brighter tomorrow for every vulnerable life.
                </p>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-4 shrink-0">
                <a href="{{ route('donate.index') }}" 
                   class="px-8 py-3.5 bg-white text-emerald-900 hover:bg-slate-100 rounded-full font-extrabold text-sm shadow-xl transition transform hover:-translate-y-0.5">
                    Donate Now
                </a>
                <a href="{{ route('volunteers.create') }}" 
                   class="px-8 py-3.5 bg-emerald-700/80 hover:bg-emerald-700 text-white border border-white/20 rounded-full font-extrabold text-sm shadow-xl transition transform hover:-translate-y-0.5">
                    Become a Volunteer
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
