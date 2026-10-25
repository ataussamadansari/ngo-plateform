@extends('layouts.base')

@section('title', 'Volunteer Application Submitted')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 text-center">
    <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    </div>

    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 mb-3">
        Application Received
    </span>

    <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mb-3">
        Thank You for Stepping Up!
    </h1>

    @if(session('applicant_name'))
        <p class="text-base font-semibold text-emerald-800 mb-2">
            Dear {{ session('applicant_name') }},
        </p>
    @endif

    <p class="text-slate-600 text-sm sm:text-base leading-relaxed max-w-lg mx-auto mb-8">
        Your volunteer application has been received successfully. Our community coordinators review every application carefully within <strong>24 to 48 hours</strong>.
    </p>

    <div class="bg-white rounded-3xl border border-slate-200 p-6 text-left shadow-xs mb-8 space-y-4">
        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-700">What Happens Next?</h3>
        <div class="flex items-start gap-3 text-xs text-slate-600">
            <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center shrink-0">1</span>
            <span>Our screening committee reviews your profile and matches your skills with upcoming drives.</span>
        </div>
        <div class="flex items-start gap-3 text-xs text-slate-600">
            <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center shrink-0">2</span>
            <span>Upon approval, you will receive your official <strong>Volunteer ID Code</strong> and orientation details via WhatsApp or email.</span>
        </div>
        <div class="flex items-start gap-3 text-xs text-slate-600">
            <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center shrink-0">3</span>
            <span>You will be invited to participate in community relief operations, health camps, and volunteer drives.</span>
        </div>
    </div>

    <div class="flex justify-center gap-4">
        <a href="{{ url('/') }}" class="px-6 py-3 rounded-xl font-bold text-sm text-white bg-primary hover:opacity-95 shadow-xs transition">
            Return to Home
        </a>
        <a href="{{ route('campaigns.index') }}" class="px-6 py-3 rounded-xl font-semibold text-sm text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
            Explore Active Causes
        </a>
    </div>
</div>
@endsection
