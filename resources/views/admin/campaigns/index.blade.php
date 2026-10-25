@extends('layouts.base')

@section('title', 'Manage Campaigns - Admin')

@section('content')
<!-- Header -->
<div class="bg-slate-900 text-white border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-emerald-400 mb-1">
                    <span>Admin Operations</span>
                    <span>&bull;</span>
                    <span>Fundraising Causes</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Campaigns Management</h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-1">Create and manage fundraising campaigns, track live funding progress, and manage cause stories.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-700 hover:border-slate-600 bg-slate-800 text-slate-300 font-semibold text-xs transition">
                    Manage Categories
                </a>
                <a href="{{ route('admin.campaigns.create') }}" class="px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Campaign
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Campaigns</span>
            <span class="text-2xl font-black text-slate-900 mt-1 block">{{ $totalCampaigns }}</span>
            <span class="text-[11px] text-slate-500 mt-0.5 block">Across all categories</span>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Active Causes</span>
            <span class="text-2xl font-black text-emerald-600 mt-1 block">{{ $activeCampaigns }}</span>
            <span class="text-[11px] text-slate-500 mt-0.5 block">Currently accepting donations</span>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Target Goal</span>
            <span class="text-2xl font-black text-blue-600 mt-1 block">₹{{ number_format($totalGoal, 2) }}</span>
            <span class="text-[11px] text-slate-500 mt-0.5 block">Cumulative fundraising targets</span>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Verified Collections</span>
            <span class="text-2xl font-black text-purple-600 mt-1 block">₹{{ number_format($totalRaised, 2) }}</span>
            <span class="text-[11px] text-slate-500 mt-0.5 block">100% verified donor receipts</span>
        </div>
    </div>

    <!-- Filters & Tabs Strip -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-2xs flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-1.5 w-full md:w-auto">
            @php
                $statusTabs = [
                    '' => 'All',
                    'active' => 'Active',
                    'draft' => 'Drafts',
                    'completed' => 'Completed',
                    'paused' => 'Paused',
                ];
            @endphp

            @foreach($statusTabs as $val => $label)
                <a href="{{ route('admin.campaigns.index', array_merge(request()->except('status', 'page'), ['status' => $val])) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status', '') === $val ? 'bg-slate-900 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <form action="{{ route('admin.campaigns.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full md:w-auto">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <select name="category_id" onchange="this.form.submit()" class="w-full sm:w-44 px-3 py-2 text-xs font-medium rounded-xl border border-slate-300 focus:border-emerald-600 bg-white text-slate-700">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <div class="relative w-full sm:w-60">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title..." class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-300 focus:border-emerald-600 text-slate-800">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                Filter
            </button>
        </form>
    </div>

    <!-- Campaigns List Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">Campaign</th>
                        <th class="py-3.5 px-4">Category</th>
                        <th class="py-3.5 px-4">Funding Progress</th>
                        <th class="py-3.5 px-4">Raised / Goal</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($campaigns as $camp)
                        <tr class="hover:bg-slate-50/70 transition">
                            <!-- Campaign Info -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="/storage/{{ $camp->thumbnail_image }}" alt="{{ $camp->title }}" class="w-12 h-12 object-cover rounded-xl border border-slate-200 shrink-0">
                                    <div class="max-w-xs">
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <span class="font-bold text-slate-900 block truncate">{{ $camp->title }}</span>
                                            @if($camp->is_urgent)
                                                <span class="px-1.5 py-0.2 rounded bg-rose-100 text-rose-700 font-bold text-[9px] uppercase tracking-wider">Urgent</span>
                                            @endif
                                            @if($camp->is_featured)
                                                <span class="px-1.5 py-0.2 rounded bg-amber-100 text-amber-700 font-bold text-[9px] uppercase tracking-wider">Featured</span>
                                            @endif
                                        </div>
                                        <span class="text-[11px] text-slate-400 font-mono block mt-0.5">/{{ $camp->slug }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700">
                                    {{ $camp->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>

                            <!-- Progress Bar -->
                            <td class="py-3.5 px-4 min-w-[140px]">
                                <div class="flex items-center justify-between text-[11px] font-bold text-slate-700 mb-1">
                                    <span>{{ $camp->progress_percentage }}%</span>
                                    <span class="text-slate-400 font-normal">{{ $camp->verified_donations_count }} donors</span>
                                </div>
                                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $camp->progress_percentage }}%;"></div>
                                </div>
                            </td>

                            <!-- Raised / Goal -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="font-bold text-emerald-600 block">₹{{ number_format($camp->raised_amount, 2) }}</span>
                                <span class="text-[11px] text-slate-400 block">of ₹{{ number_format($camp->goal_amount, 2) }}</span>
                            </td>

                            <!-- Status Dropdown Toggle -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <form action="{{ route('admin.campaigns.status', $camp) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-[11px] font-bold px-2.5 py-1 rounded-full border border-slate-200 cursor-pointer {{ $camp->status === 'active' ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : ($camp->status === 'draft' ? 'bg-slate-100 text-slate-700' : ($camp->status === 'completed' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700')) }}">
                                        <option value="active" {{ $camp->status === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="draft" {{ $camp->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="completed" {{ $camp->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="paused" {{ $camp->status === 'paused' ? 'selected' : '' }}>Paused</option>
                                    </select>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.campaigns.edit', $camp) }}" class="px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs shadow-2xs transition">
                                        Edit
                                    </a>
                                    @if(Route::has('campaigns.show'))
                                        <a href="{{ route('campaigns.show', $camp->slug) }}" target="_blank" class="px-2.5 py-1.5 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs transition">
                                            View &rarr;
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                No campaigns found matching the current filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($campaigns->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
