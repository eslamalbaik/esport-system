<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryItemRequest;
use App\Http\Requests\UpdateGalleryItemRequest;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GalleryItemController extends Controller
{
    public function index()
    {
        $items = GalleryItem::ordered()->get();

        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(StoreGalleryItemRequest $request)
    {
        $data = $request->validated();

        $item = new GalleryItem();
        $item->title = [
            'en' => $request->input('title.en'),
            'ar' => $request->input('title.ar'),
        ];
        $item->description = [
            'en' => $request->input('description.en'),
            'ar' => $request->input('description.ar'),
        ];
        $item->slug = $data['slug'] ?? null;
        $item->video_type = $request->input('video_type');
        $item->video_url = null;
        $item->video_path = null;
        $item->thumb_path = null;
        $item->is_published = $request->boolean('is_published');
        $item->sort_order = $request->input('sort_order') ?? ((GalleryItem::max('sort_order') ?? 0) + 1);
        $item->published_at = $request->input('published_at') ?: null;

        if ($item->video_type === GalleryItem::VIDEO_TYPE_FILE) {
            $item->video_path = $this->storeUploadedImage($request->file('video_file'));
        } else {
            $item->video_url = $request->input('video_url');
        }

        if ($request->hasFile('thumb')) {
            $item->thumb_path = $this->storeThumbnail($request->file('thumb'));
        }

        $item->save();

        return redirect()
            ->route('admin.gallery-items.index')
            ->with('ok', __('Gallery item created.'));
    }

    public function edit(GalleryItem $gallery_item)
    {
        return view('admin.gallery.edit', ['item' => $gallery_item]);
    }

    public function update(UpdateGalleryItemRequest $request, GalleryItem $gallery_item)
    {
        $data = $request->validated();

        $gallery_item->title = [
            'en' => $request->input('title.en'),
            'ar' => $request->input('title.ar'),
        ];
        $gallery_item->description = [
            'en' => $request->input('description.en'),
            'ar' => $request->input('description.ar'),
        ];
        $gallery_item->slug = $data['slug'] ?? $gallery_item->slug;
        $gallery_item->video_type = $request->input('video_type');
        $gallery_item->is_published = $request->boolean('is_published', $gallery_item->is_published);
        $gallery_item->sort_order = $request->input('sort_order', $gallery_item->sort_order);
        $gallery_item->published_at = $request->input('published_at') ?: null;

        if ($gallery_item->video_type === GalleryItem::VIDEO_TYPE_FILE) {
            if ($request->hasFile('video_file')) {
                $this->deleteUploadedImage($gallery_item->video_path);
                $gallery_item->video_path = $this->storeUploadedImage($request->file('video_file'));
            }
            $gallery_item->video_url = null;
        } else {
            if ($gallery_item->video_path) {
                $this->deleteUploadedImage($gallery_item->video_path);
                $gallery_item->video_path = null;
            }
            $gallery_item->video_url = $request->input('video_url');
        }

        if ($request->hasFile('thumb')) {
            $this->deleteThumbnail($gallery_item->thumb_path);
            $gallery_item->thumb_path = $this->storeThumbnail($request->file('thumb'));
        }

        $gallery_item->save();

        return redirect()
            ->route('admin.gallery-items.index')
            ->with('ok', __('Gallery item updated.'));
    }

    public function destroy(GalleryItem $gallery_item)
    {
        $this->deleteThumbnail($gallery_item->thumb_path);
        $this->deleteUploadedImage($gallery_item->video_path);
        $gallery_item->delete();

        return redirect()
            ->route('admin.gallery-items.index')
            ->with('ok', __('Gallery item deleted.'));
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'orders' => ['required', 'array'],
            'orders.*.id' => ['required', 'integer', 'exists:gallery_items,id'],
            'orders.*.sort_order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($validated['orders'] as $order) {
            GalleryItem::whereKey($order['id'])->update([
                'sort_order' => $order['sort_order'],
            ]);
        }

        return response()->json(['ok' => true]);
    }

    private function storeThumbnail($file): string
    {
        $directory = public_path('content-images/gallery');

        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $name = 'thumb-' . Str::random(12) . '.' . $extension;
        $file->move($directory, $name);

        return 'content-images/gallery/' . $name;
    }

    private function storeUploadedImage($file): string
    {
        $directory = public_path('content-images/gallery');

        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $name = 'upload-' . Str::random(16) . '.' . $extension;
        $file->move($directory, $name);

        return 'content-images/gallery/' . $name;
    }

    private function deleteThumbnail(?string $path): void
    {
        if (!$path) {
            return;
        }

        $fullPath = public_path($path);
        if (File::isFile($fullPath)) {
            File::delete($fullPath);
        }
    }

    private function deleteUploadedImage(?string $path): void
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
