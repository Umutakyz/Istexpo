@extends('layouts.admin')

@section('header', 'Temsilcilikler')

@section('content')
<div class="content-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <h2 class="section-title" style="margin-bottom: 0;">Temsilci Listesi</h2>
        <a href="{{ route('admin.representations.create') }}" class="btn btn-primary">Yeni Temsilci Ekle</a>
    </div>

    @if(session('success'))
        <div style="background: rgba(63, 185, 80, 0.1); color: #3fb950; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Logo</th>
                <th>Temsilci Adı</th>
                <th>Web Sitesi</th>
                <th>Sıra</th>
                <th style="text-align: right;">İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($representations as $item)
            <tr>
                <td>
                    @if($item->logo)
                        <img src="{{ asset('storage/' . $item->logo) }}" alt="" style="height: 40px; border-radius: 4px;">
                    @else
                        <div style="width: 40px; height: 40px; background: #333; border-radius: 4px; display: grid; place-items: center; font-size: 10px;">YOK</div>
                    @endif
                </td>
                <td style="font-weight: 700;">{{ $item->name }}</td>
                <td><a href="{{ $item->website }}" target="_blank" style="color: var(--admin-accent);">{{ $item->website }}</a></td>
                <td>{{ $item->order }}</td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                        <a href="{{ route('admin.representations.edit', $item->id) }}" class="btn" style="background: rgba(243,146,0,0.1); color: var(--admin-accent); padding: 8px 12px;">Düzenle</a>
                        <form action="{{ route('admin.representations.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background: rgba(248, 81, 73, 0.1); color: #f85149; padding: 8px 12px;">Sil</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
