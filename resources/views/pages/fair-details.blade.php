@extends('layouts.app')

@section('title', $fair->name_loc . ' — ISTexpo')

@section('content')
<section class="fair-hero" style="background: #f4f4f4; padding: 140px 0 80px; position: relative;">
    <div class="wrap" style="position: relative; z-index: 2;">
        {{-- Floating Top Card --}}
        <div style="background: #fff; display: flex; flex-wrap: wrap; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 40px;">
            
            {{-- Left Part: Logo & Name --}}
            <div style="flex: 1; min-width: 250px; background: #eef0f2; padding: 40px;">
                @if($fair->logo)
                    <div style="width: 100px; height: 100px; background-color: #fff; display: grid; place-items: center; border: 1px solid var(--line); margin-bottom: 24px;">
                        <img src="{{ asset('storage/' . $fair->logo) }}" alt="{{ $fair->name }}" style="max-width: 80%; max-height: 80%;">
                    </div>
                @endif
                <h1 style="font-size: 20px; font-weight: 700; color: var(--ink); margin-bottom: 12px; text-transform: uppercase;">{{ $fair->name_loc }}</h1>
                
                @if($fair->grant_amount)
                    <p style="font-size: 14px; color: var(--ink); margin-bottom: 16px;">{{ __('Incentive Amount:') }} {{ $fair->grant_amount }}</p>
                @endif
                
                <p style="font-size: 15px; color: var(--ink); font-weight: 500;">
                    @if($fair->start_date->format('m') === $fair->end_date->format('m'))
                        {{ $fair->start_date->format('d') }} - {{ $fair->end_date->format('d') }} {{ __($fair->end_date->format('M')) }} {{ $fair->end_date->format('Y') }}
                    @else
                        {{ $fair->start_date->format('d') }} {{ __($fair->start_date->format('M')) }} - {{ $fair->end_date->format('d') }} {{ __($fair->end_date->format('M')) }} {{ $fair->end_date->format('Y') }}
                    @endif
                </p>
            </div>

            {{-- Middle Part: Cover Image or Video --}}
            <div style="flex: 1.5; min-width: 300px; min-height: 280px; background: #000; position: relative;">
                @if($fair->video)
                    <video controls playsinline webkit-playsinline preload="metadata" style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; display: block;">
                        <source src="{{ asset('storage/' . $fair->video) }}" type="video/mp4">
                    </video>
                @elseif($fair->image)
                    <img src="{{ asset('storage/' . $fair->image) }}" alt="{{ $fair->name }}" style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                @else
                    <div style="width: 100%; height: 100%; background: var(--line); display: grid; place-items: center;">
                        <span style="color: var(--muted);">{{ __('No Image') }}</span>
                    </div>
                @endif
            </div>

            {{-- Right Part: Details List --}}
            <div style="flex: 1.5; min-width: 300px; background: #eef0f2; padding: 40px;">
                <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; color: var(--ink); line-height: 2;">
                    @if($fair->subject)
                        <li style="position: relative; padding-left: 16px; margin-bottom: 8px;">
                            <span style="position: absolute; left: 0; top: 10px; width: 4px; height: 4px; background: var(--ink); border-radius: 50%;"></span>
                            <strong>{{ __('Fair Subject:') }}</strong> {{ $fair->subject }}
                        </li>
                    @endif
                    <li style="position: relative; padding-left: 16px; margin-bottom: 8px;">
                        <span style="position: absolute; left: 0; top: 10px; width: 4px; height: 4px; background: var(--ink); border-radius: 50%;"></span>
                        <strong>{{ __('Date:') }}</strong> 
                        @if($fair->start_date->format('m') === $fair->end_date->format('m'))
                            {{ $fair->start_date->format('d') }} - {{ $fair->end_date->format('d') }} {{ __($fair->end_date->format('M')) }} {{ $fair->end_date->format('Y') }}
                        @else
                            {{ $fair->start_date->format('d') }} {{ __($fair->start_date->format('M')) }} - {{ $fair->end_date->format('d') }} {{ __($fair->end_date->format('M')) }} {{ $fair->end_date->format('Y') }}
                        @endif
                    </li>
                    <li style="position: relative; padding-left: 16px; margin-bottom: 8px;">
                        <span style="position: absolute; left: 0; top: 10px; width: 4px; height: 4px; background: var(--ink); border-radius: 50%;"></span>
                        <strong>{{ __('City - Country:') }}</strong> {{ $fair->location }}
                    </li>
                    @if($fair->venue)
                        <li style="position: relative; padding-left: 16px; margin-bottom: 8px;">
                            <span style="position: absolute; left: 0; top: 10px; width: 4px; height: 4px; background: var(--ink); border-radius: 50%;"></span>
                            <strong>{{ __('Venue:') }}</strong> {{ $fair->venue }}
                        </li>
                    @endif
                    @if($fair->organizer)
                        <li style="position: relative; padding-left: 16px; margin-bottom: 8px;">
                            <span style="position: absolute; left: 0; top: 10px; width: 4px; height: 4px; background: var(--ink); border-radius: 50%;"></span>
                            <strong>{{ __('Organizer:') }}</strong> {{ $fair->organizer }}
                        </li>
                    @endif
                    @if($fair->edition)
                        <li style="position: relative; padding-left: 16px; margin-bottom: 8px;">
                            <span style="position: absolute; left: 0; top: 10px; width: 4px; height: 4px; background: var(--ink); border-radius: 50%;"></span>
                            <strong>{{ __('Edition:') }}</strong> {{ $fair->edition }}
                        </li>
                    @endif
                    @if($fair->grant_amount)
                        <li style="position: relative; padding-left: 16px; margin-bottom: 8px;">
                            <span style="position: absolute; left: 0; top: 10px; width: 4px; height: 4px; background: var(--ink); border-radius: 50%;"></span>
                            <strong>{{ __('Incentive Amount:') }}</strong> {{ $fair->grant_amount }}
                        </li>
                    @endif
                    @if($fair->website)
                        <li style="position: relative; padding-left: 16px; margin-bottom: 8px;">
                            <span style="position: absolute; left: 0; top: 10px; width: 4px; height: 4px; background: var(--ink); border-radius: 50%;"></span>
                            <strong>{{ __('Website:') }}</strong> <a href="{{ $fair->website }}" target="_blank" style="color: #0066cc; text-decoration: none;">{{ __('Official Site') }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- Bottom Section: Description & Profile --}}
        <div class="grid-sidebar">
            {{-- Main Content --}}
            <div style="background: #fff; padding: 48px; border-radius: 4px; box-shadow: 0 15px 40px rgba(0,0,0,0.04); border-bottom: 4px solid var(--brand);">
                <h2 style="font-size: 32px; font-weight: 700; color: var(--ink); margin-bottom: 32px; position: relative; display: inline-block;">
                    {{ __('About the Fair') }}
                    <span style="position: absolute; bottom: -8px; left: 0; width: 40px; height: 3px; background: var(--brand);"></span>
                </h2>
                <div class="fair-content" style="font-size: 16px; line-height: 1.9; color: #444; margin-top: 20px;">
                    {!! $fair->description_loc !!}
                </div>
            </div>

            {{-- Sidebar --}}
            <div style="background: #fff; padding: 40px; border-radius: 4px; box-shadow: 0 15px 40px rgba(0,0,0,0.04); border-top: 4px solid var(--yellow); height: fit-content;">
                <h3 style="font-size: 20px; font-weight: 700; color: var(--ink); margin-bottom: 24px; text-transform: uppercase; letter-spacing: 0.5px;">{{ __('Exhibitor Profile') }}</h3>
                
                @if($fair->profile_loc)
                    <div style="font-size: 15px; color: #555; line-height: 1.7; margin-bottom: 32px;" class="fair-exhibitor-profile">
                        {!! preg_replace('/<ul>/', '<ul style="list-style: none; padding: 0; margin: 0;">', preg_replace('/<li>/', '<li style="position: relative; padding-left: 16px; margin-bottom: 12px;"><span style="position: absolute; left: 0; top: 10px; width: 4px; height: 4px; background: var(--yellow); border-radius: 50%;"></span>', $fair->profile_loc)) !!}
                    </div>
                @else
                    <p style="font-size: 14px; color: var(--muted); margin-bottom: 32px;">{{ __('No exhibitor profile available.') }}</p>
                @endif

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <a href="{{ route('contact') }}" style="display: block; width: 100%; padding: 18px 20px; background: var(--yellow); color: var(--ink); font-weight: 700; font-size: 15px; text-align: center; transition: all 0.3s; text-decoration: none; border-radius: 4px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(232, 149, 0, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        {{ __('Information & Sales') }}
                    </a>
                    <a href="{{ asset('documents/katilimci-kilavuzu.pdf') }}" download style="display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 16px 20px; background: #f8f9fa; color: var(--ink); font-weight: 600; font-size: 14px; text-align: center; border: 1px solid var(--line); transition: all 0.3s; text-decoration: none; border-radius: 4px;" onmouseover="this.style.background='#fff'; this.style.borderColor='var(--ink)'" onmouseout="this.style.background='#f8f9fa'; this.style.borderColor='var(--line)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        {{ __('Exhibitor Guide') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
