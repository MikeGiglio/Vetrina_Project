import './bootstrap';
import flatpickr from 'flatpickr';
import { Italian } from 'flatpickr/dist/l10n/it.js';
import 'flatpickr/dist/flatpickr.min.css';

/* ─────────────────────────────────────────
   LOADING SCREEN
───────────────────────────────────────── */
const loader = document.getElementById('loader');
if (loader) {
    const hide = () => loader.classList.add('hidden-loader');
    if (document.readyState === 'complete') {
        setTimeout(hide, 2600);
    } else {
        window.addEventListener('load', () => setTimeout(hide, 2600));
    }
}

/* ─────────────────────────────────────────
   LIGHTBOX GALLERIA
───────────────────────────────────────── */
(function () {
    const lightbox     = document.getElementById('lightbox');
    const lbImg        = document.getElementById('lightbox-img');
    const lbLabel      = document.getElementById('lightbox-label');
    const lbCounter    = document.getElementById('lightbox-counter');
    const lbClose      = document.getElementById('lightbox-close');
    const lbPrev       = document.getElementById('lightbox-prev');
    const lbNext       = document.getElementById('lightbox-next');
    const lbBackdrop   = document.getElementById('lightbox-backdrop');
    if (!lightbox || !lbImg) return;

    let photos = [];   // { src, alt }
    let current = 0;

    // Costruisce l'array foto dalla griglia (incluse le hidden)
    const buildPhotos = () => {
        photos = [];
        document.querySelectorAll('#gallery-grid .gallery-slot').forEach(slot => {
            const img = slot.querySelector('img');
            if (img) photos.push({ src: img.src, alt: img.alt });
        });
    };

    const openLightbox = (index) => {
        buildPhotos();
        current = index;
        showPhoto(current);
        lightbox.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    const closeLightbox = () => {
        lightbox.classList.remove('open');
        document.body.style.overflow = '';
    };

    const showPhoto = (index) => {
        const p = photos[index];
        if (!p) return;
        lbImg.classList.add('loading');
        const tmp = new Image();
        tmp.onload = () => { lbImg.src = p.src; lbImg.alt = p.alt; lbImg.classList.remove('loading'); };
        tmp.src = p.src;
        lbLabel.textContent   = p.alt;
        lbCounter.textContent = `${index + 1} / ${photos.length}`;
    };

    const prev = () => { current = (current - 1 + photos.length) % photos.length; showPhoto(current); };
    const next = () => { current = (current + 1) % photos.length; showPhoto(current); };

    // Click su ogni slot galleria
    document.getElementById('gallery-grid')?.addEventListener('click', (e) => {
        const slot = e.target.closest('.gallery-slot');
        if (!slot) return;
        buildPhotos();
        const img = slot.querySelector('img');
        if (!img) return;
        const idx = photos.findIndex(p => p.src === img.src);
        openLightbox(idx >= 0 ? idx : 0);
    });

    lbClose.addEventListener('click', closeLightbox);
    lbBackdrop.addEventListener('click', closeLightbox);
    lbPrev.addEventListener('click', prev);
    lbNext.addEventListener('click', next);

    document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('open')) return;
        if (e.key === 'Escape')     closeLightbox();
        if (e.key === 'ArrowLeft')  prev();
        if (e.key === 'ArrowRight') next();
    });

    // Swipe touch
    let touchX = 0;
    lightbox.addEventListener('touchstart', e => { touchX = e.touches[0].clientX; }, { passive: true });
    lightbox.addEventListener('touchend', e => {
        const dx = e.changedTouches[0].clientX - touchX;
        if (Math.abs(dx) > 50) dx < 0 ? next() : prev();
    });
})();

/* ─────────────────────────────────────────
   GALLERY — "Visualizza tutte"
───────────────────────────────────────── */
const gallerySeeAll = document.getElementById('gallery-see-all');
if (gallerySeeAll) {
    const activate = () => {
        document.querySelectorAll('.gallery-hidden').forEach(el => el.classList.remove('gallery-hidden'));
        gallerySeeAll.remove();
    };
    gallerySeeAll.addEventListener('click', activate);
    gallerySeeAll.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') activate(); });
}

