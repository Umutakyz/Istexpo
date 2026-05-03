@extends('layouts.admin')

@section('header', 'Haberi Düzenle')

@section('content')
<div class="content-section" style="max-width: 800px;">
    <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="display: grid; grid-template-columns: 1fr; gap: 24px; margin-bottom: 24px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Haber Görseli</label>
                @if($news->image)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ asset('storage/' . $news->image) }}" alt="" style="height: 100px; border-radius: 12px; border: 1px solid var(--admin-border); object-fit: cover;">
                    </div>
                @endif
                <input type="file" name="image" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Haber Başlığı</label>
                <input type="text" name="title" value="{{ $news->title }}" required style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Kısa Özet (Opsiyonel)</label>
                <textarea name="summary" rows="3" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none; resize: vertical;">{{ $news->summary }}</textarea>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Haber İçeriği</label>
                <textarea name="content" rows="10" required style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none; resize: vertical;">{{ $news->content }}</textarea>
            </div>

            <div style="display: flex; align-items: center; gap: 12px;">
                <input type="checkbox" name="is_active" value="1" {{ $news->is_active ? 'checked' : '' }} id="is_active" style="width: 18px; height: 18px; accent-color: var(--admin-accent);">
                <label for="is_active" style="font-size: 14px; font-weight: 600; color: #fff; cursor: pointer;">Sitede Göster (Aktif)</label>
            </div>
        </div>

        <div style="display: flex; gap: 16px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 32px;">Güncelle</button>
            <a href="{{ route('admin.news.index') }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; padding: 12px 32px; text-decoration: none;">İptal</a>
        </div>
    </form>
</div>
@endsection
