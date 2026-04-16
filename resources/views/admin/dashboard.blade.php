@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Row 1: Stat Cards --}}
<div class="admin-grid-4">

    {{-- Visite Oggi --}}
    <div class="stat-card">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div>
                <div class="stat-value">{{ $viewsToday }}</div>
                <div class="stat-label">Visite Oggi</div>
                <div style="font-family:'DM Sans',sans-serif;font-size:0.68rem;color:rgba(168,212,171,0.35);margin-top:0.4rem;">{{ $uniqueIpsToday }} IP univoci</div>
            </div>
            <div class="stat-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="1.8">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Visite 7 giorni --}}
    <div class="stat-card">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div>
                <div class="stat-value">{{ $views7Days }}</div>
                <div class="stat-label">Visite 7 Giorni</div>
                <div style="font-family:'DM Sans',sans-serif;font-size:0.68rem;color:rgba(168,212,171,0.35);margin-top:0.4rem;">{{ $views30Days }} ultimi 30 gg</div>
            </div>
            <div class="stat-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="1.8">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Lead Totali --}}
    <div class="stat-card">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div>
                <div class="stat-value">{{ $totalLeads }}</div>
                <div class="stat-label">Lead Totali</div>
                <div style="font-family:'DM Sans',sans-serif;font-size:0.68rem;color:rgba(168,212,171,0.35);margin-top:0.4rem;">richieste ricevute</div>
            </div>
            <div class="stat-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="1.8">
                    <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Lead Nuovi --}}
    <div class="stat-card" style="border-color:rgba(74,222,128,0.2);">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div>
                <div class="stat-value" style="color:#4ADE80;">{{ $newLeads }}</div>
                <div class="stat-label">Lead Nuovi</div>
                <div style="margin-top:0.5rem;">
                    <span class="badge badge-new">da gestire</span>
                </div>
            </div>
            <div class="stat-icon" style="background:rgba(74,222,128,0.1);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4ADE80" stroke-width="1.8">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
        </div>
    </div>

</div>

{{-- Row 2: Leads + Recent Views --}}
<div class="admin-grid-3-2">

    {{-- Recent leads table --}}
    <div class="admin-card" style="padding:0;overflow:hidden;">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid rgba(168,212,171,0.08);display:flex;align-items:center;justify-content:space-between;">
            <div class="section-title" style="margin:0;">Ultime Prenotazioni</div>
            <a href="{{ route('admin.leads') }}" class="btn-secondary" style="padding:0.35rem 0.8rem;font-size:0.73rem;">Vedi tutte</a>
        </div>
        @if($recentLeads->isEmpty())
        <div style="padding:2rem;text-align:center;font-family:'DM Sans',sans-serif;font-size:0.82rem;color:rgba(168,212,171,0.35);">
            Nessuna prenotazione ancora.
        </div>
        @else
        <div class="table-scroll">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Arrivo → Partenza</th>
                    <th>Ospiti</th>
                    <th>Stato</th>
                    <th>Quando</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentLeads as $lead)
                <tr>
                    <td style="font-weight:500;color:#F0F5F1;">{{ $lead->name }}</td>
                    <td>
                        <span style="color:#A8D4AB;">{{ $lead->arrival->format('d/m') }}</span>
                        <span style="color:rgba(168,212,171,0.35);margin:0 0.3rem;">→</span>
                        <span style="color:#A8D4AB;">{{ $lead->departure->format('d/m') }}</span>
                        @if($lead->nights)
                        <span style="color:rgba(168,212,171,0.4);font-size:0.72rem;margin-left:0.3rem;">({{ $lead->nights }}n)</span>
                        @endif
                    </td>
                    <td>{{ $lead->guests }}</td>
                    <td>
                        <span class="badge badge-{{ $lead->status }}">
                            {{ match($lead->status) {
                                'new' => 'Nuovo',
                                'contacted' => 'Contattato',
                                'confirmed' => 'Confermato',
                                'cancelled' => 'Cancellato',
                                default => $lead->status
                            } }}
                        </span>
                    </td>
                    <td style="color:rgba(168,212,171,0.4);font-size:0.75rem;">{{ $lead->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>{{-- /table-scroll --}}
        @endif
    </div>

    {{-- Recent page views --}}
    <div class="admin-card" style="padding:0;overflow:hidden;">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid rgba(168,212,171,0.08);display:flex;align-items:center;justify-content:space-between;">
            <div class="section-title" style="margin:0;">Visite Recenti</div>
            <a href="{{ route('admin.visitors') }}" class="btn-secondary" style="padding:0.35rem 0.8rem;font-size:0.73rem;">Vedi tutte</a>
        </div>
        @if($recentViews->isEmpty())
        <div style="padding:2rem;text-align:center;font-family:'DM Sans',sans-serif;font-size:0.82rem;color:rgba(168,212,171,0.35);">
            Nessuna visita ancora.
        </div>
        @else
        <div style="padding:0.5rem 0;">
            @foreach($recentViews as $view)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:0.65rem 1.5rem;border-bottom:1px solid rgba(168,212,171,0.04);">
                <div>
                    <div style="font-family:'DM Sans',sans-serif;font-size:0.8rem;color:#A8D4AB;font-weight:500;">{{ $view->ip_address }}</div>
                    <div style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(168,212,171,0.4);">{{ $view->page }}</div>
                </div>
                <div style="font-family:'DM Sans',sans-serif;font-size:0.7rem;color:rgba(168,212,171,0.3);white-space:nowrap;margin-left:0.75rem;">
                    {{ $view->created_at->diffForHumans() }}
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

</div>

{{-- Quick actions row --}}
<div>
    <div class="section-title">Accesso Rapido</div>
    <div class="admin-grid-4-sm">
        @foreach([
            ['Prenotazioni', 'Gestisci le richieste', route('admin.leads'), 'M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01'],
            ['Galleria', 'Carica e gestisci foto', route('admin.photos'), 'M3 3h18v18H3zM3 9h18M9 21V9'],
            ['Visitatori', 'Analizza il traffico', route('admin.visitors'), 'M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6z'],
            ['Utenti', 'Gestisci gli admin', route('admin.users'), 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2 M9 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8z'],
        ] as [$label, $desc, $href, $icon])
        <a href="{{ $href }}" style="display:block;padding:1.25rem;background:rgba(255,255,255,0.025);border:1px solid rgba(168,212,171,0.09);border-radius:0.75rem;text-decoration:none;transition:all 0.2s;" onmouseover="this.style.borderColor='rgba(22,163,74,0.3)';this.style.background='rgba(22,163,74,0.06)'" onmouseout="this.style.borderColor='rgba(168,212,171,0.09)';this.style.background='rgba(255,255,255,0.025)'">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="1.6" style="margin-bottom:0.75rem;">
                <path d="{{ $icon }}"/>
            </svg>
            <div style="font-family:'DM Sans',sans-serif;font-size:0.85rem;font-weight:600;color:#F0F5F1;margin-bottom:0.2rem;">{{ $label }}</div>
            <div style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(168,212,171,0.4);">{{ $desc }}</div>
        </a>
        @endforeach
    </div>
</div>

@endsection
