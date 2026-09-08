<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Contracts\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return view('news', [
            'news' => News::published()
                ->orderBy('published_at', 'desc')
                ->get(),
        ]);
    }

    public function show(News $article): View
    {
        abort_unless($article->is_published, 404);

        return view('news-article', ['article' => $article]);
    }
}
