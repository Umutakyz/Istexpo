@extends('layouts.admin')

@section('header', 'Anasayfa Fuarları (Öne Çıkanlar)')

@section('content')
<div class="content-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 class="section-title">Anasayfada Gösterilen Fuarlar</h2>
        <a href="{{ route('admin.fairs.create') }}" class="btn btn-primary">+ Yeni Fuar Ekle</a>
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
                <th>Türü</th>
                <th>Tarihler</th>
                <th>Lokasyon</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fairs as $fair)
            <tr>
                <td>{{ $fair->name }}</td>
                <td>
                    @if($fair->type == 'international')
                        <span class="badge" style="background: rgba(47, 129, 247, 0.1); color: #2f81f7; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Uluslararası</span>
                    @else
                        <span class="badge" style="background: rgba(139, 148, 158, 0.1); color: #8b949e; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Geçmiş</span>
                    @endif
                </td>
                <td>{{ $fair->start_date->format('d.m.Y') }} - {{ $fair->end_date->format('d.m.Y') }}</td>
                <td>{{ $fair->location }}</td>
                <td>
                    <div style="display: flex; gap: 16px;">
                        <a href="{{ route('admin.fairs.edit', $fair) }}" style="color: var(--admin-accent);">Düzenle</a>
                        <form action="{{ route('admin.fairs.unfeature', $fair) }}" method="POST" onsubmit="return confirm('Bu fuarı anasayfadan kaldırmak istediğinize emin misiniz? (Fuar sistemden silinmez)')">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: #f85149; cursor: pointer; font-family: inherit; font-size: 14px; padding: 0;">Kaldır</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 24px;">
        {{ $fairs->links() }}
    </div>
</div>
@endsection
