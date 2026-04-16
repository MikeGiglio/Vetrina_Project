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
                <span style="color:rgba(255,255,255,0.7);cursor:default;">Privacy Policy</span>
                <span style="color:rgba(255,255,255,0.7);cursor:default;">Cookie Policy</span>
                @guest
                    <a href="{{ route('login') }}" style="color:rgba(90,122,98,0.3);transition:color 0.25s;" onmouseover="this.style.color='#A8D4AB'" onmouseout="this.style.color='rgba(90,122,98,0.3)'">Admin</a>
                @endguest
                @auth
                    <a href="{{ route('admin.dashboard') }}" style="color:rgba(22,163,74,0.55);transition:color 0.25s;" onmouseover="this.style.color='#A8D4AB'" onmouseout="this.style.color='rgba(22,163,74,0.55)'">Dashboard</a>
                @endauth
            </div>
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