/* ─────────────────────────────────────────
   HERO WHEEL — preview fissa al centro schermo
───────────────────────────────────────── */
const heroEl        = document.getElementById('hero');
const heroWheel     = document.querySelector('.hero-wheel');
const wheelPreview  = document.getElementById('wheel-preview');
const wheelBackdrop = document.getElementById('wheel-backdrop');
const previewImg    = document.getElementById('wheel-preview-img');
const previewLabel  = document.getElementById('wheel-preview-label');

if (heroEl && heroWheel && wheelPreview) {
    let hideTimer;
    let activeCard  = null;

    const showPreview = (card) => {
        if (card === activeCard) return;
        clearTimeout(hideTimer);
        activeCard = card;
        const img = card.querySelector('img');
        if (!img) return;
        previewImg.src = img.src;
        previewLabel.textContent = img.alt;
        heroWheel.classList.add('paused');
        wheelPreview.classList.add('active');
        if (wheelBackdrop) wheelBackdrop.classList.add('active');
    };

    const hidePreview = () => {
        clearTimeout(hideTimer);
        hideTimer = setTimeout(() => {
            activeCard = null;
            wheelPreview.classList.remove('active');
            if (wheelBackdrop) wheelBackdrop.classList.remove('active');
            heroWheel.classList.remove('paused');
        }, 180);
    };

    // pointermove sull'intero hero — getBoundingClientRect() dà sempre
    // la posizione visiva reale della card, incluse tutte le trasformazioni
    heroEl.addEventListener('pointermove', (e) => {
        const cards = heroWheel.querySelectorAll('.wheel-card');
        let found = null;

        for (const card of cards) {
            const r = card.getBoundingClientRect();
            // Soglia generosa: +40px attorno al rettangolo visivo della card
            if (e.clientX >= r.left - 40 && e.clientX <= r.right  + 40 &&
                e.clientY >= r.top  - 40 && e.clientY <= r.bottom + 40) {
                found = card;
                break;
            }
        }

        if (found) {
            showPreview(found);
        } else {
            hidePreview();
        }
    });

    heroEl.addEventListener('pointerleave', hidePreview);
}

/* ─────────────────────────────────────────
   NAVBAR SCROLL
───────────────────────────────────────── */
const navbar = document.getElementById('navbar');
if (navbar) {
    const onScroll = () => navbar.classList.toggle('scrolled', window.scrollY > 40);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

/* ─────────────────────────────────────────
   MOBILE MENU
───────────────────────────────────────── */
const menuBtn   = document.getElementById('menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
const menuClose = document.getElementById('menu-close');
const blockTouch = (e) => e.preventDefault();

function openMobileMenu() {
    if (!mobileMenu) return;
    mobileMenu.classList.add('open');
    document.body.style.overflow = 'hidden';
    // Blocca completamente tutti i gesti touch sul menu (iOS/Android)
    mobileMenu.addEventListener('touchmove', blockTouch, { passive: false });
    document.addEventListener('touchmove', blockTouch, { passive: false });
}
function closeMobileMenu() {
    if (!mobileMenu) return;
    mobileMenu.classList.remove('open');
    document.body.style.overflow = '';
    mobileMenu.removeEventListener('touchmove', blockTouch);
    document.removeEventListener('touchmove', blockTouch);
}

if (menuBtn)   menuBtn.addEventListener('click', openMobileMenu);
if (menuClose) menuClose.addEventListener('click', closeMobileMenu);
if (mobileMenu) {
    // Solo i link interni (#anchor) chiudono il menu; i link /lang/* fanno redirect e non devono
    mobileMenu.querySelectorAll('a[href^="#"]').forEach(l => l.addEventListener('click', closeMobileMenu));
    mobileMenu.querySelectorAll('[data-open-booking]').forEach(b => b.addEventListener('click', closeMobileMenu));
}

/* ─────────────────────────────────────────
   SCROLL REVEAL
───────────────────────────────────────── */
const revealObs = new IntersectionObserver(
    (entries) => entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); revealObs.unobserve(e.target); } }),
    { threshold: 0.12, rootMargin: '0px 0px -60px 0px' }
);
document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => revealObs.observe(el));

