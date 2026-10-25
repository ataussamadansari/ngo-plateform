<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the About Us institutional trust and accreditation page.
     */
    public function about(): View
    {
        return view('pages.about');
    }
}
