@extends('admin.layouts.admin')

@section('title', 'Utenti')
@section('page-title', 'Utenti Admin')

@section('content')

{{-- ── Modal password temporanea ── --}}
@if(session('new_user'))
@php $nu = session('new_user'); @endphp
<div id="pwd-modal-overlay" style="position:fixed;inset:0;background:rgba(0,0,0,0.75);z-index:9000;display:flex;align-items:center;justify-content:center;padding:1rem;">
    <div style="background:#0D1F0B;border:1px solid rgba(74,222,128,0.3);border-radius:1.25rem;padding:2rem 2rem 1.75rem;width:100%;max-width:460px;position:relative;box-shadow:0 20px 60px rgba(0,0,0,0.6);">

        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
            <div style="width:40px;height:40px;border-radius:50%;background:rgba(74,222,128,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4ADE80" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <div>
                <div style="font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:700;color:#F0F5F1;">Utente creato con successo</div>
                <div style="font-family:'DM Sans',sans-serif;font-size:0.75rem;color:rgba(168,212,171,0.5);margin-top:0.1rem;">Copia e invia le credenziali all'utente</div>
            </div>
        </div>

        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(168,212,171,0.1);border-radius:0.65rem;padding:1rem;margin-bottom:1.25rem;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.6rem;">
                <span style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(168,212,171,0.45);letter-spacing:0.1em;text-transform:uppercase;">Nome</span>
                <span style="font-family:'DM Sans',sans-serif;font-size:0.84rem;color:#F0F5F1;font-weight:500;">{{ $nu['name'] }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <span style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(168,212,171,0.45);letter-spacing:0.1em;text-transform:uppercase;">Email</span>
                <span style="font-family:'DM Sans',sans-serif;font-size:0.84rem;color:#A8D4AB;">{{ $nu['email'] }}</span>
            </div>
        </div>

        <div style="margin-bottom:1.5rem;">
            <div style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(168,212,171,0.45);letter-spacing:0.1em;text-transform:uppercase;margin-bottom:0.5rem;">Password Temporanea</div>
            <div style="display:flex;align-items:center;gap:0.6rem;">
                <div id="tmp-pwd-box" style="flex:1;background:rgba(0,0,0,0.35);border:1px solid rgba(74,222,128,0.25);border-radius:0.6rem;padding:0.9rem 1rem;font-family:monospace;font-size:1.2rem;font-weight:700;color:#4ADE80;letter-spacing:0.15em;word-break:break-all;">{{ $nu['password'] }}</div>
                <button onclick="copyPwd('{{ $nu['password'] }}')" id="copy-btn" title="Copia password"
                    style="flex-shrink:0;width:44px;height:44px;border-radius:0.6rem;background:rgba(74,222,128,0.12);border:1px solid rgba(74,222,128,0.25);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;">
                    <svg id="copy-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4ADE80" stroke-width="2">
                        <rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                    </svg>
                </button>
            </div>
            <div id="copy-feedback" style="font-family:'DM Sans',sans-serif;font-size:0.73rem;color:#4ADE80;margin-top:0.4rem;opacity:0;transition:opacity 0.3s;">✓ Copiata negli appunti</div>
        </div>

        <div style="background:rgba(251,191,36,0.07);border:1px solid rgba(251,191,36,0.18);border-radius:0.5rem;padding:0.75rem 0.9rem;margin-bottom:1.5rem;display:flex;gap:0.6rem;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FCD34D" stroke-width="2" style="flex-shrink:0;margin-top:0.1rem;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <span style="font-family:'DM Sans',sans-serif;font-size:0.76rem;color:rgba(252,211,77,0.8);line-height:1.5;">Questa password è mostrata <strong>una sola volta</strong>. L'utente dovrà cambiarla al primo accesso.</span>
        </div>

        <button onclick="document.getElementById('pwd-modal-overlay').remove()"
            style="width:100%;padding:0.7rem;background:rgba(168,212,171,0.08);border:1px solid rgba(168,212,171,0.15);border-radius:0.6rem;color:rgba(168,212,171,0.7);font-family:'DM Sans',sans-serif;font-size:0.84rem;font-weight:500;cursor:pointer;transition:all 0.2s;"
            onmouseover="this.style.background='rgba(168,212,171,0.14)'" onmouseout="this.style.background='rgba(168,212,171,0.08)'">
            Ho copiato la password — Chiudi
        </button>
    </div>
</div>
<script>
function copyPwd(pwd) {
    navigator.clipboard.writeText(pwd).then(() => {
        const fb = document.getElementById('copy-feedback');
        const btn = document.getElementById('copy-btn');
        fb.style.opacity = '1';
        btn.style.background = 'rgba(74,222,128,0.25)';
        setTimeout(() => { fb.style.opacity = '0'; btn.style.background = 'rgba(74,222,128,0.12)'; }, 2500);
    });
}
</script>
@endif

<style>
    .users-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 0.85rem;
    }
    .user-card {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(168,212,171,0.09);
        border-radius: 0.875rem;
        overflow: hidden;
        transition: border-color 0.2s;
    }
    .user-card:hover { border-color: rgba(168,212,171,0.2); }
    .user-card-head {
        padding: 0.9rem 1rem 0.75rem;
        border-bottom: 1px solid rgba(168,212,171,0.06);
        display: flex; align-items: center; gap: 0.7rem;
    }
    .user-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg,#16A34A,#0D7A32);
        display: flex; align-items: center; justify-content: center;
        font-family: 'DM Sans', sans-serif; font-size: 0.7rem; font-weight: 700;
        color: #F0F5F1; flex-shrink: 0;
    }
    .user-name {
        font-family: 'DM Sans', sans-serif; font-size: 0.9rem; font-weight: 600;
        color: #F0F5F1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .user-email {
        font-family: 'DM Sans', sans-serif; font-size: 0.72rem;
        color: rgba(168,212,171,0.45); margin-top: 0.08rem;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .user-card-badges {
        padding: 0.55rem 1rem;
        display: flex; flex-wrap: wrap; gap: 0.4rem;
        border-bottom: 1px solid rgba(168,212,171,0.06);
    }
    .user-card-foot {
        padding: 0.65rem 1rem;
        display: flex; align-items: center; justify-content: space-between;
        gap: 0.5rem; flex-wrap: wrap;
    }
    .user-date {
        font-family: 'DM Sans', sans-serif; font-size: 0.7rem;
        color: rgba(168,212,171,0.28);
    }
    .user-actions { display: flex; gap: 0.4rem; flex-wrap: wrap; align-items: center; }

    @media (max-width: 640px) {
        .users-grid { grid-template-columns: 1fr; gap: 0.7rem; }
    }
</style>

<div class="admin-grid-3-1">

    {{-- ── Lista utenti (card grid) ── --}}
    <div class="admin-card" style="padding:0;overflow:hidden;">
        <div style="padding:1rem 1.25rem;border-bottom:1px solid rgba(168,212,171,0.08);display:flex;align-items:center;justify-content:space-between;">
            <div class="section-title" style="margin:0;">Tutti gli Utenti</div>
            <span style="font-family:'DM Sans',sans-serif;font-size:0.75rem;color:rgba(168,212,171,0.35);">{{ $users->count() }} utenti</span>
        </div>

        <div style="padding:1rem;">
            <div class="users-grid">
                @foreach($users as $user)
                @php
                    $isMe      = $user->id === auth()->id();
                    $isSuper   = $user->isSuperAdmin();
                    $approved  = $user->is_approved;
                    $mustChange = $user->must_change_password;
                @endphp
                <div class="user-card" style="{{ $isSuper ? 'border-color:rgba(196,181,253,0.2);' : '' }}">

                    {{-- Header --}}
                    <div class="user-card-head" style="{{ $isSuper ? 'background:rgba(196,181,253,0.05);' : '' }}">
                        <div class="user-avatar" style="{{ $isSuper ? 'background:linear-gradient(135deg,#7C3AED,#5B21B6);' : '' }}">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div style="min-width:0;flex:1;">
                            <div class="user-name">{{ $user->name }}
                                @if($isMe)
                                <span style="font-size:0.62rem;color:rgba(168,212,171,0.4);font-weight:400;"> (tu)</span>
                                @endif
                            </div>
                            <div class="user-email">{{ $user->email }}</div>
                        </div>
                    </div>

                    {{-- Badges --}}
                    <div class="user-card-badges">
                        @if($isSuper)
                        <span class="badge badge-super">Super Admin</span>
                        @else
                        <span style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(168,212,171,0.4);">Admin</span>
                        @endif

                        @if($approved)
                        <span class="badge badge-approved">Approvato</span>
                        @else
                        <span class="badge badge-pending">In attesa</span>
                        @endif

                        @if($mustChange)
                        <span class="badge" style="background:rgba(251,191,36,0.15);color:#FCD34D;">cambio pwd</span>
                        @endif
                    </div>

                    {{-- Footer: data + azioni --}}
                    <div class="user-card-foot">
                        <span class="user-date">{{ $user->created_at->format('d/m/Y') }}</span>

                        <div class="user-actions">
                            {{-- Modifica --}}
                            <button type="button" class="btn-secondary"
                                style="padding:0.3rem 0.65rem;font-size:0.72rem;"
                                onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Modifica
                            </button>

                            {{-- Reset password --}}
                            <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" style="display:inline;"
                                  onsubmit="return confirm('Resettare la password di {{ addslashes($user->name) }}?');">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-secondary" style="padding:0.3rem 0.65rem;font-size:0.72rem;" title="Reset password">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                    Pwd
                                </button>
                            </form>

                            {{-- Approva --}}
                            @if(!$approved)
                            <form method="POST" action="{{ route('admin.users.approve', $user) }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-secondary" style="padding:0.3rem 0.65rem;font-size:0.72rem;">
                                    Approva
                                </button>
                            </form>
                            @endif

                            @if(!$isMe)
                            {{-- Super toggle --}}
                            <form method="POST" action="{{ route('admin.users.super', $user) }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-secondary"
                                    style="padding:0.3rem 0.65rem;font-size:0.72rem;"
                                    title="{{ $isSuper ? 'Rimuovi super admin' : 'Rendi super admin' }}">
                                    {{ $isSuper ? '↓ Declassa' : '↑ Super' }}
                                </button>
                            </form>

                            {{-- Elimina --}}
                            @if(!$isSuper)
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline;"
                                  onsubmit="return confirm('Eliminare l\'utente {{ addslashes($user->name) }}?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger" style="padding:0.3rem 0.5rem;" title="Elimina">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                        <path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                    </svg>
                                </button>
                            </form>
                            @endif
                            @endif
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── Form nuovo utente ── --}}
    <div class="admin-card">
        <div class="section-title">Nuovo Utente</div>
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div style="margin-bottom:1rem;">
                <label class="admin-label" for="new-name">Nome</label>
                <input type="text" id="new-name" name="name" class="admin-input"
                       placeholder="Nome completo" value="{{ old('name') }}" required>
                @error('name')
                <div style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:#FCA5A5;margin-top:0.3rem;">{{ $message }}</div>
                @enderror
            </div>
            <div style="margin-bottom:1.25rem;">
                <label class="admin-label" for="new-email">Email</label>
                <input type="email" id="new-email" name="email" class="admin-input"
                       placeholder="email@esempio.com" value="{{ old('email') }}" required>
                @error('email')
                <div style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:#FCA5A5;margin-top:0.3rem;">{{ $message }}</div>
                @enderror
            </div>
            <div style="margin-bottom:1.25rem;padding:0.85rem;background:rgba(22,163,74,0.06);border:1px solid rgba(22,163,74,0.15);border-radius:0.5rem;">
                <div style="font-family:'DM Sans',sans-serif;font-size:0.74rem;color:rgba(168,212,171,0.65);line-height:1.5;">
                    Una password temporanea verrà generata automaticamente. L'utente dovrà cambiarla al primo accesso.
                </div>
            </div>
            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Crea Utente
            </button>
        </form>
    </div>

