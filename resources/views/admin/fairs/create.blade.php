@extends('layouts.admin')

@section('header', 'Yeni Fuar Ekle')

@section('content')
<div class="content-section" style="max-width: 800px;">
    <form action="{{ route('admin.fairs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Fuar Resmi</label>
                <input type="file" name="image" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Tanıtım Videosu</label>
                <input type="file" name="video" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>
            <div style="grid-column: span 2;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Fuar Adı</label>
                <input type="text" name="name" required style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>
            

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Fuar Türü</label>
                <select name="type" required style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
                    <option value="international">Uluslararası Fuar</option>
                    <option value="past">Geçmiş Fuar</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Lokasyon</label>
                <input type="text" name="location" required style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Başlangıç Tarihi</label>
                <input type="date" name="start_date" required style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Bitiş Tarihi</label>
                <input type="date" name="end_date" required style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>

            <div style="grid-column: span 2;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Açıklama</label>
                <textarea name="description" rows="5" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none; resize: vertical;"></textarea>
            </div>

            <!-- Extra Detail Fields -->
            <div style="grid-column: span 2; border-top: 1px solid var(--admin-border); padding-top: 24px; margin-top: 8px;">
                <h3 style="font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 16px;">Fuar Ek Detayları</h3>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Fuar Logosu (Kare)</label>
                <input type="file" name="logo" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>
            
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Fuarın Konusu</label>
                <input type="text" name="subject" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Fuar Alanı (Venue)</label>
                <input type="text" name="venue" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Organizatör</label>
                <input type="text" name="organizer" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Düzenlenme Sayısı</label>
                <input type="text" name="edition" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Teşvik Rakamı</label>
                <input type="text" name="grant_amount" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Web Sitesi</label>
                <input type="url" name="website" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none;" placeholder="https://...">
            </div>

            <div style="grid-column: span 2;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Katılımcı Profili (HTML/Liste)</label>
                <textarea name="exhibitor_profile" rows="5" style="width: 100%; background: #0d1117; border: 1px solid var(--admin-border); padding: 12px 16px; border-radius: 12px; color: #fff; font-family: inherit; outline: none; resize: vertical;"></textarea>
            </div>
        </div>

        <div style="display: flex; gap: 16px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 32px;">Fuar Oluştur</button>
            <a href="{{ route('admin.fairs.index') }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; padding: 12px 32px; text-decoration: none;">İptal</a>
        </div>
    </form>
</div>
@endsection
