<!-- filepath: resources/views/layouts/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: '#2C3E50', // Dark blue
                        accent: '#E5F4FF', // Light blue background
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Merriweather', 'serif'],
                    },
                }
            }
        }
    </script>
    <style>
        /* Force footer background color */
        footer {
            background-color: #075985 !important; /* primary-800 color */
            color: white !important;
        }
        footer a, footer p, footer span, footer div {
            color: inherit;
        }
        footer .text-primary-100 {
            color: #e0f2fe !important;
        }
        footer .text-primary-200, footer .text-primary-300 {
            color: #bae6fd !important;
        }
        footer .border-primary-700 {
            border-color: #0369a1 !important;
        }
        footer .after\:bg-primary-400::after {
            background-color: #38bdf8 !important;
        }

        /* Ensure navbar consistency */
        header, nav {
            background-color: #075985 !important; /* primary-800 to match footer */
            color: white !important;
        }
        
        /* Fix navigation links and logo colors */
        header a, nav a, 
        header .text-black, nav .text-black,
        header svg, nav svg, 
        header img, nav img {
            color: white !important;
            fill: white !important;
        }
        
        /* Fix any hover states */
        header a:hover, nav a:hover {
            color: #e0f2fe !important; /* primary-100 */
        }
        
        /* Fix button colors in the navbar */
        header button, nav button {
            color: white !important;
        }
        
        /* Enhanced dropdown menu styling */
        .dropdown-menu,
        nav .dropdown-menu,
        header .dropdown-menu,
        .dropdown-content,
        .dropdown div[role="menu"],
        .absolute.mt-2,
        .origin-top-right {
            background-color: #075985 !important;
            color: white !important;
            border: 1px solid #0369a1 !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3) !important;
        }
        
        /* Fix dropdown links */
        .dropdown-menu a,
        nav .dropdown-menu a,
        header .dropdown-menu a,
        .dropdown-content a,
        .dropdown div[role="menu"] a,
        .absolute.mt-2 a,
        .origin-top-right a {
            color: white !important;
            display: block !important;
            padding: 0.5rem 1rem !important;
        }
        
        /* Dropdown hover effects */
        .dropdown-menu a:hover,
        nav .dropdown-menu a:hover,
        header .dropdown-menu a:hover,
        .dropdown-content a:hover,
        .dropdown div[role="menu"] a:hover,
        .absolute.mt-2 a:hover,
        .origin-top-right a:hover {
            background-color: #0369a1 !important; /* primary-700 */
            color: #e0f2fe !important; /* primary-100 */
        }
        
        /* Fix dropdown dividers */
        .dropdown-divider,
        .border-t,
        .border-gray-200 {
            border-color: #0369a1 !important; /* primary-700 */
        }
    </style>
</head>
<body class="font-sans text-gray-800 bg-gray-100">
    <!-- Header -->
    @include('components.header')

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="w-full">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    @include('components.home.footer')

    <!-- Mobile menu toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            // Debug check
            console.log('Mobile menu button:', mobileMenuButton);
            console.log('Mobile menu:', mobileMenu);
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    console.log('Toggle mobile menu - hidden:', mobileMenu.classList.contains('hidden'));
                });
            } else {
                console.error('Mobile menu elements not found');
            }
        });
    </script>
</body>
</html>