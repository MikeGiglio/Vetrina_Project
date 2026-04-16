<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Mau House 44</title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #08060A; color: #F5EFE6; font-family: 'DM Sans', sans-serif; }
        .login-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(249,115,22,0.15);
            border-radius: 1.25rem;
            padding: 2.5rem 2rem;
        }
        .input-label {
            display: block;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.76rem; font-weight: 500;
            color: rgba(154,142,160,0.8);
            margin-bottom: 0.5rem;
            letter-spacing: 0.05em;
        }
        .input-field {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(249,115,22,0.18);
            border-radius: 0.6rem;
            padding: 0.75rem 1rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.88rem;
            color: #F5EFE6;
            outline: none;
            transition: border-color 0.2s;
        }
        .input-field:focus { border-color: rgba(249,115,22,0.5); }
        .input-field::placeholder { color: rgba(154,142,160,0.35); }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #F97316, #EA6B0C);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.88rem; font-weight: 600;
            border: none; border-radius: 0.65rem;
            cursor: pointer; text-decoration: none;
            transition: opacity 0.2s;
        }
        .btn-primary:hover { opacity: 0.9; }
    </style>
</head>
<body class="login-bg" style="background:#08060A;color:#F5EFE6;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:2rem;">

<!-- Glow orbs -->
<div style="position:fixed;top:0;left:0;width:600px;height:600px;background:radial-gradient(circle,rgba(249,115,22,0.08) 0%,transparent 70%);transform:translate(-30%,-20%);pointer-events:none;"></div>
<div style="position:fixed;bottom:0;right:0;width:500px;height:500px;background:radial-gradient(circle,rgba(200,167,90,0.06) 0%,transparent 70%);transform:translate(20%,20%);pointer-events:none;"></div>

<div style="width:100%;max-width:420px;position:relative;z-index:10;">
    <!-- Logo -->
    <div style="text-align:center;margin-bottom:2.5rem;">
        <a href="/" style="display:inline-flex;flex-direction:column;align-items:center;gap:0.75rem;text-decoration:none;">
            <img src="/images/logo.png" alt="Mau House Logo" style="width:64px;height:64px;object-fit:contain;">
            <div>
                <div style="font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;letter-spacing:0.2em;color:#F5EFE6;">MAU HOUSE</div>
                <div style="font-family:'DM Sans',sans-serif;font-size:0.62rem;letter-spacing:0.45em;color:#9A8EA0;text-transform:uppercase;margin-top:0.2rem;">Pannello Admin</div>
            </div>
        </a>
    </div>

    <!-- Card -->
    <div class="login-card">
        <!-- Admin badge -->
        <div style="display:flex;align-items:center;justify-content:center;margin-bottom:2rem;">
            <div style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.35rem 1rem;background:rgba(249,115,22,0.08);border:1px solid rgba(249,115,22,0.2);border-radius:2rem;">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="#F97316"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span style="font-family:'DM Sans',sans-serif;font-size:0.68rem;font-weight:600;letter-spacing:0.25em;text-transform:uppercase;color:#F97316;">Accesso Riservato</span>
            </div>
        </div>

        <!-- Session errors -->
        @if ($errors->any())
        <div style="padding:1rem;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:0.6rem;margin-bottom:1.5rem;">
            <p style="font-family:'DM Sans',sans-serif;font-size:0.82rem;color:rgba(239,68,68,0.85);">
                {{ $errors->first() }}
            </p>
        </div>
        @endif

        @if (session('status'))
        <div style="padding:1rem;background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);border-radius:0.6rem;margin-bottom:1.5rem;">
            <p style="font-family:'DM Sans',sans-serif;font-size:0.82rem;color:rgba(34,197,94,0.85);">
                {{ session('status') }}
            </p>
        </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div style="margin-bottom:1.25rem;">
                <label for="email" class="input-label">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    autofocus
                    class="input-field"
                    placeholder="admin@maohouse44.it"
                >
            </div>

            <!-- Password -->
            <div style="margin-bottom:1.75rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem;">
                    <label for="password" class="input-label" style="margin-bottom:0;">Password</label>
                </div>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="input-field"
                    placeholder="••••••••"
                >
            </div>

            <!-- Remember me -->
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:2rem;">
                <input
                    id="remember"
                    type="checkbox"
                    name="remember"
                    style="width:16px;height:16px;accent-color:#F97316;border-radius:4px;cursor:pointer;"
                >
                <label for="remember" style="font-family:'DM Sans',sans-serif;font-size:0.8rem;color:rgba(154,142,160,0.7);cursor:pointer;">
                    Ricordami su questo dispositivo
                </label>
            </div>

            <!-- Submit -->
            <button type="submit" id="login-btn" class="btn-primary" style="width:100%;justify-content:center;">
                <svg id="login-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                <span id="login-label">Accedi alla Dashboard</span>
            </button>
        </form>
        <script>
            document.querySelector('form').addEventListener('submit', function() {
                var btn = document.getElementById('login-btn');
                btn.disabled = true;
                btn.style.opacity = '0.6';
                btn.style.cursor = 'not-allowed';
                document.getElementById('login-label').textContent = 'Accesso in corso…';
            });
        </script>
    </div>

    <!-- Back link -->
    <div style="text-align:center;margin-top:1.5rem;">
        <a href="/" style="font-family:'DM Sans',sans-serif;font-size:0.78rem;color:rgba(154,142,160,0.45);transition:color 0.25s;text-decoration:none;" onmouseover="this.style.color='#F97316'" onmouseout="this.style.color='rgba(154,142,160,0.45)'">
            ← Torna al sito
        </a>
    </div>
</div>

</body>
</html>
