<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | DentalCare Clinic</title>
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
<body class="bg-lightBlue min-h-screen flex flex-col justify-center items-center py-12">
    <div class="max-w-lg w-full mx-auto px-4">
        <!-- Logo & Header -->
        <div class="text-center mb-10">
            <div class="flex items-center justify-center mb-4">
                <i class="fas fa-tooth text-primary text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-secondary mb-2">DentalCare Clinic</h1>
            <p class="text-darkText text-sm">Create a new account</p>
        </div>
        
        <!-- Registration Form Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Form Header -->
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-semibold text-darkText">Sign Up</h2>
                <p class="text-gray-500 text-sm mt-1">Please fill in the details to create your account</p>
            </div>
            
            <!-- Registration Form -->
            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                
                @if(session('error'))
                    <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-600">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4 p-4 rounded-lg bg-red-50">
                        <div class="font-medium text-red-600">
                            Please fix the following errors:
                        </div>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Full Name Input -->
                <div class="mb-5">
                    <label for="fullName" class="block text-sm font-medium text-darkText mb-2">Full Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input 
                            type="text" 
                            id="fullName" 
                            name="fullName" 
                            value="{{ old('fullName') }}"
                            class="block w-full pl-10 pr-4 py-3 border @error('fullName') border-red-500 @else border-gray-200 @enderror rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 ease-in-out" 
                            placeholder="John Smith"
                            required>
                    </div>
                    @error('fullName')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email Input -->
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-darkText mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="block w-full pl-10 pr-4 py-3 border @error('email') border-red-500 @else border-gray-200 @enderror rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 ease-in-out" 
                            placeholder="your.email@example.com"
                            required>
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Phone Number Input -->
                <div class="mb-5">
                    <label for="phone" class="block text-sm font-medium text-darkText mb-2">Phone Number</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone') }}"
                            class="block w-full pl-10 pr-4 py-3 border @error('phone') border-red-500 @else border-gray-200 @enderror rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 ease-in-out" 
                            placeholder="(123) 456-7890"
                            required>
                    </div>
                    @error('phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Date of Birth Input -->
                <div class="mb-5">
                    <label for="date_of_birth" class="block text-sm font-medium text-darkText mb-2">Date of Birth</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar text-gray-400"></i>
                        </div>
                        <input 
                            type="date" 
                            id="date_of_birth" 
                            name="date_of_birth" 
                            value="{{ old('date_of_birth') }}"
                            class="block w-full pl-10 pr-4 py-3 border @error('date_of_birth') border-red-500 @else border-gray-200 @enderror rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 ease-in-out" 
                            required>
                    </div>
                    @error('date_of_birth')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender Input -->
                <div class="mb-5">
                    <label for="gender" class="block text-sm font-medium text-darkText mb-2">Gender</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-venus-mars text-gray-400"></i>
                        </div>
                        <select 
                            id="gender" 
                            name="gender" 
                            class="block w-full pl-10 pr-4 py-3 border @error('gender') border-red-500 @else border-gray-200 @enderror rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 ease-in-out appearance-none bg-white" 
                            required>
                            <option value="">Select gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @error('gender')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Password Input -->
                <div class="mb-5">
                    <label for="password" class="block text-sm font-medium text-darkText mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="block w-full pl-10 pr-10 py-3 border @error('password') border-red-500 @else border-gray-200 @enderror rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 ease-in-out" 
                            placeholder="Create a strong password"
                            required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" id="togglePassword" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters long with letters and numbers</p>
                </div>
                
                <!-- Confirm Password Input -->
                <div class="mb-5">
                    <label for="password_confirmation" class="block text-sm font-medium text-darkText mb-2">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="block w-full pl-10 pr-4 py-3 border @error('password_confirmation') border-red-500 @else border-gray-200 @enderror rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 ease-in-out" 
                            placeholder="Confirm your password"
                            required>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Terms & Conditions -->
                <div class="flex items-start mb-6">
                    <div class="flex items-center h-5">
                        <input 
                            id="terms" 
                            name="terms" 
                            type="checkbox" 
                            class="h-4 w-4 rounded text-primary focus:ring-primary border-gray-300"
                            required>
                    </div>
                    <label for="terms" class="ml-2 block text-sm text-gray-600">
                        I agree to the 
                        <a href="#" class="text-primary hover:text-primary/80 underline">Terms of Service</a> and 
                        <a href="#" class="text-primary hover:text-primary/80 underline">Privacy Policy</a>
                    </label>
                </div>
                
                <!-- Register Button -->
                <div class="mb-6">
                    <button 
                        type="submit" 
                        class="w-full flex justify-center items-center bg-primary hover:bg-primary/90 transition-all duration-150 ease-in-out py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="fas fa-user-plus mr-2"></i>
                        Create Account
                    </button>
                </div>
            </form>
            
            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">or register with</span>
                </div>
            </div>
            
            <!-- Social Registration Options -->
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
            
            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Already have an account? 
                    <a href="{{route('login')}}" class="font-medium text-primary hover:text-primary/80 focus:outline-none focus:underline transition duration-150 ease-in-out">
                        Sign in
                    </a>
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500">
                <span id="current-time">2025-03-23 23:59:51</span>
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

    <!-- JavaScript for password toggle and validation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
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
            
            // Form validation
            const registrationForm = document.querySelector('form');
            const confirmPassword = document.getElementById('password_confirmation');
            
            registrationForm.addEventListener('submit', function(event) {
                // Password matching validation
                if(password.value !== confirmPassword.value) {
                    event.preventDefault();
                    alert('Passwords do not match!');
                    confirmPassword.focus();
                    confirmPassword.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                }
            });
        });
    </script>
</body>
</html>
