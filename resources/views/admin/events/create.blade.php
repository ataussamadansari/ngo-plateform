@extends('layouts.base')

@section('title', 'Schedule New Event')

@section('content')
<div class="bg-slate-900 text-white py-8 border-b border-slate-800">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 mb-2">
            <a href="{{ route('admin.events.index') }}" class="text-xs font-semibold text-slate-400 hover:text-white transition flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to Events
            </a>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
            Schedule New Community Event
        </h1>
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

    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-xs space-y-8">
        @csrf

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
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           placeholder="e.g. Mega Free Health Camp & Medicine Distribution"
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label for="slug" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Custom URL Slug <span class="text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                           placeholder="e.g. mega-health-camp-2026"
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="upcoming" {{ old('status', 'upcoming') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="ongoing" {{ old('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div>
                    <label for="event_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Event Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" required
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="start_time" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Start Time <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="start_time" id="start_time" value="{{ old('start_time', '09:00') }}" required
                                   class="w-full text-sm rounded-xl border border-slate-300 px-3 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="end_time" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                End Time <span class="text-slate-400 font-normal">(Opt)</span>
                            </label>
                            <input type="time" name="end_time" id="end_time" value="{{ old('end_time', '17:00') }}"
                                   class="w-full text-sm rounded-xl border border-slate-300 px-3 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Event Description & Program Details <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="5" required
                              placeholder="Describe the initiative, key activities, what volunteers need to bring, and beneficiary impact..."
                              class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('description') }}</textarea>
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
                    <input type="text" name="location_name" id="location_name" value="{{ old('location_name') }}" required
                           placeholder="e.g. Community Center Hall, Assi Ghat"
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label for="max_participants" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Max Participant Capacity <span class="text-slate-400 font-normal">(Leave blank if unlimited)</span>
                    </label>
                    <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants') }}" min="1"
                           placeholder="e.g. 50"
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="sm:col-span-2">
                    <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Complete Venue Address <span class="text-red-500">*</span>
                    </label>
                    <textarea name="address" id="address" rows="2" required
                              placeholder="Full postal address with landmarks..."
                              class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('address') }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label for="google_map_link" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Google Map Link / Directions URL <span class="text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <input type="url" name="google_map_link" id="google_map_link" value="{{ old('google_map_link') }}"
                           placeholder="https://maps.google.com/..."
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>
        </div>

        <!-- Banner Image -->
        <div>
            <h2 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">
                3. Event Banner Image
            </h2>

            <div class="p-6 rounded-2xl border border-dashed border-slate-300 bg-slate-50 text-center">
                <label for="banner_image" class="cursor-pointer block">
                    <svg class="w-10 h-10 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-xs font-bold text-slate-800 block">Upload Event Banner Image <span class="text-red-500">*</span></span>
                    <span class="text-[11px] text-slate-500 block mt-1">Recommended: 16:9 ratio, JPEG / PNG / WebP, max 2MB</span>
                    <input type="file" name="banner_image" id="banner_image" required accept="image/jpeg,image/png,image/webp"
                           class="mt-3 text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300">
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.events.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white font-bold text-xs hover:opacity-95 shadow-md transition">
                Publish Event
            </button>
        </div>
    </form>
</div>
@endsection
