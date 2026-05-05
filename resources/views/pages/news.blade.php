@extends('layouts.app')

@section('title', __('News') . ' — ISTexpo')

@section('content')
<section class="page-header" style="background: linear-gradient(rgba(0,43,73,0.85), rgba(0,43,73,0.85)), url('/img/cover-images/cover-main.png') center/cover; color: #fff; ">
    <div class="wrap">
        <div class="eyebrow" style="color: var(--yellow); border-color: var(--yellow);">{{ __('Media Center') }}</div>
        <h1 class="page-title">{{ __('Latest') }} <span class="script" style="color: var(--yellow);">{{ __('News') }}</span></h1>
        <p style="font-size: 20px; color: rgba(255,255,255,0.7); max-width: 600px;">{{ __('Stay updated with the latest trends and announcements from the world of global exhibitions.') }}</p>
    </div>
</section>

<section>
    <div class="wrap">
        <div class="grid-3">
            @forelse ($news as $item)
            <div class="card" style="cursor: pointer;" onclick="window.location='{{ route('news.show', $item->slug) }}'">
                <div class="card-img" style="background: #f8f9fa; overflow: hidden;">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                             style="width: 100%; height: 250px; object-fit: cover; transition: transform 0.4s ease;">
                    @else
                        <div style="width: 100%; height: 250px; display: grid; place-items: center; background: rgba(0,43,73,0.05);">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div style="font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px;">
                        {{ $item->created_at->format('d') }} {{ __($item->created_at->format('M')) }} {{ $item->created_at->format('Y') }}
                    </div>
                    <h3 class="card-title" style="font-size: 18px; line-height: 1.4;">{{ $item->title_loc }}</h3>
                    <p class="card-text">{{ Str::limit(html_entity_decode(strip_tags($item->summary_loc ?: $item->content_loc)), 120) }}</p>
                    <a href="{{ route('news.show', $item->slug) }}" class="card-link">{{ __('Read More') }} →</a>
                </div>
            </div>
            @empty
                <div style="grid-column: span 3; text-align: center; padding: 80px 0; color: var(--muted);">
                    <p style="font-size: 18px;">{{ __('Henüz haber eklenmemiş.') }}</p>
                </div>
            @endforelse
        </div>

        @if($news->hasPages())
        <div style="margin-top: 60px;">
            {{ $news->links() }}
        </div>
        @endif
    </div>
</section>

<style>
.card:hover .card-img img { transform: scale(1.05); }
</style>
@endsection
