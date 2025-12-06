<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;

class GalleryController extends Controller
{
    public function index()
    {
        $items = GalleryItem::published()->ordered()->paginate(9);

        return view('site.gallery', compact('items'));
    }

    public function show(GalleryItem $item)
    {
        if (!$item->is_published) {
            abort(404);
        }

        return view('site.gallery_show', compact('item'));
    }
}
