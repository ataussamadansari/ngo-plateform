@extends('layouts.base')

@section('title', 'About Us — ' . (function_exists('setting') ? setting('ngo_name', 'Hope Foundation') : 'Hope Foundation'))

@section('content')
@php
    $ngoName = function_exists('setting') ? setting('ngo_name', 'Hope Foundation') : 'Hope Foundation';
    $homeUrl = Route::has('home') ? route('home') : url('/');
    $donateUrl = Route::has('donate.index') ? route('donate.index') : url('/donate');
    $volunteerUrl = Route::has('volunteers.create') ? route('volunteers.create') : url('/volunteer-join');

    // Default showcase team members matching the exact mockup if $teamMembers is empty
    $fallbackTeam = [
        [
            'name' => 'Amit Sharma',
            'role' => 'Founder & Director',
            'image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=500&q=80',
        ],
        [
            'name' => 'Priya Verma',
            'role' => 'Program Head',
            'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=500&q=80',
        ],
        [
            'name' => 'Rahul Singh',
            'role' => 'Operations Manager',
            'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=500&q=80',
        ],
        [
            'name' => 'Neha Khan',
            'role' => 'Community Outreach',
            'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=500&q=80',
        ],
    ];

    // 6 Journey Milestones from Mockup
    $defaultMilestones = [
        ['year' => '2018', 'line1' => 'Foundation', 'line2' => 'Started'],
        ['year' => '2019', 'line1' => 'First Education', 'line2' => 'Program'],
        ['year' => '2020', 'line1' => 'Healthcare', 'line2' => 'Camps Initiated'],
        ['year' => '2021', 'line1' => 'Clean Water', 'line2' => 'Projects'],
        ['year' => '2023', 'line1' => 'Expanded to', 'line2' => '5+ States'],
        ['year' => '2025', 'line1' => '12,500+', 'line2' => 'Lives Impacted'],
    ];

    $milestones = $defaultMilestones;
    if (function_exists('setting') && setting('about_milestones')) {
        $stored = json_decode(setting('about_milestones'), true);
        if (is_array($stored) && !empty($stored)) {
            $milestones = $stored;
        }
    }

    $aboutBanner = function_exists('setting') && setting('about_banner_image')
        ? asset('storage/' . setting('about_banner_image'))
        : 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=1920&q=85';
    $aboutHeroTitle = function_exists('setting') ? setting('about_hero_title', 'About Us') : 'About Us';
    $aboutHeroSubtitle = function_exists('setting') ? setting('about_hero_subtitle', 'People | Purpose | Positive Change') : 'People | Purpose | Positive Change';
    $aboutHeroScript = function_exists('setting') ? setting('about_hero_script', 'Real People, Real Change 💚') : 'Real People, Real Change 💚';
    $storyBadge = function_exists('setting') ? setting('about_story_badge', 'OUR STORY • The Grassroots Story') : 'OUR STORY • The Grassroots Story';
    $storyTitle = function_exists('setting') ? setting('about_story_title', 'The Grassroots Story: A Small Step Towards a Brighter Tomorrow') : 'The Grassroots Story: A Small Step Towards a Brighter Tomorrow';
    $storyContent = function_exists('setting') ? setting('about_story_content') : null;
    $storyImage = function_exists('setting') && setting('about_story_image')
        ? asset('storage/' . setting('about_story_image'))
        : 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?auto=format&fit=crop&w=1000&q=85';
    $mission = function_exists('setting') ? setting('about_mission', 'To empower underprivileged communities through education, healthcare, clean environment and sustainable development.') : 'To empower underprivileged communities through education, healthcare, clean environment and sustainable development.';
    $vision = function_exists('setting') ? setting('about_vision', 'A healthier, educated and more equal society where every individual can reach their full potential.') : 'A healthier, educated and more equal society where every individual can reach their full potential.';
    $values = function_exists('setting') ? setting('about_values', 'Integrity, total transparency, direct empathy and unwavering community commitment.') : 'Integrity, total transparency, direct empathy and unwavering community commitment.';
