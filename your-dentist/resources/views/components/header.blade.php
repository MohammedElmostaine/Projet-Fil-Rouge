<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-tooth text-white text-3xl mr-2"></i>
                <span class="text-2xl font-bold text-white">DentalCare</span>
            </div>
            <div class="hidden md:flex items-center space-x-4">
                <a href="/" class="text-secondary hover:text-primary transition">Home</a>
                @php
                    $profileRoute = '#';
                    $dashboardRoute = '#';
                    
                    if (Auth::user()->role === 'admin') {
                        $profileRoute = route('admin.profile');
                        $dashboardRoute = route('admin.dashboard');
                    } elseif (Auth::user()->role === 'doctor') {
                        $profileRoute = route('doctor.profile');
                        $dashboardRoute = route('doctor.dashboard');
                    } elseif (Auth::user()->role === 'assistant') {
                        $profileRoute = route('assistant.profile');
                        $dashboardRoute = route('assistant.dashboard');
                    } else {
                        $profileRoute = route('profile');
                        $dashboardRoute = route('dashboard');
                    }
                @endphp
                <a href="{{ $dashboardRoute }}" class="text-secondary hover:text-primary transition">Dashboard</a>
                <div class="relative group">
                    <button class="flex items-center text-secondary hover:text-primary transition">
                        <span class="mr-1">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md overflow-hidden invisible group-hover:visible transition-all z-50">
                        <a href="{{ $profileRoute }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary hover:text-white">Profile Settings</a>
                        @if(Auth::user()->role !== 'admin' && Auth::user()->role !== 'assistant')
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary hover:text-white">Medical Records</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-600 hover:text-white">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Make sure this button has the correct ID -->
            <button class="md:hidden text-secondary" id="mobile-menu-button">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>
    <!-- Make sure this div has the correct ID and is initially hidden -->
    <div class="hidden md:hidden bg-white border-t" id="mobile-menu">
        <div class="p-4 space-y-4">
            <a href="/" class="block text-secondary hover:text-primary">Home</a>
            <a href="{{ $dashboardRoute }}" class="block text-secondary hover:text-primary">Dashboard</a>
            <a href="{{ $profileRoute }}" class="block text-secondary hover:text-primary">Profile Settings</a>
            @if(Auth::user()->role !== 'admin' && Auth::user()->role !== 'assistant')
                <a href="#" class="block text-secondary hover:text-primary">Medical Records</a>
            @endif
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left text-red-600 hover:text-red-700">Logout</button>
            </form>
        </div>
    </div>
</header>

<script>
    const toggleSidebarBtn = document.getElementById('toggle-sidebar');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    
    if (toggleSidebarBtn && mobileSidebar) {
        toggleSidebarBtn.addEventListener('click', function() {
            mobileSidebar.classList.toggle('hidden');
        });
    }
</script>