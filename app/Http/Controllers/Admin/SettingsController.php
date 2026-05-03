<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'site_title'    => Setting::get('site_title', 'ISTexpo'),
            'emails'        => Setting::get('contact_emails', ['info@istexpo.com']),
            'phones'        => Setting::get('contact_phones', ['+90 (212) 000 00 00']),
            'facebook'      => Setting::get('social_facebook', ''),
            'instagram'     => Setting::get('social_instagram', ''),
            'linkedin'      => Setting::get('social_linkedin', ''),
            'map_embed_url' => Setting::get('map_embed_url', ''),
        ];

        // Dizi olduğundan emin ol
        if (!is_array($settings['emails'])) {
            $settings['emails'] = [$settings['emails']];
        }
        if (!is_array($settings['phones'])) {
            $settings['phones'] = [$settings['phones']];
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_title'    => 'required|string|max:200',
            'emails'        => 'required|array|min:1',
            'emails.*'      => 'required|email|max:200',
            'phones'        => 'required|array|min:1',
            'phones.*'      => 'required|string|max:50',
            'map_embed_url' => 'nullable|string|max:3000',
        ]);

        // Tam <iframe> kodu yapıştırıldıysa src="..." URL'ini ayıkla
        $mapRaw = $request->input('map_embed_url', '');
        if (preg_match('/src=["\']([^"\']+)["\']/', $mapRaw, $m)) {
            $mapRaw = $m[1];
        }
        $mapRaw = trim($mapRaw);

        Setting::set('site_title',       $request->site_title);
        Setting::set('contact_emails',   array_values(array_filter($request->emails)));
        Setting::set('contact_phones',   array_values(array_filter($request->phones)));
        Setting::set('social_facebook',  $request->input('social_facebook', ''));
        Setting::set('social_instagram', $request->input('social_instagram', ''));
        Setting::set('social_linkedin',  $request->input('social_linkedin', ''));
        Setting::set('map_embed_url',    $mapRaw);

        return back()->with('success', 'Ayarlar başarıyla kaydedildi.');
    }
}
