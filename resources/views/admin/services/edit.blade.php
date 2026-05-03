@extends('layouts.admin')

@section('header', 'Hizmeti Düzenle')

@section('content')
<div class="content-section" style="max-width: 600px;">
    <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Hizmet Adı</label>
            <input type="text" name="name" value="{{ old('name', $service->name) }}" required style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Açıklama</label>
            <textarea name="description" rows="4" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none; resize: vertical;">{{ old('description', $service->description) }}</textarea>
        </div>

        <div style="display: flex; gap: 16px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 32px;">Güncelle</button>
            <a href="{{ route('admin.services.index') }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; padding: 12px 32px; text-decoration: none;">İptal</a>
        </div>
    </form>
</div>
@endsection
