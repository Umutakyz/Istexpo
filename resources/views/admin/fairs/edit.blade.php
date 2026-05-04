@extends('layouts.admin')

@section('header', 'Fuarı Düzenle')

@section('content')
<div class="content-section" style="max-width: 800px;">
    <form action="{{ route('admin.fairs.update', $fair) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Fuar Resmi</label>
                @if($fair->image)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ asset('storage/' . $fair->image) }}" alt="" style="height: 100px; border-radius: 12px; border: 1px solid var(--admin-border);">
                    </div>
                @endif
                <input type="file" name="image" class="admin-input">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Tanıtım Videosu</label>
                @if($fair->video)
                    <div style="margin-bottom: 12px;">
                        <span class="badge badge-success">Video Mevcut</span>
                    </div>
                @endif
                <input type="file" name="video" class="admin-input">
            </div>
            <div style="grid-column: span 2;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Fuar Adı</label>
                <input type="text" name="name" value="{{ $fair->name }}" required class="admin-input">
            </div>


            

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Fuar Türü</label>
                <select name="type" required class="admin-input">
                    <option value="international" {{ $fair->type == 'international' ? 'selected' : '' }}>Uluslararası Fuar</option>
                    <option value="past" {{ $fair->type == 'past' ? 'selected' : '' }}>Geçmiş Fuar</option>
                </select>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; margin-top: 28px;">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ $fair->is_featured ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--admin-primary); cursor: pointer;">
                <label for="is_featured" style="font-size: 14px; font-weight: 600; color: #fff; cursor: pointer;">Anasayfada Göster (Gelecek Sergiler)</label>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Lokasyon</label>
                <input type="text" name="location" value="{{ $fair->location }}" required class="admin-input">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Başlangıç Tarihi</label>
                <input type="date" name="start_date" value="{{ $fair->start_date->format('Y-m-d') }}" required class="admin-input">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Bitiş Tarihi</label>
                <input type="date" name="end_date" value="{{ $fair->end_date->format('Y-m-d') }}" required class="admin-input">
            </div>

            <div style="grid-column: span 2;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Açıklama</label>
                <textarea name="description" rows="5" class="admin-input" style="height: auto; resize: vertical;">{{ $fair->description }}</textarea>
            </div>

            <!-- Extra Detail Fields -->
            <div style="grid-column: span 2; border-top: 1px solid var(--admin-border); padding-top: 24px; margin-top: 8px;">
                <h3 style="font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 16px;">Fuar Ek Detayları</h3>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Fuar Logosu (Kare)</label>
                @if($fair->logo)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ asset('storage/' . $fair->logo) }}" alt="" style="height: 60px; border-radius: 8px; border: 1px solid var(--admin-border); background: #fff; padding: 4px;">
                    </div>
                @endif
                <input type="file" name="logo" class="admin-input">
            </div>
            
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Fuarın Konusu</label>
                <input type="text" name="subject" value="{{ $fair->subject }}" class="admin-input">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Fuar Alanı (Venue)</label>
                <input type="text" name="venue" value="{{ $fair->venue }}" class="admin-input">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Organizatör</label>
                <input type="text" name="organizer" value="{{ $fair->organizer }}" class="admin-input">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Düzenlenme Sayısı</label>
                <input type="text" name="edition" value="{{ $fair->edition }}" class="admin-input">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Teşvik Rakamı</label>
                <input type="text" name="grant_amount" value="{{ $fair->grant_amount }}" class="admin-input">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Web Sitesi</label>
                <input type="url" name="website" value="{{ $fair->website }}" class="admin-input" placeholder="https://...">
            </div>

            <div style="grid-column: span 2;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Katılımcı Profili (HTML/Liste)</label>
                <textarea name="exhibitor_profile" rows="5" class="admin-input" style="height: auto; resize: vertical;">{{ $fair->exhibitor_profile }}</textarea>
            </div>
        </div>

        <div style="display: flex; gap: 16px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 32px;">Güncelle</button>
            <a href="{{ route('admin.fairs.index') }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; padding: 12px 32px; text-decoration: none;">İptal</a>
        </div>
    </form>
</div>
@endsection
