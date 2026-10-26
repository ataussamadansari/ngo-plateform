
<div class="space-y-6 text-sm">

    {{-- Applicant Header --}}
    <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
        <div class="h-1.5 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500"></div>

        <div class="flex flex-col gap-5 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex min-w-0 items-center gap-4">
                @if($record->profile_photo)
                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($record->profile_photo) }}"
                        alt="Applicant profile"
                        class="h-16 w-16 shrink-0 rounded-2xl border border-slate-200 object-cover dark:border-slate-700"
                    >
                @else
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-xl font-bold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                        {{ strtoupper(substr($record->full_name ?: 'A', 0, 1)) }}
                    </div>
                @endif

                <div class="min-w-0">
                    <div class="mb-1 flex flex-wrap items-center gap-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Volunteer Application
                        </span>
                    </div>

                    <h2 class="break-words text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $record->full_name }}
                    </h2>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        {{ $record->occupation ?: 'Occupation not specified' }}
                        <span class="mx-1.5">•</span>
                        {{ $record->city ?: 'Location not specified' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                @php
                    $statusClasses = match($record->status) {
                        'approved' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20 dark:bg-emerald-950/50 dark:text-emerald-300',
                        'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-950/50 dark:text-amber-300',
                        'rejected' => 'bg-rose-50 text-rose-700 ring-rose-600/20 dark:bg-rose-950/50 dark:text-rose-300',
                        default => 'bg-slate-100 text-slate-700 ring-slate-500/20 dark:bg-slate-800 dark:text-slate-300',
                    };
                @endphp

                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-bold capitalize ring-1 ring-inset {{ $statusClasses }}">
                    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                    {{ $record->status ?: 'Unknown' }}
                </span>

                <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 dark:border-slate-700 dark:bg-slate-800">
                    <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        Volunteer Code
                    </p>
                    <p class="mt-0.5 font-mono text-xs font-bold text-emerald-700 dark:text-emerald-400">
                        {{ $record->volunteer_code ?: 'Pending approval' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-5">

        {{-- Left: Applicant Information --}}
        <div class="space-y-5 lg:col-span-3">

            {{-- Contact Information --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM5 21a7 7 0 0114 0M19 8v6m-3-3h6"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Personal Information</h3>
                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Contact and applicant details</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-x-6 px-5 sm:grid-cols-2">
                    <div class="flex min-w-0 items-start gap-3 border-b border-slate-100 py-4 dark:border-slate-800">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.2l-2.1 1.05a11 11 0 005.44 5.44l1.05-2.1a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.06 21 3 14.94 3 7V5z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Phone Number</p>
                            <a href="tel:{{ $record->phone }}" class="mt-1 block break-all font-semibold text-slate-800 hover:text-emerald-600 dark:text-slate-200">
                                {{ $record->phone ?: 'Not provided' }}
                            </a>
                        </div>
                    </div>

                    <div class="flex min-w-0 items-start gap-3 border-b border-slate-100 py-4 dark:border-slate-800">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 7l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Email Address</p>
                            <p class="mt-1 break-all font-semibold text-slate-800 dark:text-slate-200">
                                {{ $record->email ?: 'Not provided' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex min-w-0 items-start gap-3 border-b border-slate-100 py-4 dark:border-slate-800">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 21s7-4.5 7-11a7 7 0 10-14 0c0 6.5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 dark:text-slate-400">City / District</p>
                            <p class="mt-1 font-semibold text-slate-800 dark:text-slate-200">
                                {{ $record->city ?: 'Not provided' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex min-w-0 items-start gap-3 border-b border-slate-100 py-4 dark:border-slate-800">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9" stroke-width="1.7"/><path stroke-linecap="round" stroke-width="1.7" d="M12 7v5l3 2"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Availability</p>
                            <p class="mt-1 font-semibold capitalize text-slate-800 dark:text-slate-200">
                                {{ $record->availability ?: 'Flexible' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex min-w-0 items-start gap-3 py-4 sm:col-span-2">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="17" rx="2" stroke-width="1.7"/><path stroke-linecap="round" stroke-width="1.7" d="M16 2v4M8 2v4M3 10h18"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Application Submitted</p>
                            <p class="mt-1 font-semibold text-slate-800 dark:text-slate-200">
                                {{ $record->created_at ? $record->created_at->format('d M Y, h:i A') : 'Not available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Address --}}
            @if($record->address)
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                    <div class="mb-3 flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-950/50 dark:text-violet-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 21s7-4.5 7-11a7 7 0 10-14 0c0 6.5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Postal Address</h3>
                    </div>
                    <p class="rounded-xl bg-slate-50 p-4 leading-6 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        {{ $record->address }}
                    </p>
                </section>
            @endif

            {{-- Skills --}}
            @if($record->skills && is_array($record->skills) && count($record->skills) > 0)
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 12l2 2 4-4M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white">Skills & Expertise</h3>
                            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Applicant's listed skills</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @foreach($record->skills as $skill)
                            <span class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-300">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </section>
            @endif

        </div>

        {{-- Right: Documents --}}
        <div class="space-y-5 lg:col-span-2">

            {{-- Government ID --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-950/50 dark:text-amber-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M8 3h6l5 5v11a2 2 0 01-2 2H8a2 2 0 01-2-2V5a2 2 0 012-2z"/><path stroke-linecap="round" stroke-width="1.7" d="M14 3v6h5M9 14h6M9 17h6"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Government ID Proof</h3>
                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Identity verification document</p>
                    </div>
                </div>

                <div class="p-4">
                    @if($record->id_proof_path)
                        @php
                            $idUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($record->id_proof_path);
                            $extension = strtolower(pathinfo($record->id_proof_path, PATHINFO_EXTENSION));
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                        @endphp

                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-800">
                            @if($isImage)
                                <a href="{{ $idUrl }}" target="_blank" rel="noopener noreferrer" class="group block">
                                    <div class="flex min-h-48 items-center justify-center p-3">
                                        <img
                                            src="{{ $idUrl }}"
                                            alt="Government identity document"
                                            class="max-h-72 w-full rounded-lg object-contain transition duration-200 group-hover:opacity-90"
                                            loading="lazy"
                                        >
                                    </div>
                                    <div class="flex items-center justify-center gap-2 border-t border-slate-200 bg-white px-3 py-3 text-xs font-semibold text-emerald-700 dark:border-slate-700 dark:bg-slate-900 dark:text-emerald-400">
                                        View full-size image
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 4h6v6m-11 3L20 4M18 13v5a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h5"/>
                                        </svg>
                                    </div>
                                </a>
                            @else
                                <div class="flex flex-col items-center px-4 py-8 text-center">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-slate-400 shadow-sm dark:bg-slate-900">
                                        <svg class="h-9 w-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 3h7l5 5v11a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/><path stroke-linecap="round" stroke-width="1.5" d="M14 3v6h5M8 14h8M8 17h8"/>
                                        </svg>
                                    </div>
                                    <p class="mt-3 font-semibold text-slate-800 dark:text-slate-200">
                                        Identity document
                                    </p>
                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                        {{ strtoupper($extension ?: 'FILE') }} attachment
                                    </p>
                                    <a href="{{ $idUrl }}" target="_blank" rel="noopener noreferrer" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-emerald-700">
                                        Open document
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 4h6v6m-11 3L20 4"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="flex flex-col items-center rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-10 text-center dark:border-slate-700 dark:bg-slate-800/50">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-400 dark:bg-slate-900">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M7 3h7l5 5v11a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/><path stroke-linecap="round" stroke-width="1.6" d="M14 3v6h5"/>
                                </svg>
                            </div>
                            <p class="mt-3 font-semibold text-slate-700 dark:text-slate-200">No ID proof attached</p>
                            <p class="mt-1 max-w-52 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                The applicant has not uploaded an identity document.
                            </p>
                        </div>
                    @endif
                </div>
            </section>

            {{-- Profile Photograph --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-950/50 dark:text-violet-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4" stroke-width="1.7"/><path stroke-linecap="round" stroke-width="1.7" d="M4 21a8 8 0 0116 0"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Profile Photograph</h3>
                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Applicant's uploaded photo</p>
                    </div>
                </div>

                <div class="p-5">
                    @if($record->profile_photo)
                        <a
                            href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($record->profile_photo) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group flex flex-col items-center rounded-xl bg-slate-50 px-4 py-6 transition hover:bg-slate-100 dark:bg-slate-800/60 dark:hover:bg-slate-800"
                        >
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($record->profile_photo) }}"
                                alt="Volunteer profile photograph"
                                class="h-32 w-32 rounded-2xl border-2 border-white object-cover shadow-md ring-1 ring-slate-200 transition duration-200 group-hover:scale-[1.03] dark:border-slate-700 dark:ring-slate-600"
                                loading="lazy"
                            >
                            <span class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-400">
                                View full-size photo
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 4h6v6m-11 3L20 4"/>
                                </svg>
                            </span>
                        </a>
                    @else
                        <div class="flex flex-col items-center rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center dark:border-slate-700 dark:bg-slate-800/50">
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-slate-400 dark:bg-slate-900">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="8" r="4" stroke-width="1.6"/><path stroke-linecap="round" stroke-width="1.6" d="M4 21a8 8 0 0116 0"/>
                                </svg>
                            </div>
                            <p class="mt-3 font-semibold text-slate-700 dark:text-slate-200">No profile photo</p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">No photograph was uploaded.</p>
                        </div>
                    @endif
                </div>
            </section>

        </div>
    </div>
</div>

<div class="space-y-6 text-sm">

    {{-- Applicant Header --}}
    <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
        <div class="h-1.5 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500"></div>

        <div class="flex flex-col gap-5 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex min-w-0 items-center gap-4">
                @if($record->profile_photo)
                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($record->profile_photo) }}"
                        alt="Applicant profile"
                        class="h-16 w-16 shrink-0 rounded-2xl border border-slate-200 object-cover dark:border-slate-700"
                    >
                @else
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-xl font-bold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                        {{ strtoupper(substr($record->full_name ?: 'A', 0, 1)) }}
                    </div>
                @endif

                <div class="min-w-0">
                    <div class="mb-1 flex flex-wrap items-center gap-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Volunteer Application
                        </span>
                    </div>

                    <h2 class="break-words text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $record->full_name }}
                    </h2>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        {{ $record->occupation ?: 'Occupation not specified' }}
                        <span class="mx-1.5">•</span>
                        {{ $record->city ?: 'Location not specified' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                @php
                    $statusClasses = match($record->status) {
                        'approved' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20 dark:bg-emerald-950/50 dark:text-emerald-300',
                        'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-950/50 dark:text-amber-300',
                        'rejected' => 'bg-rose-50 text-rose-700 ring-rose-600/20 dark:bg-rose-950/50 dark:text-rose-300',
                        default => 'bg-slate-100 text-slate-700 ring-slate-500/20 dark:bg-slate-800 dark:text-slate-300',
                    };
                @endphp

                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-bold capitalize ring-1 ring-inset {{ $statusClasses }}">
                    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                    {{ $record->status ?: 'Unknown' }}
                </span>

                <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 dark:border-slate-700 dark:bg-slate-800">
                    <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        Volunteer Code
                    </p>
                    <p class="mt-0.5 font-mono text-xs font-bold text-emerald-700 dark:text-emerald-400">
                        {{ $record->volunteer_code ?: 'Pending approval' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-5">

        {{-- Left: Applicant Information --}}
        <div class="space-y-5 lg:col-span-3">

            {{-- Contact Information --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM5 21a7 7 0 0114 0M19 8v6m-3-3h6"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Personal Information</h3>
                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Contact and applicant details</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-x-6 px-5 sm:grid-cols-2">
                    <div class="flex min-w-0 items-start gap-3 border-b border-slate-100 py-4 dark:border-slate-800">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.2l-2.1 1.05a11 11 0 005.44 5.44l1.05-2.1a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.06 21 3 14.94 3 7V5z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Phone Number</p>
                            <a href="tel:{{ $record->phone }}" class="mt-1 block break-all font-semibold text-slate-800 hover:text-emerald-600 dark:text-slate-200">
                                {{ $record->phone ?: 'Not provided' }}
                            </a>
                        </div>
                    </div>

                    <div class="flex min-w-0 items-start gap-3 border-b border-slate-100 py-4 dark:border-slate-800">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 7l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Email Address</p>
                            <p class="mt-1 break-all font-semibold text-slate-800 dark:text-slate-200">
                                {{ $record->email ?: 'Not provided' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex min-w-0 items-start gap-3 border-b border-slate-100 py-4 dark:border-slate-800">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 21s7-4.5 7-11a7 7 0 10-14 0c0 6.5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 dark:text-slate-400">City / District</p>
                            <p class="mt-1 font-semibold text-slate-800 dark:text-slate-200">
                                {{ $record->city ?: 'Not provided' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex min-w-0 items-start gap-3 border-b border-slate-100 py-4 dark:border-slate-800">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9" stroke-width="1.7"/><path stroke-linecap="round" stroke-width="1.7" d="M12 7v5l3 2"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Availability</p>
                            <p class="mt-1 font-semibold capitalize text-slate-800 dark:text-slate-200">
                                {{ $record->availability ?: 'Flexible' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex min-w-0 items-start gap-3 py-4 sm:col-span-2">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="17" rx="2" stroke-width="1.7"/><path stroke-linecap="round" stroke-width="1.7" d="M16 2v4M8 2v4M3 10h18"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Application Submitted</p>
                            <p class="mt-1 font-semibold text-slate-800 dark:text-slate-200">
                                {{ $record->created_at ? $record->created_at->format('d M Y, h:i A') : 'Not available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Address --}}
            @if($record->address)
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                    <div class="mb-3 flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-950/50 dark:text-violet-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 21s7-4.5 7-11a7 7 0 10-14 0c0 6.5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Postal Address</h3>
                    </div>
                    <p class="rounded-xl bg-slate-50 p-4 leading-6 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        {{ $record->address }}
                    </p>
                </section>
            @endif

            {{-- Skills --}}
            @if($record->skills && is_array($record->skills) && count($record->skills) > 0)
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 12l2 2 4-4M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white">Skills & Expertise</h3>
                            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Applicant's listed skills</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @foreach($record->skills as $skill)
                            <span class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-300">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </section>
            @endif

        </div>

        {{-- Right: Documents --}}
        <div class="space-y-5 lg:col-span-2">

            {{-- Government ID --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-950/50 dark:text-amber-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M8 3h6l5 5v11a2 2 0 01-2 2H8a2 2 0 01-2-2V5a2 2 0 012-2z"/><path stroke-linecap="round" stroke-width="1.7" d="M14 3v6h5M9 14h6M9 17h6"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Government ID Proof</h3>
                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Identity verification document</p>
                    </div>
                </div>

                <div class="p-4">
                    @if($record->id_proof_path)
                        @php
                            $idUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($record->id_proof_path);
                            $extension = strtolower(pathinfo($record->id_proof_path, PATHINFO_EXTENSION));
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                        @endphp

                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-800">
                            @if($isImage)
                                <a href="{{ $idUrl }}" target="_blank" rel="noopener noreferrer" class="group block">
                                    <div class="flex min-h-48 items-center justify-center p-3">
                                        <img
                                            src="{{ $idUrl }}"
                                            alt="Government identity document"
                                            class="max-h-72 w-full rounded-lg object-contain transition duration-200 group-hover:opacity-90"
                                            loading="lazy"
                                        >
                                    </div>
                                    <div class="flex items-center justify-center gap-2 border-t border-slate-200 bg-white px-3 py-3 text-xs font-semibold text-emerald-700 dark:border-slate-700 dark:bg-slate-900 dark:text-emerald-400">
                                        View full-size image
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 4h6v6m-11 3L20 4M18 13v5a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h5"/>
                                        </svg>
                                    </div>
                                </a>
                            @else
                                <div class="flex flex-col items-center px-4 py-8 text-center">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-slate-400 shadow-sm dark:bg-slate-900">
                                        <svg class="h-9 w-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 3h7l5 5v11a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/><path stroke-linecap="round" stroke-width="1.5" d="M14 3v6h5M8 14h8M8 17h8"/>
                                        </svg>
                                    </div>
                                    <p class="mt-3 font-semibold text-slate-800 dark:text-slate-200">
                                        Identity document
                                    </p>
                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                        {{ strtoupper($extension ?: 'FILE') }} attachment
                                    </p>
                                    <a href="{{ $idUrl }}" target="_blank" rel="noopener noreferrer" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-emerald-700">
                                        Open document
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 4h6v6m-11 3L20 4"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="flex flex-col items-center rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-10 text-center dark:border-slate-700 dark:bg-slate-800/50">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-400 dark:bg-slate-900">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M7 3h7l5 5v11a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/><path stroke-linecap="round" stroke-width="1.6" d="M14 3v6h5"/>
                                </svg>
                            </div>
                            <p class="mt-3 font-semibold text-slate-700 dark:text-slate-200">No ID proof attached</p>
                            <p class="mt-1 max-w-52 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                The applicant has not uploaded an identity document.
                            </p>
                        </div>
                    @endif
                </div>
            </section>

            {{-- Profile Photograph --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-950/50 dark:text-violet-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4" stroke-width="1.7"/><path stroke-linecap="round" stroke-width="1.7" d="M4 21a8 8 0 0116 0"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Profile Photograph</h3>
                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Applicant's uploaded photo</p>
                    </div>
                </div>

                <div class="p-5">
                    @if($record->profile_photo)
                        <a
                            href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($record->profile_photo) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group flex flex-col items-center rounded-xl bg-slate-50 px-4 py-6 transition hover:bg-slate-100 dark:bg-slate-800/60 dark:hover:bg-slate-800"
                        >
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($record->profile_photo) }}"
                                alt="Volunteer profile photograph"
                                class="h-32 w-32 rounded-2xl border-2 border-white object-cover shadow-md ring-1 ring-slate-200 transition duration-200 group-hover:scale-[1.03] dark:border-slate-700 dark:ring-slate-600"
                                loading="lazy"
                            >
                            <span class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-400">
                                View full-size photo
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 4h6v6m-11 3L20 4"/>
                                </svg>
                            </span>
                        </a>
                    @else
                        <div class="flex flex-col items-center rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center dark:border-slate-700 dark:bg-slate-800/50">
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-slate-400 dark:bg-slate-900">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="8" r="4" stroke-width="1.6"/><path stroke-linecap="round" stroke-width="1.6" d="M4 21a8 8 0 0116 0"/>
                                </svg>
                            </div>
                            <p class="mt-3 font-semibold text-slate-700 dark:text-slate-200">No profile photo</p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">No photograph was uploaded.</p>
                        </div>
                    @endif
                </div>
            </section>

        </div>
    </div>
</div>

<div class="space-y-6 text-sm">

    {{-- Applicant Header --}}
    <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
        <div class="h-1.5 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500"></div>

        <div class="flex flex-col gap-5 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex min-w-0 items-center gap-4">
                @if($record->profile_photo)
                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($record->profile_photo) }}"
                        alt="Applicant profile"
                        class="h-16 w-16 shrink-0 rounded-2xl border border-slate-200 object-cover dark:border-slate-700"
                    >
                @else
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-xl font-bold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                        {{ strtoupper(substr($record->full_name ?: 'A', 0, 1)) }}
                    </div>
                @endif

                <div class="min-w-0">
                    <div class="mb-1 flex flex-wrap items-center gap-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Volunteer Application
                        </span>
                    </div>

                    <h2 class="break-words text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $record->full_name }}
                    </h2>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        {{ $record->occupation ?: 'Occupation not specified' }}
                        <span class="mx-1.5">•</span>
                        {{ $record->city ?: 'Location not specified' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                @php
                    $statusClasses = match($record->status) {
                        'approved' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20 dark:bg-emerald-950/50 dark:text-emerald-300',
                        'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-950/50 dark:text-amber-300',
                        'rejected' => 'bg-rose-50 text-rose-700 ring-rose-600/20 dark:bg-rose-950/50 dark:text-rose-300',
                        default => 'bg-slate-100 text-slate-700 ring-slate-500/20 dark:bg-slate-800 dark:text-slate-300',
                    };
                @endphp

                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-bold capitalize ring-1 ring-inset {{ $statusClasses }}">
                    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                    {{ $record->status ?: 'Unknown' }}
                </span>

                <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 dark:border-slate-700 dark:bg-slate-800">
                    <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        Volunteer Code
                    </p>
                    <p class="mt-0.5 font-mono text-xs font-bold text-emerald-700 dark:text-emerald-400">
                        {{ $record->volunteer_code ?: 'Pending approval' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-5">

        {{-- Left: Applicant Information --}}
        <div class="space-y-5 lg:col-span-3">

            {{-- Contact Information --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM5 21a7 7 0 0114 0M19 8v6m-3-3h6"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Personal Information</h3>
                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Contact and applicant details</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-x-6 px-5 sm:grid-cols-2">
                    <div class="flex min-w-0 items-start gap-3 border-b border-slate-100 py-4 dark:border-slate-800">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.2l-2.1 1.05a11 11 0 005.44 5.44l1.05-2.1a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.06 21 3 14.94 3 7V5z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Phone Number</p>
                            <a href="tel:{{ $record->phone }}" class="mt-1 block break-all font-semibold text-slate-800 hover:text-emerald-600 dark:text-slate-200">
                                {{ $record->phone ?: 'Not provided' }}
                            </a>
                        </div>
                    </div>

                    <div class="flex min-w-0 items-start gap-3 border-b border-slate-100 py-4 dark:border-slate-800">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 7l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Email Address</p>
                            <p class="mt-1 break-all font-semibold text-slate-800 dark:text-slate-200">
                                {{ $record->email ?: 'Not provided' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex min-w-0 items-start gap-3 border-b border-slate-100 py-4 dark:border-slate-800">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 21s7-4.5 7-11a7 7 0 10-14 0c0 6.5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 dark:text-slate-400">City / District</p>
                            <p class="mt-1 font-semibold text-slate-800 dark:text-slate-200">
                                {{ $record->city ?: 'Not provided' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex min-w-0 items-start gap-3 border-b border-slate-100 py-4 dark:border-slate-800">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9" stroke-width="1.7"/><path stroke-linecap="round" stroke-width="1.7" d="M12 7v5l3 2"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Availability</p>
                            <p class="mt-1 font-semibold capitalize text-slate-800 dark:text-slate-200">
                                {{ $record->availability ?: 'Flexible' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex min-w-0 items-start gap-3 py-4 sm:col-span-2">
                        <div class="mt-0.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="17" rx="2" stroke-width="1.7"/><path stroke-linecap="round" stroke-width="1.7" d="M16 2v4M8 2v4M3 10h18"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Application Submitted</p>
                            <p class="mt-1 font-semibold text-slate-800 dark:text-slate-200">
                                {{ $record->created_at ? $record->created_at->format('d M Y, h:i A') : 'Not available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Address --}}
            @if($record->address)
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                    <div class="mb-3 flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-950/50 dark:text-violet-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 21s7-4.5 7-11a7 7 0 10-14 0c0 6.5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Postal Address</h3>
                    </div>
                    <p class="rounded-xl bg-slate-50 p-4 leading-6 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        {{ $record->address }}
                    </p>
                </section>
            @endif

            {{-- Skills --}}
            @if($record->skills && is_array($record->skills) && count($record->skills) > 0)
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 12l2 2 4-4M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white">Skills & Expertise</h3>
                            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Applicant's listed skills</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @foreach($record->skills as $skill)
                            <span class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-300">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </section>
            @endif

        </div>

        {{-- Right: Documents --}}
        <div class="space-y-5 lg:col-span-2">

            {{-- Government ID --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-950/50 dark:text-amber-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M8 3h6l5 5v11a2 2 0 01-2 2H8a2 2 0 01-2-2V5a2 2 0 012-2z"/><path stroke-linecap="round" stroke-width="1.7" d="M14 3v6h5M9 14h6M9 17h6"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Government ID Proof</h3>
                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Identity verification document</p>
                    </div>
                </div>

                <div class="p-4">
                    @if($record->id_proof_path)
                        @php
                            $idUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($record->id_proof_path);
                            $extension = strtolower(pathinfo($record->id_proof_path, PATHINFO_EXTENSION));
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                        @endphp

                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-800">
                            @if($isImage)
                                <a href="{{ $idUrl }}" target="_blank" rel="noopener noreferrer" class="group block">
                                    <div class="flex min-h-48 items-center justify-center p-3">
                                        <img
                                            src="{{ $idUrl }}"
                                            alt="Government identity document"
                                            class="max-h-72 w-full rounded-lg object-contain transition duration-200 group-hover:opacity-90"
                                            loading="lazy"
                                        >
                                    </div>
                                    <div class="flex items-center justify-center gap-2 border-t border-slate-200 bg-white px-3 py-3 text-xs font-semibold text-emerald-700 dark:border-slate-700 dark:bg-slate-900 dark:text-emerald-400">
                                        View full-size image
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 4h6v6m-11 3L20 4M18 13v5a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h5"/>
                                        </svg>
                                    </div>
                                </a>
                            @else
                                <div class="flex flex-col items-center px-4 py-8 text-center">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-slate-400 shadow-sm dark:bg-slate-900">
                                        <svg class="h-9 w-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 3h7l5 5v11a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/><path stroke-linecap="round" stroke-width="1.5" d="M14 3v6h5M8 14h8M8 17h8"/>
                                        </svg>
                                    </div>
                                    <p class="mt-3 font-semibold text-slate-800 dark:text-slate-200">
                                        Identity document
                                    </p>
                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                        {{ strtoupper($extension ?: 'FILE') }} attachment
                                    </p>
                                    <a href="{{ $idUrl }}" target="_blank" rel="noopener noreferrer" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-emerald-700">
                                        Open document
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 4h6v6m-11 3L20 4"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="flex flex-col items-center rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-10 text-center dark:border-slate-700 dark:bg-slate-800/50">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-400 dark:bg-slate-900">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M7 3h7l5 5v11a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/><path stroke-linecap="round" stroke-width="1.6" d="M14 3v6h5"/>
                                </svg>
                            </div>
                            <p class="mt-3 font-semibold text-slate-700 dark:text-slate-200">No ID proof attached</p>
                            <p class="mt-1 max-w-52 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                The applicant has not uploaded an identity document.
                            </p>
                        </div>
                    @endif
                </div>
            </section>

            {{-- Profile Photograph --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-950/50 dark:text-violet-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4" stroke-width="1.7"/><path stroke-linecap="round" stroke-width="1.7" d="M4 21a8 8 0 0116 0"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Profile Photograph</h3>
                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Applicant's uploaded photo</p>
                    </div>
                </div>

                <div class="p-5">
                    @if($record->profile_photo)
                        <a
                            href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($record->profile_photo) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group flex flex-col items-center rounded-xl bg-slate-50 px-4 py-6 transition hover:bg-slate-100 dark:bg-slate-800/60 dark:hover:bg-slate-800"
                        >
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($record->profile_photo) }}"
                                alt="Volunteer profile photograph"
                                class="h-32 w-32 rounded-2xl border-2 border-white object-cover shadow-md ring-1 ring-slate-200 transition duration-200 group-hover:scale-[1.03] dark:border-slate-700 dark:ring-slate-600"
                                loading="lazy"
                            >
                            <span class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-400">
                                View full-size photo
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 4h6v6m-11 3L20 4"/>
                                </svg>
                            </span>
                        </a>
                    @else
                        <div class="flex flex-col items-center rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center dark:border-slate-700 dark:bg-slate-800/50">
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-slate-400 dark:bg-slate-900">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="8" r="4" stroke-width="1.6"/><path stroke-linecap="round" stroke-width="1.6" d="M4 21a8 8 0 0116 0"/>
                                </svg>
                            </div>
                            <p class="mt-3 font-semibold text-slate-700 dark:text-slate-200">No profile photo</p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">No photograph was uploaded.</p>
                        </div>
                    @endif
                </div>
            </section>

        </div>
    </div>
</div>
