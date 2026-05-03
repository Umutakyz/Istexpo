@extends('layouts.admin')

@section('header', 'Ayarlar')

@section('content')
<style>
    .settings-section {
        background: var(--admin-card);
        border: 1px solid var(--admin-border);
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 24px;
    }
    .settings-section h3 {
        font-size: 13px;
        font-weight: 800;
        color: var(--admin-accent);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--admin-border);
    }
    .field-group { margin-bottom: 20px; }
    .field-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: var(--admin-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
    }
    .field-input {
        width: 100%;
        background: rgba(0, 30, 55, 0.6);
        border: 1px solid var(--admin-border);
        padding: 12px 16px;
        border-radius: 12px;
        color: var(--admin-text);
        font-family: 'Manrope', sans-serif;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
    }
    .field-input:focus { border-color: var(--admin-accent); }

    /* Çoklu giriş alanı */
    .multi-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }
    .multi-row .field-input { margin-bottom: 0; }
    .btn-remove-row {
        flex-shrink: 0;
        width: 36px; height: 36px;
        background: rgba(220, 50, 50, 0.12);
        border: 1px solid rgba(220, 50, 50, 0.2);
        border-radius: 10px;
        color: #f47c7c;
        cursor: pointer;
        font-size: 18px;
        line-height: 1;
        display: flex; align-items: center; justify-content: center;
        transition: 0.2s;
    }
    .btn-remove-row:hover { background: rgba(220,50,50,0.25); }
    .btn-add-row {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 6px;
        background: rgba(243, 146, 0, 0.1);
        border: 1px dashed rgba(243, 146, 0, 0.35);
        color: var(--admin-accent);
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
        font-family: 'Manrope', sans-serif;
    }
    .btn-add-row:hover { background: rgba(243,146,0,0.18); border-style: solid; }

    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

    .alert-success {
        background: rgba(34, 197, 94, 0.12);
        border: 1px solid rgba(34, 197, 94, 0.25);
        color: #4ade80;
        padding: 14px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 24px;
    }
    .alert-error {
        background: rgba(220, 50, 50, 0.12);
        border: 1px solid rgba(220, 50, 50, 0.25);
        color: #f87171;
        padding: 14px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 24px;
    }
</style>

