<!-- filepath: c:\Users\elmos\Desktop\Ycode\Projet-Fil-Rouge\your-dentist\resources\views\home.blade.php -->
@extends('layouts.home')

@section('title', 'DentalCare Clinic - Your Trusted Dental Care Provider')

@section('content')
    <!-- Hero Section -->
    @include('components.home.hero')
    
    <!-- Feature Cards -->
    @include('components.home.features')
    
    <!-- Services Section -->
    @include('components.home.services')
    
    <!-- Call to Action -->
    <section class="relative py-16 bg-primary-700 text-white">
        <div class="absolute inset-0 bg-primary-900 opacity-50"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1629909613654-28e377c37b09?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80')] bg-no-repeat bg-cover opacity-20"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-3xl mx-auto" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready for a Brighter Smile?</h2>
                <p class="text-xl mb-8 text-primary-100">Schedule your appointment today and take the first step towards healthier teeth and gums.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="bg-white text-primary-600 hover:bg-gray-100 px-8 py-3 rounded-full font-medium text-lg inline-flex items-center justify-center shadow-lg hover:shadow-xl transition-all">
                        Register Now
                    </a>
                    <a href="tel:+15551234567" class="border border-white text-white hover:bg-white hover:text-primary-600 px-8 py-3 rounded-full font-medium text-lg inline-flex items-center justify-center transition-all">
                        <i class="fas fa-phone-alt mr-2"></i> Call Us
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection