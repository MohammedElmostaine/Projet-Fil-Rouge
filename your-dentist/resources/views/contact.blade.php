<!-- filepath: c:\Users\elmos\Desktop\Ycode\Projet-Fil-Rouge\your-dentist\resources\views\contact.blade.php -->
@extends('layouts.home')

@section('title', 'Contact Us | DentalCare Clinic')

@section('content')
    <!-- Contact Hero Section -->
    <section class="bg-primary-700 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Contact Us</h1>
            <p class="text-xl max-w-3xl mx-auto text-primary-100">We'd love to hear from you! Reach out with any questions or to schedule your appointment.</p>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Contact Form -->
                <div class="lg:w-1/2 bg-white p-8 rounded-xl shadow-lg" data-aos="fade-right">
                    <h2 class="text-2xl font-semibold mb-6 text-primary-700">Send us a Message</h2>
                    <form>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" placeholder="John Doe" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" placeholder="john@example.com" required>
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" placeholder="(123) 456-7890">
                        </div>
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" placeholder="How can we help you?" required></textarea>
                        </div>
                        <button type="submit" class="bg-primary-600 text-white py-2 px-6 rounded-lg hover:bg-primary-700 transition-colors">
                            Send Message
                        </button>
                    </form>
                </div>
                
                <!-- Contact Information -->
                <div class="lg:w-1/2" data-aos="fade-left">
                    <div class="bg-white p-8 rounded-xl shadow-lg mb-8">
                        <h3 class="text-xl font-semibold mb-6 text-primary-700">Contact Information</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="bg-primary-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-map-marker-alt text-primary-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Address</p>
                                    <p class="text-gray-600">123 Dental Street, City Name, State 12345</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-primary-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-phone-alt text-primary-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Phone</p>
                                    <p class="text-gray-600">(555) 123-4567</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-primary-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-envelope text-primary-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Email</p>
                                    <p class="text-gray-600">info@dentalcare.com</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-primary-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-clock text-primary-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Hours</p>
                                    <p class="text-gray-600">Monday - Friday: 9AM - 6PM</p>
                                    <p class="text-gray-600">Saturday: 9AM - 2PM</p>
                                    <p class="text-gray-600">Sunday: Closed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Map -->
                    <div class="bg-white p-8 rounded-xl shadow-lg">
                        <h3 class="text-xl font-semibold mb-6 text-primary-700">Find Us</h3>
                        <div class="rounded-lg overflow-hidden h-64 bg-gray-200">
                            <!-- Replace with your Google Maps embed code -->
                            <div class="w-full h-full flex items-center justify-center">
                                <p class="text-gray-500">Google Maps will be embedded here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection