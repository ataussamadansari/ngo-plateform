@extends('layouts.base')

@section('title', '100% Financial Transparency & Fund Utilization Ledger - ' . setting('ngo_name', 'NGO Platform'))

@section('content')
<!-- Hero Header -->
<div class="relative bg-slate-900 text-white py-12 md:py-16 overflow-hidden">
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#16a34a_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="flex items-center text-xs sm:text-sm text-slate-400 mb-4 gap-2">
            <a href="{{ url('/') }}" class="hover:text-white transition">Home</a>
            <span>&rsaquo;</span>
            <span class="text-emerald-400 font-medium">Transparency Ledger</span>
        </nav>

        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-3">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <span>Zero Leakage &bull; 100% Transparent</span>
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-white mb-3">
                Every Single Rupee Accounted For
            </h1>
            <p class="text-base sm:text-lg text-slate-300 leading-relaxed">
                We believe trust is built on radical financial transparency. Explore our real-time audited ledger with verified bank receipts, supplier invoices, and ground impact photos.
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-10">

    <!-- Financial Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Verified Raised -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-2xs">
            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Verified Raised</span>
            <span class="text-2xl sm:text-3xl font-black text-slate-900 mt-1 block">₹{{ number_format($totalRaised, 2) }}</span>
            <span class="text-[11px] text-slate-500 mt-1 block">100% verified via bank statements</span>
        </div>

        <!-- Card 2: Total Disbursed -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-2xs">
            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Disbursed</span>
            <span class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1 block">₹{{ number_format($totalDistributed, 2) }}</span>
            <span class="text-[11px] text-slate-500 mt-1 block">Backed by vendor invoices & bills</span>
        </div>

        <!-- Card 3: Reserve Balance -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-2xs">
            <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 18h12l3-18H3z"></path></svg>
            </div>
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Net Available Reserve</span>
            <span class="text-2xl sm:text-3xl font-black text-slate-900 mt-1 block">₹{{ number_format($netReserve, 2) }}</span>
            <span class="text-[11px] text-slate-500 mt-1 block">Ready for emergency allocation</span>
        </div>

        <!-- Card 4: Lives Impacted -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-2xs">
            <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Relief Operations</span>
            <span class="text-2xl sm:text-3xl font-black text-purple-600 mt-1 block">{{ $totalBeneficiaries }}</span>
            <span class="text-[11px] text-slate-500 mt-1 block">Direct public disbursements</span>
        </div>
    </div>

    <!-- Utilization Rate Banner -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-2xs">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Direct Fund Utilization Rate</h2>
                <p class="text-xs sm:text-sm text-slate-500">Percentage of verified donor contributions actively deployed to ground causes.</p>
            </div>
            <div class="text-right">
                <span class="text-2xl sm:text-3xl font-black text-emerald-600">{{ $utilizationRate }}%</span>
                <span class="text-[11px] text-slate-400 block font-medium">Direct Program Deployment</span>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="w-full h-3.5 bg-slate-100 rounded-full overflow-hidden p-0.5">
            <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" style="width: {{ $utilizationRate }}%;"></div>
        </div>

        <!-- Category Breakdown Chips -->
        @if($categoryBreakdown->isNotEmpty() || $generalReliefSpent > 0)
            <div class="mt-6 pt-6 border-t border-slate-100">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-3">Utilization Breakdown by Cause</span>
                <div class="flex flex-wrap items-center gap-2.5">
                    @foreach($categoryBreakdown as $cat)
                        <div class="px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-100 text-xs flex items-center gap-2">
                            <span class="font-bold text-slate-800">{{ $cat->name }}</span>
                            <span class="text-emerald-700 font-bold">₹{{ number_format($cat->total_spent, 2) }}</span>
                            <span class="text-[10px] text-slate-400">({{ $cat->item_count }} disbursements)</span>
                        </div>
                    @endforeach

                    @if($generalReliefSpent > 0)
                        <div class="px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-100 text-xs flex items-center gap-2">
                            <span class="font-bold text-slate-800">General Humanitarian Relief</span>
                            <span class="text-emerald-700 font-bold">₹{{ number_format($generalReliefSpent, 2) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Filter & Search Controls -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-2xs">
        <form action="{{ route('transparency.index') }}" method="GET" class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900">Itemized Financial Ledger</h3>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-2 w-full md:w-auto">
                <select name="campaign" onchange="this.form.submit()" class="w-full sm:w-56 px-3.5 py-2.5 text-xs font-medium rounded-xl border border-slate-300 focus:border-emerald-600 bg-white text-slate-700">
                    <option value="">All Supported Causes</option>
                    @foreach($campaigns as $camp)
                        <option value="{{ $camp->id }}" {{ request('campaign') == $camp->id ? 'selected' : '' }}>
                            {{ $camp->title }}
                        </option>
                    @endforeach
                </select>

                <div class="relative w-full sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search purpose, beneficiary..." class="w-full pl-9 pr-3 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-600 text-slate-800">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition">
                    Filter
                </button>

                @if(request()->hasAny(['campaign', 'search']))
                    <a href="{{ route('transparency.index') }}" class="w-full sm:w-auto px-3 py-2 text-xs text-slate-400 hover:text-slate-600 text-center">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Itemized Ledger Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($distributions as $dist)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-2xs hover:shadow-md transition overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Header -->
                    <div class="p-6 pb-4">
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="text-[11px] font-semibold text-slate-400">
                                {{ $dist->distribution_date->format('d M Y') }}
                            </span>

                            @if($dist->campaign)
                                <a href="{{ route('campaigns.transparency', $dist->campaign->slug) }}" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 hover:bg-emerald-100 transition truncate max-w-[160px]">
                                    {{ $dist->campaign->title }} &rarr;
                                </a>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                    General Relief
                                </span>
                            @endif
                        </div>

                        <h3 class="text-base font-bold text-slate-900 line-clamp-2">{{ $dist->title }}</h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-3 leading-relaxed">{{ $dist->description }}</p>
                    </div>

                    <!-- Beneficiary & Amount Strip -->
                    <div class="px-6 py-3 bg-slate-50 border-y border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-semibold text-slate-400 uppercase block">Beneficiary</span>
                            <span class="text-xs font-bold text-slate-800 block truncate max-w-[150px]">{{ $dist->beneficiary_name }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] font-semibold text-slate-400 uppercase block">Disbursed</span>
                            <span class="text-sm font-black text-emerald-600 block">₹{{ number_format($dist->amount_spent, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Footer: Proof Document & Photos Button -->
                <div class="p-6 pt-4 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-1.5">
                        @if($dist->proof_bill_image)
                            <button type="button" onclick="openProofModal({{ json_encode($dist) }})" class="px-3 py-1.5 rounded-xl border border-emerald-200 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold transition flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span>View Bill</span>
                            </button>
                        @endif

                        @if(!empty($dist->impact_photos))
                            <button type="button" onclick="openProofModal({{ json_encode($dist) }})" class="px-3 py-1.5 rounded-xl border border-purple-200 bg-purple-50 hover:bg-purple-100 text-purple-800 text-xs font-bold transition flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ count($dist->impact_photos) }} Photos</span>
                            </button>
                        @endif
                    </div>

                    <button type="button" onclick="openProofModal({{ json_encode($dist) }})" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition">
                        Audit Details &rarr;
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white rounded-3xl p-12 text-center border border-slate-200">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h4 class="text-base font-bold text-slate-900">No Distribution Records Found</h4>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-md mx-auto">There are no disbursements matching your current search or filter. Try clearing filters to view all entries.</p>
                <div class="mt-4">
                    <a href="{{ route('transparency.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                        Reset Filters
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($distributions->hasPages())
        <div class="pt-4 flex justify-center">
            {{ $distributions->links() }}
        </div>
    @endif

</div>

<!-- Interactive Proof Lightbox Modal -->
<div id="proof-modal" class="fixed inset-0 z-50 hidden bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-3xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto space-y-6">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider block">Audited Proof & Ground Record</span>
                <h3 id="modal-title" class="text-xl font-bold text-slate-900 mt-0.5"></h3>
                <p id="modal-meta" class="text-xs text-slate-500 mt-0.5"></p>
            </div>
            <button type="button" onclick="closeProofModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 text-base font-bold">
                &times;
            </button>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 text-xs">
            <div>
                <span class="text-slate-400 block font-medium">Beneficiary / Recipient</span>
                <span id="modal-beneficiary" class="font-bold text-slate-800 block mt-0.5"></span>
            </div>
            <div>
                <span class="text-slate-400 block font-medium">Amount Disbursed</span>
                <span id="modal-amount" class="font-bold text-emerald-600 block mt-0.5"></span>
            </div>
            <div>
                <span class="text-slate-400 block font-medium">Audit Reference</span>
                <span id="modal-ref" class="font-mono font-semibold text-slate-800 block mt-0.5"></span>
            </div>
        </div>

        <div>
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Ground Utilization Report</h4>
            <div id="modal-description" class="p-4 rounded-xl bg-slate-50 text-xs text-slate-700 leading-relaxed border border-slate-100"></div>
        </div>

        <!-- Vendor Bill / Invoice Lightbox -->
        <div id="modal-bill-section">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Official Vendor Bill / Purchase Receipt</h4>
            <div class="p-3 bg-slate-100 rounded-2xl border border-slate-200 text-center">
                <img id="modal-bill-img" src="" alt="Bill Proof" class="max-h-80 mx-auto object-contain rounded-xl shadow-2xs hidden">
                <div id="modal-pdf-bill" class="py-6 text-center hidden">
                    <svg class="w-12 h-12 text-rose-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <span class="text-xs font-bold text-slate-800 block">PDF Document Attached</span>
                </div>
                <a id="modal-bill-link" href="#" target="_blank" class="inline-block mt-2 text-xs font-bold text-emerald-600 hover:text-emerald-700 underline">
                    Open Original Document in Full Resolution &rarr;
                </a>
            </div>
        </div>

        <!-- Ground Impact Photos -->
        <div id="modal-photos-section">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">On-Ground Impact Photo Evidence</h4>
            <div id="modal-photos-grid" class="grid grid-cols-2 sm:grid-cols-3 gap-3"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openProofModal(dist) {
        document.getElementById('modal-title').textContent = dist.title;
        document.getElementById('modal-meta').textContent = 'Disbursed on ' + new Date(dist.distribution_date).toLocaleDateString() + (dist.campaign ? ' • For ' + dist.campaign.title : ' • General Relief');
        document.getElementById('modal-beneficiary').textContent = dist.beneficiary_name;
        document.getElementById('modal-amount').textContent = '₹' + Number(dist.amount_spent).toLocaleString('en-IN', {minimumFractionDigits: 2});
        document.getElementById('modal-ref').textContent = dist.payment_reference || 'VERIFIED-CASH/DIRECT';
        document.getElementById('modal-description').textContent = dist.description;

        const billSection = document.getElementById('modal-bill-section');
        const billImg = document.getElementById('modal-bill-img');
        const pdfBill = document.getElementById('modal-pdf-bill');
        const billLink = document.getElementById('modal-bill-link');

        if (dist.proof_bill_image) {
            billSection.classList.remove('hidden');
            billLink.href = '/storage/' + dist.proof_bill_image;
            if (dist.proof_bill_image.toLowerCase().endsWith('.pdf')) {
                billImg.classList.add('hidden');
                pdfBill.classList.remove('hidden');
            } else {
                billImg.src = '/storage/' + dist.proof_bill_image;
                billImg.classList.remove('hidden');
                pdfBill.classList.add('hidden');
            }
        } else {
            billSection.classList.add('hidden');
        }

        const photosSection = document.getElementById('modal-photos-section');
        const photosGrid = document.getElementById('modal-photos-grid');
        photosGrid.innerHTML = '';

        if (dist.impact_photos && dist.impact_photos.length > 0) {
            photosSection.classList.remove('hidden');
            dist.impact_photos.forEach(photo => {
                const a = document.createElement('a');
                a.href = '/storage/' + photo;
                a.target = '_blank';
                a.innerHTML = `<img src="/storage/${photo}" class="w-full h-32 object-cover rounded-xl border border-slate-200 hover:opacity-90 transition">`;
                photosGrid.appendChild(a);
            });
        } else {
            photosSection.classList.add('hidden');
        }

        document.getElementById('proof-modal').classList.remove('hidden');
    }

    function closeProofModal() {
        document.getElementById('proof-modal').classList.add('hidden');
    }
</script>
@endpush
@endsection
