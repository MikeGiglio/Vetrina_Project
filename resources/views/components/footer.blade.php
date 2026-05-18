<footer style="background:#020605;padding:3rem 0 2rem;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="footer-divider" style="margin-bottom:2.5rem;"></div>
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-2">
                <img src="/images/logo.png" alt="Mau House Logo" style="width:28px;height:28px;object-fit:contain;">
                <span style="font-family:'Playfair Display',serif;font-size:0.95rem;font-weight:700;letter-spacing:0.15em;color:rgba(240,245,241,0.45);">MAU HOUSE</span>
            </a>

            <!-- Links -->
            <div class="flex flex-wrap items-center justify-center gap-6"
                 style="font-family:'DM Sans',sans-serif;font-size:0.78rem;color:rgba(255,255,255,0.7);">
                <a href="#gallery"   style="color:inherit;transition:color 0.25s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">{{ __('nav.gallery') }}</a>
                <a href="#servizi"   style="color:inherit;transition:color 0.25s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">{{ __('nav.services') }}</a>
                <a href="#posizione" style="color:inherit;transition:color 0.25s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">{{ __('nav.location') }}</a>
                <button data-open-booking type="button" style="background:none;border:none;font-family:inherit;font-size:inherit;color:inherit;cursor:pointer;transition:color 0.25s;padding:0;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">{{ __('nav.book_now') }}</button>
                <a href="{{ route('terms') }}" style="color:inherit;transition:color 0.25s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">{{ __('footer.terms') }}</a>
                <a href="https://www.iubenda.com/privacy-policy/21158314" target="_blank" rel="noopener" style="color:inherit;transition:color 0.25s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">Privacy Policy</a>
                <a href="https://www.iubenda.com/privacy-policy/21158314/cookie-policy" target="_blank" rel="noopener" style="color:inherit;transition:color 0.25s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">Cookie Policy</a>
                @guest
                    <a href="{{ route('login') }}" style="color:rgba(90,122,98,0.3);transition:color 0.25s;" onmouseover="this.style.color='#A8D4AB'" onmouseout="this.style.color='rgba(90,122,98,0.3)'">Admin</a>
                @endguest
                @auth
                    <a href="{{ route('admin.dashboard') }}" style="color:rgba(22,163,74,0.55);transition:color 0.25s;" onmouseover="this.style.color='#A8D4AB'" onmouseout="this.style.color='rgba(22,163,74,0.55)'">Dashboard</a>
                @endauth
            </div>
        </div>

        <!-- Social -->
        <div class="flex items-center justify-center gap-5" style="margin-top:1.75rem;">
            <a href="https://www.instagram.com/mauhouse44apartment/" target="_blank" rel="noopener" aria-label="Instagram"
               style="color:rgba(255,255,255,0.35);transition:color 0.25s;line-height:0;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
            <a href="https://www.tiktok.com/@mauhouse44apartment" target="_blank" rel="noopener" aria-label="TikTok"
               style="color:rgba(255,255,255,0.35);transition:color 0.25s;line-height:0;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.34-6.34V8.69a8.15 8.15 0 0 0 4.77 1.52V6.78a4.85 4.85 0 0 1-1.01-.09z"/></svg>
            </a>
            <a href="https://www.facebook.com/mau.house44/" target="_blank" rel="noopener" aria-label="Facebook"
               style="color:rgba(255,255,255,0.35);transition:color 0.25s;line-height:0;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
        </div>

        <!-- Address + copyright -->
        <div class="text-center" style="margin-top:2rem;">
            <div style="font-family:'DM Sans',sans-serif;font-size:0.75rem;color:rgba(255,255,255,0.45);margin-bottom:0.35rem;">
                Vicolo San Carlo, 44 &middot; 90133 Palermo (PA) &middot; Italia
            </div>
            <div style="font-family:'DM Sans',sans-serif;font-size:0.68rem;color:rgba(255,255,255,0.25);letter-spacing:0.06em;">
                &copy; {{ date('Y') }} Mau House 44 &middot; {{ __('footer.rights') }}
            </div>
        </div>
    </div>
</footer>
