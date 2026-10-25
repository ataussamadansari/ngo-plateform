<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminInquiryController extends Controller
{
    /**
     * Display a listing of visitor contact inquiries with status and search filters.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search');

        $query = ContactInquiry::query();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->latest()->paginate(20)->withQueryString();

        $totalCount = ContactInquiry::count();
        $pendingCount = ContactInquiry::where('status', 'pending')->count();
        $readCount = ContactInquiry::where('status', 'read')->count();
        $repliedCount = ContactInquiry::where('status', 'replied')->count();

        return view('admin.inquiries.index', compact(
            'inquiries',
            'status',
            'search',
            'totalCount',
            'pendingCount',
            'readCount',
            'repliedCount'
        ));
    }

    /**
     * Update the status of the specified inquiry (mark as read or replied).
     */
    public function updateStatus(Request $request, ContactInquiry $inquiry): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,read,replied'],
        ]);

        $inquiry->update([
            'status' => $request->status,
        ]);

        return back()->with('success', "Inquiry from {$inquiry->name} marked as {$request->status}.");
    }

    /**
     * Delete the specified inquiry from database.
     */
    public function destroy(ContactInquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();

        return back()->with('success', 'Inquiry deleted successfully.');
    }
}
