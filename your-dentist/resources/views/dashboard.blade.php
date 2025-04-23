<!-- filepath: resources/views/dashboard.blade.php -->
@extends('layouts.dashboard')

@section('title', 'Patient Dashboard | DentalCare Clinic')

@section('content')
    <!-- Welcome Section -->
    <x-welcome-section />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <!-- Appointment Requests Section -->
            <x-appointment-requests />
            
            <!-- Appointments Section -->
            <x-appointments />
            
            <!-- Medical History Section -->
            <x-medical-history />
        </div>
        
        <div class="lg:col-span-1">
            <!-- Patient Information Summary -->
            <x-patient-profile />
            
            <!-- Notifications Section -->
            <x-notifications />
            
            <!-- Quick Links -->
            <x-quick-links />
        </div>
    </div>
@endsection