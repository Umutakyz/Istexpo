@extends('layouts.admin')

@section('content')
<div class="dashboard-grid">
    <div class="stat-card">
        <div class="stat-label">Toplam Fuar</div>
        <div class="stat-value">{{ $fairCount }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Aktif Sektör</div>
        <div class="stat-value">{{ $sectorCount }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Mesajlar</div>
        <div class="stat-value">0</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Aboneler</div>
        <div class="stat-value">0</div>
    </div>
</div>

<div class="content-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 class="section-title">Son Eklenen Fuarlar</h2>
        <a href="{{ route('admin.fairs.create') }}" class="btn btn-primary">+ Yeni Fuar Ekle</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Etkinlik Adı</th>
                <th>Sektör</th>
                <th>Tarih</th>
                <th>Durum</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentFairs as $fair)
            <tr>
                <td>{{ $fair->name }}</td>
                <td>{{ $fair->sector->name }}</td>
                <td>{{ $fair->start_date->format('d.m.Y') }}</td>
                <td><span class="badge badge-success">Gelecek</span></td>
                <td><a href="{{ route('admin.fairs.edit', $fair) }}" style="color: var(--admin-accent);">Düzenle</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: var(--admin-text-muted);">Fuar bulunamadı.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
