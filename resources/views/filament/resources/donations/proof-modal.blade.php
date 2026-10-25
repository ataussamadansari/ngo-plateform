<div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start text-sm">
    <!-- Left Pane: Submission Particulars -->
    <div class="space-y-4">
        <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-200 dark:border-slate-700 space-y-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block">Bank Matching Details</span>

            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 block">UTR / Ref Number (Match on Bank Statement)</span>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-lg font-mono font-extrabold text-slate-900 dark:text-white select-all">
                        {{ $record->utr_number ?: 'N/A' }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-2 border-t border-slate-200 dark:border-slate-700">
                <div>
                    <span class="text-xs text-slate-500 dark:text-slate-400 block">Amount</span>
                    <span class="text-lg font-extrabold text-emerald-600 dark:text-emerald-400 block">
                        ₹{{ number_format((float) $record->amount, 2) }}
                    </span>
                </div>
                <div>
                    <span class="text-xs text-slate-500 dark:text-slate-400 block">Payment Mode</span>
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200 uppercase block mt-1">
                        {{ str_replace('_', ' ', $record->payment_mode) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 space-y-2 text-xs bg-white dark:bg-slate-900">
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-800">
                <span class="text-slate-500 dark:text-slate-400">Donor Name:</span>
                <span class="font-bold text-slate-800 dark:text-slate-200">{{ $record->donor_name }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-800">
                <span class="text-slate-500 dark:text-slate-400">Phone:</span>
                <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $record->donor_phone }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-800">
                <span class="text-slate-500 dark:text-slate-400">Email:</span>
                <span class="text-slate-800 dark:text-slate-200">{{ $record->donor_email ?: 'N/A' }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-800">
                <span class="text-slate-500 dark:text-slate-400">PAN Number:</span>
                <span class="font-mono font-semibold text-slate-800 dark:text-slate-200">{{ $record->donor_pan ?: 'N/A' }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-800">
                <span class="text-slate-500 dark:text-slate-400">Linked Campaign:</span>
                <span class="font-medium text-slate-800 dark:text-slate-200">{{ $record->campaign?->title ?: 'General Fund' }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-800">
                <span class="text-slate-500 dark:text-slate-400">Status:</span>
                <span class="font-bold uppercase {{ $record->status === 'verified' ? 'text-emerald-600' : ($record->status === 'pending' ? 'text-amber-600' : 'text-rose-600') }}">
                    {{ $record->status }}
                </span>
            </div>
            @if($record->receipt_number)
                <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-800">
                    <span class="text-slate-500 dark:text-slate-400">Receipt No:</span>
                    <span class="font-mono font-bold text-emerald-600 dark:text-emerald-400">{{ $record->receipt_number }}</span>
                </div>
            @endif
            @if($record->admin_remarks)
                <div class="pt-2">
                    <span class="text-slate-500 dark:text-slate-400 block mb-1">Admin Remarks:</span>
                    <p class="text-slate-700 dark:text-slate-300 italic bg-slate-50 dark:bg-slate-800 p-2 rounded-lg">
                        {{ $record->admin_remarks }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Right Pane: Payment Screenshot Proof -->
    <div class="space-y-3">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block">Uploaded Payment Screenshot</span>
        @if($record->payment_screenshot)
            <div class="rounded-2xl border border-slate-200 dark:border-slate-700 p-2 bg-slate-50 dark:bg-slate-800 text-center">
                <a href="{{ \Illuminate\Support\Facades\Storage::url($record->payment_screenshot) }}" target="_blank" class="block group relative overflow-hidden rounded-xl">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($record->payment_screenshot) }}"
                         alt="Payment Screenshot Proof"
                         class="max-h-96 w-full object-contain mx-auto rounded-xl group-hover:scale-105 transition duration-200" />
                    <span class="absolute bottom-2 right-2 bg-slate-900/80 text-white text-[10px] px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition">
                        Click to view full size ↗
                    </span>
                </a>
            </div>
        @else
            <div class="p-10 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-700 text-center bg-slate-50/50 dark:bg-slate-800/30">
                <svg class="w-10 h-10 text-slate-300 dark:text-slate-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">No payment screenshot uploaded</p>
                <p class="text-[11px] text-slate-400 mt-1">Direct offline entry or manual donation without image attachment.</p>
            </div>
        @endif
    </div>
</div>
