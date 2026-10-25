@extends('layouts.base')

@section('title', $campaign->title)

@section('content')
<!-- Cause Header & Social Share Hero -->
<div class="bg-gradient-to-b from-slate-100 to-white border-b border-slate-200 py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center gap-2 mb-3">
            <a href="{{ route('campaigns.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                All Causes
            </a>
            <span class="text-slate-300">&bull;</span>
            @if($campaign->category)
                <a href="{{ route('campaigns.index', ['category' => $campaign->category->slug]) }}" class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-200 text-slate-700 hover:bg-slate-300 transition">
                    {{ $campaign->category->name }}
                </a>
            @endif
            @if($campaign->is_urgent)
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-600 text-white flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.316.492-.593 1.096-.867 1.748-.65 1.545-1.156 3.14-1.748 4.706a1 1 0 01-.19.333L4.85 13.5a1 1 0 00.75 1.5h8.8a1 1 0 00.75-1.5l-2.469-3.682a1 1 0 01-.19-.333c-.592-1.566-1.098-3.161-1.748-4.706-.274-.652-.551-1.256-.867-1.748a3.1 3.1 0 00-.481-.478z" clip-rule="evenodd"/></svg>
                    Urgent Cause
                </span>
            @endif
            @if($campaign->status === 'completed')
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-600 text-white">
                    Completed & Fully Funded
                </span>
            @endif
        </div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-3xl">
                <h1 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight mb-3">
                    {{ $campaign->title }}
                </h1>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                    {{ $campaign->short_description }}
                </p>
            </div>

            <!-- Social Share Buttons -->
            <div class="flex items-center gap-2 self-start lg:self-center bg-white p-2 rounded-2xl border border-slate-200 shadow-xs">
                <span class="text-xs font-bold text-slate-500 px-2 uppercase tracking-wider">Share:</span>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($campaign->title . ' - Support here: ' . url()->current()) }}"
                   target="_blank" rel="noopener noreferrer"
                   class="p-2 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition" title="Share on WhatsApp">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.299.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.303c-.087.087-.179.182-.077.357.101.174.449.741.964 1.201.662.591 1.221.774 1.394.861.173.087.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.043.073.043.419-.101.824z"/></svg>
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($campaign->title) }}&url={{ urlencode(url()->current()) }}"
                   target="_blank" rel="noopener noreferrer"
                   class="p-2 rounded-xl bg-sky-50 text-sky-600 hover:bg-sky-100 transition" title="Share on Twitter / X">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <button type="button" onclick="copyCurrentUrl(this)" class="p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition" title="Copy Page Link">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        <!-- Left Column: Content, Narrative, Gallery & Evidence (8 cols) -->
        <div class="lg:col-span-8 space-y-10">

            <!-- Hero Banner Image -->
            <div class="rounded-3xl overflow-hidden border border-slate-200 bg-slate-100 shadow-xs relative aspect-video">
                @if($campaign->thumbnail_image)
                    <img src="{{ asset('storage/' . $campaign->thumbnail_image) }}"
                         alt="{{ $campaign->title }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-600 to-slate-900 text-white font-black text-2xl">
                        {{ setting('ngo_name', 'NGO Platform') }}
                    </div>
                @endif
            </div>

            <!-- Full Rich Narrative Story -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 mb-6 flex items-center gap-3">
                    <span class="w-2.5 h-6 bg-primary rounded-full"></span>
                    About This Cause & Ground Need
                </h2>
                <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed space-y-4 text-sm sm:text-base">
                    {!! nl2br(e($campaign->full_story)) !!}
                </div>
            </div>

            <!-- Photo Gallery with Interactive Lightbox Modal -->
            @if($campaign->gallery_images && count($campaign->gallery_images) > 0)
                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Cause Photo Gallery & Field Evidence
                        </h2>
                        <span class="text-xs text-slate-500">{{ count($campaign->gallery_images) }} Photos</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @foreach($campaign->gallery_images as $photo)
                            <div class="aspect-square rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 cursor-pointer group relative shadow-xs"
                                 onclick="openLightbox('{{ asset('storage/' . $photo) }}')">
                                <img src="{{ asset('storage/' . $photo) }}"
                                     alt="Campaign photo"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                    <svg class="w-6 h-6 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Audited Fund Utilization Summary Preview -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block mb-1">Audited Financials</span>
                        <h2 class="text-xl font-bold text-slate-900">Fund Utilization & Ground Impact</h2>
                    </div>
                    <a href="{{ route('campaigns.transparency', $campaign->slug) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                        <span>View Public Ledger & Bills</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-100">
                        <span class="text-xs text-slate-600 font-medium block">Total Verified Donations</span>
                        <span class="text-xl sm:text-2xl font-black text-emerald-700 mt-1 block">
                            ₹{{ number_format($campaign->raised_amount, 2) }}
                        </span>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="text-xs text-slate-600 font-medium block">Disbursed for Ground Relief</span>
                        <span class="text-xl sm:text-2xl font-black text-slate-900 mt-1 block">
                            ₹{{ number_format($campaign->distributed_amount, 2) }}
                        </span>
                    </div>
                </div>

                @if($fundDistributions->count() > 0)
                    <div class="space-y-3">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Recent Expenses Verified:</span>
                        @foreach($fundDistributions as $dist)
                            <div class="flex items-center justify-between p-3 rounded-xl border border-slate-100 bg-slate-50/50 text-xs">
                                <div>
                                    <span class="font-bold text-slate-800 block">{{ $dist->title }}</span>
                                    <span class="text-[11px] text-slate-500">{{ $dist->beneficiary_name }} &bull; {{ $dist->distribution_date->format('d M, Y') }}</span>
                                </div>
                                <span class="font-mono font-bold text-slate-900">₹{{ number_format($dist->amount_spent, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-500 italic">Disbursements will appear here with proof receipts as relief activities are carried out on ground.</p>
                @endif
            </div>

            <!-- Recent Verified Donors Stream -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block mb-1">Community Support</span>
                        <h2 class="text-xl font-bold text-slate-900">Recent Verified Donors ({{ $donorsCount }})</h2>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                        100% Bank Reconciled
                    </span>
                </div>

                @if($recentDonations->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentDonations as $donation)
                            <div class="flex items-start justify-between p-3.5 rounded-2xl border border-slate-100 bg-slate-50/60 hover:bg-slate-50 transition">
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                                        {{ substr($donation->is_anonymous ? 'A' : $donation->donor_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-xs sm:text-sm font-bold text-slate-900">
                                                {{ $donation->is_anonymous ? 'Anonymous Supporter' : $donation->donor_name }}
                                            </span>
                                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        </div>
                                        <span class="text-[11px] text-slate-500 block">
                                            {{ $donation->created_at->diffForHumans() }}
                                        </span>
                                        @if($donation->donor_message)
                                            <p class="text-xs text-slate-600 mt-1 italic">
                                                "{{ $donation->donor_message }}"
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-sm font-mono font-bold text-slate-900">
                                    ₹{{ number_format($donation->amount, 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-slate-500">
                        <p class="text-sm">Be the first verified supporter for this cause!</p>
                        @if($campaign->status === 'active')
                            <a href="{{ route('donate.index', ['campaign_id' => $campaign->id]) }}" class="mt-3 inline-block px-4 py-2 rounded-xl text-xs font-bold text-white bg-primary hover:opacity-95 transition">
                                Donate First
                            </a>
                        @endif
                    </div>
                @endif
            </div>

        </div>

        <!-- Right Sticky Column: Goal Progress, Direct CTA & Offline Details (4 cols) -->
        <div class="lg:col-span-4">
            <div class="sticky top-24 space-y-6">

                <!-- Financial Goal Card -->
                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-lg">
                    <div class="flex justify-between items-baseline mb-2">
                        <div>
                            <span class="text-2xl sm:text-3xl font-black text-slate-900">
                                ₹{{ number_format($campaign->raised_amount, 2) }}
                            </span>
                            <span class="text-xs text-slate-500 block">raised so far</span>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-bold text-slate-600">
                                ₹{{ number_format($campaign->goal_amount, 2) }}
                            </span>
                            <span class="text-xs text-slate-500 block">target goal</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-slate-100 rounded-full h-3 mb-3 overflow-hidden">
                        <div class="bg-primary h-3 rounded-full transition-all duration-700" style="width: {{ $campaign->progress_percentage }}%"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-center text-xs pb-6 border-b border-slate-100 mb-6">
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="font-black text-slate-900 text-sm block">{{ $campaign->progress_percentage }}%</span>
                            <span class="text-slate-500 text-[11px]">Goal Funded</span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="font-black text-slate-900 text-sm block">{{ $donorsCount }}</span>
                            <span class="text-slate-500 text-[11px]">Verified Donors</span>
                        </div>
                    </div>

                    @if($campaign->status === 'active')
                        <a href="{{ route('donate.index', ['campaign_id' => $campaign->id]) }}"
                           class="w-full block text-center py-4 px-6 rounded-2xl font-black text-base text-white bg-primary hover:opacity-95 shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                            Donate to This Cause Now
                        </a>
                        <p class="text-center text-slate-400 text-[11px] mt-2">Instant submission &bull; Bank-verified receipt</p>
                    @else
                        <div class="w-full text-center py-3.5 px-4 rounded-2xl font-bold text-sm bg-slate-100 text-slate-600">
                            This campaign has concluded.
                        </div>
                    @endif
                </div>

                <!-- Direct UPI & Bank Details Box for Offline Donors -->
                <div class="bg-slate-900 text-white rounded-3xl p-6 shadow-md border border-slate-800">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 block mb-2">Direct UPI & Bank Transfer</span>
                    <h3 class="text-base font-bold text-white mb-4">Zero Gateway Fees</h3>

                    <div class="space-y-3 text-xs">
                        @if(setting('upi_id'))
                            <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700/60 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-400 block uppercase">UPI ID / VPA</span>
                                    <span class="font-mono font-bold text-emerald-300">{{ setting('upi_id') }}</span>
                                </div>
                                <button type="button" onclick="navigator.clipboard.writeText('{{ setting('upi_id') }}'); alert('UPI ID copied!');" class="text-xs text-slate-400 hover:text-white underline">
                                    Copy
                                </button>
                            </div>
                        @endif

                        @if(setting('bank_account_number'))
                            <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700/60 space-y-1">
                                <div class="flex justify-between">
                                    <span class="text-[10px] text-slate-400 uppercase">Bank</span>
                                    <span class="font-semibold text-slate-200">{{ setting('bank_name', 'National Bank') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-[10px] text-slate-400 uppercase">Account No</span>
                                    <span class="font-mono font-bold text-white">{{ setting('bank_account_number') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-[10px] text-slate-400 uppercase">IFSC Code</span>
                                    <span class="font-mono font-bold text-emerald-300">{{ setting('bank_ifsc_code') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-800 flex items-center justify-between text-xs text-slate-400">
                        <span>Already transferred?</span>
                        <a href="{{ route('donate.index', ['campaign_id' => $campaign->id]) }}" class="text-emerald-400 hover:text-emerald-300 font-bold underline">
                            Submit UTR Proof &rarr;
                        </a>
                    </div>
                </div>

                <!-- 80G Tax Exemption Card -->
                <div class="bg-emerald-50/70 border border-emerald-200 rounded-3xl p-5 text-xs text-emerald-900 flex items-start gap-3">
                    <svg class="w-6 h-6 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <div>
                        <span class="font-bold block text-sm text-emerald-950 mb-0.5">Tax Exemption Certified</span>
                        <p class="text-slate-600 leading-relaxed">
                            Donations are eligible for 50% deduction under Section 80G of the Indian Income Tax Act. Automated compliance receipt issued upon verification.
                        </p>
                        @if(setting('80g_reg_number'))
                            <span class="text-[11px] font-mono font-bold text-emerald-800 block mt-1.5">
                                Reg No: {{ setting('80g_reg_number') }}
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Lightbox Modal for Photo Gallery -->
<div id="lightbox-modal" class="fixed inset-0 z-50 bg-slate-900/90 backdrop-blur-sm hidden flex items-center justify-center p-4" onclick="closeLightbox()">
    <div class="relative max-w-4xl max-h-[90vh] flex items-center justify-center" onclick="event.stopPropagation()">
        <img id="lightbox-img" src="" alt="Enlarged gallery photo" class="max-w-full max-h-[85vh] rounded-2xl object-contain shadow-2xl">
        <button type="button" onclick="closeLightbox()" class="absolute -top-12 right-0 text-white hover:text-slate-300 p-2 text-sm font-bold flex items-center gap-1">
            <span>Close</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</div>

@push('scripts')
<script>
    function copyCurrentUrl(button) {
        navigator.clipboard.writeText(window.location.href);
        const originalContent = button.innerHTML;
        button.innerHTML = '<svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
        setTimeout(() => {
            button.innerHTML = originalContent;
        }, 2000);
    }

    function openLightbox(imageUrl) {
        document.getElementById('lightbox-img').src = imageUrl;
        document.getElementById('lightbox-modal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeLightbox() {
        document.getElementById('lightbox-modal').classList.add('hidden');
        document.getElementById('lightbox-img').src = '';
        document.body.classList.remove('overflow-hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
</script>
@endpush
@endsection
