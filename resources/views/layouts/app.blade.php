<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script>
    (function () {
        try {
            var t = localStorage.getItem('taskflow-theme') || 'light';
            if (t === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.documentElement.setAttribute('data-bs-theme', 'dark');
            } else if (t === 'ocean') {
                document.documentElement.setAttribute('data-theme', 'ocean');
                document.documentElement.setAttribute('data-bs-theme', 'light');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
                document.documentElement.setAttribute('data-bs-theme', 'light');
            }
        } catch (e) {}
    })();
    </script>
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
            --radius: 0.1875rem;
            --radius-lg: 0.3125rem;
            --radius-xl: 0.4375rem;
            --bs-border-radius: var(--radius);
            --bs-border-radius-sm: 0.125rem;
            --bs-border-radius-lg: var(--radius-lg);
            --bs-border-radius-xl: var(--radius-xl);
            --bs-card-border-radius: var(--radius-lg);
            --bs-modal-border-radius: var(--radius-lg);
            --bs-dropdown-border-radius: var(--radius-lg);
            --bs-dropdown-inner-border-radius: var(--radius);
            --shadow: 0 1px 3px rgba(15, 23, 42, 0.06), 0 4px 12px rgba(15, 23, 42, 0.08);
            --shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.05);
            --shadow-lg: 0 8px 24px rgba(15, 23, 42, 0.1), 0 2px 8px rgba(15, 23, 42, 0.06);
            --sidebar-bg: #fafbfc;
            --sidebar-text: #3d4f5f;
            --sidebar-text-muted: #64748b;
            --sidebar-hover: #f0f2f7;
            --sidebar-active: rgba(91, 95, 239, 0.14);
            --primary: #5b5fef;
            --primary-hover: #4f52e5;
            --body-bg: #f1f3f9;
            --border-color: #e2e6ef;
            --border-light: rgba(15, 23, 42, 0.08);
            --text-body: #3d4f5f;
            --text-muted: #64748b;
            --input-bg: #ffffff;
            --header-bg: #ffffff;
            /* Form control heights — default single-line inputs match default .btn */
            --control-height: 38px;
            --control-height-sm: 30px;
            --control-height-lg: 44px;
            /* Semantic actions (aligned with Sneat UI kit) */
            --btn-success: #71dd37;
            --btn-success-border: #65c932;
            --btn-success-hover: #5fc32f;
            --btn-warning: #ffab00;
            --btn-warning-border: #eba400;
            --btn-warning-hover: #e6a200;
            --btn-info: #03c3ec;
            --btn-info-border: #02b0d4;
            --btn-info-hover: #02afd0;
            --btn-dark: #233446;
            --btn-dark-border: #1e2d3d;
            --btn-dark-hover: #1a2836;
        }
        /* —— Color themes (Light = default :root; Dark / Ocean below) —— */
        html[data-theme="dark"] {
            color-scheme: dark;
            --sidebar-bg: #111827;
            --sidebar-text: #f1f5f9;
            --sidebar-text-muted: #9ca3af;
            --sidebar-hover: rgba(148, 163, 184, 0.1);
            --sidebar-active: rgba(129, 140, 248, 0.18);
            --primary: #8b93ff;
            --primary-hover: #a5adff;
            --body-bg: #070b14;
            --border-color: #2d3748;
            --border-light: rgba(148, 163, 184, 0.14);
            --text-body: #e8edf5;
            --text-muted: #9ca3af;
            --input-bg: #1a2234;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.35), 0 1px 3px rgba(0, 0, 0, 0.25);
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.28);
            --shadow-lg: 0 16px 40px rgba(0, 0, 0, 0.45);
        }
        html[data-theme="dark"] .app-header {
            background: var(--sidebar-bg);
            border-bottom-color: rgba(148, 163, 184, 0.12);
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.2);
        }
        html[data-theme="dark"] .app-header .header-search .form-control {
            background: #1a2234;
            border-color: var(--border-color);
            color: var(--text-body);
        }
        html[data-theme="dark"] .app-header .navbar-user .user-name { color: var(--text-body); }
        html[data-theme="dark"] .app-header .navbar-user .avatar {
            background: linear-gradient(135deg, #7c8cff 0%, #b794f6 55%, #f472b6 100%);
        }
        html[data-theme="dark"] .app-sidebar { box-shadow: 4px 0 24px rgba(0, 0, 0, 0.25); }
        html[data-theme="dark"] .app-sidebar .sidebar-brand { border-bottom-color: rgba(148, 163, 184, 0.1); }
        html[data-theme="dark"] .app-sidebar .sidebar-brand .brand-text { color: var(--text-body); }
        html[data-theme="dark"] .app-sidebar .nav-link.active { color: #c7d2fe; }
        html[data-theme="dark"] .app-sidebar .nav-link.active i { color: var(--primary); }
        html[data-theme="dark"] .app-sidebar .nav-link.active::before { background: var(--primary); }
        html[data-theme="dark"] .app-sidebar .nav-link:hover i { color: var(--primary); }
        html[data-theme="dark"] .app-sidebar .nav-link:hover::before { background: rgba(139, 147, 255, 0.45); }
        html[data-theme="dark"] .app-sidebar .setup-nav-scroll {
            background: rgba(7, 11, 20, 0.45);
        }
        html[data-theme="dark"] .card {
            background: #161f2e;
            border-color: var(--border-light);
        }
        html[data-theme="dark"] .card-header,
        html[data-theme="dark"] .card-footer {
            background: #161f2e;
            border-color: var(--border-light);
        }
        html[data-theme="dark"] .modal-content {
            background: #161f2e;
            color: var(--text-body);
            border-color: var(--border-color);
        }
        html[data-theme="dark"] .modal-header,
        html[data-theme="dark"] .modal-footer { border-color: var(--border-color); }
        html[data-theme="dark"] .table { color: var(--text-body); }
        html[data-theme="dark"] .table .table-light th {
            background: #111827;
            color: var(--text-muted);
            border-color: var(--border-color);
        }
        html[data-theme="dark"] .table > :not(caption) > * > * {
            border-bottom-color: var(--border-color);
        }
        html[data-theme="dark"] .form-control,
        html[data-theme="dark"] .form-select {
            background-color: var(--input-bg);
            color: var(--text-body);
            border-color: var(--border-color);
        }
        html[data-theme="dark"] .btn-primary {
            background: linear-gradient(180deg, #949dff 0%, #6b73f5 100%);
            border-color: #6b73f5;
            color: #0b0f1a;
            font-weight: 600;
        }
        html[data-theme="dark"] .btn-primary:hover:not(:disabled) {
            background: linear-gradient(180deg, #a8afff 0%, #7c84f7 100%);
            border-color: #8b93ff;
            color: #0b0f1a;
        }
        html[data-theme="dark"] .btn-outline-secondary {
            color: var(--text-body);
            border-color: var(--border-color);
            background: transparent;
        }
        html[data-theme="dark"] .btn-outline-secondary:hover:not(:disabled) {
            background: rgba(148, 163, 184, 0.1);
            border-color: #4b5563;
            color: var(--text-body);
        }
        html[data-theme="dark"] .btn-light {
            background: #252f42;
            border-color: #3d4a5f;
            color: var(--text-body);
        }
        html[data-theme="dark"] .app-main-loading {
            background: rgba(7, 11, 20, 0.88) !important;
        }
        html[data-theme="dark"] .dropdown-menu {
            background: #161f2e;
            border-color: var(--border-color);
        }
        html[data-theme="dark"] .dropdown-item { color: var(--text-body); }
        html[data-theme="dark"] .dropdown-item:hover,
        html[data-theme="dark"] .dropdown-item:focus { background: rgba(139, 147, 255, 0.12); color: var(--text-body); }
        html[data-theme="dark"] .scrollable::-webkit-scrollbar-thumb,
        html[data-theme="dark"] .app-main-inner::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.28); }
        html[data-theme="dark"] .setup-filter-form {
            background: linear-gradient(165deg, #1a2436 0%, #111827 55%, #0d121c 100%);
            border-bottom-color: var(--border-color);
        }
        html[data-theme="dark"] .setup-table-footer.card-footer {
            background: linear-gradient(to top, #151d2e 0%, #111827 55%);
            border-top-color: var(--border-color) !important;
        }
        html[data-theme="dark"] .setup-filter-form-label { color: var(--text-muted); }
        html[data-theme="dark"] .page-title { color: var(--text-body); }
        /* Ocean: deep sea glass — cool neutrals + saturated teal accent */
        html[data-theme="ocean"] {
            --header-bg: #fcfdfd;
            --sidebar-bg: #f7fcfc;
            --sidebar-text: #134e4a;
            --sidebar-text-muted: #5b7c78;
            --sidebar-hover: #e0f5f3;
            --sidebar-active: rgba(13, 148, 136, 0.12);
            --primary: #0d9488;
            --primary-hover: #0f766e;
            --body-bg: #e8f4f2;
            --border-color: #b8d9d4;
            --border-light: rgba(19, 78, 74, 0.09);
            --text-body: #134e4a;
            --text-muted: #5b7c78;
            --input-bg: #ffffff;
            --shadow: 0 1px 3px rgba(19, 78, 74, 0.06), 0 6px 16px rgba(13, 148, 136, 0.07);
            --shadow-sm: 0 1px 2px rgba(19, 78, 74, 0.05);
            --shadow-lg: 0 10px 28px rgba(19, 78, 74, 0.08), 0 4px 12px rgba(13, 148, 136, 0.06);
        }
        html[data-theme="ocean"] .app-sidebar {
            box-shadow: 2px 0 16px rgba(13, 148, 136, 0.06);
        }
        html[data-theme="ocean"] .app-sidebar .setup-nav-scroll {
            background: #e4f2ef;
        }
        html[data-theme="ocean"] .app-sidebar .setup-nav-scroll .nav-section-label {
            color: #5b7c78;
        }
        html[data-theme="ocean"] .app-sidebar .sidebar-brand .brand-text { color: var(--text-body); }
        html[data-theme="ocean"] .app-header {
            background: var(--header-bg);
            border-bottom-color: var(--border-light);
        }
        html[data-theme="ocean"] .app-header .header-search .form-control {
            background: #f0faf9;
            border-color: var(--border-color);
        }
        html[data-theme="ocean"] .app-header .navbar-user .user-name { color: var(--text-body); }
        html[data-theme="ocean"] .app-header .navbar-user .avatar {
            background: linear-gradient(135deg, #0f766e 0%, #14b8a6 45%, #2dd4bf 100%);
        }
        html[data-theme="ocean"] .app-sidebar .nav-link.active {
            color: #0f766e;
            background: var(--sidebar-active);
        }
        html[data-theme="ocean"] .app-sidebar .nav-link.active i { color: #0d9488; }
        html[data-theme="ocean"] .app-sidebar .nav-link.active::before { background: linear-gradient(180deg, #14b8a6, #0d9488); }
        html[data-theme="ocean"] .app-sidebar .nav-link:hover i { color: #0d9488; }
        html[data-theme="ocean"] .app-sidebar .nav-link:hover::before { background: rgba(13, 148, 136, 0.32); }
        html[data-theme="ocean"] .card {
            border-color: var(--border-light);
            box-shadow: var(--shadow-sm);
        }
        html[data-theme="ocean"] .btn-primary {
            background: linear-gradient(180deg, #14b8a6 0%, #0d9488 100%);
            border-color: #0f766e;
            color: #fff;
            font-weight: 600;
        }
        html[data-theme="ocean"] .btn-primary:hover:not(:disabled) {
            background: linear-gradient(180deg, #2dd4bf 0%, #14b8a6 100%);
            border-color: #0d9488;
            color: #fff;
        }
        html { overflow-x: hidden; }
        body { min-height: 100vh; background: var(--body-bg); font-family: 'Public Sans', 'DM Sans', system-ui, sans-serif; color: var(--text-body); font-size: 0.9375rem; overflow-x: hidden; line-height: 1.5; }
        .app-sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            max-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed; left: 0; top: 0; z-index: 1020;
            overflow-x: hidden;
            overflow-y: auto;
            transition: transform .25s ease, width .25s ease;
            box-shadow: 2px 0 12px rgba(0,0,0,.08);
            display: flex;
            flex-direction: column;
        }
        .app-sidebar .sidebar-brand {
            height: var(--header-height);
            padding: 0 1.5rem;
            display: flex; align-items: center; gap: .5rem;
            border-bottom: 1px solid rgba(15,23,42,.08);
        }
        .app-sidebar .sidebar-brand .brand-icon {
            width: 32px; height: 32px; background: var(--primary);
            border-radius: var(--radius); display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.25rem;
        }
        .app-sidebar .sidebar-brand .brand-text { color: var(--text-body); font-weight: 700; font-size: 1.25rem; letter-spacing: -.02em; }
        .app-sidebar .sidebar-nav { flex: 1; min-height: 0; display: flex; flex-direction: column; padding: .5rem 0; }
        .app-sidebar .sidebar-nav > ul { display: flex; flex-direction: column; flex: 1; min-height: 0; }
        .app-sidebar .nav { padding: .5rem 0; }
        .app-sidebar .sidebar-nav > ul > li { padding: 0; margin: 0; }
        .app-sidebar .nav-link {
            color: var(--sidebar-text-muted);
            padding: .625rem 1.5rem;
            border-radius: var(--radius-lg);
            margin: 0 .5rem;
            font-size: .9375rem;
            font-weight: 500;
            display: flex; align-items: center;
            position: relative;
            overflow: hidden;
            transition: color .24s ease, background .24s ease, transform .18s ease, box-shadow .24s ease;
        }
        .app-sidebar .nav-link i {
            font-size: 1.25rem;
            margin-right: .75rem;
            opacity: .88;
            width: 1.5rem;
            text-align: center;
            color: var(--sidebar-text-muted);
            transition: color .2s ease, opacity .2s ease, transform .2s ease;
        }
        .app-sidebar .nav-link .nav-label { white-space: nowrap; transition: transform .18s ease, opacity .18s ease; }
        .app-sidebar .nav-link::before {
            content: "";
            position: absolute;
            left: 0;
            top: 18%;
            height: 64%;
            width: 3px;
            border-radius: 3px;
            background: transparent;
            transition: background .2s ease;
        }
        .app-sidebar .nav-link:hover {
            color: var(--sidebar-text);
            background: var(--sidebar-hover);
            transform: translateX(2px);
        }
        .app-sidebar .nav-link:hover i {
            color: var(--primary);
            opacity: 1;
        }
        .app-sidebar .nav-link:hover::before {
            background: color-mix(in srgb, var(--primary) 38%, transparent);
        }
        .app-sidebar .nav-link.active {
            color: var(--primary);
            font-weight: 600;
            background: var(--sidebar-active);
            border: 1px solid transparent;
            box-shadow: none;
        }
        .app-sidebar .nav-link.active i {
            color: var(--primary);
            opacity: 1;
            transform: none;
        }
        .app-sidebar .nav-link.active::before {
            background: var(--primary);
            box-shadow: none;
        }
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
            transition: color .24s ease, background .24s ease, transform .18s ease;
            box-sizing: border-box;
        }
        .app-sidebar .nav-section-toggle:hover {
            color: var(--sidebar-text);
            background: var(--sidebar-hover);
            transform: translateX(2px);
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
            background: #eef1f6;
            scrollbar-width: thin;
            scrollbar-color: rgba(148,163,184,.55) rgba(148,163,184,.16);
        }
        .app-sidebar .setup-nav-scroll .nav { padding: .25rem 0 .75rem; }
        .app-sidebar .setup-nav-scroll .nav-link {
            padding: .5rem 1.5rem .5rem 2.25rem;
            font-size: .875rem;
            border-left: 2px solid transparent;
        }
        .app-sidebar .setup-nav-scroll .nav-link:hover { border-left-color: transparent; }
        .app-sidebar .setup-nav-scroll .nav-link.active { border-left-color: transparent; }
        .app-sidebar .setup-nav-scroll .nav-link i { font-size: 1.125rem; margin-right: .625rem; width: 1.25rem; }
        .app-sidebar .setup-nav-scroll .nav-section-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: .09em;
            color: #a1acb8;
            padding: .75rem 1.5rem .25rem 2.25rem;
            font-weight: 600;
        }
        .app-sidebar .setup-nav-scroll::-webkit-scrollbar { width: 6px; }
        .app-sidebar .setup-nav-scroll::-webkit-scrollbar-track { background: rgba(148,163,184,.14); border-radius: 3px; }
        .app-sidebar .setup-nav-scroll::-webkit-scrollbar-thumb { background: rgba(148,163,184,.48); border-radius: 3px; }
        .app-sidebar .setup-nav-scroll::-webkit-scrollbar-thumb:hover { background: rgba(148,163,184,.68); }
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
            width: calc(100vw - var(--sidebar-width));
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
            padding-top: calc(var(--header-height) + 1rem);
            transition: margin .28s cubic-bezier(0.4, 0, 0.2, 1), max-width .28s cubic-bezier(0.4, 0, 0.2, 1), width .28s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }
        .app-header {
            height: var(--header-height);
            background: var(--header-bg);
            border-bottom: 1px solid var(--border-light);
            position: fixed; left: var(--sidebar-width); right: 0; top: 0; z-index: 1015;
            box-shadow: 0 1px 2px rgba(15,23,42,.04);
            display: flex; align-items: center; padding: 0 1.5rem;
            transition: left .28s cubic-bezier(0.4, 0, 0.2, 1), width .28s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .app-header .header-search { max-width: 280px; }
        .app-header .header-search .form-control {
            border: 1px solid var(--border-color); border-radius: var(--radius-lg);
            height: var(--control-height);
            min-height: var(--control-height);
            padding: 0.375rem 1rem 0.375rem 2.5rem; font-size: 0.875rem; background: var(--body-bg);
            line-height: 1.35;
        }
        .app-header .header-search .search-icon { left: .875rem; color: #a1acb8; pointer-events: none; }
        .app-header .header-search .header-search-trigger {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            height: var(--control-height);
            min-height: var(--control-height);
            padding: 0.375rem 1rem 0.375rem 2.5rem;
            font-size: 0.875rem;
            background: var(--body-bg);
            color: var(--text-muted);
            line-height: 1.35;
            width: 100%;
            text-align: left;
            cursor: pointer;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }
        .app-header .header-search .header-search-trigger:hover {
            border-color: color-mix(in srgb, var(--primary) 32%, var(--border-color));
            background: color-mix(in srgb, var(--primary) 4%, var(--body-bg));
            box-shadow: var(--shadow-sm);
            color: var(--text-body);
        }
        .app-header .global-search-mobile-trigger {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            width: var(--control-height);
            height: var(--control-height);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--body-bg);
            color: var(--text-muted);
            padding: 0;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }
        .app-header .global-search-mobile-trigger:hover {
            border-color: color-mix(in srgb, var(--primary) 32%, var(--border-color));
            color: var(--primary);
            box-shadow: var(--shadow-sm);
        }
        .global-search-modal .global-search-modal-dialog {
            max-width: min(96vw, 980px);
            width: 100%;
            margin: 1rem auto;
        }
        @media (min-width: 1200px) {
            .global-search-modal .global-search-modal-dialog {
                max-width: min(92vw, 1040px);
            }
        }
        .global-search-modal .modal-content {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            min-height: min(82vh, 820px);
            max-height: 92vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .global-search-modal .modal-header {
            flex-shrink: 0;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.35rem 1.75rem 1rem;
            border-bottom: 1px solid var(--border-light);
            background: linear-gradient(180deg, color-mix(in srgb, var(--primary) 5%, var(--header-bg)) 0%, var(--header-bg) 100%);
        }
        .global-search-modal .modal-header .btn-close {
            flex-shrink: 0;
            margin: 0.2rem 0 0;
        }
        .global-search-modal .modal-title {
            font-size: 1.2rem;
            letter-spacing: -0.02em;
        }
        .global-search-modal .modal-body {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            min-height: 0;
            overflow: hidden;
            padding: 1.35rem 1.75rem 1.5rem;
            gap: 1rem;
        }
        .global-search-modal .global-search-field-wrap {
            flex-shrink: 0;
        }
        .global-search-modal #globalSearchInput {
            border-radius: var(--radius-lg);
            padding-left: 3.65rem;
            padding-right: 2.75rem;
            min-height: 3.125rem;
            font-size: 1rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            background-color: transparent;
            background-image: none;
        }
        .global-search-modal #globalSearchInput:focus {
            background-color: transparent;
        }
        .global-search-modal .global-search-input-icon {
            top: 50%;
            left: 1.15rem;
            z-index: 2;
            font-size: 1.15rem;
            line-height: 1;
            width: 1.25rem;
            text-align: center;
            pointer-events: none;
            transform: translateY(-50%);
        }
        html[data-theme="dark"] .global-search-modal #globalSearchInput,
        html[data-theme="dark"] .global-search-modal #globalSearchInput:focus {
            background-color: transparent;
        }
        .global-search-type-checks {
            flex-shrink: 0;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.65rem 1.35rem;
            padding: 0.75rem 0;
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
        }
        .global-search-type-checks .global-search-types-label {
            width: 100%;
            margin-bottom: 0.1rem;
            font-size: 0.6875rem;
            letter-spacing: 0.06em;
        }
        @media (min-width: 576px) {
            .global-search-type-checks .global-search-types-label {
                width: auto;
                margin-bottom: 0;
                margin-right: 0.25rem;
            }
        }
        .global-search-type-checks .form-check {
            margin-bottom: 0;
            min-height: 0;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }
        .global-search-type-checks .form-check-input {
            border-radius: var(--radius);
            width: 1rem;
            height: 1rem;
            margin: 0;
            flex-shrink: 0;
            cursor: pointer;
        }
        .global-search-type-checks .form-check-label {
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--text-body);
            cursor: pointer;
            padding: 0;
            margin: 0;
        }
        .global-search-results {
            flex: 1 1 0;
            min-height: 320px;
            overflow-y: auto;
            overflow-x: hidden;
            margin-top: 0;
            padding: 0.35rem 0.15rem 0.5rem;
            border: none;
            border-radius: 0;
            background: transparent;
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.2) transparent;
        }
        .global-search-results::-webkit-scrollbar {
            width: 8px;
        }
        .global-search-results::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.18);
            border-radius: 4px;
        }
        .global-search-modal .global-search-hint {
            flex-shrink: 0;
            padding-top: 0.25rem;
            border-top: 1px solid var(--border-light);
            margin-bottom: 0 !important;
            margin-top: 0 !important;
        }
        html[data-theme="dark"] .global-search-modal .modal-header {
            background: linear-gradient(180deg, rgba(91, 95, 239, 0.08) 0%, var(--header-bg) 100%);
            border-bottom-color: var(--border-color);
        }
        html[data-theme="dark"] .global-search-results::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.35);
        }
        .global-search-section {
            margin-bottom: 1.35rem;
        }
        .global-search-section:last-child {
            margin-bottom: 0;
        }
        .global-search-section-title {
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            margin: 0 0 0.5rem;
            padding-bottom: 0.35rem;
            border-bottom: 1px solid var(--border-light);
        }
        .global-search-hit-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .global-search-hit {
            display: flex;
            align-items: stretch;
            text-decoration: none;
            color: inherit;
            border-bottom: 1px solid var(--border-light);
            padding: 0.85rem 0.5rem 0.85rem 0.85rem;
            margin: 0;
            border-radius: 0;
            transition: background .16s ease, box-shadow .16s ease, border-left-color .16s ease;
            border-left: 3px solid transparent;
        }
        .global-search-hit:last-child {
            border-bottom: none;
        }
        .global-search-hit:hover {
            background: color-mix(in srgb, var(--primary) 6%, transparent);
            color: inherit;
            box-shadow: inset 0 0 0 1px color-mix(in srgb, var(--primary) 12%, transparent);
            border-left-color: var(--primary);
        }
        .global-search-hit-main {
            flex: 1;
            min-width: 0;
        }
        .global-search-hit-line1 {
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
            gap: 0.35rem 0.65rem;
            margin-bottom: 0.2rem;
        }
        .global-search-hit-key {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: -0.02em;
        }
        .global-search-hit-title {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--text-body);
            letter-spacing: -0.01em;
        }
        .global-search-hit-meta,
        .global-search-hit-kind {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 500;
        }
        .global-search-hit-kind {
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-size: 0.65rem;
        }
        .global-search-hit-line2 {
            font-size: 0.8125rem;
            color: var(--text-muted);
            line-height: 1.45;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .global-search-hit .badge {
            font-size: 0.65rem;
            font-weight: 600;
            vertical-align: middle;
        }
        @media (prefers-reduced-motion: reduce) {
            .global-search-hit { transition: background .1s ease; }
        }
        .global-search-hit:focus-visible {
            outline: 2px solid color-mix(in srgb, var(--primary) 55%, transparent);
            outline-offset: 1px;
            z-index: 1;
        }
        html[data-theme="dark"] .global-search-hit:hover {
            background: rgba(139, 147, 255, 0.08);
            box-shadow: inset 0 0 0 1px rgba(139, 147, 255, 0.15);
        }
        .app-header .navbar-user {
            display: flex; align-items: center; gap: .75rem; padding: .5rem .75rem;
            border-radius: var(--radius-lg); margin-left: auto;
        }
        .app-header .navbar-user .avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, color-mix(in srgb, var(--primary) 72%, #a78bfa) 100%);
            color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: .875rem;
        }
        .app-header .navbar-user .user-name { font-weight: 500; color: var(--text-body); font-size: .9375rem; }
        /* Unified scrollable - Sneat-style thin scrollbar */
        .scrollable, .app-main-inner { scrollbar-width: thin; scrollbar-color: rgba(0,0,0,.22) transparent; -webkit-overflow-scrolling: touch; }
        .scrollable::-webkit-scrollbar, .app-main-inner::-webkit-scrollbar { width: 6px; height: 6px; }
        .scrollable::-webkit-scrollbar-track, .app-main-inner::-webkit-scrollbar-track { background: transparent; border-radius: 3px; }
        .scrollable::-webkit-scrollbar-thumb, .app-main-inner::-webkit-scrollbar-thumb { background: rgba(0,0,0,.22); border-radius: 3px; }
        .scrollable::-webkit-scrollbar-thumb:hover, .app-main-inner::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,.35); }
        .app-main-inner {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            padding-bottom: 0;
            transition: opacity 0.34s cubic-bezier(0.4, 0, 0.2, 1), transform 0.34s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: opacity, transform;
        }
        #app-main-content.app-main-content-fade-out {
            opacity: 0;
            transform: translateY(12px) scale(0.992);
            pointer-events: none;
        }
        #app-main-content.app-main-content-fade-in {
            animation: appContentFadeIn 0.48s cubic-bezier(0.22, 1, 0.36, 1) both;
        }
        @keyframes appContentFadeIn {
            from { opacity: 0; transform: translateY(16px) scale(0.988); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @media (prefers-reduced-motion: reduce) {
            .app-main-inner {
                transition: opacity 0.14s ease;
            }
            #app-main-content.app-main-content-fade-out {
                transform: none;
                opacity: 0.35;
            }
            #app-main-content.app-main-content-fade-in {
                animation: none;
                opacity: 1;
                transform: none;
            }
        }
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
        .dashboard-card { border: 1px solid rgba(0,0,0,.06); border-radius: var(--radius-lg); box-shadow: none; background: #fff; }
        .dashboard-card .card-header { background: #fff; border-bottom: 1px solid rgba(0,0,0,.06); padding: 0.75rem 1rem; font-weight: 600; font-size: 0.9375rem; border-radius: var(--radius-lg) var(--radius-lg) 0 0; }
        .dashboard-card .card-header span.subtitle { font-weight: 400; font-size: 0.75rem; color: #a1acb8; margin-left: 0.35rem; }
        .dashboard-card .card-body { padding: 1rem; }
        .dashboard-kpi { border-radius: var(--radius-lg); box-shadow: none; border: 1px solid rgba(0,0,0,.06); background: #fff; }
        .dashboard-kpi .card-body { padding: 0.65rem 0.9rem; }
        .dashboard-kpi .kpi-icon { width: 38px; height: 38px; border-radius: var(--radius); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
        .dashboard-kpi .text-uppercase.tracking { letter-spacing: 0.04em; font-size: 0.7rem; }
        .dashboard-kpi .kpi-secondary { font-size: 0.75rem; color: #a1acb8; margin-top: 0.1rem; }
        .dashboard-overview {
            background: linear-gradient(135deg, #eef2ff 0%, #e0f2fe 55%, #fef3c7 100%);
            color: #111827;
            border: 0;
            border-radius: var(--radius-lg);
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
        .table {
            color: var(--text-body);
            font-size: 0.875rem;
            border-collapse: separate;
            border-spacing: 0;
        }
        .table thead th {
            position: sticky;
            top: 0;
            z-index: 5;
            font-weight: 700;
            color: #6b7280;
            font-size: 0.6875rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            white-space: nowrap;
            padding: 0.8rem 1rem;
            background: #fafbfc;
            border-bottom: 1px solid #e9edf3;
        }
        .table tbody td {
            vertical-align: middle;
            padding: 0.72rem 1rem;
            border-bottom: 1px solid #eef1f6;
            font-size: 0.8125rem;
            line-height: 1.4;
        }
        .table tbody tr {
            transition: background-color .2s ease, transform .16s ease, box-shadow .2s ease;
            transform: translateZ(0);
        }
        .table tbody tr:nth-of-type(even) { background-color: #fcfcfd; }
        .table tbody tr:hover {
            background: #f5f7ff;
            box-shadow: inset 0 1px 0 rgba(105,108,255,.05), inset 0 -1px 0 rgba(105,108,255,.05);
        }
        .table tbody tr:last-child td { border-bottom: 0; }
        .table .table-light th { background: #fafbfc; color: var(--text-muted); }
        .table tbody td:last-child:has(.btn) { white-space: nowrap; text-align: right; }
        .table tbody td:last-child .btn, .table tbody td:last-child .btn-sm {
            display: inline-flex;
            margin-left: 0.35rem;
            vertical-align: middle;
            align-items: center;
            justify-content: center;
        }
        .table tbody td:last-child .btn:first-child, .table tbody td:last-child .btn-sm:first-child { margin-left: 0; }
        /* Buttons - unified enterprise */
        .btn {
            font-weight: 500;
            letter-spacing: 0.01em;
            border-radius: var(--radius);
            padding: 0.5rem 1rem;
            font-size: 0.9375rem;
            min-height: var(--control-height);
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
        .btn-sm { border-radius: var(--radius); padding: 0.3rem 0.65rem; font-size: 0.75rem; min-height: var(--control-height-sm); line-height: 1.2; }
        .btn-lg { border-radius: var(--radius-lg); padding: 0.625rem 1.25rem; font-size: 1rem; min-height: var(--control-height-lg); }
        .btn-primary {
            background: linear-gradient(180deg, color-mix(in srgb, var(--primary) 92%, #fff) 0%, var(--primary) 100%);
            border: 1px solid color-mix(in srgb, var(--primary) 85%, #000);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 1px 2px color-mix(in srgb, var(--primary) 35%, transparent), 0 2px 8px color-mix(in srgb, var(--primary) 22%, transparent);
        }
        .btn-primary:hover:not(:disabled) {
            background: linear-gradient(180deg, color-mix(in srgb, var(--primary) 100%, #fff) 0%, var(--primary-hover) 100%);
            border-color: color-mix(in srgb, var(--primary-hover) 80%, #000);
            color: #fff;
            box-shadow: 0 2px 6px color-mix(in srgb, var(--primary) 30%, transparent), 0 4px 14px color-mix(in srgb, var(--primary) 25%, transparent);
        }
        .btn-primary:focus-visible { box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--primary); }
        .btn-secondary {
            background: #6c757d;
            border: 1px solid #5c636a;
            color: #fff;
            box-shadow: 0 1px 2px rgba(0,0,0,.06);
        }
        .btn-secondary:hover:not(:disabled) { background: #5c636a; border-color: #565e64; color: #fff; box-shadow: 0 2px 6px rgba(0,0,0,.12); }
        .btn-outline-primary { color: var(--primary); border: 1px solid var(--primary); background: transparent; }
        .btn-outline-primary:hover:not(:disabled) {
            background: color-mix(in srgb, var(--primary) 12%, transparent);
            color: var(--primary-hover);
            border-color: var(--primary);
        }
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
        .btn-success {
            background: var(--btn-success);
            border: 1px solid var(--btn-success-border);
            color: #fff;
            box-shadow: 0 1px 3px rgba(113,221,55,.22);
        }
        .btn-success:hover:not(:disabled) {
            background: var(--btn-success-hover);
            border-color: #57b32a;
            color: #fff;
            box-shadow: 0 4px 12px rgba(113,221,55,.28);
        }
        .btn-warning {
            background: var(--btn-warning);
            border: 1px solid var(--btn-warning-border);
            color: #fff;
            box-shadow: 0 1px 3px rgba(255,171,0,.2);
        }
        .btn-warning:hover:not(:disabled) {
            background: var(--btn-warning-hover);
            border-color: #cc8a00;
            color: #fff;
            box-shadow: 0 4px 12px rgba(255,171,0,.25);
        }
        .btn-info {
            background: var(--btn-info);
            border: 1px solid var(--btn-info-border);
            color: #fff;
            box-shadow: 0 1px 3px rgba(3,195,236,.22);
        }
        .btn-info:hover:not(:disabled) {
            background: var(--btn-info-hover);
            border-color: #029fc0;
            color: #fff;
            box-shadow: 0 4px 12px rgba(3,195,236,.28);
        }
        .btn-dark {
            background: var(--btn-dark);
            border: 1px solid var(--btn-dark-border);
            color: #fff;
            box-shadow: 0 1px 3px rgba(35,52,70,.18);
        }
        .btn-dark:hover:not(:disabled) {
            background: var(--btn-dark-hover);
            border-color: #151f2b;
            color: #fff;
            box-shadow: 0 4px 12px rgba(35,52,70,.22);
        }
        .btn-outline-success {
            color: #61bc29;
            border: 1px solid #61bc29;
            background: transparent;
        }
        .btn-outline-success:hover:not(:disabled) {
            background: rgba(113,221,55,.12);
            color: #4a961f;
            border-color: #4a961f;
        }
        .btn-outline-success:focus-visible { box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgba(113,221,55,.45); }
        .btn-outline-warning {
            color: #e6a200;
            border: 1px solid #ffab00;
            background: transparent;
        }
        .btn-outline-warning:hover:not(:disabled) {
            background: rgba(255,171,0,.12);
            color: #cc9000;
            border-color: #cc9000;
        }
        .btn-outline-warning:focus-visible { box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgba(255,171,0,.45); }
        .btn-outline-info {
            color: #02b0d4;
            border: 1px solid var(--btn-info);
            background: transparent;
        }
        .btn-outline-info:hover:not(:disabled) {
            background: rgba(3,195,236,.12);
            color: #018faf;
            border-color: #018faf;
        }
        .btn-outline-info:focus-visible { box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgba(3,195,236,.4); }
        .btn-outline-dark {
            color: var(--btn-dark);
            border: 1px solid var(--btn-dark);
            background: transparent;
        }
        .btn-outline-dark:hover:not(:disabled) {
            background: rgba(35,52,70,.08);
            color: var(--btn-dark-hover);
            border-color: var(--btn-dark-hover);
        }
        .btn-outline-dark:focus-visible { box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgba(35,52,70,.35); }
        /* Rounded (pill) buttons — Sneat “Rounded” variants */
        .btn.rounded-pill { padding-left: 1.15rem; padding-right: 1.15rem; }
        .btn-sm.rounded-pill { padding-left: 0.85rem; padding-right: 0.85rem; }
        .btn-lg.rounded-pill { padding-left: 1.35rem; padding-right: 1.35rem; }
        .btn-xs.rounded-pill { padding-left: 0.65rem; padding-right: 0.65rem; }
        /* Label buttons (icon chip + label) */
        .btn-label-primary,
        .btn-label-secondary,
        .btn-label-success,
        .btn-label-danger,
        .btn-label-warning,
        .btn-label-info,
        .btn-label-dark {
            box-shadow: none;
            gap: 0;
        }
        .btn-label-primary {
            border: 1px solid rgba(105,108,255,.32);
            background: rgba(105,108,255,.08);
            color: var(--primary);
        }
        .btn-label-primary:hover:not(:disabled) {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 4px 12px rgba(105,108,255,.28);
        }
        .btn-label-secondary {
            border: 1px solid rgba(108,117,125,.35);
            background: rgba(108,117,125,.08);
            color: #6c757d;
        }
        .btn-label-secondary:hover:not(:disabled) {
            background: #6c757d;
            border-color: #5c636a;
            color: #fff;
            box-shadow: 0 4px 12px rgba(108,117,125,.22);
        }
        .btn-label-success {
            border: 1px solid rgba(113,221,55,.4);
            background: rgba(113,221,55,.1);
            color: #57b32a;
        }
        .btn-label-success:hover:not(:disabled) {
            background: var(--btn-success);
            border-color: var(--btn-success-border);
            color: #fff;
            box-shadow: 0 4px 12px rgba(113,221,55,.28);
        }
        .btn-label-danger {
            border: 1px solid rgba(255,62,29,.35);
            background: rgba(255,62,29,.08);
            color: #ff3e1d;
        }
        .btn-label-danger:hover:not(:disabled) {
            background: #dc3545;
            border-color: #c82333;
            color: #fff;
            box-shadow: 0 4px 12px rgba(220,53,69,.25);
        }
        .btn-label-warning {
            border: 1px solid rgba(255,171,0,.4);
            background: rgba(255,171,0,.1);
            color: #e6a200;
        }
        .btn-label-warning:hover:not(:disabled) {
            background: var(--btn-warning);
            border-color: var(--btn-warning-border);
            color: #fff;
            box-shadow: 0 4px 12px rgba(255,171,0,.25);
        }
        .btn-label-info {
            border: 1px solid rgba(3,195,236,.4);
            background: rgba(3,195,236,.1);
            color: #02b0d4;
        }
        .btn-label-info:hover:not(:disabled) {
            background: var(--btn-info);
            border-color: var(--btn-info-border);
            color: #fff;
            box-shadow: 0 4px 12px rgba(3,195,236,.28);
        }
        .btn-label-dark {
            border: 1px solid rgba(35,52,70,.35);
            background: rgba(35,52,70,.08);
            color: var(--btn-dark);
        }
        .btn-label-dark:hover:not(:disabled) {
            background: var(--btn-dark);
            border-color: var(--btn-dark-border);
            color: #fff;
            box-shadow: 0 4px 12px rgba(35,52,70,.2);
        }
        .btn-label-primary > i:first-child,
        .btn-label-secondary > i:first-child,
        .btn-label-success > i:first-child,
        .btn-label-danger > i:first-child,
        .btn-label-warning > i:first-child,
        .btn-label-info > i:first-child,
        .btn-label-dark > i:first-child {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.65rem;
            height: 1.65rem;
            margin-right: 0.45rem;
            margin-left: -0.15rem;
            border-radius: var(--radius);
            font-size: 1rem;
            line-height: 1;
        }
        .btn-label-primary > i:first-child { background: rgba(105,108,255,.22); }
        .btn-label-secondary > i:first-child { background: rgba(108,117,125,.22); }
        .btn-label-success > i:first-child { background: rgba(113,221,55,.22); }
        .btn-label-danger > i:first-child { background: rgba(255,62,29,.2); }
        .btn-label-warning > i:first-child { background: rgba(255,171,0,.22); }
        .btn-label-info > i:first-child { background: rgba(3,195,236,.22); }
        .btn-label-dark > i:first-child { background: rgba(35,52,70,.15); }
        .btn-label-primary:hover:not(:disabled) > i:first-child,
        .btn-label-secondary:hover:not(:disabled) > i:first-child,
        .btn-label-success:hover:not(:disabled) > i:first-child,
        .btn-label-danger:hover:not(:disabled) > i:first-child,
        .btn-label-warning:hover:not(:disabled) > i:first-child,
        .btn-label-info:hover:not(:disabled) > i:first-child,
        .btn-label-dark:hover:not(:disabled) > i:first-child {
            background: rgba(255,255,255,.26);
            color: #fff;
        }
        .btn-sm.btn-label-primary > i:first-child,
        .btn-sm.btn-label-secondary > i:first-child,
        .btn-sm.btn-label-success > i:first-child,
        .btn-sm.btn-label-danger > i:first-child,
        .btn-sm.btn-label-warning > i:first-child,
        .btn-sm.btn-label-info > i:first-child,
        .btn-sm.btn-label-dark > i:first-child {
            width: 1.35rem;
            height: 1.35rem;
            font-size: 0.875rem;
            margin-right: 0.35rem;
        }
        /* Text / ghost buttons */
        .btn-text-primary, .btn-text-secondary, .btn-text-success, .btn-text-danger, .btn-text-warning, .btn-text-info, .btn-text-dark {
            background: transparent !important;
            border: 1px solid transparent !important;
            box-shadow: none !important;
        }
        .btn-text-primary { color: var(--primary) !important; }
        .btn-text-primary:hover:not(:disabled) { background: rgba(105,108,255,.1) !important; color: #5f61e6 !important; }
        .btn-text-secondary { color: #6c757d !important; }
        .btn-text-secondary:hover:not(:disabled) { background: rgba(108,117,125,.1) !important; }
        .btn-text-success { color: #57b32a !important; }
        .btn-text-success:hover:not(:disabled) { background: rgba(113,221,55,.1) !important; }
        .btn-text-danger { color: #ff3e1d !important; }
        .btn-text-danger:hover:not(:disabled) { background: rgba(255,62,29,.1) !important; }
        .btn-text-warning { color: #e6a200 !important; }
        .btn-text-warning:hover:not(:disabled) { background: rgba(255,171,0,.12) !important; }
        .btn-text-info { color: #02b0d4 !important; }
        .btn-text-info:hover:not(:disabled) { background: rgba(3,195,236,.1) !important; }
        .btn-text-dark { color: var(--btn-dark) !important; }
        .btn-text-dark:hover:not(:disabled) { background: rgba(35,52,70,.08) !important; }
        /* Sneat extra sizes (xl / xs) */
        .btn-xs {
            padding: 0.2rem 0.55rem;
            font-size: 0.6875rem;
            min-height: 26px;
            border-radius: var(--radius);
        }
        .btn-xl {
            padding: 0.875rem 1.55rem;
            font-size: 1.0625rem;
            min-height: 48px;
            border-radius: var(--radius-lg);
        }
        /* Icon-only */
        .btn-icon {
            width: var(--control-height);
            height: var(--control-height);
            padding: 0;
            flex-shrink: 0;
        }
        .btn-icon.btn-sm { width: var(--control-height-sm); height: var(--control-height-sm); font-size: 0.9rem; }
        .btn-icon.btn-lg { width: var(--control-height-lg); height: var(--control-height-lg); font-size: 1.15rem; }
        .btn-icon.btn-xs { width: 26px; height: 26px; font-size: 0.8rem; }
        .btn-icon.btn-xl { width: 48px; height: 48px; font-size: 1.2rem; }
        /* Social (Sneat social section) — use e.g. class="btn btn-sm btn-social btn-facebook" */
        .btn-social, .btn-social-icon {
            color: #fff !important;
            border: 0;
            font-weight: 500;
            box-shadow: 0 1px 4px rgba(0,0,0,.12);
        }
        .btn-social:hover:not(:disabled), .btn-social-icon:hover:not(:disabled) {
            filter: brightness(1.06);
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
            color: #fff !important;
        }
        .btn-social-icon { width: 38px; height: 38px; padding: 0; border-radius: var(--radius); }
        .btn-social-icon.btn-sm { width: 32px; height: 32px; }
        .btn-facebook { background: #3b5998; }
        .btn-twitter { background: #1da1f2; }
        .btn-google { background: #dd4b39; }
        .btn-instagram { background: #e1306c; }
        .btn-linkedin { background: #0077b5; }
        .btn-github { background: #333; }
        .btn-pinterest { background: #cb2027; }
        .btn-slack { background: #4a154b; }
        .btn-dribbble { background: #ea4c89; }
        .btn-reddit { background: #ff4500; }
        .btn-youtube { background: #ff0000; }
        .btn-vimeo { background: #1ab7ea; }
        /* Toggle / checkbox button groups (Bootstrap btn-check) */
        .btn-check:checked + .btn.btn-primary { background: var(--primary-hover); border-color: color-mix(in srgb, var(--primary-hover) 82%, #000); }
        .btn-check:checked + .btn.btn-outline-primary { background: var(--primary); border-color: var(--primary); color: #fff; }
        .btn-check:checked + .btn.btn-outline-secondary { background: #6c757d; border-color: #5c636a; color: #fff; }
        .btn-check:focus-visible + .btn { box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--primary); }
        /* Button groups — Sneat-like tight radius */
        .btn-group > .btn:not(:first-child) { margin-left: -1px; }
        .btn-group > .btn:focus { z-index: 3; }
        /* Module list actions — Sneat “rounded” row buttons (no Blade edits required) */
        .btn.btn-sm.btn-view,
        .btn.btn-sm.btn-edit,
        .btn.btn-sm.btn-delete {
            border-radius: 999px;
            font-weight: 500;
        }
        /* Badges - Sneat style (status pills) */
        .badge {
            font-weight: 600;
            padding: .4rem .68rem;
            border-radius: 999px;
            font-size: .75rem;
            letter-spacing: .01em;
            line-height: 1.1;
            min-height: 1.4rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .badge.bg-success { background: rgba(105,208,27,.16) !important; color: #71dd37; }
        .badge.bg-info { background: rgba(3,195,236,.16) !important; color: #03c3ec; }
        .badge.bg-warning { background: rgba(255,171,0,.16) !important; color: #ffab00; }
        .badge.bg-danger { background: rgba(255,62,29,.16) !important; color: #ff3e1d; }
        .badge.bg-primary { background: rgba(105,108,255,.16) !important; color: var(--primary); }
        .badge.bg-secondary { background: rgba(105,108,255,.12) !important; color: #697a8d; }
        /* Forms — one default height for single-line fields; exceptions below */
        .form-label { font-weight: 500; color: var(--text-body); font-size: 0.875rem; margin-bottom: 0.375rem; }
        .form-control, .form-select {
            border-radius: var(--radius); border: 1px solid var(--border-color);
            padding: 0.5rem 0.875rem; font-size: 0.9375rem;
            background: var(--input-bg); color: var(--text-body);
            line-height: 1.35;
        }
        input.form-control:not([type="file"]):not([type="range"]):not(.form-control-sm):not(.form-control-lg):not(.form-control-plaintext),
        .form-floating > .form-control:not(textarea):not(.form-control-sm):not(.form-control-lg) {
            min-height: var(--control-height);
        }
        input.form-control:not([type="file"]):not([type="range"]):not(.form-control-sm):not(.form-control-lg):not(.form-control-plaintext) {
            height: var(--control-height);
        }
        .form-select:not([multiple]):not([size]):not(.form-select-sm):not(.form-select-lg) {
            height: var(--control-height);
            min-height: var(--control-height);
        }
        textarea.form-control {
            height: auto;
            min-height: 5.5rem;
        }
        input.form-control[type="file"] {
            height: auto;
            min-height: var(--control-height);
            padding-top: 0.4rem;
            padding-bottom: 0.4rem;
            line-height: 1.25;
        }
        input.form-control[type="range"] {
            height: auto;
            min-height: 0;
            padding: 0.5rem 0;
        }
        select.form-select[multiple],
        select.form-select[size]:not([size="1"]) {
            height: auto;
            min-height: var(--control-height);
        }
        select.form-select[size="1"]:not([multiple]) {
            height: var(--control-height);
            min-height: var(--control-height);
        }
        .form-control-sm {
            min-height: var(--control-height-sm);
            padding-top: 0.28rem;
            padding-bottom: 0.28rem;
            font-size: 0.8125rem;
        }
        input.form-control-sm:not([type="file"]):not([type="range"]) { height: var(--control-height-sm); }
        .form-select-sm:not([multiple]):not([size]) {
            height: var(--control-height-sm);
            min-height: var(--control-height-sm);
            padding-top: 0.28rem;
            padding-bottom: 0.28rem;
            font-size: 0.8125rem;
        }
        .form-control-lg {
            min-height: var(--control-height-lg);
            padding-top: 0.625rem;
            padding-bottom: 0.625rem;
            font-size: 1rem;
        }
        input.form-control-lg:not([type="file"]):not([type="range"]) { height: var(--control-height-lg); }
        .form-select-lg:not([multiple]):not([size]) {
            height: var(--control-height-lg);
            min-height: var(--control-height-lg);
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
            border-radius: var(--radius);
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
        .input-group:not(.input-group-sm):not(.input-group-lg) > .input-group-text,
        .input-group:not(.input-group-sm):not(.input-group-lg) > .form-control:not(textarea),
        .input-group:not(.input-group-sm):not(.input-group-lg) > .form-select:not([multiple]):not([size]) {
            min-height: var(--control-height);
        }
        .input-group:not(.input-group-sm):not(.input-group-lg) > .form-control:not(textarea):not([type="file"]) { height: var(--control-height); }
        .input-group:not(.input-group-sm):not(.input-group-lg) > .form-select:not([multiple]):not([size]) { height: var(--control-height); }
        .input-group-sm > .input-group-text,
        .input-group-sm > .form-control:not(textarea),
        .input-group-sm > .form-select:not([multiple]):not([size]) {
            min-height: var(--control-height-sm);
        }
        .input-group-sm > .form-control:not(textarea):not([type="file"]) { height: var(--control-height-sm); }
        .input-group-sm > .form-select:not([multiple]):not([size]) { height: var(--control-height-sm); }
        .input-group-lg > .input-group-text,
        .input-group-lg > .form-control:not(textarea),
        .input-group-lg > .form-select:not([multiple]):not([size]) {
            min-height: var(--control-height-lg);
        }
        .input-group-lg > .form-control:not(textarea):not([type="file"]) { height: var(--control-height-lg); }
        .input-group-lg > .form-select:not([multiple]):not([size]) { height: var(--control-height-lg); }
        .input-group-text { border-radius: var(--radius); border: 1px solid var(--border-color); background: #fafbfc; color: var(--text-muted); padding: 0.5rem 0.875rem; display: flex; align-items: center; }
        .input-group .form-control { border-left: 0; }
        .input-group .input-group-text + .form-control { border-left: 1px solid var(--border-color); }
        .form-text, .invalid-feedback { font-size: 0.8125rem; }
        .mb-3 > .form-control, .mb-3 > .form-select { margin-top: 0.125rem; }
        .page-title { font-size: 1.5rem; font-weight: 600; color: var(--text-body); }
        /* Kanban: maximize space, flexible columns, single scroll area */
        .kanban-page-layout { display: flex; flex-direction: column; flex: 1; min-height: 0; }
        .kanban-page-layout #kanban-board-container { display: flex; flex-direction: column; flex: 1; min-height: 0; }
        /* Dropdown triggers (aligned with global radius tokens) */
        .kanban-toolbar-dropdown .kanban-board-dropdown-btn,
        #app-main-content .dropdown > button.dropdown-toggle.btn-outline-secondary,
        #app-main-content .dropdown > button.dropdown-toggle.btn-secondary,
        #app-main-content .dropdown > button.dropdown-toggle.btn-light,
        #app-main-content .dropdown > button.dropdown-toggle.btn-dark,
        #crudModal .dropdown > button.dropdown-toggle.btn-outline-secondary,
        #crudModal .dropdown > button.dropdown-toggle.btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.42rem 1rem 0.42rem 0.85rem;
            font-weight: 600;
            font-size: 0.875rem;
            line-height: 1.25;
            color: var(--text-body);
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            transition: border-color .2s ease, background .2s ease, box-shadow .2s ease, transform .15s ease;
        }
        .kanban-toolbar-dropdown .kanban-board-dropdown-btn:hover,
        #app-main-content .dropdown > button.dropdown-toggle.btn-outline-secondary:hover,
        #app-main-content .dropdown > button.dropdown-toggle.btn-secondary:hover,
        #app-main-content .dropdown > button.dropdown-toggle.btn-light:hover,
        #app-main-content .dropdown > button.dropdown-toggle.btn-dark:hover,
        #crudModal .dropdown > button.dropdown-toggle.btn-outline-secondary:hover,
        #crudModal .dropdown > button.dropdown-toggle.btn-secondary:hover {
            border-color: color-mix(in srgb, var(--primary) 38%, var(--border-color));
            background: color-mix(in srgb, var(--primary) 7%, var(--input-bg));
            box-shadow: 0 2px 10px color-mix(in srgb, var(--primary) 12%, transparent);
        }
        .kanban-toolbar-dropdown .kanban-board-dropdown-btn:active,
        #app-main-content .dropdown > button.dropdown-toggle.btn-outline-secondary:active,
        #app-main-content .dropdown > button.dropdown-toggle.btn-secondary:active,
        #app-main-content .dropdown > button.dropdown-toggle.btn-light:active,
        #app-main-content .dropdown > button.dropdown-toggle.btn-dark:active {
            transform: scale(0.98);
        }
        .kanban-toolbar-dropdown .kanban-board-dropdown-btn.show,
        #app-main-content .dropdown > button.dropdown-toggle.show.btn-outline-secondary,
        #app-main-content .dropdown > button.dropdown-toggle.show.btn-secondary,
        #app-main-content .dropdown > button.dropdown-toggle.show.btn-light,
        #app-main-content .dropdown > button.dropdown-toggle.show.btn-dark,
        #crudModal .dropdown > button.dropdown-toggle.show.btn-outline-secondary,
        #crudModal .dropdown > button.dropdown-toggle.show.btn-secondary {
            border-color: color-mix(in srgb, var(--primary) 45%, var(--border-color));
            background: color-mix(in srgb, var(--primary) 10%, var(--input-bg));
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--primary) 16%, transparent);
        }
        .kanban-toolbar-dropdown .kanban-board-dropdown-btn .badge,
        #app-main-content .dropdown > button.dropdown-toggle .badge,
        #crudModal .dropdown > button.dropdown-toggle .badge {
            font-weight: 600;
            font-size: 0.65rem;
            letter-spacing: 0.03em;
            padding: 0.28em 0.55em;
            border-radius: var(--radius) !important;
        }
        .kanban-toolbar-dropdown .kanban-board-dropdown-btn.dropdown-toggle::after,
        #app-main-content .dropdown > button.dropdown-toggle.btn-outline-secondary::after,
        #app-main-content .dropdown > button.dropdown-toggle.btn-secondary::after,
        #app-main-content .dropdown > button.dropdown-toggle.btn-light::after,
        #app-main-content .dropdown > button.dropdown-toggle.btn-dark::after,
        #crudModal .dropdown > button.dropdown-toggle.btn-outline-secondary::after,
        #crudModal .dropdown > button.dropdown-toggle.btn-secondary::after {
            margin-left: 0.15rem;
            opacity: 0.5;
            transition: transform .22s ease, opacity .2s ease;
        }
        .kanban-toolbar-dropdown .kanban-board-dropdown-btn.show.dropdown-toggle::after,
        #app-main-content .dropdown > button.dropdown-toggle.show::after,
        #crudModal .dropdown > button.dropdown-toggle.show::after {
            transform: rotate(-180deg);
            opacity: 0.85;
        }
        .kanban-board-dropdown-menu {
            min-width: min(100vw - 2rem, 300px);
            max-height: min(58vh, 360px);
            overflow-y: auto;
        }
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
            color: var(--text-body);
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
        .table-responsive {
            border-radius: 0;
            overflow-x: auto;
            overflow-y: hidden;
            max-width: 100%;
            scrollbar-width: thin;
            scrollbar-color: rgba(0,0,0,.22) transparent;
            background: #fff;
            animation: tableFadeIn .28s ease both;
        }
        .table-responsive::-webkit-scrollbar { width: 6px; height: 6px; }
        .table-responsive::-webkit-scrollbar-track { background: transparent; border-radius: 3px; }
        .table-responsive::-webkit-scrollbar-thumb { background: rgba(0,0,0,.22); border-radius: 3px; }
        .table-responsive::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,.35); }
        .card .table-responsive { margin: 0; }
        .card .table { margin-bottom: 0; }
        .card .table thead th:first-child { border-top-left-radius: 0; }
        .card .table thead th:last-child { border-top-right-radius: 0; }
        .app-main-inner > * { min-width: 0; }
        .app-main-loading {
            transition: opacity 0.38s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.38s step-end;
            opacity: 0;
            pointer-events: none;
            visibility: hidden;
            background: rgba(255, 255, 255, 0.78) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .app-main-loading.is-visible {
            opacity: 1;
            pointer-events: auto;
            visibility: visible;
            transition: opacity 0.32s cubic-bezier(0.4, 0, 0.2, 1), visibility 0s step-start;
        }
        .taskflow-module-loader {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.125rem;
        }
        .taskflow-loader-rings {
            position: relative;
            width: 52px;
            height: 52px;
        }
        .taskflow-loader-rings::before,
        .taskflow-loader-rings::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 2px solid transparent;
            border-top-color: var(--primary);
            animation: taskflowLoaderSpin 0.85s linear infinite;
        }
        .taskflow-loader-rings::after {
            inset: 7px;
            border-top-color: color-mix(in srgb, var(--primary) 50%, #a78bfa);
            animation-duration: 1.15s;
            animation-direction: reverse;
        }
        @keyframes taskflowLoaderSpin {
            to { transform: rotate(360deg); }
        }
        .taskflow-loader-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            animation: taskflowLoaderPulse 1.15s ease-in-out infinite;
        }
        @keyframes taskflowLoaderPulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
        @media (prefers-reduced-motion: reduce) {
            .app-main-loading {
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
                transition: opacity 0.12s ease;
            }
            .taskflow-loader-rings::before,
            .taskflow-loader-rings::after {
                animation: none;
                border-color: color-mix(in srgb, var(--primary) 35%, transparent);
                border-top-color: var(--primary);
            }
            .taskflow-loader-label { animation: none; opacity: 0.85; }
        }
        .pagination { gap: 0.25rem; }
        .pagination .page-link {
            border-radius: var(--radius) !important;
            border: 1px solid #e6e9f0;
            color: #6b7280;
            min-width: 2rem;
            height: 2rem;
            padding: 0.25rem 0.55rem;
            font-size: 0.8125rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
        }
        .pagination .page-item:not(.active) .page-link:hover {
            background: #f3f4f8;
            border-color: #dfe4ec;
            color: #4b5563;
        }
        .pagination .page-item.active .page-link { background: var(--primary); border-color: var(--primary); color: #fff; }
        .dropdown-menu {
            padding: 0.35rem;
            margin-top: 0.35rem !important;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-lg);
            background: var(--input-bg);
        }
        .dropdown-item {
            border-radius: var(--radius);
            margin: 0.15rem 0.1rem;
            padding: 0.5rem 0.85rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background .15s ease, color .15s ease;
        }
        /* Badges inside menus (templates often use rounded-pill) */
        .dropdown-menu .badge.rounded-pill,
        .dropdown-item .badge.rounded-pill {
            border-radius: var(--radius) !important;
        }
        .dropdown-item:not(.active):hover,
        .dropdown-item:not(.active):focus {
            background: var(--sidebar-hover);
            color: var(--text-body);
        }
        .dropdown-item.active {
            background: color-mix(in srgb, var(--primary) 14%, transparent);
            color: var(--primary);
            font-weight: 600;
        }
        .dropdown-item.active .badge { opacity: 0.95; }
        .dropdown-menu .dropdown-header {
            border-radius: var(--radius);
            margin: 0.15rem 0.35rem 0.35rem;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        .dropdown-menu .dropdown-divider {
            margin: 0.35rem 0.5rem;
            opacity: 0.85;
        }
        #toast-container { position: fixed; top: calc(var(--header-height) + 16px); right: 16px; z-index: 9999; }
        .toast-custom { min-width: 300px; box-shadow: var(--shadow-lg); border-radius: var(--radius-lg); }
        #crudModal .modal-dialog { max-width: 560px; }
        #crudModal .modal-dialog.modal-lg { max-width: min(920px, calc(100vw - 2rem)); }
        .issue-modal-description { font-size: 0.9375rem; line-height: 1.6; word-break: break-word; overflow-wrap: anywhere; }
        .issue-modal-description p:last-child { margin-bottom: 0; }
        .issue-modal-description p { margin-bottom: 0.5rem; }
        .issue-modal-description ul,
        .issue-modal-description ol { margin-bottom: 0.5rem; padding-left: 1.25rem; }
        .issue-modal-description pre,
        .issue-modal-description code { font-size: 0.875em; }
        #crudModal .modal-content { border: none; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); }
        #crudModal .modal-header { border-bottom: 1px solid var(--border-light); padding: 1rem 1.5rem; }
        #crudModal .modal-body { padding: 1.25rem 1.5rem; max-height: 70vh; overflow-y: auto; }
        #crudModal .modal-body.scrollable { scrollbar-width: thin; }
        #crudModal .modal-footer { border-top: 1px solid var(--border-light); padding: 1rem 1.5rem; }
        /* Modal open/close motion */
        .modal.fade .modal-dialog {
            transform: translateY(10px) scale(.98);
            opacity: 0;
            transition: transform .22s ease, opacity .22s ease;
        }
        .modal.show .modal-dialog {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
        .modal.fade .modal-content {
            transition: box-shadow .22s ease, transform .22s ease;
        }
        .modal.show .modal-content {
            box-shadow: 0 14px 30px -14px rgba(15,23,42,.35), 0 8px 18px -12px rgba(15,23,42,.22);
        }
        .modal-backdrop.fade {
            opacity: 0;
            transition: opacity .2s ease;
        }
        .modal-backdrop.show {
            opacity: .38;
        }
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
        .setup-list-card > .card-header { display: none !important; }
        .setup-list-card .card { border: 1px solid var(--border-light); }
        /* Setup tables: scrollable body with max height */
        .setup-list-card .card-body {
            max-height: none;
            overflow: visible;
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
            padding: 0.875rem 1.4rem;
            margin-bottom: 0;
            background: linear-gradient(to bottom, #f8f9fa 0%, #fafbfc 100%);
            border-bottom: 1px solid var(--border-light);
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            flex-shrink: 0;
        }
        .setup-filter-form.setup-table-controls {
            padding: 1.125rem 1.5rem;
            gap: 0.625rem 1.25rem;
        }
        /* Table list footer: more breathing room, align with toolbar strip */
        .setup-table-footer.card-footer {
            padding: 1.125rem 1.5rem;
            border-top: 1px solid var(--border-light) !important;
            background: linear-gradient(to top, #f4f6f9 0%, #fff 50%);
        }
        /* Toolbar native selects — match dropdown-toggle chrome (all setup/list toolbars) */
        .setup-filter-form .form-select:not([multiple]):not([size]),
        .issues-toolbar-filters .form-select:not([multiple]):not([size]) {
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            background: var(--input-bg);
            box-shadow: var(--shadow-sm);
            font-weight: 600;
            color: var(--text-body);
            transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
        }
        .setup-filter-form .form-select:not([multiple]):not([size]):focus,
        .issues-toolbar-filters .form-select:not([multiple]):not([size]):focus {
            border-color: color-mix(in srgb, var(--primary) 45%, var(--border-color));
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--primary) 16%, transparent), var(--shadow-sm);
            outline: 0;
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
        .setup-filter-form .form-select:not([multiple]):not([size]):not(.form-select-sm):not(.form-select-lg) {
            min-width: 200px;
            background-position: right 0.5rem center;
            font-size: 0.8125rem;
            height: 34px;
            min-height: 34px;
            padding-top: 0.35rem;
            padding-bottom: 0.35rem;
        }
        .setup-filter-form .form-select.form-select-sm:not([multiple]):not([size]) {
            height: var(--control-height-sm);
            min-height: var(--control-height-sm);
            font-size: 0.8125rem;
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
            min-width: 4.5rem;
        }
        .setup-filter-form .btn-reset-filter {
            padding: 0.3rem 0.65rem;
            font-size: 0.75rem;
            min-height: 32px;
        }
        /* Second row (filter by role / user / …): don’t stretch selects full-width */
        .setup-filter-form.setup-filter-inline {
            justify-content: flex-start;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem 0.75rem;
        }
        .setup-filter-form.setup-filter-inline .setup-filter-form-label {
            margin-bottom: 0;
            flex-shrink: 0;
        }
        .setup-filter-form.setup-filter-inline .form-select.form-select-sm:not([multiple]):not([size]) {
            width: auto;
            min-width: 11rem;
            max-width: 22rem;
            flex: 0 1 16rem;
        }
        .setup-filter-form.setup-filter-inline .btn-reset-filter {
            flex-shrink: 0;
            align-self: center;
        }
        .setup-table-controls .form-control:not(textarea):not(.form-control-sm):not(.form-control-lg) {
            height: 34px;
            min-height: 34px;
            font-size: 0.8125rem;
            min-width: 180px;
        }
        .setup-table-controls .form-control.form-control-sm:not(textarea) {
            height: var(--control-height-sm);
            min-height: var(--control-height-sm);
            font-size: 0.8125rem;
            min-width: 140px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            font-weight: 500;
        }
        .setup-table-controls .form-control.form-control-sm:not(textarea):focus {
            border-color: color-mix(in srgb, var(--primary) 45%, var(--border-color));
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--primary) 16%, transparent), var(--shadow-sm);
            outline: 0;
        }
        .setup-table-controls .btn-sm { min-height: 32px; }
        .setup-table-footer .pagination { margin-bottom: 0; }
        .setup-list-card .table td .btn,
        .setup-list-card .table td .btn-sm { min-width: 58px; }
        @keyframes tableFadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (prefers-reduced-motion: reduce) {
            .table-responsive,
            .table tbody tr,
            .app-sidebar .nav-link,
            .app-sidebar .nav-section-toggle,
            .app-sidebar .nav-link .nav-label {
                animation: none !important;
                transition: none !important;
                transform: none !important;
            }
        }
        /* Sidebar toggle (desktop): framed control + icon crossfade */
        .app-header .sidebar-toggle-btn {
            --st-size: 2.5rem;
            width: var(--st-size);
            height: var(--st-size);
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--text-body);
            text-decoration: none;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            transition: background .2s ease, border-color .2s ease, box-shadow .2s ease, transform .18s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .app-header .sidebar-toggle-btn:hover {
            background: color-mix(in srgb, var(--primary) 9%, var(--input-bg));
            border-color: color-mix(in srgb, var(--primary) 32%, var(--border-color));
            box-shadow: 0 2px 10px color-mix(in srgb, var(--primary) 14%, transparent);
            transform: scale(1.05);
        }
        .app-header .sidebar-toggle-btn:active {
            transform: scale(0.94);
        }
        body.sidebar-collapsed .app-header .sidebar-toggle-btn {
            background: color-mix(in srgb, var(--primary) 12%, var(--input-bg));
            border-color: color-mix(in srgb, var(--primary) 28%, var(--border-color));
        }
        .sidebar-toggle-icon-wrap {
            position: relative;
            width: 1.35rem;
            height: 1.35rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sidebar-toggle-icon-wrap i {
            position: absolute;
            font-size: 1.15rem;
            line-height: 1;
            transition: opacity .22s ease, transform .22s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-toggle-icon-expanded {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }
        .sidebar-toggle-icon-collapsed {
            opacity: 0;
            transform: scale(0.65) rotate(-12deg);
            pointer-events: none;
        }
        body.sidebar-collapsed .sidebar-toggle-icon-expanded {
            opacity: 0;
            transform: scale(0.65) rotate(12deg);
        }
        body.sidebar-collapsed .sidebar-toggle-icon-collapsed {
            opacity: 1;
            transform: scale(1) rotate(0deg);
            pointer-events: auto;
        }
        /* Mobile drawer toggle — match visual weight */
        .app-header .sidebar-toggle-btn--mobile {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            background: var(--input-bg);
            box-shadow: var(--shadow-sm);
            color: var(--text-body);
            transition: background .2s ease, border-color .2s ease, transform .15s ease;
        }
        .app-header .sidebar-toggle-btn--mobile:hover {
            background: color-mix(in srgb, var(--primary) 9%, var(--input-bg));
            border-color: color-mix(in srgb, var(--primary) 28%, var(--border-color));
        }
        .app-header .sidebar-toggle-btn--mobile:active {
            transform: scale(0.94);
        }
        @media (prefers-reduced-motion: reduce) {
            .app-header .sidebar-toggle-btn,
            .app-header .sidebar-toggle-btn--mobile,
            .sidebar-toggle-icon-wrap i,
            .app-main,
            .app-header {
                transition: none !important;
            }
            .app-header .sidebar-toggle-btn:hover,
            .app-header .sidebar-toggle-btn:active {
                transform: none;
            }
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
        body.sidebar-collapsed .app-sidebar .nav-section-toggle:hover {
            background: color-mix(in srgb, var(--primary) 14%, transparent) !important;
        }
        body.sidebar-collapsed .app-sidebar .nav-section-toggle:active {
            transform: scale(0.96);
        }
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
        <button class="btn d-lg-none me-2 p-0 border-0 sidebar-toggle-btn sidebar-toggle-btn--mobile" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-label="Open menu">
            <i class="bi bi-list fs-5"></i>
        </button>
        <button class="d-none d-lg-inline-flex me-2 sidebar-toggle-btn" type="button" data-sidebar-toggle aria-label="Toggle sidebar" aria-expanded="true" title="Collapse sidebar">
            <span class="sidebar-toggle-icon-wrap" aria-hidden="true">
                <i class="bi bi-layout-sidebar-inset sidebar-toggle-icon-expanded"></i>
                <i class="bi bi-layout-sidebar sidebar-toggle-icon-collapsed"></i>
            </span>
        </button>
        @auth
        <button type="button" class="global-search-mobile-trigger d-md-none me-2" data-bs-toggle="modal" data-bs-target="#globalSearchModal" aria-label="Open search">
            <i class="bi bi-search"></i>
        </button>
        <div class="header-search position-relative d-none d-md-flex">
            <i class="bi bi-search position-absolute search-icon top-50 translate-middle-y" aria-hidden="true"></i>
            <button type="button" class="header-search-trigger" data-bs-toggle="modal" data-bs-target="#globalSearchModal" aria-label="Open search">
                Search across TaskFlow…
            </button>
        </div>
        @endauth
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
                    <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 200px;">
                        <li><h6 class="dropdown-header text-uppercase small px-3 mb-1">Theme</h6></li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center gap-2 taskflow-theme-option" data-taskflow-theme="light" aria-pressed="false">
                                <i class="bi bi-sun text-warning"></i><span>Light</span><i class="bi bi-check2 ms-auto taskflow-theme-check d-none"></i>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center gap-2 taskflow-theme-option" data-taskflow-theme="dark" aria-pressed="false">
                                <i class="bi bi-moon-stars"></i><span>Dark</span><i class="bi bi-check2 ms-auto taskflow-theme-check d-none"></i>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center gap-2 taskflow-theme-option" data-taskflow-theme="ocean" aria-pressed="false">
                                <i class="bi bi-droplet text-info"></i><span>Ocean</span><i class="bi bi-check2 ms-auto taskflow-theme-check d-none"></i>
                            </button>
                        </li>
                        <li><hr class="dropdown-divider"></li>
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

    @auth
    <div class="modal fade global-search-modal" id="globalSearchModal" tabindex="-1" aria-labelledby="globalSearchModalLabel" aria-hidden="true" data-search-url="{{ route('search.global') }}">
        <div class="modal-dialog modal-dialog-centered global-search-modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-semibold mb-0" id="globalSearchModalLabel">Search TaskFlow</h5>
                        <p class="text-muted small mb-0 mt-1">Search issues, projects, teams, boards, sprints, and users</p>
                    </div>
                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="position-relative global-search-field-wrap">
                        <i class="bi bi-search global-search-input-icon position-absolute text-muted" aria-hidden="true"></i>
                        <input type="search" class="form-control form-control-lg" id="globalSearchInput" placeholder="Search across TaskFlow…" autocomplete="off" aria-label="Search query">
                    </div>
                    <div class="global-search-type-checks" role="group" aria-label="Categories to search">
                        <span class="global-search-types-label text-muted fw-semibold text-uppercase">Search in</span>
                        <div class="form-check">
                            <input class="form-check-input global-search-type-cb" type="checkbox" value="issues" id="gsc-issues" checked autocomplete="off">
                            <label class="form-check-label" for="gsc-issues">Issues</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input global-search-type-cb" type="checkbox" value="projects" id="gsc-projects" checked autocomplete="off">
                            <label class="form-check-label" for="gsc-projects">Projects</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input global-search-type-cb" type="checkbox" value="users" id="gsc-users" checked autocomplete="off">
                            <label class="form-check-label" for="gsc-users">Users</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input global-search-type-cb" type="checkbox" value="teams" id="gsc-teams" checked autocomplete="off">
                            <label class="form-check-label" for="gsc-teams">Teams</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input global-search-type-cb" type="checkbox" value="sprints" id="gsc-sprints" checked autocomplete="off">
                            <label class="form-check-label" for="gsc-sprints">Sprints</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input global-search-type-cb" type="checkbox" value="boards" id="gsc-boards" checked autocomplete="off">
                            <label class="form-check-label" for="gsc-boards">Boards</label>
                        </div>
                    </div>
                    <div id="globalSearchResults" class="global-search-results"></div>
                    <p class="text-muted small global-search-hint pt-2" id="globalSearchHint">Type at least 2 characters. Shortcut: <kbd class="px-1 rounded border bg-light text-dark" style="font-size:0.7rem;">Ctrl</kbd>+<kbd class="px-1 rounded border bg-light text-dark" style="font-size:0.7rem;">K</kbd></p>
                </div>
            </div>
        </div>
    </div>
    @endauth

    <main class="app-main position-relative" id="app-main">
        <div class="app-main-loading position-absolute top-0 start-0 end-0 bottom-0 d-flex align-items-center justify-content-center d-none" id="app-main-loading" style="z-index: 15; border-radius: var(--radius-lg);" aria-hidden="true">
            <div class="taskflow-module-loader text-center px-4" id="app-main-loading-inner" role="status" aria-live="polite" aria-busy="false">
                <div class="taskflow-loader-rings mx-auto" aria-hidden="true"></div>
                <span class="taskflow-loader-label">Loading module</span>
                <span class="visually-hidden">Loading content, please wait.</span>
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
        applyTheme(name) {
            var n = (name === 'dark' || name === 'ocean') ? name : 'light';
            var html = document.documentElement;
            html.setAttribute('data-theme', n);
            html.setAttribute('data-bs-theme', n === 'dark' ? 'dark' : 'light');
            try { localStorage.setItem('taskflow-theme', n); } catch (e) {}
            document.querySelectorAll('.taskflow-theme-option').forEach(function(btn) {
                var on = btn.getAttribute('data-taskflow-theme') === n;
                btn.setAttribute('aria-pressed', on ? 'true' : 'false');
                var ch = btn.querySelector('.taskflow-theme-check');
                if (ch) ch.classList.toggle('d-none', !on);
            });
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
        (function initTaskflowTheme() {
            var t = 'light';
            try { t = localStorage.getItem('taskflow-theme') || 'light'; } catch (e) {}
            if (t !== 'dark' && t !== 'ocean') t = 'light';
            TaskFlow.applyTheme(t);
            document.querySelectorAll('.taskflow-theme-option').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var name = btn.getAttribute('data-taskflow-theme');
                    if (name) TaskFlow.applyTheme(name);
                });
            });
        })();
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
            function syncSidebarToggleUi() {
                var expanded = !body.classList.contains('sidebar-collapsed');
                toggleButtons.forEach(function(btn) {
                    btn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                    btn.setAttribute('title', expanded ? 'Collapse sidebar' : 'Expand sidebar');
                });
            }
            function applyState(fromStorage) {
                var collapsed = false;
                if (fromStorage) {
                    collapsed = localStorage.getItem(STORAGE_KEY) === '1';
                } else {
                    collapsed = body.classList.contains('sidebar-collapsed');
                }
                if (collapsed) body.classList.add('sidebar-collapsed');
                else body.classList.remove('sidebar-collapsed');
                syncSidebarToggleUi();
            }
            applyState(true);
            toggleButtons.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    body.classList.toggle('sidebar-collapsed');
                    var collapsed = body.classList.contains('sidebar-collapsed');
                    try { localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0'); } catch (err) {}
                    syncSidebarToggleUi();
                });
            });
        })();
        // Collapsed rail: clicking Setup expands sidebar and opens Setup list (capture so Bootstrap collapse doesn’t fight CSS-hidden panel)
        (function setupNavExpandWhenSidebarCollapsed() {
            var btn = document.querySelector('.nav-section-setup .nav-section-toggle[data-bs-target="#setupNav"]');
            if (!btn) return;
            btn.addEventListener('click', function(e) {
                if (!document.body.classList.contains('sidebar-collapsed')) return;
                e.preventDefault();
                e.stopPropagation();
                document.body.classList.remove('sidebar-collapsed');
                try { localStorage.setItem('taskflow_sidebar_collapsed', '0'); } catch (err) {}
                document.querySelectorAll('[data-sidebar-toggle]').forEach(function(b) {
                    b.setAttribute('aria-expanded', 'true');
                    b.setAttribute('title', 'Collapse sidebar');
                });
                var setupNav = document.getElementById('setupNav');
                if (setupNav && typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
                    var inst = bootstrap.Collapse.getOrCreateInstance(setupNav, { toggle: false });
                    inst.show();
                }
                btn.setAttribute('aria-expanded', 'true');
            }, true);
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
        (function initGlobalSearch() {
            var modalEl = document.getElementById('globalSearchModal');
            if (!modalEl || typeof bootstrap === 'undefined') return;
            var searchUrl = modalEl.getAttribute('data-search-url');
            if (!searchUrl) return;
            var input = document.getElementById('globalSearchInput');
            var resultsEl = document.getElementById('globalSearchResults');
            var hintEl = document.getElementById('globalSearchHint');
            var requestGen = 0;
            var debounceTimer = null;
            function selectedTypes() {
                var out = [];
                modalEl.querySelectorAll('.global-search-type-cb:checked').forEach(function(cb) {
                    out.push(cb.value);
                });
                return out;
            }
            function escapeHtml(s) {
                if (s == null || s === '') return '';
                var div = document.createElement('div');
                div.textContent = String(s);
                return div.innerHTML;
            }
            function sectionBlock(title, inner) {
                if (!inner) return '';
                return '<div class="global-search-section">' +
                    '<div class="global-search-section-title">' + escapeHtml(title) + '</div>' +
                    '<div class="global-search-hit-list">' + inner + '</div></div>';
            }
            function render(data) {
                var wanted = selectedTypes();
                var q = (input && input.value || '').trim();
                var parts = [];
                function issueHits(items) {
                    return (items || []).map(function(i) {
                        return '<a class="global-search-hit" href="' + escapeHtml(i.url) + '" data-search-result="1">' +
                            '<div class="global-search-hit-main">' +
                            '<div class="global-search-hit-line1">' +
                            '<span class="global-search-hit-key">' + escapeHtml(i.issue_key) + '</span>' +
                            (i.project_name ? '<span class="global-search-hit-meta">' + escapeHtml(i.project_name) + '</span>' : '') +
                            '<span class="global-search-hit-kind ms-auto">Issue</span></div>' +
                            '<div class="global-search-hit-line2">' + escapeHtml(i.summary) + '</div></div></a>';
                    }).join('');
                }
                function projectHits(items) {
                    return (items || []).map(function(p) {
                        var keyBadge = p.project_key
                            ? '<span class="badge bg-secondary">' + escapeHtml(p.project_key) + '</span>'
                            : '';
                        return '<a class="global-search-hit" href="' + escapeHtml(p.url) + '" data-search-result="1">' +
                            '<div class="global-search-hit-main">' +
                            '<div class="global-search-hit-line1">' + keyBadge +
                            '<span class="global-search-hit-title">' + escapeHtml(p.name) + '</span>' +
                            '<span class="global-search-hit-kind ms-auto">Project</span></div></div></a>';
                    }).join('');
                }
                function userHits(items) {
                    return (items || []).map(function(u) {
                        return '<a class="global-search-hit" href="' + escapeHtml(u.url) + '" data-search-result="1">' +
                            '<div class="global-search-hit-main">' +
                            '<div class="global-search-hit-line1">' +
                            '<span class="global-search-hit-title">' + escapeHtml(u.name) + '</span>' +
                            '<span class="global-search-hit-meta">@' + escapeHtml(u.username) + '</span>' +
                            '<span class="global-search-hit-kind ms-auto">User</span></div></div></a>';
                    }).join('');
                }
                function teamHits(items) {
                    return (items || []).map(function(t) {
                        return '<a class="global-search-hit" href="' + escapeHtml(t.url) + '" data-search-result="1">' +
                            '<div class="global-search-hit-main">' +
                            '<div class="global-search-hit-line1">' +
                            '<span class="global-search-hit-title">' + escapeHtml(t.name) + '</span>' +
                            '<span class="global-search-hit-kind ms-auto">Team</span></div>' +
                            (t.excerpt ? '<div class="global-search-hit-line2">' + escapeHtml(t.excerpt) + '</div>' : '') +
                            '</div></a>';
                    }).join('');
                }
                function sprintHits(items) {
                    return (items || []).map(function(s) {
                        return '<a class="global-search-hit" href="' + escapeHtml(s.url) + '" data-search-result="1">' +
                            '<div class="global-search-hit-main">' +
                            '<div class="global-search-hit-line1">' +
                            '<span class="global-search-hit-title">' + escapeHtml(s.name) + '</span>' +
                            (s.board_name ? '<span class="global-search-hit-meta">' + escapeHtml(s.board_name) + '</span>' : '') +
                            '<span class="global-search-hit-kind ms-auto">Sprint</span></div>' +
                            (s.excerpt ? '<div class="global-search-hit-line2">' + escapeHtml(s.excerpt) + '</div>' : '') +
                            '</div></a>';
                    }).join('');
                }
                function boardHits(items) {
                    return (items || []).map(function(b) {
                        var typeBadge = b.board_type
                            ? '<span class="badge bg-secondary">' + escapeHtml(b.board_type) + '</span>'
                            : '';
                        return '<a class="global-search-hit" href="' + escapeHtml(b.url) + '" data-search-result="1">' +
                            '<div class="global-search-hit-main">' +
                            '<div class="global-search-hit-line1">' + typeBadge +
                            '<span class="global-search-hit-title">' + escapeHtml(b.name) + '</span>' +
                            (b.project_name ? '<span class="global-search-hit-meta">' + escapeHtml(b.project_name) + '</span>' : '') +
                            '<span class="global-search-hit-kind ms-auto">Board</span></div></div></a>';
                    }).join('');
                }
                if (q.length < 2) {
                    resultsEl.innerHTML = '';
                    if (hintEl) hintEl.classList.remove('d-none');
                    return;
                }
                if (wanted.length === 0) {
                    if (hintEl) hintEl.classList.remove('d-none');
                    resultsEl.innerHTML = '<p class="text-muted small text-center py-4 mb-0">Select at least one category above to search.</p>';
                    return;
                }
                if (hintEl) hintEl.classList.add('d-none');
                if (wanted.indexOf('issues') >= 0 && data.issues && data.issues.length) {
                    parts.push(sectionBlock('Issues', issueHits(data.issues)));
                }
                if (wanted.indexOf('projects') >= 0 && data.projects && data.projects.length) {
                    parts.push(sectionBlock('Projects', projectHits(data.projects)));
                }
                if (wanted.indexOf('users') >= 0 && data.users && data.users.length) {
                    parts.push(sectionBlock('Users', userHits(data.users)));
                }
                if (wanted.indexOf('teams') >= 0 && data.teams && data.teams.length) {
                    parts.push(sectionBlock('Teams', teamHits(data.teams)));
                }
                if (wanted.indexOf('sprints') >= 0 && data.sprints && data.sprints.length) {
                    parts.push(sectionBlock('Sprints', sprintHits(data.sprints)));
                }
                if (wanted.indexOf('boards') >= 0 && data.boards && data.boards.length) {
                    parts.push(sectionBlock('Boards', boardHits(data.boards)));
                }
                var html = parts.join('');
                if (!html) {
                    resultsEl.innerHTML = '<p class="text-muted small text-center py-4 mb-0">No results for &ldquo;' + escapeHtml(q) + '&rdquo; in the selected categories.</p>';
                } else {
                    resultsEl.innerHTML = html;
                }
            }
            function runSearch() {
                if (!input || !resultsEl) return;
                var q = input.value.trim();
                if (q.length < 2) {
                    resultsEl.innerHTML = '';
                    if (hintEl) hintEl.classList.remove('d-none');
                    return;
                }
                var types = selectedTypes();
                if (types.length === 0) {
                    resultsEl.innerHTML = '<p class="text-muted small text-center py-4 mb-0">Select at least one category above to search.</p>';
                    if (hintEl) hintEl.classList.remove('d-none');
                    return;
                }
                if (hintEl) hintEl.classList.add('d-none');
                var myGen = ++requestGen;
                var params = new URLSearchParams();
                params.set('q', q);
                types.forEach(function(t) {
                    params.append('types[]', t);
                });
                var sep = searchUrl.indexOf('?') >= 0 ? '&' : '?';
                var u = searchUrl + sep + params.toString();
                fetch(u, {
                    credentials: 'same-origin',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                }).then(function(r) {
                    if (!r.ok) throw new Error('search failed');
                    return r.json();
                }).then(function(data) {
                    if (myGen !== requestGen) return;
                    render(data);
                }).catch(function() {
                    if (myGen !== requestGen) return;
                    resultsEl.innerHTML = '<p class="text-danger small text-center py-3 mb-0">Search failed. Try again.</p>';
                });
            }
            function scheduleSearch() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(runSearch, 280);
            }
            modalEl.addEventListener('shown.bs.modal', function() {
                if (input) {
                    input.focus();
                    input.select();
                }
                scheduleSearch();
            });
            modalEl.addEventListener('hidden.bs.modal', function() {
                requestGen++;
                clearTimeout(debounceTimer);
                if (input) input.value = '';
                if (resultsEl) resultsEl.innerHTML = '';
                if (hintEl) hintEl.classList.remove('d-none');
            });
            if (input) input.addEventListener('input', scheduleSearch);
            modalEl.querySelectorAll('.global-search-type-cb').forEach(function(cb) {
                cb.addEventListener('change', scheduleSearch);
            });
            modalEl.addEventListener('click', function(e) {
                var a = e.target.closest('a[data-search-result]');
                if (!a) return;
                var inst = bootstrap.Modal.getInstance(modalEl);
                if (inst) inst.hide();
            });
            document.addEventListener('keydown', function(e) {
                if (!e.key || (e.key.toLowerCase() !== 'k')) return;
                if (!(e.ctrlKey || e.metaKey)) return;
                var t = e.target;
                var tag = t && t.tagName ? t.tagName.toLowerCase() : '';
                if (tag === 'input' || tag === 'textarea' || tag === 'select' || (t && t.isContentEditable)) return;
                e.preventDefault();
                bootstrap.Modal.getOrCreateInstance(modalEl).show();
            });
        })();
    });

    // SPA-style nav: load setup/main pages into #app-main without full reload (AJAX + transition)
    TaskFlow.appNav = {
        _loadGen: 0,
        /** Same path and query params except `page` — table pagination only (skip heavy fade/overlay). */
        isPaginationOnlyNav(currentHref, targetHref) {
            try {
                var cur = new URL(currentHref);
                var next = new URL(targetHref, cur.href);
                if (cur.origin !== next.origin || cur.pathname !== next.pathname) return false;
                var pa = new URLSearchParams(cur.search);
                var pb = new URLSearchParams(next.search);
                var keySet = {};
                pa.forEach(function(_, k) { keySet[k] = true; });
                pb.forEach(function(_, k) { keySet[k] = true; });
                for (var k in keySet) {
                    if (!Object.prototype.hasOwnProperty.call(keySet, k)) continue;
                    if (k === 'page') continue;
                    if (pa.getAll(k).join('\x1e') !== pb.getAll(k).join('\x1e')) return false;
                }
                function normPage(p) {
                    if (p == null || p === '') return '1';
                    return String(p);
                }
                return normPage(pa.get('page')) !== normPage(pb.get('page'));
            } catch (e) {
                return false;
            }
        },
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
            const loadingInner = document.getElementById('app-main-loading-inner');
            if (!main) return;
            const reqUrl = url.startsWith('http') ? url : (window.location.origin + (url.startsWith('/') ? '' : '/') + url);
            const softPagination = TaskFlow.appNav.isPaginationOnlyNav(window.location.href, reqUrl);
            const savedScrollTop = contentTarget ? contentTarget.scrollTop : 0;
            const gen = ++TaskFlow.appNav._loadGen;
            const hideLoadingOverlay = function(immediate) {
                if (!loadingEl || !loadingEl.classList) return;
                loadingEl.classList.remove('is-visible');
                loadingEl.setAttribute('aria-hidden', 'true');
                if (loadingInner) loadingInner.setAttribute('aria-busy', 'false');
                if (immediate) {
                    loadingEl.classList.add('d-none');
                    return;
                }
                setTimeout(function() {
                    if (loadingEl.classList && !loadingEl.classList.contains('is-visible')) {
                        loadingEl.classList.add('d-none');
                    }
                }, 400);
            };
            const showLoadingOverlay = function() {
                if (!loadingEl || !loadingEl.classList) return;
                loadingEl.classList.remove('d-none');
                loadingEl.setAttribute('aria-hidden', 'false');
                if (loadingInner) loadingInner.setAttribute('aria-busy', 'true');
                requestAnimationFrame(function() {
                    requestAnimationFrame(function() {
                        if (loadingEl.classList) loadingEl.classList.add('is-visible');
                    });
                });
            };
            const restoreContentAfterError = function() {
                if (contentTarget && contentTarget.classList) {
                    contentTarget.classList.remove('app-main-content-fade-out', 'app-main-content-fade-in');
                }
                hideLoadingOverlay(true);
            };
            if (contentTarget && contentTarget.classList) {
                contentTarget.classList.remove('app-main-content-fade-in');
                if (!softPagination) contentTarget.classList.add('app-main-content-fade-out');
                else contentTarget.classList.remove('app-main-content-fade-out');
            }
            if (loadingEl && loadingEl.classList) {
                if (!softPagination) {
                    showLoadingOverlay();
                } else {
                    hideLoadingOverlay(true);
                }
            }
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
                    if (gen !== TaskFlow.appNav._loadGen) return;
                    if (!html || html.trim().length === 0) {
                        if (typeof TaskFlow !== 'undefined' && TaskFlow.toast) TaskFlow.toast('error', 'Failed to load content.');
                        restoreContentAfterError();
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
                        restoreContentAfterError();
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
                            restoreContentAfterError();
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
                    var transitionMs = softPagination ? 0 : 320;
                    var runAfterTransition = function() {
                        if (gen !== TaskFlow.appNav._loadGen) return;
                        if (doc && doc.head) {
                            (function mergeSpaHeadAssets(sourceDoc) {
                                var destHead = document.head;
                                if (!sourceDoc.head || !destHead) return;
                                sourceDoc.head.querySelectorAll('link[rel="stylesheet"][href]').forEach(function(link) {
                                    var href = link.getAttribute('href');
                                    if (!href) return;
                                    var abs;
                                    try { abs = new URL(href, window.location.origin).href; } catch (e) { return; }
                                    var has = Array.prototype.some.call(destHead.querySelectorAll('link[rel="stylesheet"]'), function(el) {
                                        var eh = el.getAttribute('href');
                                        if (!eh) return false;
                                        try { return new URL(eh, window.location.origin).href === abs; } catch (e2) { return false; }
                                    });
                                    if (!has) destHead.appendChild(link.cloneNode(true));
                                });
                                sourceDoc.head.querySelectorAll('style[id^="taskflow-page-"]').forEach(function(style) {
                                    var sid = style.id;
                                    if (!sid) return;
                                    var old = document.getElementById(sid);
                                    if (old && old.parentNode) old.parentNode.removeChild(old);
                                    destHead.appendChild(style.cloneNode(true));
                                });
                            })(doc);
                        }
                        if (newContent && contentTarget) {
                            contentTarget.innerHTML = newContent.innerHTML || '';
                        } else if (newMain && main) {
                            var inner = newMain.querySelector('#app-main-content') || newMain.querySelector('[id="app-main-content"]') || newMain.querySelector('.app-main-inner');
                            if (contentTarget && inner) contentTarget.innerHTML = inner.innerHTML || '';
                            else main.innerHTML = newMain.innerHTML || '';
                        }
                        if (contentTarget) {
                            contentTarget.classList.remove('app-main-content-fade-out');
                            if (!softPagination) {
                                contentTarget.classList.add('app-main-content-fade-in');
                                contentTarget.scrollTop = 0;
                                requestAnimationFrame(function() {
                                    requestAnimationFrame(function() {
                                        hideLoadingOverlay(false);
                                    });
                                });
                                setTimeout(function() {
                                    if (contentTarget && contentTarget.classList) contentTarget.classList.remove('app-main-content-fade-in');
                                }, 520);
                            } else {
                                contentTarget.classList.remove('app-main-content-fade-in');
                                contentTarget.scrollTop = savedScrollTop;
                            }
                        }
                        var scripts = scriptsRoot ? scriptsRoot.querySelectorAll('script') : [];
                        if (!scripts.length && doc.body) scripts = doc.body.querySelectorAll('script');
                        scripts.forEach(function(oldScript) {
                            var script = document.createElement('script');
                            if (oldScript.attributes && oldScript.attributes.length) {
                                Array.prototype.forEach.call(oldScript.attributes, function(attr) {
                                    script.setAttribute(attr.name, attr.value);
                                });
                            }
                            if (oldScript.src) {
                                script.src = oldScript.src;
                            } else {
                                script.textContent = oldScript.textContent;
                            }
                            document.body.appendChild(script);
                        });
                        /* Workflow diagram (Cytoscape): container often has 0×0 until flex + page CSS apply; re-run after layout */
                        setTimeout(function() {
                            if (typeof window.renderWorkflowDiagram === 'function') window.renderWorkflowDiagram();
                        }, 0);
                        setTimeout(function() {
                            if (typeof window.renderWorkflowDiagram === 'function') window.renderWorkflowDiagram();
                        }, 340);
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
                    if (gen !== TaskFlow.appNav._loadGen) return;
                    restoreContentAfterError();
                    if (typeof TaskFlow !== 'undefined' && TaskFlow.toast) TaskFlow.toast('error', 'Failed to load page.');
                });
        }
    };
    </script>
    @yield('vite')
    @stack('scripts')
</body>
</html>
