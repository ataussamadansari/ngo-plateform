@extends('layouts.base')

@section('title', 'Admin Verification Queue - ' . setting('ngo_name', 'NGO Platform'))

@section('content')
<div class="bg-slate-900 text-white py-8 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-emerald-400 mb-1">
                <span>Back-Office Management</span>
                <span>&bull;</span>
                <span>Finance Verification</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Donation Verification Queue</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Reconcile donor-submitted UTRs and screenshot proofs against official bank statements.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.donations.create') }}" class="px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-primary hover:opacity-95 shadow-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Record Offline Donation
            </a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Flash Alerts -->
    @if(session('success'))
        <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-xl bg-rose-50 border border-rose-200 p-4 text-rose-800 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Metrics Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Pending Verification</span>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-amber-600">{{ $pendingCount }}</span>
                <span class="text-xs text-slate-400">awaiting check</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Total Verified</span>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-emerald-600">{{ $verifiedCount }}</span>
                <span class="text-xs text-slate-400">approved</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Verified Amount</span>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">₹{{ number_format($totalVerifiedAmount) }}</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Rejected Submissions</span>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-rose-600">{{ $rejectedCount }}</span>
                <span class="text-xs text-slate-400">unmatched</span>
            </div>
        </div>
    </div>

    <!-- Filter Bar & Search -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs mb-6">
        <form action="{{ route('admin.donations.index') }}" method="GET" class="space-y-4">
            <!-- Tabs -->
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.donations.index', array_merge(request()->query(), ['status' => 'pending'])) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'pending' ? 'bg-amber-100 text-amber-800' : 'text-slate-600 hover:bg-slate-100' }}">
                        Pending ({{ $pendingCount }})
                    </a>
                    <a href="{{ route('admin.donations.index', array_merge(request()->query(), ['status' => 'verified'])) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'verified' ? 'bg-emerald-100 text-emerald-800' : 'text-slate-600 hover:bg-slate-100' }}">
                        Verified ({{ $verifiedCount }})
                    </a>
                    <a href="{{ route('admin.donations.index', array_merge(request()->query(), ['status' => 'rejected'])) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'rejected' ? 'bg-rose-100 text-rose-800' : 'text-slate-600 hover:bg-slate-100' }}">
                        Rejected ({{ $rejectedCount }})
                    </a>
                    <a href="{{ route('admin.donations.index', array_merge(request()->query(), ['status' => 'all'])) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'all' ? 'bg-slate-200 text-slate-800' : 'text-slate-600 hover:bg-slate-100' }}">
                        All ({{ $pendingCount + $verifiedCount + $rejectedCount }})
                    </a>
                </div>

                <input type="hidden" name="status" value="{{ $status }}">

                <div class="flex items-center gap-3">
                    <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition">
                        Apply Filters
                    </button>
                    @if(request()->hasAny(['search', 'campaign_id', 'payment_mode']))
                        <a href="{{ route('admin.donations.index', ['status' => $status]) }}" class="text-xs text-slate-500 hover:text-slate-800 underline">
                            Clear
                        </a>
                    @endif
                </div>
            </div>

            <!-- Inputs Row -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search UTR, donor, phone, receipt..." class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                </div>

                <div>
                    <select name="campaign_id" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 bg-white">
                        <option value="">All Campaigns</option>
                        @foreach($campaigns as $camp)
                            <option value="{{ $camp->id }}" {{ $campaignId == $camp->id ? 'selected' : '' }}>{{ $camp->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="payment_mode" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 bg-white">
                        <option value="">All Payment Modes</option>
                        <option value="upi_qr" {{ $paymentMode === 'upi_qr' ? 'selected' : '' }}>UPI Payment</option>
                        <option value="bank_transfer" {{ $paymentMode === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="cash" {{ $paymentMode === 'cash' ? 'selected' : '' }}>Cash / Direct</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <!-- Donations Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase font-semibold text-[11px] border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4">Date</th>
                        <th class="py-3.5 px-4">Donor Particulars</th>
                        <th class="py-3.5 px-4">Amount</th>
                        <th class="py-3.5 px-4">Mode</th>
                        <th class="py-3.5 px-4">UTR / Ref No</th>
                        <th class="py-3.5 px-4">Campaign</th>
                        <th class="py-3.5 px-4">Status / Receipt</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($donations as $donation)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="font-medium text-slate-900 block">{{ $donation->created_at->format('d M Y') }}</span>
                                <span class="text-[10px] text-slate-400 block">{{ $donation->created_at->format('h:i A') }}</span>
                            </td>

                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900 block">{{ $donation->donor_name }}</span>
                                <span class="text-[11px] text-slate-500 block">{{ $donation->donor_phone }}</span>
                                @if($donation->donor_pan)
                                    <span class="inline-block mt-0.5 px-1.5 py-0.5 bg-slate-100 rounded text-[10px] font-mono text-slate-700">PAN: {{ $donation->donor_pan }}</span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 whitespace-nowrap font-bold text-sm text-slate-900">
                                ₹{{ number_format($donation->amount, 2) }}
                            </td>

                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="px-2 py-1 rounded-md text-[11px] font-semibold {{ $donation->payment_mode === 'upi_qr' ? 'bg-purple-50 text-purple-700' : ($donation->payment_mode === 'bank_transfer' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700') }}">
                                    {{ strtoupper(str_replace('_', ' ', $donation->payment_mode)) }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-1.5 font-mono text-xs font-bold text-slate-800">
                                    <span>{{ $donation->utr_number }}</span>
                                    <button type="button" onclick="navigator.clipboard.writeText('{{ $donation->utr_number }}'); alert('UTR Copied!');" class="text-slate-400 hover:text-slate-600">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </button>
                                </div>
                            </td>

                            <td class="py-3.5 px-4 text-xs font-medium text-slate-700 max-w-[150px] truncate">
                                {{ $donation->campaign->title ?? 'General Relief Fund' }}
                            </td>

                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($donation->isVerified())
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        Verified
                                    </span>
                                    <span class="text-[10px] text-slate-500 font-mono block mt-1">{{ $donation->receipt_number }}</span>
                                @elseif($donation->isPending())
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">
                                        Pending Review
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">
                                        Rejected
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" onclick="openProofModal({{ json_encode($donation) }})" class="px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs shadow-2xs transition">
                                        Inspect
                                    </button>

                                    @if($donation->isPending())
                                        <form action="{{ route('admin.donations.approve', $donation) }}" method="POST" onsubmit="return confirm('Confirm approval for donation of ₹{{ number_format($donation->amount) }} with UTR {{ $donation->utr_number }}?');" class="inline">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-2xs transition">
                                                Approve
                                            </button>
                                        </form>

                                        <button type="button" onclick="promptRejectModal({{ $donation->id }}, '{{ $donation->utr_number }}')" class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold text-xs transition">
                                            Reject
                                        </button>
                                    @endif

                                    @if($donation->isVerified() && Route::has('donation.receipt'))
                                        <a href="{{ route('donation.receipt', $donation) }}" target="_blank" class="px-2.5 py-1.5 rounded-lg border border-emerald-200 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-semibold text-xs transition">
                                            PDF
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                No donations found matching current filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($donations->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $donations->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Side-by-Side Proof Verification Modal -->
<div id="proof-modal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs overflow-y-auto flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-4xl w-full shadow-2xl border border-slate-200 overflow-hidden my-8">
        <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-white">Side-by-Side Verification Check</h3>
                <p class="text-xs text-slate-400">Compare donor-submitted UTR against payment screenshot proof.</p>
            </div>
            <button type="button" onclick="closeProofModal()" class="text-slate-400 hover:text-white p-1 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
            <!-- Left Pane: Submission Particulars -->
            <div class="space-y-4">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Bank Matching Details</span>

                    <div>
                        <span class="text-xs text-slate-400 block">UTR / Ref Number (Match on Bank Statement)</span>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span id="modal-utr" class="text-lg font-mono font-extrabold text-slate-900"></span>
                            <button type="button" onclick="copyModalUtr()" class="px-2 py-0.5 bg-white border border-slate-300 rounded text-xs font-semibold text-slate-700 hover:bg-slate-100">Copy</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-200">
                        <div>
                            <span class="text-xs text-slate-400 block">Amount</span>
                            <span id="modal-amount" class="text-lg font-bold text-emerald-600 block"></span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">Mode</span>
                            <span id="modal-mode" class="text-xs font-semibold text-slate-800 uppercase block mt-1"></span>
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-2xl border border-slate-200 space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Donor Name:</span>
                        <span id="modal-donor-name" class="font-bold text-slate-800"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Phone:</span>
                        <span id="modal-donor-phone" class="font-semibold text-slate-800"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Email:</span>
                        <span id="modal-donor-email" class="text-slate-800"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">PAN:</span>
                        <span id="modal-donor-pan" class="font-mono text-slate-800"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Campaign:</span>
                        <span id="modal-campaign" class="font-medium text-slate-800"></span>
                    </div>
                </div>

                <div id="modal-action-zone" class="pt-2 flex gap-3">
                    <form id="modal-approve-form" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-sm transition">
                            Approve & Issue Receipt
                        </button>
                    </form>
                    <button type="button" onclick="openRejectFromModal()" class="px-4 py-3 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl font-bold text-xs transition">
                        Reject
                    </button>
                </div>

                <div id="modal-verified-zone" class="pt-2 hidden">
                    <a id="modal-receipt-link" href="#" target="_blank" class="w-full py-3 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 rounded-xl font-bold text-xs shadow-xs transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Download Official 80G Receipt (PDF)
                    </a>
                </div>
            </div>

            <!-- Right Pane: Proof Screenshot -->
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block mb-2">Uploaded Payment Proof</span>
                <div class="bg-slate-100 rounded-2xl p-2 border border-slate-200 text-center min-h-[300px] flex items-center justify-center overflow-hidden">
                    <img id="modal-screenshot" src="" alt="Payment Screenshot Proof" class="max-h-[360px] w-auto object-contain rounded-xl shadow-xs">
                    <span id="modal-no-screenshot" class="text-xs text-slate-400 hidden">No screenshot uploaded (Offline/Cash entry)</span>
                </div>
                <a id="modal-screenshot-link" href="#" target="_blank" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 text-center block mt-2">
                    Open Full Resolution Image in New Tab &rarr;
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Reject Reason Prompt Modal -->
<div id="reject-modal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200">
        <h3 class="text-base font-bold text-slate-900 mb-1">Reject Donation Submission</h3>
        <p class="text-xs text-slate-500 mb-4">Please provide an explanatory remark for the donor explaining why verification failed.</p>

        <form id="reject-form" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Rejection Remarks *</label>
                <textarea name="admin_remarks" required rows="3" placeholder="e.g. Transaction not found in bank statement, or UTR number mismatch." class="w-full p-3 rounded-xl border border-slate-300 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 text-xs text-slate-900"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-xs">
                    Confirm Rejection
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let currentDonation = null;

    function openProofModal(donation) {
        currentDonation = donation;
        document.getElementById('modal-utr').textContent = donation.utr_number;
        document.getElementById('modal-amount').textContent = '₹' + Number(donation.amount).toLocaleString('en-IN', {minimumFractionDigits: 2});
        document.getElementById('modal-mode').textContent = donation.payment_mode.replace('_', ' ');
        document.getElementById('modal-donor-name').textContent = donation.donor_name;
        document.getElementById('modal-donor-phone').textContent = donation.donor_phone;
        document.getElementById('modal-donor-email').textContent = donation.donor_email || 'Not provided';
        document.getElementById('modal-donor-pan').textContent = donation.donor_pan || 'Not provided';
        document.getElementById('modal-campaign').textContent = donation.campaign ? donation.campaign.title : 'General Fund';

        const img = document.getElementById('modal-screenshot');
        const noImg = document.getElementById('modal-no-screenshot');
        const link = document.getElementById('modal-screenshot-link');

        if (donation.payment_screenshot) {
            img.src = '/storage/' + donation.payment_screenshot;
            img.classList.remove('hidden');
            noImg.classList.add('hidden');
            link.href = '/storage/' + donation.payment_screenshot;
            link.classList.remove('hidden');
        } else {
            img.classList.add('hidden');
            noImg.classList.remove('hidden');
            link.classList.add('hidden');
        }

        const actionZone = document.getElementById('modal-action-zone');
        const verifiedZone = document.getElementById('modal-verified-zone');
        const receiptLink = document.getElementById('modal-receipt-link');

        if (donation.status === 'pending') {
            actionZone.classList.remove('hidden');
            verifiedZone.classList.add('hidden');
            document.getElementById('modal-approve-form').action = '/admin/donations/' + donation.id + '/approve';
        } else if (donation.status === 'verified') {
            actionZone.classList.add('hidden');
            verifiedZone.classList.remove('hidden');
            receiptLink.href = '/donations/' + donation.id + '/receipt';
        } else {
            actionZone.classList.add('hidden');
            verifiedZone.classList.add('hidden');
        }

        document.getElementById('proof-modal').classList.remove('hidden');
    }

    function closeProofModal() {
        document.getElementById('proof-modal').classList.add('hidden');
    }

    function copyModalUtr() {
        if (currentDonation) {
            navigator.clipboard.writeText(currentDonation.utr_number).then(() => {
                alert('UTR copied to clipboard!');
            });
        }
    }

    function promptRejectModal(id, utr) {
        document.getElementById('reject-form').action = '/admin/donations/' + id + '/reject';
        document.getElementById('reject-modal').classList.remove('hidden');
    }

    function openRejectFromModal() {
        if (currentDonation) {
            closeProofModal();
            promptRejectModal(currentDonation.id, currentDonation.utr_number);
        }
    }

    function closeRejectModal() {
        document.getElementById('reject-modal').classList.add('hidden');
    }
</script>
@endpush
@endsection
