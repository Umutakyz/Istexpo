@extends('layouts.app')

@section('title', $item->title_loc . ' — ISTexpo')
@section('meta_description', Str::limit(strip_tags($item->summary_loc ?: $item->content_loc), 160))

@section('content')

{{-- Hero / Page Header --}}
<section style="background: linear-gradient(135deg, var(--ink) 0%, #001f35 100%); color: #fff; padding: 80px 0 60px;">
    <div class="wrap">
        <a href="{{ route('news') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--yellow); font-size: 14px; font-weight: 700; text-decoration: none; margin-bottom: 24px; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            {{ __('Back to News') }}
        </a>
        <div class="eyebrow" style="color: var(--yellow); border-color: var(--yellow); margin-bottom: 16px;">{{ __('Media Center') }}</div>
        <h1 style="font-size: clamp(24px, 3.5vw, 42px); font-weight: 800; line-height: 1.2; max-width: 900px; margin: 0 0 24px; letter-spacing: -0.02em;">
            {{ $item->title_loc }}
        </h1>
        <div style="font-size: 14px; color: rgba(255,255,255,0.6); display: flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            {{ $item->created_at->format('d M Y') }}
        </div>
    </div>
</section>

{{-- Featured Image --}}
@if($item->image)
<div class="wrap" style="margin-top: 40px; margin-bottom: 40px;">
    <div style="border-radius: 16px; overflow: hidden; background: #fff; border: 1px solid var(--line); display: flex; justify-content: center; align-items: center; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title_loc }}"
             style="max-width: 100%; max-height: 400px; object-fit: contain; display: block;">
    </div>
</div>
@endif

{{-- Content --}}
<section style="padding: 20px 0 100px;">
    <div class="wrap">
        <div class="news-detail-grid" style="display: grid; grid-template-columns: 1fr 340px; gap: 80px; align-items: start;">

            {{-- Article Body --}}
            <article style="min-width: 0;">
                <div class="news-content" style="
                    font-size: 17px;
                    line-height: 1.8;
                    color: var(--ink);
                    max-width: 720px;
                ">
                    @if($item->content_loc)
                        {!! $item->content_loc !!}
                    @else
                        <p style="color: var(--muted);">{{ __('Content not available.') }}</p>
                    @endif
                </div>

                {{-- Share --}}
                <div style="margin-top: 60px; padding-top: 40px; border-top: 1px solid var(--line); display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 14px; font-weight: 700; color: var(--muted);">{{ __('Share:') }}</span>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($item->title_loc) }}"
                       target="_blank" rel="noopener"
                       style="background: #000; color: #fff; width: 38px; height: 38px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.742l7.73-8.835L1.254 2.25H8.08l4.259 5.632 5.905-5.632zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(url()->current()) }}&title={{ urlencode($item->title_loc) }}"
                       target="_blank" rel="noopener"
                       style="background: #0077b5; color: #fff; width: 38px; height: 38px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       target="_blank" rel="noopener"
                       style="background: #1877f2; color: #fff; width: 38px; height: 38px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                </div>
            </article>

            {{-- Sidebar --}}
            <aside>
                <div style="background: var(--bg-2); border-radius: 24px; padding: 40px; position: sticky; top: 120px;">
                    <h4 style="font-size: 16px; font-weight: 800; margin-bottom: 32px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted);">
                        {{ __('Related News') }}
                    </h4>
                    @foreach($related as $rel)
                    <a href="{{ route('news.show', $rel->slug) }}" style="display: block; text-decoration: none; margin-bottom: 28px; padding-bottom: 28px; border-bottom: 1px solid var(--line);">
                        @if($rel->image)
                            <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->title_loc }}"
                                 style="width: 100%; height: 140px; object-fit: cover; border-radius: 12px; margin-bottom: 14px;">
                        @else
                            <div style="width: 100%; height: 100px; background: var(--bg-3); border-radius: 12px; margin-bottom: 14px; display: grid; place-items: center;">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                                </svg>
                            </div>
                        @endif
                        <div style="font-size: 11px; color: var(--muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">
                            {{ $rel->created_at->format('d M Y') }}
                        </div>
                        <div style="font-size: 14px; font-weight: 700; color: var(--ink); line-height: 1.4; transition: color 0.2s;"
                             onmouseover="this.style.color='var(--brand)'" onmouseout="this.style.color='var(--ink)'">
                            {{ Str::limit($rel->title_loc, 70) }}
                        </div>
                    </a>
                    @endforeach

                    <a href="{{ route('news') }}" class="btn btn-primary" style="width: 100%; text-align: center;">
                        {{ __('All News') }} →
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section>

<style>
.news-content p { margin-bottom: 1.5em; }
.news-content img { max-width: 100%; height: auto; border-radius: 12px; margin: 20px 0; }
.news-content h1, .news-content h2, .news-content h3, .news-content h4 {
    margin: 1.5em 0 0.75em; font-weight: 800; color: var(--ink);
}
.news-content a { color: var(--brand); text-decoration: underline; }
.news-content ul, .news-content ol { margin: 1em 0 1em 1.5em; }
.news-content li { margin-bottom: 0.5em; }
.news-content table { width: 100%; border-collapse: collapse; margin: 1.5em 0; }
.news-content td, .news-content th { border: 1px solid var(--line); padding: 10px 14px; }

@media (max-width: 900px) {
    .news-detail-grid { grid-template-columns: 1fr !important; }
    aside { display: none; }
}
</style>
@endsection
