@extends('layouts.app')

@section('title', __('About Us') . ' — ISTexpo')

@section('content')
<section class="page-header" style="background: linear-gradient(rgba(0,43,73,0.85), rgba(0,43,73,0.85)), url('/img/cover-images/cover-main.png') center/cover; color: #fff; ">
    <div class="wrap">
        <div class="eyebrow" style="color: var(--yellow); border-color: var(--yellow);">{{ __('Our Story') }}</div>
        <h1 class="page-title">{{ __('Legacy of') }} <span class="script" style="color: var(--yellow);">{{ __('Excellence') }}</span></h1>
        <p style="font-size: 20px; color: rgba(255,255,255,0.7); max-width: 600px;">{{ __('A decade of connecting global industries through world-class exhibitions.') }}</p>
    </div>
</section>

<section>
    <div class="wrap">
        <div class="grid-2" style="align-items: center;">
            <div style="aspect-ratio: 4/5; border-radius: 40px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.15);">
                <img src="{{ asset('img/about-history.png') }}" alt="{{ __('Hakkımızda') }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div>
                <h2 class="section-title" style="margin-bottom: 24px;">{{ __('Hakkımızda') }}</h2>
                <p style="font-size: 16px; color: var(--muted); line-height: 1.8; margin-bottom: 24px;">{{ __('ISTexpo Fuarcılık Hizmetleri Ltd. Şti. ticari fuarlar ve etkinlik yönetimi konusunda deneyimli ekibi tarafından 2007 yılında kurulmuştur. Fuarcılık sektöründe her daim gelişime ve yeniliğe önem veren ISTexpo Fuarcılık; Avrupa, Asya, Amerika ve Afrika’daki ülkelerde gerçekleştirdiği fuarlar ile Türk sanayicisinin ürün ve hizmetlerinin yurtdışında tanıtımında ve ihracatın gelişmesinde rol oynamaktadır.') }}</p>
                <p style="font-size: 16px; color: var(--muted); line-height: 1.8; margin-bottom: 24px;">{{ __('Şirketimiz aynı zamanda yurt içinde düzenlediği fuarlar ile adından söz ettiren İSTANBUL Restate Fuar Organizasyon A.Ş’nin de %100 hissedarıdır. İstanbul Restate Gayrimenkul Fuarı, Gyoder Gayrimenkul Zirveleri, Cityscape Türkiye, All Energy Turkey, TEF Teknoloji ve Eğitim Teknolojileri fuarları ve Migros İyi Gelecek Festivali gibi yurtiçinde düzenlenen organizasyonlar ile büyük başarılara imza atılmıştır.') }}</p>
                <p style="font-size: 16px; color: var(--muted); line-height: 1.8; margin-bottom: 24px;">{{ __('ISTexpo Fuarcılık, başta gayrimenkul olmak üzere promosyon, medikal ve sağlık, alüminyum, kaynak, güvenlik, makine gibi yirmiye yakın sektörde düzenlenen yurtdışı fuarların Türkiye temsilciğini yapmaktadır. Bunun yanı sıra Düsseldorf’ta da ofisi bulunan ISTexpo Fuarcılık, Almanya’da fuar düzenleme yetkisine sahiptir. Geçtiğimiz yıl Düsseldorf’ta düzenlediği Evim Türkiye fuarı ile Türk gayrimenkul sektörünü Avrupa’ya tanıtma idealini gerçekleştirmiştir. ISTexpo Fuarcılık sunduğu yaratıcı ve yenilikçi etkinlik yönetimi hizmetleri ile de sektörün lider firmalarından biri olmaya devam etmektedir.') }}</p>
                <p style="font-size: 16px; color: var(--muted); line-height: 1.8; font-weight: 600;">{{ __('Takviminde bulunan yılda kırktan fazla etkinlik ile onlarca ülkede ilgili pazarı tanıma, ticarete başlama ve işlerini geliştirmesine olanak sağlayan ISTexpo Fuarcılık, Dünya ile Doğru Bağlantılar Kurmak İçin En Doğru Adres!') }}</p>
            </div>
        </div>
    </div>
</section>
@endsection
