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
                        primary: '#4F9BDF', // Light blue
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
    @include('components.footer')

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