@extends('layouts.app')

@section('title', __('Supports') . ' — ISTexpo')

@section('content')
<section class="page-header" style="background: linear-gradient(rgba(0,43,73,0.85), rgba(0,43,73,0.85)), url('/img/cover-images/cover-main.png') center/cover; color: #fff; padding: 120px 0 80px;">
    <div class="wrap">
        <div class="eyebrow" style="color: var(--yellow); border-color: var(--yellow);">{{ __('Financial Aid') }}</div>
        <h1 class="page-title">{{ __('Government') }} <span class="script" style="color: var(--yellow);">{{ __('Incentives') }}</span></h1>
        <p style="font-size: 20px; color: rgba(255,255,255,0.7); max-width: 600px;">{{ __('Maximize your ROI by leveraging available government incentives for international trade shows.') }}</p>
    </div>
</section>

<section>
    <div class="wrap">
        <div style="max-width: 800px; margin: 0 auto;">
            <div class="support-item" style="padding: 40px; background: #fff; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 32px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                    <h3 style="font-size: 24px; color: var(--brand); margin: 0;">{{ __('T.C. Ticaret Bakanlığı Destekleri') }}</h3>
                    <img src="{{ asset('img/logos/ticaret-bakanligi.png') }}" alt="T.C. Ticaret Bakanlığı" style="height: 60px; object-fit: contain;">
                </div>
                <p style="color: var(--muted); line-height: 1.8; margin-bottom: 24px; font-size: 16px;">
                    {{ __('T.C Ticaret Bakanlığı İhracat Genel Müdürlüğü’nce, mal ticaretine ilişkin uluslararası fuarlara firmalarımızın katılımları ve organizatörlerin tanıtım harcamaları, “Yurt Dışında Gerçekleştirilen Fuar Katılımcılarının Desteklenmesine İlişkin 2017/4 sayılı Karar” kapsamında desteklenmektedir. Bu çerçevede, Bakanlıkça belirlenip ilan edilen sektörel nitelikteki uluslararası fuarlara firmalarımızın bireysel katılımı, bunun yanı sıra yetkilendirilen organizatörlerce düzenlenen fuarlara milli katılım ve sektöründe önde gelen prestijli fuarlara katılım belirli kalemlerde ve değişen tutarlarda desteklenmektedir.') }}
                </p>
                <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                    <a href="https://www.ticaret.gov.tr" target="_blank" class="btn btn-secondary" style="background: transparent; border: 2px solid var(--brand); color: var(--brand); font-weight: 600; padding: 12px 24px;">{{ __('www.ticaret.gov.tr') }}</a>
                    <a href="https://ticaret.gov.tr/destekler/ihracat-destekleri/teblig-karar-yurutulmesine-dair-genelgeler/yurt-disinda-gerceklestirilen-fuar-katilimlarinin-desteklenmesine-iliskin-2017-4" target="_blank" class="btn btn-primary" style="font-weight: 600; padding: 12px 24px; background: var(--brand); color: #fff;">{{ __('Mevzuat için Tıklayın') }}</a>
                </div>
            </div>
            
            <div class="support-item" style="padding: 40px; background: #fff; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                    <h3 style="font-size: 24px; color: var(--brand); margin: 0;">{{ __('KOSGEB Destekleri') }}</h3>
                    <img src="{{ asset('img/logos/kosgeb.png') }}" alt="KOSGEB" style="height: 50px; object-fit: contain;">
                </div>
                <p style="color: var(--muted); line-height: 1.8; margin-bottom: 24px; font-size: 16px;">
                    {{ __('Kosgeb Kanunu uyarınca. 18.11.2005 tarih ve 25997 sayılı Resmî Gazete’de yayınlanan KOBİ tanımı ve sınıflandırması hakkındaki Yönetmenlik ile tanımlanan küçük ve orta ölçekli işletmelere çok yönlü geliştirme ve destekleme programları uygulanmaktadır.') }}
                </p>
                <a href="https://www.kosgeb.gov.tr" target="_blank" class="btn btn-secondary" style="background: transparent; border: 2px solid var(--brand); color: var(--brand); font-weight: 600; padding: 12px 24px;">{{ __('www.kosgeb.gov.tr') }}</a>
            </div>
        </div>
    </div>
</section>
@endsection
