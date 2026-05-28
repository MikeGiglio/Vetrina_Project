@php $locale = app()->getLocale(); @endphp

{{-- ════════════════════════════════════════
     MOBILE MENU (fullscreen, slide da destra)
════════════════════════════════════════ --}}
<div id="mobile-menu" role="dialog" aria-modal="true" aria-label="Menu">

    {{-- Pulsante chiudi --}}
    <button id="menu-close" class="menu-close-btn" aria-label="Chiudi menu">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>

    {{-- Contenuto centrato --}}
    <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:1.75rem;padding:2rem;position:relative;z-index:1;">

        {{-- Logo compatto --}}
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;">
            <img src="/images/logo.png" alt="My House Logo" style="width:32px;height:32px;object-fit:contain;">
            <span style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;letter-spacing:0.18em;color:rgba(253,250,245,0.35);text-transform:uppercase;">MY HOUSE 44</span>
        </div>

        {{-- Divisore --}}
        <div style="width:40px;height:1px;background:rgba(253,250,245,0.12);"></div>

        {{-- Link di navigazione --}}
        <nav style="display:flex;flex-direction:column;align-items:center;gap:1.1rem;">
            <a href="#gallery"   class="mobile-nav-link">{{ __('nav.gallery') }}</a>
            <a href="#spazio"    class="mobile-nav-link">{{ __('nav.space') }}</a>
            <a href="#servizi"   class="mobile-nav-link">{{ __('nav.services') }}</a>
            <a href="#posizione" class="mobile-nav-link">{{ __('nav.location') }}</a>
        </nav>

        {{-- Prenota --}}
        <button data-open-booking type="button"
            style="display:inline-flex;align-items:center;gap:0.6rem;padding:0.8rem 2rem;background:#25D366;color:#fff;font-family:'DM Sans',sans-serif;font-size:0.85rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;border:none;border-radius:0.5rem;cursor:pointer;transition:background 0.2s;margin-top:0.25rem;"
            onmouseover="this.style.background='#1ebe5d'" onmouseout="this.style.background='#25D366'">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.999 0C5.373 0 0 5.373 0 12c0 2.118.554 4.1 1.522 5.817L.031 23.93l6.266-1.642A11.935 11.935 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.797 9.797 0 0 1-5.003-1.37l-.356-.213-3.721.976.991-3.623-.233-.371A9.818 9.818 0 0 1 2.18 12c0-5.416 4.403-9.818 9.819-9.818 5.416 0 9.818 4.402 9.818 9.818 0 5.417-4.402 9.818-9.818 9.818z"/></svg>
            {{ __('nav.book_now') }}
        </button>

        {{-- Divisore --}}
        <div style="width:40px;height:1px;background:rgba(253,250,245,0.1);"></div>

        {{-- Social --}}
        <div style="display:flex;align-items:center;gap:1rem;">
            <a href="https://www.instagram.com/myhouse44apartment/" target="_blank" rel="noopener" aria-label="Instagram"
               style="color:rgba(253,250,245,0.55);transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(253,250,245,0.55)'">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
            <a href="https://www.tiktok.com/@myhouse44apartment" target="_blank" rel="noopener" aria-label="TikTok"
               style="color:rgba(253,250,245,0.55);transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(253,250,245,0.55)'">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.34-6.34V8.69a8.15 8.15 0 0 0 4.77 1.52V6.78a4.85 4.85 0 0 1-1.01-.09z"/></svg>
            </a>
            <a href="https://www.facebook.com/myhouse44/" target="_blank" rel="noopener" aria-label="Facebook"
               style="color:rgba(253,250,245,0.55);transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(253,250,245,0.55)'">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
        </div>

        {{-- Divisore --}}
        <div style="width:40px;height:1px;background:rgba(253,250,245,0.1);"></div>

        {{-- Selettore lingua --}}
        <div style="display:flex;align-items:center;gap:0.5rem;">
            @foreach(['it' => 'IT', 'en' => 'EN', 'fr' => 'FR', 'es' => 'ES', 'de' => 'DE'] as $code => $label)
            <a href="{{ route('lang.switch', $code) }}"
               class="mobile-lang-btn {{ $locale === $code ? 'active' : '' }}"
               aria-label="{{ $label }}">{{ $label }}</a>
            @endforeach
        </div>

        {{-- Indirizzo --}}
        <p style="font-family:'DM Sans',sans-serif;font-size:0.68rem;letter-spacing:0.12em;color:rgba(253,250,245,0.22);text-align:center;text-transform:uppercase;margin-top:0.25rem;">
            Vicolo San Carlo, 44 &middot; Palermo
        </p>

    </div>
</div>

