@extends('layouts.app')

@section('title', __('Representations') . ' — ISTexpo')

@section('content')
<section class="page-header" style="background: linear-gradient(rgba(0,43,73,0.85), rgba(0,43,73,0.85)), url('/img/cover-images/cover-main.png') center/cover; color: #fff; position: relative; overflow: hidden;">
    <div class="wrap" style="position: relative; z-index: 1;">
        <div class="eyebrow" style="color: var(--yellow); border-color: var(--yellow);">{{ __('Global Network') }}</div>
        <h1 class="page-title">{{ __('Our') }} <span class="script" style="color: var(--yellow);">{{ __('Representations') }}</span></h1>
        <p style="font-size: 20px; color: rgba(255,255,255,0.8); max-width: 600px;">{{ __('We represent world-leading exhibition organizers, bringing global opportunities to local markets.') }}</p>
    </div>
</section>

<section>
    <div class="wrap">
        <div class="grid-2">
            @foreach($representations as $item)
            <div class="card" style="padding: 40px; border: 1px solid var(--line); border-radius: 24px; display: flex; flex-direction: column; height: 100%;">
                <div style="height: 60px; margin-bottom: 32px; display: flex; align-items: center;">
                    @if($item->logo)
                        <img src="{{ asset('storage/' . $item->logo) }}" alt="{{ $item->name }}" style="max-height: 100%; width: auto;">
                    @else
                        <h3 style="font-size: 24px; margin-bottom: 0;">{{ $item->name }}</h3>
                    @endif
                </div>
                <h3 style="font-size: 24px; margin-bottom: 16px;">{{ $item->name_loc }}</h3>
                <div style="color: var(--muted); line-height: 1.6; font-size: 15px; flex-grow: 1;">
                    {!! nl2br(html_entity_decode($item->description_loc)) !!}
                </div>
                @if($item->website)
                    <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--line);">
                        <a href="{{ $item->website }}" target="_blank" class="card-link">{{ __('Visit Website') }}</a>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
