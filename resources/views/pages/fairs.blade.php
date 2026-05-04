@extends('layouts.app')

@section('title', __('Upcoming Fairs') . ' — ISTexpo')

@section('content')
<section class="page-header" style="background: linear-gradient(rgba(0,43,73,0.85), rgba(0,43,73,0.85)), url('/img/cover-images/cover-main.png') center/cover; color: #fff; position: relative; overflow: hidden;">
    <div style="position: absolute; inset: 0; opacity: 0.1; background: url('https://images.unsplash.com/photo-1540575861501-7cf05a4b125a?auto=format&fit=crop&q=80&w=2000') center/cover;"></div>
    <div class="wrap" style="position: relative; z-index: 1;">
        <div class="eyebrow" style="color: var(--yellow); border-color: var(--yellow);">{{ __('Calendar') }}</div>
        <h1 class="page-title">{{ __('Upcoming') }} <span class="script" style="color: var(--yellow);">{{ __('Exhibitions') }}</span></h1>
        <p style="font-size: 20px; color: rgba(255,255,255,0.7); max-width: 600px;">{{ __('Explore our global portfolio of industry-leading trade shows and summits for 2026-2027.') }}</p>
    </div>
</section>

<section>
    <div class="wrap">
        @if($internationalFairs->isNotEmpty())
            <div style="margin-bottom: 80px;">
                <h2 class="section-title" style="margin-bottom: 40px; font-size: 32px;">{{ __('International Fairs') }}</h2>
                <div class="grid-4">
                    @foreach ($internationalFairs as $fair)
                    <div class="card card-compact">
                        <div class="card-img" style="position: relative; overflow: hidden;">
                            @if($fair->video)
                                <video autoplay muted loop playsinline webkit-playsinline preload="metadata" style="width: 100%; height: 180px; object-fit: cover; display: block;">
                                    <source src="{{ asset('storage/' . $fair->video) }}" type="video/mp4">
                                </video>
                            @elseif($fair->image)
                                <img src="{{ asset('storage/' . $fair->image) }}" alt="{{ $fair->name }}" style="width: 100%; height: 180px; object-fit: cover;">
                            @else
                                <svg viewBox="0 0 400 180" fill="#f0ede8"><rect width="400" height="180" fill="var(--brand)" fill-opacity="0.05"/><text x="50%" y="50%" text-anchor="middle" fill="var(--brand)" font-size="14" font-weight="700">{{ __('EVENT IMAGE') }}</text></svg>
                            @endif
                        </div>
                        <div class="card-body">

                            <h3 class="card-title">{{ $fair->name_loc }}</h3>
                            <p class="card-text">{{ Str::limit(strip_tags($fair->description_loc), 100) }}</p>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 20px; border-top: 1px solid var(--line);">
                                <div style="font-weight: 800; font-size: 12px; color: var(--muted);">
                                    @if($fair->start_date->format('m') === $fair->end_date->format('m'))
                                        {{ $fair->start_date->format('d') }}-{{ $fair->end_date->format('d') }} {{ __($fair->start_date->format('M')) }}
                                    @else
                                        {{ $fair->start_date->format('d') }} {{ __($fair->start_date->format('M')) }} - {{ $fair->end_date->format('d') }} {{ __($fair->end_date->format('M')) }}
                                    @endif
                                </div>
                                <div style="display: flex; gap: 12px; align-items: center;">
                                    <a href="{{ route('fairs.show', $fair->slug) }}" class="card-link" style="margin-bottom: 0;">{{ __('Details') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="pagination-wrapper" style="margin-top: 60px;">
                    {{ $internationalFairs->appends(request()->except('int_page'))->links() }}
                </div>
            </div>
        @endif

        @if($pastFairs->isNotEmpty())
            <div>
                <h2 class="section-title" style="margin-bottom: 40px; font-size: 32px;">{{ __('Past Fairs') }}</h2>
                <div class="grid-4">
                    @foreach ($pastFairs as $fair)
                    <div class="card card-compact">
                        <div class="card-img" style="position: relative; overflow: hidden;">
                            @if($fair->video)
                                <video autoplay muted loop playsinline webkit-playsinline preload="metadata" style="width: 100%; height: 180px; object-fit: cover; display: block;">
                                    <source src="{{ asset('storage/' . $fair->video) }}" type="video/mp4">
                                </video>
                            @elseif($fair->image)
                                <img src="{{ asset('storage/' . $fair->image) }}" alt="{{ $fair->name }}" style="width: 100%; height: 180px; object-fit: cover;">
                            @else
                                <svg viewBox="0 0 400 180" fill="#f0ede8"><rect width="400" height="180" fill="var(--brand)" fill-opacity="0.05"/><text x="50%" y="50%" text-anchor="middle" fill="var(--brand)" font-size="14" font-weight="700">{{ __('EVENT IMAGE') }}</text></svg>
                            @endif
                        </div>
                        <div class="card-body">

                            <h3 class="card-title">{{ $fair->name_loc }}</h3>
                            <p class="card-text">{{ Str::limit(strip_tags($fair->description_loc), 100) }}</p>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 20px; border-top: 1px solid var(--line);">
                                <div style="font-weight: 800; font-size: 12px; color: var(--muted);">
                                    @if($fair->start_date->format('m') === $fair->end_date->format('m'))
                                        {{ $fair->start_date->format('d') }}-{{ $fair->end_date->format('d') }} {{ __($fair->start_date->format('M')) }}
                                    @else
                                        {{ $fair->start_date->format('d') }} {{ __($fair->start_date->format('M')) }} - {{ $fair->end_date->format('d') }} {{ __($fair->end_date->format('M')) }}
                                    @endif
                                </div>
                                <div style="display: flex; gap: 12px; align-items: center;">
                                    <a href="{{ route('fairs.show', $fair->slug) }}" class="card-link" style="margin-bottom: 0;">{{ __('Details') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="pagination-wrapper" style="margin-top: 60px;">
                    {{ $pastFairs->appends(request()->except('past_page'))->links() }}
                </div>
            </div>
        @endif

        @if($internationalFairs->isEmpty() && $pastFairs->isEmpty())
            <div style="text-align: center; padding: 100px 0;">
                <h2 style="font-size: 24px; color: var(--muted);">{{ __('No fairs found.') }}</h2>
            </div>
        @endif
        <style>
            .play-overlay:hover { background: rgba(0,0,0,0.4) !important; }
        </style>
        <script>
            // Force autoplay for mobile (iOS requires user interaction in some cases)
            document.addEventListener('DOMContentLoaded', function() {
                var videos = document.querySelectorAll('video[autoplay]');
                videos.forEach(function(v) {
                    v.muted = true;
                    var p = v.play();
                    if (p !== undefined) {
                        p.catch(function() {
                            // Retry on first touch
                            document.addEventListener('touchstart', function() {
                                v.play();
                            }, { once: true });
                        });
                    }
                });
            });
        </script>
    </div>
</section>
@endsection
