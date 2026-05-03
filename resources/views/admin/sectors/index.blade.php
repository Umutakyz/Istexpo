@extends('layouts.admin')

@section('header', 'Sektör Yönetimi')

@section('content')
<div class="content-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 class="section-title">Tüm Sektörler</h2>
        <a href="{{ route('admin.sectors.create') }}" class="btn btn-primary">+ Yeni Sektör Ekle</a>
    </div>

    @if(session('success'))
        <div style="background: rgba(63, 185, 80, 0.1); color: #3fb950; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Ad</th>
                <th>Slug</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sectors as $sector)
            <tr>
                <td>{{ $sector->name }}</td>
                <td>{{ $sector->slug }}</td>
                <td>
                    <div style="display: flex; gap: 16px;">
                        <a href="{{ route('admin.sectors.edit', $sector) }}" style="color: var(--admin-accent);">Düzenle</a>
                        <form action="{{ route('admin.sectors.destroy', $sector) }}" method="POST" onsubmit="return confirm('Emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #f85149; cursor: pointer; font-family: inherit; font-size: 14px; padding: 0;">Sil</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top: 24px;">
        {{ $sectors->links() }}
    </div>
</div>
@endsection
