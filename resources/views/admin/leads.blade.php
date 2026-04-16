@extends('admin.layouts.admin')

@section('title', 'Prenotazioni')
@section('page-title', 'Prenotazioni')

@section('content')

<style>
    .leads-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1rem;
    }
    .lead-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(168,212,171,0.1);
        border-radius: 0.875rem;
        overflow: hidden;
        transition: border-color 0.2s;
    }
    .lead-card:hover { border-color: rgba(168,212,171,0.22); }
    .lead-card-header {
        padding: 0.9rem 1.1rem 0.75rem;
        border-bottom: 1px solid rgba(168,212,171,0.07);
        display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;
    }
    .lead-name {
        font-family: 'Playfair Display', serif;
        font-size: 1rem; font-weight: 700; color: #F0F5F1;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .lead-card-body { padding: 0.85rem 1.1rem; }
    .lead-dates {
        display: flex; align-items: center; gap: 0.5rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9rem; font-weight: 600; color: #A8D4AB;
        margin-bottom: 0.6rem;
    }
    .lead-dates-arrow { color: rgba(168,212,171,0.35); font-size: 0.8rem; }
    .lead-meta {
        display: flex; flex-wrap: wrap; gap: 0.4rem 1rem;
        margin-bottom: 0.85rem;
    }
    .lead-meta-item {
        display: flex; align-items: center; gap: 0.35rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.78rem; color: rgba(168,212,171,0.55);
    }
    .lead-meta-item svg { opacity: 0.6; flex-shrink: 0; }
    .lead-meta-item strong { color: rgba(168,212,171,0.85); font-weight: 600; }
    .lead-card-footer {
        padding: 0.65rem 1.1rem;
        border-top: 1px solid rgba(168,212,171,0.06);
        display: flex; align-items: center; justify-content: space-between; gap: 0.5rem;
    }
    .lead-time {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.7rem; color: rgba(168,212,171,0.3);
    }
    .lead-ip {
        font-family: monospace;
        font-size: 0.68rem; color: rgba(168,212,171,0.25);
    }
    .status-select {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(168,212,171,0.15);
        border-radius: 2rem;
        padding: 0.3rem 0.75rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.75rem; font-weight: 600;
        outline: none; cursor: pointer;
        transition: border-color 0.2s;
    }
    .status-new       { border-color:rgba(74,222,128,0.4); color:#4ADE80; }
    .status-contacted { border-color:rgba(147,197,253,0.4); color:#93C5FD; }
    .status-confirmed { border-color:rgba(196,181,253,0.4); color:#C4B5FD; }
    .status-cancelled { border-color:rgba(252,165,165,0.4); color:#FCA5A5; }
    .status-select option { background: #0D1F0B; color: #F0F5F1; }

    @media (max-width: 640px) {
        .leads-grid { grid-template-columns: 1fr; gap: 0.75rem; }
        .lead-card-header { padding: 0.8rem 1rem 0.65rem; }
        .lead-card-body   { padding: 0.75rem 1rem; }
        .lead-card-footer { padding: 0.6rem 1rem; }
        .lead-name { font-size: 0.95rem; }
    }
</style>

{{-- Header --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:0.5rem;">
    <div style="font-family:'DM Sans',sans-serif;font-size:0.82rem;color:rgba(168,212,171,0.4);">
        {{ $leads->total() }} richieste totali
    </div>
    {{-- Legenda stati --}}
    <div style="display:flex;gap:0.6rem;flex-wrap:wrap;">
        @foreach(['new'=>['#4ADE80','Nuovo'],'contacted'=>['#93C5FD','Contattato'],'confirmed'=>['#C4B5FD','Confermato'],'cancelled'=>['#FCA5A5','Cancellato']] as $s=>[$col,$label])
        <span style="display:inline-flex;align-items:center;gap:0.3rem;font-family:'DM Sans',sans-serif;font-size:0.68rem;color:rgba(168,212,171,0.4);">
            <span style="width:7px;height:7px;border-radius:50%;background:{{ $col }};display:inline-block;"></span>{{ $label }}
        </span>
        @endforeach
    </div>
</div>

@if($leads->isEmpty())
<div class="admin-card" style="padding:3rem;text-align:center;font-family:'DM Sans',sans-serif;font-size:0.88rem;color:rgba(168,212,171,0.35);">
    Nessuna richiesta di prenotazione ancora.
</div>
@else

<div class="leads-grid">
    @foreach($leads as $lead)
    @php
        $statusColors = [
            'new'       => 'rgba(74,222,128,0.12)',
            'contacted' => 'rgba(147,197,253,0.12)',
            'confirmed' => 'rgba(196,181,253,0.12)',
            'cancelled' => 'rgba(252,165,165,0.08)',
        ];
        $statusBorder = [
            'new'       => 'rgba(74,222,128,0.25)',
            'contacted' => 'rgba(147,197,253,0.25)',
            'confirmed' => 'rgba(196,181,253,0.25)',
            'cancelled' => 'rgba(252,165,165,0.2)',
        ];
    @endphp
    <div class="lead-card" style="border-color:{{ $statusBorder[$lead->status] ?? 'rgba(168,212,171,0.1)' }};">

        {{-- Header: nome + stato --}}
        <div class="lead-card-header" style="background:{{ $statusColors[$lead->status] ?? 'transparent' }};">
            <div style="display:flex;align-items:center;gap:0.6rem;min-width:0;">
                <div style="width:32px;height:32px;border-radius:50%;background:rgba(22,163,74,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-family:'DM Sans',sans-serif;font-size:0.72rem;font-weight:700;color:#A8D4AB;">
                    {{ strtoupper(substr($lead->name, 0, 2)) }}
                </div>
                <div style="min-width:0;">
                    <div class="lead-name">{{ $lead->name }}</div>
                    <div style="font-family:'DM Sans',sans-serif;font-size:0.68rem;color:rgba(168,212,171,0.35);margin-top:0.05rem;">#{{ $lead->id }}</div>
                </div>
            </div>
            {{-- Status dropdown --}}
            <form method="POST" action="{{ route('admin.leads.status', $lead) }}" style="flex-shrink:0;">
                @csrf @method('PATCH')
                <select name="status" class="status-select status-{{ $lead->status }}" onchange="this.form.submit()">
                    <option value="new"       {{ $lead->status==='new'       ?'selected':'' }}>● Nuovo</option>
                    <option value="contacted" {{ $lead->status==='contacted' ?'selected':'' }}>● Contattato</option>
                    <option value="confirmed" {{ $lead->status==='confirmed' ?'selected':'' }}>● Confermato</option>
                    <option value="cancelled" {{ $lead->status==='cancelled' ?'selected':'' }}>● Cancellato</option>
                </select>
            </form>
        </div>

        {{-- Body --}}
        <div class="lead-card-body">

            {{-- Date --}}
            <div class="lead-dates">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#A8D4AB" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $lead->arrival->format('d/m/Y') }}
                <span class="lead-dates-arrow">→</span>
                {{ $lead->departure->format('d/m/Y') }}
                @if($lead->nights)
                <span style="font-family:'DM Sans',sans-serif;font-size:0.75rem;color:rgba(168,212,171,0.4);font-weight:400;">
                    · {{ $lead->nights }} notti
                </span>
                @endif
            </div>

            {{-- Meta info --}}
            <div class="lead-meta">
                <div class="lead-meta-item">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <strong>{{ $lead->guests }}</strong> ospiti
                </div>
                @if($lead->arrival_time)
                <div class="lead-meta-item">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    arrivo <strong>{{ $lead->arrival_time }}</strong>
                </div>
                @endif
            </div>
        </div>

        {{-- Footer: IP + tempo + elimina --}}
        <div class="lead-card-footer">
            <span class="lead-ip">{{ $lead->ip_address ?? '—' }}</span>
            <div style="display:flex;align-items:center;gap:0.6rem;">
                <span class="lead-time" title="{{ $lead->created_at->format('d/m/Y H:i') }}">
                    {{ $lead->created_at->diffForHumans() }}
                </span>
                <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" style="display:inline;"
                      onsubmit="return confirm('Eliminare la prenotazione di {{ addslashes($lead->name) }}?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger" style="padding:0.25rem 0.45rem;" title="Elimina">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Paginazione --}}
@if($leads->hasPages())
<div style="margin-top:1.5rem;">
    {{ $leads->links() }}
</div>
@endif

@endif

@endsection
