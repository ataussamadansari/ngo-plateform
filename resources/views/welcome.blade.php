@extends('layouts.base')

@section('title', setting('hero_title', 'Empowering Communities'))

@section('content')
<div class="py-12 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 mb-4">
            {{ setting('ngo_tagline', 'Direct Relief & Transparency') }}
        </span>
        <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight max-w-3xl mx-auto">
            {{ setting('hero_title', 'Direct Impact, Zero Deductions, 100% Transparency') }}
        </h1>
        <p class="mt-4 text-lg text-slate-600 max-w-2xl mx-auto">
            {{ setting('hero_subtitle', 'Every rupee you donate is verified against bank records and tracked directly to ground relief with proof bills.') }}
        </p>
        <div class="mt-8 flex justify-center gap-4">
            <a href="#causes" class="px-6 py-3 rounded-xl font-semibold text-white shadow-md transition-all hover:opacity-95 bg-primary">
                {{ setting('hero_cta_text', 'Donate Now') }}
            </a>
            <a href="#about" class="px-6 py-3 rounded-xl font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-all">
                Learn More
            </a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- White-Label Theme Demonstration Swatches -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-200 mb-12">
        <h2 class="text-xl font-bold text-slate-900 mb-2">White-Label Engine Status</h2>
        <p class="text-sm text-slate-500 mb-6">Active dynamic theme colors and configuration loaded from site_settings cache.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Organization</span>
                <span class="text-base font-bold text-slate-900">{{ setting('ngo_name') }}</span>
                <span class="text-xs text-slate-500 block mt-1">Reg: {{ setting('ngo_reg_number') }}</span>
            </div>

            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Receipt Prefix</span>
                <span class="text-base font-bold text-slate-900">{{ setting('receipt_prefix') }}</span>
                <span class="text-xs text-emerald-600 font-medium block mt-1">80G Reg: {{ setting('80g_reg_number') }}</span>
            </div>

            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg shadow-inner bg-primary"></div>
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Primary Color</span>
                    <span class="text-sm font-mono font-bold text-slate-800">{{ setting('primary_color') }}</span>
                </div>
            </div>

            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg shadow-inner bg-secondary"></div>
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Secondary Color</span>
                    <span class="text-sm font-mono font-bold text-slate-800">{{ setting('secondary_color') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Causes -->
    <div id="causes">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Cause Categories</h2>
                <p class="text-sm text-slate-500">Transparent initiatives funded directly by donors</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
            @forelse(\App\Models\CauseCategory::active()->get() as $category)
                <div class="bg-white rounded-xl p-5 border border-slate-200 text-center shadow-xs hover:border-slate-300 transition-all">
                    <div class="w-10 h-10 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-semibold mb-3">
                        {{ substr($category->name, 0, 1) }}
                    </div>
                    <h3 class="text-sm font-bold text-slate-800">{{ $category->name }}</h3>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-slate-500 bg-white rounded-xl border border-slate-200">
                    No active cause categories yet.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
