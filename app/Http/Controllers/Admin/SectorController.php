<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SectorController extends Controller
{
    public function index()
    {
        $sectors = Sector::latest()->paginate(10);
        return view('admin.sectors.index', compact('sectors'));
    }

    public function create()
    {
        return view('admin.sectors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sectors', 'public');
        }

        Sector::create($data);

        return redirect()->route('admin.sectors.index')->with('success', 'Sektör başarıyla oluşturuldu.');
    }

    public function edit(Sector $sector)
    {
        return view('admin.sectors.edit', compact('sector'));
    }

    public function update(Request $request, Sector $sector)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($sector->image) Storage::disk('public')->delete($sector->image);
            $data['image'] = $request->file('image')->store('sectors', 'public');
        }

        $sector->update($data);

        return redirect()->route('admin.sectors.index')->with('success', 'Sektör başarıyla güncellendi.');
    }

    public function destroy(Sector $sector)
    {
        if ($sector->image) Storage::disk('public')->delete($sector->image);
        $sector->delete();
        return redirect()->route('admin.sectors.index')->with('success', 'Sektör başarıyla silindi.');
    }
}
