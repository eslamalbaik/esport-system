<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;

class NewsController extends Controller
{
    public function index()
    {
        $articles = NewsArticle::published()->ordered()->paginate(8);

        return view('site.news', compact('articles'));
    }

    public function show(NewsArticle $article)
    {
        if (!$article->is_published) {
            abort(404);
        }

        return view('site.news_show', compact('article'));
    }
}