@endphp

<!-- ================= 1. TOP HERO BANNER ================= -->
<section class="relative min-h-[240px] sm:min-h-[280px] lg:min-h-[310px] flex items-center overflow-hidden bg-[#0a2617]">
    <!-- Background Photo + Warm Dark-Green Gradient Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ $aboutBanner }}"
             alt="{{ $ngoName }} About Us"
             class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-gradient-to-r from-[#071f12]/90 via-[#0a2617]/65 to-[#071f12]/70"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <!-- Left: Title, Subtitle & Breadcrumb -->
            <div class="space-y-2" data-reveal>
                <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                    {{ $aboutHeroTitle }}
                </h1>
                <p class="text-sm sm:text-lg font-medium text-white/90 tracking-wide">
                    {{ $aboutHeroSubtitle }}
                </p>
                <nav class="flex items-center gap-2 text-xs font-medium text-white/75 pt-2">
                    <a href="{{ $homeUrl }}" class="hover:text-[#86efac] transition-colors">Home</a>
                    <span>&rsaquo;</span>
                    <span class="text-white font-semibold">About Us</span>
                </nav>
            </div>

            <!-- Right: Handwritten Script Overlay -->
            <div class="hidden sm:block pr-4 -rotate-6 select-none" data-reveal data-reveal-delay="150">
                <p class="font-script text-4xl lg:text-5xl text-white font-bold leading-none drop-shadow-md">
                    {{ $aboutHeroScript }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ================= 2. OUR STORY + PHOTO + MISSION/VISION/VALUES (3-COL) ================= -->
<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-9 items-center">

            <!-- Left Column (4 Cols): Our Story Narrative -->
            <div class="lg:col-span-4 space-y-4" data-reveal>
                <span class="block text-xs font-extrabold uppercase tracking-[0.18em] text-[#16a34a]">
                    {{ $storyBadge }}
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ $storyTitle }}
                </h2>
                <div class="space-y-3.5 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    @if($storyContent)
                        {!! nl2br(e($storyContent)) !!}
                    @else
                        <p>
                            {{ $ngoName }} is a non-profit organization working towards education, health, environment and community development. We believe in a world where every individual gets equal opportunities to live a healthy, educated and dignified life.
                        </p>
                        <p>
                            What started as a small initiative has now grown into a movement of thousands of supporters, volunteers and changemakers. Together, we are creating real and lasting impact in communities across India.
                        </p>
                    @endif
                </div>
                <div class="pt-2">
                    <a href="#our-journey"
                       class="inline-flex items-center gap-2 rounded-xl bg-[#16a34a] hover:bg-[#15803d] text-white text-xs sm:text-sm font-bold px-6 py-3 shadow-sm transition-all duration-300 group">
                        <span>Our Journey</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Center Column (4 Cols): Smiling Children Photo + White Brush Script Badge -->
            <div class="lg:col-span-4 relative" data-reveal data-reveal-delay="100">
                <div class="relative rounded-3xl overflow-hidden shadow-lg aspect-4/3 sm:aspect-square lg:aspect-4/3 bg-slate-100">
                    <img src="{{ $storyImage }}"
                         alt="{{ $ngoName }} Story"
                         class="w-full h-full object-cover">

                    <!-- Bottom-Right White Brush-Stroke Quote Badge -->
                    <div class="absolute bottom-3 right-3 sm:bottom-4 sm:right-4 bg-white/95 backdrop-blur-xs px-5 py-3 shadow-xl -rotate-2 max-w-[230px]"
                         style="border-radius: 18px 6px 20px 8px;">
                        <p class="font-script text-xl sm:text-2xl font-bold text-slate-900 leading-5 text-center">
                            Because every <span class="text-[#16a34a]">🌱</span><br>
                            child deserves <br>
                            a brighter tomorrow <span class="text-[#16a34a]">🌿</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Column (4 Cols): 3 Tinted Mission / Vision / Values Cards -->
            <div class="lg:col-span-4 space-y-3.5" data-reveal data-reveal-delay="200">
                <!-- Our Mission (Soft Mint Card) -->
                <div class="bg-[#f0fdf4] rounded-2xl p-4 sm:p-5 border border-[#dcfce7] flex items-start gap-4">
                    <div class="w-11 h-11 rounded-full bg-white text-[#16a34a] shadow-2xs flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/><path stroke-linecap="round" d="M12 3v2m0 14v2m9-9h-2M5 12H3"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Our Mission</h3>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            {{ $mission }}
                        </p>
                    </div>
                </div>

                <!-- Our Vision (Soft Sky Blue Card) -->
                <div class="bg-[#eff6ff] rounded-2xl p-4 sm:p-5 border border-blue-100 flex items-start gap-4">
                    <div class="w-11 h-11 rounded-full bg-white text-blue-600 shadow-2xs flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Our Vision</h3>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            {{ $vision }}
                        </p>
                    </div>
                </div>

                <!-- Our Values (Soft Warm Cream/Amber Card) -->
                <div class="bg-[#fffbeb] rounded-2xl p-4 sm:p-5 border border-amber-100 flex items-start gap-4">
                    <div class="w-11 h-11 rounded-full bg-white text-amber-500 shadow-2xs flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Our Values</h3>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            {{ $values }}
                        </p>
                    </div>
                </div>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            Integrity, Transparency, Compassion, Impact and Community First.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= 3. OUR IMPACT IN NUMBERS CONTAINER ================= -->
