<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Fair;
use App\Models\Service;
use App\Models\Representation;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $representations = Representation::orderBy('order')->get();
        return view('welcome', compact('representations'));
    }

    public function fairs(Request $request)
    {
        $query = Fair::latest();
        
        $internationalFairs = (clone $query)->where('type', 'international')->paginate(12, ['*'], 'uluslararasi_sayfa');
        $pastFairs = (clone $query)->where('type', 'past')->paginate(12, ['*'], 'gecmis_sayfa');

        return view('pages.fairs', compact('internationalFairs', 'pastFairs'));
    }

    public function fairShow($slug)
    {
        $fair = Fair::where('slug', $slug)->firstOrFail();
        return view('pages.fair-details', compact('fair'));
    }



    public function services()
    {
        $services = Service::all();
        return view('pages.services', compact('services'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function representations()
    {
        $representations = Representation::orderBy('order')->get();
        return view('pages.representations', compact('representations'));
    }

    public function supports()
    {
        return view('pages.supports');
    }

    public function news()
    {
        $news = \App\Models\News::where('is_active', true)->latest()->paginate(9);
        return view('pages.news', compact('news'));
    }

    public function newsShow($slug)
    {
        $item = \App\Models\News::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $related = \App\Models\News::where('is_active', true)->where('id', '!=', $item->id)->latest()->limit(3)->get();
        return view('pages.news-detail', compact('item', 'related'));
    }

    public function kvkk()
    {
        return view('pages.kvkk');
    }

    public function contactSend(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:200',
            'email'   => 'required|email|max:200',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:5000',
        ]);

        // messages tablosuna kaydet
        Message::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->route('contact')
            ->with('success', __('Your message has been sent. We will get back to you shortly.'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (!$query) {
            return redirect()->back();
        }

        $fairs = Fair::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        $services = Service::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        $news = \App\Models\News::where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->get();

        return view('pages.search', compact('fairs', 'services', 'news', 'query'));
    }
}
