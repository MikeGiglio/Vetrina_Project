<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Disiscrizione — My House 44</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        background: #F5EFE6;
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
        display: flex; align-items: center; justify-content: center;
        padding: 2rem 1rem;
    }
    .card {
        max-width: 480px; width: 100%;
        background: #fff;
        border-radius: 1rem;
        padding: 3rem 2.25rem;
        text-align: center;
        box-shadow: 0 6px 28px rgba(0,0,0,0.08);
    }
    .logo-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem; font-weight: 700;
        letter-spacing: 0.08em;
        color: #1C2E1A;
        margin-bottom: 0.3rem;
    }
    .logo-sub {
        font-size: 0.68rem; letter-spacing: 0.25em;
        color: #A8D4AB; text-transform: uppercase;
        margin-bottom: 2rem;
    }
    h1 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem; font-weight: 700;
        color: #1A1A18;
        margin-bottom: 1rem;
    }
    p {
        font-size: 0.95rem; line-height: 1.6;
        color: #555;
        margin-bottom: 1rem;
    }
    .email-chip {
        display: inline-block;
        background: #F5EFE6;
        border: 1px solid #E5DFD3;
        border-radius: 0.5rem;
        padding: 0.5rem 0.85rem;
        font-size: 0.85rem; color: #1A1A18;
        font-weight: 500;
        margin: 0.5rem 0 1.5rem;
        word-break: break-all;
    }
    .btn {
        display: inline-block;
        padding: 0.85rem 2rem;
        background: #2E5E32;
        color: #fff;
        border: none; border-radius: 0.5rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9rem; font-weight: 600;
        letter-spacing: 0.04em;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn:hover { background: #1C3320; }
    .btn-secondary {
        background: transparent;
        color: #7A8070;
        padding: 0.5rem 1rem;
        font-size: 0.82rem;
        text-decoration: underline;
    }
    .btn-secondary:hover { background: transparent; color: #2E5E32; }
    .icon-success {
        width: 56px; height: 56px;
        border-radius: 50%;
        background: rgba(22,163,74,0.1);
        display: inline-flex; align-items: center; justify-content: center;
        margin-bottom: 1rem;
        color: #16A34A;
    }
    .back-link {
        display: inline-block;
        margin-top: 1.75rem;
        font-size: 0.82rem; color: #7A8070;
        text-decoration: underline;
    }
    .back-link:hover { color: #2E5E32; }
</style>
</head>
<body>
    <div class="card">
        <div class="logo-title">MY HOUSE</div>
        <div class="logo-sub">PALERMO · APPARTAMENTO 44</div>

        @if($notFound)
            <h1>Link non valido</h1>
            <p>Il link di disiscrizione che hai usato non è valido o è scaduto. Se ricevi email indesiderate, rispondi a un'email recente e ti rimuoveremo manualmente.</p>
            <a href="{{ url('/') }}" class="back-link">Torna al sito</a>

        @elseif($done)
            <div class="icon-success">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <h1>Disiscrizione completata</h1>
            @if($subscriber)
                <p>L'indirizzo</p>
                <div class="email-chip">{{ $subscriber->email }}</div>
                <p>è stato rimosso dalla nostra lista. Non riceverai più comunicazioni promozionali da My House 44.</p>
            @else
                <p>Non riceverai più comunicazioni promozionali da My House 44.</p>
            @endif
            <a href="{{ url('/') }}" class="back-link">Torna al sito</a>

        @else
            <h1>Confermi la disiscrizione?</h1>
            <p>Stai per rimuovere il seguente indirizzo dalla lista delle comunicazioni My House 44:</p>
            <div class="email-chip">{{ $subscriber->email }}</div>
            <p>Non riceverai più email promozionali. Questa azione può essere annullata solo contattandoci direttamente.</p>

            <form method="POST" action="{{ url('/unsubscribe/' . $subscriber->unsubscribe_token) }}" style="margin-top:1rem;">
                @csrf
                <button type="submit" class="btn">Conferma disiscrizione</button>
            </form>
            <a href="{{ url('/') }}" class="btn-secondary" style="display:inline-block;margin-top:0.75rem;">Annulla</a>
        @endif
    </div>
</body>
</html>
