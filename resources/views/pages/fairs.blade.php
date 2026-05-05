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
                <div class="grid-2">
                    @foreach ($internationalFairs as $fair)
                    <a href="{{ route('fairs.show', $fair->slug) }}" class="fair-card-item card">
                        <div class="fair-card-img">
                            @if($fair->image)
                                <img src="{{ asset('storage/' . $fair->image) }}" alt="{{ $fair->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; background: var(--bg-3); display: grid; place-items: center;">
                                    <span style="font-size: 10px; font-weight: 800; color: var(--muted);">{{ __('No Image') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="fair-card-body">
                            @if($fair->logo)
                                <div class="fair-card-logo">
                                    <img src="{{ asset('storage/' . $fair->logo) }}" alt="Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                </div>
                            @endif
                            <div style="flex: 1;">
                                <h3 class="card-title" style="margin: 0 0 8px; font-size: 18px; line-height: 1.2;">{{ $fair->name_loc }}</h3>
                                <div style="font-weight: 800; font-size: 11px; color: var(--brand); margin-bottom: 8px; text-transform: uppercase;">
                                    @if($fair->start_date->format('m') === $fair->end_date->format('m'))
                                        {{ $fair->start_date->format('d') }}-{{ $fair->end_date->format('d') }} {{ __($fair->start_date->format('M')) }}
                                    @else
                                        {{ $fair->start_date->format('d') }} {{ __($fair->start_date->format('M')) }} - {{ $fair->end_date->format('d') }} {{ __($fair->end_date->format('M')) }}
                                    @endif
                                </div>
                                <p style="font-size: 13px; color: var(--muted); margin: 0; line-height: 1.4;">{{ Str::limit(html_entity_decode(strip_tags($fair->description_loc)), 80) }}</p>
                            </div>
                            <div class="fair-card-arrow">
                                <div class="search-btn" style="width: 44px; height: 44px;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="pagination-wrapper" style="margin-top: 60px;">
                    {{ $internationalFairs->appends(request()->except('uluslararasi_sayfa'))->links() }}
                </div>
            </div>
        @endif

        @if($pastFairs->isNotEmpty())
            <div>
                <h2 class="section-title" style="margin-bottom: 40px; font-size: 32px;">{{ __('Past Fairs') }}</h2>
                <div class="grid-2">
                    @foreach ($pastFairs as $fair)
                    <a href="{{ route('fairs.show', $fair->slug) }}" class="fair-card-item card">
                        <div class="fair-card-img">
                            @if($fair->image)
                                <img src="{{ asset('storage/' . $fair->image) }}" alt="{{ $fair->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; background: var(--bg-3); display: grid; place-items: center;">
                                    <span style="font-size: 10px; font-weight: 800; color: var(--muted);">{{ __('No Image') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="fair-card-body">
                            @if($fair->logo)
                                <div class="fair-card-logo">
                                    <img src="{{ asset('storage/' . $fair->logo) }}" alt="Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                </div>
                            @endif
                            <div style="flex: 1;">
                                <h3 class="card-title" style="margin: 0 0 8px; font-size: 18px; line-height: 1.2;">{{ $fair->name_loc }}</h3>
                                <div style="font-weight: 800; font-size: 11px; color: var(--brand); margin-bottom: 8px; text-transform: uppercase;">
                                    @if($fair->start_date->format('m') === $fair->end_date->format('m'))
                                        {{ $fair->start_date->format('d') }}-{{ $fair->end_date->format('d') }} {{ __($fair->start_date->format('M')) }}
                                    @else
                                        {{ $fair->start_date->format('d') }} {{ __($fair->start_date->format('M')) }} - {{ $fair->end_date->format('d') }} {{ __($fair->end_date->format('M')) }}
                                    @endif
                                </div>
                                <p style="font-size: 13px; color: var(--muted); margin: 0; line-height: 1.4;">{{ Str::limit(html_entity_decode(strip_tags($fair->description_loc)), 80) }}</p>
                            </div>
                            <div class="fair-card-arrow">
                                <div class="search-btn" style="width: 44px; height: 44px;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="pagination-wrapper" style="margin-top: 60px;">
                    {{ $pastFairs->appends(request()->except('gecmis_sayfa'))->links() }}
                </div>
            </div>
        @endif

        @if($internationalFairs->isEmpty() && $pastFairs->isEmpty())
            <div style="text-align: center; padding: 100px 0;">
                <h2 style="font-size: 24px; color: var(--muted);">{{ __('No fairs found.') }}</h2>
            </div>
        @endif

        <style>
            .fair-card-item {
                display: flex;
                flex-direction: row;
                overflow: hidden;
                height: 180px;
                margin-bottom: 24px;
                text-decoration: none;
                transition: all 0.3s ease;
                background: #fff;
            }
            .fair-card-item:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            }
            .fair-card-img {
                width: 240px;
                flex-shrink: 0;
                position: relative;
            }
            .fair-card-body {
                flex: 1;
                display: flex;
                flex-direction: row;
                gap: 24px;
                padding: 24px;
                align-items: center;
            }
            .fair-card-logo {
                width: 80px;
                height: 80px;
                flex-shrink: 0;
                background: #fff;
                border-radius: 12px;
                border: 1px solid var(--line);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 8px;
            }
            
            @media (max-width: 768px) {
                .fair-card-item {
                    flex-direction: column;
                    height: auto;
                }
                .fair-card-img {
                    width: 100%;
                    height: 200px;
                }
                .fair-card-body {
                    flex-direction: column;
                    align-items: flex-start;
                    padding: 20px;
                    gap: 15px;
                }
                .fair-card-logo {
                    width: 60px;
                    height: 60px;
                }
                .fair-card-arrow {
                    display: none;
                }
            }
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
