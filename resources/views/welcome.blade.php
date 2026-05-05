@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-bg">
        <video autoplay loop muted playsinline webkit-playsinline preload="metadata" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
            <source src="https://www.istexpo.com/cdn/videos/shutterstock_v16143700.mp4" type="video/mp4">
            <source src="https://www.istexpo.com/cdn/videos/shutterstock_v16143700.webm" type="video/webm">
        </video>
    </div>
    
    <div class="wrap hero-inner">
        <div class="hero-tagline">
            <div class="dot"></div>
            {{ __('Global Events Portfolio 2026') }}
        </div>
        
        <h1>
            {!! __('Connecting you with the :right :connections', [
                'right' => '<span class="script" style="color: var(--yellow);">' . __('Right') . '</span>',
                'connections' => '<br><span class="strong">' . __('Connections Globally') . '</span>'
            ]) !!}
        </h1>
        
        <p class="hero-sub">
            {{ __('ISTexpo delivers world-class trade shows and exhibitions across high-growth sectors, connecting global industry leaders with local expertise.') }}
        </p>
        
        <div class="hero-ctas">
            <a href="{{ route('fairs') }}" class="btn btn-primary">{{ __('View Upcoming Fairs') }}</a>
            <a href="{{ route('representations') }}" class="btn btn-secondary">{{ __('Our Representations') }}</a>
        </div>
        
        <div class="hero-stats">
            <div class="hero-stat">
                <div class="val">12<em>+</em></div>
                <div class="lbl">{{ __('Global Locations') }}</div>
            </div>
            <div class="hero-stat">
                <div class="val">250<em>k</em></div>
                <div class="lbl">{{ __('Annual Visitors') }}</div>
            </div>
            <div class="hero-stat">
                <div class="val">500<em>+</em></div>
                <div class="lbl">{{ __('Partner Brands') }}</div>
            </div>
            <div class="hero-stat">
                <div class="val">15<em>yr</em></div>
                <div class="lbl">{{ __('Excellence') }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Fairs -->
<section>
    <div class="wrap">
            <div>
                <h2 class="section-title">{{ __('Upcoming') }} <em>{{ __('Exhibitions') }}</em></h2>
            </div>
            <p class="section-desc">{{ __('Explore our global portfolio of industry-leading events and exhibitions planned for the upcoming season.') }}</p>
        
        <div class="grid-3">
            @php
                $upcomingFairs = \App\Models\Fair::where('is_featured', true)->orderBy('start_date', 'asc')->get();
            @endphp
            @foreach($upcomingFairs as $fair)
            <div class="card" style="display: flex; flex-direction: column; height: 100%;">
                <div class="card-img" style="position: relative; overflow: hidden; height: 220px; flex-shrink: 0;">
                    @if($fair->video)
                        <video autoplay muted loop playsinline webkit-playsinline preload="metadata" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            <source src="{{ asset('storage/' . $fair->video) }}" type="video/mp4">
                        </video>
                    @elseif($fair->image)
                        <img src="{{ asset('storage/' . $fair->image) }}" alt="{{ $fair->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <svg viewBox="0 0 400 220" fill="#f0ede8"><rect width="400" height="220" fill="var(--brand)" fill-opacity="0.05"/><text x="50%" y="50%" text-anchor="middle" fill="var(--brand)" font-size="14" font-weight="700">{{ __('EVENT IMAGE') }}</text></svg>
                    @endif
                </div>
                <div class="card-body" style="flex: 1; display: flex; flex-direction: column; padding: 24px;">
                    <div style="display: flex; gap: 20px; align-items: flex-start; margin-bottom: 20px;">
                        @if($fair->logo)
                            <div style="width: 70px; height: 70px; flex-shrink: 0; background: #fff; border-radius: 12px; border: 1px solid var(--line); display: flex; align-items: center; justify-content: center; padding: 6px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                                <img src="{{ asset('storage/' . $fair->logo) }}" alt="Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                            </div>
                        @endif
                        <h3 class="card-title" style="margin: 0; font-size: 20px; line-height: 1.3; font-weight: 800;">{{ $fair->name_loc }}</h3>
                    </div>
                    
                    <p class="card-text" style="font-size: 14px; line-height: 1.6; color: var(--muted); margin-bottom: 24px;">
                        {{ Str::limit(html_entity_decode(strip_tags($fair->description_loc)), 90) }}
                    </p>

                    <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid var(--line-strong);">
                        <div style="font-weight: 800; font-size: 11px; color: var(--brand); text-transform: uppercase; letter-spacing: 0.5px;">
                            @if($fair->start_date->format('m') === $fair->end_date->format('m'))
                                {{ $fair->start_date->format('d') }}-{{ $fair->end_date->format('d') }} {{ __($fair->start_date->format('M')) }}
                            @else
                                {{ $fair->start_date->format('d') }} {{ __($fair->start_date->format('M')) }} - {{ $fair->end_date->format('d') }} {{ __($fair->end_date->format('M')) }}
                            @endif
                        </div>
                        <a href="{{ route('fairs.show', $fair->slug) }}" class="card-link" style="margin: 0; font-size: 13px; font-weight: 700;">{{ __('Details') }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var videos = document.querySelectorAll('.grid-3 video[autoplay]');
                videos.forEach(function(v) {
                    v.muted = true;
                    var p = v.play();
                    if (p !== undefined) {
                        p.catch(function() {
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

<!-- About Section -->
<section style="background: var(--bg-2);">
    <div class="wrap">
        <div class="grid-2" style="align-items: center; gap: 80px;">
            <div style="position: relative;">
                <div style="aspect-ratio: 4/5; border-radius: 40px; overflow: hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.12);">
                    <img src="{{ asset('img/about-history.png') }}" alt="{{ __('About Us') }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="position: absolute; -right: 40px; top: 40px; background: var(--brand); color: #fff; padding: 32px; border-radius: 24px; box-shadow: 0 20px 40px rgba(0,43,73,0.3); max-width: 200px;">
                    <div style="font-size: 32px; font-weight: 800; margin-bottom: 4px;">2007</div>
                    <div style="font-size: 13px; font-weight: 600; opacity: 0.8; text-transform: uppercase; letter-spacing: 1px;">{{ __('Established') }}</div>
                </div>
            </div>
            <div>
                <div class="eyebrow">{{ __('Corporate') }}</div>
                <h2 class="section-title" style="margin-bottom: 32px;">{{ __('About') }} <span class="script" style="color: var(--brand);">ISTexpo</span></h2>
                <p style="font-size: 18px; line-height: 1.8; color: var(--muted); margin-bottom: 40px;">
                    {{ __('ISTexpo Exhibition Services Ltd. was established in 2007 by a team experienced in trade fairs and event management. Together with our global solution partners, we bring industry leaders together with a boutique service approach at international standards.') }}
                </p>
                <div style="display: flex; gap: 24px;">
                    <a href="{{ route('about') }}" class="btn btn-primary">{{ __('Read Our Story') }}</a>
                    <a href="{{ route('contact') }}" class="btn btn-outline">{{ __('Contact Us') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Representations / Partners -->
<section style="background: #f8f9fa; padding: 100px 0;">
    <div class="wrap">
        <div class="section-head" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 60px;">
            <div style="text-align: left;">
                <div class="eyebrow" style="margin: 0 0 16px;">{{ __('Representations') }}</div>
                <h2 class="section-title" style="margin: 0;">{{ __('Our Global') }} <em>{{ __('Partners') }}</em></h2>
            </div>
            <div style="display: flex; gap: 12px; margin-bottom: 8px;">
                <button id="prevPartner" style="width: 44px; height: 44px; border-radius: 50%; border: 1px solid var(--line); background: #fff; display: grid; place-items: center; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='var(--brand)'; this.style.color='#fff'" onmouseout="this.style.background='#fff'; this.style.color='inherit'">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <button id="nextPartner" style="width: 44px; height: 44px; border-radius: 50%; border: 1px solid var(--line); background: #fff; display: grid; place-items: center; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='var(--brand)'; this.style.color='#fff'" onmouseout="this.style.background='#fff'; this.style.color='inherit'">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
        </div>
        
        <div id="partnerTrack" style="display: flex; gap: 60px; overflow-x: auto; scroll-behavior: smooth; padding: 40px 0; scrollbar-width: none; -ms-overflow-style: none; align-items: center;">
            @foreach($representations as $representation)
            <div class="partner-logo" style="flex: 0 0 auto; filter: grayscale(1); opacity: 0.7; transition: 0.4s; cursor: pointer; display: grid; place-items: center;" title="{{ $representation->name }}">
                @if($representation->logo)
                    <img src="{{ asset('storage/' . $representation->logo) }}" alt="{{ $representation->name }}" class="partner-img">
                @else
                    <span style="font-weight: 800; color: var(--brand); font-size: 28px;">{{ $representation->name }}</span>
                @endif
            </div>
            @endforeach
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const track = document.getElementById('partnerTrack');
                const prev = document.getElementById('prevPartner');
                const next = document.getElementById('nextPartner');
                
                if(track) {
                    if(prev && next) {
                        prev.onclick = () => track.scrollBy({ left: -300, behavior: 'smooth' });
                        next.onclick = () => track.scrollBy({ left: 300, behavior: 'smooth' });
                    }

                    // Drag to scroll functionality
                    let isDown = false;
                    let startX;
                    let scrollLeft;

                    track.addEventListener('mousedown', (e) => {
                        isDown = true;
                        track.classList.add('active');
                        startX = e.pageX - track.offsetLeft;
                        scrollLeft = track.scrollLeft;
                    });

                    track.addEventListener('mouseleave', () => {
                        isDown = false;
                        track.classList.remove('active');
                    });

                    track.addEventListener('mouseup', () => {
                        isDown = false;
                        track.classList.remove('active');
                    });

                    track.addEventListener('mousemove', (e) => {
                        if (!isDown) return;
                        e.preventDefault();
                        const x = e.pageX - track.offsetLeft;
                        const walk = (x - startX) * 2; // Scroll speed
                        track.scrollLeft = scrollLeft - walk;
                    });
                }
            });
        </script>
        <style>
            #partnerTrack { 
                cursor: grab;
                user-select: none;
                -webkit-user-drag: none;
            }
            #partnerTrack.active { 
                cursor: grabbing;
                scroll-behavior: auto !important;
            }
            #partnerTrack img {
                pointer-events: none;
            }
            #partnerTrack::-webkit-scrollbar { display: none; }
            .partner-logo:hover { filter: grayscale(0) !important; opacity: 1 !important; transform: translateY(-5px); }
            
            .partner-img {
                max-height: 160px;
                max-width: 300px;
                width: auto;
                object-fit: contain;
            }
            @media (max-width: 768px) {
                #partnerTrack { gap: 40px !important; }
                .partner-img { max-height: 80px; max-width: 150px; }
            }
        </style>
    </div>
</section>


<!-- Why ISTexpo -->
<section>
    <div class="wrap">
        <div class="grid-2" style="align-items: center;">
            <div>
                <div class="eyebrow">{{ __('Why Choose Us') }}</div>
                <h2 class="section-title">{{ __('The ISTexpo') }} <em>{{ __('Advantage') }}</em></h2>
                <p class="section-desc" style="margin-bottom: 40px;">{{ __('With over 15 years of experience and a global network of partners, we offer unparalleled reach and expertise in the exhibition industry.') }}</p>
                
                <div class="why-list">
                    <div class="why-item" style="padding: 32px 0; border-bottom: 1px solid var(--line);">
                        <h4 style="font-size: 20px; font-weight: 800; margin-bottom: 8px;">{{ __('Strategic Locations') }}</h4>
                        <p style="color: var(--muted); font-size: 15px;">{{ __('We operate in the world\'s most dynamic markets, providing access to high-growth opportunities.') }}</p>
                    </div>
                    <div class="why-item" style="padding: 32px 0; border-bottom: 1px solid var(--line);">
                        <h4 style="font-size: 20px; font-weight: 800; margin-bottom: 8px;">{{ __('Boutique Excellence') }}</h4>
                        <p style="color: var(--muted); font-size: 15px;">{{ __('Our dedicated team provides personalized support to ensure every participant achieves their goals.') }}</p>
                    </div>
                    <div class="why-item" style="padding: 32px 0;">
                        <h4 style="font-size: 20px; font-weight: 800; margin-bottom: 8px;">{{ __('Innovative Platforms') }}</h4>
                        <p style="color: var(--muted); font-size: 15px;">{{ __('We leverage the latest technology to create immersive and interactive exhibition experiences.') }}</p>
                    </div>
                </div>
            </div>
            <div style="position: relative;">
                <div style="background: var(--bg-3); aspect-ratio: 1/1; border-radius: 40px; overflow: hidden; transform: rotate(-3deg);">
                    <img src="{{ asset('img/advantage.png') }}" alt="{{ __('The ISTexpo Advantage') }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="position: absolute; bottom: -30px; left: -30px; background: #fff; padding: 32px; border-radius: 24px; box-shadow: var(--shadow-hover); max-width: 240px;">
                    <div style="font-size: 40px; font-weight: 800; color: var(--brand);">98%</div>
                    <div style="font-size: 14px; font-weight: 700; color: var(--ink);">{{ __('Client Satisfaction Rate') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA / Incentive Section -->
<section>
    <div class="wrap">
        <div class="incentive-box" style="background: linear-gradient(rgba(0, 43, 73, 0.8), rgba(0, 43, 73, 0.95)), url('{{ asset('img/cta_background.png') }}'); background-size: cover; background-position: center; border-radius: 40px; padding: 100px 80px; color: #fff; text-align: center; position: relative; overflow: hidden;">
            

            <div class="eyebrow" style="color: var(--yellow); border-color: var(--yellow); justify-content: center; margin-bottom: 40px;">{{ __('Partner with Us') }}</div>
            <h2 class="section-title" style="color: #fff; margin-bottom: 40px;">{{ __('Ready to') }} <em style="color: var(--yellow);">{{ __('Transform') }}</em> {{ __('Your Global Reach?') }}</h2>
            <p style="font-size: 20px; color: rgba(255,255,255,0.8); max-width: 700px; margin: 0 auto 60px;">{{ __('Join hundreds of industry leaders who trust ISTexpo to deliver exceptional results and strategic growth opportunities.') }}</p>
            <a href="{{ route('contact') }}" class="btn btn-primary" style="padding: 24px 60px; font-size: 18px;">{{ __('Get a Proposal') }}</a>
        </div>
    </div>
</section>
@endsection
