@extends('layouts.admin')

@section('header', 'Gelen Kutusu')

@section('content')
<div class="content-section">
    <h2 class="section-title">Mesajlar</h2>
    <table>
        <thead>
            <tr>
                <th>Gönderen</th>
                <th>Konu</th>
                <th>Tarih</th>
                <th>Durum</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $message)
            <tr style="{{ $message->is_read ? 'opacity: 0.6;' : 'font-weight: 700;' }}">
                <td>{{ $message->name }} <br> <small style="font-weight: 400; opacity: 0.7;">{{ $message->email }}</small></td>
                <td>{{ $message->subject ?? 'Konu Yok' }}</td>
                <td>{{ $message->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    @if($message->is_read)
                        <span class="badge" style="background: rgba(255,255,255,0.05); color: #8b949e;">Okundu</span>
                    @else
                        <span class="badge badge-success">Yeni</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 16px;">
                        <a href="{{ route('admin.inbox.show', $message) }}" style="color: var(--admin-accent);">Oku</a>
                        <form action="{{ route('admin.inbox.destroy', $message) }}" method="POST" onsubmit="return confirm('Emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #f85149; cursor: pointer; font-family: inherit; font-size: 14px; padding: 0;">Sil</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: var(--admin-text-muted);">Henüz mesaj bulunmuyor.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top: 24px;">
        {{ $messages->links() }}
    </div>
</div>
@endsection
