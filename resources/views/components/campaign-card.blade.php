@props([
    'campaign' => null,
    'title' => null,
    'category' => null,
    'description' => null,
    'image' => null,
    'raised' => null,
    'goal' => null,
    'percentage' => null,
    'donateUrl' => null,
    'detailUrl' => null,
    'isUrgent' => false,
])

@php
    if ($campaign) {
        $title = $title ?? $campaign->title;
        $category = $category ?? ($campaign->category ? $campaign->category->name : 'General');
        $description = $description ?? $campaign->short_description;
        $raised = $raised ?? (float) ($campaign->raised_amount ?? 0);
        $goal = $goal ?? (float) ($campaign->goal_amount ?? 100000);
        $donateUrl = $donateUrl ?? route('donate.index', ['campaign_id' => $campaign->id]);
        $detailUrl = $detailUrl ?? route('campaigns.show', $campaign->slug);
        $isUrgent = $isUrgent || !empty($campaign->is_urgent);

        $categoryLower = strtolower($category);
        $fallbackCategoryImages = [
            'education' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=900&q=85',
            'clean water' => 'https://images.unsplash.com/photo-1541544741938-0af808871cc0?auto=format&fit=crop&w=900&q=85',
            'water' => 'https://images.unsplash.com/photo-1541544741938-0af808871cc0?auto=format&fit=crop&w=900&q=85',
            'healthcare' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=900&q=85',
            'health' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=900&q=85',
            'food' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=900&q=85',
            'nutrition' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=900&q=85',
            'environment' => 'https://images.unsplash.com/photo-1416879597379-82b3c6b1a6b8?auto=format&fit=crop&w=900&q=85',
            'community' => 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?auto=format&fit=crop&w=900&q=85',
        ];

        if (!$image) {
            $image = !empty($campaign->thumbnail_image)
                ? (str_starts_with($campaign->thumbnail_image, 'http') ? $campaign->thumbnail_image : asset('storage/' . $campaign->thumbnail_image))
                : ($fallbackCategoryImages[$categoryLower] ?? 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=900&q=80');
        }
    } else {
        $title = $title ?? 'Campaign Title';
        $category = $category ?? 'General';
        $raised = $raised ?? 0;
        $goal = $goal ?? 100000;
        $image = $image ?? 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=900&q=80';
        $donateUrl = $donateUrl ?? '#';
        $detailUrl = $detailUrl ?? '#';
    }

    $pct = $percentage ?? ($goal > 0 ? min(100, (int) round(($raised / $goal) * 100)) : 0);
    $catSlug = strtolower(trim($category ?? ''));
@endphp

<article {{ $attributes->merge(['class' => 'group flex flex-col overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-[0_4px_20px_rgba(15,23,42,0.05)] hover:shadow-lg transition-all duration-300']) }}>
    <!-- Thumbnail with Category Pill Badge -->
    <div class="relative h-48 sm:h-52 w-full overflow-hidden bg-slate-100">
        <img src="{{ $image }}"
             alt="{{ $title }}"
             loading="lazy"
             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">

        <!-- Category Floating Pill (Top-Left per Mockup) -->
        <span class="absolute top-3 left-3 inline-flex items-center gap-1.5 rounded-full bg-white/95 backdrop-blur-xs px-3 py-1 text-xs font-bold text-slate-800 shadow-sm border border-slate-100">
            @if(str_contains($catSlug, 'education') || str_contains($catSlug, 'school') || str_contains($catSlug, 'child'))
                <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            @elseif(str_contains($catSlug, 'water'))
                <svg class="h-3.5 w-3.5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            @elseif(str_contains($catSlug, 'health') || str_contains($catSlug, 'medical'))
                <svg class="h-3.5 w-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            @elseif(str_contains($catSlug, 'food') || str_contains($catSlug, 'nutrition'))
                <svg class="h-3.5 w-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            @elseif(str_contains($catSlug, 'environment') || str_contains($catSlug, 'tree'))
                <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            @elseif(str_contains($catSlug, 'community') || str_contains($catSlug, 'skill'))
                <svg class="h-3.5 w-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            @else
                <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            @endif
            <span>{{ $category }}</span>
        </span>

        @if($isUrgent)
            <span class="absolute top-3 right-3 rounded-full bg-red-600 px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider text-white shadow-xs">
                Urgent Appeal
            </span>
        @endif
    </div>

    <!-- Content Area -->
    <div class="flex flex-1 flex-col justify-between p-5">
        <div>
            <h3 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-1">
                @if($detailUrl)
                    <a href="{{ $detailUrl }}">{{ $title }}</a>
                @else
                    {{ $title }}
                @endif
            </h3>
            <p class="mt-1.5 text-xs sm:text-sm text-slate-500 line-clamp-2 leading-relaxed">
                {{ $description }}
            </p>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-100">
            <!-- Amount & Percentage Row -->
            <div class="flex items-baseline justify-between text-xs sm:text-sm mb-1.5">
                <div>
                    <span class="font-extrabold text-slate-900">₹{{ number_format((float)$raised) }}</span>
                    <span class="text-slate-500 text-xs"> raised of ₹{{ number_format((float)$goal) }}</span>
                    <span class="sr-only">{{ number_format((float)$raised, 2) }}</span>
                </div>
                <span class="font-extrabold text-slate-800">{{ $pct }}%</span>
            </div>

            <!-- Progress Bar -->
            <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full rounded-full bg-[#16a34a] transition-all duration-700 ease-out"
                     style="width: {{ $pct }}%"></div>
            </div>

            <!-- 2 Action Buttons (Side by Side per Mockup) -->
            <div class="mt-4 grid grid-cols-2 gap-2">
                <a href="{{ $donateUrl }}"
                   class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-[#16a34a] hover:bg-[#15803d] active:scale-[0.99] px-3 py-2.5 text-xs font-bold text-white shadow-xs transition-all">
                    <span>Donate Now</span>
                    <span aria-hidden="true">→</span>
                </a>
                <a href="{{ $detailUrl }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white hover:bg-slate-50 hover:border-slate-300 active:scale-[0.99] px-3 py-2.5 text-xs font-bold text-slate-700 transition-all">
                    <span>View Details</span>
                </a>
            </div>
        </div>
    </div>
</article>
