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
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Diğer Resimler (Galeri)</label>
                @if($fair->images)
                    <div style="display: flex; gap: 15px; margin-bottom: 15px; flex-wrap: wrap;">
                        @foreach($fair->images as $img)
                            <div class="gallery-item" style="position: relative; width: 80px; height: 80px; border: 1px solid var(--admin-border); border-radius: 8px; overflow: hidden; background: #fff; transition: all 0.3s;">
                                <img src="{{ asset('storage/' . $img) }}" style="width: 100%; height: 100%; object-fit: contain;">
                                <label style="position: absolute; top: 0; right: 0; background: rgba(0,0,0,0.5); color: #fff; padding: 2px 5px; cursor: pointer; border-bottom-left-radius: 8px; font-size: 10px; transition: all 0.3s;" onclick="toggleDelete(this)">
                                    <input type="checkbox" name="remove_images[]" value="{{ $img }}" style="display: none;">
                                    <span>Sil</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <script>
                        function toggleDelete(label) {
                            const container = label.closest('.gallery-item');
                            const checkbox = label.querySelector('input');
                            const span = label.querySelector('span');
                            setTimeout(() => {
                                if (checkbox.checked) {
                                    container.style.opacity = '0.3';
                                    container.style.border = '2px solid red';
                                    label.style.background = 'red';
                                    span.innerText = 'SİLİNECEK';
                                } else {
                                    container.style.opacity = '1';
                                    container.style.border = '1px solid var(--admin-border)';
                                    label.style.background = 'rgba(0,0,0,0.5)';
                                    span.innerText = 'Sil';
                                }
                            }, 50);
                        }
                    </script>
                    <p style="font-size: 11px; color: var(--admin-text-muted); margin-bottom: 12px;">* Silmek istediğiniz resimlerin üzerindeki 'Sil' butonuna tıklayın.</p>
                @endif
                <input type="file" name="images[]" multiple class="admin-input">
                <p style="font-size: 11px; color: var(--admin-text-muted); margin-top: 5px;">Yeni resimler yüklerseniz mevcut listeye eklenir.</p>
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
                <textarea name="description" rows="5" class="admin-input editor">{{ $fair->description }}</textarea>
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
                <input type="text" name="website" value="{{ $fair->website }}" class="admin-input" placeholder="https://...">
            </div>

            <div style="grid-column: span 2;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px;">Katılımcı Profili (Liste)</label>
                <textarea name="exhibitor_profile" rows="5" class="admin-input editor">{{ $fair->exhibitor_profile }}</textarea>
            </div>
        </div>

        <div style="display: flex; gap: 16px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 32px;">Güncelle</button>
            <a href="{{ route('admin.fairs.index') }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; padding: 12px 32px; text-decoration: none;">İptal</a>
        </div>
    </form>
</div>
@endsection
