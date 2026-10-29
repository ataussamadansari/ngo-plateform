@props([
    'name',
    'role',
    'image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-[0_6px_20px_-4px_rgba(15,23,42,0.05)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group']) }}>
    <div class="h-36 sm:h-40 overflow-hidden bg-slate-100">
        <img src="{{ $image }}"
             alt="{{ $name }}"
             loading="lazy"
             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
    </div>
    <div class="p-3 sm:p-3.5 text-left">
        <h4 class="text-xs sm:text-sm font-extrabold text-slate-900 group-hover:text-[#16a34a] transition-colors leading-tight">
            {{ $name }}
        </h4>
        <span class="block text-[11px] font-medium text-slate-500 mt-0.5">
            {{ $role }}
        </span>
    </div>
</div>
