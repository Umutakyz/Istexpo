@extends('layouts.app')

@section('title', __('Our Services') . ' — ISTexpo')

@section('content')
<section class="page-header" style="background: var(--bg-2); ">
    <div class="wrap">
        <div class="eyebrow">{{ __('Services') }}</div>
        <h1 class="page-title">{{ __('Excellence in') }} <span class="script" style="color: var(--brand);">{{ __('Execution') }}</span></h1>
        <p style="font-size: 20px; color: var(--muted); max-width: 600px;">{{ __('Comprehensive exhibition management and strategic consultancy services.') }}</p>
    </div>
</section>

<section>
    <div class="wrap">
        <div class="grid-3">
            @foreach($services as $service)
            <div class="card">
                <div class="card-body">
                    <div style="width: 60px; height: 60px; background: var(--brand-light); border-radius: 16px; display: grid; place-items: center; color: var(--brand); margin-bottom: 32px;">
                        {!! $service->icon ?? '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M2 12h20"/></svg>' !!}
                    </div>
                    <h3 class="card-title">{{ $service->name_loc }}</h3>
                    <p class="card-text">{{ $service->description_loc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
