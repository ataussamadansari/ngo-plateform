<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CauseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of cause categories with campaign metrics.
     */
    public function index()
    {
        $categories = CauseCategory::withCount('campaigns')
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store a newly created cause category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120', 'unique:cause_categories,slug'],
            'icon' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        CauseCategory::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Cause category "'.$validated['name'].'" successfully created.');
    }

    /**
     * Update the specified cause category in storage.
     */
    public function update(Request $request, CauseCategory $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120', Rule::unique('cause_categories', 'slug')->ignore($category->id)],
            'icon' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Cause category "'.$category->name.'" updated successfully.');
    }

    /**
     * Remove the specified cause category from storage.
     */
    public function destroy(CauseCategory $category)
    {
        if ($category->campaigns()->count() > 0) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Cannot delete category "'.$category->name.'" because active campaigns are associated with it.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Cause category deleted successfully.');
    }
}
