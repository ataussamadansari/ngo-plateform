@extends('layouts.base')

@section('title', 'Contact Us - Office Address, Directions & Inquiries')

@section('content')
<!-- Header Banner -->
<div class="bg-gradient-to-b from-slate-900 to-slate-800 text-white py-14 sm:py-20 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 mb-4">
            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
            Direct Communication & Ground Office
        </span>
        <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight max-w-3xl mx-auto leading-tight">
            We Are Here to Help & Connect
        </h1>
        <p class="mt-4 text-sm sm:text-base text-slate-300 max-w-2xl mx-auto leading-relaxed">
            Have questions regarding donations, ongoing relief campaigns, CSR partnerships, or volunteering? Reach out to our field office directly.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">

    @if (session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center justify-between">
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-8 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm">
            <div class="font-bold mb-1">Please fix the following:</div>
            <ul class="list-disc pl-6 space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        
        <!-- Left Column: Contact Cards & Office Details -->
        <div class="lg:col-span-5 space-y-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 block mb-1">Head Office</span>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Visit or Reach Out</h2>
                <p class="text-xs text-slate-500 mt-1">Our administrative center is open Monday through Saturday.</p>
            </div>

            <!-- Address Card -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex items-start gap-4">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Postal Address</h3>
                    <p class="text-sm font-bold text-slate-900 mt-1">{{ setting('contact_address', 'B-12, Assi Ghat Road, Varanasi, Uttar Pradesh - 221005') }}</p>
                    <a href="{{ setting('office_google_map_link', 'https://maps.google.com/?q=25.2819,82.9995') }}" target="_blank"
                       class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline mt-2">
                        Get Google Maps Directions &rarr;
                    </a>
                </div>
            </div>

            <!-- Phone Card -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex items-start gap-4">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 mt-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Direct Phone</h3>
                    <p class="text-sm font-bold text-slate-900 mt-1">{{ setting('contact_phone', '+91 9876543210') }}</p>
                    <p class="text-[11px] text-slate-400 mt-1">Available 9:00 AM – 6:00 PM IST</p>
                </div>
            </div>

            <!-- Email Card -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex items-start gap-4">
                <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 mt-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Official Inquiries</h3>
                    <a href="mailto:{{ setting('contact_email', 'contact@kashiseva.org') }}" class="text-sm font-bold text-slate-900 hover:text-primary transition mt-1 block">
                        {{ setting('contact_email', 'contact@kashiseva.org') }}
                    </a>
                    <p class="text-[11px] text-slate-400 mt-1">Official replies within 24 business hours</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Inquiry Submission Form -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-xs">
                <div class="mb-6">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 block mb-1">Direct Message</span>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Send Us an Inquiry</h2>
                    <p class="text-xs text-slate-500 mt-1">Fill out the form below and an administrative officer will contact you.</p>
                </div>

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Your Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   placeholder="e.g. Rahul Sharma"
                                   class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                   placeholder="rahul@example.com"
                                   class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Phone Number <span class="text-slate-400 font-normal">(Optional)</span>
                            </label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                   placeholder="+91 9876543210"
                                   class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label for="subject" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Inquiry Subject <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                   placeholder="e.g. CSR Partnership / 80G Receipt Query"
                                   class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Your Message <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message" id="message" rows="5" required
                                  placeholder="Please provide details about your inquiry or feedback..."
                                  class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('message') }}</textarea>
                    </div>

                    <div>
                        <button type="submit"
                                class="w-full sm:w-auto px-8 py-3 rounded-xl bg-primary text-white font-bold text-xs sm:text-sm hover:opacity-95 shadow-md transition">
                            Submit Inquiry &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
