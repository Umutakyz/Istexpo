@extends('layouts.app')

@section('title', __('Search Results') . ' — ISTexpo')

@section('content')
<section class="page-header" style="background: linear-gradient(rgba(0,43,73,0.85), rgba(0,43,73,0.85)), url('/img/cover-images/cover-main.png') center/cover; color: #fff; padding: 120px 0 80px;">
    <div class="wrap">
        <div class="eyebrow" style="color: var(--yellow); border-color: var(--yellow);">{{ __('Search Results') }}</div>
        <h1 style="font-size: clamp(32px, 5vw, 64px); line-height: 1.1; letter-spacing: -0.04em; margin-bottom: 24px;">
            {{ __('results for :query', ['query' => $query]) }}
        </h1>
    </div>
</section>

<section>
    <div class="wrap">
        @if($fairs->isEmpty() && $services->isEmpty() && $news->isEmpty())
            <div style="text-align: center; padding: 120px 0;">
                <div style="width: 80px; height: 80px; background: rgba(0,43,73,0.05); border-radius: 50%; display: grid; place-items: center; margin: 0 auto 32px;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
                <h2 style="font-size: 32px; font-weight: 800; color: var(--brand); margin-bottom: 16px;">{{ __('No results found.') }}</h2>
                <p style="color: var(--muted); font-size: 18px; margin-bottom: 40px; max-width: 500px; margin-left: auto; margin-right: auto;">
                    {{ __('We couldn\'t find anything matching your search. Try different keywords or browse our upcoming exhibitions.') }}
                </p>
                <a href="{{ route('home') }}" class="btn btn-primary" style="padding: 16px 40px;">{{ __('Back to Home') }}</a>
            </div>
        @else
            @if($fairs->isNotEmpty())
                <div style="margin-bottom: 80px;">
                    <h2 class="section-title" style="margin-bottom: 40px;">{{ __('Fairs') }}</h2>
                    <div class="grid-3">
                        @foreach($fairs as $fair)
                            <div class="card">
                                <div class="card-img">
                                    <img src="{{ asset('storage/' . $fair->image) }}" alt="{{ $fair->name }}">
                                </div>
                                <div class="card-body">
                                    <h3 class="card-title">{{ $fair->name_loc }}</h3>
                                    <p class="card-text">{{ Str::limit($fair->description_loc, 100) }}</p>
                                    <a href="{{ route('fairs.show', $fair->slug) }}" class="card-link">{{ __('Details') }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($services->isNotEmpty())
                <div style="margin-bottom: 80px;">
                    <h2 class="section-title" style="margin-bottom: 40px;">{{ __('Services') }}</h2>
                    <div class="grid-3">
                        @foreach($services as $service)
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">{{ $service->name_loc }}</h3>
                                    <p class="card-text">{{ Str::limit($service->description_loc, 100) }}</p>
                                    <a href="{{ route('services') }}" class="card-link">{{ __('Learn More') }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($news->isNotEmpty())
                <div style="margin-bottom: 80px;">
                    <h2 class="section-title" style="margin-bottom: 40px;">{{ __('News') }}</h2>
                    <div class="grid-3">
                        @foreach($news as $item)
                            <div class="card">
                                <div class="card-img">
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title_loc }}">
                                </div>
                                <div class="card-body">
                                    <h3 class="card-title">{{ $item->title_loc }}</h3>
                                    <p class="card-text">{{ Str::limit(strip_tags($item->content_loc), 100) }}</p>
                                    <a href="{{ route('news.show', $item->slug) }}" class="card-link">{{ __('Read More') }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>
</section>
@endsection
