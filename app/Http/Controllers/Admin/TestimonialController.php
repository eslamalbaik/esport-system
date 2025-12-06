<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::ordered()->paginate(20);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(StoreTestimonialRequest $request)
    {
        $data = $this->extractTranslatableData($request->validated(), $request);
        $data['sort_order'] = (Testimonial::max('sort_order') ?? 0) + 1;

        if ($request->hasFile('avatar')) {
            $data['avatar_path'] = $this->storeAvatar($request->file('avatar'));
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('ok', __('Testimonial created.'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', ['testimonial' => $testimonial]);
    }

    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        $data = $this->extractTranslatableData($request->validated(), $request);

        if ($request->hasFile('avatar')) {
            $this->deleteAvatar($testimonial->avatar_path);
            $data['avatar_path'] = $this->storeAvatar($request->file('avatar'));
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('ok', __('Testimonial updated.'));
    }

    public function destroy(Testimonial $testimonial)
    {
        $this->deleteAvatar($testimonial->avatar_path);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('ok', __('Testimonial deleted.'));
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'orders' => ['required', 'array'],
            'orders.*.id' => ['required', 'integer', 'exists:testimonials,id'],
            'orders.*.sort_order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($validated['orders'] as $order) {
            Testimonial::whereKey($order['id'])->update([
                'sort_order' => $order['sort_order'],
            ]);
        }

        return response()->json(['ok' => true]);
    }

    private function extractTranslatableData(array $data, Request $request): array
    {
        $data['name'] = [
            'en' => $request->input('name.en'),
            'ar' => $request->input('name.ar'),
        ];

        $data['role'] = [
            'en' => $request->input('role.en'),
            'ar' => $request->input('role.ar'),
        ];

        $data['text'] = [
            'en' => $request->input('text.en'),
            'ar' => $request->input('text.ar'),
        ];

        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }

    private function storeAvatar($file): string
    {
        $directory = public_path('content-images/testimonials');

        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'png');
        $name = 'testimonial-' . Str::random(12) . '.' . $extension;
        $file->move($directory, $name);

        return 'content-images/testimonials/' . $name;
    }

    private function deleteAvatar(?string $path): void
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
