<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsArticleRequest;
use App\Http\Requests\UpdateNewsArticleRequest;
use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NewsArticleController extends Controller
{
    public function index()
    {
        $articles = NewsArticle::ordered()->get();

        return view('admin.news.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(StoreNewsArticleRequest $request)
    {
        $article = new NewsArticle();
        $article->title = [
            'en' => $request->input('title.en'),
            'ar' => $request->input('title.ar'),
        ];
        $article->description = [
            'en' => $request->input('description.en'),
            'ar' => $request->input('description.ar'),
        ];
        $article->date = $request->input('date') ?: null;
        $article->is_published = $request->boolean('is_published');
        $article->sort_order = (NewsArticle::max('sort_order') ?? 0) + 1;

        if ($request->filled('slug')) {
            $article->slug = Str::slug($request->input('slug'));
        }

        if ($request->hasFile('image')) {
            $article->image_path = $this->storeImage($request->file('image'));
        }

        $article->save();

        return redirect()
            ->route('admin.news-articles.index')
            ->with('ok', __('Article created.'));
    }

    public function edit(NewsArticle $news_article)
    {
        return view('admin.news.edit', ['article' => $news_article]);
    }

    public function update(UpdateNewsArticleRequest $request, NewsArticle $news_article)
    {
        $news_article->title = [
            'en' => $request->input('title.en'),
            'ar' => $request->input('title.ar'),
        ];
        $news_article->description = [
            'en' => $request->input('description.en'),
            'ar' => $request->input('description.ar'),
        ];
        $news_article->date = $request->input('date') ?: null;
        $news_article->is_published = $request->boolean('is_published');

        if ($request->filled('slug')) {
            $news_article->slug = Str::slug($request->input('slug'));
        }

        if ($request->hasFile('image')) {
            $this->deleteImage($news_article->image_path);
            $news_article->image_path = $this->storeImage($request->file('image'));
        }

        $news_article->save();

        return redirect()
            ->route('admin.news-articles.index')
            ->with('ok', __('Article updated.'));
    }

    public function destroy(NewsArticle $news_article)
    {
        $this->deleteImage($news_article->image_path);
        $news_article->delete();

        return redirect()
            ->route('admin.news-articles.index')
            ->with('ok', __('Article deleted.'));
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'orders' => ['required', 'array'],
            'orders.*.id' => ['required', 'integer', 'exists:news_articles,id'],
            'orders.*.sort_order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($validated['orders'] as $order) {
            NewsArticle::whereKey($order['id'])->update([
                'sort_order' => $order['sort_order'],
            ]);
        }

        return response()->json(['ok' => true]);
    }

    private function storeImage($file): string
    {
        $directory = public_path('content-images/news');

        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $name = 'article-' . Str::random(12) . '.' . $extension;
        $file->move($directory, $name);

        return 'content-images/news/' . $name;
    }

    private function deleteImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        $fullPath = public_path($path);
        if (File::isFile($fullPath)) {
            File::delete($fullPath);
        }
    }
}
