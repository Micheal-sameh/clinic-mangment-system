<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

@php
    $logo = app()->make('App\Repositories\SettingRepository')->getLogo() ?: asset('images/logo.jpg');
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link rel="icon" href="{{ $logo }}" type="image/jpg">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --sidebar-bg: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
            --sidebar-hover: rgba(255, 255, 255, 0.15);
            --sidebar-active: rgba(255, 255, 255, 0.25);
            --sidebar-text: #f8fafc;
            --sidebar-text-muted: #cbd5e1;
            --primary-color: #3b82f6;
            --accent-color: #f59e0b;
            --content-bg: #f8fafc;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        html,
        body {
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            width: 100%;
            background-color: var(--content-bg);
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
        }

        /* Enhanced Sidebar Styles */
        #sidebar {
            position: fixed;
            top: 0;
            height: 100vh;
            width: 250px;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            padding: 0;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        [dir="rtl"] #sidebar {
            right: 0;
            left: auto;
        }

        .sidebar-header {
            padding: 2rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-header img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.2);
            padding: 3px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .sidebar-header img:hover {
            transform: scale(1.05);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .app-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            margin: 0;
        }

        .app-subtitle {
            font-size: 0.875rem;
            color: var(--sidebar-text-muted);
            margin: 0.25rem 0 0;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1.5rem 0;
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }

        /* Flash Messages in Sidebar */
        .sidebar-flash-messages {
            padding: 0 1.5rem 1rem;
        }

        .sidebar-alert {
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--sidebar-text-muted);
            padding: 0 1.5rem 0.5rem;
            margin-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-item {
            margin: 0.25rem 0.75rem;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--sidebar-text);
            text-decoration: none;
            padding: 12px 16px;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-item a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--accent-color);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .nav-item a:hover {
            background: var(--sidebar-hover);
            transform: translateX(4px);
            color: white;
        }

        .nav-item a:hover::before {
            transform: scaleY(1);
        }

        .nav-item a.active {
            background: var(--sidebar-active);
            color: white;
            transform: translateX(4px);
        }

        .nav-item a.active::before {
            transform: scaleY(1);
        }

        .nav-item a i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .nav-item a:hover i {
            transform: scale(1.1);
        }

        .nav-item a.active i {
            color: var(--accent-color);
        }

        .nav-badge {
            background: var(--accent-color);
            color: #1f2937;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 8px;
            margin-left: auto;
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
        }

        .action-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: var(--sidebar-text);
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .action-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .action-btn.logout {
            background: rgba(239, 68, 68, 0.2);
            color: #fecaca;
        }

        .action-btn.logout:hover {
            background: rgba(239, 68, 68, 0.3);
        }

        /* Content Area */
        .content-area {
            margin-left: 250px;
            padding: 2rem;
            min-height: 100vh;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--content-bg);
        }

        [dir="rtl"] .content-area {
            margin-right: 250px;
            margin-left: 0;
        }

        /* Toggle Button */
        .btn-toggle-sidebar {
            position: fixed;
            top: 1.5rem;
            left: 1.5rem;
            z-index: 1100;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 12px;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .btn-toggle-sidebar:hover {
            background: #2563eb;
            transform: scale(1.05);
            box-shadow: 0 8px 15px rgba(59, 130, 246, 0.3);
        }

        [dir="rtl"] .btn-toggle-sidebar {
            left: auto;
            right: 1.5rem;
        }

        /* User Info Section */
        .user-info {
            padding: 1rem 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            margin: 1rem 0.75rem;
            text-align: center;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--accent-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
        }

        .user-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .user-role {
            font-size: 0.875rem;
            color: var(--sidebar-text-muted);
        }

        /* Mobile View */
        @media (max-width: 768px) {
            #sidebar {
                left: -250px;
                width: 250px;
            }

            [dir="rtl"] #sidebar {
                right: -250px;
                left: auto;
            }

            #sidebar.show {
                left: 0;
            }

            [dir="rtl"] #sidebar.show {
                right: 0;
            }

            [dir="rtl"] .content-area {
                margin-right: 0px;
                margin-left: 0;
            }

            .content-area {
                margin-left: 0;
                margin-right: 0;
                padding: 1.5rem;
            }

            .btn-toggle-sidebar {
                top: 1rem;
                left: 1rem;
            }

            [dir="rtl"] .btn-toggle-sidebar {
                right: 1rem;
            }
        }

        /* Backdrop for mobile */
        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-backdrop.show {
            opacity: 1;
            visibility: visible;
        }

        /* Animation for content */
        .content-area {
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading state */
        .nav-item.loading a {
            position: relative;
            overflow: hidden;
        }

        .nav-item.loading a::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
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
            <img src="{{ $logo }}" alt="Logo">
            <h1 class="app-name">MediCare</h1>
            <p class="app-subtitle">Healthcare Management</p>
        </div>
        <!-- Navigation -->
        <div class="sidebar-nav">
            @auth
                <div class="nav-section">
                    {{-- <div class="nav-section-title">{{ __('messages.main') }}</div> --}}
                    <div class="nav-item">
                        <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            {{ __('messages.home') }}
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('users.profile') }}"
                            class="{{ request()->routeIs('users.profile') ? 'active' : '' }}">
                            <i class="fas fa-user"></i>
                            {{ __('messages.profile') }}
                        </a>
                    </div>
                    @can('users_list')
                        <div class="nav-item">
                            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.index') || request()->routeIs('patients.index') ? 'active' : '' }}">
                                <i class="fas fa-users"></i>
                                {{ __('messages.users') }}
                                <span class="nav-badge">Admin</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a href="{{ route('patients.index') }}" class="{{ request()->routeIs('patients.index') ? 'active' : '' }}">
                                <i class="fas fa-user-injured"></i>
                                {{ __('messages.patients') }}
                            </a>
                        </div>
                    @endcan
                    @can('procedures_list')
                        <div class="nav-item">
                            <a href="{{ route('procedures.index') }}"
                                class="{{ request()->routeIs('procedures.*') ? 'active' : '' }}">
                                <i class="fas fa-stethoscope"></i>
                                {{ __('messages.procedures') }}
                            </a>
                        </div>
                    @endcan
                    @can('reservations_list')
                        <div class="nav-item">
                            <a href="{{ route('reservations.index') }}"
                                class="{{ request()->routeIs('reservations.*') ? 'active' : '' }}">
                                <i class="fas fa-calendar-check"></i>
                                {{ __('messages.reservations') }}
                                <span class="nav-badge">New</span>
                            </a>
                        </div>
                    @endcan
                    @can('workDays_list')
                        <div class="nav-item">
                            <a href="{{ route('working-days.index') }}"
                                class="{{ request()->routeIs('working-days.*') ? 'active' : '' }}">
                                <i class="fas fa-clock"></i>
                                {{ __('messages.working_days') }}
                            </a>
                        </div>
                    @endcan
                    @can('reports_list')
                        <div class="nav-item">
                            <a href="{{ route('reports.index') }}"
                                class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar"></i>
                                {{ __('messages.reports') }}
                            </a>
                        </div>
                    @endcan
                    @can('settings_update')
                        <div class="nav-item">
                            <a href="{{ route('settings.index') }}"
                                class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
                                <i class="fas fa-cog"></i>
                                {{ __('messages.settings') }}
                            </a>
                        </div>
                    @endcan
                </div>
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
                <button class="action-btn" id="languageSwitcher" aria-label="Change Language">
                    <i class="fas fa-globe"></i>
                </button>
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="action-btn logout" aria-label="Logout">
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
