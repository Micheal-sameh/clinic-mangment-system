<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

@php
    $logo = app()->make('App\Repositories\SettingRepository')->getLogo() ?: asset('images/logo.jpg');
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', env('APP_NAME'))</title>
    <link rel="icon" href="{{ $logo }}" type="image/jpg">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* ============================================
           CLINIC MANAGEMENT SYSTEM — DESIGN SYSTEM
           Modern Medical Theme (Teal)
        ============================================ */
        :root {
            /* Brand Colors */
            --primary:         #0d9488;
            --primary-dark:    #0f766e;
            --primary-darker:  #134e4a;
            --primary-light:   #5eead4;
            --primary-xlight:  #ccfbf1;
            --secondary:       #3b82f6;
            --accent:          #f59e0b;
            --success:         #10b981;
            --warning:         #f59e0b;
            --danger:          #ef4444;
            --info:            #06b6d4;

            /* Sidebar */
            --sidebar-bg:      linear-gradient(160deg, #0f172a 0%, #134e4a 60%, #0f766e 100%);
            --sidebar-hover:   rgba(13, 148, 136, 0.25);
            --sidebar-active:  rgba(13, 148, 136, 0.4);
            --sidebar-text:    #f0fdfa;
            --sidebar-muted:   #99f6e4;
            --sidebar-width:   260px;

            /* Content */
            --content-bg:      #f0fdfa;
            --card-bg:         #ffffff;

            /* Gradients */
            --grad-primary:    linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
            --grad-header:     linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #0891b2 100%);
            --grad-glass:      linear-gradient(135deg, rgba(13,148,136,0.08) 0%, rgba(6,182,212,0.05) 100%);

            /* Shadows */
            --shadow-sm:       0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
            --shadow:          0 4px 12px rgba(0,0,0,0.08), 0 2px 4px rgba(0,0,0,0.04);
            --shadow-md:       0 8px 24px rgba(0,0,0,0.10), 0 4px 8px rgba(0,0,0,0.06);
            --shadow-lg:       0 20px 40px rgba(0,0,0,0.12), 0 8px 16px rgba(0,0,0,0.06);
            --shadow-primary:  0 8px 24px rgba(13,148,136,0.30);
            --shadow-xxl:      0 25px 50px -12px rgba(0,0,0,0.20);

            /* Borders */
            --radius:          12px;
            --radius-lg:       20px;
            --radius-xl:       28px;
            --border-light:    rgba(13,148,136,0.15);

            /* Transitions */
            --transition:      all 0.3s cubic-bezier(0.4, 0, 0.2, 1);

            /* Glass */
            --glass-bg:        rgba(255,255,255,0.12);
            --glass-border:    rgba(255,255,255,0.20);
            --glass-content-bg: rgba(255,255,255,0.92);
        }

        /* ── Base ─────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            width: 100%;
            background: var(--content-bg);
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
            color: #1e293b;
        }

        /* ── Bootstrap Overrides ──────────────── */
        .btn-primary {
            background: var(--grad-primary) !important;
            border-color: var(--primary) !important;
            box-shadow: var(--shadow-primary) !important;
            font-weight: 600;
            letter-spacing: 0.01em;
            transition: var(--transition);
        }
        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(135deg, #0f766e 0%, #0891b2 100%) !important;
            border-color: var(--primary-dark) !important;
            transform: translateY(-1px);
            box-shadow: 0 12px 32px rgba(13,148,136,0.40) !important;
        }
        .btn-outline-primary {
            color: var(--primary) !important;
            border-color: var(--primary) !important;
        }
        .btn-outline-primary:hover {
            background: var(--primary) !important;
            color: #fff !important;
        }
        .text-primary { color: var(--primary) !important; }
        .bg-primary { background: var(--grad-primary) !important; }
        .border-primary { border-color: var(--primary) !important; }
        .badge.bg-primary { background: var(--primary) !important; }

        /* ── Global Utilities ─────────────────── */

        /* Text gradient */
        .text-gradient {
            background: var(--grad-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Glass morphism card */
        .glass-effect {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(13,148,136,0.12) !important;
            box-shadow: var(--shadow-md);
        }
        .glass-inner {
            background: rgba(240,253,250,0.60);
            border: 1px solid rgba(13,148,136,0.10);
            border-radius: var(--radius);
        }

        /* Glow button */
        .btn-glow {
            box-shadow: 0 4px 20px rgba(13,148,136,0.35) !important;
        }
        .btn-glow:hover {
            box-shadow: 0 8px 30px rgba(13,148,136,0.50) !important;
            transform: translateY(-2px);
        }

        /* Premium card header */
        .premium-header {
            background: var(--grad-header) !important;
            border-bottom: none !important;
        }
        .premium-header .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }
        .premium-header .shape-1 { width: 150px; height: 150px; top: -50px; right: -30px; }
        .premium-header .shape-2 { width: 80px; height: 80px; bottom: -20px; left: 60px; }
        .premium-header .shape-3 { width: 50px; height: 50px; top: 20px; left: 40%; }

        /* Stat icon */
        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Avatars */
        .doctor-avatar,
        .patient-avatar,
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .doctor-avatar-sm,
        .patient-avatar-sm {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }
        .doctor-avatar-large {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 2rem;
            flex-shrink: 0;
        }

        /* Section icon */
        .section-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Premium input */
        .premium-input .form-control,
        .premium-input .form-select {
            border: 2px solid rgba(13,148,136,0.15);
            border-radius: var(--radius);
            transition: var(--transition);
            font-size: 0.95rem;
        }
        .premium-input .form-control:focus,
        .premium-input .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(13,148,136,0.12);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(13,148,136,0.10) !important;
        }
        .input-group-text { border-color: rgba(13,148,136,0.15); }

        /* Cards */
        .card {
            border: 1px solid rgba(13,148,136,0.08) !important;
            border-radius: var(--radius-lg) !important;
            box-shadow: var(--shadow) !important;
            transition: var(--transition);
        }
        .card:hover { box-shadow: var(--shadow-md) !important; }
        .shadow-xxl { box-shadow: var(--shadow-xxl) !important; }

        /* Table */
        .table { font-size: 0.9rem; }
        .table th {
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            padding: 1rem 0.75rem;
            border-bottom: 2px solid rgba(13,148,136,0.10);
        }
        .table td { padding: 0.875rem 0.75rem; vertical-align: middle; }
        .table-hover tbody tr:hover {
            background: rgba(240,253,250,0.70) !important;
            transition: background 0.2s ease;
        }
        .table-light th { background: rgba(240,253,250,0.70) !important; }

        /* Alerts */
        .alert { border-radius: var(--radius) !important; border: none !important; }
        .alert-success { background: rgba(16,185,129,0.10) !important; color: #065f46 !important; }
        .alert-danger  { background: rgba(239,68,68,0.10) !important; color: #7f1d1d !important; }
        .alert-warning { background: rgba(245,158,11,0.10) !important; color: #78350f !important; }
        .alert-info    { background: rgba(6,182,212,0.10) !important; color: #164e63 !important; }

        /* Background page wrapper used by many pages */
        .bg-gradient-to-br {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 40%, #f0fdfa 70%, #e0f2fe 100%) !important;
        }

        /* Floating background elements */
        .floating-elements {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(13,148,136,0.06), rgba(6,182,212,0.04));
            animation: floatBg 10s ease-in-out infinite;
        }
        .element-1 { width: 280px; height: 280px; top: -80px; left: -80px; animation-delay: 0s; }
        .element-2 { width: 200px; height: 200px; bottom: 10%; right: -60px; animation-delay: 3s; }
        .element-3 { width: 120px; height: 120px; bottom: 30%; left: 15%; animation-delay: 6s; }
        .element-4 { width: 160px; height: 160px; top: 40%; right: 20%; animation-delay: 1.5s; }
        @keyframes floatBg {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50%       { transform: translateY(-20px) rotate(15deg); }
        }

        /* Error messages */
        .error-message {
            color: var(--danger);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* Status badges */
        .status-success  { background: rgba(16,185,129,0.12) !important; color: #065f46 !important; }
        .status-waiting  { background: rgba(245,158,11,0.12) !important; color: #78350f !important; }
        .status-topay    { background: rgba(6,182,212,0.12) !important; color: #164e63 !important; }
        .status-cancelled{ background: rgba(239,68,68,0.12) !important; color: #7f1d1d !important; }

        /* Page animations */
        .content-area { animation: fadeInUp 0.45s ease; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Metric indicator dot */
        .metric-indicator {
            width: 10px; height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* Detail card */
        .detail-card {
            background: rgba(240,253,250,0.7);
            border: 1px solid rgba(13,148,136,0.10);
            border-radius: var(--radius);
        }

        /* Growth/stat badge */
        .stat-badge {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            font-size: 0.78rem;
        }
        .glass-inner-stat {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
        }

        /* Table inactive row */
        .table-inactive { opacity: 0.5; }

        /* ── Sidebar ──────────────────────────── */
        #sidebar {
            position: fixed;
            top: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            transition: var(--transition);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 4px 0 24px rgba(0,0,0,0.15);
        }
        [dir="rtl"] #sidebar { right: 0; left: auto; }

        .sidebar-header {
            padding: 1.75rem 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            background: rgba(255,255,255,0.04);
            position: relative;
        }
        .sidebar-header::after {
            content: '';
            position: absolute;
            bottom: 0; left: 50%;
            transform: translateX(-50%);
            width: 60%; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(13,148,136,0.5), transparent);
        }
        .sidebar-logo-wrap {
            width: 68px; height: 68px;
            border-radius: 20px;
            background: rgba(255,255,255,0.10);
            border: 2px solid rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
            margin-bottom: 0.9rem;
            transition: var(--transition);
        }
        .sidebar-logo-wrap:hover {
            border-color: rgba(13,148,136,0.60);
            background: rgba(13,148,136,0.15);
        }
        .sidebar-logo-wrap img {
            width: 100%; height: 100%;
            object-fit: contain;
            padding: 8px;
        }
        .app-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
            letter-spacing: -0.01em;
        }
        .app-subtitle {
            font-size: 0.72rem;
            color: var(--sidebar-muted);
            margin: 0.2rem 0 0;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            padding: 1.25rem 0.75rem;
            overflow-y: auto;
        }
        .sidebar-nav::-webkit-scrollbar { width: 3px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(94,234,212,0.30);
            border-radius: 2px;
        }

        .nav-item { margin: 0.15rem 0; }
        .nav-item a {
            display: flex;
            align-items: center;
            gap: 11px;
            color: rgba(240,253,250,0.80);
            text-decoration: none;
            padding: 11px 14px;
            border-radius: 10px;
            transition: var(--transition);
            font-size: 0.875rem;
            font-weight: 500;
            position: relative;
        }
        .nav-item a:hover {
            background: var(--sidebar-hover);
            color: #fff;
            padding-left: 18px;
        }
        [dir="rtl"] .nav-item a:hover { padding-right: 18px; padding-left: 14px; }
        .nav-item a.active {
            background: linear-gradient(135deg, rgba(13,148,136,0.45), rgba(6,182,212,0.30));
            color: #fff;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(13,148,136,0.25);
        }
        .nav-item a.active::before {
            content: '';
            position: absolute;
            left: 0; top: 25%; bottom: 25%;
            width: 3px;
            background: var(--primary-light);
            border-radius: 0 3px 3px 0;
        }
        [dir="rtl"] .nav-item a.active::before { left: auto; right: 0; border-radius: 3px 0 0 3px; }
        .nav-item a i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
            opacity: 0.85;
            transition: var(--transition);
        }
        .nav-item a:hover i, .nav-item a.active i { opacity: 1; color: var(--primary-light); }

        .nav-badge {
            background: rgba(13,148,136,0.30);
            border: 1px solid rgba(94,234,212,0.25);
            color: var(--primary-light);
            font-size: 0.65rem;
            padding: 2px 7px;
            border-radius: 6px;
            margin-left: auto;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        /* Nav section divider */
        .nav-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
            margin: 0.75rem 0.5rem;
        }
        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.10em;
            color: rgba(153,246,228,0.45);
            padding: 0.5rem 0.875rem 0.25rem;
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 1rem 1.25rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.08);
            background: rgba(0,0,0,0.10);
        }
        .action-buttons { display: flex; gap: 0.6rem; justify-content: center; }
        .action-btn {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            color: var(--sidebar-text);
            width: 42px; height: 42px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1rem;
        }
        .action-btn:hover {
            background: rgba(13,148,136,0.25);
            border-color: rgba(13,148,136,0.40);
            transform: translateY(-2px);
        }
        .action-btn.logout {
            background: rgba(239,68,68,0.15);
            border-color: rgba(239,68,68,0.25);
            color: #fca5a5;
        }
        .action-btn.logout:hover {
            background: rgba(239,68,68,0.30);
            border-color: rgba(239,68,68,0.50);
        }

        /* User info in sidebar */
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            margin: 0 0 1rem;
        }
        .sidebar-user-avatar {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), #0891b2);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            color: white;
            flex-shrink: 0;
        }
        .sidebar-user-name {
            font-size: 0.82rem;
            font-weight: 600;
            color: #fff;
            line-height: 1.2;
        }
        .sidebar-user-role {
            font-size: 0.7rem;
            color: var(--sidebar-muted);
        }

        /* ── Content Area ─────────────────────── */
        .content-area {
            margin-left: var(--sidebar-width);
            padding: 2rem 2rem 3rem;
            min-height: 100vh;
            transition: var(--transition);
            background: var(--content-bg);
        }
        [dir="rtl"] .content-area { margin-right: var(--sidebar-width); margin-left: 0; }

        /* ── Toggle Button ────────────────────── */
        .btn-toggle-sidebar {
            position: fixed;
            top: 1.25rem; left: 1.25rem;
            z-index: 1100;
            background: var(--grad-primary);
            color: white;
            border: none;
            border-radius: 10px;
            width: 44px; height: 44px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: var(--shadow-primary);
            transition: var(--transition);
            font-size: 1.1rem;
        }
        .btn-toggle-sidebar:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(13,148,136,0.40);
        }
        [dir="rtl"] .btn-toggle-sidebar { left: auto; right: 1.25rem; }

        /* ── Backdrop ─────────────────────────── */
        .sidebar-backdrop {
            position: fixed; top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(15,23,42,0.50);
            backdrop-filter: blur(3px);
            z-index: 999;
            opacity: 0; visibility: hidden;
            transition: var(--transition);
        }
        .sidebar-backdrop.show { opacity: 1; visibility: visible; }

        /* ── Responsive ───────────────────────── */
        @media (max-width: 768px) {
            #sidebar { left: calc(-1 * var(--sidebar-width)); }
            [dir="rtl"] #sidebar { right: calc(-1 * var(--sidebar-width)); left: auto; }
            #sidebar.show { left: 0; }
            [dir="rtl"] #sidebar.show { right: 0; }
            .content-area { margin-left: 0; margin-right: 0; padding: 1.25rem; }
            [dir="rtl"] .content-area { margin-right: 0; }
            .btn-toggle-sidebar { top: 0.875rem; left: 0.875rem; }
            [dir="rtl"] .btn-toggle-sidebar { right: 0.875rem; }
        }

        /* ── Loading shimmer ──────────────────── */
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        .nav-item.loading a::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            animation: shimmer 1.2s infinite;
        }
    </style>
</head>

<body>
    <!-- Sidebar Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Sidebar -->
    <div id="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <div class="sidebar-logo-wrap">
                <img src="{{ $logo }}" alt="Logo">
            </div>
            <h1 class="app-name">{{ env('APP_NAME') }}</h1>
            <p class="app-subtitle">Healthcare Management</p>
        </div>

        <!-- Navigation -->
        <div class="sidebar-nav">
            @auth
                {{-- User info chip --}}
                <div class="sidebar-user">
                    <div class="sidebar-user-avatar">
                        {{ strtoupper(substr(auth()->user()->localized_name ?? auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <div class="sidebar-user-name">{{ auth()->user()->localized_name ?? auth()->user()->name }}</div>
                        <div class="sidebar-user-role">{{ auth()->user()->roles->first()->name ?? '' }}</div>
                    </div>
                </div>

                <div class="nav-divider"></div>
                <div class="nav-section-label">{{ __('messages.main') ?? 'Navigation' }}</div>

                <div class="nav-item">
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        {{ __('messages.home') }}
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('users.profile') }}" class="{{ request()->routeIs('users.profile') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i>
                        {{ __('messages.profile') }}
                    </a>
                </div>

                <div class="nav-divider"></div>
                <div class="nav-section-label">{{ __('messages.clinic') ?? 'Clinic' }}</div>

                @can('reservations_list')
                    <div class="nav-item">
                        <a href="{{ route('reservations.index') }}" class="{{ request()->routeIs('reservations.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-check"></i>
                            {{ __('messages.reservations') }}
                        </a>
                    </div>
                @endcan
                @can('patients-list')
                    <div class="nav-item">
                        <a href="{{ route('patients.index') }}" class="{{ request()->routeIs('patients.index') ? 'active' : '' }}">
                            <i class="fas fa-user-injured"></i>
                            {{ __('messages.patients') }}
                        </a>
                    </div>
                @endcan
                @can('procedures_list')
                    <div class="nav-item">
                        <a href="{{ route('procedures.index') }}" class="{{ request()->routeIs('procedures.*') ? 'active' : '' }}">
                            <i class="fas fa-stethoscope"></i>
                            {{ __('messages.procedures') }}
                        </a>
                    </div>
                @endcan
                @can('workDays_list')
                    <div class="nav-item">
                        <a href="{{ route('working-days.index') }}" class="{{ request()->routeIs('working-days.*') ? 'active' : '' }}">
                            <i class="fas fa-clock"></i>
                            {{ __('messages.working_days') }}
                        </a>
                    </div>
                @endcan

                @can('users_list')
                    <div class="nav-divider"></div>
                    <div class="nav-section-label">{{ __('messages.administration') ?? 'Administration' }}</div>
                    <div class="nav-item">
                        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                            <i class="fas fa-users-cog"></i>
                            {{ __('messages.users') }}
                            <span class="nav-badge">Admin</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('doctors.index') }}" class="{{ request()->routeIs('doctors.*') ? 'active' : '' }}">
                            <i class="fas fa-user-md"></i>
                            {{ __('messages.doctors') }}
                        </a>
                    </div>
                @endcan
                @can('reports_list')
                    <div class="nav-item">
                        <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-line"></i>
                            {{ __('messages.reports') }}
                        </a>
                    </div>
                @endcan
                @can('settings_update')
                    <div class="nav-item">
                        <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
                            <i class="fas fa-cog"></i>
                            {{ __('messages.settings') }}
                        </a>
                    </div>
                @endcan
            @else
                <div class="nav-item">
                    <a href="{{ route('loginPage') }}">
                        <i class="fas fa-sign-in-alt"></i>
                        {{ __('messages.login') }}
                    </a>
                </div>
            @endauth
        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="action-buttons">
                <button class="action-btn" id="languageSwitcher" title="Change Language">
                    <i class="fas fa-globe"></i>
                </button>
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="action-btn logout" title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>

    <!-- Toggle Button -->
    <button class="btn-toggle-sidebar d-md-none" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Content -->
    <div class="content-area">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const sidebar = document.getElementById("sidebar");
        const toggleBtn = document.getElementById("toggleSidebar");
        const backdrop = document.getElementById("sidebarBackdrop");

        // Toggle sidebar
        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("show");
            backdrop.classList.toggle("show");
            document.body.style.overflow = sidebar.classList.contains("show") ? 'hidden' : '';
        });

        // Close sidebar when clicking backdrop
        backdrop.addEventListener("click", () => {
            sidebar.classList.remove("show");
            backdrop.classList.remove("show");
            document.body.style.overflow = '';
        });

        // Language switcher
        document.getElementById("languageSwitcher").addEventListener("click", () => {
            const currentLang = "{{ app()->getLocale() }}";
            const newLang = currentLang === "en" ? "ar" : "en";

            // Add loading state
            const btn = document.getElementById("languageSwitcher");
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            setTimeout(() => {
                window.location.href = `/lang/${newLang}`;
            }, 500);
        });

        // Add active states and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading animation to nav items on click
            const navItems = document.querySelectorAll('.nav-item a');
            navItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    if (this.getAttribute('href') !== '#') {
                        this.parentElement.classList.add('loading');
                    }
                });
            });

            // Remove loading state when page loads
            window.addEventListener('load', function() {
                document.querySelectorAll('.nav-item.loading').forEach(item => {
                    item.classList.remove('loading');
                });
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove("show");
                backdrop.classList.remove("show");
                document.body.style.overflow = '';
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
