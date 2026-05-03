@extends('layouts.admin')

@section('header', 'Yeni Sektör Ekle')

@section('content')
<div class="content-section" style="max-width: 600px;">
    <form action="{{ route('admin.sectors.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Arka Plan Resmi</label>
            <input type="file" name="image" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
        </div>
        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Sektör Adı</label>
            <input type="text" name="name" required style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Açıklama</label>
            <textarea name="description" rows="4" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none; resize: vertical;"></textarea>
        </div>

        <div style="display: flex; gap: 16px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 32px;">Oluştur</button>
            <a href="{{ route('admin.sectors.index') }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; padding: 12px 32px; text-decoration: none;">İptal</a>
        </div>
    </form>
</div>
@endsection
