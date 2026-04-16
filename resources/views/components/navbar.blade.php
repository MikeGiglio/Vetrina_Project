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
            <img src="/images/logo.png" alt="Mau House Logo" style="width:32px;height:32px;object-fit:contain;">
            <span style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;letter-spacing:0.18em;color:rgba(253,250,245,0.35);text-transform:uppercase;">MAU HOUSE 44</span>
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
        <a href="/" class="flex items-center gap-2.5 group" aria-label="Mau House">
            <img src="/images/logo.png" alt="Mau House Logo"
                 class="transition-transform duration-300 group-hover:scale-110"
                 style="width:36px;height:36px;object-fit:contain;">
            <div class="leading-none">
                <div class="logo-name">MAU HOUSE</div>
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
