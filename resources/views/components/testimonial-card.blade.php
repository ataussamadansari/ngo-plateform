@props([
    'quote',
    'name',
    'role' => 'Supporter',
    'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80',
])

<div {{ $attributes->merge(['class' => 'bg-[#f8faf8] hover:bg-white rounded-2xl p-5 border border-slate-200/70 shadow-xs hover:shadow-md transition-all duration-300 flex items-start gap-4']) }}>
    <img src="{{ $avatar }}"
         alt="{{ $name }}"
         loading="lazy"
         class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl object-cover shrink-0 border border-white shadow-xs">
    <div class="space-y-2">
        <p class="text-xs sm:text-sm text-slate-600 italic leading-relaxed">
            "{{ $quote }}"
        </p>
        <div>
            <h4 class="text-sm font-extrabold text-slate-900">{{ $name }}</h4>
            <span class="block text-xs text-slate-500">{{ $role }}</span>
        </div>
    </div>
</div>