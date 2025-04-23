<!-- filepath: c:\Users\elmos\Desktop\Ycode\Projet-Fil-Rouge\your-dentist\resources\views\about.blade.php -->
@extends('layouts.home')

@section('title', 'About Us | DentalCare Clinic')

@section('content')
    <!-- About Hero Section -->
    <section class="bg-primary-700 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">About DentalCare Clinic</h1>
            <p class="text-xl max-w-3xl mx-auto text-primary-100">Learn more about our mission, our team of experts, and why patients choose us for their dental care needs.</p>
        </div>
    </section>
    
    <!-- Main content will go here -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center gap-10">
                <div class="md:w-1/2" data-aos="fade-right">
                    <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=600&q=80" alt="Our Clinic" class="rounded-lg shadow-xl w-full">
                </div>
                <div class="md:w-1/2" data-aos="fade-left">
                    <h2 class="text-3xl font-bold text-primary-700 mb-4">Our Story</h2>
                    <p class="text-gray-600 mb-4">Founded in 2010, DentalCare Clinic has been providing exceptional dental services to our community for over a decade. We started with a simple mission: to deliver high-quality dental care in a comfortable, patient-focused environment.</p>
                    <p class="text-gray-600 mb-4">Our practice has grown from a small office with just two dentists to a modern facility with a full team of specialists, but our commitment to personalized care has never wavered.</p>
                    <p class="text-gray-600">We've invested in the latest dental technology and continue to expand our services to meet the evolving needs of our patients. Today, we're proud to be one of the most trusted dental care providers in the region.</p>
                </div>
            </div>
        </div>
    </section>
@endsection