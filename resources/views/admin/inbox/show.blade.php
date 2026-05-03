@extends('layouts.admin')

@section('header', 'Mesaj Detayı')

@section('content')
<div class="content-section" style="max-width: 800px;">
    <div style="margin-bottom: 32px; border-bottom: 1px solid var(--admin-border); padding-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
            <div>
                <h2 style="font-size: 24px; font-weight: 800; margin-bottom: 4px;">{{ $message->subject ?? 'Konu Yok' }}</h2>
                <div style="color: var(--admin-text-muted); font-size: 14px;">
                    <strong>{{ $message->name }}</strong> &lt;{{ $message->email }}&gt;
                </div>
            </div>
            <div style="color: var(--admin-text-muted); font-size: 13px;">
                {{ $message->created_at->format('d F Y, H:i') }}
            </div>
        </div>
    </div>

    <div style="line-height: 1.8; font-size: 16px; color: var(--admin-text); white-space: pre-wrap; margin-bottom: 40px;">
        {{ $message->message }}
    </div>

    <div style="display: flex; gap: 16px;">
        <a href="{{ route('admin.inbox.index') }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; padding: 12px 24px; text-decoration: none;">Geri Dön</a>
        <form action="{{ route('admin.inbox.destroy', $message) }}" method="POST" onsubmit="return confirm('Emin misiniz?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn" style="background: rgba(248, 81, 73, 0.1); color: #f85149; padding: 12px 24px;">Bu Mesajı Sil</button>
        </form>
    </div>
</div>
@endsection