<section class="py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#eef8f1] rounded-3xl p-6 sm:p-8 border border-[#d8f3df]" data-reveal>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">

                <!-- Left Title Column (3 Cols) -->
                <div class="lg:col-span-3 space-y-1.5 text-left">
                    <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-tight">
                        Our Impact <br class="hidden lg:inline">In Numbers
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Together we are creating real change in people's lives.
                    </p>
                </div>

                <!-- Right 4 White Inner Cards (9 Cols) -->
                <div class="lg:col-span-9 grid grid-cols-2 sm:grid-cols-4 gap-3.5 sm:gap-4">
                    <!-- Stat Card 1 -->
                    <div class="bg-white/90 rounded-2xl p-4 text-center border border-white shadow-2xs">
                        <div class="w-10 h-10 rounded-xl bg-[#eef8f1] text-[#16a34a] flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                        </div>
                        <span class="block text-xl sm:text-2xl font-extrabold text-slate-900">
                            {{ function_exists('setting') ? setting('total_lives_impacted', '12,500+') : '12,500+' }}
                        </span>
                        <span class="block text-[11px] font-medium text-slate-500 mt-0.5">Lives Impacted</span>
                    </div>

                    <!-- Stat Card 2 -->
                    <div class="bg-white/90 rounded-2xl p-4 text-center border border-white shadow-2xs">
                        <div class="w-10 h-10 rounded-xl bg-[#eef8f1] text-[#16a34a] flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </div>
                        <span class="block text-xl sm:text-2xl font-extrabold text-slate-900">₹2.8 Cr+</span>
                        <span class="block text-[11px] font-medium text-slate-500 mt-0.5">Funds Utilized</span>
                    </div>

                    <!-- Stat Card 3 -->
                    <div class="bg-white/90 rounded-2xl p-4 text-center border border-white shadow-2xs">
                        <div class="w-10 h-10 rounded-xl bg-[#eef8f1] text-[#16a34a] flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="block text-xl sm:text-2xl font-extrabold text-slate-900">
                            {{ function_exists('setting') ? setting('total_projects_completed', '150+') : '150+' }}
                        </span>
                        <span class="block text-[11px] font-medium text-slate-500 mt-0.5">Projects Completed</span>
                    </div>

                    <!-- Stat Card 4 -->
                    <div class="bg-white/90 rounded-2xl p-4 text-center border border-white shadow-2xs">
                        <div class="w-10 h-10 rounded-xl bg-[#eef8f1] text-[#16a34a] flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8M12 3a15 15 0 014 9 15 15 0 01-4 9 15 15 0 01-4-9 15 15 0 014-9z"/></svg>
                        </div>
                        <span class="block text-xl sm:text-2xl font-extrabold text-slate-900">5,000+</span>
                        <span class="block text-[11px] font-medium text-slate-500 mt-0.5">Supporters & Donors</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- ================= 4. SIDE-BY-SIDE: OUR JOURNEY (5 COLS) + OUR TEAM (7 COLS) ================= -->
