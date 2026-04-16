@extends('admin.layouts.admin')

@section('title', 'Visitatori')
@section('page-title', 'Visitatori')

@section('content')

@php
    $deviceTotal = $desktop + $tablet + $mobile;
    $pctDesktop  = $deviceTotal > 0 ? round($desktop / $deviceTotal * 100) : 0;
    $pctTablet   = $deviceTotal > 0 ? round($tablet  / $deviceTotal * 100) : 0;
    $pctMobile   = $deviceTotal > 0 ? round($mobile  / $deviceTotal * 100) : 0;

    function deviceType(string $ua): string {
        $ua = strtolower($ua);
        if (str_contains($ua, 'ipad') || (str_contains($ua, 'android') && !str_contains($ua, 'mobile')) || str_contains($ua, 'tablet')) return 'tablet';
        if (str_contains($ua, 'mobile') || str_contains($ua, 'iphone') || str_contains($ua, 'ipod') || str_contains($ua, 'blackberry') || str_contains($ua, 'windows phone')) return 'mobile';
        return 'desktop';
    }
@endphp

<style>
    /* ---- stat cards ---- */
    .vis-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.85rem;
        margin-bottom: 1.25rem;
    }
    .vis-stat-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(168,212,171,0.1);
        border-radius: 0.875rem;
        padding: 1rem 1.15rem 0.9rem;
    }
    .vis-stat-label {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.68rem; font-weight: 600;
        letter-spacing: 0.1em; text-transform: uppercase;
        color: rgba(168,212,171,0.4);
        margin-bottom: 0.4rem;
    }
    .vis-stat-value {
        font-family: 'Playfair Display', serif;
        font-size: 1.9rem; font-weight: 700;
        color: #F0F5F1; line-height: 1;
    }
    .vis-stat-sub {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.7rem; color: rgba(168,212,171,0.35);
        margin-top: 0.3rem;
    }

    /* ---- middle row ---- */
    .vis-mid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
        margin-bottom: 1.25rem;
    }

    /* ---- device bar ---- */
    .device-bar {
        display: flex; height: 8px; border-radius: 4px; overflow: hidden; margin: 0.85rem 0 0.6rem;
    }
    .device-bar-seg { transition: width 0.4s; }
    .device-row {
        display: flex; align-items: center; justify-content: space-between;
        font-family: 'DM Sans', sans-serif; font-size: 0.8rem;
        color: rgba(168,212,171,0.7); padding: 0.35rem 0;
        border-bottom: 1px solid rgba(168,212,171,0.05);
    }
    .device-row:last-child { border-bottom: none; }
    .device-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .device-pct {
        font-family: 'DM Sans', sans-serif; font-weight: 700;
        font-size: 0.82rem; color: #A8D4AB;
    }

    /* ---- top pages ---- */
    .page-row {
        display: flex; align-items: center; gap: 0.6rem;
        padding: 0.4rem 0;
        border-bottom: 1px solid rgba(168,212,171,0.05);
        font-family: 'DM Sans', sans-serif; font-size: 0.8rem;
    }
    .page-row:last-child { border-bottom: none; }
    .page-rank {
        width: 18px; text-align: center;
        font-size: 0.65rem; font-weight: 700;
        color: rgba(168,212,171,0.3);
        flex-shrink: 0;
    }
    .page-path {
        flex: 1; color: #A8D4AB; font-weight: 500;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .page-count {
        font-size: 0.75rem; font-weight: 700; color: rgba(168,212,171,0.6);
        background: rgba(168,212,171,0.07); border-radius: 0.3rem;
        padding: 0.1rem 0.45rem; flex-shrink: 0;
    }

    /* ---- visit cards ---- */
    .vis-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 0.75rem;
    }
    .vis-card {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(168,212,171,0.08);
        border-radius: 0.75rem;
        overflow: hidden;
        transition: border-color 0.2s;
    }
    .vis-card:hover { border-color: rgba(168,212,171,0.18); }
    .vis-card-head {
        display: flex; align-items: center; gap: 0.6rem;
        padding: 0.7rem 0.9rem;
        border-bottom: 1px solid rgba(168,212,171,0.06);
    }
    .vis-device-icon {
        width: 30px; height: 30px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .vis-ip {
        font-family: monospace; font-size: 0.85rem; font-weight: 700;
        color: #A8D4AB; flex: 1;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .vis-time {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.68rem; color: rgba(168,212,171,0.3);
        flex-shrink: 0;
    }
    .vis-card-body { padding: 0.55rem 0.9rem 0.65rem; }
    .vis-page {
        font-family: 'DM Sans', sans-serif; font-size: 0.82rem;
        font-weight: 600; color: #F0F5F1;
        margin-bottom: 0.3rem;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .vis-ref {
        font-family: 'DM Sans', sans-serif; font-size: 0.72rem;
        color: rgba(168,212,171,0.35);
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }

    /* ---- responsive ---- */
    @media (max-width: 900px) {
        .vis-stats { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .vis-stats { grid-template-columns: repeat(2, 1fr); gap: 0.6rem; }
        .vis-stat-value { font-size: 1.5rem; }
        .vis-mid { grid-template-columns: 1fr; }
        .vis-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 380px) {
        .vis-stats { grid-template-columns: 1fr 1fr; }
    }
</style>

{{-- ====== STAT CARDS ====== --}}
<div class="vis-stats">

    <div class="vis-stat-card">
        <div class="vis-stat-label">Visite Totali</div>
        <div class="vis-stat-value">{{ number_format($totalViews) }}</div>
        <div class="vis-stat-sub">tutte le pagine</div>
    </div>

    <div class="vis-stat-card" style="border-color:rgba(74,222,128,0.18);">
        <div class="vis-stat-label">IP Unici</div>
        <div class="vis-stat-value" style="color:#4ADE80;">{{ number_format($uniqueIps) }}</div>
        <div class="vis-stat-sub">visitatori distinti</div>
    </div>

    <div class="vis-stat-card" style="border-color:rgba(147,197,253,0.18);">
        <div class="vis-stat-label">Oggi</div>
        <div class="vis-stat-value" style="color:#93C5FD;">{{ $today }}</div>
        <div class="vis-stat-sub">{{ now()->format('d/m/Y') }}</div>
    </div>

    <div class="vis-stat-card" style="border-color:rgba(196,181,253,0.18);">
        <div class="vis-stat-label">Ultimi 7 gg</div>
        <div class="vis-stat-value" style="color:#C4B5FD;">{{ $thisWeek }}</div>
        <div class="vis-stat-sub">visite settimana</div>
    </div>

</div>

{{-- ====== MID ROW: devices + top pages ====== --}}
<div class="vis-mid">

    {{-- Dispositivi --}}
    <div class="admin-card">
        <div class="section-title">Dispositivi <span style="font-family:'DM Sans',sans-serif;font-size:0.7rem;font-weight:400;color:rgba(168,212,171,0.35);letter-spacing:0;text-transform:none;">(per IP unico)</span></div>

        <div class="device-bar">
            <div class="device-bar-seg" style="width:{{ $pctDesktop }}%;background:#4ADE80;"></div>
            <div class="device-bar-seg" style="width:{{ $pctTablet }}%;background:#93C5FD;"></div>
            <div class="device-bar-seg" style="width:{{ $pctMobile }}%;background:#C4B5FD;"></div>
        </div>

        <div class="device-row">
            <div style="display:flex;align-items:center;gap:0.55rem;">
                <div class="device-dot" style="background:#4ADE80;"></div>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#4ADE80" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                <span>Desktop</span>
            </div>
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <span style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(168,212,171,0.4);">{{ $desktop }} IP</span>
                <span class="device-pct">{{ $pctDesktop }}%</span>
            </div>
        </div>

        <div class="device-row">
            <div style="display:flex;align-items:center;gap:0.55rem;">
                <div class="device-dot" style="background:#93C5FD;"></div>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#93C5FD" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="9" y1="7" x2="15" y2="7"/><circle cx="12" cy="17" r="1" fill="#93C5FD" stroke="none"/></svg>
                <span>Tablet</span>
            </div>
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <span style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(168,212,171,0.4);">{{ $tablet }} IP</span>
                <span class="device-pct">{{ $pctTablet }}%</span>
            </div>
        </div>

        <div class="device-row">
            <div style="display:flex;align-items:center;gap:0.55rem;">
                <div class="device-dot" style="background:#C4B5FD;"></div>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C4B5FD" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="9" y1="7" x2="15" y2="7"/><circle cx="12" cy="17" r="1" fill="#C4B5FD" stroke="none"/></svg>
                <span>Mobile</span>
            </div>
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <span style="font-family:'DM Sans',sans-serif;font-size:0.72rem;color:rgba(168,212,171,0.4);">{{ $mobile }} IP</span>
                <span class="device-pct">{{ $pctMobile }}%</span>
            </div>
        </div>

        <div style="margin-top:1rem;padding-top:0.85rem;border-top:1px solid rgba(168,212,171,0.07);">
            <div class="vis-stat-label" style="margin-bottom:0.6rem;">Top IP</div>
            @foreach($topIps as $i => $row)
            <div style="display:flex;align-items:center;gap:0.5rem;padding:0.3rem 0;border-bottom:1px solid rgba(168,212,171,0.04);">
                <span style="font-family:monospace;font-size:0.68rem;font-weight:700;color:rgba(168,212,171,0.25);width:14px;text-align:center;">{{ $i+1 }}</span>
                <span style="font-family:monospace;font-size:0.78rem;color:#A8D4AB;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $row->ip_address }}</span>
                <span style="font-family:'DM Sans',sans-serif;font-size:0.72rem;font-weight:700;color:rgba(168,212,171,0.55);background:rgba(168,212,171,0.07);border-radius:0.25rem;padding:0.1rem 0.4rem;">{{ $row->visits }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Top Pagine --}}
    <div class="admin-card">
        <div class="section-title">Pagine Più Visitate</div>

        @if($topPages->isEmpty())
        <div style="font-family:'DM Sans',sans-serif;font-size:0.82rem;color:rgba(168,212,171,0.35);padding:1rem 0;">
            Nessun dato.
        </div>
        @else
        @foreach($topPages as $i => $pg)
        <div class="page-row">
            <span class="page-rank">{{ $i + 1 }}</span>
            <span class="page-path" title="{{ $pg->page }}">{{ $pg->page ?: '/' }}</span>
            @php
                $maxPg = $topPages->first()->visits;
                $barW  = $maxPg > 0 ? round($pg->visits / $maxPg * 100) : 0;
            @endphp
            <div style="width:60px;height:4px;background:rgba(168,212,171,0.08);border-radius:2px;flex-shrink:0;">
                <div style="width:{{ $barW }}%;height:100%;background:rgba(168,212,171,0.35);border-radius:2px;"></div>
            </div>
            <span class="page-count">{{ $pg->visits }}</span>
        </div>
        @endforeach
        @endif
    </div>

</div>

{{-- ====== VISITS LIST ====== --}}
<div class="admin-card" style="padding:0;overflow:hidden;">
    <div style="padding:1rem 1.25rem;border-bottom:1px solid rgba(168,212,171,0.08);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.4rem;">
        <div class="section-title" style="margin:0;">Registro Visite</div>
        <span style="font-family:'DM Sans',sans-serif;font-size:0.75rem;color:rgba(168,212,171,0.35);">{{ $views->total() }} registrazioni</span>
    </div>

    @if($views->isEmpty())
    <div style="padding:3rem;text-align:center;font-family:'DM Sans',sans-serif;font-size:0.88rem;color:rgba(168,212,171,0.35);">
        Nessuna visita ancora.
    </div>
    @else
    <div style="padding:1rem;">
        <div class="vis-grid">
            @foreach($views as $v)
            @php
                $dt     = deviceType($v->user_agent ?? '');
                $dtColor = ['desktop'=>'#4ADE80','tablet'=>'#93C5FD','mobile'=>'#C4B5FD'][$dt];
                $dtBg    = ['desktop'=>'rgba(74,222,128,0.1)','tablet'=>'rgba(147,197,253,0.1)','mobile'=>'rgba(196,181,253,0.1)'][$dt];
                $refHost = $v->referer ? parse_url($v->referer, PHP_URL_HOST) : null;
            @endphp
            <div class="vis-card">
                <div class="vis-card-head">
                    {{-- Device icon --}}
                    <div class="vis-device-icon" style="background:{{ $dtBg }};" title="{{ ucfirst($dt) }}">
                        @if($dt === 'desktop')
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="{{ $dtColor }}" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        @elseif($dt === 'tablet')
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="{{ $dtColor }}" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="9" y1="7" x2="15" y2="7"/></svg>
                        @else
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="{{ $dtColor }}" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="9" y1="7" x2="15" y2="7"/></svg>
                        @endif
                    </div>
                    <span class="vis-ip">{{ $v->ip_address }}</span>
                    <span class="vis-time" title="{{ $v->created_at->format('d/m/Y H:i:s') }}">
                        {{ $v->created_at->diffForHumans() }}
                    </span>
                </div>
                <div class="vis-card-body">
                    <div class="vis-page">
                        <span style="color:rgba(168,212,171,0.4);font-weight:400;font-size:0.7rem;">pag&nbsp;</span>{{ $v->page ?: '/' }}
                    </div>
                    @if($refHost)
                    <div class="vis-ref">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:2px;"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        {{ $refHost }}
                    </div>
                    @else
                    <div class="vis-ref">accesso diretto</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @if($views->hasPages())
    <div style="padding:1rem 1.25rem;border-top:1px solid rgba(168,212,171,0.08);">
        {{ $views->links() }}
    </div>
    @endif
    @endif
</div>

@endsection