{{-- ════════════════════════════════════════
     NAVBAR
════════════════════════════════════════ --}}
<nav id="navbar">
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2.5 group" aria-label="My House">
            <img src="/images/logo.png" alt="My House Logo"
                 class="transition-transform duration-300 group-hover:scale-110"
                 style="width:36px;height:36px;object-fit:contain;">
            <div class="leading-none">
                <div class="logo-name">MY HOUSE</div>
                <div class="logo-sub">Palermo &middot; 44</div>
            </div>
        </a>

        {{-- Desktop Nav --}}
        <div class="hidden md:flex items-center gap-7">
            <a href="#gallery"   class="nav-link">{{ __('nav.gallery') }}</a>
            <a href="#spazio"    class="nav-link">{{ __('nav.space') }}</a>
            <a href="#servizi"   class="nav-link">{{ __('nav.services') }}</a>
            <a href="#posizione" class="nav-link">{{ __('nav.location') }}</a>

            {{-- Separatore verticale --}}
            <span style="width:1px;height:18px;background:rgba(253,250,245,0.15);display:block;" class="scrolled-hide"></span>

            {{-- Selettore lingua desktop --}}
            <div class="lang-switcher">
                @foreach(['it' => 'IT', 'en' => 'EN', 'fr' => 'FR', 'es' => 'ES', 'de' => 'DE'] as $code => $label)
                <a href="{{ route('lang.switch', $code) }}"
                   class="lang-btn {{ $locale === $code ? 'active' : '' }}"
                   aria-label="{{ $label }}">{{ $label }}</a>
                @endforeach
            </div>

            {{-- Social desktop --}}
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <a href="https://www.instagram.com/myhouse44apartment/" target="_blank" rel="noopener" aria-label="Instagram" class="nav-social-btn scrolled-social">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
                <a href="https://www.tiktok.com/@myhouse44apartment" target="_blank" rel="noopener" aria-label="TikTok" class="nav-social-btn scrolled-social">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.34-6.34V8.69a8.15 8.15 0 0 0 4.77 1.52V6.78a4.85 4.85 0 0 1-1.01-.09z"/></svg>
                </a>
                <a href="https://www.facebook.com/myhouse44/" target="_blank" rel="noopener" aria-label="Facebook" class="nav-social-btn scrolled-social">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
            </div>

            {{-- Prenota --}}
            <button data-open-booking type="button" class="btn-nav-cta" style="cursor:pointer;">
                {{ __('nav.book_now') }}
            </button>
        </div>

        {{-- Mobile: lang dropdown compatto + burger --}}
        <div class="md:hidden flex items-center gap-3">

            {{-- Lang dropdown compatto --}}
            <div style="position:relative;" id="mobile-lang-wrap">
                <button id="mobile-lang-btn"
                    onclick="document.getElementById('mobile-lang-drop').classList.toggle('hidden')"
                    style="display:flex;align-items:center;gap:0.3rem;padding:0.3rem 0.55rem;border:1px solid rgba(253,250,245,0.2);border-radius:0.4rem;background:rgba(253,250,245,0.06);color:rgba(253,250,245,0.85);font-family:'DM Sans',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.08em;cursor:pointer;">
                    {{ strtoupper($locale) }}
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div id="mobile-lang-drop" class="hidden"
                    style="position:absolute;right:0;top:calc(100% + 6px);background:#1a1520;border:1px solid rgba(253,250,245,0.12);border-radius:0.45rem;overflow:hidden;z-index:999;min-width:54px;box-shadow:0 8px 24px rgba(0,0,0,0.5);">
                    @foreach(['it' => 'IT', 'en' => 'EN', 'fr' => 'FR', 'es' => 'ES', 'de' => 'DE'] as $code => $label)
                    <a href="{{ route('lang.switch', $code) }}"
                       style="display:block;padding:0.45rem 0.75rem;font-family:'DM Sans',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.08em;color:{{ $locale === $code ? '#4ade80' : 'rgba(253,250,245,0.7)' }};text-decoration:none;transition:background 0.15s;"
                       onmouseover="this.style.background='rgba(253,250,245,0.07)'" onmouseout="this.style.background='transparent'">
                        {{ $label }}
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Burger --}}
            <button id="menu-btn" class="burger-btn" aria-label="Apri menu">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
        </div>

        <script>
        // Chiudi dropdown lingua mobile cliccando fuori
        document.addEventListener('click', function(e) {
            var wrap = document.getElementById('mobile-lang-wrap');
            var drop = document.getElementById('mobile-lang-drop');
            if (wrap && drop && !wrap.contains(e.target)) {
                drop.classList.add('hidden');
            }
        });
        </script>

    </div>
</nav>
