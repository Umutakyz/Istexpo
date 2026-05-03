@extends('layouts.app')

@section('title', __('Our Sectors') . ' — ISTexpo')

@section('content')
<section class="page-header" style="background: linear-gradient(rgba(0,43,73,0.85), rgba(0,43,73,0.85)), url('/img/cover-images/cover-main.png') center/cover; color: #fff; padding: 120px 0 80px; position: relative; overflow: hidden;">
    <div class="wrap" style="position: relative; z-index: 1;">
        <div class="eyebrow" style="color: var(--yellow); border-color: var(--yellow);">{{ __('Expertise') }}</div>
        <h1 class="page-title">{{ __('Industry') }} <span class="script" style="color: var(--yellow);">{{ __('Verticals') }}</span></h1>
        <p style="font-size: 20px; color: rgba(255,255,255,0.8); max-width: 600px;">{{ __('We specialize in high-growth industries where we can deliver maximum impact and strategic value.') }}</p>
    </div>
</section>

<section>
    <div class="wrap">
        <div class="grid-3">
            @foreach ($sectors as $sector)
            <div class="card" style="
                border: none; 
                min-height: 400px; 
                display: flex; 
                flex-direction: column; 
                justify-content: flex-end; 
                overflow: hidden; 
                position: relative;
                background-color: var(--brand);
                @if($sector->image)
                    background-image: linear-gradient(rgba(0,43,73,0.3), rgba(0,43,73,0.9)), url('{{ asset('storage/' . $sector->image) }}');
                    background-size: cover;
                    background-position: center;
                @endif
            ">
                <div class="card-body" style="padding: 40px; position: relative; z-index: 2; color: #fff;">
                    <h3 class="card-title" style="color: #fff; font-size: 32px; margin-bottom: 16px;">{{ $sector->name_loc }}</h3>
                    <p style="color: rgba(255,255,255,0.8); font-size: 16px; margin-bottom: 32px;">{{ $sector->description_loc }}</p>
                    <a href="{{ route('fairs') }}?sector={{ $sector->id }}" class="btn btn-primary" style="background: var(--yellow); color: var(--ink); border: none;">{{ __('Explore Fairs') }}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