<section id="our-journey" class="py-12 lg:py-16 bg-white scroll-mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-start">

            <!-- Left Column (5 Cols): Our Journey Timeline -->
            <div class="lg:col-span-5 space-y-6" data-reveal>
                <div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                        Our Journey
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        From a small idea to a growing movement, here are some key milestones of our journey.
                    </p>
                </div>

                <!-- Desktop Horizontal 6-Node Timeline (`sm` and above) -->
                <div class="hidden sm:block pt-6 pb-2">
                    <div class="relative">
                        <!-- Horizontal Connecting Line -->
                        <div class="absolute top-2.5 left-4 right-4 h-0.5 bg-[#bbf7d0]"></div>

                        <div class="grid grid-cols-6 gap-2 relative z-10">
                            @foreach($milestones as $ms)
                                <div class="flex flex-col items-center text-center">
                                    <!-- Green Node Dot -->
                                    <span class="w-5 h-5 rounded-full bg-[#16a34a] border-4 border-[#dcfce7] shadow-2xs"></span>
                                    <!-- Vertical Tick -->
                                    <span class="w-px h-3 bg-slate-200 my-1"></span>
                                    <!-- Year -->
                                    <span class="text-xs font-extrabold text-slate-900">{{ $ms['year'] }}</span>
                                    <!-- Label -->
                                    <p class="text-[10px] text-slate-500 leading-tight mt-1">
                                        {{ $ms['line1'] }} <br>{{ $ms['line2'] }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Mobile 2-Column Vertical Timeline (`< sm`, matching mobile mockup) -->
                <div class="grid grid-cols-2 gap-4 sm:hidden pt-2">
                    @foreach(array_chunk($milestones, 3) as $colMilestones)
                        <div class="relative pl-5 space-y-5 border-l-2 border-[#bbf7d0]">
                            @foreach($colMilestones as $ms)
                                <div class="relative">
                                    <span class="absolute -left-[25px] top-1 w-3.5 h-3.5 rounded-full bg-[#16a34a] border-2 border-white"></span>
                                    <span class="block text-xs font-extrabold text-slate-900">{{ $ms['year'] }}</span>
                                    <span class="block text-[11px] text-slate-500 leading-tight">{{ $ms['line1'] }} {{ $ms['line2'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Column (7 Cols): Our Team (4 Portrait Cards) -->
            <div class="lg:col-span-7 space-y-5" data-reveal data-reveal-delay="150">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                            Our Team
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            A dedicated team of changemakers working for a better tomorrow.
                        </p>
                    </div>

                    <a href="{{ $volunteerUrl }}"
                       class="shrink-0 inline-flex items-center gap-1 rounded-full bg-[#eef8f1] hover:bg-[#dcfce7] text-[#16a34a] text-xs font-bold px-3.5 py-1.5 border border-[#bbf7d0] transition-colors">
                        <span>View All Members</span>
                        <span>&rarr;</span>
                    </a>
                </div>

                <!-- 4-Column Team Cards Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @if(isset($teamMembers) && $teamMembers->count() > 0)
                        @foreach($teamMembers->take(4) as $idx => $member)
                            <x-team-member-card
                                :name="$member->name"
                                :role="$member->role"
                                :image="$member->photo && file_exists(storage_path('app/public/' . $member->photo)) ? asset('storage/' . $member->photo) : $fallbackTeam[$idx % 4]['image']"
                            />
                        @endforeach
                    @else
                        @foreach($fallbackTeam as $member)
                            <x-team-member-card
                                :name="$member['name']"
                                :role="$member['role']"
                                :image="$member['image']"
                            />
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= 5. OUR REGISTRATION & LEGAL DETAILS BOX ================= -->
<section class="pb-12 lg:pb-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#eef8f1] rounded-3xl p-6 sm:p-8 border border-[#d8f3df] space-y-6" data-reveal>
            <div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                    Legal Accreditations & Registrations
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                    We are a registered non-profit organization, committed to complete transparency.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- 1. Registered Trust -->
                <x-legal-badge-card
                    title="Registered Trust"
                    :subtitle="'Reg. No: ' . (function_exists('setting') ? setting('ngo_reg_number', '1234/2018') : '1234/2018')"
                    color="green">
                    <x-slot:icon>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </x-slot:icon>
                </x-legal-badge-card>

                <!-- 2. 12A Certificate -->
                <x-legal-badge-card
                    title="12A Certificate"
                    :subtitle="'No. ' . (function_exists('setting') ? setting('12a_reg_number', 'AAATH1234A') : 'AAATH1234A')"
                    color="blue">
                    <x-slot:icon>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </x-slot:icon>
                </x-legal-badge-card>

                <!-- 3. 80G Certificate -->
                <x-legal-badge-card
                    title="80G Certificate"
                    :subtitle="'No. ' . (function_exists('setting') ? setting('80g_reg_number', 'AAATH1234AF') : 'AAATH1234AF')"
                    color="amber">
                    <x-slot:icon>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                    </x-slot:icon>
                </x-legal-badge-card>

                <!-- 4. PAN Number -->
                <x-legal-badge-card
                    title="Income Tax PAN"
                    :subtitle="'PAN: ' . (function_exists('setting') ? setting('ngo_pan_number', 'AAATH1234P') : 'AAATH1234P')"
                    color="indigo">
                    <x-slot:icon>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8M12 3a15 15 0 014 9 15 15 0 01-4 9 15 15 0 01-4-9 15 15 0 014-9z"/></svg>
                    </x-slot:icon>
                </x-legal-badge-card>
            </div>
        </div>
    </div>
</section>

<!-- ================= 6. FULL-WIDTH BOTTOM CTA BANNER ("BE A PART OF OUR JOURNEY") ================= -->
<section class="relative bg-[#0a2617] text-white py-14 lg:py-16 overflow-hidden">
    <!-- Background Children Photo + Dark Forest Gradient Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1509099836639-18ba1795216d?auto=format&fit=crop&w=1920&q=80"
             alt="Be a part of our journey"
             class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-r from-[#071f12]/90 via-[#0a2617]/75 to-[#071f12]/90"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6" data-reveal>
            <div class="space-y-2 max-w-xl">
                <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white">
                    Be a Part of Our Journey
                </h2>
                <p class="text-sm sm:text-base text-white/85 leading-relaxed">
                    Your support can help us create more opportunities, better communities and a brighter tomorrow.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3.5 shrink-0">
                <a href="{{ $donateUrl }}"
                   class="inline-flex items-center justify-center rounded-xl bg-white hover:bg-slate-100 text-slate-900 text-sm font-extrabold px-7 py-3.5 shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                    Donate Now
                </a>
                <a href="{{ $volunteerUrl }}"
                   class="inline-flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/40 text-white text-sm font-bold px-7 py-3.5 transition-all duration-300">
                    Become a Volunteer
                </a>
            </div>
        </div>
    </div>
</section>
@endsection