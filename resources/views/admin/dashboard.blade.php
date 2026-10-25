@extends('layouts.base')

@section('title', 'Executive Back-Office Dashboard - ' . setting('ngo_name', 'NGO Platform'))

@section('content')
<!-- Header Banner -->
<div class="bg-slate-900 text-white py-8 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-emerald-400 mb-1">
                <span>Executive Command Center</span>
                <span>&bull;</span>
                <span>Financial & Operations Overview</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Executive Back-Office Dashboard</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Live verified balance, pending reconciliation queues, and volunteer deployments.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.donations.index') }}" class="px-4 py-2.5 rounded-xl font-bold text-xs text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Verify Donations ({{ $pendingDonationsCount }})
            </a>
            <a href="{{ route('admin.distributions.create') }}" class="px-4 py-2.5 rounded-xl font-bold text-xs text-slate-200 bg-slate-800 hover:bg-slate-700 border border-slate-700 transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Record Distribution
            </a>
            <a href="{{ route('admin.campaigns.create') }}" class="px-4 py-2.5 rounded-xl font-bold text-xs text-slate-200 bg-slate-800 hover:bg-slate-700 border border-slate-700 transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                New Campaign
            </a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Top Executive Financial Metric Cards Strip (ADM-01) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Verified Funds Raised -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Verified Funds</span>
                <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                ₹{{ number_format($totalVerifiedFunds, 2) }}
            </div>
            <p class="text-[11px] text-emerald-600 font-semibold mt-1">100% bank reconciled donations</p>
        </div>

        <!-- Distributed Funds -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Distributed</span>
                <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-blue-700 tracking-tight">
                ₹{{ number_format($totalDistributedFunds, 2) }}
            </div>
            <p class="text-[11px] text-slate-500 mt-1">Backed by public bills & proof</p>
        </div>

        <!-- Net Available Balance -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Available Treasury</span>
                <span class="w-8 h-8 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-purple-800 tracking-tight">
                ₹{{ number_format($availableBalance, 2) }}
            </div>
            <p class="text-[11px] text-purple-600 font-semibold mt-1">Net non-profit unallocated funds</p>
        </div>

        <!-- Pending Verifications & Applications Queue -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pending Action Queue</span>
                <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-amber-600 tracking-tight">
                {{ $pendingDonationsCount + $pendingVolunteersCount }}
            </div>
            <p class="text-[11px] text-amber-700 font-medium mt-1">
                {{ $pendingDonationsCount }} donations &bull; {{ $pendingVolunteersCount }} volunteers
            </p>
        </div>

    </div>

    <!-- Quick-Action Triage Queues (ADM-02) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Left: Quick Donation Verification Queue -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <h2 class="text-base font-bold text-slate-900">Donation Verification Triage</h2>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Quickly reconcile donor UTRs against bank statements.</p>
                    </div>
                    <a href="{{ route('admin.donations.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 transition">
                        View All ({{ $pendingDonationsCount }}) &rarr;
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($pendingDonations as $donation)
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                            <div class="flex items-start gap-3.5">
                                @if($donation->payment_screenshot)
                                    <a href="{{ asset('storage/' . $donation->payment_screenshot) }}" target="_blank" class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden border border-slate-200 shrink-0 block hover:opacity-80 transition">
                                        <img src="{{ asset('storage/' . $donation->payment_screenshot) }}" alt="Proof" class="w-full h-full object-cover">
                                    </a>
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-xs shrink-0">
                                        No img
                                    </div>
                                @endif
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-slate-900">{{ $donation->donor_name }}</span>
                                        <span class="text-xs font-mono font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md">
                                            ₹{{ number_format($donation->amount, 2) }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5 space-x-2">
                                        <span class="font-mono text-slate-700">UTR: {{ $donation->utr_number }}</span>
                                        <span>&bull;</span>
                                        <span>{{ strtoupper($donation->payment_mode) }}</span>
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $donation->campaign ? $donation->campaign->title : 'General Relief Fund' }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <form action="{{ route('admin.donations.approve', $donation->id) }}" method="POST" onsubmit="return confirm('Approve donation of ₹{{ number_format($donation->amount, 2) }} and issue 80G receipt?')">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition shadow-xs">
                                        Approve
                                    </button>
                                </form>

                                <form action="{{ route('admin.donations.reject', $donation->id) }}" method="POST" onsubmit="return confirm('Reject this donation proof?')">
                                    @csrf
                                    <input type="hidden" name="remarks" value="Unmatched transaction record on bank statement.">
                                    <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 transition">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500 text-xs">
                            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            All donor payments are verified! Verification queue is clear.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="p-4 bg-slate-50 border-t border-slate-100 text-right">
                <a href="{{ route('admin.donations.create') }}" class="text-xs font-bold text-slate-700 hover:text-slate-900 transition">
                    + Record Offline Direct Cash Donation
                </a>
            </div>
        </div>

        <!-- Right: Quick Volunteer Screening Queue -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                            <h2 class="text-base font-bold text-slate-900">Volunteer Candidate Screening</h2>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Review incoming volunteer applications & generate badges.</p>
                    </div>
                    <a href="{{ route('admin.volunteers.index') }}" class="text-xs font-bold text-blue-700 hover:text-blue-800 transition">
                        View All ({{ $pendingVolunteersCount }}) &rarr;
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($pendingVolunteers as $volunteer)
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                            <div class="flex items-start gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0">
                                    {{ substr($volunteer->full_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900">{{ $volunteer->full_name }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5 space-x-2">
                                        <span>{{ $volunteer->city }}</span>
                                        <span>&bull;</span>
                                        <span class="text-blue-600 font-medium">{{ $volunteer->availability }}</span>
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        Skills: {{ is_array($volunteer->skills) ? implode(', ', $volunteer->skills) : $volunteer->skills }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <form action="{{ route('admin.volunteers.approve', $volunteer->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 transition shadow-xs">
                                        Approve & Issue Code
                                    </button>
                                </form>

                                <form action="{{ route('admin.volunteers.reject', $volunteer->id) }}" method="POST" onsubmit="return confirm('Reject this volunteer application?')">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 transition">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500 text-xs">
                            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            No pending volunteer applications awaiting review.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="p-4 bg-slate-50 border-t border-slate-100 text-right">
                <a href="{{ route('admin.volunteers.index') }}" class="text-xs font-bold text-slate-700 hover:text-slate-900 transition">
                    Manage Full Volunteer Roster &rarr;
                </a>
            </div>
        </div>

    </div>

    <!-- Active Relief Campaigns & Ground Disbursements -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Active Relief Campaigns Progress -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Active Cause Campaigns</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Fundraising targets & real-time verified collections.</p>
                </div>
                <a href="{{ route('admin.campaigns.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 transition">
                    Manage Campaigns &rarr;
                </a>
            </div>

            <div class="space-y-4">
                @forelse($activeCampaigns as $campaign)
                    @php
                        $percentage = $campaign->goal_amount > 0 ? min(100, round(($campaign->raised_amount / $campaign->goal_amount) * 100)) : 0;
                    @endphp
                    <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-100">
                        <div class="flex items-center justify-between gap-4 mb-2">
                            <span class="text-xs font-bold text-slate-800 line-clamp-1">{{ $campaign->title }}</span>
                            <span class="text-xs font-bold font-mono text-emerald-700 shrink-0">{{ $percentage }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden mb-2">
                            <div class="bg-emerald-600 h-2 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="flex items-center justify-between text-[11px] text-slate-500 font-medium">
                            <span>Raised: <strong class="text-slate-700 font-mono">₹{{ number_format($campaign->raised_amount, 2) }}</strong></span>
                            <span>Target: <strong class="text-slate-700 font-mono">₹{{ number_format($campaign->goal_amount, 2) }}</strong></span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-6">No active relief campaigns.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Ground Disbursements Feed -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Recent Ground Disbursements</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Latest expenditure entries with bills & receipts.</p>
                </div>
                <a href="{{ route('admin.distributions.index') }}" class="text-xs font-bold text-blue-700 hover:text-blue-800 transition">
                    View Full Ledger &rarr;
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentDistributions as $dist)
                    <div class="p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100 flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs font-bold text-slate-900">{{ $dist->beneficiary_name }}</div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                {{ $dist->campaign ? $dist->campaign->title : 'General Allocation' }} &bull; {{ $dist->distribution_date?->format('d M Y') }}
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="text-xs font-bold font-mono text-blue-700">₹{{ number_format($dist->amount_spent, 2) }}</div>
                            <span class="inline-block text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md mt-0.5">
                                {{ $dist->proof_bill_image ? 'Receipt Verified' : 'Direct Relief' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-6">No disbursements logged yet.</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Administrative Operations Hub Directory -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
        <h3 class="text-base font-bold text-slate-900 mb-4">Administrative Management Directory</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <a href="{{ route('admin.donations.index') }}" class="p-4 rounded-2xl border border-slate-200 hover:border-emerald-500 hover:shadow-xs transition text-center group">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 group-hover:bg-emerald-600 group-hover:text-white flex items-center justify-center mx-auto mb-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 block">Donations</span>
                <span class="text-[10px] text-slate-400">Reconcile UTR</span>
            </a>

            <a href="{{ route('admin.distributions.index') }}" class="p-4 rounded-2xl border border-slate-200 hover:border-blue-500 hover:shadow-xs transition text-center group">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 group-hover:bg-blue-600 group-hover:text-white flex items-center justify-center mx-auto mb-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 block">Ledger</span>
                <span class="text-[10px] text-slate-400">Ground Bills</span>
            </a>

            <a href="{{ route('admin.campaigns.index') }}" class="p-4 rounded-2xl border border-slate-200 hover:border-purple-500 hover:shadow-xs transition text-center group">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 group-hover:bg-purple-600 group-hover:text-white flex items-center justify-center mx-auto mb-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 block">Campaigns</span>
                <span class="text-[10px] text-slate-400">Cause Goals</span>
            </a>

            <a href="{{ route('admin.volunteers.index') }}" class="p-4 rounded-2xl border border-slate-200 hover:border-amber-500 hover:shadow-xs transition text-center group">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 group-hover:bg-amber-600 group-hover:text-white flex items-center justify-center mx-auto mb-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 block">Volunteers</span>
                <span class="text-[10px] text-slate-400">Rosters & Codes</span>
            </a>

            <a href="{{ route('admin.events.index') }}" class="p-4 rounded-2xl border border-slate-200 hover:border-rose-500 hover:shadow-xs transition text-center group">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-700 group-hover:bg-rose-600 group-hover:text-white flex items-center justify-center mx-auto mb-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 block">Events</span>
                <span class="text-[10px] text-slate-400">Drives & Camps</span>
            </a>

            <a href="{{ route('admin.inquiries.index') }}" class="p-4 rounded-2xl border border-slate-200 hover:border-indigo-500 hover:shadow-xs transition text-center group">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 group-hover:bg-indigo-600 group-hover:text-white flex items-center justify-center mx-auto mb-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 block">Inquiries</span>
                <span class="text-[10px] text-slate-400">Visitor Contact</span>
            </a>
        </div>
    </div>

</div>
@endsection
