@if ($paginator->hasPages())
<div style="display: flex; flex-direction: column; align-items: center; gap: 10px; margin: 40px 0;">
    {{-- Sayfa Bilgisi --}}
    <p style="font-size: 11px; color: #5a6a7a; margin: 0;">
        {{ __('Showing') }} {{ $paginator->firstItem() }} {{ __('to') }} {{ $paginator->lastItem() }} {{ __('of') }} {{ $paginator->total() }} {{ __('results') }}
    </p>

    {{-- Butonlar --}}
    <div style="display: flex; flex-direction: row; gap: 4px; align-items: center; flex-wrap: wrap; justify-content: center;">

        {{-- Geri Butonu --}}
        @if ($paginator->onFirstPage())
            <span style="display:inline-flex;align-items:center;justify-content:center;height:30px;padding:0 12px;border-radius:6px;background:#f4f6f9;color:#b0b8c5;font-size:12px;font-weight:600;cursor:not-allowed;">‹ Geri</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="display:inline-flex;align-items:center;justify-content:center;height:30px;padding:0 12px;border-radius:6px;background:#f4f6f9;color:#002B49;font-size:12px;font-weight:600;text-decoration:none;transition:0.2s;" onmouseover="this.style.background='#d6e4f0'" onmouseout="this.style.background='#f4f6f9'">‹ Geri</a>
        @endif

        {{-- Sayfa Numaraları --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:6px;background:transparent;color:#5a6a7a;font-size:12px;">…</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:6px;background:#002B49;color:#fff;font-size:12px;font-weight:700;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:6px;background:#f4f6f9;color:#002B49;font-size:12px;font-weight:600;text-decoration:none;transition:0.2s;" onmouseover="this.style.background='#d6e4f0'" onmouseout="this.style.background='#f4f6f9'">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- İleri Butonu --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="display:inline-flex;align-items:center;justify-content:center;height:30px;padding:0 12px;border-radius:6px;background:#f4f6f9;color:#002B49;font-size:12px;font-weight:600;text-decoration:none;transition:0.2s;" onmouseover="this.style.background='#d6e4f0'" onmouseout="this.style.background='#f4f6f9'">İleri ›</a>
        @else
            <span style="display:inline-flex;align-items:center;justify-content:center;height:30px;padding:0 12px;border-radius:6px;background:#f4f6f9;color:#b0b8c5;font-size:12px;font-weight:600;cursor:not-allowed;">İleri ›</span>
        @endif

    </div>
</div>
@endif
