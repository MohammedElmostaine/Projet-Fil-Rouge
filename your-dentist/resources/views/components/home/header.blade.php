<!-- filepath: c:\Users\elmos\Desktop\Ycode\Projet-Fil-Rouge\your-dentist\resources\views\components\home\header.blade.php -->
<header class="bg-white shadow-sm sticky top-0 z-50 transition-all duration-300" id="main-header">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <a href="{{ route('home') }}" class="flex items-center">
                <span class="text-primary-600 text-3xl">
                    <i class="fas fa-tooth"></i>
                </span>
                <span class="font-bold text-xl text-primary-700">DentalCare</span>
            </a>
        </div>
        
        <!-- Navigation for larger screens -->
        <nav class="hidden lg:flex items-center space-x-8">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-primary-700 font-medium' : 'text-gray-600' }} hover:text-primary-500 transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 hover:after:w-full after:bg-primary-500 after:transition-all">Home</a>
            <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'text-primary-700 font-medium' : 'text-gray-600' }} hover:text-primary-500 transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 hover:after:w-full after:bg-primary-500 after:transition-all">Services</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-primary-700 font-medium' : 'text-gray-600' }} hover:text-primary-500 transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 hover:after:w-full after:bg-primary-500 after:transition-all">About</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-primary-700 font-medium' : 'text-gray-600' }} hover:text-primary-500 transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 hover:after:w-full after:bg-primary-500 after:transition-all">Contact</a>
        </nav>
        
        <!-- CTA Buttons -->
        <div class="hidden lg:flex items-center space-x-4">
            <a href="tel:+15551234567" class="text-primary-600 hover:text-primary-700 font-medium flex items-center">
                <i class="fas fa-phone-alt mr-2"></i> (555) 123-4567
            </a>
            
            @guest
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-full font-medium shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">Register</a>
                </div>
            @else
                <a href="{{ route('dashboard') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-full font-medium shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    Dashboard
                </a>
            @endguest
        </div>
        
        <!-- Mobile menu button -->
        <button class="lg:hidden text-primary-700 hover:text-primary-500" id="mobile-menu-button" aria-label="Open menu">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
    
    <!-- Mobile navigation menu (hidden by default) -->
    <div class="lg:hidden hidden bg-white pb-4 px-4 border-t border-gray-100" id="mobile-menu">
        <nav class="space-y-3 py-3">
            <a href="{{ route('home') }}" class="block py-2 {{ request()->routeIs('home') ? 'text-primary-700 font-medium border-l-4 border-primary-500 pl-3' : 'text-gray-600 hover:text-primary-600 hover:bg-primary-50 hover:border-l-4 hover:border-primary-400 pl-3 transition-all' }}">Home</a>
            <a href="{{ route('services') }}" class="block py-2 {{ request()->routeIs('services') ? 'text-primary-700 font-medium border-l-4 border-primary-500 pl-3' : 'text-gray-600 hover:text-primary-600 hover:bg-primary-50 hover:border-l-4 hover:border-primary-400 pl-3 transition-all' }}">Services</a>
            <a href="{{ route('about') }}" class="block py-2 {{ request()->routeIs('about') ? 'text-primary-700 font-medium border-l-4 border-primary-500 pl-3' : 'text-gray-600 hover:text-primary-600 hover:bg-primary-50 hover:border-l-4 hover:border-primary-400 pl-3 transition-all' }}">About</a>
            <a href="{{ route('contact') }}" class="block py-2 {{ request()->routeIs('contact') ? 'text-primary-700 font-medium border-l-4 border-primary-500 pl-3' : 'text-gray-600 hover:text-primary-600 hover:bg-primary-50 hover:border-l-4 hover:border-primary-400 pl-3 transition-all' }}">Contact</a>
            
            <div class="border-t border-gray-100 pt-2">
                @guest
                    <a href="{{ route('login') }}" class="block py-2 text-gray-600 hover:text-primary-600 hover:bg-primary-50 hover:border-l-4 hover:border-primary-400 pl-3 transition-all">Login</a>
                    <a href="{{ route('register') }}" class="block py-2 text-gray-600 hover:text-primary-600 hover:bg-primary-50 hover:border-l-4 hover:border-primary-400 pl-3 transition-all">Register</a>
                @else
                    <a href="{{ route('dashboard') }}" class="block py-2 text-gray-600 hover:text-primary-600 hover:bg-primary-50 hover:border-l-4 hover:border-primary-400 pl-3 transition-all">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left block py-2 text-gray-600 hover:text-primary-600 hover:bg-primary-50 hover:border-l-4 hover:border-primary-400 pl-3 transition-all">Logout</button>
                    </form>
                @endguest
            </div>
        </nav>
    </div>
</header>