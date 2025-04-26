@extends('layouts.dashboard')

@section('title', 'Appointment Details | Doctor Dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Appointment Details Card -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="bg-primary-800 text-white px-6 py-4 rounded-t-lg">
            <h1 class="text-xl font-semibold">Appointment Details</h1>
        </div>
        
        <div class="p-6">
            <!-- Status Badge -->
            <div class="mb-4">
                <span class="px-3 py-1 rounded-full text-sm 
                    @if($appointment->status == 'Completed') bg-green-100 text-green-800
                    @elseif($appointment->status == 'Cancelled') bg-red-100 text-red-800
                    @else bg-blue-100 text-blue-800 @endif">
                    {{ $appointment->status }}
                </span>
            </div>
            
            <!-- Appointment Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Patient</h3>
                    <p class="text-base font-medium text-gray-900">{{ $appointment->patient->name }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Date & Time</h3>
                    <p class="text-base font-medium text-gray-900">{{ \Carbon\Carbon::parse($appointment->start_datetime)->format('M d, Y h:i A') }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Gender</h3>
                    <p class="text-base font-medium text-gray-900">{{ ucfirst($appointment->patient->gender ?? 'Not specified') }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                    <p class="text-base font-medium text-gray-900">{{ $appointment->patient->phone ?? 'Not provided' }}</p>
                </div>
                
                <div class="md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                    <p class="text-base text-gray-900">{{ $appointment->description ?? 'No description provided' }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Medical History Form -->
    @if($appointment->status == 'Scheduled')
    <div class="bg-white rounded-lg shadow-sm">
        <div class="bg-primary-800 text-white px-6 py-4 rounded-t-lg">
            <h2 class="text-xl font-semibold">Medical History</h2>
            <p class="text-sm mt-1">Record medical details for this appointment</p>
        </div>
        
        <div class="p-6">
            <form action="{{ route('doctor.medical-history.store', $appointment->id) }}" method="POST">
                @csrf
                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                
                <div class="mb-6">
                    <label for="details" class="block text-sm font-medium text-gray-700 mb-1">Medical Details</label>
                    <textarea id="details" name="details" rows="6" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 resize-none"
                        placeholder="Enter medical findings, diagnosis, treatment plan, etc."></textarea>
                    @error('details')
                        <p class="text-red-500 text-xs mt-1">{{ $message ?? 'Please enter medical details' }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <button type="submit" name="action" value="save" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition">
                            Save Medical History
                        </button>
                        <button type="submit" name="action" value="complete" class="ml-3 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                            Complete Appointment
                        </button>
                    </div>
                    <a href="{{ route('doctor.appointments.all') }}" class="text-gray-600 hover:text-gray-900">
                        Back to Appointments
                    </a>
                </div>
            </form>
        </div>
    </div>
    @else
    <!-- Display existing medical history if appointment is completed -->
    @if(isset($medicalHistory))
    <div class="bg-white rounded-lg shadow-sm">
        <div class="bg-primary-800 text-white px-6 py-4 rounded-t-lg">
            <h2 class="text-xl font-semibold">Medical History</h2>
            <p class="text-sm mt-1">Recorded on {{ \Carbon\Carbon::parse($medicalHistory->date)->format('M d, Y') }}</p>
        </div>
        
        <div class="p-6">
            <div class="bg-gray-50 p-4 rounded-md">
                <p class="whitespace-pre-line">{{ $medicalHistory->details }}</p>
            </div>
            
            <div class="mt-6 text-right">
                <a href="{{ route('doctor.appointments.all') }}" class="text-gray-600 hover:text-gray-900">
                    Back to Appointments
                </a>
            </div>
        </div>
    </div>
    @endif
    @endif
</div>
@endsection 