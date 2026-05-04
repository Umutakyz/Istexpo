@extends('layouts.app')

@section('title', __('KVKK Information') . ' — ISTexpo')

@section('content')
<section class="page-header" style="background: var(--bg-2); padding: 80px 0 40px;">
    <div class="wrap">
        <h1 style="font-size: clamp(32px, 5vw, 48px); line-height: 1.1; letter-spacing: -0.04em;">{{ __('KVKK Aydınlatma Metni') }}</h1>
    </div>
</section>

<section>
    <div class="wrap">
        <div style="max-width: 900px; line-height: 1.8; color: var(--muted); padding: 40px 0;">
            <h4 style="color: var(--ink); margin-bottom: 24px; font-weight: 700;">{{ __('KİŞİSEL VERİLERİN KORUNMASI KANUNU AYDINLATMA METNİ') }}</h4>
            
            <p style="margin-bottom: 24px;">{{ __('İşbu Aydınlatma Metni’nde, kişisel verilerinizin, 6698 sayılı Kişisel Verilerin Korunması Kanunu (“Kanun”) ve ilgili mevzuata uygun olarak, veri sorumlusu olan ve “Ayazmaderesi Cad. Saral İş Merkezi No: 5/A 34349 Beşiktaş/İstanbul” adresinde yer alan ISTexpo Fuarcılık Hizmetleri LTD. ŞTİ. (“ISTexpo Fuarcılık” veya “Şirket”) nezdinde işlenmesine ilişkin esaslar aşağıda belirtilmiştir.') }}</p>

            <h3 style="color: var(--ink); margin: 40px 0 20px;">1. {{ __('Tanımlar') }}</h3>
            <p style="margin-bottom: 16px;">{{ __('İşbu Aydınlatma Metni’nde kullanılan kavramlar aşağıdaki anlamlara gelmektedir:') }}</p>
            <ul style="list-style: none; padding: 0; margin-bottom: 24px;">
                <li style="margin-bottom: 12px;"><strong>{{ __('Kişisel Verilerin Korunması Kanunu (KVKK):') }}</strong> {{ __('7 Nisan 2016 tarihli Resmi Gazetede yayınlanarak yürürlüğe giren 6698 Sayılı Kişisel Verilerin Korunması Kanunu.') }}</li>
                <li style="margin-bottom: 12px;"><strong>{{ __('Kişisel Veri:') }}</strong> {{ __('Kimliği belirli veya belirlenebilir gerçek kişiye ilişkin her türlü bilgi.') }}</li>
                <li style="margin-bottom: 12px;"><strong>{{ __('Kişisel Verilerin İşlenmesi:') }}</strong> {{ __('Kişisel verilerin tamamen veya kısmen otomatik olan ya da herhangi bir veri kayıt sisteminin parçası olmak kaydıyla otomatik olmayan yollarla elde edilmesi, kaydedilmesi, depolanması, muhafaza edilmesi, değiştirilmesi, yeniden düzenlenmesi, açıklanması, aktarılması, devralınması, elde edilebilir hâle getilizilmesi, sınıflandırılması ya da kullanılmasının engellenmesi gibi veriler üzerinde gerçekleştirilen her türlü işlem.') }}</li>
                <li style="margin-bottom: 12px;"><strong>{{ __('Özel Nitelikli Kişisel Veri:') }}</strong> {{ __('Kişilerin ırkı, etnik kökeni, siyasi düşüncesi, felsefi inancı, dini, mezhebi veya diğer inançları, kılık ve kıyafeti, dernek, vakıf ya da sendika üyeliği, sağlığı, cinsel hayatı, ceza mahkûmiyeti ve güvenlik tedbirleriyle ilgili verileri ile biyometrik ve genetik verileri özel nitelikli kişisel veridir.') }}</li>
                <li style="margin-bottom: 12px;"><strong>{{ __('Veri İşleyen:') }}</strong> {{ __('Veri sorumlusunun verdiği yetkiye dayanarak onun adına kişisel verileri işleyen gerçek veya tüzel kişi.') }}</li>
                <li style="margin-bottom: 12px;"><strong>{{ __('Veri Sorumlusu:') }}</strong> {{ __('Kişisel verilerin işleme amaçlarını ve vasıtalarını belirleyen, veri kayıt sisteminin kurulmasından ve yönetilmesinden sorumlu olan gerçek veya tüzel kişi.') }}</li>
            </ul>

            <h3 style="color: var(--ink); margin: 40px 0 20px;">2. {{ __('Veri Sorumlusu') }}</h3>
            <p style="margin-bottom: 24px;">{{ __('ISTexpo Fuarcılık Hizmetleri Limited Şirketi (Ayazmaderesi Cad. Saral İş Merkezi No:5/A 34349 Beşiktaş/İstanbul) KVKK kapsamında “Veri Sorumlusu” sıfatıyla hareket etmektedir.') }}</p>

            <h3 style="color: var(--ink); margin: 40px 0 20px;">3. {{ __('Kişisel Verilerin İşlenme Amacı') }}</h3>
            <p style="margin-bottom: 16px;">{{ __('Kişisel verileriniz aşağıdaki amaçlar doğrultusunda işlenebilir:') }}</p>
            <p style="margin-bottom: 24px;">{{ __('ISTexpo Fuarcılık tarafından düzenlenen etkinlikler kapsamında toplanan ad-soyad gibi kimlik, kredi kartı gibi finans, çalıştığınız firma gibi özlük ve e-posta adresi, telefon numarası gibi iletişim kişisel verileriniz, Kanun tarafından öngörülen temel ilkelere uygun olarak ve Kanun’un 5. ve 6. maddelerinde belirtilen kişisel veri işleme şartları ve amaçları dâhilinde; etkinliğe kayıt olabilmeniz ve katılım sağlayabilmeniz amacıyla işlenmektedir.') }}</p>

            <h3 style="color: var(--ink); margin: 40px 0 20px;">4. {{ __('İşlenen Kişisel Verilerin Aktarıldığı Yerler ve Aktarım Amacı') }}</h3>
            <p style="margin-bottom: 24px;">{{ __('Kişisel verileriniz, Kanun’a uygun olarak talep edilmesi halinde resmi kurum ve kuruluşlara ve bu amaçla bağlantılı olarak iş ortaklarımıza aktarılabilmektedir. Kişisel verilerin işlenme amacı ile verilerin aktarım amacı paralellik göstermektedir.') }}</p>

            <h3 style="color: var(--ink); margin: 40px 0 20px;">5. {{ __('Kişisel Verilerin Toplanma Yöntemi ve Hukuki Sebebi') }}</h3>
            <p style="margin-bottom: 24px;">{{ __('Kişisel verileriniz tarafınızca doldurulmakta olan formlar, çağrı merkezleri, elektronik formlar, internet sitesi, anketler, sosyal medya uygulamaları dahil ancak bunlarla sınırlı olmamak üzere, sözlü, yazılı veya elektronik olarak toplanabilir. Kanun’un 5/2 (c) hükmü uyarınca bir sözleşmenin kurulması veya ifası için tarafınıza ait kişisel verilerin işlenmesinin gerekli olması hukuki sebebine dayanılmak suretiyle işlenmektedir.') }}</p>

            <h3 style="color: var(--ink); margin: 40px 0 20px;">6. {{ __('Veri Sorumlusuna Başvuru Yolları ve Haklarınız') }}</h3>
            <p style="margin-bottom: 16px;">{{ __('Kanun’un 11. maddesi uyarınca, Şirketimize başvurarak, kişisel verilerinizin;') }}</p>
            <ul style="list-style: none; padding: 0; margin-bottom: 24px;">
                <li style="margin-bottom: 8px;">• {{ __('İşlenip işlenmediğini öğrenme,') }}</li>
                <li style="margin-bottom: 8px;">• {{ __('İşlenmişse bilgi talep etme,') }}</li>
                <li style="margin-bottom: 8px;">• {{ __('İşlenme amacını ve amacına uygun kullanılıp kullanılmadığını öğrenme,') }}</li>
                <li style="margin-bottom: 8px;">• {{ __('Yurt içinde / yurt dışında transfer edildiği tarafları öğrenme,') }}</li>
                <li style="margin-bottom: 8px;">• {{ __('Eksik / yanlış işlenmişse düzeltilmesini isteme,') }}</li>
                <li style="margin-bottom: 8px;">• {{ __('Kanun’un 7. Maddesinde öngörülen şartlar çerçevesinde silinmesini / yok edilmesini isteme,') }}</li>
                <li style="margin-bottom: 8px;">• {{ __('Aktarıldığı 3. kişilere bildirilmesini isteme,') }}</li>
                <li style="margin-bottom: 8px;">• {{ __('Münhasıran otomatik sistemler ile analiz edilmesi nedeniyle aleyhinize bir sonucun ortaya çıkmasına itiraz etme,') }}</li>
                <li style="margin-bottom: 8px;">• {{ __('Kanun’a aykırı olarak işlenmesi sebebiyle zarara uğramanız hâlinde zararın giderilmesini talep etme hakkına sahipsiniz.') }}</li>
            </ul>
        </div>
    </div>
</section>
@endsection
