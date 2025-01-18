<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #sidebar {
            position: fixed;
            top: 0;
            height: 100vh;
            width: 150px;
            background-color: #333;
            color: white;
            transition: left 0.3s ease, right 0.3s ease;
            z-index: 1000; /* Ensure it's above other content */
            left: -150px; /* Default hidden position for mobile */
        }
        [dir="rtl"] #sidebar {
            position: fixed;
            top: 0;
            height: 100vh;
            width: 150px;
            background-color: #333;
            color: white;
            transition: right 0.3s ease; /* Smooth transition for the sidebar */
            z-index: 1000; /* Ensure it's above other content */
            right: 0; /* Sidebar is visible by default on large screens */
        }

        #sidebar.show {
            left: 0;
        }


        /* RTL adjustments */
        [dir="rtl"] #sidebar {
            left: auto;
            right: 0px; /* Default RTL hidden position */
        }

        [dir="rtl"] #sidebar.show {
            right: -150px; /* Show the sidebar from the right side */
        }

        /* Content Area */
        .content-wrapper {
            display: flex; /* Enable flexbox for layout */
        }

        .content-area {
            flex-grow: 1; /* Allow content to take available space */
            margin-left: 0;
        }

        /* Adjust content area margin for RTL */
        [dir="rtl"] .content-area {
            margin-right: 0;
        }

        .btn-toggle-sidebar {
            position: fixed;
            top: 20px;
            z-index: 1001; /* Above the sidebar */
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .btn-toggle-sidebar img {
            width: 40px;
            height: auto;
        }

        /* RTL toggle button position */
        [dir="rtl"] .btn-toggle-sidebar {
            right: 20px;
            left: auto;
        }

        /* Hide toggle on medium and larger screens */
        @media (min-width: 768px) {
            .btn-toggle-sidebar {
                display: none; /* Hide toggle button on larger screens */
            }
            #sidebar {
                left: 0; /* Sidebar is always visible on larger screens */
            }
            .content-area {
                margin-left: 150px; /* Content adjusts to make space for the sidebar */
            }
            /* Adjust the content area for RTL languages */
            [dir="rtl"] .content-area {
                margin-right: 150px; /* Match sidebar width */
                margin-left: 0;
            }
        }

        /* Mobile view adjustments */
        @media (max-width: 767px) {
            #sidebar {
                left: -150px; /* Keep sidebar hidden off-screen */
            }
            [dir="rtl"] #sidebar {
                right: -150px; /* Keep sidebar hidden off-screen */
            }
            #sidebar.show {
                left: 0; /* Sidebar visible when toggled */
            }

            [dir="rtl"] #sidebar.show {
                right: 0px; /* Sidebar visible when toggled */
            }

            /* Ensure toggle button is visible */
            .btn-toggle-sidebar {
                display: block;
            }
        }

        #sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0; /* Reset default margins */
        }

        #sidebar .nav-item {
            padding: 8px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row content-wrapper">
            <!-- Sidebar -->
            <div id="sidebar">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="img-fluid mb-3">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link text-white" href="{{ url('/') }}"> {{__('messages.home')}} </a></li>
                    @can('users_list')
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('users.profile') }}">{{__('messages.profile')}} </a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('users.index') }}">{{__('messages.users')}} </a></li>
                    @endcan
                    <li class="nav-item"><a class="nav-link text-white" href="{{ url('/about') }}">{{__('messages.about')}} </a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ url('/contact') }}">{{__('messages.contact')}} </a></li>
                </ul>
            </div>

            <!-- Content Area -->
            <div class="content-area p-3">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Mobile Toggle Button -->
    <button class="btn-toggle-sidebar d-md-none" id="toggleSidebar" aria-label="Open Sidebar">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
    </button>

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle JS -->
    <script>
        document.getElementById("toggleSidebar").addEventListener("click", function() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("show");
            this.setAttribute('aria-label', sidebar.classList.contains("show") ? 'Close Sidebar' : 'Open Sidebar');
        });
    </script>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
