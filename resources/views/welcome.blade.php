<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
@php
    $logo = app()->make('App\Repositories\SettingRepository')->getLogo() ?: asset('images/logo.jpg');
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME', 'Clinic Management') }}</title>
    <link rel="icon" href="{{ $logo }}" type="image/jpg">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0d9488;
            --primary-dark: #0f766e;
            --primary-darker: #134e4a;
            --primary-light: #5eead4;
            --primary-xlight: #ccfbf1;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; color: #1e293b; overflow-x: hidden; }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #134e4a 55%, #0f766e 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .hero-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            animation: floatHero 12s ease-in-out infinite;
        }
        .hero-shape-1 { width: 500px; height: 500px; top: -150px; right: -100px; animation-delay: 0s; }
        .hero-shape-2 { width: 300px; height: 300px; bottom: -80px; left: -60px; animation-delay: 4s; }
        .hero-shape-3 { width: 180px; height: 180px; top: 30%; left: 15%; animation-delay: 2s; }
        @keyframes floatHero {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.03); }
        }

        /* Navbar */
        .hero-nav {
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative; z-index: 10;
        }
        .nav-brand {
            display: flex; align-items: center; gap: 0.875rem;
        }
        .nav-logo {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 8px;
            object-fit: contain;
        }
        .nav-app-name {
            font-size: 1.25rem; font-weight: 700;
            color: white; letter-spacing: -0.01em;
        }
        .nav-links { display: flex; align-items: center; gap: 0.75rem; }
        .nav-link {
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .nav-link:hover { background: rgba(255,255,255,0.1); color: white; }
        .nav-btn {
            background: linear-gradient(135deg, #0d9488, #0891b2);
            color: white !important;
            border-radius: 10px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(13,148,136,0.35);
        }
        .nav-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(13,148,136,0.45);
        }

        /* Hero Content */
        .hero-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem 5rem;
            text-align: center;
            position: relative; z-index: 5;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(13,148,136,0.25);
            border: 1px solid rgba(94,234,212,0.30);
            color: var(--primary-light);
            font-size: 0.82rem; font-weight: 600;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            margin-bottom: 1.5rem;
            text-transform: uppercase; letter-spacing: 0.08em;
        }
        .hero-title {
            font-size: clamp(2.4rem, 6vw, 4.5rem);
            font-weight: 800;
            color: white;
            line-height: 1.1;
            letter-spacing: -0.02em;
            margin-bottom: 1.5rem;
        }
        .hero-title span {
            background: linear-gradient(135deg, #5eead4, #67e8f9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-subtitle {
            font-size: 1.15rem;
            color: rgba(255,255,255,0.68);
            max-width: 580px;
            margin: 0 auto 2.5rem;
            line-height: 1.7;
        }
        .hero-cta { display: flex; align-items: center; justify-content: center; gap: 1rem; flex-wrap: wrap; }
        .btn-hero-primary {
            background: linear-gradient(135deg, #0d9488, #0891b2);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 0.9rem 2.5rem;
            font-weight: 700; font-size: 1.05rem;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 8px 25px rgba(13,148,136,0.40);
            display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(13,148,136,0.50);
            color: white;
        }
        .btn-hero-secondary {
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            border-radius: 14px;
            padding: 0.9rem 2.5rem;
            font-weight: 600; font-size: 1.05rem;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex; align-items: center; gap: 0.5rem;
            backdrop-filter: blur(8px);
        }
        .btn-hero-secondary:hover {
            background: rgba(255,255,255,0.18);
            transform: translateY(-3px);
            color: white;
        }

        /* Stats bar */
        .hero-stats {
            display: flex; justify-content: center; gap: 3rem; flex-wrap: wrap;
            padding: 1.5rem 2rem 3rem;
            position: relative; z-index: 5;
        }
        .stat-item {
            text-align: center;
        }
        .stat-value {
            font-size: 2rem; font-weight: 800; color: white; line-height: 1;
        }
        .stat-label {
            font-size: 0.78rem; color: rgba(255,255,255,0.55);
            text-transform: uppercase; letter-spacing: 0.08em;
            margin-top: 0.3rem;
        }
        .stat-divider {
            width: 1px; background: rgba(255,255,255,0.12);
            align-self: stretch;
        }

        /* Wave */
        .hero-wave { display: block; margin-bottom: -4px; }

        /* Features */
        .features-section {
            background: #f0fdfa;
            padding: 5rem 1.5rem;
        }
        .section-label {
            display: inline-block;
            background: var(--primary-xlight);
            color: var(--primary-dark);
            font-size: 0.78rem; font-weight: 700;
            padding: 0.35rem 1rem;
            border-radius: 50px;
            text-transform: uppercase; letter-spacing: 0.1em;
            margin-bottom: 1rem;
        }
        .section-title {
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }
        .section-title span {
            background: linear-gradient(135deg, var(--primary), #0891b2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .section-subtitle {
            color: #64748b; font-size: 1.05rem; max-width: 520px; margin: 0 auto; line-height: 1.7;
        }

        .feature-card {
            background: white;
            border: 1px solid rgba(13,148,136,0.10);
            border-radius: 20px;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 40px rgba(13,148,136,0.12);
            border-color: rgba(13,148,136,0.20);
        }
        .feature-icon {
            width: 56px; height: 56px;
            border-radius: 15px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 1.25rem;
        }
        .feature-icon.teal { background: linear-gradient(135deg, #ccfbf1, #99f6e4); color: var(--primary); }
        .feature-icon.blue { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #2563eb; }
        .feature-icon.green { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #16a34a; }
        .feature-icon.amber { background: linear-gradient(135deg, #fef9c3, #fde047); color: #d97706; }
        .feature-icon.rose { background: linear-gradient(135deg, #ffe4e6, #fecdd3); color: #e11d48; }
        .feature-icon.violet { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #7c3aed; }
        .feature-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 0.6rem; }
        .feature-desc { font-size: 0.9rem; color: #64748b; line-height: 1.65; }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #0891b2 100%);
            padding: 5rem 1.5rem;
            text-align: center;
            position: relative; overflow: hidden;
        }
        .cta-shape {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
        .cta-shape-1 { width: 400px; height: 400px; top: -200px; right: -100px; }
        .cta-shape-2 { width: 250px; height: 250px; bottom: -100px; left: -50px; }
        .cta-section h2 { font-size: clamp(1.8rem, 4vw, 2.5rem); font-weight: 800; color: white; margin-bottom: 1rem; }
        .cta-section p { color: rgba(255,255,255,0.72); font-size: 1.05rem; max-width: 500px; margin: 0 auto 2rem; }

        /* Footer */
        footer {
            background: #0f172a;
            padding: 2rem 1.5rem;
            text-align: center;
            color: rgba(255,255,255,0.45);
            font-size: 0.875rem;
        }
        footer a { color: var(--primary-light); text-decoration: none; }
        footer a:hover { color: white; }

        @media (max-width: 576px) {
            .hero-nav { padding: 1rem; }
            .nav-links .nav-link:not(.nav-btn) { display: none; }
            .hero-stats { gap: 1.5rem; }
            .stat-divider { display: none; }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <!-- Background shapes -->
        <div class="hero-shape hero-shape-1"></div>
        <div class="hero-shape hero-shape-2"></div>
        <div class="hero-shape hero-shape-3"></div>

        <!-- Navbar -->
        <nav class="hero-nav">
            <div class="nav-brand">
                <img src="{{ $logo }}" alt="Logo" class="nav-logo">
                <span class="nav-app-name">{{ env('APP_NAME', 'Clinic') }}</span>
            </div>
            <div class="nav-links">
                @auth
                    <a href="{{ url('/home') }}" class="nav-link nav-btn">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('loginPage') }}" class="nav-link">
                        {{ __('messages.login') ?? 'Login' }}
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link nav-btn">
                            {{ __('messages.register') ?? 'Register' }}
                            <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    @endif
                @endauth
            </div>
        </nav>

        <!-- Hero Body -->
        <div class="hero-content">
            <div>
                <div class="hero-badge">
                    <i class="fas fa-plus-circle"></i>
                    Premium Healthcare Platform
                </div>
                <h1 class="hero-title">
                    Modern <span>Clinic</span><br>Management System
                </h1>
                <p class="hero-subtitle">
                    Streamline your clinic operations with a powerful, elegant platform built for healthcare professionals. Manage reservations, patients, doctors, and reports — all in one place.
                </p>
                <div class="hero-cta">
                    @auth
                        <a href="{{ url('/home') }}" class="btn-hero-primary">
                            <i class="fas fa-tachometer-alt"></i> Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('loginPage') }}" class="btn-hero-primary">
                            <i class="fas fa-sign-in-alt"></i>
                            {{ __('messages.login') ?? 'Get Started' }}
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-hero-secondary">
                                {{ __('messages.register') ?? 'Create Account' }}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="hero-stats">
            <div class="stat-item">
                <div class="stat-value">∞</div>
                <div class="stat-label">Patients</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-value">24/7</div>
                <div class="stat-label">Access</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-value">100%</div>
                <div class="stat-label">Secure</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-value">RTL</div>
                <div class="stat-label">Arabic Support</div>
            </div>
        </div>

        <!-- Wave -->
        <svg class="hero-wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none">
            <path fill="#f0fdfa" d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z"/>
        </svg>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <div class="section-label">Features</div>
                <h2 class="section-title mb-3">Everything You Need to<br>Run <span>Your Clinic</span></h2>
                <p class="section-subtitle">
                    A complete suite of tools designed specifically for modern healthcare facilities and medical practitioners.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon teal"><i class="fas fa-calendar-check"></i></div>
                        <h3 class="feature-title">Smart Reservations</h3>
                        <p class="feature-desc">Manage appointments effortlessly with real-time scheduling, status tracking, and automated workflows for your entire clinic.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon blue"><i class="fas fa-user-injured"></i></div>
                        <h3 class="feature-title">Patient Management</h3>
                        <p class="feature-desc">Maintain comprehensive patient records, medical history, contact information, and visit notes all in one centralized system.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon green"><i class="fas fa-user-md"></i></div>
                        <h3 class="feature-title">Doctor Profiles</h3>
                        <p class="feature-desc">Manage doctor information, specializations, working schedules, and assignments to deliver optimal patient care.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon amber"><i class="fas fa-chart-line"></i></div>
                        <h3 class="feature-title">Analytics & Reports</h3>
                        <p class="feature-desc">Gain powerful insights with visual charts, income tracking, patient growth metrics, and detailed statistical reports.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon rose"><i class="fas fa-stethoscope"></i></div>
                        <h3 class="feature-title">Procedures Catalog</h3>
                        <p class="feature-desc">Manage your clinic's medical procedures and services with pricing, descriptions, and assignment to reservations.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon violet"><i class="fas fa-shield-alt"></i></div>
                        <h3 class="feature-title">Role-Based Access</h3>
                        <p class="feature-desc">Granular permissions system with role-based access control ensures every staff member sees exactly what they need.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-shape cta-shape-1"></div>
        <div class="cta-shape cta-shape-2"></div>
        <div style="position: relative; z-index: 5;">
            <h2>Ready to Transform Your Clinic?</h2>
            <p>Join healthcare professionals who trust our platform to manage their clinics efficiently and deliver better patient care.</p>
            @auth
                <a href="{{ url('/home') }}" class="btn-hero-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-arrow-right"></i> Go to Dashboard
                </a>
            @else
                <a href="{{ route('loginPage') }}" class="btn-hero-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-sign-in-alt"></i> {{ __('messages.login') ?? 'Sign In Now' }}
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>
            &copy; {{ date('Y') }} {{ env('APP_NAME', 'Clinic Management System') }}.
            Built with <i class="fas fa-heart" style="color: #ef4444;"></i> for Healthcare.
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
