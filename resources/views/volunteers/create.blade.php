@extends('layouts.base')

@section('title', 'Join as a Volunteer')

@section('content')
<div class="bg-gradient-to-b from-slate-100 to-white py-10 sm:py-14 border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 mb-4 shadow-xs">
            Community Leadership &bull; Direct Relief
        </span>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">
            Join Our Volunteer Community
        </h1>
        <p class="mt-3 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Volunteers are the backbone of our ground operations. Whether you can offer a few hours on weekends or bring professional skills, your time creates immediate life-changing impact.
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if ($errors->any())
        <div class="mb-8 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm">
            <div class="font-bold mb-1 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                Please correct the following errors before submitting:
            </div>
            <ul class="list-disc pl-7 space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('volunteers.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm space-y-8">
        @csrf

        <!-- Section 1: Personal & Contact Information -->
        <div>
            <h2 class="text-lg sm:text-xl font-bold text-slate-900 mb-1 flex items-center gap-2">
                <span class="w-2.5 h-5 bg-primary rounded-full"></span>
                1. Personal & Contact Details
            </h2>
            <p class="text-xs text-slate-500 mb-6">We will use these details to contact you for ground relief drives and orientation.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="full_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" required
                           placeholder="e.g. Rahul Sharma"
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           placeholder="rahul@example.com"
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Phone Number (WhatsApp Preferred) <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                           placeholder="+91 9876543210"
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label for="city" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        City / District <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="city" id="city" value="{{ old('city') }}" required
                           placeholder="e.g. Varanasi, Lucknow, Delhi"
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="sm:col-span-2">
                    <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Residential Address <span class="text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <textarea name="address" id="address" rows="2"
                              placeholder="Your current street or locality address"
                              class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('address') }}</textarea>
                </div>

                <div>
                    <label for="occupation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Occupation / Profession <span class="text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <input type="text" name="occupation" id="occupation" value="{{ old('occupation') }}"
                           placeholder="e.g. Student, Doctor, Engineer, Teacher"
                           class="w-full text-sm rounded-xl border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Availability Preference <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['weekends' => 'Weekends', 'weekdays' => 'Weekdays', 'flexible' => 'Flexible'] as $val => $label)
                            <label class="flex items-center justify-center p-2.5 rounded-xl border border-slate-300 text-xs font-semibold cursor-pointer has-checked:border-emerald-600 has-checked:bg-emerald-50 has-checked:text-emerald-900 transition">
                                <input type="radio" name="availability" value="{{ $val }}" {{ old('availability', 'weekends') === $val ? 'checked' : '' }} class="sr-only">
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-slate-100">

        <!-- Section 2: Skills & Service Domains -->
        <div>
            <h2 class="text-lg sm:text-xl font-bold text-slate-900 mb-1 flex items-center gap-2">
                <span class="w-2.5 h-5 bg-primary rounded-full"></span>
                2. Skills & Areas of Interest <span class="text-red-500 text-sm">*</span>
            </h2>
            <p class="text-xs text-slate-500 mb-4">Select all domains where you would like to contribute.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($skills as $skill)
                    <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 hover:border-slate-300 bg-slate-50/50 cursor-pointer has-checked:border-emerald-500 has-checked:bg-emerald-50/60 transition">
                        <input type="checkbox" name="skills[]" value="{{ $skill }}"
                               {{ is_array(old('skills')) && in_array($skill, old('skills')) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                        <span class="text-xs sm:text-sm font-semibold text-slate-800">{{ $skill }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <hr class="border-slate-100">

        <!-- Section 3: Identity & Documentation Verification -->
        <div>
            <h2 class="text-lg sm:text-xl font-bold text-slate-900 mb-1 flex items-center gap-2">
                <span class="w-2.5 h-5 bg-primary rounded-full"></span>
                3. Profile Photo & ID Verification
            </h2>
            <p class="text-xs text-slate-500 mb-6">Helps our screening team verify your identity and generate your official NGO volunteer badge.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Profile Photo -->
                <div class="p-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50/60 text-center">
                    <label for="profile_photo" class="cursor-pointer block">
                        <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-xs font-bold text-slate-800 block">Upload Profile Photo</span>
                        <span class="text-[11px] text-slate-500 block mt-1">JPEG, PNG, WebP (Max 2MB)</span>
                        <input type="file" name="profile_photo" id="profile_photo" accept="image/jpeg,image/png,image/webp" class="mt-3 text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300">
                    </label>
                </div>

                <!-- ID Proof -->
                <div class="p-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50/60 text-center">
                    <label for="id_proof" class="cursor-pointer block">
                        <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span class="text-xs font-bold text-slate-800 block">Upload ID Document (Optional)</span>
                        <span class="text-[11px] text-slate-500 block mt-1">Aadhaar, Voter ID, Driving License (PDF / Image &le; 2MB)</span>
                        <input type="file" name="id_proof" id="id_proof" accept="image/jpeg,image/png,image/webp,application/pdf" class="mt-3 text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300">
                    </label>
                </div>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit"
                    class="w-full py-4 px-6 rounded-2xl font-black text-base text-white bg-primary hover:opacity-95 shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                Submit Volunteer Application
            </button>
            <p class="text-center text-xs text-slate-400 mt-3">
                By submitting this form, you agree to uphold our community code of conduct and ethics during on-ground relief operations.
            </p>
        </div>
    </form>
</div>
@endsection
