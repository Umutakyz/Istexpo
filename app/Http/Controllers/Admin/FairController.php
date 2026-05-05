<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fair;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FairController extends Controller
{
    public function index()
    {
        $fairs = Fair::latest()->paginate(10);
        return view('admin.fairs.index', compact('fairs'));
    }

    public function featured()
    {
        $fairs = Fair::where('is_featured', true)->orderBy('start_date', 'asc')->paginate(10);
        return view('admin.fairs.featured', compact('fairs'));
    }

    public function unfeature(Fair $fair)
    {
        $fair->update(['is_featured' => false]);
        return back()->with('success', 'Fuar başarıyla anasayfadan kaldırıldı.');
    }

    public function create()
    {
        return view('admin.fairs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:international,past',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'subject' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'edition' => 'nullable|string|max:255',
            'grant_amount' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'exhibitor_profile' => 'nullable|string',
        ]);

        $data = $request->all();
        $slug = Str::slug($request->name);
        $count = Fair::where('slug', 'LIKE', "{$slug}%")->count();
        $data['slug'] = $count > 0 ? "{$slug}-" . ($count + 1) : $slug;
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('fairs', 'public');
        }

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('fairs', 'public');
            }
            $data['images'] = $images;
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('fairs/logos', 'public');
        }

        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('videos', 'public');
        }

        Fair::create($data);

        return redirect()->route('admin.fairs.index')->with('success', 'Fuar başarıyla oluşturuldu.');
    }

    public function edit(Fair $fair)
    {
        return view('admin.fairs.edit', compact('fair'));
    }

    public function update(Request $request, Fair $fair)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:international,past',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'subject' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'edition' => 'nullable|string|max:255',
            'grant_amount' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'exhibitor_profile' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');

        if ($fair->name !== $request->name) {
            $slug = Str::slug($request->name);
            $count = Fair::where('slug', 'LIKE', "{$slug}%")->where('id', '!=', $fair->id)->count();
            $data['slug'] = $count > 0 ? "{$slug}-" . ($count + 1) : $slug;
        } else {
            unset($data['slug']);
        }

        if ($request->hasFile('image')) {
            if ($fair->image) Storage::disk('public')->delete($fair->image);
            $data['image'] = $request->file('image')->store('fairs', 'public');
        }

        $currentImages = $fair->images ?? [];

        // Remove selected images
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imgToRemove) {
                if (Storage::disk('public')->exists($imgToRemove)) {
                    Storage::disk('public')->delete($imgToRemove);
                }
                $currentImages = array_filter($currentImages, function($img) use ($imgToRemove) {
                    return $img !== $imgToRemove;
                });
            }
            $currentImages = array_values($currentImages); // Reset keys
        }

        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $currentImages[] = $file->store('fairs', 'public');
            }
        }

        $data['images'] = $currentImages;

        if ($request->hasFile('logo')) {
            if ($fair->logo) Storage::disk('public')->delete($fair->logo);
            $data['logo'] = $request->file('logo')->store('fairs/logos', 'public');
        }

        if ($request->hasFile('video')) {
            if ($fair->video) Storage::disk('public')->delete($fair->video);
            $data['video'] = $request->file('video')->store('videos', 'public');
        }

        $fair->update($data);

        return redirect()->route('admin.fairs.index')->with('success', 'Fuar başarıyla güncellendi.');
    }

    public function destroy(Fair $fair)
    {
        if ($fair->image) Storage::disk('public')->delete($fair->image);
        if ($fair->video) Storage::disk('public')->delete($fair->video);
        $fair->delete();
        return redirect()->route('admin.fairs.index')->with('success', 'Fuar başarıyla silindi.');
    }
}
