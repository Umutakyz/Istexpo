<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'videos.*' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        if ($request->hasFile('videos')) {
            $videoPaths = [];
            foreach ($request->file('videos') as $video) {
                $videoPaths[] = $video->store('news/videos', 'public');
            }
            $data['videos'] = $videoPaths;
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Haber başarıyla oluşturuldu.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'videos.*' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($news->image) Storage::disk('public')->delete($news->image);
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        if ($request->hasFile('videos')) {
            // Delete old videos
            if ($news->videos) {
                foreach ($news->videos as $oldVideo) {
                    Storage::disk('public')->delete($oldVideo);
                }
            }
            $videoPaths = [];
            foreach ($request->file('videos') as $video) {
                $videoPaths[] = $video->store('news/videos', 'public');
            }
            $data['videos'] = $videoPaths;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Haber başarıyla güncellendi.');
    }

    public function destroy(News $news)
    {
        if ($news->image) Storage::disk('public')->delete($news->image);
        if ($news->videos) {
            foreach ($news->videos as $video) {
                Storage::disk('public')->delete($video);
            }
        }
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Haber başarıyla silindi.');
    }
}
