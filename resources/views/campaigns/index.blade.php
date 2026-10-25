@extends('layouts.base')

@section('title', 'Active Causes & Relief Campaigns')

@section('content')
<div class="bg-gradient-to-b from-slate-100 to-white py-12 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 mb-4 shadow-xs">
            Direct Impact &bull; Verified Relief
        </span>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">
            Support Our Active Causes
        </h1>
        <p class="mt-3 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto">
            Choose a cause close to your heart. 100% of your manual donation is verified against bank records and directed straight to ground operations.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if($urgentCampaigns->isNotEmpty() && !request()->filled('category') && !request()->filled('search') && $status === 'active')
        <!-- Urgent Causes Callout Strip -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                    <h2 class="text-xl font-bold text-slate-900">Urgent Appeals Requiring Immediate Support</h2>
                </div>
                <span class="text-xs font-semibold text-red-600 bg-red-50 px-2.5 py-1 rounded-full border border-red-200">Time-Critical</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-{{ min(count($urgentCampaigns), 3) }} gap-6">
                @foreach($urgentCampaigns as $urgent)
                    <div class="bg-red-50/50 rounded-2xl border border-red-200 p-5 flex flex-col justify-between shadow-xs hover:shadow-md transition">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="text-xs font-bold uppercase tracking-wider text-red-700 bg-red-100 px-2 py-0.5 rounded-md">
                                    {{ $urgent->category?->name ?? 'General Appeal' }}
                                </span>
                                <span class="text-xs font-bold text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.316.492-.593 1.096-.867 1.748-.65 1.545-1.156 3.14-1.748 4.706a1 1 0 01-.19.333L4.85 13.5a1 1 0 00.75 1.5h8.8a1 1 0 00.75-1.5l-2.469-3.682a1 1 0 01-.19-.333c-.592-1.566-1.098-3.161-1.748-4.706-.274-.652-.551-1.256-.867-1.748a3.1 3.1 0 00-.481-.478z" clip-rule="evenodd"/></svg>
                                    Urgent
                                </span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2 leading-snug hover:text-emerald-700 transition">
                                <a href="{{ route('campaigns.show', $urgent->slug) }}">{{ $urgent->title }}</a>
                            </h3>
                            <p class="text-xs text-slate-600 line-clamp-2 mb-4 leading-relaxed">
                                {{ $urgent->short_description }}
                            </p>
                        </div>

                        <div>
                            <div class="w-full bg-slate-200 rounded-full h-2 mb-2 overflow-hidden">
                                <div class="bg-red-500 h-2 rounded-full" style="width: {{ $urgent->progress_percentage }}%"></div>
                            </div>
                            <div class="flex justify-between items-center text-xs mb-4">
                                <span class="font-bold text-slate-900">₹{{ number_format($urgent->raised_amount, 2) }}</span>
                                <span class="text-slate-500">Goal: ₹{{ number_format($urgent->goal_amount, 2) }} ({{ $urgent->progress_percentage }}%)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('donate.index', ['campaign_id' => $urgent->id]) }}" class="flex-1 text-center py-2 px-3 rounded-xl bg-red-600 text-white font-bold text-xs hover:bg-red-700 transition shadow-xs">
                                    Donate Now
                                </a>
                                <a href="{{ route('campaigns.show', $urgent->slug) }}" class="py-2 px-3 rounded-xl bg-white border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition">
                                    Read Story
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Filter, Search & Status Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-6 mb-8 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-100">
            <!-- Status Tabs -->
            <div class="flex items-center gap-2">
                <a href="{{ route('campaigns.index', array_merge(request()->except('status', 'page'), ['status' => 'active'])) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ $status !== 'completed' ? 'bg-primary text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Active Causes
                </a>
                <a href="{{ route('campaigns.index', array_merge(request()->except('status', 'page'), ['status' => 'completed'])) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ $status === 'completed' ? 'bg-primary text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Completed Causes
                </a>
            </div>

            <!-- Search Form -->
            <form action="{{ route('campaigns.index') }}" method="GET" class="flex items-center gap-2 max-w-md w-full">
                @if(request()->filled('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                @if(request()->filled('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="relative flex-grow">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search causes by title or keyword..."
                           class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 pl-9 pr-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs sm:text-sm font-semibold hover:bg-slate-800 transition">
                    Search
                </button>
                @if(request()->filled('search') || request()->filled('category'))
                    <a href="{{ route('campaigns.index') }}" class="p-2 text-slate-400 hover:text-slate-600 text-xs">Clear</a>
                @endif
            </form>
        </div>

        <!-- Category Filter Pills -->
        <div class="flex items-center gap-2 overflow-x-auto pt-4 scrollbar-none">
            <a href="{{ route('campaigns.index', request()->except('category', 'page')) }}"
               class="px-3 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition {{ !request()->filled('category') ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                All Categories
            </a>
            @foreach($categories as $category)
                <a href="{{ route('campaigns.index', array_merge(request()->except('category', 'page'), ['category' => $category->slug])) }}"
                   class="px-3 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition flex items-center gap-1.5 {{ request('category') == $category->slug ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    <span>{{ $category->name }}</span>
                    <span class="text-[10px] opacity-75 px-1 rounded-full {{ request('category') == $category->slug ? 'bg-slate-800' : 'bg-slate-200' }}">
                        {{ $category->campaigns_count }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Campaigns 3-Column Grid -->
    @if($campaigns->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($campaigns as $campaign)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Thumbnail Header -->
                        <div class="relative aspect-video bg-slate-100 overflow-hidden">
                            @if($campaign->thumbnail_image)
                                <img src="{{ asset('storage/' . $campaign->thumbnail_image) }}"
                                     alt="{{ $campaign->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-600 to-slate-800 text-white font-bold text-xl">
                                    {{ setting('ngo_name', 'NGO') }}
                                </div>
                            @endif

                            <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                                @if($campaign->category)
                                    <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-white/95 backdrop-blur-xs text-slate-800 shadow-xs">
                                        {{ $campaign->category->name }}
                                    </span>
                                @endif
                                @if($campaign->is_urgent)
                                    <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-red-600 text-white shadow-xs">
                                        Urgent
                                    </span>
                                @endif
                            </div>

                            @if($campaign->status === 'completed')
                                <div class="absolute inset-0 bg-slate-900/60 flex items-center justify-center">
                                    <span class="px-4 py-2 rounded-xl bg-emerald-600 text-white font-black text-sm tracking-wide shadow-md uppercase">
                                        Goal Fully Achieved
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Content Body -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition leading-snug line-clamp-2 mb-2">
                                <a href="{{ route('campaigns.show', $campaign->slug) }}">
                                    {{ $campaign->title }}
                                </a>
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 line-clamp-3 mb-6 leading-relaxed">
                                {{ $campaign->short_description }}
                            </p>
                        </div>
                    </div>

                    <!-- Financial Status & CTA Footer -->
                    <div class="px-6 pb-6 pt-2 border-t border-slate-100 bg-slate-50/50">
                        <div class="mb-3">
                            <div class="flex justify-between items-baseline text-xs mb-1.5">
                                <span class="font-bold text-slate-900 text-sm">
                                    ₹{{ number_format($campaign->raised_amount, 2) }}
                                </span>
                                <span class="text-slate-500">
                                    of ₹{{ number_format($campaign->goal_amount, 2) }}
                                </span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                <div class="bg-primary h-2 rounded-full transition-all duration-500" style="width: {{ $campaign->progress_percentage }}%"></div>
                            </div>
                            <div class="flex justify-between items-center text-[11px] text-slate-500 mt-1">
                                <span>{{ $campaign->progress_percentage }}% Funded</span>
                                <span>{{ max(0, (float)$campaign->goal_amount - (float)$campaign->raised_amount) > 0 ? '₹' . number_format($campaign->remaining_amount, 2) . ' needed' : 'Funded' }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            @if($campaign->status === 'active')
                                <a href="{{ route('donate.index', ['campaign_id' => $campaign->id]) }}"
                                   class="flex-1 text-center py-2.5 px-4 rounded-xl text-xs font-bold text-white bg-primary hover:opacity-95 shadow-xs transition">
                                    Donate Now
                                </a>
                            @endif
                            <a href="{{ route('campaigns.show', $campaign->slug) }}"
                               class="{{ $campaign->status === 'active' ? 'py-2.5 px-4 bg-white border border-slate-300 text-slate-700 font-semibold' : 'w-full py-2.5 px-4 bg-slate-900 text-white font-bold' }} text-center rounded-xl text-xs hover:bg-slate-50 transition">
                                View Details & Story
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $campaigns->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-2xl border border-slate-200 p-8 shadow-xs">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">No campaigns found</h3>
            <p class="text-xs sm:text-sm text-slate-500 max-w-sm mx-auto mb-6">
                We couldn't find any fundraising campaigns matching your selected criteria.
            </p>
            <a href="{{ route('campaigns.index') }}" class="px-5 py-2.5 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition">
                Reset All Filters
            </a>
        </div>
    @endif

</div>
@endsection
