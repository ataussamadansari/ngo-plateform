@extends('layouts.base')

@section('title', 'Fund Utilization: ' . $campaign->title . ' - ' . setting('ngo_name', 'NGO Platform'))

@section('content')
<!-- Hero Header -->
<div class="relative bg-slate-900 text-white py-12 md:py-16 overflow-hidden">
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#16a34a_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="flex items-center text-xs sm:text-sm text-slate-400 mb-4 gap-2">
            <a href="{{ url('/') }}" class="hover:text-white transition">Home</a>
            <span>&rsaquo;</span>
            <a href="{{ route('transparency.index') }}" class="hover:text-white transition">Transparency</a>
            <span>&rsaquo;</span>
            <span class="text-emerald-400 font-medium truncate max-w-xs">{{ $campaign->title }}</span>
        </nav>

        <div class="max-w-3xl">
            <span class="text-xs font-bold tracking-widest text-emerald-400 uppercase block mb-2">
                {{ $campaign->category->name ?? 'Cause Fund' }} &bull; AUDITED UTILIZATION
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-white mb-3">
                {{ $campaign->title }}
            </h1>
            <p class="text-base sm:text-lg text-slate-300 leading-relaxed">
                {{ $campaign->short_description }}
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-10">

    <!-- Campaign Financial Dashboard -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Target Goal</span>
            <span class="text-2xl font-black text-slate-900 mt-1 block">₹{{ number_format($goal, 2) }}</span>
            <span class="text-[11px] text-slate-500 mt-0.5 block">Approved budget for cause</span>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Verified Raised</span>
            <span class="text-2xl font-black text-emerald-600 mt-1 block">₹{{ number_format($raised, 2) }}</span>
            <span class="text-[11px] text-slate-500 mt-0.5 block">{{ $campaign->progress_percentage }}% of target funded</span>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Disbursed</span>
            <span class="text-2xl font-black text-blue-600 mt-1 block">₹{{ number_format($distributed, 2) }}</span>
            <span class="text-[11px] text-slate-500 mt-0.5 block">Directly spent on beneficiaries</span>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Deployment Ratio</span>
            <span class="text-2xl font-black text-purple-600 mt-1 block">{{ $utilizationRate }}%</span>
            <span class="text-[11px] text-slate-500 mt-0.5 block">Of raised funds already put to work</span>
        </div>
    </div>

    <!-- Progress Bars Section -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-2xs space-y-6">
        <div>
            <div class="flex items-center justify-between text-xs font-bold text-slate-700 mb-2">
                <span>Fundraising Progress (Raised vs Target Goal)</span>
                <span class="text-emerald-600">{{ $campaign->progress_percentage }}% (₹{{ number_format($raised, 2) }} / ₹{{ number_format($goal, 2) }})</span>
            </div>
            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden p-0.5">
                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $campaign->progress_percentage }}%;"></div>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between text-xs font-bold text-slate-700 mb-2">
                <span>Deployment Efficiency (Disbursed vs Raised)</span>
                <span class="text-blue-600">{{ $utilizationRate }}% (₹{{ number_format($distributed, 2) }} disbursed)</span>
            </div>
            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden p-0.5">
                <div class="h-full bg-blue-500 rounded-full" style="width: {{ $utilizationRate }}%;"></div>
            </div>
        </div>
    </div>

    <!-- Itemized Expenditures for this Cause -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900">Cause Expenditure Ledger</h2>
                <p class="text-xs text-slate-500 mt-0.5">All audited expenses recorded directly for {{ $campaign->title }}.</p>
            </div>
            <a href="{{ route('donate.index', ['campaign_id' => $campaign->id]) }}" class="px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition">
                Support This Cause &rarr;
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-2xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                        <tr>
                            <th class="py-3.5 px-4">Date</th>
                            <th class="py-3.5 px-4">Purpose / Particulars</th>
                            <th class="py-3.5 px-4">Beneficiary</th>
                            <th class="py-3.5 px-4">Amount</th>
                            <th class="py-3.5 px-4">Payment Ref</th>
                            <th class="py-3.5 px-4">Proof</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($distributions as $dist)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3.5 px-4 whitespace-nowrap font-medium text-slate-900">
                                    {{ $dist->distribution_date->format('d M Y') }}
                                </td>
                                <td class="py-3.5 px-4 font-bold text-slate-900 max-w-sm">
                                    {{ $dist->title }}
                                    <span class="text-[11px] font-normal text-slate-500 block mt-0.5">{{ $dist->description }}</span>
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-slate-800">
                                    {{ $dist->beneficiary_name }}
                                </td>
                                <td class="py-3.5 px-4 font-black text-sm text-emerald-600 whitespace-nowrap">
                                    ₹{{ number_format($dist->amount_spent, 2) }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-[11px] text-slate-600 whitespace-nowrap">
                                    {{ $dist->payment_reference ?? 'VERIFIED-DIRECT' }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($dist->proof_bill_image)
                                        <a href="/storage/{{ $dist->proof_bill_image }}" target="_blank" class="px-2.5 py-1 rounded-md bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-[11px] inline-flex items-center gap-1">
                                            <span>Invoice</span> &rarr;
                                        </a>
                                    @else
                                        <span class="text-slate-400 italic">No bill</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400">
                                    No public fund disbursements have been logged for this cause yet.
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
