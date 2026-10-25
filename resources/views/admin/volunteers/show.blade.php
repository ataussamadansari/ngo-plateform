@extends('layouts.base')

@section('title', 'Volunteer Dossier - ' . $volunteer->full_name)

@section('content')
<div class="bg-slate-900 text-white py-8 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 mb-3">
            <a href="{{ route('admin.volunteers.index') }}" class="text-xs font-semibold text-slate-400 hover:text-white transition flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to Volunteer Roster
            </a>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                @if($volunteer->profile_photo)
                    <img src="{{ asset('storage/' . $volunteer->profile_photo) }}"
                         alt="{{ $volunteer->full_name }}"
                         class="w-16 h-16 rounded-2xl object-cover border-2 border-slate-700 shadow-sm shrink-0">
                @else
                    <div class="w-16 h-16 rounded-2xl bg-slate-800 text-white font-black flex items-center justify-center text-xl shrink-0 border border-slate-700">
                        {{ substr($volunteer->full_name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight flex items-center gap-2">
                        <span>{{ $volunteer->full_name }}</span>
                    </h1>
                    <div class="flex flex-wrap items-center gap-2 mt-1">
                        @if($volunteer->volunteer_code)
                            <span class="font-mono text-xs font-bold text-emerald-300 bg-emerald-950/80 px-2 py-0.5 rounded border border-emerald-700">
                                {{ $volunteer->volunteer_code }}
                            </span>
                        @endif
                        <span class="text-xs text-slate-400">{{ $volunteer->city }} &bull; Applied {{ $volunteer->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <div>
                @if($volunteer->status === 'approved')
                    <span class="px-4 py-2 rounded-xl text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Approved Volunteer
                    </span>
                @elseif($volunteer->status === 'pending')
                    <span class="px-4 py-2 rounded-xl text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/40 inline-flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        Pending Review
                    </span>
                @elseif($volunteer->status === 'rejected')
                    <span class="px-4 py-2 rounded-xl text-xs font-bold bg-red-500/20 text-red-300 border border-red-500/40">
                        Application Rejected
                    </span>
                @endif
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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Left Column: Dossier Details & Documents (8 cols) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Personal Profile Card -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-xs">
                <h2 class="text-base font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Contact & Background Information
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Email Address</span>
                        <a href="mailto:{{ $volunteer->email }}" class="font-semibold text-slate-900 hover:text-emerald-700 transition">{{ $volunteer->email }}</a>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Phone Number</span>
                        <a href="tel:{{ $volunteer->phone }}" class="font-mono font-bold text-slate-900 hover:text-emerald-700 transition">{{ $volunteer->phone }}</a>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">City / District</span>
                        <span class="font-semibold text-slate-900">{{ $volunteer->city }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Occupation</span>
                        <span class="font-semibold text-slate-900">{{ $volunteer->occupation ?? 'Not specified' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 sm:col-span-2">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Address</span>
                        <span class="text-slate-800">{{ $volunteer->address ?? 'Not provided' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 sm:col-span-2">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Availability</span>
                        <span class="font-bold text-emerald-800 capitalize">{{ $volunteer->availability }}</span>
                    </div>
                </div>
            </div>

            <!-- Skills & Domain Areas -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-xs">
                <h2 class="text-base font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    Skills & Service Preferences
                </h2>

                <div class="flex flex-wrap gap-2">
                    @if(is_array($volunteer->skills) && count($volunteer->skills) > 0)
                        @foreach($volunteer->skills as $skill)
                            <span class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold">
                                {{ $skill }}
                            </span>
                        @endforeach
                    @else
                        <span class="text-xs text-slate-500 italic">No specific skills indicated.</span>
                    @endif
                </div>
            </div>

            <!-- ID Proof Verification -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-xs">
                <h2 class="text-base font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                    Uploaded Identification Proof
                </h2>

                @if($volunteer->id_proof_path)
                    @php
                        $isPdf = str_ends_with(strtolower($volunteer->id_proof_path), '.pdf');
                    @endphp

                    @if($isPdf)
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs shrink-0">
                                    PDF
                                </div>
                                <div>
                                    <span class="font-bold text-xs text-slate-900 block">ID Proof Document (PDF)</span>
                                    <span class="text-[11px] text-slate-500">Official government ID document uploaded</span>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $volunteer->id_proof_path) }}" target="_blank"
                               class="px-4 py-2 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition">
                                Open Document
                            </a>
                        </div>
                    @else
                        <div class="rounded-2xl overflow-hidden border border-slate-200 max-w-md bg-slate-50">
                            <img src="{{ asset('storage/' . $volunteer->id_proof_path) }}"
                                 alt="ID Proof Document"
                                 class="w-full h-auto object-contain">
                            <div class="p-3 bg-white border-t border-slate-100 text-right">
                                <a href="{{ asset('storage/' . $volunteer->id_proof_path) }}" target="_blank"
                                   class="text-xs font-bold text-emerald-700 hover:underline">
                                    View Full Size &rarr;
                                </a>
                            </div>
                        </div>
                    @endif
                @else
                    <p class="text-xs text-slate-500 italic">No government ID proof was uploaded with this application.</p>
                @endif
            </div>

            <!-- Event Participation History -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-xs">
                <h2 class="text-base font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Event Participation History ({{ $volunteer->eventRegistrations->count() }})
                </h2>

                @if($volunteer->eventRegistrations->count() > 0)
                    <div class="space-y-3">
                        @foreach($volunteer->eventRegistrations as $reg)
                            <div class="p-3 rounded-xl border border-slate-100 bg-slate-50/60 flex items-center justify-between text-xs">
                                <div>
                                    <span class="font-bold text-slate-800">{{ $reg->event?->title ?? 'Event' }}</span>
                                    <span class="text-[11px] text-slate-500 block">{{ $reg->event?->event_date?->format('d M, Y') }} &bull; Role: {{ $reg->role_assigned }}</span>
                                </div>
                                <span class="px-2 py-0.5 rounded font-bold capitalize text-[10px] {{ $reg->attendance_status === 'attended' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                                    {{ $reg->attendance_status }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-500 italic">No events joined yet.</p>
                @endif
            </div>

        </div>

        <!-- Right Column: Status & Screening Actions (4 cols) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Screening Actions Card -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Screening Decision</h3>

                @if($volunteer->status === 'pending')
                    <p class="text-xs text-slate-600 leading-relaxed mb-6">
                        Approving this application will generate an official unique ID code (<code class="bg-slate-100 px-1 py-0.5 rounded text-slate-800">{{ setting('volunteer_prefix', 'KSF') }}-VOL-{{ date('Y') }}-XXXX</code>) and activate this volunteer on the roster.
                    </p>

                    <div class="space-y-3">
                        <form action="{{ route('admin.volunteers.approve', $volunteer->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full py-3.5 px-4 rounded-2xl bg-emerald-600 text-white font-black text-sm hover:bg-emerald-700 shadow-md hover:shadow-lg transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                Approve & Issue Volunteer Code
                            </button>
                        </form>

                        <form action="{{ route('admin.volunteers.reject', $volunteer->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full py-3 px-4 rounded-2xl bg-slate-100 text-red-600 font-bold text-xs hover:bg-red-50 transition"
                                    onclick="return confirm('Are you sure you want to reject this volunteer application?')">
                                Reject Application
                            </button>
                        </form>
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 mb-4">
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-500">Current Status:</span>
                            <span class="font-bold text-slate-900 capitalize">{{ $volunteer->status }}</span>
                        </div>
                        @if($volunteer->volunteer_code)
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-500">ID Code:</span>
                                <span class="font-mono font-bold text-emerald-700">{{ $volunteer->volunteer_code }}</span>
                            </div>
                        @endif
                        @if($volunteer->joined_at)
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-500">Joined Date:</span>
                                <span class="font-semibold text-slate-900">{{ $volunteer->joined_at->format('d M, Y') }}</span>
                            </div>
                        @endif
                    </div>

                    @if($volunteer->status === 'rejected')
                        <form action="{{ route('admin.volunteers.approve', $volunteer->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 transition">
                                Re-approve Application
                            </button>
                        </form>
                    @endif
                @endif
            </div>

            <!-- Organization Badge Preview -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-3xl p-6 shadow-md border border-slate-700">
                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-400 block mb-2">Volunteer Credential</span>
                <span class="text-base font-bold text-white block">{{ setting('ngo_name', 'NGO Platform') }}</span>
                <span class="text-[11px] text-slate-400 block mb-4">Community Volunteer Member</span>

                <div class="pt-3 border-t border-slate-700/80 flex items-center justify-between text-xs">
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase block">ID Code</span>
                        <span class="font-mono font-bold text-emerald-300">{{ $volunteer->volunteer_code ?? 'PENDING' }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-slate-400 uppercase block">Status</span>
                        <span class="font-bold uppercase text-[11px] {{ $volunteer->status === 'approved' ? 'text-emerald-400' : 'text-amber-400' }}">
                            {{ $volunteer->status }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