/* ─────────────────────────────────────────
   SMOOTH SCROLL
───────────────────────────────────────── */
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', (e) => {
        const t = document.querySelector(a.getAttribute('href'));
        if (t) {
            e.preventDefault();
            window.scrollTo({ top: t.getBoundingClientRect().top + window.scrollY - 80, behavior: 'smooth' });
        }
    });
});

/* ─────────────────────────────────────────
   PARALLAX HERO
───────────────────────────────────────── */
const heroSection = document.getElementById('hero');
if (heroSection) {
    window.addEventListener('scroll', () => {
        const off = window.scrollY;
        const heroContent = heroSection.querySelector('.hero-content');
        if (heroContent && off < window.innerHeight) {
            heroContent.style.transform = `translateY(${off * 0.18}px)`;
            heroContent.style.opacity = 1 - off / (window.innerHeight * 0.8);
        }
    }, { passive: true });
}

/* ─────────────────────────────────────────
   BOOKING MODAL + WHATSAPP
───────────────────────────────────────── */
const bookingModal   = document.getElementById('booking-modal');
const bookingBackdrop = document.querySelector('.booking-backdrop');
const bookingForm    = document.getElementById('booking-form');

// ── Flatpickr date pickers con date bloccate ──────────────────────
let fpArrivo   = null;
let fpPartenza = null;
let blockedDatesCache = [];

// Carica date bloccate una volta sola
fetch('/blocked-dates')
    .then(r => r.json())
    .then(dates => {
        blockedDatesCache = dates;
        initFlatpickrs(dates);
    })
    .catch(() => initFlatpickrs([]));

function initFlatpickrs(blocked) {
    const arrivoEl   = document.getElementById('b-arrivo');
    const partenzaEl = document.getElementById('b-partenza');
    if (!arrivoEl || !partenzaEl) return;

    // blocked è un array ordinato di stringhe 'Y-m-d'
    const blockedSorted = [...blocked].sort();

    // Restituisce la prima data bloccata strettamente dopo `dateStr` (o null)
    function firstBlockedAfter(dateStr) {
        return blockedSorted.find(d => d > dateStr) || null;
    }

    const commonOpts = {
        locale: Italian,
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'd/m/Y',
        altInputClass: 'booking-input',
        minDate: 'today',
        disable: blocked,
        disableMobile: true,
        onDayCreate(_, __, ___, dayElem) {
            if (dayElem.classList.contains('flatpickr-disabled')) {
                dayElem.title = 'Non disponibile';
            }
        },
    };

    fpArrivo = flatpickr(arrivoEl, {
        ...commonOpts,
        onChange(selectedDates) {
            if (!selectedDates[0]) {
                fpPartenza.set('minDate', 'today');
                fpPartenza.set('maxDate', null);
                return;
            }
            const arrivalStr = selectedDates[0].toISOString().split('T')[0];

            // Partenza: min = arrivo + 1
            const nextDay = new Date(selectedDates[0]);
            nextDay.setDate(nextDay.getDate() + 1);
            fpPartenza.set('minDate', nextDay);

            // Partenza: max = primo giorno bloccato dopo l'arrivo
            // (si può partire IL giorno bloccato, ma non starci la notte)
            const cap = firstBlockedAfter(arrivalStr);
            fpPartenza.set('maxDate', cap || null);

            // Se la partenza già selezionata è ora fuori range, azzera
            if (fpPartenza.selectedDates[0]) {
                const depStr = fpPartenza.selectedDates[0].toISOString().split('T')[0];
                if (depStr <= arrivalStr || (cap && depStr > cap)) {
                    fpPartenza.clear();
                }
            }
        },
    });

    fpPartenza = flatpickr(partenzaEl, {
        ...commonOpts,
        minDate: (() => { const d = new Date(); d.setDate(d.getDate() + 1); return d; })(),
    });
}

