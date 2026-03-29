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
    <title>@yield('title') - TaskFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #5b5fef;
            --primary-hover: #4f52e5;
            --auth-body: #f1f3f9;
            --auth-text: #3d4f5f;
            --auth-muted: #64748b;
            --auth-input-bg: #ffffff;
            --auth-border: #e2e6ef;
            --auth-card-bg: rgba(255, 255, 255, 0.78);
            --auth-card-border: rgba(255, 255, 255, 0.65);
            --auth-shadow: 0 4px 24px rgba(15, 23, 42, 0.08), 0 1px 3px rgba(15, 23, 42, 0.06);
            --auth-mesh-a: rgba(91, 95, 239, 0.22);
            --auth-mesh-b: rgba(129, 140, 248, 0.14);
            --auth-mesh-c: rgba(244, 114, 182, 0.08);
            --auth-ease: cubic-bezier(0.22, 1, 0.36, 1);
            --auth-focus-ring: rgba(91, 95, 239, 0.28);
        }
        html[data-theme="dark"] {
            color-scheme: dark;
            --primary: #8b93ff;
            --primary-hover: #a5adff;
            --auth-body: #070b14;
            --auth-text: #e8edf5;
            --auth-muted: #9ca3af;
            --auth-input-bg: #1a2234;
            --auth-border: #2d3748;
            --auth-card-bg: rgba(17, 24, 39, 0.82);
            --auth-card-border: rgba(148, 163, 184, 0.12);
            --auth-shadow: 0 16px 48px rgba(0, 0, 0, 0.45), 0 4px 12px rgba(0, 0, 0, 0.3);
            --auth-mesh-a: rgba(129, 140, 248, 0.16);
            --auth-mesh-b: rgba(167, 139, 250, 0.1);
            --auth-mesh-c: rgba(244, 114, 182, 0.07);
            --auth-focus-ring: rgba(139, 147, 255, 0.35);
        }
        html[data-theme="ocean"] {
            --primary: #0d9488;
            --primary-hover: #0f766e;
            --auth-body: #e8f4f2;
            --auth-text: #134e4a;
            --auth-muted: #5b7c78;
            --auth-input-bg: #ffffff;
            --auth-border: #b8d9d4;
            --auth-card-bg: rgba(252, 253, 253, 0.88);
            --auth-card-border: rgba(184, 217, 212, 0.55);
            --auth-shadow: 0 8px 32px rgba(19, 78, 74, 0.1), 0 2px 8px rgba(13, 148, 136, 0.06);
            --auth-mesh-a: rgba(13, 148, 136, 0.2);
            --auth-mesh-b: rgba(45, 212, 191, 0.12);
            --auth-mesh-c: rgba(20, 184, 166, 0.08);
            --auth-focus-ring: rgba(13, 148, 136, 0.28);
        }

        * { box-sizing: border-box; }
        body.auth-body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Public Sans', system-ui, sans-serif;
            background: var(--auth-body);
            color: var(--auth-text);
            -webkit-font-smoothing: antialiased;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem 2rem;
            position: relative;
            overflow-x: hidden;
        }

        .auth-bg {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        .auth-bg__blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(72px);
            opacity: 0.9;
            animation: auth-float 22s var(--auth-ease) infinite;
        }
        .auth-bg__blob--1 {
            width: min(72vw, 420px);
            height: min(72vw, 420px);
            background: var(--auth-mesh-a);
            top: -12%;
            right: -8%;
            animation-delay: 0s;
        }
        .auth-bg__blob--2 {
            width: min(64vw, 380px);
            height: min(64vw, 380px);
            background: var(--auth-mesh-b);
            bottom: -18%;
            left: -12%;
            animation-delay: -7s;
        }
        .auth-bg__blob--3 {
            width: min(48vw, 280px);
            height: min(48vw, 280px);
            background: var(--auth-mesh-c);
            top: 38%;
            left: 42%;
            animation-delay: -14s;
        }
        @keyframes auth-float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(2%, -3%) scale(1.03); }
            66% { transform: translate(-3%, 2%) scale(0.98); }
        }

        .auth-shell {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
        }

        .auth-card {
            background: var(--auth-card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--auth-card-border);
            border-radius: 1rem;
            box-shadow: var(--auth-shadow);
            padding: 2rem 1.75rem 1.75rem;
            animation: auth-card-in 0.6s var(--auth-ease) backwards;
        }
        @keyframes auth-card-in {
            from {
                opacity: 0;
                transform: translateY(18px) scale(0.985);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .auth-brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-bottom: 0.35rem;
        }
        .auth-brand__icon {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, var(--primary) 0%, color-mix(in srgb, var(--primary) 70%, #a855f7) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.35rem;
            box-shadow: 0 4px 14px color-mix(in srgb, var(--primary) 35%, transparent);
        }
        html[data-theme="ocean"] .auth-brand__icon {
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            box-shadow: 0 4px 14px rgba(13, 148, 136, 0.28);
        }
        .auth-brand__text {
            font-weight: 700;
            font-size: 1.35rem;
            letter-spacing: -0.02em;
        }
        .auth-lead {
            color: var(--auth-muted);
            font-size: 0.9375rem;
            margin-bottom: 1.5rem;
            line-height: 1.45;
        }

        @keyframes auth-field-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .auth-field {
            margin-bottom: 1.1rem;
            animation: auth-field-in 0.5s var(--auth-ease) backwards;
        }

        .auth-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
            color: var(--auth-text);
        }

        .auth-field .form-control {
            border-radius: 0.65rem;
            border-color: var(--auth-border);
            background: var(--auth-input-bg);
            color: var(--auth-text);
            min-height: 2.65rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }
        .auth-field .form-control::placeholder {
            color: var(--auth-muted);
            opacity: 0.75;
        }
        .auth-field .form-control:hover:not(:focus) {
            border-color: color-mix(in srgb, var(--primary) 28%, var(--auth-border));
        }
        .auth-field .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem var(--auth-focus-ring);
            background: var(--auth-input-bg);
            color: var(--auth-text);
        }
        .auth-field .form-control.is-invalid {
            border-color: var(--bs-form-invalid-border-color, #dc3545);
        }
        .auth-input-group {
            position: relative;
            display: flex;
            align-items: center;
        }
        .auth-input-group .form-control {
            padding-right: 2.75rem;
        }

        .auth-toggle-password {
            position: absolute;
            right: 0.35rem;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: var(--auth-muted);
            width: 2.25rem;
            height: 2.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.45rem;
            cursor: pointer;
            transition: color 0.15s ease, background 0.15s ease;
        }
        .auth-toggle-password:hover {
            color: var(--primary);
            background: color-mix(in srgb, var(--primary) 8%, transparent);
        }
        .auth-toggle-password:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        .auth-form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.15rem;
        }
        .auth-form-check .form-check-input {
            width: 2.5rem;
            height: 1.25rem;
            margin-top: 0;
            cursor: pointer;
            border-color: var(--auth-border);
            background-color: var(--auth-input-bg);
            transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .auth-form-check .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .auth-form-check .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem var(--auth-focus-ring);
        }
        .auth-form-check label {
            font-size: 0.875rem;
            color: var(--auth-muted);
            cursor: pointer;
            user-select: none;
        }

        .btn-auth-submit {
            width: 100%;
            min-height: 2.75rem;
            font-weight: 600;
            border-radius: 0.65rem;
            border: none;
            background: var(--primary);
            color: #fff;
            transition: transform 0.15s ease, box-shadow 0.2s ease, background 0.2s ease, opacity 0.2s ease;
            box-shadow: 0 2px 8px color-mix(in srgb, var(--primary) 32%, transparent);
            position: relative;
        }
        .btn-auth-submit:hover:not(:disabled) {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px color-mix(in srgb, var(--primary) 38%, transparent);
        }
        .btn-auth-submit:active:not(:disabled) {
            transform: translateY(0);
        }
        .btn-auth-submit:disabled {
            opacity: 0.75;
            cursor: wait;
        }
        html[data-theme="ocean"] .btn-auth-submit {
            background: linear-gradient(180deg, #14b8a6 0%, #0d9488 100%);
            box-shadow: 0 2px 10px rgba(13, 148, 136, 0.28);
        }
        html[data-theme="ocean"] .btn-auth-submit:hover:not(:disabled) {
            background: linear-gradient(180deg, #2dd4bf 0%, #14b8a6 100%);
        }

        .btn-auth-submit .btn-label { transition: opacity 0.2s ease; }
        .btn-auth-submit.is-loading .btn-label { opacity: 0; }
        .btn-auth-submit .btn-spinner {
            position: absolute;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
        }
        .btn-auth-submit.is-loading .btn-spinner { display: flex; }
        .btn-auth-submit .btn-spinner i {
            animation: auth-spin 0.7s linear infinite;
        }
        @keyframes auth-spin {
            to { transform: rotate(360deg); }
        }

        .auth-footer {
            margin-top: 1.35rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--auth-border);
            text-align: center;
            font-size: 0.875rem;
            color: var(--auth-muted);
        }
        .auth-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            position: relative;
            transition: color 0.15s ease;
        }
        .auth-footer a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: 1px;
            background: currentColor;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.25s var(--auth-ease);
        }
        .auth-footer a:hover {
            color: var(--primary-hover);
        }
        .auth-footer a:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        @media (prefers-reduced-motion: reduce) {
            .auth-bg__blob,
            .auth-card,
            .auth-field,
            .btn-auth-submit .btn-spinner i {
                animation: none !important;
            }
            .auth-card,
            .auth-field {
                opacity: 1 !important;
                transform: none !important;
            }
            .btn-auth-submit:hover:not(:disabled) {
                transform: none;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="auth-body">
    <div class="auth-bg" aria-hidden="true">
        <div class="auth-bg__blob auth-bg__blob--1"></div>
        <div class="auth-bg__blob auth-bg__blob--2"></div>
        <div class="auth-bg__blob auth-bg__blob--3"></div>
    </div>
    <div class="auth-shell">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function () {
        document.querySelectorAll('.auth-toggle-password').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var wrap = btn.closest('.auth-input-group');
                if (!wrap) return;
                var input = wrap.querySelector('input');
                if (!input) return;
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
                var icon = btn.querySelector('i');
                if (icon) icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
            });
        });
        document.querySelectorAll('form.auth-form').forEach(function (form) {
            form.addEventListener('submit', function () {
                var submit = form.querySelector('.btn-auth-submit');
                if (!submit || submit.disabled) return;
                submit.disabled = true;
                submit.classList.add('is-loading');
                submit.setAttribute('aria-busy', 'true');
            });
        });
    })();
    </script>
    @stack('scripts')
</body>
</html>
