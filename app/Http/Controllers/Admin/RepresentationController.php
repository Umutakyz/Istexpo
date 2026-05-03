<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Representation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RepresentationController extends Controller
{
    public function index()
    {
        $representations = Representation::orderBy('order')->get();
        return view('admin.representations.index', compact('representations'));
    }

    public function create()
    {
        return view('admin.representations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('representations', 'public');
        }

        Representation::create($data);

        return redirect()->route('admin.representations.index')->with('success', 'Representation created successfully.');
    }

    public function edit(Representation $representation)
    {
        return view('admin.representations.edit', compact('representation'));
    }

    public function update(Request $request, Representation $representation)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($representation->logo) {
                Storage::disk('public')->delete($representation->logo);
            }
            $data['logo'] = $request->file('logo')->store('representations', 'public');
        }

        $representation->update($data);

        return redirect()->route('admin.representations.index')->with('success', 'Representation updated successfully.');
    }

    public function destroy(Representation $representation)
    {
        if ($representation->logo) {
            Storage::disk('public')->delete($representation->logo);
        }
        $representation->delete();

        return redirect()->route('admin.representations.index')->with('success', 'Representation deleted successfully.');
    }
}
