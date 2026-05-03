@extends('layouts.admin')

@section('header', 'Temsilci Düzenle')

@section('content')
<div class="content-section" style="max-width: 800px;">
    <form action="{{ route('admin.representations.update', $representation->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--admin-text-muted);">Temsilci Adı</label>
            <input type="text" name="name" value="{{ $representation->name }}" style="width: 100%; padding: 12px; background: #0d1117; border: 1px solid var(--admin-border); border-radius: 8px; color: #fff;" required>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--admin-text-muted);">Logo</label>
            @if($representation->logo)
                <div style="margin-bottom: 12px;">
                    <img src="{{ asset('storage/' . $representation->logo) }}" alt="" style="height: 60px; border-radius: 8px; border: 1px solid var(--admin-border); padding: 8px;">
                </div>
            @endif
            <input type="file" name="logo" style="width: 100%; padding: 12px; background: #0d1117; border: 1px solid var(--admin-border); border-radius: 8px; color: #fff;">
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--admin-text-muted);">Web Sitesi (URL)</label>
            <input type="url" name="website" value="{{ $representation->website }}" style="width: 100%; padding: 12px; background: #0d1117; border: 1px solid var(--admin-border); border-radius: 8px; color: #fff;">
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--admin-text-muted);">Sıralama</label>
            <input type="number" name="order" value="{{ $representation->order }}" style="width: 100%; padding: 12px; background: #0d1117; border: 1px solid var(--admin-border); border-radius: 8px; color: #fff;">
        </div>

        <div style="margin-bottom: 32px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--admin-text-muted);">Açıklama</label>
            <textarea name="description" rows="5" style="width: 100%; padding: 12px; background: #0d1117; border: 1px solid var(--admin-border); border-radius: 8px; color: #fff;">{{ $representation->description }}</textarea>
        </div>

        <div style="display: flex; gap: 16px;">
            <button type="submit" class="btn btn-primary">Güncelle</button>
            <a href="{{ route('admin.representations.index') }}" class="btn" style="background: transparent; color: var(--admin-text-muted); border: 1px solid var(--admin-border);">İptal</a>
        </div>
    </form>
</div>
@endsection
