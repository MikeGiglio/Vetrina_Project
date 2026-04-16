@extends('layouts.app')

@section('title', 'Recensioni — Mau House 44 · Palermo')

@section('content')

{{-- ════════════════════════════════════════
     HERO
════════════════════════════════════════ --}}
<section style="background:#08060A;padding:9rem 0 5rem;position:relative;overflow:hidden;">
    {{-- Sfumatura decorativa --}}
    <div style="position:absolute;inset:0;background:radial-gradient(ellipse 60% 60% at 50% 0%,rgba(46,94,50,0.12),transparent);pointer-events:none;"></div>

    <div class="max-w-4xl mx-auto px-6 text-center" style="position:relative;z-index:1;">
        {{-- Back --}}
        <a href="/"
           style="display:inline-flex;align-items:center;gap:0.5rem;font-family:'DM Sans',sans-serif;font-size:0.78rem;font-weight:500;color:rgba(245,239,230,0.45);text-decoration:none;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:2.5rem;transition:color 0.2s;"
           onmouseover="this.style.color='rgba(245,239,230,0.8)'" onmouseout="this.style.color='rgba(245,239,230,0.45)'">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Torna alla home
        </a>

        {{-- Label --}}
        <div style="display:inline-block;padding:0.35rem 1rem;border:1px solid rgba(46,94,50,0.4);border-radius:2rem;font-family:'DM Sans',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.14em;color:rgba(168,212,171,0.8);text-transform:uppercase;margin-bottom:1.5rem;">
            Recensioni degli Ospiti
        </div>

        {{-- Titolo --}}
        <h1 style="font-family:'Playfair Display',serif;font-size:clamp(2.2rem,5vw,3.6rem);font-weight:700;color:#F5EFE6;line-height:1.15;margin-bottom:1.5rem;">
            Le loro parole<br>
            <em style="color:#A8D4AB;">valgono più delle nostre</em>
        </h1>

        {{-- Rating badge --}}
        <div style="display:inline-flex;align-items:center;gap:1rem;padding:0.75rem 1.75rem;background:rgba(46,94,50,0.1);border:1px solid rgba(46,94,50,0.25);border-radius:2rem;margin-bottom:0.75rem;">
            <div style="font-size:1.2rem;color:#FFD700;">★★★★★</div>
            <div style="font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;color:#A8D4AB;line-height:1;">9,6
                <span style="font-size:0.85rem;font-weight:500;color:rgba(245,239,230,0.45);">/10</span>
            </div>
            <div style="font-family:'DM Sans',sans-serif;font-size:0.8rem;color:rgba(245,239,230,0.45);">su Airbnb & Booking</div>
        </div>

        <div style="font-family:'DM Sans',sans-serif;font-size:0.78rem;color:rgba(245,239,230,0.3);letter-spacing:0.06em;">
            {{ count($reviews) }} recensioni verificate
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     GRIGLIA RECENSIONI
════════════════════════════════════════ --}}
<section style="background:#FDFAF5;padding:5rem 0 4rem;">
    <div class="max-w-7xl mx-auto px-6">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($reviews as $i => $r)
                <div class="review-card" style="animation:fadeUp 0.5s ease both;animation-delay:{{ ($i % 6) * 0.07 }}s;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                        <div class="stars" style="font-size:0.85rem;">{{ $r[4] }}</div>
                        <span style="display:inline-flex;align-items:center;gap:0.2rem;padding:0.2rem 0.55rem;background:{{ $r[8] }};border-radius:1rem;font-family:'DM Sans',sans-serif;font-size:0.68rem;font-weight:700;color:#fff;">
                            {{ $r[3] }}<span style="opacity:0.7;font-weight:400;">/10</span>
                        </span>
                    </div>
                    <p style="font-family:'DM Sans',sans-serif;font-size:0.88rem;line-height:1.75;color:#3C3C38;margin-bottom:1.5rem;">
                        "{{ $r[7] }}"</p>
                    <div style="display:flex;align-items:center;gap:0.75rem;padding-top:1rem;border-top:1px solid #DDD8CE;">
                        <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,{{ $r[8] }},#1C3320);display:flex;align-items:center;justify-content:center;font-family:'DM Sans',sans-serif;font-size:0.7rem;font-weight:700;color:white;flex-shrink:0;">
                            {{ $r[2] }}</div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-family:'DM Sans',sans-serif;font-size:0.85rem;font-weight:600;color:#1A1A18;">{{ $r[0] }}</div>
                            <div style="font-family:'DM Sans',sans-serif;font-size:0.7rem;color:rgba(90,122,98,0.6);">{{ $r[1] }}</div>
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            <div style="font-family:'DM Sans',sans-serif;font-size:0.62rem;color:rgba(90,122,98,0.45);">{{ $r[5] }}</div>
                            <div style="font-family:'DM Sans',sans-serif;font-size:0.62rem;color:rgba(90,122,98,0.35);">{{ $r[6] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Bottoni piattaforme --}}
        <div style="display:flex;justify-content:center;align-items:center;gap:1rem;margin-top:3.5rem;flex-wrap:wrap;">
            <a href="https://www.booking.com/hotel/it/mau-house-44-apartment.it.html"
               target="_blank" rel="noopener"
               style="display:inline-flex;align-items:center;gap:0.6rem;padding:0.85rem 1.75rem;background:#003580;color:#fff;font-family:'DM Sans',sans-serif;font-size:0.82rem;font-weight:600;border-radius:0.5rem;text-decoration:none;transition:opacity 0.2s;"
               onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;"><rect x="3" y="3" width="18" height="18" rx="3" ry="3" fill="none" stroke="currentColor" stroke-width="2"/><path d="M7 12h10M7 8h6M7 16h8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" fill="none"/></svg>
                {{ __('reviews.view_booking') }}
            </a>
            <a href="https://www.airbnb.it/rooms/34062811"
               target="_blank" rel="noopener"
               style="display:inline-flex;align-items:center;gap:0.6rem;padding:0.85rem 1.75rem;background:#FF5A5F;color:#fff;font-family:'DM Sans',sans-serif;font-size:0.82rem;font-weight:600;border-radius:0.5rem;text-decoration:none;transition:opacity 0.2s;"
               onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
                {{ __('reviews.view_airbnb') }}
            </a>
        </div>

        {{-- Back link --}}
        <div style="text-align:center;margin-top:2rem;">
            <a href="/"
               style="font-family:'DM Sans',sans-serif;font-size:0.8rem;color:rgba(90,122,98,0.5);text-decoration:none;transition:color 0.2s;"
               onmouseover="this.style.color='#2E5E32'" onmouseout="this.style.color='rgba(90,122,98,0.5)'">
                ← Torna alla home
            </a>
        </div>

    </div>
</section>

@push('styles')
<style>
@keyframes fadeUp {
    from { opacity:0; transform:translateY(20px); }
    to   { opacity:1; transform:translateY(0); }
}
</style>
@endpush

@endsection
