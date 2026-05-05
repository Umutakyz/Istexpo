@extends('layouts.admin')

@section('header', 'Yeni Haber Ekle')

@section('content')
<div class="content-section" style="max-width: 800px;">
    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr; gap: 24px; margin-bottom: 24px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Haber Görseli</label>
                <input type="file" name="image" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Haber Videoları (Çoklu Seçilebilir)</label>
                <input type="file" name="videos[]" multiple style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
                <small style="display: block; color: var(--admin-text-muted); margin-top: 4px;">Birden fazla video seçebilirsiniz (mp4, mov, vb.)</small>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Haber Başlığı</label>
                <input type="text" name="title" required style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Kısa Özet (Opsiyonel)</label>
                <textarea name="summary" rows="3" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none; resize: vertical;"></textarea>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Haber İçeriği</label>
                <textarea name="content" rows="10" required class="admin-input editor"></textarea>
            </div>

            <div style="display: flex; align-items: center; gap: 12px;">
                <input type="checkbox" name="is_active" value="1" checked id="is_active" style="width: 18px; height: 18px; accent-color: var(--admin-accent);">
                <label for="is_active" style="font-size: 14px; font-weight: 600; color: #fff; cursor: pointer;">Sitede Göster (Aktif)</label>
            </div>
        </div>

        <div style="display: flex; gap: 16px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 32px;">Haber Oluştur</button>
            <a href="{{ route('admin.news.index') }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; padding: 12px 32px; text-decoration: none;">İptal</a>
        </div>
    </form>
</div>
@endsection
