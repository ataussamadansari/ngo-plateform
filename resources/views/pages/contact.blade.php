{{-- resources/views/pages/contact.blade.php --}}
@extends('layouts.base')

@section('title', 'Contact Us - ' . setting('ngo_name', 'Hope Foundation'))
@section('meta_description', 'Get in touch with ' . setting('ngo_name', 'Hope Foundation') . '. Reach out for queries, partnerships, volunteering, or visit our Varanasi office.')

@section('content')
    @php
        $ngoName       = setting('ngo_name', 'Hope Foundation');
        $officeAddress = setting('contact_address', setting('office_address', '123 NGO Street, Varanasi, Uttar Pradesh - 221001, India'));
        $contactPhone  = setting('contact_phone', '+91 87654 32109');
        $contactEmail  = setting('contact_email', 'info@hopefoundation.org');
        $websiteUrl    = setting('website_url', 'www.hopefoundation.org');
        $workingHours  = setting('working_hours', 'Mon - Sat: 9:00 AM - 6:00 PM');

        $quickHighlights = [
            [
                'title'         => 'Quick Response',
                'mobile_title'  => 'Quick Response',
                'subtitle'      => 'We usually reply within 24 hours',
                'mobile_sub'    => 'Reply within 24 hours',
                'icon'          => 'phone-incoming',
            ],
            [
                'title'         => 'Direct Communication',
                'mobile_title'  => 'Direct Contact',
                'subtitle'      => 'Connect with our team',
                'mobile_sub'    => 'Connect with our team',
                'icon'          => 'users',
            ],
            [
                'title'         => 'Partnership Opportunities',
                'mobile_title'  => 'Partnerships',
                'subtitle'      => "Let's work together for change",
                'mobile_sub'    => 'Work together for change',
                'icon'          => 'handshake',
            ],
            [
                'title'         => 'Visit Us',
                'mobile_title'  => 'Visit Us',
                'subtitle'      => 'We welcome you at our office',
                'mobile_sub'    => 'Welcome at our office',
                'icon'          => 'map-pin',
            ],
        ];

        $faqs = [
            [
                'question' => 'How can I reach your team?',
                'answer'   => 'You can reach us directly by filling out the contact form on this page, calling us at ' . $contactPhone . ' during working hours, or emailing us at ' . $contactEmail . '. We typically respond within 24 hours.',
            ],
            [
                'question' => 'Can I visit your office?',
                'answer'   => 'Yes! We warmly welcome donors, volunteers, and community members at our head office (' . $officeAddress . ') Monday through Saturday between 9:00 AM and 6:00 PM.',
            ],
            [
                'question' => 'How can I partner with your NGO?',
                'answer'   => 'We collaborate with corporates (CSR), schools, hospitals, and local institutions. Select "Partnership / CSR" in the message form above or write to ' . $contactEmail . ' with your proposal.',
            ],
            [
                'question' => 'Do you have internship or volunteering opportunities?',
                'answer'   => 'Absolutely! You can apply online through our Volunteer Registration page or choose "Volunteering / Internship" in the contact form to join our on-ground field drives.',
            ],
        ];
    @endphp

    {{-- ===================================================================
         1. HERO SECTION (Dark Green Gradient Overlay + Script Callout)
    ==================================================================== --}}
    <section class="relative overflow-hidden bg-[#0a2617]">
        {{-- Background Image & Multi-Stop Dark Forest Overlay --}}
        <div class="absolute inset-0 z-0">
            <img
                src="{{ function_exists('setting') && setting('contact_banner_image') ? asset('storage/' . setting('contact_banner_image')) : 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?auto=format&fit=crop&w=1920&q=85' }}"
                alt="Contact {{ $ngoName }}"
                class="w-full h-full object-cover object-center scale-105 transition-transform duration-1000"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-[#071f12]/92 via-[#0a2617]/75 to-black/30"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#071f12]/80 via-transparent to-black/25"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                {{-- Left Column: Eyebrow, Heading & Subtitle --}}
                <div class="lg:col-span-7 text-white" data-aos="fade-right">
                    <div class="inline-flex items-center gap-2 mb-3">
                        <span class="text-[11px] sm:text-xs font-extrabold uppercase tracking-[0.2em] text-[#4ade80]">
                            CONTACT US
                        </span>
                    </div>

                    <h1 class="font-heading text-3xl sm:text-4xl lg:text-[44px] font-extrabold tracking-tight leading-[1.12] mb-3.5 text-white drop-shadow-xs">
                        We Are Here to Help & Connect
                    </h1>

                    <p class="text-xs sm:text-sm lg:text-[15px] text-white/90 font-normal leading-relaxed max-w-xl">
                        Have a question, suggestion, or want to collaborate? We'd love to hear from you. Let's create a greater impact together.
                    </p>
                </div>

                {{-- Right Column: Handwritten Script Callout (Desktop) --}}
                <div class="hidden lg:flex lg:col-span-5 justify-end items-center pr-4" data-aos="fade-left" data-aos-delay="150">
                    <div class="text-right transform -rotate-2 select-none">
                        <p class="font-script text-3xl xl:text-[36px] text-white/95 leading-[1.2] drop-shadow-md">
                            Let's Connect<br>
                            For a Brighter<br>
                            Tomorrow <span class="inline-block text-[#4ade80] align-middle">💚</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================================================================
         2. 4-COLUMN QUICK FEATURE PILLS STRIP
    ==================================================================== --}}
    <section class="pt-6 sm:pt-8 pb-4 bg-[#fcfdfc]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-4 gap-2 sm:gap-4 lg:gap-5" data-aos="fade-up">
                @foreach($quickHighlights as $item)
                    <div class="bg-[#f2fbf5] hover:bg-[#eaf8ef] rounded-2xl p-2.5 sm:p-4 border border-[#d8f3df] shadow-2xs transition-all duration-300 flex flex-col sm:flex-row items-center sm:items-center text-center sm:text-left gap-2 sm:gap-3.5">
                        {{-- Icon Circle --}}
                        <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-full bg-[#dcfce7] border border-[#bbf7d0] text-[#16a34a] flex items-center justify-center shrink-0">
                            @if($item['icon'] === 'phone-incoming')
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                                </svg>
                            @elseif($item['icon'] === 'users')
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                                </svg>
                            @elseif($item['icon'] === 'handshake')
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                            @endif
                        </div>

                        {{-- Text --}}
                        <div class="min-w-0">
                            <h2 class="hidden sm:block font-heading text-xs lg:text-[13.5px] font-extrabold text-[#14291b] leading-snug">
                                {{ $item['title'] }}
                            </h2>
                            <h2 class="sm:hidden font-heading text-[10px] font-extrabold text-[#14291b] leading-tight">
                                {{ $item['mobile_title'] }}
                            </h2>
                            <p class="hidden sm:block text-[11px] lg:text-xs text-slate-600 mt-0.5 leading-snug">
                                {{ $item['subtitle'] }}
                            </p>
                            <p class="sm:hidden text-[9px] text-slate-500 mt-0.5 leading-tight">
                                {{ $item['mobile_sub'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================================================================
         3. MAIN 2-COLUMN SECTION: SEND US A MESSAGE + OUR OFFICE
    ==================================================================== --}}
    <section class="py-5 sm:py-8 bg-[#fcfdfc]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-7 items-stretch">

                {{-- LEFT COLUMN (6 Cols): Send Us a Message Form Card --}}
                <div class="lg:col-span-6 flex" data-aos="fade-up">
                    <div class="w-full bg-white rounded-3xl p-5 sm:p-7 lg:p-8 border border-slate-200/85 shadow-xs flex flex-col justify-between">
                        <div>
                            {{-- Card Header --}}
                            <div class="mb-5">
                                <div class="flex items-center gap-2.5 mb-1.5">
                                    <span class="w-7 h-7 rounded-lg bg-[#16a34a] text-white flex items-center justify-center shrink-0 shadow-2xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                        </svg>
                                    </span>
                                    <h2 class="font-heading text-lg sm:text-xl font-extrabold text-[#14291b]">
                                        Send Us an Inquiry
                                    </h2>
                                </div>
                                <p class="text-xs sm:text-[13px] text-slate-500">
                                    Fill out the form below and we'll get back to you as soon as possible.
                                </p>
                            </div>

                            {{-- Flash Success Message --}}
                            @if(session('success'))
                                <div class="mb-5 rounded-2xl bg-[#f0fdf4] border border-[#bbf7d0] p-4 flex items-start gap-3">
                                    <span class="w-6 h-6 rounded-full bg-[#16a34a] text-white flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                        </svg>
                                    </span>
                                    <div class="text-xs sm:text-sm font-semibold text-[#14532d]">
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif

                            {{-- Contact Inquiry Form --}}
                            <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                                @csrf

                                {{-- Row 1: Full Name + Email Address --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="name" class="block text-xs font-bold text-[#14291b] mb-1.5">
                                            Full Name <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            value="{{ old('name') }}"
                                            required
                                            placeholder="Enter your full name"
                                            class="w-full rounded-xl border border-slate-200 bg-[#fcfdfc] px-3.5 py-2.5 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#16a34a] focus:ring-2 focus:ring-[#16a34a]/15 focus:outline-none transition"
                                        >
                                        @error('name')
                                            <p class="mt-1 text-[11px] font-medium text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="email" class="block text-xs font-bold text-[#14291b] mb-1.5">
                                            Email Address <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            required
                                            placeholder="Enter your email address"
                                            class="w-full rounded-xl border border-slate-200 bg-[#fcfdfc] px-3.5 py-2.5 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#16a34a] focus:ring-2 focus:ring-[#16a34a]/15 focus:outline-none transition"
                                        >
                                        @error('email')
                                            <p class="mt-1 text-[11px] font-medium text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Row 2: Mobile Number + Subject Dropdown --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="phone" class="block text-xs font-bold text-[#14291b] mb-1.5">
                                            Mobile Number
                                        </label>
                                        <input
                                            type="text"
                                            id="phone"
                                            name="phone"
                                            value="{{ old('phone') }}"
                                            placeholder="Enter your mobile number"
                                            class="w-full rounded-xl border border-slate-200 bg-[#fcfdfc] px-3.5 py-2.5 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#16a34a] focus:ring-2 focus:ring-[#16a34a]/15 focus:outline-none transition"
                                        >
                                        @error('phone')
                                            <p class="mt-1 text-[11px] font-medium text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="subject" class="block text-xs font-bold text-[#14291b] mb-1.5">
                                            Subject <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <select
                                                id="subject"
                                                name="subject"
                                                required
                                                class="w-full appearance-none rounded-xl border border-slate-200 bg-[#fcfdfc] px-3.5 py-2.5 pr-9 text-xs sm:text-sm text-slate-700 focus:bg-white focus:border-[#16a34a] focus:ring-2 focus:ring-[#16a34a]/15 focus:outline-none transition"
                                            >
                                                <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Select a subject</option>
                                                <option value="General Inquiry" {{ old('subject') === 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                                <option value="Donation & 80G Receipt Support" {{ old('subject') === 'Donation & 80G Receipt Support' ? 'selected' : '' }}>Donation &amp; 80G Receipt Support</option>
                                                <option value="Partnership / CSR Collaboration" {{ old('subject') === 'Partnership / CSR Collaboration' ? 'selected' : '' }}>Partnership / CSR Collaboration</option>
                                                <option value="Volunteering / Internship" {{ old('subject') === 'Volunteering / Internship' ? 'selected' : '' }}>Volunteering / Internship</option>
                                                <option value="Media & Press Inquiry" {{ old('subject') === 'Media & Press Inquiry' ? 'selected' : '' }}>Media &amp; Press Inquiry</option>
                                            </select>
                                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                                </svg>
                                            </span>
                                        </div>
                                        @error('subject')
                                            <p class="mt-1 text-[11px] font-medium text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Row 3: Message Textarea --}}
                                <div>
                                    <label for="message" class="block text-xs font-bold text-[#14291b] mb-1.5">
                                        Message <span class="text-red-500">*</span>
                                    </label>
                                    <textarea
                                        id="message"
                                        name="message"
                                        rows="4"
                                        required
                                        placeholder="Tell us more about your query, suggestion or collaboration idea..."
                                        class="w-full rounded-xl border border-slate-200 bg-[#fcfdfc] px-3.5 py-2.5 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#16a34a] focus:ring-2 focus:ring-[#16a34a]/15 focus:outline-none transition resize-y"
                                    >{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="mt-1 text-[11px] font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Submit Button --}}
                                <div class="pt-1">
                                    <button
                                        type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-[#16a34a] hover:bg-[#15803d] text-white font-bold text-sm shadow-sm hover:shadow transition-all duration-200 cursor-pointer"
                                    >
                                        <svg class="w-4 h-4 -rotate-12" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                                        </svg>
                                        <span>Send Message</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Bottom Privacy Reassurance Note --}}
                        <div class="mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-center gap-1.5 text-center">
                            <svg class="w-3.5 h-3.5 text-[#16a34a] shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-[11px] text-slate-500">
                                Your information is safe with us. We never share your data with third parties.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN (6 Cols): Our Office Card + Embedded Map --}}
                <div class="lg:col-span-6 flex" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-full bg-white rounded-3xl p-5 sm:p-7 lg:p-8 border border-slate-200/85 shadow-xs flex flex-col justify-between gap-5">
                        <div>
                            {{-- Card Header --}}
                            <div class="mb-4">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="w-7 h-7 rounded-lg bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                    <h2 class="font-heading text-lg sm:text-xl font-extrabold text-[#14291b]">
                                        Our Office
                                    </h2>
                                </div>
                                <p class="text-xs sm:text-[13px] text-slate-500">
                                    We'd be happy to welcome you at our office. Feel free to visit us during working hours.
                                </p>
                            </div>

                            {{-- Inner 2-Column Split: Building Photo + Socials (Left) | Contact Details (Right) --}}
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 sm:gap-5 items-start">
                                {{-- Left Sub-Column (5 Cols): Office Photo & Social Media Buttons --}}
                                <div class="sm:col-span-5">
                                    <div class="relative rounded-2xl overflow-hidden border border-slate-200/80 shadow-2xs aspect-4/3 bg-slate-100">
                                        <img
                                            src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=700&q=80"
                                            alt="{{ $ngoName }} Office Building"
                                            class="w-full h-full object-cover"
                                            loading="lazy"
                                        >
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-transparent to-transparent"></div>
                                        <div class="absolute bottom-2.5 left-3 right-3 flex items-center gap-1.5 text-white">
                                            <span class="w-2 h-2 rounded-full bg-[#4ade80]"></span>
                                            <span class="text-[11px] font-bold tracking-wide truncate">{{ $ngoName }} HQ</span>
                                        </div>
                                    </div>

                                    {{-- Colored Social Media Row --}}
                                    <div class="mt-3 flex items-center justify-center sm:justify-start gap-2">
                                        {{-- Facebook --}}
                                        <a href="{{ setting('facebook_url', '#') }}" target="_blank" rel="noopener" aria-label="Facebook" class="w-7 h-7 rounded-lg bg-[#1877F2] hover:opacity-90 text-white flex items-center justify-center shadow-2xs transition">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                                        </a>
                                        {{-- Instagram --}}
                                        <a href="{{ setting('instagram_url', '#') }}" target="_blank" rel="noopener" aria-label="Instagram" class="w-7 h-7 rounded-lg bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] hover:opacity-90 text-white flex items-center justify-center shadow-2xs transition">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                        </a>
                                        {{-- YouTube --}}
                                        <a href="{{ setting('youtube_url', '#') }}" target="_blank" rel="noopener" aria-label="YouTube" class="w-7 h-7 rounded-lg bg-[#FF0000] hover:opacity-90 text-white flex items-center justify-center shadow-2xs transition">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                        </a>
                                        {{-- LinkedIn --}}
                                        <a href="{{ setting('linkedin_url', '#') }}" target="_blank" rel="noopener" aria-label="LinkedIn" class="w-7 h-7 rounded-lg bg-[#0A66C2] hover:opacity-90 text-white flex items-center justify-center shadow-2xs transition">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
                                        </a>
                                        {{-- X (Twitter) --}}
                                        <a href="{{ setting('twitter_url', '#') }}" target="_blank" rel="noopener" aria-label="X" class="w-7 h-7 rounded-lg bg-[#0f172a] hover:opacity-90 text-white flex items-center justify-center shadow-2xs transition">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                        </a>
                                    </div>
                                </div>

                                {{-- Right Sub-Column (7 Cols): Address, Phone, Email, Website, Working Hours --}}
                                <div class="sm:col-span-7 space-y-2.5 text-xs">
                                    {{-- Address --}}
                                    <div class="flex items-start gap-2.5">
                                        <span class="w-6 h-6 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                            </svg>
                                        </span>
                                        <p class="text-slate-700 font-medium leading-snug">
                                            {{ $officeAddress }}
                                        </p>
                                    </div>

                                    {{-- Phone --}}
                                    <div class="flex items-start gap-2.5">
                                        <span class="w-6 h-6 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                                            </svg>
                                        </span>
                                        <div>
                                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactPhone) }}" class="font-bold text-[#14291b] hover:text-[#16a34a] transition">
                                                {{ $contactPhone }}
                                            </a>
                                            <p class="text-[11px] text-slate-500">Mon - Sat, 9:00 AM - 6:00 PM</p>
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-6 h-6 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                            </svg>
                                        </span>
                                        <a href="mailto:{{ $contactEmail }}" class="font-medium text-slate-700 hover:text-[#16a34a] transition truncate">
                                            {{ $contactEmail }}
                                        </a>
                                    </div>

                                    {{-- Website --}}
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-6 h-6 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                                            </svg>
                                        </span>
                                        <span class="font-medium text-slate-700 truncate">
                                            {{ $websiteUrl }}
                                        </span>
                                    </div>

                                    {{-- Working Hours --}}
                                    <div class="flex items-start gap-2.5 pt-0.5">
                                        <span class="w-6 h-6 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </span>
                                        <div>
                                            <p class="font-bold text-[#14291b]">Working Hours</p>
                                            <p class="text-[11px] text-slate-600">{{ $workingHours }}</p>
                                            <p class="text-[11px] text-slate-500">Sunday: Closed</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Interactive / Styled Varanasi Map Widget --}}
                        <div class="relative rounded-2xl overflow-hidden border border-slate-200 shadow-2xs h-48 sm:h-52 bg-[#e8f0e8]">
                            <iframe
                                title="{{ $ngoName }} Office Location Map"
                                src="https://www.openstreetmap.org/export/embed.html?bbox=82.9500%2C25.2800%2C83.0300%2C25.3500&amp;layer=mapnik&amp;marker=25.3176%2C82.9739"
                                class="w-full h-full border-0 filter saturate-[0.95] contrast-[1.02]"
                                loading="lazy"
                            ></iframe>

                            {{-- Top-Left Floating Location Card (Matches Mockup) --}}
                            <div class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs rounded-xl px-3 py-2 shadow-sm border border-slate-200/80 pointer-events-auto">
                                <p class="text-xs font-extrabold text-[#14291b] leading-tight">{{ $ngoName }}</p>
                                <a
                                    href="https://www.google.com/maps/search/?api=1&query={{ urlencode($officeAddress) }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="text-[11px] font-semibold text-[#16a34a] hover:underline inline-flex items-center gap-1 mt-0.5"
                                >
                                    <span>View larger map</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===================================================================
         4. BOTTOM 2-COLUMN SECTION: FAQs + OTHER WAYS TO CONNECT
    ==================================================================== --}}
    <section class="pt-4 pb-14 sm:pb-20 bg-[#fcfdfc]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-7 items-stretch">

                {{-- LEFT COLUMN (6 Cols): Frequently Asked Questions --}}
                <div class="lg:col-span-6 flex" data-aos="fade-up">
                    <div
                        x-data="{ activeFaq: null }"
                        class="w-full bg-[#f2fbf5] rounded-3xl p-5 sm:p-7 border border-[#d8f3df] shadow-2xs flex flex-col justify-between"
                    >
                        <div>
                            {{-- Header Row --}}
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-6 h-6 rounded-full bg-[#16a34a] text-white flex items-center justify-center shrink-0 text-xs font-extrabold">
                                        ?
                                    </span>
                                    <h2 class="font-heading text-base sm:text-lg font-extrabold text-[#14291b]">
                                        Frequently Asked Questions
                                    </h2>
                                </div>

                                <a href="{{ route('about') }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#16a34a] hover:text-[#15803d] shrink-0">
                                    <span>View All</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                    </svg>
                                </a>
                            </div>

                            {{-- Accordion List --}}
                            <div class="space-y-2.5">
                                @foreach($faqs as $idx => $faq)
                                    <x-faq-item
                                        :index="$idx + 1"
                                        :question="$faq['question']"
                                        :answer="$faq['answer']"
                                    />
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN (6 Cols): Other Ways to Connect --}}
                <div class="lg:col-span-6 flex" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-full bg-[#eaf8ef] rounded-3xl p-5 sm:p-7 border border-[#d1f0da] shadow-2xs flex flex-col justify-between">
                        <div>
                            {{-- Header --}}
                            <div class="mb-4">
                                <div class="flex items-center gap-2.5 mb-1">
                                    <span class="w-6 h-6 rounded-full bg-[#16a34a] text-white flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/>
                                        </svg>
                                    </span>
                                    <h2 class="font-heading text-base sm:text-lg font-extrabold text-[#14291b]">
                                        <span class="hidden sm:inline">Other Ways to Connect</span>
                                        <span class="sm:hidden">Connect With Us</span>
                                    </h2>
                                </div>
                                <p class="text-xs text-slate-600">
                                    You can also reach us through the following channels.
                                </p>
                            </div>

                            {{-- Desktop 2x2 Cards Grid (Visible on sm and up) --}}
                            <div class="hidden sm:grid sm:grid-cols-2 gap-3.5 mt-2">
                                {{-- 1. Become a Volunteer --}}
                                <a href="{{ route('volunteers.create') }}" class="group bg-white hover:bg-[#f7fdf9] rounded-2xl p-4 border border-white hover:border-[#bbf7d0] shadow-2xs transition-all duration-200 flex items-center gap-3.5">
                                    <div class="w-11 h-11 rounded-2xl bg-[#dcfce7] text-[#16a34a] group-hover:bg-[#16a34a] group-hover:text-white transition-colors flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="font-heading text-xs lg:text-sm font-extrabold text-[#14291b] group-hover:text-[#16a34a] transition-colors">
                                            Become a Volunteer
                                        </h3>
                                        <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">
                                            Join our volunteer community
                                        </p>
                                    </div>
                                </a>

                                {{-- 2. Partner With Us --}}
                                <a href="#name" onclick="document.getElementById('subject').value='Partnership / CSR Collaboration';" class="group bg-white hover:bg-[#f7fdf9] rounded-2xl p-4 border border-white hover:border-[#bbf7d0] shadow-2xs transition-all duration-200 flex items-center gap-3.5">
                                    <div class="w-11 h-11 rounded-2xl bg-[#dcfce7] text-[#16a34a] group-hover:bg-[#16a34a] group-hover:text-white transition-colors flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="font-heading text-xs lg:text-sm font-extrabold text-[#14291b] group-hover:text-[#16a34a] transition-colors">
                                            Partner With Us
                                        </h3>
                                        <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">
                                            Collaborate for greater impact
                                        </p>
                                    </div>
                                </a>

                                {{-- 3. Media & Press --}}
                                <a href="#name" onclick="document.getElementById('subject').value='Media & Press Inquiry';" class="group bg-white hover:bg-[#f7fdf9] rounded-2xl p-4 border border-white hover:border-[#bbf7d0] shadow-2xs transition-all duration-200 flex items-center gap-3.5">
                                    <div class="w-11 h-11 rounded-2xl bg-[#dcfce7] text-[#16a34a] group-hover:bg-[#16a34a] group-hover:text-white transition-colors flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="font-heading text-xs lg:text-sm font-extrabold text-[#14291b] group-hover:text-[#16a34a] transition-colors">
                                            Media &amp; Press
                                        </h3>
                                        <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">
                                            For media queries and interviews
                                        </p>
                                    </div>
                                </a>

                                {{-- 4. General Enquiries --}}
                                <a href="mailto:{{ $contactEmail }}" class="group bg-white hover:bg-[#f7fdf9] rounded-2xl p-4 border border-white hover:border-[#bbf7d0] shadow-2xs transition-all duration-200 flex items-center gap-3.5">
                                    <div class="w-11 h-11 rounded-2xl bg-[#dcfce7] text-[#16a34a] group-hover:bg-[#16a34a] group-hover:text-white transition-colors flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="font-heading text-xs lg:text-sm font-extrabold text-[#14291b] group-hover:text-[#16a34a] transition-colors">
                                            General Enquiries
                                        </h3>
                                        <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">
                                            For any other questions
                                        </p>
                                    </div>
                                </a>
                            </div>

                            {{-- Mobile 4-Column Compact Icon Strip (Matches Mobile Mockup) --}}
                            <div class="grid grid-cols-4 gap-2 sm:hidden mt-3">
                                <a href="{{ route('volunteers.create') }}" class="bg-white rounded-xl p-2.5 text-center border border-white shadow-2xs flex flex-col items-center">
                                    <span class="w-9 h-9 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center mb-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                        </svg>
                                    </span>
                                    <span class="text-[10px] font-extrabold text-[#14291b] leading-tight">Volunteer</span>
                                    <span class="text-[8.5px] text-slate-500 mt-0.5 leading-tight">Join our team</span>
                                </a>

                                <a href="#name" onclick="document.getElementById('subject').value='Partnership / CSR Collaboration';" class="bg-white rounded-xl p-2.5 text-center border border-white shadow-2xs flex flex-col items-center">
                                    <span class="w-9 h-9 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center mb-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                                        </svg>
                                    </span>
                                    <span class="text-[10px] font-extrabold text-[#14291b] leading-tight">Partner</span>
                                    <span class="text-[8.5px] text-slate-500 mt-0.5 leading-tight">Work with us</span>
                                </a>

                                <a href="#name" onclick="document.getElementById('subject').value='Media & Press Inquiry';" class="bg-white rounded-xl p-2.5 text-center border border-white shadow-2xs flex flex-col items-center">
                                    <span class="w-9 h-9 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center mb-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282"/>
                                        </svg>
                                    </span>
                                    <span class="text-[10px] font-extrabold text-[#14291b] leading-tight">Media</span>
                                    <span class="text-[8.5px] text-slate-500 mt-0.5 leading-tight">Press queries</span>
                                </a>

                                <a href="mailto:{{ $contactEmail }}" class="bg-white rounded-xl p-2.5 text-center border border-white shadow-2xs flex flex-col items-center">
                                    <span class="w-9 h-9 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center mb-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                        </svg>
                                    </span>
                                    <span class="text-[10px] font-extrabold text-[#14291b] leading-tight">Enquiries</span>
                                    <span class="text-[8.5px] text-slate-500 mt-0.5 leading-tight">Other questions</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection