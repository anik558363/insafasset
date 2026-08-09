<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'designation' => ['nullable', 'string', 'max:100'],
            'message'     => ['required', 'string'],
            'rating'      => ['required', 'integer', 'min:1', 'max:5'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $data = $request->only(['name', 'designation', 'message', 'rating']);

        if ($request->hasFile('image')) {
            // 'uploads' disk stores directly in public/uploads/ — no symlink, cPanel safe.
            $data['image'] = $request->file('image')->store('testimonials', 'uploads');
        }

        Testimonial::create($data);
        return back()->with('success', 'Testimonial added.');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'designation' => ['nullable', 'string', 'max:100'],
            'message'     => ['required', 'string'],
            'rating'      => ['required', 'integer', 'min:1', 'max:5'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $data = $request->only(['name', 'designation', 'message', 'rating']);

        if ($request->hasFile('image')) {
            $this->deleteImageFile($testimonial->image);
            $data['image'] = $request->file('image')->store('testimonials', 'uploads');
        }

        $testimonial->update($data);
        return back()->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $this->deleteImageFile($testimonial->image);
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted.');
    }

    /**
     * Delete a stored testimonial image from whichever disk physically holds it.
     * Handles records created before the migration to the 'uploads' disk.
     */
    private function deleteImageFile(?string $path): void
    {
        if (!$path) {
            return;
        }
        foreach (['uploads', 'public'] as $disk) {
            if (Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
            }
        }
    }
}
