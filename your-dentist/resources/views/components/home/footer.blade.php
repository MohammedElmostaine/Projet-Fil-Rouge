<!-- filepath: c:\Users\elmos\Desktop\Ycode\Projet-Fil-Rouge\your-dentist\resources\views\components\home\footer.blade.php -->
<footer class="bg-primary-800 text-white pt-16 pb-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- Column 1 - Logo & About -->
            <div>
                <div class="flex items-center space-x-2 mb-6">
                    <span class="text-primary-300 text-3xl">
                        <i class="fas fa-tooth"></i>
                    </span>
                    <span class="font-bold text-xl text-white">DentalCare</span>
                </div>
                <p class="text-primary-100 mb-6 leading-relaxed">Providing quality dental care with a gentle touch for the entire family. Our mission is to help you achieve optimal oral health and a beautiful smile that lasts a lifetime.</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-primary-100 hover:text-white transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-primary-100 hover:text-white transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-primary-100 hover:text-white transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            
            <!-- Column 2 - Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-6 relative pb-4 after:absolute after:bottom-0 after:left-0 after:h-1 after:w-12 after:bg-primary-400">Quick Links</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="text-primary-100 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="text-primary-100 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}" class="text-primary-100 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> Services
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-primary-100 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> Contact
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Column 3 - Services -->
            <div>
                <h4 class="text-lg font-semibold mb-6 relative pb-4 after:absolute after:bottom-0 after:left-0 after:h-1 after:w-12 after:bg-primary-400">Our Services</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('services') }}#general" class="text-primary-100 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> General Dentistry
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}#cosmetic" class="text-primary-100 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> Cosmetic Dentistry
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}#orthodontics" class="text-primary-100 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> Orthodontics
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}#emergency" class="text-primary-100 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> Emergency Dentistry
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Column 4 - Contact -->
            <div>
                <h4 class="text-lg font-semibold mb-6 relative pb-4 after:absolute after:bottom-0 after:left-0 after:h-1 after:w-12 after:bg-primary-400">Contact Us</h4>
                <div class="space-y-4 text-primary-100">
                    <p class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                        <span>123 Dental Street, City Name, State 12345</span>
                    </p>
                    <p class="flex items-center">
                        <i class="fas fa-phone-alt mr-3"></i>
                        <span>(555) 123-4567</span>
                    </p>
                    <p class="flex items-center">
                        <i class="fas fa-envelope mr-3"></i>
                        <span>info@dentalcare.com</span>
                    </p>
                    <p class="flex items-center">
                        <i class="fas fa-clock mr-3"></i>
                        <span>Mon-Fri: 9AM-6PM, Sat: 9AM-2PM</span>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Bottom Footer -->
        <div class="border-t border-primary-700 mt-12 pt-8">
            <div class="flex flex-col md:flex-row md:justify-between items-center">
                <p class="text-primary-200 text-sm mb-4 md:mb-0">&copy; {{ date('Y') }} DentalCare Clinic. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-primary-200 hover:text-white text-sm">Privacy Policy</a>
                    <a href="#" class="text-primary-200 hover:text-white text-sm">Terms of Service</a>
                    <a href="#" class="text-primary-200 hover:text-white text-sm">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>