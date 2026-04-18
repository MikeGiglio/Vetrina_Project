@extends('admin.layouts.admin')

@section('title', 'Email')
@section('page-title', 'Email')

@section('content')

<style>
    .email-actions {
        display: flex; gap: 0.75rem; flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }
    .campaign-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(168,212,171,0.1);
        border-radius: 0.875rem;
        padding: 1.1rem 1.25rem;
        margin-bottom: 0.75rem;
        transition: border-color 0.2s;
    }
    .campaign-card:hover { border-color: rgba(168,212,171,0.22); }
    .campaign-header {
        display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;
        margin-bottom: 0.5rem;
    }
    .campaign-subject {
        font-family: 'Playfair Display', serif;
        font-size: 1.05rem; font-weight: 700; color: #F0F5F1;
        overflow: hidden; text-overflow: ellipsis;
    }
    .campaign-meta {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.72rem; color: rgba(168,212,171,0.45);
    }
    .progress-bar {
        background: rgba(168,212,171,0.08);
        border-radius: 0.35rem;
        height: 6px; overflow: hidden;
        margin: 0.5rem 0 0.3rem;
    }
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg,#16A34A,#4ADE80);
        transition: width 0.3s;
    }
    .progress-fill.failed { background: #EF4444; }
    .status-queued    { background: rgba(252,211,77,0.18); color: #FDE047; }
    .status-sending   { background: rgba(147,197,253,0.18); color: #93C5FD; }
    .status-sent      { background: rgba(74,222,128,0.18); color: #4ADE80; }
    .status-failed    { background: rgba(252,165,165,0.18); color: #FCA5A5; }
</style>

{{-- Stats --}}
<div class="admin-grid-4" style="margin-bottom:2rem;">
    <div class="stat-card">
        <div style="display:flex;align-items:center;gap:0.85rem;">
            <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
            <div>
                <div class="stat-value">{{ $stats['active'] }}</div>
                <div class="stat-label">Iscritti attivi</div>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex;align-items:center;gap:0.85rem;">
            <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
            <div>
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Totali raccolti</div>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex;align-items:center;gap:0.85rem;">
            <div class="stat-icon" style="background:rgba(239,68,68,0.12);"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div>
            <div>
                <div class="stat-value" style="color:#FCA5A5;">{{ $stats['unsubscribed'] }}</div>
                <div class="stat-label">Disiscritti</div>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display:flex;align-items:center;gap:0.85rem;">
            <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.3"/></svg></div>
            <div>
                <div class="stat-value">{{ $campaigns->total() }}</div>
                <div class="stat-label">Campagne inviate</div>
            </div>
        </div>
    </div>
</div>

{{-- Actions --}}
<div class="email-actions">
    <a href="{{ route('admin.email.compose') }}" class="btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Nuova campagna
    </a>
    <a href="{{ route('admin.email.subscribers') }}" class="btn-secondary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        Gestisci iscritti
    </a>
</div>

{{-- Campaigns list --}}
<div class="section-title">Storico campagne</div>

@if($campaigns->isEmpty())
<div class="admin-card" style="padding:3rem;text-align:center;font-family:'DM Sans',sans-serif;font-size:0.88rem;color:rgba(168,212,171,0.35);">
    Nessuna campagna inviata ancora. Inizia creandone una nuova.
</div>
@else
    @foreach($campaigns as $campaign)
    <div class="campaign-card">
        <div class="campaign-header">
            <div style="min-width:0;flex:1;">
                <div class="campaign-subject">{{ $campaign->subject }}</div>
                <div class="campaign-meta">
                    {{ $campaign->created_at->format('d/m/Y H:i') }}
                    @if($campaign->creator)
                        · {{ $campaign->creator->name }}
                    @endif
                    · {{ $campaign->total_recipients }} destinatari
                </div>
            </div>
            @php
                $statusLabels = ['queued' => 'In coda', 'sending' => 'In invio', 'sent' => 'Inviata', 'failed' => 'Fallita'];
            @endphp
            <span class="badge status-{{ $campaign->status }}">{{ $statusLabels[$campaign->status] ?? $campaign->status }}</span>
        </div>

        @if(! $campaign->isDone())
        <div class="progress-bar">
            <div class="progress-fill" style="width:{{ $campaign->progressPercent() }}%;"></div>
        </div>
        <div style="display:flex;justify-content:space-between;font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(168,212,171,0.45);">
            <span>{{ $campaign->sent_count }} inviate · {{ $campaign->failed_count }} fallite</span>
            <span>{{ $campaign->progressPercent() }}%</span>
        </div>
        @else
        <div style="display:flex;justify-content:space-between;font-family:'DM Sans',sans-serif;font-size:0.75rem;color:rgba(168,212,171,0.55);margin-top:0.4rem;">
            <span>✓ {{ $campaign->sent_count }} inviate · ✕ {{ $campaign->failed_count }} fallite</span>
            @if($campaign->finished_at)
                <span>Terminata {{ $campaign->finished_at->diffForHumans() }}</span>
            @endif
        </div>
        @endif
    </div>
    @endforeach

    @if($campaigns->hasPages())
    <div style="margin-top:1.5rem;">
        {{ $campaigns->links() }}
    </div>
    @endif
@endif

{{-- Auto-refresh if any campaign is still sending --}}
@if($campaigns->whereIn('status', ['queued', 'sending'])->isNotEmpty())
<script>
    setTimeout(() => location.reload(), 10000);
</script>
@endif

@endsection