function openBookingModal() {
    if (!bookingModal) return;
    bookingModal.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeBookingModal() {
    if (!bookingModal) return;
    bookingModal.classList.remove('open');
    document.body.style.overflow = '';
}

// Apri modal da qualsiasi pulsante [data-open-booking]
document.querySelectorAll('[data-open-booking]').forEach(btn => {
    btn.addEventListener('click', (e) => { e.preventDefault(); openBookingModal(); });
});

// Chiudi su backdrop click
if (bookingBackdrop) bookingBackdrop.addEventListener('click', closeBookingModal);

// ESC chiude
window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeBookingModal(); });

// Submit form → WhatsApp
if (bookingForm) {
    bookingForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const arrivo   = document.getElementById('b-arrivo')?.value;
        const partenza = document.getElementById('b-partenza')?.value;
        const ora      = document.getElementById('b-ora')?.value;
        const persone  = document.getElementById('b-persone')?.value;
        const nome     = document.getElementById('b-nome')?.value?.trim();

        // Validazione semplice
        if (!arrivo || !partenza || !ora || !persone || !nome) {
            const errEl = document.getElementById('booking-error');
            if (errEl) { errEl.style.display = 'block'; setTimeout(() => errEl.style.display = 'none', 3000); }
            return;
        }

        // Verifica date bloccate prima di procedere
        fetch('/blocked-dates')
            .then(r => r.json())
            .then(blocked => {
                if (blocked.length === 0) { proceedBooking(arrivo, partenza, ora, persone, nome); return; }
                const blockedSet = new Set(blocked);
                // Controlla ogni giorno del soggiorno (arrivo incluso, partenza esclusa)
                let cur = new Date(arrivo);
                const end = new Date(partenza);
                while (cur < end) {
                    const ds = cur.toISOString().split('T')[0];
                    if (blockedSet.has(ds)) {
                        const errEl = document.getElementById('booking-error-blocked');
                        if (errEl) { errEl.style.display = 'block'; setTimeout(() => errEl.style.display = 'none', 5000); }
                        return;
                    }
                    cur.setDate(cur.getDate() + 1);
                }
                proceedBooking(arrivo, partenza, ora, persone, nome);
            })
            .catch(() => proceedBooking(arrivo, partenza, ora, persone, nome)); // in caso di errore rete, procedi
        return; // blocca il flusso sincrono
    });

    // Funzione separata per il flusso di prenotazione effettivo
    function proceedBooking(arrivo, partenza, ora, persone, nome) {

        // Formatta date in DD/MM/YYYY
        const fmtDate = (s) => {
            const [y, m, d] = s.split('-');
            return `${d}/${m}/${y}`;
        };

        // Legge stringhe tradotte dai data-attributes del form
        const d = bookingForm.dataset;
        const waHello     = d.waHello     || 'Ciao! 👋 Vorrei prenotare *Mau House 44*.';
        const waArrival   = d.waArrival   || '📅 *Arrivo:*';
        const waDeparture = d.waDeparture || '📅 *Partenza:*';
        const waNights    = d.waNights    || 'notti';
        const waTime      = d.waTime      || '🕐 *Ora arrivo:*';
        const waGuests    = d.waGuests    || '👥 *Persone:*';
        const waName      = d.waName      || '👤 *Nome:*';
        const waConfirm   = d.waConfirm   || 'Potete confermare la disponibilità e il prezzo? Grazie! 🙏';

        const notti = Math.round((new Date(partenza) - new Date(arrivo)) / 86400000);
        const msg = [
            waHello,
            ``,
            `${waArrival} ${fmtDate(arrivo)}`,
            `${waDeparture} ${fmtDate(partenza)} (${notti} ${waNights})`,
            `${waTime} ${ora}`,
            `${waGuests} ${persone}`,
            `${waName} ${nome}`,
            ``,
            waConfirm,
        ].join('\n');

        const waNumber = d.waNumber || '';
        const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(msg)}`;

        // Fire-and-forget: save the lead to the DB (don't block WhatsApp redirect)
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (csrfToken) {
            fetch('/booking-lead', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    name:         nome,
                    arrival:      arrivo,
                    departure:    partenza,
                    guests:       persone,
                    arrival_time: ora,
                }),
            }).catch(() => {}); // ignore errors silently
        }

        window.open(waUrl, '_blank', 'noopener,noreferrer');
        closeBookingModal();
    } // end proceedBooking
}
