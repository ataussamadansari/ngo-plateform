{{-- resources/views/components/faq-item.blade.php --}}
@props([
    'index' => 1,
    'question',
    'answer',
])

<div class="bg-white rounded-xl border border-slate-200/80 shadow-2xs overflow-hidden transition-all duration-200 hover:border-[#bbf7d0]">
    <button
        type="button"
        @click="activeFaq = (activeFaq === {{ $index }} ? null : {{ $index }})"
        class="w-full px-4 py-3.5 text-left flex items-center justify-between gap-3 focus:outline-none"
        :aria-expanded="activeFaq === {{ $index }}"
    >
        <div class="flex items-center gap-3 min-w-0">
            <span class="w-5 h-5 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center shrink-0">
                <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="activeFaq === {{ $index }} ? 'rotate-45' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
            </span>
            <span class="text-xs sm:text-sm font-bold text-[#14291b] truncate">
                {{ $question }}
            </span>
        </div>

        <span class="text-slate-400 shrink-0 transition-transform duration-200" :class="activeFaq === {{ $index }} ? 'rotate-180 text-[#16a34a]' : ''">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" x-show="activeFaq !== {{ $index }}"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" x-show="activeFaq === {{ $index }}" x-cloak/>
            </svg>
        </span>
    </button>

    <div
        x-show="activeFaq === {{ $index }}"
        x-collapse
        x-cloak
        class="px-4 pb-4 pt-0.5 text-xs sm:text-[13px] text-slate-600 leading-relaxed border-t border-slate-100/80 pl-12"
    >
        {{ $answer }}
    </div>
</div>
