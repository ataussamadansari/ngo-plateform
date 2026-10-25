@extends('layouts.base')

@section('title', 'Administrative Sign-In - ' . setting('ngo_name', 'NGO Platform'))

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        
        <!-- Brand Header -->
        <div class="text-center">
            @if(setting('ngo_logo'))
                <img class="mx-auto h-16 w-auto object-contain mb-4" src="{{ asset('storage/' . setting('ngo_logo')) }}" alt="{{ setting('ngo_name') }}">
            @else
                <div class="mx-auto w-14 h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-black text-2xl shadow-md mb-4">
                    {{ substr(setting('ngo_name', 'KSF'), 0, 1) }}
                </div>
            @endif

            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-slate-100 text-slate-700 mb-2">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Back-Office Portal
            </span>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Administrative Sign-In</h1>
            <p class="text-xs text-slate-500 mt-1">{{ setting('ngo_name', 'NGO Platform') }} management & verification gateway</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 sm:p-10">

            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Official Staff Email
                    </label>
                    <div class="relative">
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="email"
                               placeholder="admin@ksf.org"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm text-slate-900 transition outline-none">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Password
                        </label>
                    </div>
                    <div class="relative">
                        <input type="password"
                               id="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm text-slate-900 transition outline-none">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox"
                               name="remember"
                               id="remember"
                               class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                        <span class="text-xs text-slate-600 font-medium">Keep me signed in on this computer</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="w-full py-3.5 px-6 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Sign In to Back-Office
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition inline-flex items-center gap-1.5">
                    &larr; Return to Public NGO Portal
                </a>
            </div>
        </div>

        <div class="text-center text-[11px] text-slate-400">
            Authorized personnel only. All access attempts and verification decisions are securely audited.
        </div>

    </div>
</div>
@endsection
