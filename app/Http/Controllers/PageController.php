<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Faculty;
use App\Models\News;
use App\Models\Partner;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('welcome', [
            'latestNews' => News::published()
                ->orderBy('published_at', 'desc')
                ->take(3)
                ->get(),
        ]);
    }

    public function about(): View
    {
        return view('about', [
            'faculty' => Faculty::published()->orderBy('sort_order')->get(),
        ]);
    }

    public function partners(): View
    {
        return view('partners', [
            'partners' => Partner::published()->orderBy('sort_order')->get(),
        ]);
    }

    public function contacts(): View
    {
        return view('contacts');
    }
}
