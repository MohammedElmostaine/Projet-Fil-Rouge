<!-- filepath: c:\Users\elmos\Desktop\Ycode\Projet-Fil-Rouge\your-dentist\resources\views\services.blade.php -->
@extends('layouts.home')

@section('title', 'Our Dental Services | DentalCare Clinic')

@section('content')
    <!-- Hero Section -->
    @include('components.services.hero')
    
    <!-- Services Overview -->
    @include('components.services.overview')
    
    <!-- General Dentistry -->
    @include('components.services.general-dentistry')
    
    <!-- Cosmetic Dentistry -->
    @include('components.services.cosmetic-dentistry')
    
    <!-- Orthodontics -->
    @include('components.services.orthodontics')
    
    <!-- Pediatric Dentistry -->
    @include('components.services.pediatric-dentistry')
    
    <!-- Emergency Dentistry -->
    @include('components.services.emergency-dentistry')
    
    <!-- FAQ Section -->
    @include('components.services.faq')
    
    <!-- Call to Action -->
    @include('components.services.cta')
@endsection

@section('scripts')
<script>
    // FAQ functionality
    document.addEventListener('DOMContentLoaded', function() {
        const faqToggles = document.querySelectorAll('.faq-toggle');
        
        faqToggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                const content = toggle.nextElementSibling;
                const icon = toggle.querySelector('i');
                
                // Toggle content visibility
                content.classList.toggle('hidden');
                
                // Rotate icon when open
                icon.classList.toggle('rotate-180');
            });
        });
    });
</script>
@endsection