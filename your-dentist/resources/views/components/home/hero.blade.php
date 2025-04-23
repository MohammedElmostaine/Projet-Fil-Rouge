<!-- filepath: c:\Users\elmos\Desktop\Ycode\Projet-Fil-Rouge\your-dentist\resources\views\components\home\hero.blade.php -->
<section class="relative bg-gradient-to-r from-primary-800 to-primary-500 text-white overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
        <svg class="absolute top-0 right-0 opacity-20" width="404" height="404" fill="none" viewBox="0 0 404 404">
            <defs>
                <pattern id="85737c0e-0916-41d7-917f-596dc7edfa27" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect x="0" y="0" width="4" height="4" fill="currentColor" />
                </pattern>
            </defs>
            <rect width="404" height="404" fill="url(#85737c0e-0916-41d7-917f-596dc7edfa27)" />
        </svg>
        <svg class="absolute bottom-0 left-0 opacity-20" width="404" height="404" fill="none" viewBox="0 0 404 404">
            <defs>
                <pattern id="85737c0e-0916-41d7-917f-596dc7edfa28" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect x="0" y="0" width="4" height="4" fill="currentColor" />
                </pattern>
            </defs>
            <rect width="404" height="404" fill="url(#85737c0e-0916-41d7-917f-596dc7edfa28)" />
        </svg>
    </div>
    
    <div class="container mx-auto px-4 py-20 md:py-28 flex flex-col md:flex-row items-center relative z-10">
        <div class="md:w-1/2 mb-10 md:mb-0" data-aos="fade-right" data-aos-duration="1000">
            <span class="bg-primary-900 bg-opacity-50 text-primary-100 text-sm font-semibold px-3 py-1 rounded-full mb-5 inline-block">Premier Dental Care Services</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-4">Your Smile Is <span class="text-primary-200">Our Priority</span></h1>
            <p class="text-xl mb-8 text-primary-50 opacity-90 max-w-lg">Professional dental care with a gentle touch. Experience comfort and excellence in every treatment with our highly trained specialists.</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('register') }}" class="bg-white text-primary-600 hover:bg-gray-100 px-8 py-3 rounded-full font-medium text-lg inline-flex items-center shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    Book Appointment
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
                <a href="#services" class="border border-white text-white hover:bg-white hover:text-primary-600 px-8 py-3 rounded-full font-medium text-lg inline-flex items-center transition-all">
                    Our Services
                    <i class="fas fa-chevron-right ml-2 text-sm"></i>
                </a>
            </div>
            <div class="mt-8 flex items-center space-x-4 text-primary-100">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>Modern Equipment</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>Expert Dentists</span>
                </div>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center" data-aos="fade-up" data-aos-duration="1000">
            <div class="relative">
                <div class="absolute -inset-1 bg-primary-400 rounded-lg blur-md opacity-30"></div>
                <img src="https://images.unsplash.com/photo-1606265752439-1f18756aa5fc?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80" alt="Dental Clinic" class="rounded-lg shadow-2xl max-w-full h-auto relative z-10">
            </div>
        </div>
    </div>
    <!-- Wave separator -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden">
        <svg preserveAspectRatio="none" width="100%" height="50" viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="#FFFFFF"></path>
        </svg>
    </div>
</section>