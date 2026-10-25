<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactInquiryRequest;
use App\Models\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display the Contact Us page with office details, map directions, and inquiry form.
     */
    public function index(): View
    {
        return view('pages.contact');
    }

    /**
     * Store a new visitor contact inquiry in the database.
     */
    public function store(StoreContactInquiryRequest $request): RedirectResponse
    {
        ContactInquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Thank you for reaching out! Your message has been received. Our team will review and respond promptly.');
    }
}
