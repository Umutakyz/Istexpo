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
        <div style="max-width: 900px; line-height: 1.8; color: var(--muted);">
            <p style="margin-bottom: 24px;">{{ __('Değerli Ziyaretçilerimiz ve İş Ortaklarımız,') }}</p>
            <p style="margin-bottom: 24px;">{{ __('6698 Sayılı Kişisel Verilerin Korunması Kanunu (“KVKK”) uyarınca, ISTexpo Fuarcılık Hizmetleri Ltd. Şti. (“Şirket”) olarak, veri sorumlusu sıfatıyla, kişisel verilerinizin aşağıda açıklandığı çerçevede kaydedileceğini, depolanacağını, muhafaza edileceğini, güncelleneceğini, yeniden düzenleneceğini, mevzuatın izin verdiği durumlarda ve ölçüde üçüncü kişilere açıklanabileceğini, devredilebileceğini, sınıflandırılabileceğini ve KVKK’da sayılan diğer şekillerde işlenebileceğini belirtmek isteriz.') }}</p>
            
            <h3 style="color: var(--ink); margin: 40px 0 20px;">1. {{ __('Kişisel Verilerin İşlenme Amacı') }}</h3>
            <p style="margin-bottom: 24px;">{{ __('Kişisel verileriniz; Şirketimiz tarafından sunulan ürün ve hizmetlerden sizleri faydalandırmak için gerekli çalışmaların iş birimlerimiz tarafından yapılması, ürün ve hizmetlerimizin sizlerin beğeni, kullanım alışkanlıkları ve ihtiyaçlarına göre özelleştirilerek sizlere önerilmesi, Şirketimizin ve Şirketimizle iş ilişkisi içerisinde olan kişilerin hukuki ve ticari güvenliğinin temini amaçlarıyla işlenmektedir.') }}</p>
            
            <h3 style="color: var(--ink); margin: 40px 0 20px;">2. {{ __('İşlenen Kişisel Verilerin Aktarımı') }}</h3>
            <p style="margin-bottom: 24px;">{{ __('Toplanan kişisel verileriniz; yukarıda belirtilen amaçların gerçekleştirilmesi doğrultusunda, iş ortaklarımıza, tedarikçilerimize, kanunen yetkili kamu kurumlarına ve özel kişilere aktarılabilecektir.') }}</p>
            
            <h3 style="color: var(--ink); margin: 40px 0 20px;">3. {{ __('Kişisel Veri Sahibinin Hakları') }}</h3>
            <p style="margin-bottom: 24px;">{{ __('Kişisel veri sahibi olarak KVKK’nın 11. maddesi uyarınca; verilerinizin işlenip işlenmediğini öğrenme, işlenmişse bilgi talep etme, işlenme amacını ve amacına uygun kullanılıp kullanılmadığını öğrenme, yurt içinde veya yurt dışında aktarıldığı üçüncü kişileri bilme, eksik veya yanlış işlenmişse düzeltilmesini isteme haklarına sahipsiniz.') }}</p>
        </div>
    </div>
</section>
@endsection
