@extends('layouts.base')

@section('title', 'Fund Distribution Ledger - Admin')

@section('content')
<!-- Admin Top Bar -->
<div class="bg-slate-900 text-white border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-emerald-400 mb-1">
                    <span>Admin Operations</span>
                    <span>&bull;</span>
                    <span>Transparency Ledger</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Fund Distribution Ledger</h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-1">Record verified expenditures, upload invoices and impact photos, and manage public accountability.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.donations.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-700 hover:border-slate-600 bg-slate-800 text-slate-300 font-semibold text-xs transition">
                    &larr; Donation Verification
                </a>
                <a href="{{ route('admin.distributions.create') }}" class="px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Record Disbursement
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
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Funds Distributed</span>
            <span class="text-2xl font-black text-slate-900 mt-1 block">₹{{ number_format($totalDistributed, 2) }}</span>
            <span class="text-[11px] text-slate-500 mt-0.5 block">Verified on-ground disbursements</span>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Disbursement Events</span>
            <span class="text-2xl font-black text-emerald-600 mt-1 block">{{ $totalBeneficiaries }}</span>
            <span class="text-[11px] text-slate-500 mt-0.5 block">Recorded relief operations</span>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Causes Supported</span>
            <span class="text-2xl font-black text-blue-600 mt-1 block">{{ $campaignsSupported }}</span>
            <span class="text-[11px] text-slate-500 mt-0.5 block">Active campaigns funded</span>
        </div>
    </div>

    <!-- Filters Strip -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-2xs flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
            <a href="{{ route('admin.distributions.index', array_merge(request()->except('visibility', 'page'), ['visibility' => ''])) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request('visibility') ? 'bg-slate-900 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                All ({{ $totalBeneficiaries }})
            </a>
            <a href="{{ route('admin.distributions.index', array_merge(request()->except('visibility', 'page'), ['visibility' => 'public'])) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('visibility') === 'public' ? 'bg-emerald-600 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Public Ledger
            </a>
            <a href="{{ route('admin.distributions.index', array_merge(request()->except('visibility', 'page'), ['visibility' => 'internal'])) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('visibility') === 'internal' ? 'bg-amber-600 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Internal Only
            </a>
        </div>

        <form action="{{ route('admin.distributions.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full md:w-auto">
            @if(request('visibility'))
                <input type="hidden" name="visibility" value="{{ request('visibility') }}">
            @endif

            <select name="campaign_id" onchange="this.form.submit()" class="w-full sm:w-auto px-3 py-2 text-xs font-medium rounded-xl border border-slate-300 focus:border-emerald-600 bg-white text-slate-700">
                <option value="">All Campaigns</option>
                @foreach($campaigns as $campaign)
                    <option value="{{ $campaign->id }}" {{ request('campaign_id') == $campaign->id ? 'selected' : '' }}>
                        {{ $campaign->title }}
                    </option>
                @endforeach
            </select>

            <div class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title, beneficiary..." class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-300 focus:border-emerald-600 text-slate-800">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                Filter
            </button>
            @if(request()->hasAny(['campaign_id', 'search', 'visibility']))
                <a href="{{ route('admin.distributions.index') }}" class="w-full sm:w-auto px-3 py-2 text-xs text-slate-400 hover:text-slate-600 text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">Date</th>
                        <th class="py-3.5 px-4">Expenditure Purpose</th>
                        <th class="py-3.5 px-4">Beneficiary</th>
                        <th class="py-3.5 px-4">Amount</th>
                        <th class="py-3.5 px-4">Campaign</th>
                        <th class="py-3.5 px-4">Proof Documents</th>
                        <th class="py-3.5 px-4">Visibility</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($distributions as $dist)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="font-medium text-slate-900 block">{{ $dist->distribution_date->format('d M Y') }}</span>
                                <span class="text-[10px] text-slate-400 block">{{ $dist->distribution_date->diffForHumans() }}</span>
                            </td>

                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900 block max-w-xs truncate">{{ $dist->title }}</span>
                                @if($dist->payment_reference)
                                    <span class="text-[10px] font-mono text-slate-400 block mt-0.5">Ref: {{ $dist->payment_reference }}</span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4">
                                <span class="font-semibold text-slate-800 block">{{ $dist->beneficiary_name }}</span>
                            </td>

                            <td class="py-3.5 px-4 whitespace-nowrap font-bold text-sm text-emerald-600">
                                ₹{{ number_format($dist->amount_spent, 2) }}
                            </td>

                            <td class="py-3.5 px-4 text-xs font-medium text-slate-700">
                                @if($dist->campaign)
                                    <span class="inline-block px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[11px]">
                                        {{ $dist->campaign->title }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">General Relief</span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    @if($dist->proof_bill_image)
                                        <a href="/storage/{{ $dist->proof_bill_image }}" target="_blank" class="px-2 py-1 rounded-md bg-blue-50 text-blue-700 hover:bg-blue-100 font-semibold text-[10px] flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Bill
                                        </a>
                                    @endif

                                    @if(!empty($dist->impact_photos))
                                        <span class="px-2 py-1 rounded-md bg-purple-50 text-purple-700 font-semibold text-[10px] flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ count($dist->impact_photos) }} Photos
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($dist->is_public)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        Public
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                        Internal
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <button type="button" onclick="openInspectionModal({{ json_encode($dist) }})" class="px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs shadow-2xs transition">
                                    Inspect
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                No fund distributions recorded yet matching current filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($distributions->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $distributions->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Inspection Modal -->
<div id="inspect-modal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto space-y-6">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider block">Disbursement Inspection</span>
                <h3 id="modal-title" class="text-xl font-bold text-slate-900 mt-0.5"></h3>
                <p id="modal-meta" class="text-xs text-slate-500 mt-1"></p>
            </div>
            <button type="button" onclick="closeInspectionModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600">
                &times;
            </button>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 text-xs">
            <div>
                <span class="text-slate-400 block font-medium">Beneficiary</span>
                <span id="modal-beneficiary" class="font-bold text-slate-800 block mt-0.5"></span>
            </div>
            <div>
                <span class="text-slate-400 block font-medium">Amount Spent</span>
                <span id="modal-amount" class="font-bold text-emerald-600 block mt-0.5"></span>
            </div>
            <div>
                <span class="text-slate-400 block font-medium">Payment Reference</span>
                <span id="modal-ref" class="font-mono font-semibold text-slate-800 block mt-0.5"></span>
            </div>
        </div>

        <div>
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Description / Utilization Report</h4>
            <div id="modal-description" class="p-4 rounded-xl bg-slate-50 text-xs text-slate-700 leading-relaxed border border-slate-100"></div>
        </div>

        <!-- Bill Proof Section -->
        <div>
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Bill / Invoice Document</h4>
            <div id="modal-bill-container" class="p-3 bg-slate-100 rounded-xl border border-slate-200 text-center">
                <a id="modal-bill-link" href="#" target="_blank" class="text-xs font-bold text-emerald-600 underline">
                    Open Official Bill Document &rarr;
                </a>
            </div>
        </div>

        <!-- Impact Photos Gallery -->
        <div>
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">On-Ground Impact Photos</h4>
            <div id="modal-photos-grid" class="grid grid-cols-3 gap-2"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openInspectionModal(dist) {
        document.getElementById('modal-title').textContent = dist.title;
        document.getElementById('modal-meta').textContent = 'Disbursed on ' + new Date(dist.distribution_date).toLocaleDateString() + (dist.campaign ? ' • Linked to ' + dist.campaign.title : ' • General Relief');
        document.getElementById('modal-beneficiary').textContent = dist.beneficiary_name;
        document.getElementById('modal-amount').textContent = '₹' + Number(dist.amount_spent).toLocaleString('en-IN', {minimumFractionDigits: 2});
        document.getElementById('modal-ref').textContent = dist.payment_reference || 'N/A';
        document.getElementById('modal-description').textContent = dist.description;

        const billContainer = document.getElementById('modal-bill-container');
        const billLink = document.getElementById('modal-bill-link');
        if (dist.proof_bill_image) {
            billContainer.classList.remove('hidden');
            billLink.href = '/storage/' + dist.proof_bill_image;
        } else {
            billContainer.classList.add('hidden');
        }

        const photosGrid = document.getElementById('modal-photos-grid');
        photosGrid.innerHTML = '';
        if (dist.impact_photos && dist.impact_photos.length > 0) {
            dist.impact_photos.forEach(photo => {
                const a = document.createElement('a');
                a.href = '/storage/' + photo;
                a.target = '_blank';
                a.innerHTML = `<img src="/storage/${photo}" class="w-full h-24 object-cover rounded-xl border border-slate-200 hover:opacity-90 transition">`;
                photosGrid.appendChild(a);
            });
        } else {
            photosGrid.innerHTML = '<span class="text-xs text-slate-400 col-span-3">No impact photos uploaded for this entry.</span>';
        }

        document.getElementById('inspect-modal').classList.remove('hidden');
    }

    function closeInspectionModal() {
        document.getElementById('inspect-modal').classList.add('hidden');
    }
</script>
@endpush
@endsection
