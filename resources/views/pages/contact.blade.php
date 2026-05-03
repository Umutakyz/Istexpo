@extends('layouts.app')

@section('title', __('Contact Us') . ' — ISTexpo')

@section('content')
<section class="page-header" style="background: linear-gradient(rgba(0,43,73,0.85), rgba(0,43,73,0.85)), url('/img/cover-images/cover-main.png') center/cover; color: #fff; padding: 120px 0 80px;">
    <div class="wrap">
        <div class="eyebrow" style="color: var(--yellow); border-color: var(--yellow);">{{ __('Connect') }}</div>
        <h1 class="page-title">
            {{ __('Get in') }}
            <span class="script" style="color: var(--yellow);">{{ __('Touch') }}</span>
        </h1>
        <p style="font-size: 20px; color: rgba(255,255,255,0.7); max-width: 600px;">{{ __('Our team is here to help you navigate the world of global exhibitions.') }}</p>
    </div>
</section>

<section>
    <div class="wrap">
        <div class="grid-contact">
            <div>
                <div style="margin-bottom: 48px;">
                    <h3 style="font-size: 24px; font-weight: 800; margin-bottom: 16px;">{{ __('Istanbul Office') }}</h3>
                    <p style="color: var(--muted); line-height: 1.6;">Levent, Büyükdere Cd. No:123<br>34394 Şişli/İstanbul, Turkey</p>
                </div>
                <div style="margin-bottom: 48px;">
                    <h3 style="font-size: 24px; font-weight: 800; margin-bottom: 16px;">{{ __('Contact Details') }}</h3>
                    @php
                        $contactEmails = \App\Models\Setting::get('contact_emails', ['info@istexpo.com']);
                        $contactPhones = \App\Models\Setting::get('contact_phones', ['+90 (212) 000 00 00']);
                        if (!is_array($contactEmails)) $contactEmails = [$contactEmails];
                        if (!is_array($contactPhones)) $contactPhones = [$contactPhones];
                    @endphp
                    <p style="color: var(--muted); line-height: 2;">
                        @foreach($contactEmails as $email)
                            <a href="mailto:{{ $email }}" style="display:block; color: var(--brand); font-weight:600;">{{ $email }}</a>
                        @endforeach
                        @foreach($contactPhones as $phone)
                            <a href="tel:{{ preg_replace('/[^+0-9]/', '', $phone) }}" style="display:block; color: var(--muted);">{{ $phone }}</a>
                        @endforeach
                    </p>
                </div>
                <div>
                    @php
                        $facebook  = \App\Models\Setting::get('social_facebook', '');
                        $instagram = \App\Models\Setting::get('social_instagram', '');
                        $linkedin  = \App\Models\Setting::get('social_linkedin', '');
                    @endphp
                    <h3 style="font-size: 24px; font-weight: 800; margin-bottom: 16px;">{{ __('Social') }}</h3>
                    <div style="display: flex; gap: 24px; flex-wrap: wrap;">
                        @if($linkedin)
                            <a href="{{ $linkedin }}" target="_blank" style="font-weight: 700; color: var(--brand);">LinkedIn</a>
                        @endif
                        @if($instagram)
                            <a href="{{ $instagram }}" target="_blank" style="font-weight: 700; color: var(--brand);">Instagram</a>
                        @endif
                        @if($facebook)
                            <a href="{{ $facebook }}" target="_blank" style="font-weight: 700; color: var(--brand);">Facebook</a>
                        @endif
                        @if(!$linkedin && !$instagram && !$facebook)
                            <span style="color: var(--muted);">—</span>
                        @endif
                    </div>
                </div>
            </div>

            <div style="background: #fff; padding: 60px; border-radius: 32px; border: 1px solid var(--line); box-shadow: var(--shadow-soft);">
                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    @if(session('success'))
                        <div style="background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
                            ✓ {{ session('success') }}
                        </div>
                    @endif
                    <div class="grid-2" style="margin-bottom: 24px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px; text-transform: uppercase;">{{ __('Full Name') }}</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('John Doe') }}" style="width: 100%; padding: 16px; border: 1px solid var(--line); border-radius: 12px; outline: none; font-family: inherit;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px; text-transform: uppercase;">{{ __('Email Address') }}</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('john@example.com') }}" style="width: 100%; padding: 16px; border: 1px solid var(--line); border-radius: 12px; outline: none; font-family: inherit;">
                        </div>
                    </div>
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px; text-transform: uppercase;">{{ __('Subject') }}</label>
                        <select name="subject" style="width: 100%; padding: 16px; border: 1px solid var(--line); border-radius: 12px; outline: none; font-family: inherit;">
                            <option>{{ __('Exhibitor Inquiry') }}</option>
                            <option>{{ __('Visitor Inquiry') }}</option>
                            <option>{{ __('Partnership') }}</option>
                            <option>{{ __('Other') }}</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 40px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px; text-transform: uppercase;">{{ __('Message') }}</label>
                        <textarea name="message" rows="5" placeholder="{{ __('How can we help you?') }}" style="width: 100%; padding: 16px; border: 1px solid var(--line); border-radius: 12px; outline: none; resize: none; font-family: inherit;">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 20px; font-family: inherit; cursor: pointer; border: none;">{{ __('Send Message') }}</button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- Google Harita Bölümü --}}
@php $mapEmbed = \App\Models\Setting::get('map_embed_url', ''); @endphp
@if($mapEmbed)
<section style="padding: 0 0 100px;">
    <div class="wrap">
        <div style="border-radius: 28px; overflow: hidden; border: 1px solid var(--line); box-shadow: var(--shadow-soft); aspect-ratio: 16/5; min-height: 380px;">
            <iframe
                src="{{ $mapEmbed }}"
                width="100%"
                height="100%"
                style="border:0; display:block;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="ISTexpo Konum"
            ></iframe>
        </div>
    </div>
</section>
@endif

@endsection
