<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Category;
use App\Http\Requests\Admin\PropertyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with(['category', 'images'])->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location_text', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $properties = $query->paginate(15);
        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.properties.create', compact('categories'));
    }

    public function store(PropertyRequest $request)
    {

  

        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['featured'] = $request->boolean('featured');
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(6);

        $property = Property::create($data);

        $this->handleImageUploads($request, $property);

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property created successfully.');
    }

    public function edit(Property $property)
    {
        $categories = Category::all();
        $property->load('images');
        return view('admin.properties.edit', compact('property', 'categories'));
    }

    public function update(PropertyRequest $request, Property $property)
    {
        $data = $request->validated();
        $data['featured'] = $request->boolean('featured');
        $property->update($data);

        $this->handleImageUploads($request, $property);

        // Handle image deletions
        if ($request->filled('delete_images')) {
            $imageIds = explode(',', $request->delete_images);
            $images = PropertyImage::whereIn('id', $imageIds)->where('property_id', $property->id)->get();
            foreach ($images as $image) {
                $disk = $image->disk ?? 'public';
                Storage::disk($disk)->delete($image->image_path);
                $image->delete();
            }
        }

        // Handle sort order update
        if ($request->filled('image_order')) {
            $order = json_decode($request->image_order, true);
            foreach ($order as $item) {
                PropertyImage::where('id', $item['id'])->where('property_id', $property->id)
                    ->update(['sort_order' => $item['order']]);
            }
        }

        return redirect()->route('admin.properties.edit', $property)
            ->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        foreach ($property->images as $image) {
            $disk = $image->disk ?? 'public';
            Storage::disk($disk)->delete($image->image_path);
        }
        $property->delete();
        return redirect()->route('admin.properties.index')->with('success', 'Property deleted.');
    }

    private function handleImageUploads(Request $request, Property $property): void
    {
        if (!$request->hasFile('images')) return;

        $isPrimarySet = $property->images()->where('is_primary', true)->exists();
        $sortOrder = $property->images()->max('sort_order') ?? -1;

        // Use 'uploads' disk: stores directly in public/uploads/ — no symlink needed.
        // This ensures images display on cPanel shared hosting and VPS alike.
        foreach ($request->file('images') as $file) {
            $path = $file->store('properties', 'uploads');
            $sortOrder++;
            PropertyImage::create([
                'property_id' => $property->id,
                'image_path'  => $path,
                'disk'        => 'uploads',
                'is_primary'  => !$isPrimarySet,
                'sort_order'  => $sortOrder,
            ]);
            $isPrimarySet = true;
        }
    }

    public function setPrimary(Request $request, Property $property)
    {
        PropertyImage::where('property_id', $property->id)->update(['is_primary' => false]);
        PropertyImage::where('id', $request->image_id)->where('property_id', $property->id)
            ->update(['is_primary' => true]);
        return response()->json(['success' => true]);
    }
}
