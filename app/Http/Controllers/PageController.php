<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the About Us institutional trust and accreditation page.
     */
    public function about(): View
    {
        $teamMembers = TeamMember::active()->get();

        return view('pages.about', compact('teamMembers'));
    }

    /**
     * Display the unified Legal & Privacy portal with pre-selected tab.
     */
    public function legal(): View
    {
        return view('pages.legal', ['initialTab' => 'privacy']);
    }

    public function privacy(): View
    {
        return view('pages.legal', ['initialTab' => 'privacy']);
    }

    public function terms(): View
    {
        return view('pages.legal', ['initialTab' => 'terms']);
    }

    public function disclaimer(): View
    {
        return view('pages.legal', ['initialTab' => 'disclaimer']);
    }
}
