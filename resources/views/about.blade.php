<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About - Clinic Management System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --primary-light: #dbeafe;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --text-white: #ffffff;
            --bg-light: #f9fafb;
            --bg-white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --radius: 12px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Figtree, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .header {
            background-color: var(--bg-white);
            box-shadow: var(--shadow-sm);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .nav a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 600;
            margin-left: 1.5rem;
            transition: var(--transition);
            position: relative;
        }

        .nav a:hover {
            color: var(--primary);
        }

        .nav a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary);
            transition: var(--transition);
        }

        .nav a:hover::after {
            width: 100%;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .hero {
            text-align: center;
            padding: 80px 20px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: var(--text-white);
            border-radius: var(--radius);
            margin-bottom: 60px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.25rem;
            max-width: 600px;
            margin: 0 auto 2rem;
            opacity: 0.9;
        }

        .stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .stat {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 1rem 1.5rem;
            border-radius: var(--radius);
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            display: block;
        }

        .stat-text {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .section-title h2 {
            font-size: 2.25rem;
            color: var(--text-dark);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .section-title p {
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            margin: 1rem auto;
            border-radius: 2px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .feature {
            padding: 30px;
            border-radius: var(--radius);
            background: var(--bg-white);
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .feature::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary), var(--accent));
            transition: var(--transition);
        }

        .feature:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .feature:hover::before {
            width: 6px;
        }

        .feature h3 {
            margin-top: 0;
            color: var(--text-dark);
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .feature p {
            color: var(--text-light);
            line-height: 1.6;
        }

        .icon {
            width: 60px;
            height: 60px;
            margin-bottom: 1.5rem;
            padding: 12px;
            background-color: var(--primary-light);
            border-radius: 12px;
            color: var(--primary);
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .benefit-card {
            background: var(--bg-white);
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .benefit-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .benefit-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: white;
        }

        .benefit-card h3 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .benefit-card p {
            color: var(--text-light);
            flex-grow: 1;
        }

        .pricing-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 2rem;
        }

        .pricing-card {
            background: var(--bg-white);
            border-radius: var(--radius);
            padding: 2.5rem 2rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .pricing-card.popular {
            border: 2px solid var(--primary);
            transform: scale(1.05);
        }

        .pricing-card.popular::before {
            content: 'Most Popular';
            position: absolute;
            top: 0;
            right: 0;
            background: var(--primary);
            color: white;
            padding: 0.5rem 1.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            border-bottom-left-radius: var(--radius);
        }

        .pricing-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .pricing-card.popular:hover {
            transform: scale(1.05) translateY(-5px);
        }

        .pricing-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .price {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin: 1.5rem 0;
        }

        .price-period {
            font-size: 1rem;
            color: var(--text-light);
            font-weight: normal;
        }

        .pricing-features {
            list-style: none;
            margin: 1.5rem 0;
            text-align: left;
        }

        .pricing-features li {
            margin-bottom: 0.75rem;
            display: flex;
            align-items: flex-start;
        }

        .pricing-features li::before {
            content: '✓';
            color: var(--primary);
            font-weight: bold;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .btn {
            display: inline-block;
            padding: 12px 28px;
            background-color: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            max-width: 900px;
            margin: 3rem auto;
            position: relative;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--primary-light);
            z-index: 1;
        }

        .step {
            text-align: center;
            position: relative;
            z-index: 2;
            flex: 1;
            padding: 0 1rem;
        }

        .step-number {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 auto 1.5rem;
            box-shadow: var(--shadow);
        }

        .step h3 {
            margin-bottom: 0.75rem;
            color: var(--text-dark);
        }

        .step p {
            color: var(--text-light);
        }

        .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .contact-card {
            background: var(--bg-white);
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: var(--shadow);
            text-align: center;
            transition: var(--transition);
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--primary);
        }

        .contact-card h3 {
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .contact-card p {
            color: var(--text-light);
        }

        .cta {
            text-align: center;
            margin-top: 80px;
            padding: 60px 40px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: var(--radius);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .cta-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
            margin: 0 auto;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .cta p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .cta .btn {
            background: white;
            color: var(--primary);
            font-size: 1.1rem;
            padding: 15px 35px;
        }

        .cta .btn:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .footer {
            text-align: center;
            padding: 40px 20px;
            background-color: var(--text-dark);
            color: white;
            margin-top: 80px;
        }

        .footer p {
            opacity: 0.8;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.25rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .stats {
                gap: 1rem;
            }

            .stat {
                padding: 0.75rem 1rem;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .steps {
                flex-direction: column;
                gap: 2rem;
            }

            .steps::before {
                display: none;
            }

            .pricing-card.popular {
                transform: none;
            }

            .pricing-card.popular:hover {
                transform: translateY(-5px);
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <nav class="nav">
            <a href="{{ url('/') }}">Home</a>
            <div>
                <a href="{{ route('about') }}">About</a>
                @auth
                    <a href="{{ url('/reservations/create') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                @endauth
            </div>
        </nav>
    </header>

    <div class="container">
        <section class="hero">
            <div class="hero-content">
                <h1>Empowering Doctor-Owned Clinics for Better Patient Care</h1>
                <p>Welcome to the Clinic Management System, a cutting-edge solution designed specifically for
                    doctor-owned clinics. Join over 500+ clinics nationwide who have revolutionized their operations.
                </p>

                <div class="stats">
                    <div class="stat">
                        <span class="stat-number">40%</span>
                        <span class="stat-text">Reduction in Administrative Time</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">60%</span>
                        <span class="stat-text">Fewer No-Shows</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">85%</span>
                        <span class="stat-text">Increase in Patient Satisfaction</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="features-section">
            <div class="section-title">
                <h2>Powerful Features for Your Clinic</h2>
                <p>Our comprehensive suite of tools is designed to streamline your clinic operations and enhance patient
                    care</p>
            </div>

            <div class="features">
                <div class="feature">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3>Comprehensive Reservation Management</h3>
                    <p>Seamless scheduling with online booking, intelligent time-slot management, advanced filtering,
                        procedure assignment, and detailed reservation notes for personalized patient care and efficient
                        follow-up.</p>
                </div>

                <div class="feature">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                    <h3>User and Role Management</h3>
                    <p>Role-based access for Admins, Secretaries, and Patients. Manage patient profiles, staff
                        oversight, and ensure data integrity with secure permissions tailored for healthcare compliance.
                    </p>
                </div>

                <div class="feature">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3>Procedure and Pricing Control</h3>
                    <p>Dynamic procedure management with descriptions and pricing. Transparent billing tracking for
                        accurate invoicing and cost management across all reservations.</p>
                </div>

                <div class="feature">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3>Working Days and Availability</h3>
                    <p>Flexible scheduling for clinic operating hours. Real-time visibility of available slots for
                        patients and staff, accommodating varying needs and ensuring optimal clinic utilization.</p>
                </div>

                <div class="feature">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    <h3>Reporting and Insights</h3>
                    <p>Comprehensive analytics on clinic performance, revenue trends, and patient data. Operational
                        insights for strategic planning and data-driven decision-making.</p>
                </div>

                <div class="feature">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3>Settings and Customization</h3>
                    <p>Branding options with logo uploads and custom settings. Full multilingual support for English and
                        Arabic, ensuring accessibility for diverse patient bases.</p>
                </div>
            </div>
        </section>

        <section class="benefits" style="margin-top: 100px;">
            <div class="section-title">
                <h2>Benefits You'll Experience</h2>
                <p>Discover how our system transforms clinic operations and enhances patient care</p>
            </div>

            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3>Operational Excellence</h3>
                    <p>Reduce administrative burden with automated scheduling and record-keeping. Minimize errors with
                        intelligent systems preventing conflicts. Streamline workflows from check-in to billing for
                        speed and accuracy.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5">
                            </path>
                        </svg>
                    </div>
                    <h3>Enhanced Patient Satisfaction</h3>
                    <p>Convenient 24/7 self-service appointment management. Personalized care through detailed profiles
                        and notes. Transparent communication with clear interfaces and multilingual options.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                            </path>
                        </svg>
                    </div>
                    <h3>Financial Advantages</h3>
                    <p>Increase revenue through efficient scheduling and reduced no-shows. Cost savings from digital
                        workflows eliminating paper processes. Data-driven decisions to optimize pricing and services.
                    </p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3>Security & Compliance</h3>
                    <p>Advanced data protection with HIPAA compliance and end-to-end encryption. Audit trails for
                        accountability and role-based security. Regulatory compliance with SOC 2 certification.</p>
                </div>
            </div>
        </section>

        <section class="pricing" style="margin-top: 100px;">
            <div class="section-title">
                <h2>Pricing and Plans</h2>
                <p>Flexible pricing options designed for clinics of all sizes</p>
            </div>

            <div class="pricing-cards">
                <div class="pricing-card">
                    <h3>Starter Plan</h3>
                    <div class="price">$29<span class="price-period">/month</span></div>
                    <p>Ideal for small clinics with basic needs</p>

                    <ul class="pricing-features">
                        <li>Up to 5 users</li>
                        <li>Basic reservation management</li>
                        <li>Patient profiles</li>
                        <li>Email support</li>
                    </ul>

                    <a href="#" class="btn btn-outline btn-block">Get Started</a>
                </div>

                <div class="pricing-card popular">
                    <h3>Professional Plan</h3>
                    <div class="price">$59<span class="price-period">/month</span></div>
                    <p>For growing practices with advanced needs</p>

                    <ul class="pricing-features">
                        <li>Up to 15 users</li>
                        <li>Advanced reporting</li>
                        <li>Custom settings</li>
                        <li>Priority support</li>
                        <li>Multilingual support</li>
                    </ul>

                    <a href="#" class="btn btn-block">Get Started</a>
                </div>

                <div class="pricing-card">
                    <h3>Enterprise Plan</h3>
                    <div class="price">$99<span class="price-period">/month</span></div>
                    <p>Full suite for large clinics</p>

                    <ul class="pricing-features">
                        <li>Unlimited users</li>
                        <li>Custom integrations</li>
                        <li>Dedicated account manager</li>
                        <li>24/7 phone support</li>
                        <li>Advanced security features</li>
                    </ul>

                    <a href="#" class="btn btn-outline btn-block">Get Started</a>
                </div>
            </div>

            <p style="text-align: center; margin-top: 30px; color: var(--text-light);">All plans include free setup,
                regular updates, data backup, and 99.9% uptime guarantee.</p>
        </section>

        <section class="getting-started" style="margin-top: 100px;">
            <div class="section-title">
                <h2>Getting Started</h2>
                <p>Transform your clinic today with our easy implementation process</p>
            </div>

            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Schedule Consultation</h3>
                    <p>Book a free consultation and demo tailored to your clinic's needs</p>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Customize System</h3>
                    <p>We'll customize the system to match your clinic's workflows and requirements</p>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Team Training</h3>
                    <p>Comprehensive training for your staff to ensure smooth adoption</p>
                </div>

                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Go Live</h3>
                    <p>Launch with our ongoing support to ensure success</p>
                </div>
            </div>
        </section>

        <section class="contact" style="margin-top: 100px;">
            <div class="section-title">
                <h2>Contact Us</h2>
                <p>Ready to revolutionize your clinic operations? Let's talk!</p>
            </div>

            <div class="contact-info">
                <div class="contact-card">
                    <div class="contact-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3>Email</h3>
                    <p>sales@clinicmanagement.com</p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                    </div>
                    <h3>Phone</h3>
                    <p>+1 (555) 123-4567</p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9a9 9 0 00-9 9m9-9V3m0 18v-9m0 0h9m-9 0H3">
                            </path>
                        </svg>
                    </div>
                    <h3>Website</h3>
                    <p>www.clinicmanagement.com</p>
                </div>
            </div>

            <p
                style="text-align: center; margin-top: 30px; color: var(--text-light); max-width: 600px; margin-left: auto; margin-right: auto;">
                Invest in the future of healthcare management. Subscribe now and see the difference in just 30 days!
            </p>
        </section>

        <section class="cta">
            <div class="cta-content">
                <h2>Ready to Transform Your Clinic?</h2>
                <p>Join over 500 clinics that have improved efficiency and patient care with our system</p>
                <a href="{{ route('login') }}" class="btn">Get Started Today</a>
            </div>
        </section>
    </div>

    <footer class="footer">
        <p>&copy; 2023 Clinic Management System. All rights reserved.</p>
    </footer>
</body>

</html>
