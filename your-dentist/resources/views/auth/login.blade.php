<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | DentalCare Clinic</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F9BDF', // Blue
                        secondary: '#2C3E50', // Dark blue
                        lightBlue: '#E0F7FA', // Light blue background
                        darkText: '#374151', // Dark gray for text
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='152' height='152' viewBox='0 0 152 152'%3E%3Cg fill-rule='evenodd'%3E%3Cg id='temple' fill='%234F9BDF' fill-opacity='0.05'%3E%3Cpath d='M152 150v2H0v-2h28v-8H8v-20H0v-2h8V80h42v20h20v42H30v8h90v-8H80v-42h20V80h42v40h8V30h-8v40h-42V50H80V8h40V0h2v8h20v20h8V0h2v150zm-2 0v-28h-8v20h-20v8h28zM82 30v18h18V30H82zm20 18h20v20h18V30h-20V10H82v18h20v20zm0 2v18h18V50h-18zm20-22h18V10h-18v18zm-54 92v-18H50v18h18zm-20-18H28V82H10v38h20v20h38v-18H48v-20zm0-2V82H30v18h18zm-20 22H10v18h18v-18zm54 0v18h38v-20h20V82h-18v20h-20v20H82zm18-20H82v18h18v-18zm2-2h18V82h-18v18zm20 40v-18h18v18h-18zM30 0h-2v8H8v20H0v2h8v40h42V50h20V8H30V0zm20 48h18V30H50v18zm18-20H48v20H28v20H10V30h20V10h38v18zM30 50h18v18H30V50zm-2-40H10v18h18V10z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-lightBlue min-h-screen flex flex-col justify-center items-center">
    <div class="max-w-md w-full mx-auto px-4">
        <!-- Logo & Header -->
        <div class="text-center mb-10">
            <div class="flex items-center justify-center mb-4">
                <i class="fas fa-tooth text-primary text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-secondary mb-2">DentalCare Clinic</h1>
            <p class="text-darkText text-sm">Sign in to access your account</p>
        </div>
        
        <!-- Login Form Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Form Header -->
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-semibold text-darkText">Welcome Back</h2>
                <p class="text-gray-500 text-sm mt-1">Please enter your credentials to continue</p>
            </div>
            
            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <!-- Email Input -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-darkText mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 ease-in-out" 
                            placeholder="your.email@example.com"
                            required>
                    </div>
                </div>
                
                <!-- Password Input -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-medium text-darkText">Password</label>
                        <a href="#" class="text-sm text-primary hover:text-primary/80 focus:outline-none focus:underline transition duration-150 ease-in-out">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 ease-in-out" 
                            placeholder="••••••••"
                            required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" id="togglePassword" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Remember Me -->
                <div class="flex items-center mb-6">
                    <input 
                        id="remember_me" 
                        name="remember_me" 
                        type="checkbox" 
                        class="h-4 w-4 rounded text-primary focus:ring-primary border-gray-300">
                    <label for="remember_me" class="ml-2 block text-sm text-darkText">
                        Remember me
                    </label>
                </div>
                
                <!-- Login Button -->
                <div class="mb-6">
                    <button 
                        type="submit" 
                        class="w-full flex justify-center items-center bg-primary hover:bg-primary/90 transition-all duration-150 ease-in-out py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In
                    </button>
                </div>
            </form>
            
            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">or</span>
                </div>
            </div>
            
            <!-- Alternative Login Options -->
            <div class="grid grid-cols-2 gap-4">
                <button class="flex items-center justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-darkText hover:bg-gray-50 transition-colors">
                    <i class="fab fa-google text-red-500 mr-2"></i>
                    Google
                </button>
                <button class="flex items-center justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-darkText hover:bg-gray-50 transition-colors">
                    <i class="fab fa-microsoft text-blue-500 mr-2"></i>
                    Microsoft
                </button>
            </div>
            
            <!-- Registration Link -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Don't have an account? 
                    <a href="{{route('register')}}" class="font-medium text-primary hover:text-primary/80 focus:outline-none focus:underline transition duration-150 ease-in-out">
                        Register now
                    </a>
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500">
                <span id="current-time">2025-03-23 23:56:06</span>
                <span class="mx-2">•</span>
                &copy; 2025 DentalCare Clinic. All rights reserved.
            </p>
            <div class="flex justify-center space-x-4 mt-4">
                <a href="#" class="text-xs text-gray-500 hover:text-primary">Privacy Policy</a>
                <a href="#" class="text-xs text-gray-500 hover:text-primary">Terms of Service</a>
                <a href="#" class="text-xs text-gray-500 hover:text-primary">Help Center</a>
            </div>
        </div>
    </div>

    <!-- JavaScript for password toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            
            togglePassword.addEventListener('click', function() {
                // Toggle password visibility
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                // Toggle icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
</html>