@extends('layouts.base')

@section('title', 'Visitor Inquiries Management')

@section('content')
<div class="bg-slate-900 text-white py-8 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-emerald-400 block mb-1">Administrative Center</span>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Visitor Inquiries & Contact Messages
                </h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('contact.index') }}" target="_blank" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition border border-slate-700 flex items-center gap-1.5">
                    View Public Form
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center justify-between">
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </span>
        </div>
    @endif

    <!-- Metrics Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
            <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Inquiries</span>
            <span class="text-2xl font-black text-slate-900">{{ number_format($totalCount) }}</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
            <span class="block text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Pending Review</span>
            <span class="text-2xl font-black text-amber-600">{{ number_format($pendingCount) }}</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
            <span class="block text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Reviewed (Read)</span>
            <span class="text-2xl font-black text-blue-600">{{ number_format($readCount) }}</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
            <span class="block text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Replied</span>
            <span class="text-2xl font-black text-emerald-600">{{ number_format($repliedCount) }}</span>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs">
        
        <!-- Filter Bar -->
        <div class="p-5 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            
            <!-- Status Tabs -->
            <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-2xl w-fit">
                <a href="{{ route('admin.inquiries.index', ['status' => 'all', 'search' => $search]) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $status === 'all' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                    All ({{ $totalCount }})
                </a>
                <a href="{{ route('admin.inquiries.index', ['status' => 'pending', 'search' => $search]) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $status === 'pending' ? 'bg-amber-500 text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                    Pending ({{ $pendingCount }})
                </a>
                <a href="{{ route('admin.inquiries.index', ['status' => 'read', 'search' => $search]) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $status === 'read' ? 'bg-blue-600 text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                    Read ({{ $readCount }})
                </a>
                <a href="{{ route('admin.inquiries.index', ['status' => 'replied', 'search' => $search]) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $status === 'replied' ? 'bg-emerald-600 text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                    Replied ({{ $repliedCount }})
                </a>
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('admin.inquiries.index') }}" class="flex items-center gap-2">
                <input type="hidden" name="status" value="{{ $status }}">
                <div class="relative w-64">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search sender, subject..."
                           class="w-full text-xs rounded-xl border border-slate-300 pl-8 pr-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <button type="submit" class="px-3 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                    Filter
                </button>
                @if($search)
                    <a href="{{ route('admin.inquiries.index', ['status' => $status]) }}" class="px-2.5 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200 transition">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-200 font-bold">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6">Sender Details</th>
                        <th class="py-3.5 px-4">Subject & Message</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4">Received Date</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($inquiries as $inquiry)
                        <tr class="hover:bg-slate-50/75 transition">
                            <td class="py-4 px-4 sm:px-6">
                                <div class="font-bold text-slate-900 text-sm">{{ $inquiry->name }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">
                                    <a href="mailto:{{ $inquiry->email }}" class="text-primary hover:underline">{{ $inquiry->email }}</a>
                                </div>
                                @if($inquiry->phone)
                                    <div class="text-[11px] font-mono text-slate-400 mt-0.5">{{ $inquiry->phone }}</div>
                                @endif
                            </td>
                            <td class="py-4 px-4 max-w-md">
                                <div class="font-bold text-slate-800 text-xs mb-1">{{ $inquiry->subject }}</div>
                                <p class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">{{ $inquiry->message }}</p>
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if($inquiry->status === 'replied')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Replied
                                    </span>
                                @elseif($inquiry->status === 'read')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800">
                                        Read
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-slate-500 whitespace-nowrap">
                                {{ $inquiry->created_at->format('d M Y, h:i A') }}
                            </td>
                            <td class="py-4 px-4 sm:px-6 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1 bg-slate-100 p-1 rounded-xl">
                                    @if($inquiry->status !== 'replied')
                                        <form action="{{ route('admin.inquiries.update', $inquiry->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="replied">
                                            <button type="submit" title="Mark Replied" class="px-2.5 py-1 rounded-lg text-[11px] font-bold text-slate-700 hover:bg-emerald-600 hover:text-white transition">
                                                Mark Replied
                                            </button>
                                        </form>
                                    @endif

                                    @if($inquiry->status === 'pending')
                                        <form action="{{ route('admin.inquiries.update', $inquiry->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="read">
                                            <button type="submit" title="Mark Read" class="px-2.5 py-1 rounded-lg text-[11px] font-bold text-slate-700 hover:bg-blue-600 hover:text-white transition">
                                                Mark Read
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete Inquiry" class="p-1 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-500">
                                <p class="font-bold text-slate-700 text-sm">No visitor inquiries found</p>
                                <p class="text-xs text-slate-400 mt-1">Inquiries submitted via the Contact Us page will appear here.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inquiries->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
