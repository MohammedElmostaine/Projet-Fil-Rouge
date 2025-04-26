@extends('layouts.dashboard')

@section('title', 'Create Appointment | DentalCare Clinic')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('assistant.appointments.pending') }}" class="text-primary hover:text-primary-dark">
                <i class="fas fa-arrow-left mr-2"></i> Back to Pending Appointments
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-primary text-white px-6 py-4">
                <h2 class="text-xl font-semibold">Create Appointment from Request</h2>
            </div>
            
            <div class="p-6">
                @php
                    // Load the appointment request data
                    $request = \App\Models\AppointmentRequest::with('patient')->find(request()->id ?? $id ?? null);
                    $doctors = \App\Models\User::where('role', 'doctor')->get();
                @endphp
                
                @if(!$request)
                    <div class="text-center py-8">
                        <div class="mb-4 text-red-500">
                            <i class="fas fa-exclamation-triangle text-5xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Request Not Found</h3>
                        <p class="text-gray-600">The appointment request couldn't be found.</p>
                        <a href="{{ route('assistant.appointments.pending') }}" class="mt-4 inline-block bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded">
                            Back to Pending Requests
                        </a>
                    </div>
                @else
                    <!-- Appointment Creation Form -->
                    <form action="{{ route('assistant.appointments.schedule.store', $request->id) }}" method="POST">
                        @csrf
                        
                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Error Message -->
                        @if(session('error'))
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Patient Information (Read-Only) -->
                            <div class="md:col-span-2 mb-4 p-4 bg-gray-50 rounded-lg">
                                <h3 class="font-semibold text-gray-700 mb-2">Patient Information</h3>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gray-300 mr-3 overflow-hidden">
                                        <img src="{{ $request->patient->profile_photo ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}" 
                                            alt="{{ $request->patient->name ?? 'Patient' }}" 
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $request->patient->name ?? 'Unknown Patient' }}</p>
                                        <p class="text-xs text-gray-500">ID: {{ $request->patient_id }}</p>
                                    </div>
                                </div>
                                <div class="mt-2 text-sm">
                                    <p><span class="text-gray-600">Original Request:</span> {{ $request->description }}</p>
                                    <p><span class="text-gray-600">Requested Date/Time:</span> {{ \Carbon\Carbon::parse($request->start_datetime)->format('M d, Y - g:i A') }}</p>
                                </div>
                            </div>
                        
                            <!-- Doctor Selection -->
                            <div>
                                <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-1">Select Doctor *</label>
                                <select id="doctor_id" name="doctor_id" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                    <option value="">-- Choose a doctor --</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('doctor_id', $request->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                            Dr. {{ $doctor->name }} {{ $doctor->specialization ? '('.$doctor->specialization.')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Date Selection -->
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Appointment Date *</label>
                                <input type="date" id="date" name="date" 
                                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    min="{{ date('Y-m-d') }}"
                                    value="{{ old('date', \Carbon\Carbon::parse($request->start_datetime)->format('Y-m-d')) }}"
                                    required>
                                @error('date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Time Selection -->
                            <div>
                                <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Appointment Time *</label>
                                <select id="time" name="time" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                    <option value="">-- Select time --</option>
                                    @php 
                                        $requestedTime = \Carbon\Carbon::parse($request->start_datetime)->format('H:i');
                                    @endphp
                                    <option value="09:00" {{ old('time', $requestedTime) == '09:00' ? 'selected' : '' }}>9:00 AM</option>
                                    <option value="10:00" {{ old('time', $requestedTime) == '10:00' ? 'selected' : '' }}>10:00 AM</option>
                                    <option value="11:00" {{ old('time', $requestedTime) == '11:00' ? 'selected' : '' }}>11:00 AM</option>
                                    <option value="13:00" {{ old('time', $requestedTime) == '13:00' ? 'selected' : '' }}>1:00 PM</option>
                                    <option value="14:00" {{ old('time', $requestedTime) == '14:00' ? 'selected' : '' }}>2:00 PM</option>
                                    <option value="15:00" {{ old('time', $requestedTime) == '15:00' ? 'selected' : '' }}>3:00 PM</option>
                                    <option value="16:00" {{ old('time', $requestedTime) == '16:00' ? 'selected' : '' }}>4:00 PM</option>
                                </select>
                                @error('time')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                                <textarea id="notes" name="notes" rows="3" 
                                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Add any additional notes about this appointment...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <a href="{{ route('assistant.appointments.pending') }}" class="mr-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded font-medium">
                                Create Appointment
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('date');
        const doctorSelect = document.getElementById('doctor_id');
        const timeSelect = document.getElementById('time');
        
        // Function to check doctor availability when date/doctor changes
        async function checkDoctorAvailability() {
            const doctorId = doctorSelect.value;
            const date = dateInput.value;
            
            if (!doctorId || !date) return;
            
            try {
                // In a real app, this would be an actual API endpoint
                console.log(`Checking availability for doctor ${doctorId} on ${date}`);
                
                // You would fetch data and then update the time options
                // For demonstration purposes only:
                const timeOptions = timeSelect.querySelectorAll('option');
                timeOptions.forEach(option => {
                    if (option.value) {
                        // Randomly make some times "unavailable" for demo
                        const isAvailable = Math.random() > 0.3;
                        option.disabled = !isAvailable;
                        if (!isAvailable && option.selected) {
                            option.selected = false;
                        }
                    }
                });
            } catch (error) {
                console.error('Error checking availability:', error);
            }
        }
        
        // Add event listeners
        dateInput.addEventListener('change', checkDoctorAvailability);
        doctorSelect.addEventListener('change', checkDoctorAvailability);
    });
</script>
@endpush 