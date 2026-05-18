@extends('layouts.app')

@section('title', 'Mau House 44 — Appartamento di lusso a Palermo')

@section('content')

    {{-- ════════════════════════════════════════
     HERO
════════════════════════════════════════ --}}
    <section id="hero" class="hero-bg relative min-h-screen flex items-center overflow-hidden">
        <div class="hero-grid absolute inset-0 pointer-events-none"></div>
        <img src="/images/house/11.avif" alt="" aria-hidden="true"
            style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;opacity:0.12;z-index:0;"
            loading="eager">
        {{-- Overlay scuro extra su mobile --}}
        <div class="hero-mobile-overlay" aria-hidden="true"></div>

        <div class="absolute top-0 right-0 w-[700px] h-[700px] pointer-events-none"
            style="background:radial-gradient(circle,rgba(22,163,74,0.08) 0%,transparent 70%);transform:translate(30%,-30%);">
        </div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] pointer-events-none"
            style="background:radial-gradient(circle,rgba(255,255,255,0.03) 0%,transparent 70%);transform:translate(-30%,20%);">
        </div>

        {{-- Wheel (desktop ≥ 1024px) --}}
        <div class="hero-wheel-wrap">
            <div class="hero-wheel">
                @foreach ([['/images/house/6.jpg', 'Soggiorno'], ['/images/house/3.avif', 'Camera'], ['/images/house/4.jpg', 'Cucina'], ['/images/house/10.avif', 'Terrazza'], ['/images/house/9.avif', 'Vista'], ['/images/house/5.jpeg', 'Dettaglio']] as $wi => $wp)
                    <div class="wheel-slot" style="--wi:{{ $wi }}">
                        <div class="wheel-card">
                            <img src="{{ $wp[0] }}" alt="{{ $wp[1] }}" loading="lazy">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="hero-content relative z-10 max-w-7xl mx-auto px-6 pt-28 pb-20 w-full">
            <div class="max-w-2xl hero-inner">

                {{-- Badge location + rating --}}
                <div class="flex flex-wrap items-center gap-2 mb-8 reveal">
                    <div
                        style="padding:0.4rem 1rem;background:rgba(22,163,74,0.1);border:1px solid rgba(22,163,74,0.25);border-radius:2rem;display:inline-flex;align-items:center;gap:0.5rem;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#16A34A"
                            stroke-width="2.5">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                            <circle cx="12" cy="9" r="2.5" />
                        </svg>
                        <span
                            style="font-family:'DM Sans',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.2em;text-transform:uppercase;color:#16A34A;">{{ __('hero.badge_location') }}</span>
                    </div>
                    <div
                        style="padding:0.4rem 0.9rem;background:rgba(240,245,241,0.05);border:1px solid rgba(240,245,241,0.1);border-radius:2rem;display:inline-flex;align-items:center;gap:0.4rem;">
                        <span class="stars" style="font-size:0.75rem;">★★★★★</span>
                        <span
                            style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(240,245,241,0.65);">{{ __('hero.badge_rating') }}</span>
                    </div>
                </div>

                {{-- Headline --}}
                <h1 class="hero-headline reveal reveal-delay-1" style="font-size:clamp(3rem,7vw,5.5rem);font-weight:700;">
                    <span style="color:#FDFAF5;">{{ __('hero.headline_1') }}</span><br>
                    <span style="color:#A8D4AB;">{{ __('hero.headline_2') }}</span><br>
                    <span style="color:#FDFAF5;">{{ __('hero.headline_3') }}</span>
                </h1>

                <p class="reveal reveal-delay-2"
                    style="margin-top:1.75rem;font-family:'DM Sans',sans-serif;font-size:1.05rem;line-height:1.7;color:rgba(240,245,241,0.5);max-width:480px;">
                    {{ __('hero.subtitle') }}
                </p>

                {{-- CTAs --}}
                <div class="hero-ctas reveal reveal-delay-3">
                    <button data-open-booking class="btn-primary" type="button">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                            <path
                                d="M11.999 0C5.373 0 0 5.373 0 12c0 2.118.554 4.1 1.522 5.817L.031 23.93l6.266-1.642A11.935 11.935 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.797 9.797 0 0 1-5.003-1.37l-.356-.213-3.721.976.991-3.623-.233-.371A9.818 9.818 0 0 1 2.18 12c0-5.416 4.403-9.818 9.819-9.818 5.416 0 9.818 4.402 9.818 9.818 0 5.417-4.402 9.818-9.818 9.818z" />
                        </svg>
                        {{ __('hero.cta_book') }}
                    </button>
                    <a href="#gallery" class="btn-secondary">
                        {{ __('hero.cta_explore') }}
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>
                </div>

                {{-- Trust indicators --}}
                <div class="flex flex-wrap items-center gap-6 reveal reveal-delay-4" style="margin-top:3rem;">
                    @foreach ([['M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z', 'hero.trust_superhost'], ['M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z', 'hero.trust_checkin'], ['M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z', 'hero.trust_available']] as $trust)
                        <div style="display:flex;align-items:center;gap:0.5rem;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="#16A34A">
                                <path d="{{ $trust[0] }}" />
                            </svg>
                            <span
                                style="font-family:'DM Sans',sans-serif;font-size:0.78rem;color:rgba(240,245,241,0.45);">{{ __($trust[1]) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="scroll-indicator absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1">
            <span
                style="font-family:'DM Sans',sans-serif;font-size:0.65rem;letter-spacing:0.3em;text-transform:uppercase;color:rgba(90,122,98,0.5);">{{ __('hero.scroll') }}</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgba(90,122,98,0.5)"
                stroke-width="1.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <polyline points="19 12 12 19 5 12" />
            </svg>
        </div>
    </section>

    {{-- ════════════════════════════════════════
     STATS BAR
════════════════════════════════════════ --}}
    <section class="stats-bar">
        <div class="max-w-7xl mx-auto px-6 py-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-0">
                @foreach ([['9.6/10', 'stats.rating_label'], ['200+', 'stats.reviews_label'], ['3', 'stats.guests_label'], ['70 m²', 'stats.floors_label']] as $i => $s)
                    <div class="text-center px-6 reveal"
                        style="transition-delay:{{ $i * 0.1 }}s;{{ $i > 0 ? 'border-left:1px solid rgba(46,94,50,0.15);' : '' }}">
                        <div style="font-family:'Playfair Display',serif;font-size:2.2rem;font-weight:700;color:#2E5E32;">
                            {{ $s[0] }}</div>
                        <div
                            style="font-family:'DM Sans',sans-serif;font-size:0.72rem;letter-spacing:0.12em;text-transform:uppercase;color:#7A8070;margin-top:0.25rem;">
                            {{ __($s[1]) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════
     GALLERY
════════════════════════════════════════ --}}
    <section id="gallery" style="padding:4rem 0 5rem;background:#FDFAF5;">
        <div class="max-w-7xl mx-auto px-6">

            {{-- Header compatto --}}
            <div class="flex items-end justify-between reveal" style="margin-bottom:1.25rem;">
                <div>
                    <div class="section-label" style="margin-bottom:0.4rem;">{{ __('gallery.section_label') }}</div>
                    <h2 class="section-title"
                        style="font-size:clamp(1.6rem,3vw,2.4rem);font-weight:700;line-height:1.15;">
                        {{ __('gallery.title_1') }}
                        <em style="color:#2E5E32;">{{ __('gallery.title_em') }}</em>
                    </h2>
                </div>
                @if ($photoCount > 0)
                <span
                    style="font-family:'DM Sans',sans-serif;font-size:0.75rem;color:#7A8070;padding-bottom:0.25rem;">{{ $photoCount }}
                    {{ __('gallery.photos') }}</span>
                @endif
            </div>

            @if (count($allPhotos) > 0)
            <div class="gallery-grid" id="gallery-grid">
                @foreach ($allPhotos as $gi => $photo)
                    <div class="gallery-slot{{ $gi >= 5 ? ' gallery-hidden' : '' }}">
                        <img src="{{ $photo[0] }}" alt="{{ $photo[1] }}"
                            loading="{{ $gi < 5 ? 'eager' : 'lazy' }}">
                        <div class="gallery-label">{{ $photo[1] }}</div>
                    </div>
                @endforeach

                @if ($extraCount > 0)
                {{-- Tile "Visualizza tutte" — posizione 6 (indice 5) --}}
                <div class="gallery-see-all" id="gallery-see-all" role="button" tabindex="0"
                    aria-label="{{ __('gallery.see_all') }}">
                    <div class="gallery-see-all-inner">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <circle cx="8.5" cy="8.5" r="1.5" />
                            <polyline points="21 15 16 10 5 21" />
                        </svg>
                        <span class="see-all-count">+{{ $extraCount }}</span>
                        <span class="see-all-label">{{ __('gallery.see_all') }}</span>
                    </div>
                </div>
                @endif
            </div>
            @else
            <div style="padding:3rem;text-align:center;color:#7A8070;font-family:'DM Sans',sans-serif;font-size:0.9rem;">
                {{ __('gallery.coming_soon') }}
            </div>
            @endif

        </div>
    </section>

    {{-- ════════════════════════════════════════
     THE SPACE
════════════════════════════════════════ --}}
    <section id="spazio" style="padding:7rem 0;background:#F5EFE4;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="reveal-left">
                    <div class="section-label">{{ __('space.section_label') }}</div>
                    <h2 class="section-title"
                        style="font-size:clamp(2rem,4vw,3rem);font-weight:700;margin-bottom:1.5rem;">
                        {{ __('space.title_1') }}<br>
                        <em style="color:#2E5E32;">{{ __('space.title_em') }}</em><br>
                        {{ __('space.title_2') }}
                    </h2>
                    <p
                        style="font-family:'DM Sans',sans-serif;font-size:0.95rem;line-height:1.85;color:#3C3C38;margin-bottom:1.75rem;">
                        {{ __('space.p1') }}
                    </p>
                    <p
                        style="font-family:'DM Sans',sans-serif;font-size:0.95rem;line-height:1.85;color:#3C3C38;margin-bottom:2.5rem;">
                        {{ __('space.p2') }}
                    </p>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        @foreach ([['space.feat_size', 'space.feat_size_sub'], ['space.feat_rooms', 'space.feat_rooms_sub'], ['space.feat_terrace', 'space.feat_terrace_sub'], ['space.feat_design', 'space.feat_design_sub']] as $f)
                            <div
                                style="display:flex;align-items:flex-start;gap:0.7rem;padding:0.9rem;background:#EAF2EA;border:1px solid rgba(46,94,50,0.15);border-radius:0.75rem;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2E5E32"
                                    stroke-width="2.5" style="margin-top:2px;flex-shrink:0;">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                <div>
                                    <div
                                        style="font-family:'DM Sans',sans-serif;font-size:0.82rem;font-weight:600;color:#1A1A18;">
                                        {{ __($f[0]) }}</div>
                                    <div
                                        style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:#7A8070;margin-top:0.15rem;">
                                        {{ __($f[1]) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="reveal-right" style="position:relative;">
                    <div style="aspect-ratio:4/5;border-radius:1.5rem;overflow:hidden;position:relative;">
                        <img src="/images/house/1.png" alt="Mau House 44 — Palermo"
                            style="width:100%;height:100%;object-fit:cover;object-position:center;" loading="lazy">
                        <div style="position:absolute;bottom:2rem;left:2rem;right:2rem;">
                            <div
                                style="background:rgba(253,250,245,0.92);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(26,26,24,0.08);border-radius:1rem;padding:1.25rem 1.5rem;display:flex;align-items:center;justify-content:space-between;">
                                <div>
                                    <div
                                        style="font-family:'DM Sans',sans-serif;font-size:0.7rem;letter-spacing:0.15em;text-transform:uppercase;color:#7A8070;">
                                        {{ __('space.card_available') }}</div>
                                    <div
                                        style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:#1A1A18;margin-top:0.25rem;">
                                        Mau House 44</div>
                                </div>
                                <div style="text-align:right;">
                                    <div class="stars" style="font-size:0.85rem;">★ 9.6</div>
                                    <div
                                        style="font-family:'DM Sans',sans-serif;font-size:0.7rem;color:#7A8070;margin-top:0.25rem;">
                                        {{ __('space.card_reviews') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="position:absolute;top:2rem;right:-1.5rem;z-index:10;" class="hidden lg:block">
                        <div
                            style="background:#FDFAF5;border:1px solid #DDD8CE;border-radius:1rem;padding:1rem 1.25rem;min-width:160px;box-shadow:0 4px 20px rgba(26,26,24,0.1);">
                            <div
                                style="font-family:'DM Sans',sans-serif;font-size:0.65rem;letter-spacing:0.15em;text-transform:uppercase;color:#2E5E32;margin-bottom:0.6rem;">
                                {{ __('space.superhost') }}</div>
                            <div style="display:flex;align-items:center;gap:0.5rem;">
                                <div
                                    style="width:32px;height:32px;border-radius:50%;background:#EAF2EA;display:flex;align-items:center;justify-content:center;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#2E5E32">
                                        <path
                                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <div
                                        style="font-family:'DM Sans',sans-serif;font-size:0.78rem;font-weight:600;color:#1A1A18;">
                                        {{ __('space.host_cert') }}</div>
                                    <div style="font-family:'DM Sans',sans-serif;font-size:0.65rem;color:#7A8070;">
                                        {{ __('space.since') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════
     AMENITIES
════════════════════════════════════════ --}}
    <section id="servizi" style="padding:7rem 0;background:#EAF2EA;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center reveal" style="margin-bottom:4rem;">
                <div class="section-label">{{ __('amenities.section_label') }}</div>
                <h2 class="section-title" style="font-size:clamp(2rem,4vw,3rem);font-weight:700;">
                    {{ __('amenities.title_1') }}<br>
                    <em style="color:#2E5E32;">{{ __('amenities.title_em') }}</em>
                </h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ([
            ['amenities.wifi', 'amenities.wifi_desc', 'M9 1a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-.25 9a6.75 6.75 0 1 0-7.5 0h-1a.75.75 0 0 0 0 1.5h10a.75.75 0 0 0 0-1.5h-1z'],
            ['amenities.ac', 'amenities.ac_desc', 'M9.5 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5a.5.5 0 0 1 .5-.5zM3.05 3.05a.5.5 0 0 1 .707 0L5.05 4.343a.5.5 0 0 1-.707.707L3.05 3.757a.5.5 0 0 1 0-.707zm13.9 0a.5.5 0 0 1 0 .707l-1.293 1.293a.5.5 0 1 1-.707-.707L16.243 3.05a.5.5 0 0 1 .707 0zM9.5 6a3.5 3.5 0 1 1 0 7 3.5 3.5 0 0 1 0-7z'],
            ['amenities.kitchen', 'amenities.kitchen_desc', 'M3 6h18M3 12h18M3 18h18'],
            ['amenities.terrace', 'amenities.terrace_desc', 'M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z'],
            ['amenities.checkin', 'amenities.checkin_desc', 'M15 7h3a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2h-3m-6 0H6a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h3m6 4l-4-4-4 4'],
            ['amenities.parking', 'amenities.parking_desc', 'M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v3'],
            ['amenities.heating', 'amenities.heating_desc', 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z'],
            ['amenities.crib', 'amenities.crib_desc', 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 0 0 1 1h3m10-11l2 2m-2-2v10a1 1 0 0 1-1 1h-3'],
            ['amenities.smoke', 'amenities.smoke_desc', 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z'],
            ['amenities.flex', 'amenities.flex_desc', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z'],
            ['amenities.support', 'amenities.support_desc', 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z'],
        ] as $i => $a)
                    <div class="amenity-card reveal" style="transition-delay:{{ ($i % 4) * 0.08 }}s;">
                        <div class="amenity-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="{{ $a[2] }}" />
                            </svg>
                        </div>
                        <div>
                            <div style="font-family:'DM Sans',sans-serif;font-size:0.85rem;font-weight:600;color:#1A1A18;">
                                {{ __($a[0]) }}</div>
                            <div
                                style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:#7A8070;margin-top:0.2rem;">
                                {{ __($a[1]) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════
     FAQ
════════════════════════════════════════ --}}
    <section id="faq" style="padding:7rem 0;background:#F5EFE4;">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center reveal" style="margin-bottom:4rem;">
                <div class="section-label">{{ __('faq.section_label') }}</div>
                <h2 class="section-title" style="font-size:clamp(2rem,4vw,3rem);font-weight:700;color:#1A1A18;">
                    {{ __('faq.title_1') }}<br>
                    <em style="color:#2E5E32;">{{ __('faq.title_em') }}</em>
                </h2>
            </div>

            <div style="max-width:800px;margin:0 auto;display:flex;flex-direction:column;gap:1rem;">

                @foreach ([
                    ['faq.q_pets',      'faq.a_pets',      'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z'],
                    ['faq.q_checkin',   'faq.a_checkin',   'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z'],
                    ['faq.q_transport', 'faq.a_transport', 'M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v3m4 10l-3-3m0 0l3-3m-3 3H9'],
                    ['faq.q_wifi',      'faq.a_wifi',      'M9 1a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-.25 9a6.75 6.75 0 1 0-7.5 0h-1a.75.75 0 0 0 0 1.5h10a.75.75 0 0 0 0-1.5h-1z'],
                ] as $fi => $faq)
                <div class="faq-item reveal" style="transition-delay:{{ $fi * 0.1 }}s;" onclick="toggleFaq(this)">
                    <div class="faq-question">
                        <div style="display:flex;align-items:center;gap:0.85rem;">
                            <div class="faq-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="{{ $faq[2] }}" />
                                </svg>
                            </div>
                            <span>{{ __($faq[0]) }}</span>
                        </div>
                        <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">
                        <p>{{ __($faq[1]) }}</p>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>

    <style>
        .faq-item {
            background: #fff;
            border: 1px solid rgba(46,94,50,0.12);
            border-radius: 1rem;
            overflow: hidden;
            cursor: pointer;
            transition: box-shadow 0.2s, border-color 0.2s;
        }
        .faq-item:hover { border-color: rgba(46,94,50,0.28); box-shadow: 0 4px 20px rgba(46,94,50,0.07); }
        .faq-item.open   { border-color: rgba(46,94,50,0.3); box-shadow: 0 4px 24px rgba(46,94,50,0.1); }
        .faq-question {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.25rem 1.5rem;
            font-family: 'DM Sans', sans-serif; font-size: 0.95rem; font-weight: 600;
            color: #1A1A18; gap: 1rem; user-select: none;
        }
        .faq-icon {
            width: 36px; height: 36px; flex-shrink: 0; border-radius: 50%;
            background: rgba(46,94,50,0.08);
            display: flex; align-items: center; justify-content: center;
            color: #2E5E32;
        }
        .faq-chevron {
            flex-shrink: 0; color: #7A8070;
            transition: transform 0.3s ease;
        }
        .faq-item.open .faq-chevron { transform: rotate(180deg); }
        .faq-answer {
            max-height: 0; overflow: hidden;
            transition: max-height 0.35s ease, padding 0.35s ease;
            padding: 0 1.5rem;
        }
        .faq-item.open .faq-answer {
            max-height: 200px;
            padding: 0 1.5rem 1.25rem;
        }
        .faq-answer p {
            font-family: 'DM Sans', sans-serif; font-size: 0.88rem;
            line-height: 1.75; color: #555; border-top: 1px solid rgba(46,94,50,0.08);
            padding-top: 1rem; margin: 0;
        }
        @media (max-width: 640px) {
            .faq-question { padding: 1rem 1.1rem; font-size: 0.88rem; }
            .faq-item.open .faq-answer { padding: 0 1.1rem 1rem; }
        }
    </style>

    <script>
    function toggleFaq(el) {
        const isOpen = el.classList.contains('open');
        document.querySelectorAll('.faq-item.open').forEach(f => f.classList.remove('open'));
        if (!isOpen) el.classList.add('open');
    }
    </script>

    {{-- ════════════════════════════════════════
     LOCATION
════════════════════════════════════════ --}}
    <section id="posizione" style="padding:7rem 0;background:#1C2E1A;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                {{-- Mappa visuale --}}
                <div class="reveal-left order-2 lg:order-1" style="position:relative;">
                    <div style="aspect-ratio:1/1;border-radius:1.5rem;overflow:hidden;position:relative;">
                        <iframe
                            src="https://maps.google.com/maps?q=Vicolo+San+Carlo+44,+Palermo,+Italy&t=&z=16&ie=UTF8&iwloc=&output=embed"
                            width="100%" height="100%" style="border:0;display:block;width:100%;height:100%;"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            title="Mau House 44 — Vicolo San Carlo 44, Palermo"></iframe>
                    </div>
                    {{-- Chip distanze --}}
                    <div style="position:absolute;top:2rem;right:-1rem;" class="hidden lg:block">
                        <div style="display:flex;flex-direction:column;gap:0.5rem;">
                            @foreach (['location.chip_1', 'location.chip_2', 'location.chip_3'] as $c)
                                <div
                                    style="padding:0.5rem 1rem;background:rgba(28,46,26,0.95);backdrop-filter:blur(12px);border:1px solid rgba(253,250,245,0.15);border-radius:2rem;font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(253,250,245,0.85);white-space:nowrap;">
                                    {{ __($c) }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Testo --}}
                <div class="reveal-right order-1 lg:order-2">
                    <div class="section-label-dark">{{ __('location.section_label') }}</div>
                    <h2 class="section-title-dark"
                        style="font-size:clamp(2rem,4vw,3rem);font-weight:700;margin-bottom:1.5rem;">
                        {{ __('location.title_1') }}<br>
                        <em style="color:#A8D4AB;">{{ __('location.title_em') }}</em><br>
                        {{ __('location.title_2') }}
                    </h2>
                    <p
                        style="font-family:'DM Sans',sans-serif;font-size:0.95rem;line-height:1.85;color:rgba(253,250,245,0.65);margin-bottom:2rem;">
                        {{ __('location.p') }}
                    </p>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:2rem;">
                        @foreach ([['🛍️', 'location.ballarò', 'location.ballarò_desc'], ['🎭', 'location.massimo', 'location.massimo_desc'], ['🚉', 'location.palatina', 'location.palatina_desc'], ['🏖️', 'location.mondello', 'location.mondello_desc'], ['✈️', 'location.airport', 'location.airport_desc'], ['🛒', 'location.market', 'location.market_desc']] as $l)
                            <div class="location-badge">
                                <span style="font-size:1rem;">{{ $l[0] }}</span>
                                <div>
                                    <div
                                        style="font-size:0.78rem;font-weight:600;color:rgba(253,250,245,0.85);line-height:1.2;">
                                        {{ __($l[1]) }}</div>
                                    <div style="font-size:0.65rem;color:rgba(253,250,245,0.45);margin-top:0.1rem;">
                                        {{ __($l[2]) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="https://maps.google.com/?q=Vicolo+San+Carlo+44+Palermo" target="_blank" rel="noopener"
                        class="btn-secondary" style="display:inline-flex;width:auto;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                            <circle cx="12" cy="9" r="2.5" />
                        </svg>
                        {{ __('location.maps') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════
     REVIEWS
════════════════════════════════════════ --}}
    <section id="recensioni" style="padding:7rem 0;background:#FDFAF5;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center reveal" style="margin-bottom:4rem;">
                <div class="section-label">{{ __('reviews.section_label') }}</div>
                <h2 class="section-title" style="font-size:clamp(2rem,4vw,3rem);font-weight:700;">
                    {{ __('reviews.title_1') }}<br>
                    <em style="color:#2E5E32;">{{ __('reviews.title_em') }}</em>
                </h2>
                <div
                    style="display:inline-flex;align-items:center;gap:1rem;margin-top:1.5rem;padding:0.75rem 1.5rem;background:rgba(46,94,50,0.07);border:1px solid rgba(46,94,50,0.18);border-radius:2rem;">
                    <div class="stars" style="font-size:1.2rem;">★★★★★</div>
                    <div style="font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;color:#2E5E32;line-height:1;">9,6
                        <span style="font-size:0.85rem;font-weight:500;color:#7A8070;">/10</span>
                    </div>
                    <div style="font-family:'DM Sans',sans-serif;font-size:0.8rem;color:#7A8070;">
                        {{ __('reviews.platform') }}</div>
                </div>
            </div>

            {{-- ── FORM LASCIA LA TUA RECENSIONE ── --}}
            <div class="review-submit-wrap reveal">
                <h3>{{ __('reviews.submit_title') }}</h3>
                <p class="review-submit-sub">{{ __('reviews.submit_subtitle') }}</p>

                <div class="review-form-error" id="review-form-error" role="alert"></div>
                <div class="review-form-success" id="review-form-success" role="status"></div>

                <form id="review-form" novalidate>
                    @csrf
                    <div class="review-star-input" id="review-stars" aria-label="{{ __('reviews.field_rating') }}">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" data-star="{{ $i }}" aria-label="{{ $i }}">★</button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="review-rating" value="">
                    <div class="review-form-row">
                        <input type="text" name="name" class="review-form-input" placeholder="{{ __('reviews.field_name') }}" required maxlength="60" autocomplete="given-name">
                        <input type="text" name="surname" class="review-form-input" placeholder="{{ __('reviews.field_surname') }}" maxlength="60" autocomplete="family-name">
                    </div>
                    <input type="email" name="email" class="review-form-input" placeholder="{{ __('reviews.field_email') }}" required maxlength="120" autocomplete="email" style="margin-bottom:0.75rem;">
                    <textarea name="text" class="review-form-textarea" placeholder="{{ __('reviews.field_text') }}" required minlength="10" maxlength="1500"></textarea>

                    <label class="review-consent" style="display:flex;align-items:flex-start;gap:0.55rem;margin:0.5rem 0 1rem;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:0.78rem;color:#7A8070;line-height:1.5;">
                        <input type="checkbox" name="consent_marketing" value="1" style="margin-top:0.2rem;flex-shrink:0;accent-color:#2E5E32;">
                        <span>{{ __('reviews.consent_label') }}</span>
                    </label>

                    <button type="submit" class="review-form-submit" id="review-submit-btn">{{ __('reviews.submit_button') }}</button>
                </form>
            </div>

            {{-- ── DESKTOP: 3 cards ── --}}
            <div class="hidden md:grid md:grid-cols-3 gap-6">
                @foreach (array_slice($reviews, 0, 3) as $i => $r)
                    <div class="review-card reveal" style="transition-delay:{{ $i * 0.12 }}s;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                            <div class="stars" style="font-size:0.85rem;">{{ $r[4] }}</div>
                            <span style="display:inline-flex;align-items:center;gap:0.2rem;padding:0.2rem 0.55rem;background:{{ $r[8] }};border-radius:1rem;font-family:'DM Sans',sans-serif;font-size:0.68rem;font-weight:700;color:#fff;">
                                {{ $r[3] }}<span style="opacity:0.7;font-weight:400;">/10</span>
                            </span>
                        </div>
                        <p style="font-family:'DM Sans',sans-serif;font-size:0.88rem;line-height:1.75;color:#3C3C38;margin-bottom:1.5rem;">"{{ $r[7] }}"</p>
                        <div style="display:flex;align-items:center;gap:0.75rem;padding-top:1rem;border-top:1px solid #DDD8CE;">
                            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,{{ $r[8] }},#1C3320);display:flex;align-items:center;justify-content:center;font-family:'DM Sans',sans-serif;font-size:0.7rem;font-weight:700;color:white;flex-shrink:0;">{{ $r[2] }}</div>
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

            {{-- ── MOBILE: scroll orizzontale ── --}}
            <div class="reviews-mobile-scroll">
                <div style="flex:0 0 1.5rem;flex-shrink:0;"></div>
                @foreach ($reviews as $i => $r)
                    <div class="review-card" style="flex:0 0 calc(100vw - 3rem);scroll-snap-align:center;margin-right:1rem;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                            <div class="stars" style="font-size:0.85rem;">{{ $r[4] }}</div>
                            <span style="display:inline-flex;align-items:center;gap:0.2rem;padding:0.2rem 0.55rem;background:{{ $r[8] }};border-radius:1rem;font-family:'DM Sans',sans-serif;font-size:0.68rem;font-weight:700;color:#fff;">
                                {{ $r[3] }}<span style="opacity:0.7;font-weight:400;">/10</span>
                            </span>
                        </div>
                        <p style="font-family:'DM Sans',sans-serif;font-size:0.88rem;line-height:1.75;color:#3C3C38;margin-bottom:1.5rem;">"{{ $r[7] }}"</p>
                        <div style="display:flex;align-items:center;gap:0.75rem;padding-top:1rem;border-top:1px solid #DDD8CE;">
                            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,{{ $r[8] }},#1C3320);display:flex;align-items:center;justify-content:center;font-family:'DM Sans',sans-serif;font-size:0.7rem;font-weight:700;color:white;flex-shrink:0;">{{ $r[2] }}</div>
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
                <div style="flex:0 0 0.5rem;flex-shrink:0;"></div>
            </div>

            {{-- ── Bottone "Visualizza tutte" ── --}}
            <div style="text-align:center;margin-top:2.5rem;">
                <a href="{{ route('reviews.all') }}"
                   style="display:inline-flex;align-items:center;gap:0.6rem;padding:0.85rem 2rem;background:#2E5E32;color:#fff;font-family:'DM Sans',sans-serif;font-size:0.85rem;font-weight:600;letter-spacing:0.04em;border-radius:0.5rem;text-decoration:none;transition:background 0.2s;"
                   onmouseover="this.style.background='#1C3320'" onmouseout="this.style.background='#2E5E32'">
                    {{ __('reviews.view_all') }}
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════
     CTA PRENOTA
════════════════════════════════════════ --}}
    <section id="prenota" class="cta-bg" style="padding:8rem 0;">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <div class="reveal" style="margin-bottom:2rem;">
                <div
                    style="display:inline-block;padding:1.25rem;background:rgba(249,115,22,0.08);border:1px solid rgba(249,115,22,0.15);border-radius:50%;">
                    <img src="/images/logo.png" alt="Mau House Logo" style="width:48px;height:48px;object-fit:contain;">
                </div>
            </div>

            <div class="section-label-dark reveal" style="margin-left:auto;margin-right:auto;">
                {{ __('cta.section_label') }}</div>

            <h2 class="section-title-dark reveal reveal-delay-1"
                style="font-size:clamp(2.2rem,5vw,3.8rem);font-weight:700;margin-bottom:1.25rem;">
                {{ __('cta.title_1') }}<br>
                <em style="color:#A8D4AB;">{{ __('cta.title_em') }}</em>
            </h2>

            <p class="reveal reveal-delay-2"
                style="font-family:'DM Sans',sans-serif;font-size:1rem;line-height:1.8;color:rgba(253,250,245,0.55);margin-bottom:2.5rem;max-width:480px;margin-left:auto;margin-right:auto;">
                {{ __('cta.subtitle') }}
            </p>

            <div class="reveal reveal-delay-3">
                <button data-open-booking class="btn-whatsapp" type="button" style="margin:0 auto;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                        <path
                            d="M11.999 0C5.373 0 0 5.373 0 12c0 2.118.554 4.1 1.522 5.817L.031 23.93l6.266-1.642A11.935 11.935 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.797 9.797 0 0 1-5.003-1.37l-.356-.213-3.721.976.991-3.623-.233-.371A9.818 9.818 0 0 1 2.18 12c0-5.416 4.403-9.818 9.819-9.818 5.416 0 9.818 4.402 9.818 9.818 0 5.417-4.402 9.818-9.818 9.818z" />
                    </svg>
                    {{ __('cta.btn') }}
                </button>
            </div>

            <p class="reveal reveal-delay-4"
                style="margin-top:1.75rem;font-family:'DM Sans',sans-serif;font-size:0.8rem;color:rgba(253,250,245,0.35);">
                {{ __('cta.footer_note') }}
            </p>
        </div>
    </section>

    {{-- ════════════════════════════════════════
     BOOKING MODAL
════════════════════════════════════════ --}}
    <div id="booking-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div class="booking-backdrop"></div>
        <div class="booking-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;">
                <div>
                    <div class="section-label" style="margin-bottom:0.4rem;">{{ __('booking.section_label') }}</div>
                    <h3 id="modal-title"
                        style="font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;color:#1A1A18;">
                        {{ __('booking.title') }}</h3>
                </div>
                <button onclick="closeBookingModal()"
                    style="width:36px;height:36px;border-radius:50%;background:rgba(26,26,24,0.05);border:1px solid #DDD8CE;display:flex;align-items:center;justify-content:center;color:#7A8070;cursor:pointer;transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(26,26,24,0.1)';this.style.color='#1A1A18'"
                    onmouseout="this.style.background='rgba(26,26,24,0.05)';this.style.color='#7A8070'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            <div id="booking-error"
                style="display:none;padding:0.75rem 1rem;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:0.5rem;margin-bottom:1rem;font-family:'DM Sans',sans-serif;font-size:0.82rem;color:rgba(239,68,68,0.85);">
                {{ __('booking.error') }}
            </div>
            <div id="booking-error-blocked"
                style="display:none;padding:0.75rem 1rem;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:0.5rem;margin-bottom:1rem;font-family:'DM Sans',sans-serif;font-size:0.82rem;color:rgba(239,68,68,0.85);">
                ⚠️ {{ __('booking.error_blocked') }}
            </div>

            <form id="booking-form" data-wa-number="{{ env('WHATSAPP_NUMBER', '393332299170') }}"
                data-email="{{ env('BOOKING_EMAIL', 'mau.house44@gmail.com') }}"
                data-email-subject="{{ __('booking.email_subject') }}"
                data-wa-hello="{{ __('wa.hello') }}" data-wa-arrival="{{ __('wa.arrival') }}"
                data-wa-departure="{{ __('wa.departure') }}" data-wa-nights="{{ __('wa.nights') }}"
                data-wa-time="{{ __('wa.time') }}" data-wa-guests="{{ __('wa.guests') }}"
                data-wa-name="{{ __('wa.name') }}" data-wa-confirm="{{ __('wa.confirm') }}">
                @csrf

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                    <div>
                        <label for="b-arrivo" class="booking-label">{{ __('booking.arrival') }}</label>
                        <input type="date" id="b-arrivo" class="booking-input" required>
                    </div>
                    <div>
                        <label for="b-partenza" class="booking-label">{{ __('booking.departure') }}</label>
                        <input type="date" id="b-partenza" class="booking-input" required>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                    <div>
                        <label for="b-ora" class="booking-label">{{ __('booking.arrival_time') }}</label>
                        <select id="b-ora" class="booking-input" required style="cursor:pointer;">
                            <option value="" disabled selected>{{ __('booking.time_select') }}</option>
                            <option value="{{ __('booking.time_before14') }}">{{ __('booking.time_before14') }}</option>
                            <option value="{{ __('booking.time_14_16') }}">{{ __('booking.time_14_16') }}</option>
                            <option value="{{ __('booking.time_16_18') }}">{{ __('booking.time_16_18') }}</option>
                            <option value="{{ __('booking.time_18_20') }}">{{ __('booking.time_18_20') }}</option>
                            <option value="{{ __('booking.time_20_22') }}">{{ __('booking.time_20_22') }}</option>
                            <option value="{{ __('booking.time_after22') }}">{{ __('booking.time_after22') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="b-persone" class="booking-label">{{ __('booking.guests') }}</label>
                        <input type="number" id="b-persone" class="booking-input" min="1" max="3"
                            placeholder="{{ __('booking.guests_placeholder') }}" required>
                    </div>
                </div>

                <div style="margin-bottom:1.5rem;">
                    <label for="b-nome" class="booking-label">{{ __('booking.name') }}</label>
                    <input type="text" id="b-nome" class="booking-input"
                        placeholder="{{ __('booking.name_placeholder') }}" required>
                </div>

                <div
                    style="padding:0.9rem 1rem;background:rgba(46,94,50,0.07);border:1px solid rgba(46,94,50,0.15);border-radius:0.6rem;margin-bottom:1.5rem;display:flex;align-items:flex-start;gap:0.75rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2E5E32"
                        stroke-width="2" style="flex-shrink:0;margin-top:2px;">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <p style="font-family:'DM Sans',sans-serif;font-size:0.78rem;color:#3C3C38;line-height:1.55;">
                        {{ __('booking.info') }}
                    </p>
                </div>

                <button type="submit" name="booking-channel" value="whatsapp" class="btn-whatsapp" style="width:100%;justify-content:center;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                        <path
                            d="M11.999 0C5.373 0 0 5.373 0 12c0 2.118.554 4.1 1.522 5.817L.031 23.93l6.266-1.642A11.935 11.935 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.797 9.797 0 0 1-5.003-1.37l-.356-.213-3.721.976.991-3.623-.233-.371A9.818 9.818 0 0 1 2.18 12c0-5.416 4.403-9.818 9.819-9.818 5.416 0 9.818 4.402 9.818 9.818 0 5.417-4.402 9.818-9.818 9.818z" />
                    </svg>
                    {{ __('booking.submit') }}
                </button>

                <div class="booking-separator">
                    <div class="booking-separator-line"></div>
                    <span class="booking-separator-text">{{ __('booking.or') }}</span>
                    <div class="booking-separator-line"></div>
                </div>

                <button type="submit" name="booking-channel" value="email" class="btn-email">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    {{ __('booking.submit_email') }}
                </button>

                <button type="button" onclick="closeBookingModal()"
                    style="width:100%;margin-top:0.75rem;padding:0.7rem;background:transparent;border:none;font-family:'DM Sans',sans-serif;font-size:0.8rem;color:#B0AA9E;cursor:pointer;transition:color 0.25s;"
                    onmouseover="this.style.color='#1A1A18'" onmouseout="this.style.color='#B0AA9E'">
                    {{ __('booking.cancel') }}
                </button>
            </form>
        </div>
    </div>

    <script>
        function openBookingModal() {
            document.getElementById('booking-modal')?.classList.add('open');
            document.body.style.overflow = 'hidden';
            const t = new Date().toISOString().split('T')[0];
            const a = document.getElementById('b-arrivo');
            const p = document.getElementById('b-partenza');
            if (a) a.min = t;
            if (p) p.min = t;
        }

        function closeBookingModal() {
            document.getElementById('booking-modal')?.classList.remove('open');
            document.body.style.overflow = '';
        }
    </script>

    {{-- Preview foto wheel — FUORI da qualsiasi overflow:hidden --}}
    <div id="wheel-backdrop" class="wheel-backdrop"></div>
    <div id="wheel-preview" class="wheel-preview">
        <img id="wheel-preview-img" src="" alt="">
        <div id="wheel-preview-label" class="wheel-preview-label"></div>
    </div>

    {{-- Lightbox galleria --}}
    <div id="lightbox" class="lightbox" role="dialog" aria-modal="true" aria-label="Galleria foto">
        <div class="lightbox-backdrop" id="lightbox-backdrop"></div>
        <button class="lightbox-btn lightbox-close" id="lightbox-close" aria-label="Chiudi">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.2" stroke-linecap="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>
        <button class="lightbox-btn lightbox-prev" id="lightbox-prev" aria-label="Precedente">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6" />
            </svg>
        </button>
        <button class="lightbox-btn lightbox-next" id="lightbox-next" aria-label="Successiva">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6" />
            </svg>
        </button>
        <div class="lightbox-content">
            <img id="lightbox-img" src="" alt="">
            <div class="lightbox-footer">
                <span id="lightbox-label" class="lightbox-label"></span>
                <span id="lightbox-counter" class="lightbox-counter"></span>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════
     OTP MODAL (review email verification)
    ════════════════════════════════════════ --}}
    <div id="otp-modal" role="dialog" aria-modal="true" aria-labelledby="otp-title">
        <div class="otp-backdrop" data-otp-close></div>
        <div class="otp-card">
            <button type="button" class="otp-close" data-otp-close aria-label="Close">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
            <h3 id="otp-title">{{ __('reviews.otp_title') }}</h3>
            <p class="otp-sub">{{ __('reviews.otp_sub') }} <strong id="otp-email-display"></strong></p>

            <div class="review-form-error" id="otp-error" role="alert"></div>
            <div class="review-form-success" id="otp-success" role="status"></div>

            <input type="text"
                   inputmode="numeric"
                   autocomplete="one-time-code"
                   pattern="[0-9]{6}"
                   maxlength="6"
                   class="otp-input"
                   id="otp-input"
                   placeholder="000000">

            <button type="button" class="review-form-submit" id="otp-submit-btn" style="margin-top:1rem;">{{ __('reviews.otp_verify') }}</button>

            <button type="button" class="otp-resend" id="otp-resend-btn">{{ __('reviews.otp_resend') }}</button>
        </div>
    </div>

    <script>
    (function () {
        const form = document.getElementById('review-form');
        if (!form) return;

        const ratingInput    = document.getElementById('review-rating');
        const starsWrap      = document.getElementById('review-stars');
        const starButtons    = starsWrap.querySelectorAll('button[data-star]');
        const submitBtn      = document.getElementById('review-submit-btn');
        const errorBox       = document.getElementById('review-form-error');
        const successBox     = document.getElementById('review-form-success');

        const otpModal       = document.getElementById('otp-modal');
        const otpInput       = document.getElementById('otp-input');
        const otpSubmit      = document.getElementById('otp-submit-btn');
        const otpResend      = document.getElementById('otp-resend-btn');
        const otpError       = document.getElementById('otp-error');
        const otpSuccess     = document.getElementById('otp-success');
        const otpEmailDisp   = document.getElementById('otp-email-display');

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        const L = {
            submitButton:   @json(__('reviews.submit_button')),
            submitting:     @json(__('reviews.submitting')),
            verifying:      @json(__('reviews.verifying')),
            verifyBtn:      @json(__('reviews.otp_verify')),
            errorRating:    @json(__('reviews.error_rating')),
            errorGeneric:   @json(__('reviews.error_generic')),
            errorLength:    @json(__('reviews.otp_error_length')),
            success:        @json(__('reviews.success')),
        };

        let currentReviewId = null;
        let selectedRating  = 0;

        function setStars(n) {
            selectedRating = n;
            ratingInput.value = n;
            starButtons.forEach(btn => {
                btn.classList.toggle('active', parseInt(btn.dataset.star, 10) <= n);
            });
        }
        starButtons.forEach(btn => {
            btn.addEventListener('click',      () => setStars(parseInt(btn.dataset.star, 10)));
            btn.addEventListener('mouseenter', () => {
                const hover = parseInt(btn.dataset.star, 10);
                starButtons.forEach(b => b.classList.toggle('active', parseInt(b.dataset.star, 10) <= hover));
            });
        });
        starsWrap.addEventListener('mouseleave', () => setStars(selectedRating));

        function showMsg(box, msg) { box.textContent = msg; box.style.display = 'block'; }
        function hideMsgs() {
            [errorBox, successBox, otpError, otpSuccess].forEach(b => { b.style.display = 'none'; b.textContent = ''; });
        }
        function openOtp() {
            otpModal.classList.add('open');
            document.body.style.overflow = 'hidden';
            setTimeout(() => otpInput.focus(), 300);
        }
        function closeOtp() {
            otpModal.classList.remove('open');
            document.body.style.overflow = '';
            otpInput.value = '';
            hideMsgs();
        }
        document.querySelectorAll('[data-otp-close]').forEach(el => el.addEventListener('click', closeOtp));
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && otpModal.classList.contains('open')) closeOtp(); });

        otpInput.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/\D/g, '').slice(0, 6);
        });

        async function postJSON(url, body) {
            const res  = await fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body,
            });
            let json = {};
            try { json = await res.json(); } catch (e) {}
            return { ok: res.ok, status: res.status, json };
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            hideMsgs();

            if (!selectedRating) { showMsg(errorBox, L.errorRating); return; }

            submitBtn.disabled    = true;
            submitBtn.textContent = L.submitting;

            try {
                const fd = new FormData(form);
                const { ok, json } = await postJSON({!! json_encode(route('reviews.store')) !!}, fd);

                if (!ok) {
                    let msg = json.message || L.errorGeneric;
                    if (json.errors) msg = Object.values(json.errors).flat().join(' ');
                    showMsg(errorBox, msg);
                    return;
                }

                currentReviewId = json.review_id;
                otpEmailDisp.textContent = fd.get('email');
                openOtp();
            } catch (err) {
                showMsg(errorBox, L.errorGeneric);
            } finally {
                submitBtn.disabled    = false;
                submitBtn.textContent = L.submitButton;
            }
        });

        otpSubmit.addEventListener('click', async () => {
            hideMsgs();
            const code = otpInput.value.trim();
            if (code.length !== 6) { showMsg(otpError, L.errorLength); return; }

            otpSubmit.disabled    = true;
            otpSubmit.textContent = L.verifying;

            try {
                const fd = new FormData();
                fd.append('review_id', currentReviewId);
                fd.append('otp', code);
                const { ok, json } = await postJSON({!! json_encode(route('reviews.verify')) !!}, fd);

                if (!ok) { showMsg(otpError, json.message || L.errorGeneric); return; }

                showMsg(otpSuccess, json.message || L.success);
                setTimeout(() => {
                    closeOtp();
                    form.reset();
                    setStars(0);
                    showMsg(successBox, L.success);
                    successBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 1800);
            } catch (err) {
                showMsg(otpError, L.errorGeneric);
            } finally {
                otpSubmit.disabled    = false;
                otpSubmit.textContent = L.verifyBtn;
            }
        });

        otpResend.addEventListener('click', async () => {
            hideMsgs();
            if (!currentReviewId) return;
            try {
                const fd = new FormData();
                fd.append('review_id', currentReviewId);
                const { ok, json } = await postJSON({!! json_encode(route('reviews.resend')) !!}, fd);
                if (ok) showMsg(otpSuccess, json.message || '');
                else    showMsg(otpError,   json.message || L.errorGeneric);
            } catch (err) {
                showMsg(otpError, L.errorGeneric);
            }
        });
    })();
    </script>

@endsection