</div>

{{-- ── Modal reset password ── --}}
@if(session('reset_user'))
@php $ru = session('reset_user'); @endphp
<div id="reset-modal-overlay" style="position:fixed;inset:0;background:rgba(0,0,0,0.75);z-index:9000;display:flex;align-items:center;justify-content:center;padding:1rem;">
    <div style="background:#0D1F0B;border:1px solid rgba(251,191,36,0.3);border-radius:1.25rem;padding:2rem 2rem 1.75rem;width:100%;max-width:460px;position:relative;box-shadow:0 20px 60px rgba(0,0,0,0.6);">
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
            <div style="width:40px;height:40px;border-radius:50%;background:rgba(251,191,36,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FCD34D" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <div>
                <div style="font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:700;color:#F0F5F1;">Password resettata</div>
                <div style="font-family:'DM Sans',sans-serif;font-size:0.75rem;color:rgba(252,211,77,0.5);margin-top:0.1rem;">Copia e invia la nuova password all'utente</div>
            </div>
        </div>
        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(252,211,77,0.1);border-radius:0.65rem;padding:1rem;margin-bottom:1.25rem;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.6rem;">
                <span style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(252,211,77,0.45);letter-spacing:0.1em;text-transform:uppercase;">Utente</span>
                <span style="font-family:'DM Sans',sans-serif;font-size:0.84rem;color:#F0F5F1;font-weight:500;">{{ $ru['name'] }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <span style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(252,211,77,0.45);letter-spacing:0.1em;text-transform:uppercase;">Email</span>
                <span style="font-family:'DM Sans',sans-serif;font-size:0.84rem;color:#FCD34D;">{{ $ru['email'] }}</span>
            </div>
        </div>
        <div style="margin-bottom:1.5rem;">
            <div style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(252,211,77,0.45);letter-spacing:0.1em;text-transform:uppercase;margin-bottom:0.5rem;">Nuova Password Temporanea</div>
            <div style="display:flex;align-items:center;gap:0.6rem;">
                <div style="flex:1;background:rgba(0,0,0,0.35);border:1px solid rgba(252,211,77,0.25);border-radius:0.6rem;padding:0.9rem 1rem;font-family:monospace;font-size:1.2rem;font-weight:700;color:#FCD34D;letter-spacing:0.15em;word-break:break-all;">{{ $ru['password'] }}</div>
                <button onclick="copyResetPwd('{{ $ru['password'] }}')" id="copy-reset-btn" title="Copia password"
                    style="flex-shrink:0;width:44px;height:44px;border-radius:0.6rem;background:rgba(252,211,77,0.12);border:1px solid rgba(252,211,77,0.25);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FCD34D" stroke-width="2">
                        <rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                    </svg>
                </button>
            </div>
            <div id="copy-reset-feedback" style="font-family:'DM Sans',sans-serif;font-size:0.73rem;color:#FCD34D;margin-top:0.4rem;opacity:0;transition:opacity 0.3s;">✓ Copiata negli appunti</div>
        </div>
        <button onclick="document.getElementById('reset-modal-overlay').remove()"
            style="width:100%;padding:0.7rem;background:rgba(252,211,77,0.08);border:1px solid rgba(252,211,77,0.15);border-radius:0.6rem;color:rgba(252,211,77,0.7);font-family:'DM Sans',sans-serif;font-size:0.84rem;font-weight:500;cursor:pointer;transition:all 0.2s;"
            onmouseover="this.style.background='rgba(252,211,77,0.14)'" onmouseout="this.style.background='rgba(252,211,77,0.08)'">
            Ho copiato la password — Chiudi
        </button>
    </div>
</div>
<script>
function copyResetPwd(pwd) {
    navigator.clipboard.writeText(pwd).then(() => {
        const fb = document.getElementById('copy-reset-feedback');
        const btn = document.getElementById('copy-reset-btn');
        fb.style.opacity = '1';
        btn.style.background = 'rgba(252,211,77,0.25)';
        setTimeout(() => { fb.style.opacity = '0'; btn.style.background = 'rgba(252,211,77,0.12)'; }, 2500);
    });
}
</script>
@endif

{{-- ── Modal modifica utente ── --}}
<div id="edit-modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.75);z-index:9000;align-items:center;justify-content:center;padding:1rem;">
    <div style="background:#0D1F0B;border:1px solid rgba(168,212,171,0.2);border-radius:1.25rem;padding:2rem;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,0.6);">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
            <div style="font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:700;color:#F0F5F1;">Modifica Utente</div>
            <button onclick="closeEditModal()" style="background:none;border:none;cursor:pointer;color:rgba(168,212,171,0.5);padding:0.25rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form id="edit-form" method="POST" action="">
            @csrf @method('PATCH')
            <div style="margin-bottom:1rem;">
                <label class="admin-label" for="edit-name">Nome</label>
                <input type="text" id="edit-name" name="name" class="admin-input" required>
            </div>
            <div style="margin-bottom:1.5rem;">
                <label class="admin-label" for="edit-email">Email</label>
                <input type="email" id="edit-email" name="email" class="admin-input" required>
            </div>
            <div style="display:flex;gap:0.75rem;">
                <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">Salva modifiche</button>
                <button type="button" onclick="closeEditModal()" class="btn-secondary" style="padding:0.55rem 1rem;">Annulla</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEditModal(id, name, email) {
    document.getElementById('edit-name').value  = name;
    document.getElementById('edit-email').value = email;
    document.getElementById('edit-form').action = '/admin/users/' + id;
    const overlay = document.getElementById('edit-modal-overlay');
    overlay.style.display = 'flex';
}
function closeEditModal() {
    document.getElementById('edit-modal-overlay').style.display = 'none';
}
document.getElementById('edit-modal-overlay').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
</script>
@endpush

@endsection
