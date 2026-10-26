@extends('layouts.base')

@section('title', 'Contact Us - Office Address, Directions & Inquiries | ' . setting('ngo_name', 'Hope Foundation'))

@section('content')
<!-- 1. Flagship Hero Section -->
<section class="relative bg-gradient-to-b from-[#03150e] via-[#052117] to-[#041a12] text-white pt-16 pb-24 sm:pt-20 sm:pb-32 overflow-hidden">
    <!-- Ambient Glow & Background Image Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070&auto=format&fit=crop" 
             alt="Contact Hope Foundation" 
             class="w-full h-full object-cover opacity-15 mix-blend-luminosity filter blur-[0.5px]">
        <!-- <div class="absolute inset-0 bg-gradient-to-t from-[#041a12] via-[#052117]/90 to-[#03150e]/95"></div>
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 -right-32 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div> -->
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-white/10 pb-10">
            <div>
                <!-- Subtitle / Breadcrumbs -->
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 mb-3 tracking-wider uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Contact Us
                </span>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight">
                    We're Here For a Better Tomorrow
                </h1>
                <p class="mt-2 text-sm sm:text-base text-emerald-300/90 font-medium">
                    We Are Here to Help & Connect — Have a question, suggestion, or want to collaborate? We'd love to hear from you.
                </p>
            </div>

            <!-- Right Visual Accent: Let's Connect -->
            <div class="inline-flex items-center gap-3 bg-white/5 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/10 self-start md:self-end">
                <div class="w-10 h-10 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                    </svg>
                </div>
                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-emerald-400">Get In Touch</span>
                    <span class="text-sm font-extrabold text-white">Let's Connect For Impact 🌿</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20 space-y-16 lg:space-y-24">

    <!-- 2. Top Benefit Badges (4 Pills) -->
    <section class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        <!-- Quick Response -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
            </div>
            <div>
                <span class="text-xs sm:text-sm font-bold text-slate-900 block">Quick Response</span>
                <span class="text-[11px] text-slate-500 block">We usually reply within 24h</span>
            </div>
        </div>

        <!-- Direct Communication -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div>
                <span class="text-xs sm:text-sm font-bold text-slate-900 block">Direct Contact</span>
                <span class="text-[11px] text-slate-500 block">Connect with our ground team</span>
            </div>
        </div>

        <!-- Partnership Opportunities -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M11 4a2 2 0 1 1 4 0v4a2 2 0 1 1-4 0V4Z"/><path d="M18 9v1a6 6 0 0 1-12 0V9"/><path d="M5 19h14M12 15v4"/>
                </svg>
            </div>
            <div>
                <span class="text-xs sm:text-sm font-bold text-slate-900 block">CSR Partnerships</span>
                <span class="text-[11px] text-slate-500 block">Let's work together for change</span>
            </div>
        </div>

        <!-- Visit Us -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/>
                </svg>
            </div>
            <div>
                <span class="text-xs sm:text-sm font-bold text-slate-900 block">Visit Us</span>
                <span class="text-[11px] text-slate-500 block">Welcome at our Varanasi office</span>
            </div>
        </div>
    </section>

    <!-- 3. Main 2-Column Section: Form (Left) vs Our Office (Right) -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">

        <!-- Left: Send Us a Message (Inquiry Form) -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-sm space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Send Us a Message</h2>
                    <p class="text-xs text-slate-500">Send Us an Inquiry — Fill out the form below and we'll get back to you as soon as possible.</p>
                </div>
            </div>

            <!-- Flash Success Message -->
            @if (session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Full Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               placeholder="Enter your full name"
                               class="w-full bg-slate-50 border @error('name') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                        @error('name')
                            <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Email Address <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               placeholder="Enter your email address"
                               class="w-full bg-slate-50 border @error('email') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                        @error('email')
                            <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Mobile Number -->
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Mobile Number
                        </label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                               placeholder="Enter your mobile number"
                               class="w-full bg-slate-50 border @error('phone') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                        @error('phone')
                            <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject Dropdown -->
                    <div>
                        <label for="subject" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Subject <span class="text-rose-500">*</span>
                        </label>
                        <select id="subject" name="subject" required
                                class="w-full bg-slate-50 border @error('subject') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                            <option value="">Select a subject</option>
                            <option value="General Inquiry" {{ old('subject') === 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                            <option value="Donation & 80G Receipt Query" {{ old('subject') === 'Donation & 80G Receipt Query' ? 'selected' : '' }}>Donation & 80G Receipt Query</option>
                            <option value="Volunteering & Internships" {{ old('subject') === 'Volunteering & Internships' ? 'selected' : '' }}>Volunteering & Internships</option>
                            <option value="Corporate CSR Partnership Opportunity" {{ old('subject') === 'Corporate CSR Partnership Opportunity' ? 'selected' : '' }}>Corporate CSR Partnership Opportunity</option>
                            <option value="Media & Press Inquiry" {{ old('subject') === 'Media & Press Inquiry' ? 'selected' : '' }}>Media & Press Inquiry</option>
                        </select>
                        @error('subject')
                            <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Message <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="message" name="message" rows="5" required
                              placeholder="Tell us more about your query, suggestion or collaboration idea..."
                              class="w-full bg-slate-50 border @error('message') border-rose-300 ring-2 ring-rose-100 @else border-slate-200 @enderror rounded-xl p-4 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button & Guarantee -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full font-extrabold text-sm shadow-md hover:shadow-lg transition">
                        <span>Send Message</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                    </button>

                    <span class="inline-flex items-center gap-1.5 text-xs text-slate-500">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Your information is safe with us. We never share your data.
                    </span>
                </div>
            </form>
        </div>

        <!-- Right: Our Office Card & Map -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-200/90 shadow-sm space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900 tracking-tight">Our Office</h2>
                        <p class="text-xs text-slate-500">We'd be happy to welcome you at our office during working hours.</p>
                    </div>
                </div>

                <!-- Office Photo Card matching Mockup -->
                <div class="rounded-2xl overflow-hidden border border-slate-200 relative aspect-[16/9]">
                    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1200&auto=format&fit=crop" 
                         alt="Hope Foundation Headquarters" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent flex items-end p-4">
                        <span class="text-white text-xs font-bold drop-shadow-md">
                            {{ setting('ngo_name', 'Hope Foundation') }} Administrative Office
                        </span>
                    </div>
                </div>

                <!-- Coordinates List -->
                <ul class="space-y-4 text-xs sm:text-sm text-slate-600">
                    <!-- Address -->
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Office Address</span>
                            <span>{{ setting('contact_address', '123 NGO Street, Assi Ghat Road, Varanasi, Uttar Pradesh - 221001, India') }}</span>
                        </div>
                    </li>

                    <!-- Phone -->
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Calling Helpline</span>
                            <a href="tel:{{ setting('contact_phone', '+91 9876543210') }}" class="text-emerald-700 font-bold hover:underline">
                                {{ setting('contact_phone', '+91 9876543210') }}
                            </a>
                        </div>
                    </li>

                    <!-- Email -->
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Official Email</span>
                            <a href="mailto:{{ setting('contact_email', 'contact@hopefoundation.org') }}" class="text-emerald-700 font-bold hover:underline">
                                {{ setting('contact_email', 'contact@hopefoundation.org') }}
                            </a>
                        </div>
                    </li>

                    <!-- Working Hours -->
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Visiting & Working Hours</span>
                            <span>{{ setting('working_hours', 'Mon - Sat: 9:00 AM - 6:00 PM, Sunday: Closed') }}</span>
                        </div>
                    </li>
                </ul>

                <!-- Social Icons Bar -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Follow Our Work:</span>
                    <div class="flex items-center gap-3">
                        <a href="https://facebook.com" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition" aria-label="Facebook">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg>
                        </a>
                        <a href="https://instagram.com" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition" aria-label="Instagram">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="https://linkedin.com" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition" aria-label="LinkedIn">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                        <a href="https://x.com" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition" aria-label="X / Twitter">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Google Map Embed matching Mockup -->
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-inner h-48 bg-slate-100 relative">
                    <iframe 
                        src="{{ setting('google_map_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3607.4589999999997!2d82.9995!3d25.2819!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjXCsDE2JzU0LjgiTiA4MsKwNTknNTguMiJF!5e0!3m2!1sen!2sin!4v1620000000000') }}"
                        class="w-full h-full border-0" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Hope Foundation Office Location">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Bottom Grid: FAQs + Other Ways to Connect -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start" x-data="{ activeFaq: null }">

        <!-- Left: Frequently Asked Questions -->
        <div class="lg:col-span-6 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                        ?
                    </div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Frequently Asked Questions</h3>
                </div>
            </div>

            <div class="space-y-3">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-2xs">
                    <button type="button" 
                            @click="activeFaq = (activeFaq === 1 ? null : 1)"
                            class="w-full px-5 py-4 text-left flex items-center justify-between gap-4 font-bold text-sm text-slate-900 hover:text-emerald-700 transition">
                        <span>How can I reach your team?</span>
                        <span class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center shrink-0 text-slate-500 font-black text-xs">
                            <span x-show="activeFaq !== 1">+</span>
                            <span x-show="activeFaq === 1">−</span>
                        </span>
                    </button>
                    <div x-show="activeFaq === 1" x-collapse class="px-5 pb-4 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        You can reach us via our helpline phone, official email, or by submitting the contact inquiry form above. Our support team typically responds within 24 business hours.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-2xs">
                    <button type="button" 
                            @click="activeFaq = (activeFaq === 2 ? null : 2)"
                            class="w-full px-5 py-4 text-left flex items-center justify-between gap-4 font-bold text-sm text-slate-900 hover:text-emerald-700 transition">
                        <span>Can I visit your office?</span>
                        <span class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center shrink-0 text-slate-500 font-black text-xs">
                            <span x-show="activeFaq !== 2">+</span>
                            <span x-show="activeFaq === 2">−</span>
                        </span>
                    </button>
                    <div x-show="activeFaq === 2" x-collapse class="px-5 pb-4 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Yes, our administrative office in Varanasi is open Monday through Saturday from 9:00 AM to 6:00 PM. We welcome donors, partners, and community volunteers to visit and inspect our transparent records.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-2xs">
                    <button type="button" 
                            @click="activeFaq = (activeFaq === 3 ? null : 3)"
                            class="w-full px-5 py-4 text-left flex items-center justify-between gap-4 font-bold text-sm text-slate-900 hover:text-emerald-700 transition">
                        <span>How can I partner with your NGO?</span>
                        <span class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center shrink-0 text-slate-500 font-black text-xs">
                            <span x-show="activeFaq !== 3">+</span>
                            <span x-show="activeFaq === 3">−</span>
                        </span>
                    </button>
                    <div x-show="activeFaq === 3" x-collapse class="px-5 pb-4 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        We actively collaborate with corporate CSR initiatives, educational institutions, and philanthropic trusts. Choose "Corporate CSR Partnership Opportunity" in the inquiry form and our partnership lead will connect with you.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-2xs">
                    <button type="button" 
                            @click="activeFaq = (activeFaq === 4 ? null : 4)"
                            class="w-full px-5 py-4 text-left flex items-center justify-between gap-4 font-bold text-sm text-slate-900 hover:text-emerald-700 transition">
                        <span>Do you have internship or volunteering opportunities?</span>
                        <span class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center shrink-0 text-slate-500 font-black text-xs">
                            <span x-show="activeFaq !== 4">+</span>
                            <span x-show="activeFaq === 4">−</span>
                        </span>
                    </button>
                    <div x-show="activeFaq === 4" x-collapse class="px-5 pb-4 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Yes! We have ongoing opportunities in teaching, emergency medical camp logistics, photography, digital storytelling, and relief drives. You can register anytime via our volunteer portal.
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Other Ways to Connect -->
        <div class="lg:col-span-6 space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                    ✦
                </div>
                <h3 class="text-xl font-black text-slate-900 tracking-tight">Other Ways to Connect</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Become a Volunteer -->
                <a href="{{ route('volunteers.create') }}" 
                   class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs hover:shadow-md hover:border-emerald-300 transition flex items-start gap-4 group">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">Become a Volunteer</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Join our ground changemaker force</p>
                    </div>
                </a>

                <!-- Partner With Us -->
                <a href="mailto:{{ setting('contact_email', 'contact@hopefoundation.org') }}?subject=CSR%20Partnership%20Proposal" 
                   class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs hover:shadow-md hover:border-emerald-300 transition flex items-start gap-4 group">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M11 4a2 2 0 1 1 4 0v4a2 2 0 1 1-4 0V4Z"/><path d="M18 9v1a6 6 0 0 1-12 0V9"/><path d="M5 19h14M12 15v4"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">Partner With Us</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Corporate CSR & foundations</p>
                    </div>
                </a>

                <!-- Media & Press -->
                <a href="mailto:{{ setting('contact_email', 'contact@hopefoundation.org') }}?subject=Media%20and%20Press%20Query" 
                   class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs hover:shadow-md hover:border-emerald-300 transition flex items-start gap-4 group">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">Media & Press</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Media coverage & interviews</p>
                    </div>
                </a>

                <!-- General Enquiries -->
                <a href="tel:{{ setting('contact_phone', '+91 9876543210') }}" 
                   class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs hover:shadow-md hover:border-emerald-300 transition flex items-start gap-4 group">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">General Enquiries</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Direct telephone helpline</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
