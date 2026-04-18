@extends('admin.layouts.admin')

@section('title', 'Recensioni')
@section('page-title', 'Recensioni')

@section('content')

<style>
    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 1rem;
    }
    .review-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(168,212,171,0.1);
        border-radius: 0.875rem;
        overflow: hidden;
        transition: border-color 0.2s;
        display: flex; flex-direction: column;
    }
    .review-card.pending { border-color: rgba(252,211,77,0.25); background: rgba(252,211,77,0.03); }
    .review-card.approved { border-color: rgba(74,222,128,0.2); }
    .review-card-header {
        padding: 0.9rem 1.1rem 0.75rem;
        border-bottom: 1px solid rgba(168,212,171,0.07);
        display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;
    }
    .review-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg,#16A34A,#0D7A32);
        display: flex; align-items: center; justify-content: center;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.78rem; font-weight: 700; color: #F0F5F1;
        flex-shrink: 0;
    }
    .review-name {
        font-family: 'Playfair Display', serif;
        font-size: 1rem; font-weight: 700; color: #F0F5F1;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .review-email {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.7rem; color: rgba(168,212,171,0.4);
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .review-body { padding: 0.85rem 1.1rem; flex: 1; }
    .review-stars {
        display: inline-flex; gap: 0.1rem;
        color: #FACC15;
        margin-bottom: 0.55rem;
        font-size: 0.9rem;
    }
    .review-stars .empty { color: rgba(168,212,171,0.18); }
    .review-text {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.85rem; line-height: 1.55;
        color: rgba(240,245,241,0.82);
        white-space: pre-line;
        word-break: break-word;
    }
    .review-footer {
        padding: 0.65rem 1.1rem;
        border-top: 1px solid rgba(168,212,171,0.06);
        display: flex; align-items: center; justify-content: space-between; gap: 0.5rem;
        flex-wrap: wrap;
    }
    .review-time {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.7rem; color: rgba(168,212,171,0.35);
    }
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
    .btn-approve {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.4rem 0.75rem; border-radius: 0.5rem;
        background: rgba(22,163,74,0.15);
        border: 1px solid rgba(22,163,74,0.3);
        color: #4ADE80;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.75rem; font-weight: 600;
        cursor: pointer; transition: all 0.2s;
    }
    .btn-approve:hover { background: rgba(22,163,74,0.25); }
    .btn-unapprove {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.4rem 0.75rem; border-radius: 0.5rem;
        background: rgba(252,211,77,0.1);
        border: 1px solid rgba(252,211,77,0.28);
        color: #FACC15;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.75rem; font-weight: 500;
        cursor: pointer; transition: all 0.2s;
    }
    .btn-unapprove:hover { background: rgba(252,211,77,0.2); }

    @media (max-width: 640px) {
        .reviews-grid { grid-template-columns: 1fr; }
    }
</style>

{{-- Header --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;flex-wrap:wrap;gap:0.5rem;">
    <div style="font-family:'DM Sans',sans-serif;font-size:0.82rem;color:rgba(168,212,171,0.4);">
        {{ $counts['all'] }} recensioni verificate totali
    </div>
</div>

{{-- Filter tabs --}}
<div class="filter-tabs">
    <a href="{{ route('admin.reviews.index') }}" class="filter-tab {{ $filter === 'all' ? 'active' : '' }}">
        Tutte <span class="count">{{ $counts['all'] }}</span>
    </a>
    <a href="{{ route('admin.reviews.index', ['filter' => 'pending']) }}" class="filter-tab {{ $filter === 'pending' ? 'active' : '' }}">
        In attesa <span class="count">{{ $counts['pending'] }}</span>
    </a>
    <a href="{{ route('admin.reviews.index', ['filter' => 'approved']) }}" class="filter-tab {{ $filter === 'approved' ? 'active' : '' }}">
        Pubblicate <span class="count">{{ $counts['approved'] }}</span>
    </a>
</div>

@if($reviews->isEmpty())
<div class="admin-card" style="padding:3rem;text-align:center;font-family:'DM Sans',sans-serif;font-size:0.88rem;color:rgba(168,212,171,0.35);">
    Nessuna recensione {{ $filter === 'pending' ? 'in attesa di approvazione' : ($filter === 'approved' ? 'pubblicata' : '') }}.
</div>
@else

<div class="reviews-grid">
    @foreach($reviews as $review)
    <div class="review-card {{ $review->is_approved ? 'approved' : 'pending' }}">

        {{-- Header --}}
        <div class="review-card-header">
            <div style="display:flex;align-items:center;gap:0.6rem;min-width:0;">
                <div class="review-avatar">{{ $review->initials ?: 'MH' }}</div>
                <div style="min-width:0;">
                    <div class="review-name">{{ $review->full_name }}</div>
                    <div class="review-email">{{ $review->email }}</div>
                </div>
            </div>
            @if($review->is_approved)
                <span class="badge badge-approved">Pubblicata</span>
            @else
                <span class="badge badge-pending">In attesa</span>
            @endif
        </div>

        {{-- Body --}}
        <div class="review-body">
            <div class="review-stars">
                @for($i = 1; $i <= 5; $i++)
                    <span class="{{ $i <= $review->rating ? '' : 'empty' }}">★</span>
                @endfor
            </div>
            <div class="review-text">{{ $review->text }}</div>
        </div>

        {{-- Footer --}}
        <div class="review-footer">
            <span class="review-time" title="{{ $review->created_at->format('d/m/Y H:i') }}">
                {{ $review->created_at->diffForHumans() }}
            </span>
            <div style="display:flex;gap:0.4rem;">
                @if($review->is_approved)
                    <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" style="display:inline;">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-unapprove" title="Nascondi">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            Nascondi
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" style="display:inline;">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-approve" title="Approva">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Approva
                        </button>
                    </form>
                @endif
                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" style="display:inline;"
                      onsubmit="return confirm('Eliminare definitivamente la recensione di {{ addslashes($review->full_name) }}?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger" style="padding:0.35rem 0.55rem;" title="Elimina">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($reviews->hasPages())
<div style="margin-top:1.5rem;">
    {{ $reviews->links() }}
</div>
@endif

@endif

@endsection
