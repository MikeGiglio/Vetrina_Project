@extends('admin.layouts.admin')

@section('title', 'Nuova campagna')
@section('page-title', 'Nuova campagna email')

@section('content')

<style>
    .compose-wrap {
        max-width: 820px;
    }
    .recipients-mode {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .recipients-mode label {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 1rem 1.1rem;
        background: rgba(168,212,171,0.05);
        border: 1px solid rgba(168,212,171,0.12);
        border-radius: 0.6rem;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'DM Sans', sans-serif;
    }
    .recipients-mode label:has(input:checked) {
        background: rgba(22,163,74,0.15);
        border-color: rgba(22,163,74,0.4);
    }
    .recipients-mode input { accent-color: #16A34A; }
    .recipients-mode .mode-title {
        font-size: 0.84rem; font-weight: 600; color: #F0F5F1;
    }
    .recipients-mode .mode-sub {
        font-size: 0.7rem; color: rgba(168,212,171,0.5);
        margin-top: 0.15rem;
    }
    .chips-input {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(168,212,171,0.15);
        border-radius: 0.5rem;
        padding: 0.5rem 0.6rem;
        min-height: 48px;
        display: flex; flex-wrap: wrap; gap: 0.4rem;
        align-items: center;
        transition: border-color 0.2s;
    }
    .chips-input:focus-within { border-color: rgba(22,163,74,0.5); }
    .chip {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.28rem 0.6rem;
        background: rgba(22,163,74,0.18);
        border: 1px solid rgba(22,163,74,0.3);
        color: #A8D4AB;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.78rem; font-weight: 500;
        border-radius: 999px;
    }
    .chip.invalid {
        background: rgba(239,68,68,0.15);
        border-color: rgba(239,68,68,0.35);
        color: #FCA5A5;
    }
    .chip .chip-remove {
        cursor: pointer; opacity: 0.7;
        width: 14px; height: 14px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 50%;
    }
    .chip .chip-remove:hover { opacity: 1; background: rgba(0,0,0,0.15); }
    .chips-input input[type="text"] {
        flex: 1; min-width: 180px;
        background: transparent;
        border: none; outline: none;
        padding: 0.45rem 0.5rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.88rem; color: #F0F5F1;
    }
    .chips-hint {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.7rem;
        color: rgba(168,212,171,0.4);
        margin-top: 0.4rem;
    }
    .compose-hero {
        background: linear-gradient(135deg, rgba(22,163,74,0.15), rgba(22,163,74,0.05));
        border: 1px solid rgba(22,163,74,0.25);
        border-radius: 0.875rem;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex; align-items: center; gap: 1rem;
    }
    .compose-hero svg { flex-shrink: 0; }
    .compose-hero .txt { font-family: 'DM Sans', sans-serif; font-size: 0.88rem; color: rgba(240,245,241,0.85); line-height: 1.5; }
    .compose-hero .txt strong { color: #A8D4AB; }
    .preview-frame {
        background: #F5EFE6;
        border: 1px solid rgba(168,212,171,0.15);
        border-radius: 0.75rem;
        padding: 1.5rem;
        color: #1A1A18;
        font-family: Helvetica, sans-serif;
        font-size: 0.92rem;
        line-height: 1.65;
        min-height: 120px;
        max-height: 400px;
        overflow-y: auto;
        white-space: pre-line;
    }
    .preview-frame.html-mode { white-space: normal; }
    .compose-textarea {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(168,212,171,0.15);
        border-radius: 0.5rem;
        padding: 0.85rem 1rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9rem; color: #F0F5F1;
        width: 100%; outline: none;
        min-height: 240px; resize: vertical;
        transition: border-color 0.2s;
    }
    .compose-textarea:focus { border-color: rgba(22,163,74,0.5); }
    .format-toggle {
        display: inline-flex;
        background: rgba(168,212,171,0.07);
        border: 1px solid rgba(168,212,171,0.15);
        border-radius: 0.5rem;
        padding: 0.2rem;
        margin-bottom: 0.75rem;
    }
    .format-toggle label {
        padding: 0.4rem 0.85rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.78rem; font-weight: 500;
        color: rgba(168,212,171,0.55);
        cursor: pointer; border-radius: 0.35rem;
        transition: all 0.2s;
    }
    .format-toggle input { display: none; }
    .format-toggle label:has(input:checked) {
        background: rgba(22,163,74,0.22);
        color: #A8D4AB; font-weight: 600;
    }
    .confirm-row {
        background: rgba(252,211,77,0.05);
        border: 1px solid rgba(252,211,77,0.2);
        border-radius: 0.5rem;
        padding: 0.85rem 1rem;
        margin: 1.25rem 0;
    }
    .confirm-row label {
        display: flex; gap: 0.6rem; align-items: flex-start;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.85rem; color: rgba(240,245,241,0.85);
        cursor: pointer; line-height: 1.5;
    }
    .confirm-row input[type="checkbox"] { margin-top: 0.2rem; accent-color: #F59E0B; flex-shrink: 0; }
</style>

<div class="compose-wrap">

    <form method="POST" action="{{ route('admin.email.send') }}" id="compose-form">
        @csrf

        <div style="margin-bottom:1.5rem;">
            <label class="admin-label">Destinatari</label>
            <div class="recipients-mode">
                <label>
                    <input type="radio" name="recipients_mode" value="all" {{ old('recipients_mode','all') === 'all' ? 'checked' : '' }}>
                    <div>
                        <div class="mode-title">Tutti gli iscritti attivi</div>
                        <div class="mode-sub">{{ $activeCount }} destinatari</div>
                    </div>
                </label>
                <label>
                    <input type="radio" name="recipients_mode" value="specific" {{ old('recipients_mode') === 'specific' ? 'checked' : '' }}>
                    <div>
                        <div class="mode-title">Email specifiche</div>
                        <div class="mode-sub">Inserisci manualmente gli indirizzi</div>
                    </div>
                </label>
            </div>

            <div id="specific-wrap" style="display:none;">
                <div class="chips-input" id="chips-container" onclick="document.getElementById('chip-input').focus()">
                    <input type="text" id="chip-input" placeholder="email@esempio.com e premi Invio…" autocomplete="off">
                </div>
                <div id="specific-hidden-inputs"></div>
                <div class="chips-hint">
                    Premi <strong>Invio</strong>, <strong>Tab</strong> o <strong>virgola</strong> per aggiungere ogni email. Puoi anche incollarne più insieme separate da virgole o a capo.
                </div>
                <div class="chips-hint" style="color:#FACC15;">
                    ⚠️ Assicurati di avere il consenso da ciascun destinatario. Chi è già disiscritto verrà automaticamente saltato.
                </div>
            </div>
            @error('recipients_mode')<div style="color:#FCA5A5;font-size:0.78rem;margin-top:0.3rem;">{{ $message }}</div>@enderror
            @error('emails')<div style="color:#FCA5A5;font-size:0.78rem;margin-top:0.3rem;">{{ $message }}</div>@enderror
        </div>

        <div class="compose-hero" id="all-mode-hero">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#A8D4AB" stroke-width="2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                <polyline points="22,6 12,13 2,6"/>
            </svg>
            <div class="txt">
                Stai per inviare una email a <strong>{{ $activeCount }}</strong> iscritti attivi.
                Una volta cliccato <strong>"Invia campagna"</strong> le email partiranno automaticamente, una ogni 3 secondi circa.
            </div>
        </div>

        <div style="margin-bottom:1.25rem;">
            <label class="admin-label">Oggetto</label>
            <input type="text" name="subject" class="admin-input" required maxlength="200"
                   value="{{ old('subject') }}"
                   placeholder="Es. Offerta speciale estate 2026">
            @error('subject')<div style="color:#FCA5A5;font-size:0.78rem;margin-top:0.3rem;">{{ $message }}</div>@enderror
        </div>

        <div style="margin-bottom:1.25rem;">
            <label class="admin-label">Formato corpo</label>
            <div class="format-toggle">
                <label><input type="radio" name="body_format" value="text" {{ old('body_format','text') === 'text' ? 'checked' : '' }} onchange="updatePreview()"> Testo semplice</label>
                <label><input type="radio" name="body_format" value="html" {{ old('body_format') === 'html' ? 'checked' : '' }} onchange="updatePreview()"> HTML</label>
            </div>
            <div style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(168,212,171,0.4);margin-bottom:0.55rem;">
                Testo: va a capo automaticamente. HTML: puoi usare tag come &lt;p&gt;, &lt;strong&gt;, &lt;a href=""&gt;.
            </div>
        </div>

        <div style="margin-bottom:1.25rem;">
            <label class="admin-label">Corpo email</label>
            <textarea name="body" id="body-textarea" class="compose-textarea" required maxlength="100000"
                      oninput="updatePreview()"
                      placeholder="Scrivi qui il messaggio…">{{ old('body') }}</textarea>
            @error('body')<div style="color:#FCA5A5;font-size:0.78rem;margin-top:0.3rem;">{{ $message }}</div>@enderror
        </div>

        <div style="margin-bottom:1.25rem;">
            <label class="admin-label">Anteprima</label>
            <div class="preview-frame" id="preview-frame">
                <em style="color:#B0AA9E;">L'anteprima apparirà qui…</em>
            </div>
            <div style="font-family:'DM Sans',sans-serif;font-size:0.7rem;color:rgba(168,212,171,0.4);margin-top:0.5rem;">
                Ogni email avrà in automatico header con logo My House e footer con link disiscrizione e privacy policy.
            </div>
        </div>

        <div class="confirm-row">
            <label>
                <input type="checkbox" name="confirm" value="1" required>
                <span>Confermo di voler inviare questa email a <strong id="confirm-count">{{ $activeCount }}</strong> destinatari. Ho verificato oggetto, corpo e link. Non è possibile annullare dopo l'invio.</span>
            </label>
        </div>

        <div style="display:flex;gap:0.75rem;">
            <a href="{{ route('admin.email.index') }}" class="btn-secondary">Annulla</a>
            <button type="submit" class="btn-primary" id="send-btn" @if($activeCount === 0) disabled @endif>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Invia campagna
            </button>
        </div>
    </form>

</div>

<script>
    function updatePreview() {
        const body   = document.getElementById('body-textarea').value;
        const format = document.querySelector('input[name="body_format"]:checked').value;
        const frame  = document.getElementById('preview-frame');

        if (!body.trim()) {
            frame.innerHTML = '<em style="color:#B0AA9E;">L\'anteprima apparirà qui…</em>';
            frame.classList.remove('html-mode');
            return;
        }

        if (format === 'html') {
            frame.innerHTML = body;
            frame.classList.add('html-mode');
        } else {
            frame.textContent = body;
            frame.classList.remove('html-mode');
        }
    }

    document.addEventListener('DOMContentLoaded', updatePreview);

    /* ── Mode toggle ── */
    const allCount      = {{ $activeCount }};
    const modeRadios    = document.querySelectorAll('input[name="recipients_mode"]');
    const specificWrap  = document.getElementById('specific-wrap');
    const allModeHero   = document.getElementById('all-mode-hero');
    const confirmCount  = document.getElementById('confirm-count');
    const sendBtn       = document.getElementById('send-btn');

    function currentMode() {
        return document.querySelector('input[name="recipients_mode"]:checked').value;
    }

    function updateMode() {
        const mode = currentMode();
        specificWrap.style.display = (mode === 'specific') ? 'block' : 'none';
        allModeHero.style.display  = (mode === 'all')      ? 'flex'  : 'none';
        updateCounts();
    }
    modeRadios.forEach(r => r.addEventListener('change', updateMode));

    /* ── Chip input ── */
    const chipInput    = document.getElementById('chip-input');
    const chipsWrap    = document.getElementById('chips-container');
    const hiddenWrap   = document.getElementById('specific-hidden-inputs');
    const emails       = new Set();

    function isValidEmail(e) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e);
    }

    function renderChips() {
        chipsWrap.querySelectorAll('.chip').forEach(c => c.remove());
        hiddenWrap.innerHTML = '';
        [...emails].forEach(email => {
            const chip = document.createElement('span');
            chip.className = 'chip' + (isValidEmail(email) ? '' : ' invalid');
            chip.innerHTML = `
                <span>${email.replace(/</g,'&lt;')}</span>
                <span class="chip-remove" title="Rimuovi">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </span>`;
            chip.querySelector('.chip-remove').addEventListener('click', () => {
                emails.delete(email);
                renderChips();
                updateCounts();
            });
            chipsWrap.insertBefore(chip, chipInput);

            const h = document.createElement('input');
            h.type = 'hidden'; h.name = 'emails[]'; h.value = email;
            hiddenWrap.appendChild(h);
        });
    }

    function addEmailsFromString(str) {
        const parts = str.split(/[\s,;]+/).map(s => s.trim().toLowerCase()).filter(Boolean);
        parts.forEach(p => emails.add(p));
        renderChips();
        updateCounts();
    }

    function updateCounts() {
        if (currentMode() === 'all') {
            confirmCount.textContent = allCount;
            sendBtn.disabled = allCount === 0;
        } else {
            const n = [...emails].filter(isValidEmail).length;
            confirmCount.textContent = n;
            sendBtn.disabled = n === 0;
        }
    }

    chipInput.addEventListener('keydown', (e) => {
        if (['Enter', 'Tab', ','].includes(e.key)) {
            if (chipInput.value.trim()) {
                e.preventDefault();
                addEmailsFromString(chipInput.value);
                chipInput.value = '';
            }
        } else if (e.key === 'Backspace' && !chipInput.value && emails.size) {
            const last = [...emails].pop();
            emails.delete(last);
            renderChips();
            updateCounts();
        }
    });
    chipInput.addEventListener('blur', () => {
        if (chipInput.value.trim()) {
            addEmailsFromString(chipInput.value);
            chipInput.value = '';
        }
    });
    chipInput.addEventListener('paste', (e) => {
        const txt = (e.clipboardData || window.clipboardData).getData('text');
        if (txt.match(/[\s,;]/)) {
            e.preventDefault();
            addEmailsFromString(chipInput.value + ' ' + txt);
            chipInput.value = '';
        }
    });

    updateMode();

    /* ── Submit guard ── */
    document.getElementById('compose-form').addEventListener('submit', (e) => {
        if (currentMode() === 'specific') {
            if (chipInput.value.trim()) {
                addEmailsFromString(chipInput.value);
                chipInput.value = '';
            }
            const valid = [...emails].filter(isValidEmail);
            if (valid.length === 0) {
                e.preventDefault();
                alert('Inserisci almeno un indirizzo email valido.');
                return;
            }
            const n = valid.length;
            if (!confirm(`Vuoi inviare questa email a ${n} destinatari specifici? L'invio non può essere annullato.`)) {
                e.preventDefault(); return;
            }
        } else {
            if (!confirm(`Vuoi davvero inviare questa email a ${allCount} iscritti attivi? L'invio non può essere annullato.`)) {
                e.preventDefault(); return;
            }
        }
        sendBtn.disabled = true;
        sendBtn.innerHTML = 'Invio in corso…';
    });
</script>

@endsection
