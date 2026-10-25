@extends('layouts.base')

@section('title', 'Record Fund Distribution - Admin')

@section('content')
<!-- Header -->
<div class="bg-slate-900 text-white border-b border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center justify-between">
            <div>
                <nav class="flex items-center text-xs text-slate-400 gap-2 mb-1">
                    <a href="{{ route('admin.distributions.index') }}" class="hover:text-white transition">Distributions</a>
                    <span>&rsaquo;</span>
                    <span class="text-emerald-400 font-medium">Record Disbursement</span>
                </nav>
                <h1 class="text-2xl font-extrabold text-white">Record Fund Distribution</h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-0.5">Log verified relief expenditure, upload vendor invoices, and synchronize cause balances.</p>
            </div>
            <a href="{{ route('admin.distributions.index') }}" class="px-4 py-2 rounded-xl border border-slate-700 hover:border-slate-600 bg-slate-800 text-slate-300 font-semibold text-xs transition">
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

        <form action="{{ route('admin.distributions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Basic Expenditure Details -->
            <div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                    1. Expenditure Particulars
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Expenditure Title / Purpose *</label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Distribution of 250 Dry Ration & Grocery Kits" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs text-slate-900">
                        @error('title') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Beneficiary Name / Community Group *</label>
                        <input type="text" name="beneficiary_name" value="{{ old('beneficiary_name') }}" required placeholder="e.g. Daily Wage Worker Families, Assi Ghat" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs text-slate-900">
                        @error('beneficiary_name') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Amount Disbursed (INR) *</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2.5 text-xs font-bold text-slate-400">₹</span>
                            <input type="number" step="0.01" min="1" name="amount_spent" value="{{ old('amount_spent') }}" required placeholder="15000.00" class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs font-bold text-slate-900">
                        </div>
                        @error('amount_spent') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Distribution Date *</label>
                        <input type="date" name="distribution_date" value="{{ old('distribution_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs text-slate-900">
                        @error('distribution_date') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Linked Cause / Campaign</label>
                        <select name="campaign_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs text-slate-900 bg-white">
                            <option value="">General Humanitarian Relief Fund</option>
                            @foreach($campaigns as $campaign)
                                <option value="{{ $campaign->id }}" {{ old('campaign_id') == $campaign->id ? 'selected' : '' }}>
                                    {{ $campaign->title }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-[10px] text-slate-400 mt-1 block">Allocates expenditure to update campaign's distributed balance.</span>
                        @error('campaign_id') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Bank Payment Reference / Cheque No / UTR</label>
                        <input type="text" name="payment_reference" value="{{ old('payment_reference') }}" placeholder="e.g. NEFT-994827101 or Cheque #492819" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs font-mono text-slate-900">
                        @error('payment_reference') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Narrative & Description -->
            <div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                    2. Description & Ground Impact Story
                </h3>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Utilization Details / On-Ground Report *</label>
                    <textarea name="description" rows="4" required placeholder="Describe how the funds were utilized, items procured, vendor names, volunteer involvement, and the direct outcome on beneficiaries..." class="w-full p-4 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 text-xs text-slate-900 leading-relaxed">{{ old('description') }}</textarea>
                    @error('description') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Section 3: Verification Proofs (Bill & Impact Photos) -->
            <div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                    3. Verification Proofs (Invoices & Impact Photos)
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Bill Upload -->
                    <div class="p-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50">
                        <label class="block text-xs font-bold text-slate-800 mb-1">Official Purchase Invoice / Vendor Bill</label>
                        <p class="text-[11px] text-slate-500 mb-3">Upload receipt, cash memo, or bill. Max 2MB (JPG, PNG, WEBP, or PDF).</p>
                        <input type="file" name="proof_bill_image" accept=".jpg,.jpeg,.png,.webp,.pdf" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                        @error('proof_bill_image') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Impact Photos -->
                    <div class="p-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50">
                        <label class="block text-xs font-bold text-slate-800 mb-1">On-Ground Impact Photos (Up to 6)</label>
                        <p class="text-[11px] text-slate-500 mb-3">Select photos showing distribution activity and beneficiaries. Max 2MB each.</p>
                        <input type="file" name="impact_photos[]" multiple accept=".jpg,.jpeg,.png,.webp" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer">
                        @error('impact_photos') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                        @error('impact_photos.*') <span class="text-rose-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 4: Public Visibility -->
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-start gap-3">
                <input type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public', '1') == '1' ? 'checked' : '' }} class="mt-1 h-4 w-4 text-emerald-600 rounded border-emerald-300 focus:ring-emerald-500">
                <div>
                    <label for="is_public" class="text-xs font-bold text-emerald-950 block">Publish on Public Transparency Ledger</label>
                    <p class="text-[11px] text-emerald-700 mt-0.5">When checked, this distribution, along with proof bills and impact photos, will be visible publicly on the website for complete donor accountability.</p>
                </div>
            </div>

            <!-- Submit Strip -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.distributions.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-xs text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Save & Record Distribution
                </button>
            </div>
        </form>

    </div>

</div>
@endsection
