@extends('layouts.base')

@section('title', 'Volunteer Screening & Roster')

@section('content')
<div class="bg-slate-900 text-white py-8 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        Admin Back-Office
                    </span>
                    <span class="text-xs text-slate-400">Onboarding & Personnel</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Volunteer Screening & Roster
                </h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.donations.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 transition">
                    Donations
                </a>
                <a href="{{ route('admin.campaigns.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 transition">
                    Campaigns
                </a>
                <a href="{{ route('admin.distributions.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 transition">
                    Distributions
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('info'))
        <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
            <span>{{ session('info') }}</span>
        </div>
    @endif

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block mb-1">Total Applicants</span>
            <span class="text-3xl font-black text-slate-900 block">{{ $totalApplicants }}</span>
            <span class="text-xs text-slate-400 mt-1 block">All registrations received</span>
        </div>

        <div class="bg-white rounded-3xl border border-amber-200 bg-amber-50/20 p-6 shadow-xs">
            <span class="text-xs font-bold uppercase tracking-wider text-amber-600 block mb-1">Pending Screening</span>
            <span class="text-3xl font-black text-amber-700 block">{{ $pendingCount }}</span>
            <span class="text-xs text-amber-600/80 mt-1 block">Awaiting admin review</span>
        </div>

        <div class="bg-white rounded-3xl border border-emerald-200 bg-emerald-50/20 p-6 shadow-xs">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block mb-1">Approved Volunteers</span>
            <span class="text-3xl font-black text-emerald-700 block">{{ $approvedCount }}</span>
            <span class="text-xs text-emerald-600/80 mt-1 block">Active on roster with ID code</span>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-3xl border border-slate-200 p-4 sm:p-6 mb-8 shadow-xs">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

            <!-- Status Tabs -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-2 lg:pb-0 scrollbar-none">
                @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'all' => 'All Applicants'] as $val => $label)
                    <a href="{{ route('admin.volunteers.index', array_merge(request()->except('status', 'page'), ['status' => $val])) }}"
                       class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition whitespace-nowrap {{ ($status === $val || (empty($status) && $val === 'all')) ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <!-- Search & City Filter -->
            <form action="{{ route('admin.volunteers.index') }}" method="GET" class="flex flex-wrap sm:flex-nowrap items-center gap-2.5">
                <input type="hidden" name="status" value="{{ $status }}">

                <select name="city" class="text-xs sm:text-sm rounded-xl border border-slate-300 py-2 px-3 text-slate-800 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">All Cities</option>
                    @foreach($cities as $c)
                        <option value="{{ $c }}" {{ request('city') === $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>

                <div class="relative flex-grow">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, phone, code..."
                           class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 pl-9 pr-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs sm:text-sm font-semibold hover:bg-slate-800 transition">
                    Filter
                </button>

                @if(request()->filled('search') || request()->filled('city'))
                    <a href="{{ route('admin.volunteers.index', ['status' => $status]) }}" class="p-2 text-slate-400 hover:text-slate-600 text-xs">Clear</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Volunteers Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        @if($volunteers->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider text-[11px] font-bold">
                            <th class="py-3.5 px-4 sm:px-6">Volunteer Profile</th>
                            <th class="py-3.5 px-4">Contact</th>
                            <th class="py-3.5 px-4">City</th>
                            <th class="py-3.5 px-4">Skills & Availability</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 sm:px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($volunteers as $volunteer)
                            <tr class="hover:bg-slate-50/70 transition">
                                <!-- Profile -->
                                <td class="py-4 px-4 sm:px-6">
                                    <div class="flex items-center gap-3">
                                        @if($volunteer->profile_photo)
                                            <img src="{{ asset('storage/' . $volunteer->profile_photo) }}"
                                                 alt="{{ $volunteer->full_name }}"
                                                 class="w-10 h-10 rounded-full object-cover border border-slate-200 shrink-0">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-700 font-bold flex items-center justify-center shrink-0 text-sm">
                                                {{ substr($volunteer->full_name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.volunteers.show', $volunteer->id) }}" class="font-bold text-slate-900 hover:text-emerald-700 transition block">
                                                {{ $volunteer->full_name }}
                                            </a>
                                            @if($volunteer->volunteer_code)
                                                <span class="font-mono text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200 inline-block mt-0.5">
                                                    {{ $volunteer->volunteer_code }}
                                                </span>
                                            @elseif($volunteer->occupation)
                                                <span class="text-[11px] text-slate-500 block mt-0.5">{{ $volunteer->occupation }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Contact -->
                                <td class="py-4 px-4 text-slate-700">
                                    <div class="font-medium text-xs">{{ $volunteer->email }}</div>
                                    <div class="text-slate-500 text-[11px] font-mono mt-0.5">{{ $volunteer->phone }}</div>
                                </td>

                                <!-- City -->
                                <td class="py-4 px-4 font-semibold text-slate-800 text-xs">
                                    {{ $volunteer->city }}
                                </td>

                                <!-- Skills & Availability -->
                                <td class="py-4 px-4">
                                    <div class="flex flex-wrap gap-1 max-w-xs mb-1">
                                        @if(is_array($volunteer->skills))
                                            @foreach(array_slice($volunteer->skills, 0, 2) as $s)
                                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-[10px] font-medium">
                                                    {{ $s }}
                                                </span>
                                            @endforeach
                                            @if(count($volunteer->skills) > 2)
                                                <span class="px-1.5 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px]">
                                                    +{{ count($volunteer->skills) - 2 }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                    <span class="text-[10px] font-semibold text-slate-400 capitalize block">
                                        {{ $volunteer->availability }}
                                    </span>
                                </td>

                                <!-- Status -->
                                <td class="py-4 px-4">
                                    @if($volunteer->status === 'approved')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Approved
                                        </span>
                                    @elseif($volunteer->status === 'pending')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Pending
                                        </span>
                                    @elseif($volunteer->status === 'rejected')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                            Rejected
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                            {{ ucfirst($volunteer->status) }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-4 sm:px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.volunteers.show', $volunteer->id) }}"
                                           class="px-3 py-1.5 rounded-xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition text-xs">
                                            View Dossier
                                        </a>

                                        @if($volunteer->status === 'pending')
                                            <form action="{{ route('admin.volunteers.approve', $volunteer->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition text-xs shadow-xs"
                                                        onclick="return confirm('Approve volunteer {{ $volunteer->full_name }} and assign official ID code?')">
                                                    Approve
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.volunteers.reject', $volunteer->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="px-2.5 py-1.5 rounded-xl bg-slate-100 text-red-600 hover:bg-red-50 font-semibold transition text-xs"
                                                        onclick="return confirm('Reject application for {{ $volunteer->full_name }}?')">
                                                    Reject
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $volunteers->links() }}
            </div>
        @else
            <div class="text-center py-12 p-6">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800">No volunteer applications found</h3>
                <p class="text-xs text-slate-500 mt-1">Try selecting a different status filter or clearing your search query.</p>
            </div>
        @endif
    </div>

</div>
@endsection
