@extends('layouts.base')

@section('title', 'Create Campaign - Admin')

@section('content')
<!-- Header -->
<div class="bg-slate-900 text-white border-b border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center justify-between">
            <div>
                <nav class="flex items-center text-xs text-slate-400 gap-2 mb-1">
                    <a href="{{ route('admin.campaigns.index') }}" class="hover:text-white transition">Campaigns</a>
                    <span>&rsaquo;</span>
                    <span class="text-emerald-400 font-medium">Create Cause</span>
                </nav>
                <h1 class="text-2xl font-extrabold text-white">Create Fundraising Campaign</h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-0.5">Publish a verified charitable cause with goal budget, narrative story, and photo gallery.</p>
            </div>
            <a href="{{ route('admin.campaigns.index') }}" class="px-4 py-2 rounded-xl border border-slate-700 hover:border-slate-600 bg-slate-800 text-slate-300 font-semibold text-xs transition">
                &larr; Cancel
            </a>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm">

        <!-- Error Summary -->
        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                <span class="font-bold block text-sm">Please correct the following errors:</span>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Campaign Particulars -->
            <div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                    1. Campaign Particulars
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Campaign Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Emergency Pediatric Heart Surgery Fund" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs text-slate-900">
                        @error('title') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Category *</label>
                        <select name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs text-slate-900 bg-white">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Custom URL Slug (Optional)</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" placeholder="Auto-generated from title if blank" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs font-mono text-slate-900">
                        @error('slug') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Target Fundraising Goal (INR) *</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2.5 text-xs font-bold text-slate-400">₹</span>
                            <input type="number" step="0.01" min="100" name="goal_amount" value="{{ old('goal_amount') }}" required placeholder="100000.00" class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs font-bold text-slate-900">
                        </div>
                        @error('goal_amount') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status *</label>
                        <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs font-semibold text-slate-900 bg-white">
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active (Accepting Donations)</option>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Hidden from Public)</option>
                            <option value="paused" {{ old('status') === 'paused' ? 'selected' : '' }}>Paused</option>
                            <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Start Date *</label>
                        <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">End Date (Optional Target Deadline)</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs text-slate-900">
                    </div>
                </div>
            </div>

            <!-- Section 2: Narrative Story & Descriptions -->
            <div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                    2. Story & Narrative Content
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Short Description (Excerpt for cause cards) *</label>
                        <textarea name="short_description" rows="2" maxlength="500" required placeholder="A brief 1-2 sentence overview shown on campaign cards..." class="w-full p-3 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs text-slate-900">{{ old('short_description') }}</textarea>
                        @error('short_description') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Full Detailed Story & Impact Narrative *</label>
                        <textarea name="full_story" rows="8" required placeholder="Describe the background, why this cause matters, who the beneficiaries are, cost breakdown, hospital/school details, and how donors will receive updates..." class="w-full p-4 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs text-slate-900 leading-relaxed">{{ old('full_story') }}</textarea>
                        @error('full_story') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 3: Visuals & Media -->
            <div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                    3. Visual Assets & Media
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="p-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50">
                        <label class="block text-xs font-bold text-slate-800 mb-1">Main Banner Thumbnail Image *</label>
                        <p class="text-[11px] text-slate-500 mb-3">High-quality landscape cover photo. Max 2MB (JPG, PNG, WEBP).</p>
                        <input type="file" name="thumbnail_image" required accept=".jpg,.jpeg,.png,.webp" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                        @error('thumbnail_image') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="p-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50">
                        <label class="block text-xs font-bold text-slate-800 mb-1">Story Gallery Photos (Up to 8)</label>
                        <p class="text-[11px] text-slate-500 mb-3">Additional photos showing on-ground condition. Max 2MB each.</p>
                        <input type="file" name="gallery_images[]" multiple accept=".jpg,.jpeg,.png,.webp" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer">
                        @error('gallery_images') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                        @error('gallery_images.*') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 4: Badges & Promotion -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-wrap gap-6">
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_urgent" id="is_urgent" value="1" {{ old('is_urgent') ? 'checked' : '' }} class="h-4 w-4 text-rose-600 rounded border-slate-300 focus:ring-rose-500">
                    <label for="is_urgent" class="text-xs font-bold text-slate-800">
                        Mark as Urgent Cause (Highlights in red badge & urgent banner)
                    </label>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="h-4 w-4 text-amber-600 rounded border-slate-300 focus:ring-amber-500">
                    <label for="is_featured" class="text-xs font-bold text-slate-800">
                        Feature on Home Page Hero
                    </label>
                </div>
            </div>

            <!-- Submit Strip -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.campaigns.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-xs text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Create Campaign
                </button>
            </div>
        </form>

    </div>

</div>
@endsection
