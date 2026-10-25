@extends('layouts.base')

@section('title', 'Record Offline Donation - ' . setting('ngo_name', 'NGO Platform'))

@section('content')
<div class="bg-slate-900 text-white py-8 border-b border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center text-xs text-slate-400 mb-2 gap-2">
            <a href="{{ route('admin.donations.index') }}" class="hover:text-white transition">Verification Queue</a>
            <span>&rsaquo;</span>
            <span class="text-emerald-400 font-medium">Record Offline Donation</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Record Offline / Direct Donation</h1>
        <p class="text-xs sm:text-sm text-slate-400 mt-1">Directly record cash, cheque, or bank donations with immediate receipt generation.</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <form action="{{ route('admin.donations.store') }}" method="POST" class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
        @csrf

        @if($errors->any())
            <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4 text-xs text-rose-700">
                <span class="font-bold block mb-1">Please fix the following errors:</span>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Donor Full Name *</label>
                <input type="text" name="donor_name" required value="{{ old('donor_name') }}" placeholder="e.g. Anand Mahindra" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Donor Mobile Phone *</label>
                <input type="tel" name="donor_phone" required value="{{ old('donor_phone') }}" placeholder="e.g. +91 9876543210" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Donor Email Address</label>
                <input type="email" name="donor_email" value="{{ old('donor_email') }}" placeholder="e.g. donor@example.com" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Donor PAN Number (for 80G Tax Exemption)</label>
                <input type="text" name="donor_pan" maxlength="10" value="{{ old('donor_pan') }}" placeholder="e.g. ABCDE1234F" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 uppercase text-sm font-mono">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-100">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Amount (INR) *</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 font-bold">₹</span>
                    <input type="number" name="amount" required min="1" step="any" value="{{ old('amount') }}" placeholder="5000" class="w-full pl-7 pr-3 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm font-bold text-slate-900">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Payment Mode *</label>
                <select name="payment_mode" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm bg-white">
                    <option value="cash" {{ old('payment_mode') === 'cash' ? 'selected' : '' }}>Cash Handover</option>
                    <option value="bank_transfer" {{ old('payment_mode') === 'bank_transfer' ? 'selected' : '' }}>Direct Bank Deposit / Cheque</option>
                    <option value="upi_qr" {{ old('payment_mode') === 'upi_qr' ? 'selected' : '' }}>Direct UPI</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">UTR / Cheque Ref Number</label>
                <input type="text" name="utr_number" value="{{ old('utr_number') }}" placeholder="Optional (auto-generated if empty)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm font-mono">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Allocate to Specific Campaign (Optional)</label>
            <select name="campaign_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm bg-white">
                <option value="">General Relief & Emergency Fund</option>
                @foreach($campaigns as $camp)
                    <option value="{{ $camp->id }}" {{ old('campaign_id') == $camp->id ? 'selected' : '' }}>
                        {{ $camp->title }} ({{ $camp->category->name ?? 'General' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Donor Address</label>
            <textarea name="donor_address" rows="2" placeholder="Full postal address for 80G record..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm">{{ old('donor_address') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Internal Admin Notes / Source of Donation</label>
            <input type="text" name="admin_remarks" value="{{ old('admin_remarks', 'Cash donation collected directly by field volunteer.') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-sm">
        </div>

        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200 text-xs text-emerald-800">
            <strong>Note:</strong> Submitting this form will immediately generate an official <strong>80G Receipt Number</strong> and update the linked campaign's raised amount within an atomic database transaction.
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.donations.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-primary hover:opacity-95 shadow-sm transition">
                Save & Issue Receipt
            </button>
        </div>
    </form>
</div>
@endsection
