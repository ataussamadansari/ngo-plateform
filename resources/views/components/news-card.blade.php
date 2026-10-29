@props([
    'title',
    'date' => '15 Nov 2026',
    'image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=400&q=80',
    'url' => '#',
])

<a href="{{ $url }}"
   {{ $attributes->merge(['class' => 'bg-white rounded-2xl p-3.5 border border-slate-200/80 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-4 group']) }}>
    <img src="{{ $image }}"
         alt="{{ $title }}"
         loading="lazy"
         class="w-24 h-20 rounded-xl object-cover shrink-0 group-hover:scale-105 transition-transform duration-300">
    <div class="space-y-1.5">
        <h4 class="text-sm font-extrabold text-slate-900 group-hover:text-[#16a34a] transition-colors line-clamp-2 leading-snug">
            {{ $title }}
        </h4>
        <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>{{ $date }}</span>
        </div>
    </div>
</a>