<div style="max-width: 860px;">

    @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $err) {{ $err }}<br> @endforeach
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        {{-- Genel Bilgiler --}}
        <div class="settings-section">
            <h3>Genel Bilgiler</h3>
            <div class="field-group">
                <label class="field-label">Site Başlığı</label>
                <input type="text" name="site_title" value="{{ old('site_title', $settings['site_title']) }}" class="field-input">
            </div>
        </div>

        {{-- İletişim E-postaları --}}
        <div class="settings-section">
            <h3>📧 İletişim E-postaları</h3>
            <div id="emails-container">
                @foreach($settings['emails'] as $i => $email)
                <div class="multi-row">
                    <input type="email" name="emails[]" value="{{ old('emails.'.$i, $email) }}"
                           class="field-input" placeholder="ornek@istexpo.com">
                    <button type="button" class="btn-remove-row" onclick="removeRow(this)" title="Sil">×</button>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn-add-row" onclick="addRow('emails-container', 'emails[]', 'email', 'Yeni e-posta ekle...')">
                + E-posta Ekle
            </button>
        </div>

        {{-- İletişim Telefonları --}}
        <div class="settings-section">
            <h3>📞 İletişim Telefonları</h3>
            <div id="phones-container">
                @foreach($settings['phones'] as $i => $phone)
                <div class="multi-row">
                    <input type="tel" name="phones[]" value="{{ old('phones.'.$i, $phone) }}"
                           class="field-input" placeholder="+90 (___) ___ __ __">
                    <button type="button" class="btn-remove-row" onclick="removeRow(this)" title="Sil">×</button>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn-add-row" onclick="addRow('phones-container', 'phones[]', 'tel', '+90 (___) ___ __ __')">
                + Telefon Ekle
            </button>
        </div>

        {{-- Sosyal Medya --}}
        <div class="settings-section">
            <h3>🌐 Sosyal Medya</h3>
            <div class="form-grid-2">
                <div class="field-group">
                    <label class="field-label">Facebook URL</label>
                    <input type="url" name="social_facebook" value="{{ old('social_facebook', $settings['facebook']) }}"
                           class="field-input" placeholder="https://facebook.com/...">
                </div>
                <div class="field-group">
                    <label class="field-label">Instagram URL</label>
                    <input type="url" name="social_instagram" value="{{ old('social_instagram', $settings['instagram']) }}"
                           class="field-input" placeholder="https://instagram.com/...">
                </div>
                <div class="field-group">
                    <label class="field-label">LinkedIn URL</label>
                    <input type="url" name="social_linkedin" value="{{ old('social_linkedin', $settings['linkedin']) }}"
                           class="field-input" placeholder="https://linkedin.com/...">
                </div>
            </div>
        </div>

        {{-- Google Harita --}}
        <div class="settings-section">
            <h3>🗺️ Google Harita (İletişim Sayfası)</h3>

            <div style="background: rgba(243,146,0,0.06); border: 1px solid rgba(243,146,0,0.2); border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; font-size: 13px; line-height: 1.7; color: var(--admin-text-muted);">
                <strong style="color: var(--admin-text);">Nasıl alınır? (Ücretsiz)</strong><br>
                1. <a href="https://maps.google.com" target="_blank" style="color: var(--admin-accent);">maps.google.com</a>'da konumu aratın &nbsp;→&nbsp;
                2. <strong>Paylaş</strong> butonuna tıklayın &nbsp;→&nbsp;
                3. <strong>Haritayı yerleştir</strong> sekmesine geçin &nbsp;→&nbsp;
                4. <code style="background:rgba(255,255,255,0.08); padding:2px 6px; border-radius:4px;">src="..."</code> içindeki URL'yi kopyalayın &nbsp;→&nbsp;
                5. Aşağıya yapıştırın.
            </div>

            <div class="field-group">
                <label class="field-label">Harita Kodu veya URL</label>
                <textarea
                    id="map_embed_url"
                    name="map_embed_url"
                    class="field-input"
                    rows="4"
                    placeholder="Buraya &lt;iframe ...&gt; kodunu VEYA sadece URL'yi yapıştırın"
                    oninput="updateMapPreview(this.value)"
                    style="resize: vertical; font-size: 12px; font-family: monospace;"
                >{{ old('map_embed_url', $settings['map_embed_url']) }}</textarea>
                <p style="font-size: 12px; color: var(--admin-text-muted); margin-top: 6px;">
                    💡 Google Maps'ten kopyaladığınız &lt;iframe&gt; kodunun tamamını yapıştırabilirsiniz — otomatik ayıklanır.
                </p>
            </div>

            {{-- Önizleme --}}
            <div id="map-preview-wrap" style="margin-top: 16px; border-radius: 16px; overflow: hidden; border: 1px solid var(--admin-border); {{ $settings['map_embed_url'] ? '' : 'display:none;' }}">
                <iframe
                    id="map-preview"
                    src="{{ $settings['map_embed_url'] }}"
                    width="100%"
                    height="300"
                    style="border:0; display:block;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Harita Önizleme"
                ></iframe>
            </div>
            <p id="map-empty-hint" style="color: var(--admin-text-muted); font-size: 13px; margin-top: 12px; {{ $settings['map_embed_url'] ? 'display:none;' : '' }}">
                Kod yapıştırınca harita burada önizlenir.
            </p>
        </div>

        <button type="submit" class="btn btn-primary" style="padding: 14px 48px; font-size: 15px;">
            Ayarları Kaydet
        </button>
    </form>
</div>

<script>
function addRow(containerId, name, inputType, placeholder) {
    const container = document.getElementById(containerId);
    const row = document.createElement('div');
    row.className = 'multi-row';
    row.innerHTML = `
        <input type="${inputType}" name="${name}" class="field-input" placeholder="${placeholder}">
        <button type="button" class="btn-remove-row" onclick="removeRow(this)" title="Sil">×</button>
    `;
    container.appendChild(row);
    row.querySelector('input').focus();
}

function removeRow(btn) {
    const container = btn.closest('[id$="-container"]');
    const rows = container.querySelectorAll('.multi-row');
    if (rows.length <= 1) {
        alert('En az bir alan bırakılmalıdır.');
        return;
    }
    btn.closest('.multi-row').remove();
}

function updateMapPreview(raw) {
    const wrap  = document.getElementById('map-preview-wrap');
    const frame = document.getElementById('map-preview');
    const hint  = document.getElementById('map-empty-hint');

    let url = raw.trim();

    // Tam <iframe> kodu yapıştırıldıysa src="..." kısmını çıkar
    const match = url.match(/src=["']([^"']+)["']/);
    if (match) url = match[1];

    if (url.startsWith('https://www.google.com/maps/embed')) {
        frame.src = url;
        wrap.style.display = 'block';
        hint.style.display = 'none';
    } else if (url === '') {
        wrap.style.display = 'none';
        hint.style.display = 'block';
    }
}
</script>
@endsection
