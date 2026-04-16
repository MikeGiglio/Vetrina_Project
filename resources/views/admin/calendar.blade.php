@extends('admin.layouts.admin')

@section('title', 'Calendario')
@section('page-title', 'Calendario Disponibilità')

@section('content')

@php
    $blockedSet = $blockedDates->pluck('date')->flip(); // O(1) lookup
    $monthNames = ['','Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'];
    $dayNames   = ['Lun','Mar','Mer','Gio','Ven','Sab','Dom'];

    $firstDay   = $current->copy()->startOfMonth();
    $lastDay    = $current->copy()->endOfMonth();
    // ISO: Mon=1 … Sun=7  → offset 0-6 for grid
    $startOffset = ($firstDay->dayOfWeekIso - 1);
    $totalCells  = $startOffset + $lastDay->day;
    $rows        = ceil($totalCells / 7);
@endphp

<style>
    .cal-wrap {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 1.25rem;
        align-items: start;
    }

    /* ---- calendar card ---- */
    .cal-card {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(168,212,171,0.1);
        border-radius: 0.875rem;
        overflow: hidden;
    }
    .cal-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(168,212,171,0.08);
    }
    .cal-month-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem; font-weight: 700; color: #F0F5F1;
    }
    .cal-nav-btn {
        width: 32px; height: 32px; border-radius: 0.4rem;
        background: rgba(168,212,171,0.07); border: 1px solid rgba(168,212,171,0.12);
        color: #A8D4AB; cursor: pointer; display: flex; align-items: center;
        justify-content: center; text-decoration: none; transition: background 0.2s;
    }
    .cal-nav-btn:hover { background: rgba(168,212,171,0.15); }

    .cal-grid {
        display: grid; grid-template-columns: repeat(7, 1fr);
        padding: 1rem;
        gap: 4px;
    }
    .cal-day-name {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.65rem; font-weight: 700; letter-spacing: 0.08em;
        text-transform: uppercase; color: rgba(168,212,171,0.3);
        text-align: center; padding: 0.3rem 0;
    }
    .cal-day-name.weekend { color: rgba(252,165,165,0.4); }

    .cal-cell {
        aspect-ratio: 1;
        display: flex; align-items: center; justify-content: center;
        border-radius: 0.4rem;
        font-family: 'DM Sans', sans-serif; font-size: 0.82rem; font-weight: 500;
        color: rgba(168,212,171,0.7);
        cursor: pointer; transition: background 0.15s, color 0.15s;
        user-select: none; position: relative;
    }
    .cal-cell:hover { background: rgba(168,212,171,0.1); color: #F0F5F1; }
    .cal-cell.empty { cursor: default; }
    .cal-cell.empty:hover { background: none; }
    .cal-cell.today {
        border: 1px solid rgba(168,212,171,0.35);
        color: #A8D4AB; font-weight: 700;
    }
    .cal-cell.past { color: rgba(168,212,171,0.2); cursor: default; }
    .cal-cell.past:hover { background: none; }
    .cal-cell.blocked {
        background: rgba(239,68,68,0.18);
        color: #FCA5A5; font-weight: 600;
    }
    .cal-cell.blocked:hover { background: rgba(239,68,68,0.28); }
    .cal-cell.selected {
        background: rgba(74,222,128,0.2);
        color: #4ADE80; font-weight: 700;
        outline: 1px solid rgba(74,222,128,0.4);
    }
    .cal-cell.in-range {
        background: rgba(74,222,128,0.08);
        color: #A8D4AB;
    }
    .cal-cell.weekend-num { color: rgba(252,165,165,0.55); }
    .cal-cell.weekend-num.blocked { color: #FCA5A5; }

    /* ---- right panel ---- */
    .cal-legend {
        display: flex; gap: 1rem; flex-wrap: wrap;
        padding: 0.6rem 1.25rem;
        border-top: 1px solid rgba(168,212,171,0.07);
        font-family: 'DM Sans', sans-serif; font-size: 0.72rem;
        color: rgba(168,212,171,0.45);
    }
    .legend-dot {
        width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
        display: inline-block; margin-right: 0.3rem; vertical-align: middle;
    }

    /* ---- block form ---- */
    .block-form-card { }
    .block-list-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(168,212,171,0.06);
        font-family: 'DM Sans', sans-serif; font-size: 0.8rem;
        color: rgba(168,212,171,0.7);
    }
    .block-list-item:last-child { border-bottom: none; }
    .block-date-badge {
        background: rgba(239,68,68,0.12);
        color: #FCA5A5; border-radius: 0.3rem;
        padding: 0.15rem 0.5rem; font-size: 0.72rem; font-weight: 600;
        font-family: monospace;
    }

    @media (max-width: 900px) {
        .cal-wrap { grid-template-columns: 1fr; }
    }
    @media (max-width: 500px) {
        .cal-cell { font-size: 0.72rem; }
        .cal-day-name { font-size: 0.58rem; }
    }
</style>

@if(session('cal_success'))
<div style="background:rgba(74,222,128,0.1);border:1px solid rgba(74,222,128,0.25);border-radius:0.6rem;padding:0.75rem 1rem;margin-bottom:1.25rem;font-family:'DM Sans',sans-serif;font-size:0.84rem;color:#4ADE80;">
    ✓ {{ session('cal_success') }}
</div>
@endif

<div class="cal-wrap">

    {{-- ══ CALENDARIO ══ --}}
    <div class="cal-card">
        <div class="cal-header">
            <a href="{{ route('admin.calendar', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}" class="cal-nav-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            </a>
            <span class="cal-month-title">{{ $monthNames[$current->month] }} {{ $current->year }}</span>
            <a href="{{ route('admin.calendar', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" class="cal-nav-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>

        <div class="cal-grid">
            {{-- Nomi giorni --}}
            @foreach($dayNames as $di => $dn)
            <div class="cal-day-name {{ $di >= 5 ? 'weekend' : '' }}">{{ $dn }}</div>
            @endforeach

            {{-- Celle vuote offset --}}
            @for($e = 0; $e < $startOffset; $e++)
            <div class="cal-cell empty"></div>
            @endfor

            {{-- Giorni del mese --}}
            @for($d = 1; $d <= $lastDay->day; $d++)
            @php
                $date    = $current->copy()->day($d);
                $dateStr = $date->format('Y-m-d');
                $isBlocked  = isset($blockedSet[$dateStr]);
                $isToday    = $date->isToday();
                $isPast     = $date->isPast() && !$isToday;
                $dow        = $date->dayOfWeekIso; // 6=Sat, 7=Sun
                $isWeekend  = $dow >= 6;
            @endphp
            <div class="cal-cell
                {{ $isPast    ? 'past'    : '' }}
                {{ $isToday   ? 'today'   : '' }}
                {{ $isBlocked ? 'blocked' : '' }}
                {{ $isWeekend && !$isBlocked ? 'weekend-num' : '' }}"
                data-date="{{ $dateStr }}"
                onclick="{{ $isPast ? '' : 'selectDate(this)' }}"
                title="{{ $isBlocked ? 'BLOCCATO' . ($blockedDates->firstWhere('date', $dateStr)['reason'] ? ' — '.$blockedDates->firstWhere('date', $dateStr)['reason'] : '') : $dateStr }}">
                {{ $d }}
            </div>
            @endfor
        </div>

        <div class="cal-legend">
            <span><span class="legend-dot" style="background:rgba(74,222,128,0.5);"></span>Oggi</span>
            <span><span class="legend-dot" style="background:rgba(239,68,68,0.5);"></span>Bloccato</span>
            <span><span class="legend-dot" style="background:rgba(168,212,171,0.2);"></span>Disponibile</span>
        </div>
    </div>

    {{-- ══ PANNELLO DESTRA ══ --}}
    <div style="display:flex;flex-direction:column;gap:1rem;">

        {{-- Form blocca periodo --}}
        <div class="admin-card">
            <div class="section-title">Blocca Periodo</div>

            <form method="POST" action="{{ route('admin.calendar.block') }}">
                @csrf
                <div style="margin-bottom:0.85rem;">
                    <label class="admin-label">Dal</label>
                    <input type="date" name="start" id="input-start" class="admin-input"
                           min="{{ now()->format('Y-m-d') }}" required>
                </div>
                <div style="margin-bottom:0.85rem;">
                    <label class="admin-label">Al</label>
                    <input type="date" name="end" id="input-end" class="admin-input"
                           min="{{ now()->format('Y-m-d') }}" required>
                </div>
                <div style="margin-bottom:1rem;">
                    <label class="admin-label">Motivo (opzionale)</label>
                    <input type="text" name="reason" class="admin-input"
                           placeholder="es. Booking.com, Airbnb, uso personale…">
                </div>
                <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Blocca date
                </button>
                @error('start') <div style="color:#FCA5A5;font-size:0.72rem;margin-top:0.4rem;">{{ $message }}</div> @enderror
                @error('end')   <div style="color:#FCA5A5;font-size:0.72rem;margin-top:0.4rem;">{{ $message }}</div> @enderror
            </form>
        </div>

        {{-- Sblocca intervallo --}}
        <div class="admin-card">
            <div class="section-title" style="font-size:0.82rem;">Sblocca Periodo</div>
            <form method="POST" action="{{ route('admin.calendar.unblock-range') }}">
                @csrf
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;margin-bottom:0.75rem;">
                    <div>
                        <label class="admin-label" style="font-size:0.65rem;">Dal</label>
                        <input type="date" name="start" class="admin-input" style="font-size:0.75rem;padding:0.45rem 0.6rem;" required>
                    </div>
                    <div>
                        <label class="admin-label" style="font-size:0.65rem;">Al</label>
                        <input type="date" name="end" class="admin-input" style="font-size:0.75rem;padding:0.45rem 0.6rem;" required>
                    </div>
                </div>
                <button type="submit" class="btn-secondary" style="width:100%;justify-content:center;font-size:0.78rem;"
                    onclick="return confirm('Sbloccare tutte le date in questo intervallo?')">
                    Sblocca intervallo
                </button>
            </form>
        </div>

        {{-- Lista date bloccate --}}
        <div class="admin-card" style="padding:0;overflow:hidden;">
            <div style="padding:0.85rem 1.1rem;border-bottom:1px solid rgba(168,212,171,0.08);display:flex;align-items:center;justify-content:space-between;">
                <div class="section-title" style="margin:0;font-size:0.82rem;">Date Bloccate</div>
                <span style="font-family:'DM Sans',sans-serif;font-size:0.7rem;color:rgba(168,212,171,0.35);">{{ $blocks->count() }} giorni</span>
            </div>
            @if($blocks->isEmpty())
            <div style="padding:1.5rem;text-align:center;font-family:'DM Sans',sans-serif;font-size:0.8rem;color:rgba(168,212,171,0.3);">
                Nessuna data bloccata
            </div>
            @else
            <div style="padding:0.5rem 1.1rem;max-height:280px;overflow-y:auto;">
                @foreach($blocks as $b)
                <div class="block-list-item">
                    <div>
                        <span class="block-date-badge">{{ \Carbon\Carbon::parse($b->date)->format('d/m/Y') }}</span>
                        @if($b->reason)
                        <span style="font-size:0.7rem;color:rgba(168,212,171,0.4);margin-left:0.4rem;">{{ $b->reason }}</span>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('admin.calendar.unblock', $b) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger" style="padding:0.2rem 0.4rem;font-size:0.65rem;" title="Sblocca">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>
</div>

@push('scripts')
<script>
// Date picker interattivo: click sul calendario popola i campi dal/al
const blockedDates = new Set(@json($blockedDates->pluck('date')));
let selStart = null, selEnd = null;

function selectDate(el) {
    const d = el.dataset.date;
    if (!selStart || (selStart && selEnd)) {
        // Prima selezione
        selStart = d; selEnd = null;
        document.getElementById('input-start').value = d;
        document.getElementById('input-end').value   = '';
        highlightRange();
    } else {
        // Seconda selezione
        if (d < selStart) { selEnd = selStart; selStart = d; }
        else               { selEnd = d; }
        document.getElementById('input-start').value = selStart;
        document.getElementById('input-end').value   = selEnd;
        highlightRange();
    }
}

function highlightRange() {
    document.querySelectorAll('.cal-cell[data-date]').forEach(cell => {
        cell.classList.remove('selected', 'in-range');
        const d = cell.dataset.date;
        if (!d) return;
        if (d === selStart || d === selEnd) {
            cell.classList.add('selected');
        } else if (selStart && selEnd && d > selStart && d < selEnd) {
            cell.classList.add('in-range');
        }
    });
}
</script>
@endpush

@endsection
