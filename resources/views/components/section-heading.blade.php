@props([
    'eyebrow' => '',
    'title' => '',
    'subtitle' => null,
    'align' => 'center', // 'center' or 'left'
    'actionText' => null,
    'actionUrl' => '#',
])

<div {{ $attributes->merge(['class' => $align === 'center' ? 'relative text-center mb-10' : 'flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8']) }}>
    <div class="{{ $align === 'center' ? 'max-w-2xl mx-auto' : '' }}">
        @if($eyebrow)
            <span class="block text-[11px] sm:text-xs font-extrabold uppercase tracking-[0.18em] text-[#16a34a] mb-1.5">
                {{ $eyebrow }}
            </span>
        @endif
        <h2 class="text-2xl sm:text-3xl lg:text-[34px] font-extrabold text-slate-900 tracking-tight leading-tight">
            {{ $title }}
        </h2>
        @if($subtitle)
            <p class="text-sm sm:text-base text-slate-500 mt-2">
                {{ $subtitle }}
            </p>
        @endif
    </div>

    @if($actionText)
        <div class="{{ $align === 'center' ? 'mt-3 sm:mt-0 sm:absolute sm:right-0 sm:bottom-1' : 'shrink-0' }}">
            <a href="{{ $actionUrl }}"
               class="inline-flex items-center gap-1.5 text-sm font-bold text-[#16a34a] hover:text-[#15803d] group">
                <span>{{ $actionText }}</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    @endif
</div>
