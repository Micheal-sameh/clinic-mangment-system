<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Initially hide the sidebar off-screen */
        #sidebar {
            position: fixed;
            top: 0;
            left: -150px;  /* Sidebar hidden off-screen by default */
            height: 100vh;
            width: 150px;  /* Reduced sidebar width */
            background-color: #333;
            color: white;
            transition: left 0.3s ease;
            z-index: 999;
        }

        /* Sidebar visible on mobile and desktop when toggled */
        #sidebar.show {
            left: 0;
        }

        /* Sidebar navigation items */
        #sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        #sidebar .nav-item {
            padding: 8px;  /* Reduced padding for the smaller sidebar */
        }

        /* Logo button to toggle sidebar */
        .btn-toggle-sidebar {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        /* Ensure the logo doesn't overflow and keeps the correct size */
        .btn-toggle-sidebar img {
            width: 35px;  /* Reduced logo size for smaller sidebar */
            height: auto;
        }

        /* Hide the toggle button on medium and larger screens */
        @media (min-width: 768px) {
            .btn-toggle-sidebar {
                display: none;  /* Hide on medium+ screens */
            }

            /* For medium and larger screens, the sidebar should always be visible */
            #sidebar {
                left: 0;  /* Sidebar always visible on larger screens */
            }

            /* Adjust content area to accommodate the smaller sidebar */
            .content-wrapper {
                display: flex;
                flex-direction: row;
            }

            .content-area {
                margin-left: 150px;  /* Adjusted for the smaller sidebar width */
            }
        }

        /* On smaller screens, the content area should take full width */
        @media (max-width: 768px) {
            .content-wrapper {
                display: block;
            }

            .content-area {
                margin-left: 0;
            }
        }

    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row content-wrapper">
            <!-- Sidebar (Hidden by default on small screens) -->
            <div id="sidebar" class="col-12 col-md-3 col-lg-2 bg-dark text-white p-3">
                <h3>My Sidebar</h3>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/') }}">Home</a>
                    </li>
                    @can('users_list')
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('users.index') }}">Users</a>
                    </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/contact') }}">Contact</a>
                    </li>
                </ul>
            </div>

            <!-- Main Content Area -->
            <div class="col-12 col-md-9 col-lg-10 content-area p-3">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Logo Button to Toggle Sidebar (Visible on Mobile) -->
    <button class="btn-toggle-sidebar d-md-none" id="toggleSidebar">
        <!-- Logo image for the button -->
        <img src="{{ asset('images/logo.png') }}" alt="Logo">  <!-- Replace with your logo image -->
    </button>

    <!-- Add Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript to Handle Sidebar Toggle -->
    <script>
        // Toggle sidebar visibility on mobile when the logo button is clicked
        document.getElementById("toggleSidebar").addEventListener("click", function() {
            var sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("show");  // Toggle the sidebar visibility

            // Toggle the button text (optional, to indicate open/close action)
            if (sidebar.classList.contains("show")) {
                this.setAttribute('aria-label', 'Close Sidebar');  // Change aria-label for accessibility
            } else {
                this.setAttribute('aria-label', 'Open Sidebar');   // Change aria-label for accessibility
            }
        });
    </script>
</body>
</html>
