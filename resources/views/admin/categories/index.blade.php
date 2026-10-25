@extends('layouts.base')

@section('title', 'Manage Cause Categories - Admin')

@section('content')
<!-- Header -->
<div class="bg-slate-900 text-white border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-emerald-400 mb-1">
                    <span>Admin Operations</span>
                    <span>&bull;</span>
                    <span>Cause Taxonomy</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Cause Categories</h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-1">Manage charitable cause categories (Medical, Education, Disaster Relief, etc.)</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.campaigns.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-700 hover:border-slate-600 bg-slate-800 text-slate-300 font-semibold text-xs transition">
                    &larr; Campaigns Directory
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

    @if(session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Left Column: Add Category Form -->
        <div class="lg:col-span-4 bg-white rounded-3xl p-6 border border-slate-200 shadow-2xs space-y-4">
            <h3 class="text-base font-bold text-slate-900 pb-2 border-b border-slate-100">Add New Category</h3>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Category Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Women Empowerment" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs text-slate-900">
                    @error('name') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Slug (URL identifier)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" placeholder="Auto-generated if left empty" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs font-mono text-slate-900">
                    @error('slug') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Icon Identifier</label>
                    <input type="text" name="icon" value="{{ old('icon') }}" placeholder="e.g. heart, academic-cap, shield-check" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs text-slate-900">
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked class="h-4 w-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                    <label for="is_active" class="text-xs font-bold text-slate-700">Active (Visible for campaigns)</label>
                </div>

                <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-sm transition">
                    Create Category
                </button>
            </form>
        </div>

        <!-- Right Column: Categories List -->
        <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200 shadow-2xs overflow-hidden">
            <div class="p-6 pb-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">Existing Cause Categories ({{ $categories->count() }})</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-[11px] font-bold text-slate-700 uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4">Category Name</th>
                            <th class="py-3.5 px-4">Slug</th>
                            <th class="py-3.5 px-4">Campaigns</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($categories as $category)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                    {{ $category->name }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-[11px] text-slate-500">
                                    {{ $category->slug }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700">
                                        {{ $category->campaigns_count }} causes
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($category->is_active)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                            Disabled
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    @if($category->campaigns_count === 0)
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete category {{ $category->name }}?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-rose-600 hover:text-rose-800 transition">
                                                Delete
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[11px] text-slate-400 italic">In use</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    No cause categories found. Create your first category above.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
