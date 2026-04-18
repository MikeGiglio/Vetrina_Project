@extends('admin.layouts.admin')

@section('title', 'Iscritti email')
@section('page-title', 'Iscritti email')

@section('content')

<style>
    .filter-tabs {
        display: flex; gap: 0.4rem; flex-wrap: wrap;
        margin-bottom: 1.25rem;
    }
    .filter-tab {
        padding: 0.45rem 0.9rem; border-radius: 2rem;
        background: rgba(168,212,171,0.05);
        border: 1px solid rgba(168,212,171,0.12);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.76rem; font-weight: 500;
        color: rgba(168,212,171,0.6);
        text-decoration: none;
        transition: all 0.2s;
    }
    .filter-tab:hover { background: rgba(168,212,171,0.1); color: #A8D4AB; }
    .filter-tab.active {
        background: rgba(22,163,74,0.18);
        border-color: rgba(22,163,74,0.4);
        color: #A8D4AB; font-weight: 600;
    }
    .filter-tab .count {
        display: inline-block;
        margin-left: 0.35rem;
        background: rgba(168,212,171,0.15);
        padding: 0.05rem 0.45rem;
        border-radius: 999px;
        font-size: 0.68rem;
    }
    .add-subscriber-form {
        display: flex; gap: 0.5rem; flex-wrap: wrap;
        align-items: end;
    }
    .add-subscriber-form .field { flex: 1; min-width: 180px; }
    .source-pill {
        display: inline-block;
        padding: 0.1rem 0.5rem; border-radius: 999px;
        font-size: 0.68rem; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
    }
    .source-review { background: rgba(74,222,128,0.15); color: #4ADE80; }
    .source-manual { background: rgba(147,197,253,0.15); color: #93C5FD; }
    .source-import { background: rgba(196,181,253,0.15); color: #C4B5FD; }
</style>

{{-- Actions --}}
<div class="admin-grid-3-2" style="margin-bottom:1.5rem;">

    {{-- Add single subscriber --}}
    <div class="admin-card-sm">
        <div class="section-title" style="margin-bottom:0.75rem;">Aggiungi iscritto manualmente</div>
        <form method="POST" action="{{ route('admin.email.subscribers.store') }}" class="add-subscriber-form">
            @csrf
            <div class="field">
                <input type="email" name="email" class="admin-input" required placeholder="email@esempio.com" maxlength="150">
            </div>
            <div class="field">
                <input type="text" name="name" class="admin-input" placeholder="Nome (opzionale)" maxlength="120">
            </div>
            <button type="submit" class="btn-primary">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Aggiungi
            </button>
        </form>
    </div>

    {{-- Import CSV --}}
    <div class="admin-card-sm">
        <div class="section-title" style="margin-bottom:0.75rem;">Importa da CSV</div>
        <form method="POST" action="{{ route('admin.email.subscribers.import') }}" enctype="multipart/form-data" style="display:flex;gap:0.5rem;align-items:end;">
            @csrf
            <div style="flex:1;">
                <input type="file" name="csv" accept=".csv,.txt" required class="admin-input" style="padding:0.45rem;">
            </div>
            <button type="submit" class="btn-secondary">Importa</button>
        </form>
        <div style="font-family:'DM Sans',sans-serif;font-size:0.7rem;color:rgba(168,212,171,0.4);margin-top:0.5rem;">
            Formato: 1 colonna email, 2° colonna nome (opzionale). Prima riga può essere intestazione.
        </div>
    </div>
</div>

{{-- Filter tabs --}}
<div class="filter-tabs">
    <a href="{{ route('admin.email.subscribers', ['filter' => 'active']) }}" class="filter-tab {{ $filter === 'active' ? 'active' : '' }}">
        Attivi <span class="count">{{ $counts['active'] }}</span>
    </a>
    <a href="{{ route('admin.email.subscribers', ['filter' => 'unsubscribed']) }}" class="filter-tab {{ $filter === 'unsubscribed' ? 'active' : '' }}">
        Disiscritti <span class="count">{{ $counts['unsubscribed'] }}</span>
    </a>
    <a href="{{ route('admin.email.subscribers', ['filter' => 'all']) }}" class="filter-tab {{ $filter === 'all' ? 'active' : '' }}">
        Tutti <span class="count">{{ $counts['all'] }}</span>
    </a>
</div>

{{-- List --}}
@if($subscribers->isEmpty())
<div class="admin-card" style="padding:3rem;text-align:center;font-family:'DM Sans',sans-serif;font-size:0.88rem;color:rgba(168,212,171,0.35);">
    Nessun iscritto {{ $filter === 'unsubscribed' ? 'disiscritto' : ($filter === 'active' ? 'attivo' : '') }}.
</div>
@else
<div class="admin-card" style="padding:0;overflow:hidden;">
    <div class="table-scroll">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Nome</th>
                    <th>Fonte</th>
                    <th>Consenso</th>
                    <th>Stato</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscribers as $s)
                <tr>
                    <td style="font-family:monospace;font-size:0.78rem;">{{ $s->email }}</td>
                    <td>{{ $s->name ?? '—' }}</td>
                    <td><span class="source-pill source-{{ $s->source }}">{{ ucfirst($s->source) }}</span></td>
                    <td title="{{ $s->consent_at?->format('d/m/Y H:i') }} · IP: {{ $s->consent_ip ?? '—' }}">
                        {{ $s->consent_at?->format('d/m/Y') ?? '—' }}
                    </td>
                    <td>
                        @if($s->unsubscribed_at)
                            <span class="badge badge-cancelled">Disiscritto</span>
                        @else
                            <span class="badge badge-approved">Attivo</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        <form method="POST" action="{{ route('admin.email.subscribers.destroy', $s) }}" style="display:inline;"
                              onsubmit="return confirm('Eliminare definitivamente {{ addslashes($s->email) }}?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger" style="padding:0.3rem 0.5rem;" title="Elimina">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if($subscribers->hasPages())
<div style="margin-top:1.5rem;">
    {{ $subscribers->links() }}
</div>
@endif
@endif

@endsection
