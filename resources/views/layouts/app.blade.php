<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) - TaskFlow</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>T</text></svg>" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --header-height: 64px;
            --radius: 0.375rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --shadow: 0 2px 6px -2px rgba(0,0,0,.08), 0 4px 12px -4px rgba(0,0,0,.1);
            --shadow-sm: 0 1px 2px rgba(0,0,0,.04);
            --shadow-lg: 0 8px 16px -4px rgba(0,0,0,.1), 0 4px 6px -2px rgba(0,0,0,.06);
            --sidebar-bg: #2f3349;
            --sidebar-text: rgba(255,255,255,.87);
            --sidebar-text-muted: rgba(255,255,255,.6);
            --sidebar-hover: rgba(255,255,255,.08);
            --sidebar-active: rgba(115,103,240,.16);
            --primary: #696cff;
            --body-bg: #f5f5f9;
            --border-color: #d9dee3;
            --border-light: rgba(0,0,0,.06);
            --text-body: #566a7f;
            --text-muted: #697a8d;
            --input-bg: #fff;
        }
        html { overflow-x: hidden; }
        body { min-height: 100vh; background: var(--body-bg); font-family: 'Public Sans', 'DM Sans', system-ui, sans-serif; color: var(--text-body); font-size: 0.9375rem; overflow-x: hidden; line-height: 1.5; }
        .app-sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            max-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed; left: 0; top: 0; z-index: 1020;
            overflow: hidden;
            transition: transform .25s ease, width .25s ease;
            box-shadow: 2px 0 12px rgba(0,0,0,.08);
            display: flex;
            flex-direction: column;
        }
        .app-sidebar .sidebar-brand {
            height: var(--header-height);
            padding: 0 1.5rem;
            display: flex; align-items: center; gap: .5rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .app-sidebar .sidebar-brand .brand-icon {
            width: 32px; height: 32px; background: var(--primary);
            border-radius: var(--radius); display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.25rem;
        }
        .app-sidebar .sidebar-brand .brand-text { color: #fff; font-weight: 600; font-size: 1.25rem; letter-spacing: -.02em; }
        .app-sidebar .sidebar-nav { flex: 1; min-height: 0; display: flex; flex-direction: column; padding: .5rem 0; }
        .app-sidebar .sidebar-nav > ul { display: flex; flex-direction: column; flex: 1; min-height: 0; }
        .app-sidebar .nav { padding: .5rem 0; }
        .app-sidebar .sidebar-nav > ul > li { padding: 0; margin: 0; }
        .app-sidebar .nav-link {
            color: var(--sidebar-text-muted);
            padding: .625rem 1.5rem;
            border-radius: 0;
            margin: 0 .5rem;
            font-size: .9375rem;
            display: flex; align-items: center;
            transition: color .2s, background .2s;
        }
        .app-sidebar .nav-link i { font-size: 1.25rem; margin-right: .75rem; opacity: .9; width: 1.5rem; text-align: center; }
        .app-sidebar .nav-link .nav-label { white-space: nowrap; }
        .app-sidebar .nav-link:hover { color: var(--sidebar-text); background: var(--sidebar-hover); }
        .app-sidebar .nav-link.active { color: #fff; background: var(--sidebar-active); }
        .app-sidebar .nav-section-setup { padding: 0; list-style: none; }
        /* Align Setup with Dashboard/Issues/Kanban/Workflow: same padding and margin as .nav-link */
        .app-sidebar .nav-section-toggle {
            display: flex; align-items: center; justify-content: space-between;
            width: 100%;
            padding: .625rem 1.5rem !important;
            margin: 0 .5rem !important;
            color: var(--sidebar-text-muted);
            text-decoration: none;
            background: transparent !important;
            border: none !important;
            cursor: pointer;
            font-size: .9375rem;
            font-weight: 400;
            letter-spacing: 0;
            text-transform: none;
            border-radius: 0;
            transition: color .2s, background .2s;
            box-sizing: border-box;
        }
        .app-sidebar .nav-section-toggle:hover {
            color: var(--sidebar-text);
            background: var(--sidebar-hover);
        }
        .app-sidebar .nav-section-toggle .nav-label { white-space: nowrap; }
        .app-sidebar .nav-section-toggle > span:first-child {
            display: inline-flex; align-items: center; flex-shrink: 0;
            padding: 0 !important; margin: 0 !important;
        }
        .app-sidebar .nav-section-toggle > span:first-child i { font-size: 1.25rem; margin-right: .75rem; opacity: .9; width: 1.5rem; min-width: 1.5rem; text-align: center; flex-shrink: 0; }
        .app-sidebar .setup-toggle-icon { font-size: .75rem; transition: transform .2s ease; flex-shrink: 0; margin-left: auto; }
        .app-sidebar .nav-section-toggle[aria-expanded="false"] .setup-toggle-icon { transform: rotate(-90deg); }
        .app-sidebar .setup-nav-item { list-style: none; flex: 1; min-height: 0; display: flex; flex-direction: column; overflow: hidden; max-height: 100%; }
        .app-sidebar .setup-nav-item .setup-nav-collapse.collapse.show { display: flex !important; flex: 1; min-height: 0; flex-direction: column; overflow: hidden; max-height: 100%; }
        .app-sidebar .setup-nav-scroll {
            flex: 1; min-height: 0; overflow-y: auto; overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            background: rgba(0,0,0,.08);
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.45) rgba(255,255,255,.08);
        }
        .app-sidebar .setup-nav-scroll .nav { padding: .25rem 0 .75rem; }
        .app-sidebar .setup-nav-scroll .nav-link {
            padding: .5rem 1.5rem .5rem 2.25rem;
            font-size: .875rem;
            border-left: 2px solid transparent;
        }
        .app-sidebar .setup-nav-scroll .nav-link:hover { border-left-color: rgba(255,255,255,.2); }
        .app-sidebar .setup-nav-scroll .nav-link.active { border-left-color: var(--primary); }
        .app-sidebar .setup-nav-scroll .nav-link i { font-size: 1.125rem; margin-right: .625rem; width: 1.25rem; }
        .app-sidebar .setup-nav-scroll .nav-section-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: .09em;
            color: rgba(255,255,255,.55);
            padding: .75rem 1.5rem .25rem 2.25rem;
            font-weight: 600;
        }
        .app-sidebar .setup-nav-scroll::-webkit-scrollbar { width: 6px; }
        .app-sidebar .setup-nav-scroll::-webkit-scrollbar-track { background: rgba(255,255,255,.08); border-radius: 3px; }
        .app-sidebar .setup-nav-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.45); border-radius: 3px; }
        .app-sidebar .setup-nav-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,.6); }
        .app-sidebar .nav-section {
            font-size: .6875rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--sidebar-text-muted);
            padding: 1rem 1.5rem .5rem;
            font-weight: 600;
        }
        .app-main {
            margin-left: var(--sidebar-width);
            height: 100vh;
            max-width: calc(100vw - var(--sidebar-width));
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
            padding-top: calc(var(--header-height) + 1rem);
            transition: margin .25s ease;
            overflow: hidden;
        }
        .app-header {
            height: var(--header-height);
            background: #fff;
            border-bottom: 1px solid rgba(0,0,0,.06);
            position: fixed; left: var(--sidebar-width); right: 0; top: 0; z-index: 1015;
            box-shadow: 0 1px 2px rgba(0,0,0,.04);
            display: flex; align-items: center; padding: 0 1.5rem;
        }
        .app-header .header-search { max-width: 280px; }
        .app-header .header-search .form-control {
            border: 1px solid var(--border-color); border-radius: var(--radius-lg);
            padding: 0.5rem 1rem 0.5rem 2.5rem; font-size: 0.875rem; background: var(--body-bg);
        }
        .app-header .header-search .search-icon { left: .875rem; color: #a1acb8; }
        .app-header .navbar-user {
            display: flex; align-items: center; gap: .75rem; padding: .5rem .75rem;
            border-radius: var(--radius-lg); margin-left: auto;
        }
        .app-header .navbar-user .avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(135deg, #696cff 0%, #8592ff 100%);
            color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: .875rem;
        }
        .app-header .navbar-user .user-name { font-weight: 500; color: #566a7f; font-size: .9375rem; }
        /* Unified scrollable - Sneat-style thin scrollbar */
        .scrollable, .app-main-inner { scrollbar-width: thin; scrollbar-color: rgba(0,0,0,.22) transparent; -webkit-overflow-scrolling: touch; }
        .scrollable::-webkit-scrollbar, .app-main-inner::-webkit-scrollbar { width: 6px; height: 6px; }
        .scrollable::-webkit-scrollbar-track, .app-main-inner::-webkit-scrollbar-track { background: transparent; border-radius: 3px; }
        .scrollable::-webkit-scrollbar-thumb, .app-main-inner::-webkit-scrollbar-thumb { background: rgba(0,0,0,.22); border-radius: 3px; }
        .scrollable::-webkit-scrollbar-thumb:hover, .app-main-inner::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,.35); }
        .app-main-inner { flex: 1; min-height: 0; overflow-y: auto; overflow-x: auto; display: flex; flex-direction: column; padding-bottom: 1rem; transition: opacity 0.2s ease-out; }
        #app-main-content.app-main-content-fade-out { opacity: 0.35; pointer-events: none; }
        .card {
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow);
            border-radius: var(--radius-lg);
            background: #fff;
            overflow: hidden;
        }
        .card-body { padding: 1.25rem 1.5rem; }
        .card-header { background: #fff; border-bottom: 1px solid var(--border-light); padding: 1rem 1.5rem; font-weight: 600; font-size: 1rem; color: var(--text-body); }
        .card-footer { background: #fafbfc; border-top: 1px solid var(--border-light); padding: 1rem 1.5rem; }
        /* Dashboard: maximize space, compact layout, scrollable preserved */
        .dashboard-page { display: flex; flex-direction: column; gap: 1rem; padding-bottom: 0.5rem; }
        .dashboard-page-header { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.5rem; margin-bottom: 0; }
        .dashboard-page-title { font-size: 1.2rem; font-weight: 600; letter-spacing: -.01em; }
        .dashboard-page-subtitle { font-size: 0.8125rem; color: #697a8d; }
        .dashboard-card { border: 1px solid rgba(0,0,0,.06); border-radius: 8px; box-shadow: none; background: #fff; }
        .dashboard-card .card-header { background: #fff; border-bottom: 1px solid rgba(0,0,0,.06); padding: 0.75rem 1rem; font-weight: 600; font-size: 0.9375rem; border-radius: 8px 8px 0 0; }
        .dashboard-card .card-header span.subtitle { font-weight: 400; font-size: 0.75rem; color: #a1acb8; margin-left: 0.35rem; }
        .dashboard-card .card-body { padding: 1rem; }
        .dashboard-kpi { border-radius: 8px; box-shadow: none; border: 1px solid rgba(0,0,0,.06); background: #fff; }
        .dashboard-kpi .card-body { padding: 0.65rem 0.9rem; }
        .dashboard-kpi .kpi-icon { width: 38px; height: 38px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
        .dashboard-kpi .text-uppercase.tracking { letter-spacing: 0.04em; font-size: 0.7rem; }
        .dashboard-kpi .kpi-secondary { font-size: 0.75rem; color: #a1acb8; margin-top: 0.1rem; }
        .dashboard-overview {
            background: linear-gradient(135deg, #eef2ff 0%, #e0f2fe 55%, #fef3c7 100%);
            color: #111827;
            border: 0;
            border-radius: 8px;
            box-shadow: none;
        }
        .dashboard-overview .card-body { padding: 0.9rem 1.15rem 0.95rem; }
        .dashboard-overview .overview-title { font-weight: 600; font-size: 0.9rem; margin-bottom: 0.4rem; color: #111827; }
        .dashboard-overview .overview-stats { display: flex; flex-wrap: wrap; gap: 0.75rem 1.5rem; align-items: center; margin-bottom: 0.55rem; }
        .dashboard-overview .overview-stat { font-size: 1.25rem; font-weight: 700; color: #111827; }
        .dashboard-overview .overview-stat-label { font-size: 0.75rem; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.04em; color: #374151; }
        .dashboard-overview .btn-overview {
            background: #fff;
            color: #4f46e5;
            border: 1px solid rgba(79,70,229,.35);
            font-weight: 500;
            border-radius: 999px;
            padding: 0.3rem 0.9rem;
            font-size: 0.8rem;
            box-shadow: 0 1px 2px rgba(15,23,42,.12);
        }
        .dashboard-overview .btn-overview:hover { background: #eef2ff; color: #3730a3; border-color: rgba(79,70,229,.6); }
        .dashboard-overview .overview-meta { font-size: 0.75rem; opacity: 0.9; margin-bottom: 0; color: #4b5563; }
        .dashboard-overview .overview-meta span + span::before { content: "·"; padding: 0 0.35rem; opacity: 0.65; }
        .dashboard-chart-container { position: relative; height: 240px; }
        .dashboard-donut-container { position: relative; height: 200px; }
        .dashboard-activity-tile { padding: 0.5rem 0.75rem; }
        /* Tables - unified Sneat / enterprise */
        .table { color: var(--text-body); font-size: 0.9375rem; border-collapse: separate; border-spacing: 0; }
        .table thead th {
            position: sticky;
            top: 0;
            z-index: 5;
            font-weight: 600; color: var(--text-muted); font-size: 0.6875rem; text-transform: uppercase; letter-spacing: .08em;
            padding: 0.875rem 1.25rem; background: #fafbfc; border-bottom: 1px solid var(--border-light);
        }
        .table tbody td { vertical-align: middle; padding: 0.875rem 1.25rem; border-bottom: 1px solid var(--border-light); }
        .table tbody tr:nth-of-type(even) { background-color: #fcfcfe; }
        .table tbody tr:hover { background: #f4f5fb; }
        .table tbody tr:last-child td { border-bottom: 0; }
        .table .table-light th { background: #fafbfc; color: var(--text-muted); }
        .table tbody td:last-child:has(.btn) { white-space: nowrap; text-align: right; }
        .table tbody td:last-child .btn, .table tbody td:last-child .btn-sm { display: inline-block; margin-left: 0.35rem; vertical-align: middle; }
        .table tbody td:last-child .btn:first-child, .table tbody td:last-child .btn-sm:first-child { margin-left: 0; }
        /* Buttons - unified enterprise */
        .btn {
            font-weight: 500;
            letter-spacing: 0.01em;
            border-radius: var(--radius);
            padding: 0.5rem 1rem;
            font-size: 0.9375rem;
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            cursor: pointer;
            transition: background .2s ease, border-color .2s ease, color .2s ease, box-shadow .2s ease, transform .1s ease;
        }
        .btn:focus-visible { outline: none; box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--primary); }
        .btn:active:not(:disabled) { transform: translateY(1px); }
        .btn:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }
        .btn-sm { border-radius: var(--radius); padding: 0.375rem 0.75rem; font-size: 0.8125rem; min-height: 32px; }
        .btn-lg { border-radius: var(--radius-lg); padding: 0.625rem 1.25rem; font-size: 1rem; min-height: 44px; }
        .btn-primary {
            background: var(--primary);
            border: 1px solid #5f61e6;
            color: #fff;
            box-shadow: 0 1px 3px rgba(105,108,255,.25);
        }
        .btn-primary:hover:not(:disabled) { background: #5f61e6; border-color: #5558d8; color: #fff; box-shadow: 0 4px 12px rgba(105,108,255,.3); }
        .btn-primary:focus-visible { box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--primary); }
        .btn-secondary {
            background: #6c757d;
            border: 1px solid #5c636a;
            color: #fff;
            box-shadow: 0 1px 2px rgba(0,0,0,.06);
        }
        .btn-secondary:hover:not(:disabled) { background: #5c636a; border-color: #565e64; color: #fff; box-shadow: 0 2px 6px rgba(0,0,0,.12); }
        .btn-outline-primary { color: var(--primary); border: 1px solid var(--primary); background: transparent; }
        .btn-outline-primary:hover:not(:disabled) { background: rgba(105,108,255,.1); color: #5f61e6; border-color: #5f61e6; }
        .btn-outline-primary:focus-visible { box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--primary); }
        .btn-outline-secondary { color: var(--text-body); border: 1px solid var(--border-color); background: #fff; }
        .btn-outline-secondary:hover:not(:disabled) { background: #f8f9fa; border-color: #b4bdc6; color: var(--text-body); }
        .btn-outline-secondary:focus-visible { box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgba(108,117,125,.4); }
        .btn-outline-danger { color: #dc3545; border: 1px solid #dc3545; background: transparent; }
        .btn-outline-danger:hover:not(:disabled) { background: rgba(220,53,69,.1); color: #b02a37; border-color: #b02a37; }
        .btn-outline-danger:focus-visible { box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgba(220,53,69,.4); }
        .btn-light { background: #f5f5f9; border: 1px solid #e7e7ed; color: var(--text-body); }
        .btn-light:hover:not(:disabled) { background: #eef0f4; border-color: var(--border-color); color: var(--text-body); }
        .btn-link { box-shadow: none; min-height: auto; }
        .btn-link:hover:not(:disabled) { text-decoration: underline; }
        .btn-link:focus-visible { box-shadow: 0 0 0 2px rgba(105,108,255,.35); }
        .btn-danger { background: #dc3545; border: 1px solid #c82333; color: #fff; }
        .btn-danger:hover:not(:disabled) { background: #c82333; border-color: #bd2130; color: #fff; box-shadow: 0 2px 6px rgba(220,53,69,.25); }
        /* Badges - Sneat style (status pills) */
        .badge { font-weight: 500; padding: .35em .65em; border-radius: var(--radius); font-size: .75rem; }
        .badge.bg-success { background: rgba(105,208,27,.16) !important; color: #71dd37; }
        .badge.bg-info { background: rgba(3,195,236,.16) !important; color: #03c3ec; }
        .badge.bg-warning { background: rgba(255,171,0,.16) !important; color: #ffab00; }
        .badge.bg-danger { background: rgba(255,62,29,.16) !important; color: #ff3e1d; }
        .badge.bg-primary { background: rgba(105,108,255,.16) !important; color: var(--primary); }
        .badge.bg-secondary { background: rgba(105,108,255,.12) !important; color: #697a8d; }
        /* Forms - unified inputs */
        .form-label { font-weight: 500; color: var(--text-body); font-size: 0.875rem; margin-bottom: 0.375rem; }
        .form-control, .form-select {
            border-radius: var(--radius); border: 1px solid var(--border-color);
            padding: 0.5rem 0.875rem; font-size: 0.9375rem; min-height: 38px;
            background: var(--input-bg); color: var(--text-body);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary); box-shadow: 0 0 0 0.2rem rgba(105,108,255,.2);
        }
        .form-control::placeholder { color: #a1acb8; }
        .form-check-input,
        input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            margin-top: 0.15rem;
            vertical-align: middle;
            border-radius: 0.25rem;
            border: 1px solid var(--border-color);
            background-color: #fff;
            cursor: pointer;
        }
        .form-check-input:focus,
        input[type="checkbox"]:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.16rem rgba(105,108,255,.25);
        }
        .form-check-input:checked,
        input[type="checkbox"]:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .input-group-text { border-radius: var(--radius); border: 1px solid var(--border-color); background: #fafbfc; color: var(--text-muted); padding: 0.5rem 0.875rem; }
        .input-group .form-control { border-left: 0; }
        .input-group .input-group-text + .form-control { border-left: 1px solid var(--border-color); }
        .form-text, .invalid-feedback { font-size: 0.8125rem; }
        .mb-3 > .form-control, .mb-3 > .form-select { margin-top: 0.125rem; }
        .page-title { font-size: 1.5rem; font-weight: 600; color: var(--text-body); }
        /* Kanban: maximize space, flexible columns, single scroll area */
        .kanban-page-layout { display: flex; flex-direction: column; flex: 1; min-height: 0; }
        .kanban-page-layout #kanban-board-container { display: flex; flex-direction: column; flex: 1; min-height: 0; }
        .kanban-board-wrapper {
            flex: 1 1 0;
            min-height: 0;
            overflow: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: rgba(0,0,0,.25) transparent;
        }
        .kanban-board-wrapper::-webkit-scrollbar { width: 8px; height: 8px; }
        .kanban-board-wrapper::-webkit-scrollbar-track { background: rgba(0,0,0,.04); border-radius: 4px; }
        .kanban-board-wrapper::-webkit-scrollbar-thumb { background: rgba(0,0,0,.25); border-radius: 4px; }
        .kanban-board-wrapper::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,.4); }
        .kanban-board { gap: 0.75rem; display: flex; align-items: stretch; padding: 0.5rem 0 1rem; width: 100%; min-width: min-content; }
        .kanban-column {
            flex: 1 1 260px;
            min-width: 260px;
            max-width: 320px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }
        .kanban-column .kanban-column-header {
            padding: 0.625rem 0.875rem;
            font-weight: 600;
            font-size: 0.875rem;
            color: #566a7f;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            border: 1px solid rgba(0,0,0,.06);
            border-bottom: 0;
            flex-shrink: 0;
        }
        .kanban-column .kanban-dropszone {
            padding: 0.5rem 0.625rem;
            background: #f8f9fa;
            flex: 1;
            min-height: 120px;
            border: 1px solid rgba(0,0,0,.06);
            border-top: 0;
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        }
        .kanban-card {
            background: #fff;
            border: none;
            border-radius: var(--radius);
            box-shadow: 0 1px 2px rgba(0,0,0,.06);
            padding: 0.625rem 0.75rem;
            transition: box-shadow .15s;
        }
        .kanban-card:hover { box-shadow: 0 3px 10px -2px rgba(0,0,0,.1); }
        .kanban-card.kanban-card-dragging {
            box-shadow: 0 6px 18px rgba(15,23,42,.25);
            transform: translateY(-2px);
            opacity: .9;
        }
        .kanban-dropszone.kanban-drop-allowed {
            outline: 2px dashed rgba(105,108,255,.6);
            outline-offset: 0;
        }
        .kanban-dropszone.kanban-drop-blocked {
            opacity: 0.4;
        }
        .kanban-card .card-body { padding: 0; }
        .kanban-add-item { border: 1px dashed #d9dee3; border-radius: var(--radius); color: #697a8d; padding: 0.4rem 0.75rem; font-size: 0.8125rem; background: transparent; }
        .kanban-add-item:hover { background: rgba(105,108,255,.06); border-color: var(--primary); color: var(--primary); }
        .kanban-card { cursor: grab; }
        .kanban-card:active { cursor: grabbing; }
        .list-group-item { border-radius: var(--radius); border-color: var(--border-light); padding: 0.75rem 1rem; }
        .list-group-item-action:hover { background: #fafbfc; }
        .list-group-item-action.active { background: var(--primary); border-color: var(--primary); }
        .table-responsive { border-radius: 0; overflow-x: auto; overflow-y: visible; max-width: 100%; scrollbar-width: thin; scrollbar-color: rgba(0,0,0,.22) transparent; }
        .table-responsive::-webkit-scrollbar { width: 6px; height: 6px; }
        .table-responsive::-webkit-scrollbar-track { background: transparent; border-radius: 3px; }
        .table-responsive::-webkit-scrollbar-thumb { background: rgba(0,0,0,.22); border-radius: 3px; }
        .table-responsive::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,.35); }
        .card .table-responsive { margin: 0; }
        .card .table { margin-bottom: 0; }
        .card .table thead th:first-child { border-top-left-radius: 0; }
        .card .table thead th:last-child { border-top-right-radius: 0; }
        .app-main-inner > * { min-width: 0; }
        .app-main-loading { transition: opacity .2s ease; }
        .pagination { gap: 0.25rem; }
        .pagination .page-link { border-radius: var(--radius) !important; border: 1px solid var(--border-color); color: var(--text-body); padding: 0.375rem 0.75rem; }
        .pagination .page-item.active .page-link { background: var(--primary); border-color: var(--primary); color: #fff; }
        .dropdown-menu { border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); border: 1px solid var(--border-light); }
        .dropdown-item { border-radius: var(--radius); padding: 0.5rem 1rem; font-size: 0.9375rem; }
        #toast-container { position: fixed; top: calc(var(--header-height) + 16px); right: 16px; z-index: 9999; }
        .toast-custom { min-width: 300px; box-shadow: var(--shadow-lg); border-radius: var(--radius-lg); }
        #crudModal .modal-dialog { max-width: 560px; }
        #crudModal .modal-content { border: none; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); }
        #crudModal .modal-header { border-bottom: 1px solid var(--border-light); padding: 1rem 1.5rem; }
        #crudModal .modal-body { padding: 1.25rem 1.5rem; max-height: 70vh; overflow-y: auto; }
        #crudModal .modal-body.scrollable { scrollbar-width: thin; }
        #crudModal .modal-footer { border-top: 1px solid var(--border-light); padding: 1rem 1.5rem; }
        /* Setup detail (show) pages */
        .setup-detail-page .setup-detail-header { margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.75rem; }
        .setup-detail-page .setup-detail-header .btn-group .btn { border-radius: var(--radius); }
        .setup-detail-page .setup-detail-card { border: 1px solid var(--border-light); box-shadow: var(--shadow); border-radius: var(--radius-lg); overflow: hidden; }
        .setup-detail-page .setup-detail-card .card-header {
            background: #fff; border-bottom: 1px solid var(--border-light);
            padding: 1rem 1.5rem; font-weight: 600; font-size: 1rem; color: var(--text-body);
        }
        .setup-detail-page .setup-detail-card .card-body { padding: 1.25rem 1.5rem; }
        .setup-detail-page .setup-detail-card .card-body dl.row { margin: 0; }
        .setup-detail-page .setup-detail-card .card-body dl.row dt.col-sm-3 {
            font-weight: 500; color: var(--text-muted); font-size: 0.8125rem; text-transform: uppercase; letter-spacing: .04em;
            padding: 0.75rem 0; padding-right: 1rem; border-bottom: 1px solid var(--border-light);
        }
        .setup-detail-page .setup-detail-card .card-body dl.row dd.col-sm-9 {
            padding: 0.75rem 0; border-bottom: 1px solid var(--border-light); color: var(--text-body); font-size: 0.9375rem;
        }
        .setup-detail-page .setup-detail-card .card-body dl.row > dt:last-of-type,
        .setup-detail-page .setup-detail-card .card-body dl.row > dd:last-of-type { border-bottom: 0; }
        .setup-detail-section { margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid rgba(0,0,0,.06); }
        .setup-detail-section .section-title { font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 0.75rem; }
        .setup-detail-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.375rem; }
        .setup-detail-list li { padding: 0.5rem 0.75rem; background: #fafbfc; border-radius: var(--radius); border: 1px solid var(--border-light); font-size: 0.9375rem; }
        .setup-detail-list li a { color: var(--primary); text-decoration: none; font-weight: 500; }
        .setup-detail-list li a:hover { text-decoration: underline; }
        .setup-detail-list li.empty { background: transparent; color: #a1acb8; border-style: dashed; }
        .setup-list-card .card-header { font-size: 1rem; font-weight: 600; color: var(--text-body); }
        .setup-list-card .card { border: 1px solid var(--border-light); }
        /* Setup tables: scrollable body with max height */
        .setup-list-card .card-body {
            max-height: calc(100vh - 220px);
            overflow-y: auto;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: rgba(0,0,0,.22) transparent;
        }
        .setup-list-card .card-body::-webkit-scrollbar { width: 8px; height: 8px; }
        .setup-list-card .card-body::-webkit-scrollbar-track { background: rgba(0,0,0,.04); border-radius: 4px; }
        .setup-list-card .card-body::-webkit-scrollbar-thumb { background: rgba(0,0,0,.22); border-radius: 4px; }
        .setup-list-card .card-body::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,.35); }
        /* Inline table filters */
        .setup-filter-form {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            align-items: center;
            gap: 0.5rem 1rem;
            padding: 0.625rem 1.25rem;
            margin-bottom: 0;
            background: linear-gradient(to bottom, #f8f9fa 0%, #fafbfc 100%);
            border-bottom: 1px solid var(--border-light);
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            flex-shrink: 0;
        }
        .setup-filter-form-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--text-muted);
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .setup-filter-form-label i { opacity: 0.85; }
        .setup-filter-form .form-select {
            min-width: 200px;
            background-position: right 0.5rem center;
            font-size: 0.875rem;
        }
        .setup-filter-form .btn-reset-filter {
            padding: 0.25rem 0.6rem;
            font-size: 0.8125rem;
        }
        /* Sidebar toggle button (header) */
        .app-header [data-sidebar-toggle] {
            border-radius: 999px;
            padding: 0.25rem 0.55rem;
        }
        .app-header [data-sidebar-toggle]:hover {
            background-color: #f0f2f6;
        }
        body.sidebar-collapsed .app-header [data-sidebar-toggle] {
            background-color: #eef0ff;
        }
        /* Sidebar collapsed (icon-only) - explicit 72px, center icons */
        body.sidebar-collapsed { --sidebar-width: 72px; }
        body.sidebar-collapsed .app-sidebar { width: 72px; overflow-x: hidden; overflow-y: auto; padding: 0; }
        body.sidebar-collapsed .app-sidebar .sidebar-nav > ul { padding-left: 0; padding-right: 0; margin: 0; list-style: none; }
        body.sidebar-collapsed .app-sidebar .nav-item { width: 100%; margin: 0; padding: 0; }
        body.sidebar-collapsed .app-sidebar .sidebar-brand {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        body.sidebar-collapsed .app-sidebar .brand-text { display: none; }
        body.sidebar-collapsed .app-sidebar .nav-section { display: none; }
        body.sidebar-collapsed .app-sidebar .nav-item { flex-shrink: 0; }
        body.sidebar-collapsed .app-sidebar .nav-link {
            justify-content: center;
            align-items: center;
            padding: .625rem 0;
            min-height: 2.5rem;
            box-sizing: border-box;
            display: flex;
            text-align: center;
            margin: 0;
            width: 100%;
            border-radius: 0;
        }
        body.sidebar-collapsed .app-sidebar .nav-link i {
            margin: 0 !important;
            margin-inline-start: 0 !important;
            margin-inline-end: 0 !important;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        body.sidebar-collapsed .app-sidebar .nav-link .nav-label { display: none !important; }
        /* Setup row stays visible when collapsed; hide all setup sub-items */
        body.sidebar-collapsed .app-sidebar .nav-section-setup { display: list-item; flex-shrink: 0; width: 100%; margin: 0; padding: 0; list-style: none; }
        body.sidebar-collapsed .app-sidebar .nav-section-toggle {
            justify-content: center !important;
            align-items: center !important;
            padding: .625rem 0 !important;
            min-height: 2.5rem;
            box-sizing: border-box;
            display: flex !important;
            text-align: center;
            margin: 0 !important;
            width: 100%;
            border-radius: 0;
            border: 0 !important;
            background: transparent !important;
        }
        body.sidebar-collapsed .app-sidebar .nav-section-toggle .nav-label { display: none !important; }
        body.sidebar-collapsed .app-sidebar .nav-section-toggle .setup-toggle-icon { display: none !important; }
        body.sidebar-collapsed .app-sidebar .nav-section-toggle > span:first-child {
            margin: 0 !important;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        body.sidebar-collapsed .app-sidebar .nav-section-toggle > span:first-child i {
            margin: 0 !important;
            margin-inline-start: 0 !important;
            margin-inline-end: 0 !important;
            flex-shrink: 0;
        }
        body.sidebar-collapsed .app-sidebar .nav-section-toggle > span:first-child .nav-label { display: none !important; }
        body.sidebar-collapsed .app-sidebar .setup-nav-item .setup-nav-collapse,
        body.sidebar-collapsed .app-sidebar .setup-nav-item .setup-nav-scroll { display: none !important; visibility: hidden; height: 0; overflow: hidden; min-height: 0; }
        body.sidebar-collapsed .app-main { margin-left: 72px; max-width: calc(100vw - 72px); width: calc(100vw - 72px); }
        body.sidebar-collapsed .app-header { left: 72px; right: 0; width: calc(100vw - 72px); }
        .app-main-inner { width: 100%; max-width: 100%; }
        body:not(.layout-sidebar) .app-header { left: 0; }
        body:not(.layout-sidebar) .app-main { margin-left: 0; max-width: 100vw; }
        @media (max-width: 991.98px) {
            .app-header { left: 0 !important; }
            .app-main { margin-left: 0 !important; max-width: 100vw !important; padding-top: calc(var(--header-height) + 1rem); }
        }
    </style>
    @stack('styles')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>
<body class="{{ auth()->check() ? 'layout-sidebar' : '' }}">
    @auth
    <aside class="app-sidebar collapse collapse-horizontal collapse-lg show" id="sidebarCollapse">
        <a href="{{ route('dashboard') }}" class="sidebar-brand text-decoration-none">
            <span class="brand-icon d-flex align-items-center justify-content-center"><i class="bi bi-kanban"></i></span>
            <span class="brand-text">TaskFlow</span>
        </a>
        <nav class="py-2 sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('issues.*') ? 'active' : '' }}" href="{{ route('issues.index') }}">
                        <i class="bi bi-ticket-perforated me-2"></i>
                        <span class="nav-label">Issues</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kanban*') ? 'active' : '' }}" href="{{ route('kanban.index') }}">
                        <i class="bi bi-kanban me-2"></i>
                        <span class="nav-label">Kanban Board</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('workflows.diagram*') ? 'active' : '' }}" href="{{ route('workflows.diagram.index') }}">
                        <i class="bi bi-diagram-3 me-2"></i>
                        <span class="nav-label">Workflow Diagram</span>
                    </a>
                </li>
                <li class="nav-section nav-section-setup">
                    <button class="nav-section-toggle btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#setupNav" aria-expanded="true" aria-controls="setupNav">
                        <span class="d-inline-flex align-items-center">
                            <i class="bi bi-sliders me-2"></i>
                            <span class="nav-label">Setup</span>
                        </span>
                        <i class="bi bi-chevron-down setup-toggle-icon"></i>
                    </button>
                </li>
                <li class="nav-item setup-nav-item">
                    <div class="collapse show setup-nav-collapse" id="setupNav">
                        <div class="setup-nav-scroll">
                            <ul class="nav flex-column">
                                {{-- Identity & access --}}
                                <li class="nav-section-label">Identity & access</li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('organizations.*') ? 'active' : '' }}" href="{{ route('organizations.index') }}">
                                        <i class="bi bi-building me-2"></i>
                                        <span class="nav-label">Organizations</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                        <i class="bi bi-people me-2"></i>
                                        <span class="nav-label">Users</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                                        <i class="bi bi-person-badge me-2"></i>
                                        <span class="nav-label">Roles</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}" href="{{ route('permissions.index') }}">
                                        <i class="bi bi-shield-lock me-2"></i>
                                        <span class="nav-label">Permissions</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('role-permissions.*') ? 'active' : '' }}" href="{{ route('role-permissions.index') }}">
                                        <i class="bi bi-link-45deg me-2"></i>
                                        <span class="nav-label">Role Permissions</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('user-roles.*') ? 'active' : '' }}" href="{{ route('user-roles.index') }}">
                                        <i class="bi bi-person-check me-2"></i>
                                        <span class="nav-label">User Roles</span>
                                    </a>
                                </li>

                                {{-- Projects & teams --}}
                                <li class="nav-section-label mt-2">Projects & teams</li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('teams.*') ? 'active' : '' }}" href="{{ route('teams.index') }}">
                                        <i class="bi bi-people-fill me-2"></i>
                                        <span class="nav-label">Teams</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('team-members.*') ? 'active' : '' }}" href="{{ route('team-members.index') }}">
                                        <i class="bi bi-person-plus me-2"></i>
                                        <span class="nav-label">Team Members</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}" href="{{ route('projects.index') }}">
                                        <i class="bi bi-folder me-2"></i>
                                        <span class="nav-label">Projects</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('project-members.*') ? 'active' : '' }}" href="{{ route('project-members.index') }}">
                                        <i class="bi bi-person-workspace me-2"></i>
                                        <span class="nav-label">Project Members</span>
                                    </a>
                                </li>

                                {{-- Issue configuration --}}
                                <li class="nav-section-label mt-2">Issue configuration</li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('issue-types.*') ? 'active' : '' }}" href="{{ route('issue-types.index') }}">
                                        <i class="bi bi-tag me-2"></i>
                                        <span class="nav-label">Issue Types</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('priorities.*') ? 'active' : '' }}" href="{{ route('priorities.index') }}">
                                        <i class="bi bi-arrow-up-circle me-2"></i>
                                        <span class="nav-label">Priorities</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('statuses.*') ? 'active' : '' }}" href="{{ route('statuses.index') }}">
                                        <i class="bi bi-circle-half me-2"></i>
                                        <span class="nav-label">Statuses</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('issue-labels.*') ? 'active' : '' }}" href="{{ route('issue-labels.index') }}">
                                        <i class="bi bi-bookmark me-2"></i>
                                        <span class="nav-label">Issue Labels</span>
                                    </a>
                                </li>

                                {{-- Workflow & delivery --}}
                                <li class="nav-section-label mt-2">Workflow & delivery</li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('workflows.index') || request()->routeIs('workflows.edit') ? 'active' : '' }}" href="{{ route('workflows.index') }}">
                                        <i class="bi bi-arrow-left-right me-2"></i>
                                        <span class="nav-label">Workflows</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('workflow-transitions.*') ? 'active' : '' }}" href="{{ route('workflow-transitions.index') }}">
                                        <i class="bi bi-arrow-right-circle me-2"></i>
                                        <span class="nav-label">Workflow Transitions</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('boards.*') ? 'active' : '' }}" href="{{ route('boards.index') }}">
                                        <i class="bi bi-grid-3x3 me-2"></i>
                                        <span class="nav-label">Boards</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('sprints.*') ? 'active' : '' }}" href="{{ route('sprints.index') }}">
                                        <i class="bi bi-lightning me-2"></i>
                                        <span class="nav-label">Sprints</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                                        <i class="bi bi-bell me-2"></i>
                                        <span class="nav-label">Notifications</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </aside>
    @endauth

    <header class="app-header">
        <button class="btn btn-link text-body d-lg-none me-2 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-label="Toggle sidebar">
            <i class="bi bi-list fs-4"></i>
        </button>
        <button class="btn btn-link text-body d-none d-lg-inline-flex me-2 p-0" type="button" data-sidebar-toggle aria-label="Toggle sidebar">
            <i class="bi bi-list fs-4" data-sidebar-toggle-icon></i>
        </button>
        <div class="header-search position-relative d-none d-md-flex">
            <i class="bi bi-search position-absolute search-icon top-50 translate-middle-y"></i>
            <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
        </div>
        <div class="navbar-user">
            @auth
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
                <div class="d-none d-sm-block">
                    <span class="user-name d-block">{{ auth()->user()->name ?? 'User' }}</span>
                    <small class="text-muted" style="font-size: .75rem;">Admin</small>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link text-body p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="min-width: 180px;">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </header>

    <main class="app-main position-relative" id="app-main">
        <div class="app-main-loading position-absolute top-0 start-0 end-0 bottom-0 d-flex align-items-center justify-content-center bg-white bg-opacity-90 d-none" id="app-main-loading" style="z-index: 15; border-radius: var(--radius-lg);">
            <div class="text-center">
                <div class="spinner-border text-primary mb-2" role="status" style="width: 2.5rem; height: 2.5rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="small text-muted">Loading...</div>
            </div>
        </div>
        <div class="app-main-inner position-relative" id="app-main-content">
            @yield('content')
        </div>
    </main>

    {{-- Global CRUD modal (for setup create/edit) --}}
    <div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crudModalLabel">—</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body scrollable" id="crudModalBody">
                    <div class="text-center py-4 text-muted"><span class="spinner-border spinner-border-sm me-2"></span>Loading...</div>
                </div>
                <div class="modal-footer d-none" id="crudModalFooter">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crudModalSubmit">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div id="toast-container" class="d-flex flex-column gap-2"></div>

    <script>
    window.TaskFlow = {
        csrf: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
        toast(type, message) {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const el = document.createElement('div');
            el.className = 'toast-custom alert alert-' + (type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info') + ' mb-0 show d-flex align-items-center';
            el.setAttribute('role', 'alert');
            el.innerHTML = '<i class="bi bi-' + (type === 'success' ? 'check-circle-fill' : type === 'error' ? 'exclamation-circle-fill' : 'info-circle-fill') + ' me-2"></i>' + (message || '');
            container.appendChild(el);
            setTimeout(function() { el.remove(); }, 4000);
        },
        crudModal: {
            modal: null,
            init() {
                this.modal = document.getElementById('crudModal');
                if (!this.modal) return;
                const self = this;
                document.getElementById('crudModalSubmit')?.addEventListener('click', function() {
                    const form = document.getElementById('crudModalBody').querySelector('form');
                    if (form) form.requestSubmit();
                });
                this.modal.addEventListener('hidden.bs.modal', function() {
                    var body = document.getElementById('crudModalBody');
                    var footer = document.getElementById('crudModalFooter');
                    var dialog = this.querySelector('.modal-dialog');
                    if (body) body.innerHTML = '';
                    if (footer && footer.classList) footer.classList.add('d-none');
                    if (dialog) dialog.classList.remove('modal-lg');
                });
            },
            open(options) {
                if (!options) return;
                var modalEl = document.getElementById('crudModal');
                var labelEl = document.getElementById('crudModalLabel');
                var bodyEl = document.getElementById('crudModalBody');
                var footerEl = document.getElementById('crudModalFooter');
                if (!modalEl || !bodyEl) return;
                const { title, loadUrl, submitUrl, method = 'POST', refreshUrl, onSuccess, viewOnly } = options;
                if (labelEl) labelEl.textContent = title || '—';
                if (bodyEl) bodyEl.innerHTML = '<div class="text-center py-4 text-muted"><span class="spinner-border spinner-border-sm me-2"></span>Loading...</div>';
                if (viewOnly) {
                    if (footerEl) footerEl.classList.add('d-none');
                    var dialog = modalEl ? modalEl.querySelector('.modal-dialog') : null;
                    if (dialog) dialog.classList.add('modal-lg');
                } else {
                    if (footerEl) footerEl.classList.remove('d-none');
                    var dialog = modalEl ? modalEl.querySelector('.modal-dialog') : null;
                    if (dialog) dialog.classList.remove('modal-lg');
                }
                const footer = footerEl;
                if (footer) { var btn = footer.querySelector('.btn-primary'); if (btn) btn.disabled = false; }

                fetch(loadUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } })
                    .then(r => r.text())
                    .then(html => {
                        if (bodyEl) bodyEl.innerHTML = html;
                        if (viewOnly) return;
                        const form = bodyEl ? bodyEl.querySelector('form') : null;
                        if (!form) return;
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            const btn = footer ? footer.querySelector('.btn-primary') : null;
                            if (btn) btn.disabled = true;
                            let fd = new FormData(form);
                            var projectSelect = form.querySelector('select[name="project_ids[]"]');
                            if (projectSelect && projectSelect.selectedOptions && projectSelect.selectedOptions.length > 0) {
                                var fd2 = new FormData();
                                for (var pair of fd.entries()) {
                                    if (pair[0] === 'project_ids[]') continue;
                                    fd2.append(pair[0], pair[1]);
                                }
                                for (var i = 0; i < projectSelect.selectedOptions.length; i++) {
                                    fd2.append('project_ids[]', projectSelect.selectedOptions[i].value);
                                }
                                var boardTypeEl = form.querySelector('select[name="board_type"]');
                                if (boardTypeEl && boardTypeEl.value) fd2.set('board_type', boardTypeEl.value);
                                var nameEl = form.querySelector('input[name="name"]');
                                if (nameEl) fd2.set('name', nameEl.value || '');
                                var methodEl = form.querySelector('input[name="_method"]');
                                if (methodEl && methodEl.value) fd2.set('_method', methodEl.value);
                                fd = fd2;
                            }
                            var boardIdSelect = form.querySelector('select[name="board_id"]');
                            if (boardIdSelect) {
                                if (!fd.has('name')) { var n = form.querySelector('input[name="name"]'); if (n) fd.set('name', n.value || ''); }
                                if (boardIdSelect.value) fd.set('board_id', boardIdSelect.value);
                                var methodInput = form.querySelector('input[name="_method"]');
                                if (methodInput && methodInput.value) fd.set('_method', methodInput.value);
                            }
                            const formToken = form.querySelector('input[name="_token"]');
                            const token = (formToken && formToken.value) ? formToken.value : (window.TaskFlow.csrf || '');
                            if (token) { fd.set('_token', token); }
                            var requestHeaders = { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' };
                            if (token) requestHeaders['X-CSRF-TOKEN'] = token;
                            var methodUpper = (method || 'POST').toUpperCase();
                            var fetchMethod = (methodUpper === 'GET' || methodUpper === 'HEAD') ? methodUpper : 'POST';
                            var fetchOpts = { method: fetchMethod, headers: requestHeaders };
                            if (fetchMethod !== 'GET' && fetchMethod !== 'HEAD') fetchOpts.body = fd;
                            if (methodUpper === 'PUT' || methodUpper === 'PATCH') { if (!fd.has('_method')) fd.append('_method', methodUpper); }
                            fetch(submitUrl, fetchOpts)
                                .then(r => r.json().then(data => ({ ok: r.ok, status: r.status, data })))
                                .then(({ ok, status, data }) => {
                                    if (ok && data.success !== false) {
                                        (function closeCrudModal() {
                                            var modalEl = document.getElementById('crudModal');
                                            if (!modalEl) return;
                                            try {
                                                var modalInstance = typeof bootstrap !== 'undefined' && bootstrap.Modal && bootstrap.Modal.getInstance(modalEl);
                                                if (modalInstance && typeof modalInstance.hide === 'function') modalInstance.hide();
                                                else throw new Error('no instance');
                                            } catch (err) {
                                                modalEl.classList.remove('show');
                                                modalEl.style.display = 'none';
                                                document.querySelectorAll('.modal-backdrop').forEach(function(b) { b.remove(); });
                                                document.body.classList.remove('modal-open');
                                                document.body.style.overflow = '';
                                                document.body.style.paddingRight = '';
                                            }
                                        })();
                                        window.TaskFlow.toast('success', data.message || 'Saved.');
                                        if (refreshUrl && options.refreshSelector) {
                                            fetch(refreshUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } })
                                                .then(r => r.text())
                                                .then(html => { document.querySelector(options.refreshSelector).innerHTML = html; });
                                        }
                                        if (onSuccess) onSuccess(data);
                                    } else {
                                        if (btn) btn.disabled = false;
                                        if (data.errors) {
                                            Object.keys(data.errors).forEach(name => {
                                                const input = form.querySelector('[name="' + name + '"]');
                                                const group = input && (input.closest('.mb-3') || input.closest('.col'));
                                                if (group) {
                                                    const inv = group.querySelector('.invalid-feedback') || document.createElement('div');
                                                    if (inv && inv.classList && !inv.classList.contains('invalid-feedback')) { inv.className = 'invalid-feedback'; group.appendChild(inv); }
                                                    if (inv) inv.textContent = data.errors[name][0];
                                                    var target = input || group.querySelector('input, select, textarea');
                                                    if (target && target.classList) target.classList.add('is-invalid');
                                                }
                                            });
                                        } else if (window.TaskFlow && window.TaskFlow.toast) window.TaskFlow.toast('error', data.message || 'Something went wrong.');
                                    }
                                })
                                .catch(() => { if (btn) btn.disabled = false; if (window.TaskFlow && window.TaskFlow.toast) window.TaskFlow.toast('error', 'Request failed.'); });
                        });
                    })
                    .catch(() => {
                        if (bodyEl) bodyEl.innerHTML = '<div class="alert alert-danger">Failed to load content.</div>';
                    });
                document.querySelectorAll('.modal-backdrop').forEach(function(el) { el.remove(); });
                if (document.body && document.body.classList) document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                var modalToShow = this.modal || modalEl;
                if (modalToShow) {
                    try {
                        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) bootstrap.Modal.getOrCreateInstance(modalToShow).show();
                        else { modalToShow.classList.add('show'); modalToShow.style.display = 'block'; document.body.classList.add('modal-open'); }
                    } catch (err) {
                        if (modalToShow.classList) modalToShow.classList.add('show');
                        modalToShow.style.display = 'block';
                        if (document.body && document.body.classList) document.body.classList.add('modal-open');
                    }
                }
            },
            openView(options) {
                if (!options || !options.loadUrl) return;
                this.open({ title: options.title || 'View', loadUrl: options.loadUrl, viewOnly: true });
            }
        }
    };
    document.addEventListener('DOMContentLoaded', function() {
        TaskFlow.crudModal.init();
        TaskFlow.appNav.init();
        document.body.addEventListener('click', function(e) {
            var btn = e.target.closest('.btn-view');
            if (!btn) return;
            e.preventDefault();
            var load = btn.getAttribute('data-load');
            var title = btn.getAttribute('data-title');
            if (load && window.TaskFlow && TaskFlow.crudModal && TaskFlow.crudModal.openView) TaskFlow.crudModal.openView({ title: title || 'View', loadUrl: load });
        });
        // Sidebar collapse/expand (desktop)
        (function() {
            var STORAGE_KEY = 'taskflow_sidebar_collapsed';
            var body = document.body;
            var toggleButtons = document.querySelectorAll('[data-sidebar-toggle]');
            function applyState(fromStorage) {
                var collapsed = false;
                if (fromStorage) {
                    collapsed = localStorage.getItem(STORAGE_KEY) === '1';
                } else {
                    collapsed = body.classList.contains('sidebar-collapsed');
                }
                if (collapsed) body.classList.add('sidebar-collapsed');
                else body.classList.remove('sidebar-collapsed');
            }
            applyState(true);
            toggleButtons.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    body.classList.toggle('sidebar-collapsed');
                    var collapsed = body.classList.contains('sidebar-collapsed');
                    try { localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0'); } catch (err) {}
                    applyState(false);
                });
            });
        })();
        document.addEventListener('submit', function(e) {
            var form = e.target;
            if (!form || !form.method || form.method.toLowerCase() !== 'get' || !form.closest('#app-main-content')) return;
            if (!form.classList || !form.classList.contains('setup-filter-form')) return;
            e.preventDefault();
            var url = (form.getAttribute('action') || window.location.pathname).split('?')[0];
            var params = new URLSearchParams(new FormData(form));
            if (params.toString()) url += '?' + params.toString();
            if (typeof TaskFlow !== 'undefined' && TaskFlow.appNav && TaskFlow.appNav.loadPage) TaskFlow.appNav.loadPage(url, false);
        });
        document.getElementById('app-main-content')?.addEventListener('click', function(e) {
            var a = e.target && e.target.closest && e.target.closest('a[href]');
            if (!a || a.getAttribute('target') === '_blank' || (a.classList && (a.classList.contains('btn-edit') || a.classList.contains('btn-delete') || a.classList.contains('btn-view')))) return;
            var href = a.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;
            try {
                var fullUrl = new URL(href, window.location.origin);
                if (fullUrl.origin === window.location.origin) {
                    e.preventDefault();
                    if (TaskFlow.appNav && TaskFlow.appNav.loadPage) TaskFlow.appNav.loadPage(href);
                }
            } catch (err) {}
        });
    });

    // SPA-style nav: load setup/main pages into #app-main without full reload (AJAX + transition)
    TaskFlow.appNav = {
        init() {
            const self = this;
            document.querySelector('.app-sidebar')?.addEventListener('click', function(e) {
                const a = e.target && e.target.closest && e.target.closest('a[href]');
                if (!a) return;
                const href = a.getAttribute('href');
                if (!href || href === '' || href.startsWith('#') || href.startsWith('javascript:')) return;
                if (a.getAttribute('target') === '_blank') return;
                try {
                    const fullUrl = new URL(href, window.location.origin);
                    if (fullUrl.origin !== window.location.origin) return;
                } catch (err) { return; }
                if (a.closest('form')) return;
                e.preventDefault();
                self.loadPage(href);
            });
            window.addEventListener('popstate', function() {
                self.loadPage(window.location.pathname + window.location.search, true);
            });
        },
        loadPage(url, noPush) {
            const main = document.getElementById('app-main');
            const contentTarget = document.getElementById('app-main-content');
            const loadingEl = document.getElementById('app-main-loading');
            if (!main) return;
            if (loadingEl && loadingEl.classList) loadingEl.classList.remove('d-none');
            const reqUrl = url.startsWith('http') ? url : (window.location.origin + (url.startsWith('/') ? '' : '/') + url);
            fetch(reqUrl, {
                credentials: 'same-origin',
                cache: 'no-store',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
            })
                .then(function(r) {
                    if (!r.ok) throw new Error('Load failed');
                    return r.text();
                })
                .then(function(html) {
                    if (!html || html.trim().length === 0) {
                        if (typeof TaskFlow !== 'undefined' && TaskFlow.toast) TaskFlow.toast('error', 'Failed to load content.');
                        return;
                    }
                    var newContent = null;
                    var scriptsRoot = null;
                    var doc = null;
                    try {
                        var parser = new DOMParser();
                        doc = parser.parseFromString(html, 'text/html');
                    } catch (parseErr) {
                        if (typeof TaskFlow !== 'undefined' && TaskFlow.toast) TaskFlow.toast('error', 'Failed to load content.');
                        return;
                    }
                    if (doc.getElementById) {
                        newContent = doc.getElementById('app-main-content');
                    }
                    if (!newContent) {
                        newContent = doc.querySelector('[id="app-main-content"]') || doc.querySelector('.app-main-inner');
                    }
                    if (!newContent && doc.body) {
                        newContent = doc.body.querySelector('#app-main-content') || doc.body.querySelector('[id="app-main-content"]') || doc.body.querySelector('.app-main-inner');
                    }
                    var newMain = null;
                    if (!newContent) {
                        newMain = doc.getElementById('app-main') || doc.querySelector('[id="app-main"]') || doc.querySelector('.app-main') || doc.querySelector('main');
                        if (!newMain && doc.body) {
                            newMain = doc.body.querySelector('#app-main') || doc.body.querySelector('main');
                        }
                        if (!newMain) {
                            if (typeof TaskFlow !== 'undefined' && TaskFlow.toast) TaskFlow.toast('error', 'Failed to load content.');
                            return;
                        }
                        newContent = newMain.querySelector('#app-main-content') || newMain.querySelector('[id="app-main-content"]') || newMain.querySelector('.app-main-inner');
                        if (!newContent && newMain.children && newMain.children.length > 1) {
                            newContent = newMain.children[1];
                        }
                        if (!newContent) newContent = newMain;
                        scriptsRoot = newMain;
                    } else {
                        scriptsRoot = doc.body || doc.documentElement;
                    }
                    if (contentTarget) contentTarget.classList.add('app-main-content-fade-out');
                    var transitionMs = 180;
                    var runAfterTransition = function() {
                        if (newContent && contentTarget) {
                            contentTarget.innerHTML = newContent.innerHTML || '';
                        } else if (newMain && main) {
                            var inner = newMain.querySelector('#app-main-content') || newMain.querySelector('[id="app-main-content"]') || newMain.querySelector('.app-main-inner');
                            if (contentTarget && inner) contentTarget.innerHTML = inner.innerHTML || '';
                            else main.innerHTML = newMain.innerHTML || '';
                        }
                        if (contentTarget) {
                            contentTarget.classList.remove('app-main-content-fade-out');
                            contentTarget.scrollTop = 0;
                        }
                        var scripts = scriptsRoot ? scriptsRoot.querySelectorAll('script') : [];
                        if (!scripts.length && doc.body) scripts = doc.body.querySelectorAll('script');
                        scripts.forEach(function(oldScript) {
                            var script = document.createElement('script');
                            if (oldScript.src) {
                                script.src = oldScript.src;
                            } else {
                                script.textContent = oldScript.textContent;
                            }
                            document.body.appendChild(script);
                        });
                        if (!noPush) history.pushState({}, '', url);
                        document.querySelectorAll('.app-sidebar .nav-link.active').forEach(function(l) { if (l && l.classList) l.classList.remove('active'); });
                        var pathOnly = (url.split('?')[0] || '').replace(/\/$/, '') || '/';
                        var pathNorm = pathOnly.startsWith('http') ? new URL(pathOnly).pathname.replace(/\/$/, '') || '/' : pathOnly;
                        document.querySelectorAll('.app-sidebar .nav-link[href]').forEach(function(link) {
                            if (!link || !link.classList) return;
                            var h = link.getAttribute('href');
                            var linkPath = (h && h.split('?')[0] || '').replace(/\/$/, '') || '/';
                            var linkPathNorm = linkPath.startsWith('http') ? new URL(linkPath).pathname.replace(/\/$/, '') || '/' : linkPath;
                            if (linkPathNorm === pathNorm) link.classList.add('active');
                        });
                        document.title = (doc.querySelector('title') && doc.querySelector('title').textContent) || document.title;
                    };
                    setTimeout(runAfterTransition, transitionMs);
                })
                .catch(function() {
                    if (typeof TaskFlow !== 'undefined' && TaskFlow.toast) TaskFlow.toast('error', 'Failed to load page.');
                })
                .finally(function() {
                    var loading = document.getElementById('app-main-loading');
                    if (loading && loading.classList) loading.classList.add('d-none');
                });
        }
    };
    </script>
    @yield('vite')
    @stack('scripts')
</body>
</html>
