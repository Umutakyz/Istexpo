@extends('layouts.admin')

@section('header', 'Haberler')

@section('content')
<div class="content-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="font-size: 18px; font-weight: 700; color: #fff;">Tüm Haberler</h2>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary" style="text-decoration: none;">+ Yeni Haber Ekle</a>
    </div>

    @if(session('success'))
        <div style="background: rgba(46, 160, 67, 0.1); border: 1px solid rgba(46, 160, 67, 0.4); color: #3fb950; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-weight: 600; font-size: 13px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="border-bottom: 1px solid var(--admin-border); color: var(--admin-text-muted);">
                    <th style="padding: 16px 16px 16px 0; font-weight: 600;">Görsel</th>
                    <th style="padding: 16px; font-weight: 600;">Başlık</th>
                    <th style="padding: 16px; font-weight: 600;">Durum</th>
                    <th style="padding: 16px; font-weight: 600;">Tarih</th>
                    <th style="padding: 16px 0 16px 16px; font-weight: 600; text-align: right;">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                    <tr style="border-bottom: 1px solid var(--admin-border); transition: 0.2s;">
                        <td style="padding: 16px 16px 16px 0;">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="" style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px;">
                            @else
                                <div style="width: 60px; height: 40px; background: rgba(255,255,255,0.05); border-radius: 6px; display: grid; place-items: center; color: var(--admin-text-muted); font-size: 10px;">Görsel Yok</div>
                            @endif
                        </td>
                        <td style="padding: 16px; color: #fff; font-weight: 600;">{{ $item->title }}</td>
                        <td style="padding: 16px;">
                            @if($item->is_active)
                                <span style="background: rgba(46, 160, 67, 0.1); color: #3fb950; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 700;">Aktif</span>
                            @else
                                <span style="background: rgba(248, 81, 73, 0.1); color: #f85149; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 700;">Pasif</span>
                            @endif
                        </td>
                        <td style="padding: 16px; color: var(--admin-text-muted);">{{ $item->created_at->format('d.m.Y') }}</td>
                        <td style="padding: 16px 0 16px 16px; text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a href="{{ route('admin.news.edit', $item) }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; text-decoration: none; padding: 6px 12px; font-size: 12px;">Düzenle</a>
                                <form action="{{ route('admin.news.destroy', $item) }}" method="POST" onsubmit="return confirm('Bu haberi silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="background: rgba(248, 81, 73, 0.1); color: #f85149; border: none; padding: 6px 12px; font-size: 12px;">Sil</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 32px 0; text-align: center; color: var(--admin-text-muted);">Henüz haber eklenmemiş.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 24px;">
        {{ $news->links() }}
    </div>
</div>
@endsection
