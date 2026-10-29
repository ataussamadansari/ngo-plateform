@props([
    'title',
    'subtitle',
    'color' => 'green', // 'green', 'blue', 'amber', 'indigo'
])

@php
    $colorClasses = match($color) {
        'blue'   => 'bg-blue-50 text-blue-600 border-blue-100',
        'amber'  => 'bg-amber-50 text-amber-500 border-amber-100',
        'indigo' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
        default  => 'bg-[#eef8f1] text-[#16a34a] border-[#bbf7d0]',
    };
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl p-4 sm:p-5 border border-white shadow-2xs hover:shadow-md transition-all duration-300 flex items-center gap-3.5']) }}>
    <div class="w-11 h-11 rounded-xl border {{ $colorClasses }} flex items-center justify-center shrink-0">
        {{ $icon ?? '' }}
    </div>
    <div class="min-w-0">
        <h3 class="text-xs sm:text-sm font-extrabold text-slate-900 truncate">{{ $title }}</h3>
        <p class="text-[11px] sm:text-xs text-slate-500 font-medium mt-0.5 truncate">{{ $subtitle }}</p>
    </div>
</div>