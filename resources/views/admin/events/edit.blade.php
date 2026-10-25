@extends('layouts.base')

@section('title', 'Edit Event - ' . $event->title)

@section('content')
<div class="bg-slate-900 text-white py-8 border-b border-slate-800">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <a href="{{ route('admin.events.index') }}" class="text-xs font-semibold text-slate-400 hover:text-white transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Back to Events
                    </a>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Edit Event: {{ $event->title }}
                </h1>
            </div>
            <div>
                <a href="{{ route('admin.events.participants', $event->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition border border-slate-700">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Manage Roster
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm">
            <div class="font-bold mb-1">Please fix the following errors:</div>
            <ul class="list-disc pl-6 space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-xs space-y-8">
        @csrf
        @method('PUT')

        <!-- Core Details -->
        <div>
            <h2 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">
                1. Event Overview & Schedule
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Event Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label for="slug" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Custom URL Slug
                    </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $event->slug) }}"
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="upcoming" {{ old('status', $event->status) === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="ongoing" {{ old('status', $event->status) === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ old('status', $event->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $event->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div>
                    <label for="event_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Event Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="event_date" id="event_date" value="{{ old('event_date', $event->event_date?->format('Y-m-d')) }}" required
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="start_time" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Start Time <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '') }}" required
                                   class="w-full text-sm rounded-xl border border-slate-300 px-3 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="end_time" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                End Time <span class="text-slate-400 font-normal">(Opt)</span>
                            </label>
                            <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : '') }}"
                                   class="w-full text-sm rounded-xl border border-slate-300 px-3 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Event Description & Program Details <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="5" required
                              class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('description', $event->description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Venue & Capacity -->
        <div>
            <h2 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">
                2. Venue, Location & Capacity
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="location_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Venue / Building Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="location_name" id="location_name" value="{{ old('location_name', $event->location_name) }}" required
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label for="max_participants" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Max Participant Capacity <span class="text-slate-400 font-normal">(Leave blank if unlimited)</span>
                    </label>
                    <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants', $event->max_participants) }}" min="1"
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="sm:col-span-2">
                    <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Complete Venue Address <span class="text-red-500">*</span>
                    </label>
                    <textarea name="address" id="address" rows="2" required
                              class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('address', $event->address) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label for="google_map_link" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Google Map Link / Directions URL <span class="text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <input type="url" name="google_map_link" id="google_map_link" value="{{ old('google_map_link', $event->google_map_link) }}"
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>
        </div>

        <!-- Banner Image -->
        <div>
            <h2 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">
                3. Event Banner Image
            </h2>

            <div class="flex flex-col sm:flex-row items-center gap-6 p-6 rounded-2xl border border-slate-200 bg-slate-50">
                @if($event->banner_image)
                    <div class="w-full sm:w-48 shrink-0">
                        <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Current Banner</span>
                        <div class="aspect-video w-full rounded-xl overflow-hidden border border-slate-200 bg-slate-200">
                            <img src="{{ asset('storage/' . $event->banner_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif
                <div class="w-full">
                    <label for="banner_image" class="cursor-pointer block text-left">
                        <span class="text-xs font-bold text-slate-800 block">Replace Banner Image <span class="text-slate-400 font-normal">(Optional)</span></span>
                        <span class="text-[11px] text-slate-500 block mt-1">Recommended: 16:9 ratio, JPEG / PNG / WebP, max 2MB. Leave empty to keep existing image.</span>
                        <input type="file" name="banner_image" id="banner_image" accept="image/jpeg,image/png,image/webp"
                               class="mt-3 text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300">
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition flex items-center gap-1">
                View Public Event Page
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.events.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white font-bold text-xs hover:opacity-95 shadow-md transition">
                    Update Event
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
