<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Mau House 44</title>
    <link rel="icon" type="image/png" href="/images/icon-192-admin.png">
    <link rel="apple-touch-icon" href="/images/icon-192-admin.png">
    <meta name="theme-color" content="#1C2E1A">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* ── Admin shell reset ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; }
        body { background: #030806; color: #F0F5F1; overflow-x: hidden; }
        a { color: inherit; }
        input, select, button, textarea { font-family: inherit; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #0D1F0B; }
        ::-webkit-scrollbar-thumb { background: #16A34A; border-radius: 3px; }

        .admin-shell { display: flex; min-height: 100vh; }

        /* ── Sidebar ── */
        .admin-sidebar {
            width: 240px; min-width: 240px;
            background: #050E05;
            border-right: 1px solid rgba(168,212,171,0.08);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0;
            z-index: 50; overflow-y: auto;
        }
        .admin-sidebar .logo-wrap {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(168,212,171,0.07);
        }
        .admin-sidebar .logo-link {
            display: flex; align-items: center; gap: 0.75rem;
            text-decoration: none;
        }
        .admin-sidebar .logo-title {
            font-family: 'Playfair Display', serif;
            font-size: 0.88rem; font-weight: 700;
            letter-spacing: 0.12em; color: #F0F5F1;
        }
        .admin-sidebar .logo-sub {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.58rem; letter-spacing: 0.3em;
            color: rgba(168,212,171,0.45);
            text-transform: uppercase;
        }
        .admin-sidebar nav { padding: 1.25rem 0.75rem; flex: 1; }
        .nav-section-label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem; letter-spacing: 0.3em;
            text-transform: uppercase;
            color: rgba(168,212,171,0.3);
            padding: 0 0.5rem;
            margin-bottom: 0.4rem; margin-top: 1.25rem;
        }
        .nav-section-label:first-child { margin-top: 0.25rem; }

        .admin-nav-link {
            display: flex; align-items: center; gap: 0.65rem;
            padding: 0.58rem 0.75rem; border-radius: 0.5rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem; font-weight: 500;
            color: rgba(240,245,241,0.55);
            text-decoration: none;
            transition: all 0.2s;
            margin-bottom: 0.15rem;
        }
        .admin-nav-link:hover {
            background: rgba(22,163,74,0.1);
            color: #A8D4AB;
        }
        .admin-nav-link.active {
            background: rgba(22,163,74,0.15);
            color: #A8D4AB;
            font-weight: 600;
        }
        .admin-nav-link svg { flex-shrink: 0; opacity: 0.7; }
        .admin-nav-link.active svg,
        .admin-nav-link:hover svg { opacity: 1; }

        .sidebar-user {
            padding: 1.25rem;
            border-top: 1px solid rgba(168,212,171,0.07);
        }
        .sidebar-user-info {
            display: flex; align-items: center;
            gap: 0.65rem; margin-bottom: 0.75rem;
        }
        .sidebar-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg,#16A34A,#0D7A32);
            display: flex; align-items: center; justify-content: center;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem; font-weight: 700;
            color: #F0F5F1; flex-shrink: 0;
        }
        .sidebar-user-name {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem; font-weight: 600;
            color: #F0F5F1;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .sidebar-user-email {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.63rem;
            color: rgba(168,212,171,0.4);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .btn-logout {
            width: 100%;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            padding: 0.58rem;
            background: rgba(239,68,68,0.07);
            border: 1px solid rgba(239,68,68,0.13);
            border-radius: 0.5rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.76rem; font-weight: 500;
            color: rgba(239,68,68,0.65); cursor: pointer;
            transition: all 0.2s;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.14); color: rgba(239,68,68,0.9); }

        /* ── Main area ── */
        .admin-main {
            margin-left: 240px;
            flex: 1; display: flex; flex-direction: column;
            min-height: 100vh;
        }
        .admin-topbar {
            padding: 1.25rem 2rem;
            border-bottom: 1px solid rgba(168,212,171,0.07);
            display: flex; align-items: center; justify-content: space-between;
            background: #030806;
            position: sticky; top: 0; z-index: 40;
        }
        .topbar-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem; font-weight: 700; color: #F0F5F1;
        }
        .topbar-breadcrumb {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem; color: rgba(168,212,171,0.4);
            margin-top: 0.15rem;
        }
        .topbar-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg,#16A34A,#0D7A32);
            display: flex; align-items: center; justify-content: center;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem; font-weight: 700; color: #F0F5F1;
        }
        .admin-content { padding: 2rem; flex: 1; }

        /* ── Cards ── */
        .admin-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(168,212,171,0.1);
            border-radius: 0.875rem;
            padding: 1.5rem;
        }
        .admin-card-sm {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(168,212,171,0.1);
            border-radius: 0.75rem;
            padding: 1.25rem;
        }
        .stat-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(168,212,171,0.1);
            border-radius: 0.875rem;
            padding: 1.25rem 1.5rem;
        }
        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 2rem; font-weight: 700; color: #A8D4AB;
        }
        .stat-label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.76rem; color: rgba(168,212,171,0.5);
            margin-top: 0.2rem;
        }
        .stat-icon {
            width: 42px; height: 42px; border-radius: 0.6rem;
            background: rgba(22,163,74,0.12);
            display: flex; align-items: center; justify-content: center;
        }

        /* ── Section headings ── */
        .section-title {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem; font-weight: 600;
            letter-spacing: 0.18em; text-transform: uppercase;
            color: rgba(168,212,171,0.5); margin-bottom: 1rem;
        }

        /* ── Tables ── */
        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table th {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.68rem; font-weight: 600;
            letter-spacing: 0.15em; text-transform: uppercase;
            color: rgba(168,212,171,0.45);
            padding: 0.6rem 1rem; text-align: left;
            border-bottom: 1px solid rgba(168,212,171,0.08);
        }
        .admin-table td {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem; color: rgba(240,245,241,0.75);
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(168,212,171,0.05);
            vertical-align: middle;
        }
        .admin-table tr:last-child td { border-bottom: none; }
        .admin-table tr:hover td { background: rgba(168,212,171,0.03); }

        /* ── Badges ── */
        .badge {
            display: inline-flex; align-items: center;
            padding: 0.2rem 0.6rem; border-radius: 999px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.68rem; font-weight: 600;
        }
        .badge-new      { background: rgba(22,163,74,0.18);  color: #4ADE80; }
        .badge-contacted { background: rgba(59,130,246,0.18); color: #93C5FD; }
        .badge-confirmed { background: rgba(168,85,247,0.18); color: #C4B5FD; }
        .badge-cancelled { background: rgba(239,68,68,0.18);  color: #FCA5A5; }
        .badge-super    { background: rgba(234,179,8,0.18);   color: #FDE047; }
        .badge-approved  { background: rgba(22,163,74,0.18);  color: #4ADE80; }
        .badge-pending  { background: rgba(239,68,68,0.18);   color: #FCA5A5; }

        /* ── Buttons ── */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.55rem 1.1rem; border-radius: 0.5rem;
            background: #16A34A; color: #F0F5F1;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem; font-weight: 600;
            border: none; cursor: pointer; text-decoration: none;
            transition: background 0.2s;
        }
        .btn-primary:hover { background: #15803D; }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.55rem 1.1rem; border-radius: 0.5rem;
            background: rgba(168,212,171,0.07);
            border: 1px solid rgba(168,212,171,0.15);
            color: rgba(168,212,171,0.8);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem; font-weight: 500;
            cursor: pointer; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-secondary:hover { background: rgba(168,212,171,0.12); color: #A8D4AB; }
        .btn-danger {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.45rem 0.85rem; border-radius: 0.5rem;
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.15);
            color: rgba(239,68,68,0.75);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.76rem; font-weight: 500;
            cursor: pointer; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-danger:hover { background: rgba(239,68,68,0.15); color: rgba(239,68,68,1); }

        /* ── Flash messages ── */
        .flash-message {
            position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 9999;
            padding: 0.85rem 1.25rem; border-radius: 0.6rem;
            font-family: 'DM Sans', sans-serif; font-size: 0.84rem; font-weight: 500;
            display: flex; align-items: center; gap: 0.6rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
            animation: slideIn 0.3s ease;
        }
        .flash-success { background: #0D3321; border: 1px solid rgba(22,163,74,0.35); color: #4ADE80; }
        .flash-error   { background: #3B0E0E; border: 1px solid rgba(239,68,68,0.35);  color: #FCA5A5; }
        @keyframes slideIn { from { transform: translateX(120%); opacity: 0; } to { transform: none; opacity: 1; } }

        /* ── Form elements ── */
        .admin-input {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(168,212,171,0.15);
            border-radius: 0.5rem;
            padding: 0.6rem 0.85rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.84rem; color: #F0F5F1;
            width: 100%; outline: none;
            transition: border-color 0.2s;
        }
        .admin-input:focus { border-color: rgba(22,163,74,0.5); }
        .admin-input::placeholder { color: rgba(168,212,171,0.3); }
        .admin-select {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(168,212,171,0.15);
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem; color: #F0F5F1;
            outline: none; cursor: pointer;
        }
        .admin-select option { background: #0D1F0B; }
        .admin-label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.76rem; font-weight: 500;
            color: rgba(168,212,171,0.6);
            display: block; margin-bottom: 0.35rem;
        }

        /* ── Mobile hamburger ── */
        .topbar-menu-btn {
            display: none;
            align-items: center; justify-content: center;
            width: 38px; height: 38px; border-radius: 0.5rem;
            background: rgba(168,212,171,0.07);
            border: 1px solid rgba(168,212,171,0.12);
            cursor: pointer; flex-shrink: 0;
        }
        .topbar-menu-btn svg { display: block; }

        /* ── Sidebar overlay (mobile) ── */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.65);
            z-index: 45;
        }

        /* ── Table scroll wrapper ── */
        .table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }

        /* ── Responsive grids (used in views) ── */
        .admin-grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 1.25rem; margin-bottom: 2rem; }
        .admin-grid-3-2 { display: grid; grid-template-columns: 3fr 2fr; gap: 1.5rem; margin-bottom: 2rem; }
        .admin-grid-4-sm { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; }
        .admin-grid-3-1 { display: grid; grid-template-columns: 3fr 1fr; gap: 1.5rem; align-items: start; }

        /* ─────────────────────────────
           MOBILE  ≤ 768px
        ───────────────────────────── */
        @media (max-width: 768px) {

            /* Sidebar: slide in from left */
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.28s cubic-bezier(0.4,0,0.2,1);
                z-index: 60;
            }
            .admin-sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }

            /* Main: full width */
            .admin-main { margin-left: 0; }

            /* Topbar */
            .admin-topbar { padding: 0.85rem 1rem; }
            .topbar-menu-btn { display: flex; }
            .topbar-breadcrumb { display: none; }
            .topbar-title { font-size: 1.1rem; }

            /* Content */
            .admin-content { padding: 1rem; }

            /* Grids → stack */
            .admin-grid-4   { grid-template-columns: repeat(2,1fr); gap: 0.75rem; margin-bottom: 1.25rem; }
            .admin-grid-3-2 { grid-template-columns: 1fr; gap: 1rem; margin-bottom: 1.25rem; }
            .admin-grid-4-sm { grid-template-columns: repeat(2,1fr); gap: 0.75rem; }
            .admin-grid-3-1 { grid-template-columns: 1fr; }

            /* Cards */
            .admin-card { padding: 1rem; }
            .stat-card { padding: 1rem; }
            .stat-value { font-size: 1.6rem; }

            /* Table: horizontal scroll */
            .admin-table th,
            .admin-table td { padding: 0.6rem 0.75rem; font-size: 0.76rem; }

            /* Flash */
            .flash-message { bottom: 1rem; right: 1rem; left: 1rem; font-size: 0.8rem; }
        }

        @media (max-width: 480px) {
            .admin-grid-4   { grid-template-columns: 1fr 1fr; gap: 0.6rem; }
            .admin-grid-4-sm { grid-template-columns: 1fr 1fr; gap: 0.6rem; }
            .stat-value { font-size: 1.4rem; }
        }
    </style>
</head>
<body>
<!-- Sidebar overlay (mobile) -->
<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

<div class="admin-shell">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <div class="logo-wrap">
            <a href="{{ route('admin.dashboard') }}" class="logo-link">
                <img src="/images/logo.png" alt="Mau House Logo" style="width:32px;height:32px;object-fit:contain;">
                <div>
                    <div class="logo-title">MAU HOUSE 44</div>
                    <div class="logo-sub">Admin Panel</div>
                </div>
            </a>
        </div>

        <nav>
            <div class="nav-section-label">Principale</div>
            <a href="{{ route('admin.dashboard') }}"
               class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                </svg>
                Dashboard
            </a>

            <div class="nav-section-label">Gestione</div>
            <a href="{{ route('admin.leads') }}"
               class="admin-nav-link {{ request()->routeIs('admin.leads*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                </svg>
                Prenotazioni
            </a>

            <a href="{{ route('admin.photos') }}"
               class="admin-nav-link {{ request()->routeIs('admin.photos*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <polyline points="21 15 16 10 5 21"/>
                </svg>
                Galleria
            </a>

            @php
                try {
                    $pendingReviewsCount = \App\Models\Review::whereNotNull('email_verified_at')->where('is_approved', false)->count();
                } catch (\Throwable $e) {
                    $pendingReviewsCount = 0;
                }
            @endphp
            <a href="{{ route('admin.reviews.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                Recensioni
                @if($pendingReviewsCount > 0)
                    <span style="margin-left:auto;background:#EF4444;color:#fff;font-size:0.62rem;font-weight:700;padding:0.1rem 0.4rem;border-radius:999px;min-width:18px;text-align:center;">{{ $pendingReviewsCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.visitors') }}"
               class="admin-nav-link {{ request()->routeIs('admin.visitors*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                Visitatori
            </a>

            <a href="{{ route('admin.users') }}"
               class="admin-nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Utenti
            </a>

            <a href="{{ route('admin.calendar') }}"
               class="admin-nav-link {{ request()->routeIs('admin.calendar*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Calendario
            </a>

            <a href="{{ route('admin.email.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.email*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                Email
            </a>

            <div class="nav-section-label">Sistema</div>
            <a href="{{ url('/') }}" target="_blank" class="admin-nav-link">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Vedi Sito
            </a>

            <a href="{{ route('admin.password.change') }}"
               class="admin-nav-link {{ request()->routeIs('admin.password.*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                Password
            </a>
        </nav>

        <div class="sidebar-user">
            <div class="sidebar-user-info">
                <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                <div style="overflow:hidden;">
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-email">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Disconnetti
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="admin-main">
        <!-- Top bar -->
        <div class="admin-topbar">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <button class="topbar-menu-btn" onclick="toggleSidebar()" aria-label="Menu">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#A8D4AB" stroke-width="2">
                        <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <div>
                    <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                    <div class="topbar-breadcrumb">Mau House 44 &rsaquo; @yield('page-title', 'Dashboard')</div>
                </div>
            </div>
            <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        </div>

        <!-- Content -->
        <div class="admin-content">
            @yield('content')
        </div>
    </div>

</div>

<!-- Flash messages -->
@if(session('success'))
<div class="flash-message flash-success" id="flash-msg">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="20 6 9 17 4 12"/>
    </svg>
    {{ session('success') }}
</div>
@endif
@if(session('error') || $errors->has('error'))
<div class="flash-message flash-error" id="flash-msg">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>
    {{ session('error') ?? $errors->first('error') }}
</div>
@endif

<script>
    // Sidebar toggle (mobile)
    function toggleSidebar() {
        document.querySelector('.admin-sidebar').classList.toggle('open');
        document.getElementById('sidebar-overlay').classList.toggle('open');
        document.body.style.overflow = document.querySelector('.admin-sidebar').classList.contains('open') ? 'hidden' : '';
    }
    function closeSidebar() {
        document.querySelector('.admin-sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').classList.remove('open');
        document.body.style.overflow = '';
    }
    // Close sidebar on nav link click (mobile)
    document.querySelectorAll('.admin-nav-link').forEach(link => {
        link.addEventListener('click', () => { if (window.innerWidth <= 768) closeSidebar(); });
    });

    // Auto-dismiss flash messages
    const flash = document.getElementById('flash-msg');
    if (flash) {
        setTimeout(() => {
            flash.style.transition = 'opacity 0.5s';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 500);
        }, 4000);
    }
</script>

@stack('scripts')
</body>
</html>
