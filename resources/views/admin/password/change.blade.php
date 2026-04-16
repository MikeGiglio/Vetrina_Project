@extends('admin.layouts.admin')

@section('title', 'Cambia Password')
@section('page-title', 'Cambia Password')

@section('content')

<div style="max-width:480px;margin:0 auto;">

    @if(auth()->user()->must_change_password)
    <div style="padding:1rem 1.25rem;background:rgba(251,191,36,0.08);border:1px solid rgba(251,191,36,0.2);border-radius:0.6rem;margin-bottom:1.5rem;display:flex;align-items:flex-start;gap:0.75rem;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FCD34D" stroke-width="2" style="flex-shrink:0;margin-top:0.05rem;">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
        <div style="font-family:'DM Sans',sans-serif;font-size:0.83rem;color:#FCD34D;line-height:1.5;">
            Devi impostare una nuova password prima di continuare.
        </div>
    </div>
    @endif

    <div class="admin-card">
        <div class="section-title">Imposta Nuova Password</div>

        <form method="POST" action="{{ route('admin.password.update') }}">
            @csrf

            <div style="margin-bottom:1.1rem;">
                <label class="admin-label" for="new_password">Nuova Password</label>
                <input type="password" id="new_password" name="new_password" class="admin-input"
                       placeholder="Minimo 8 caratteri" required minlength="8"
                       autocomplete="new-password">
                @error('new_password')
                <div style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:#FCA5A5;margin-top:0.35rem;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="admin-label" for="new_password_confirmation">Conferma Password</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="admin-input"
                       placeholder="Ripeti la password" required
                       autocomplete="new-password">
            </div>

            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                Aggiorna Password
            </button>
        </form>
    </div>

</div>

@endsection
