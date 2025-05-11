@extends('layouts.dashboard')

@section('title', 'Schedule Appointment | DentalCare Clinic')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('assistant.appointments.requests') }}" class="text-primary hover:text-primary-dark">
                <i class="fas fa-arrow-left mr-2"></i> Back to Pending Appointments
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-primary text-white px-6 py-4">
                <h2 class="text-xl font-semibold">Schedule Appointment</h2>
            </div>
            
            <div class="p-6">
                @php
                    $appointmentRequest = \App\Models\AppointmentRequest::with(['patient', 'doctor'])->find($id);
                    $doctors = \App\Models\User::where('role', 'doctor')->get();
                @endphp
                
                @if(!$appointmentRequest)
                    <div class="text-center py-8">
                        <div class="mb-4 text-red-500">
                            <i class="fas fa-exclamation-triangle text-5xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Appointment Request Not Found</h3>
                        <p class="text-gray-600">The appointment request you're looking for doesn't exist or has been deleted.</p>
                        <a href="{{ route('assistant.appointments.pending') }}" class="mt-4 inline-block bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded">
                            View All Pending Requests
                        </a>
                    </div>
                @else
                    <!-- Patient Information -->
                    <div class="mb-8 border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-secondary mb-4">Patient Information</h3>
                        
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-gray-300 mr-4 overflow-hidden">
                                <img src="{{ $appointmentRequest->patient->profile_photo ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}" 
                                    alt="{{ $appointmentRequest->patient->name ?? 'Patient' }}" 
                                    class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="font-semibold">{{ $appointmentRequest->patient->name ?? 'Unknown Patient' }}</p>
                                <p class="text-sm text-gray-600">Patient ID: {{ $appointmentRequest->patient_id }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Email</p>
                                <p>{{ $appointmentRequest->patient->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Phone</p>
                                <p>{{ $appointmentRequest->patient->phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Appointment Request Details -->
                    <div class="mb-8 border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-secondary mb-4">Appointment Request Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Requested Date & Time</p>
                                <p>{{ \Carbon\Carbon::parse($appointmentRequest->start_datetime)->format('M d, Y - g:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Status</p>
                                <p><span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">{{ $appointmentRequest->status }}</span></p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-600 mb-1">Description</p>
                                <p>{{ $appointmentRequest->description }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Check Doctor's Availability -->
                    <div class="mb-8 border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-secondary mb-4">Doctor Availability</h3>
                        
                        @php
                            $date = \Carbon\Carbon::parse($appointmentRequest->start_datetime)->format('Y-m-d');
                            $doctorAppointments = \App\Models\Appointment::whereDate('start_datetime', $date)
                                ->whereIn('status', ['Confirmed', 'Checked-in', 'In Progress'])
                                ->orderBy('start_datetime')
                                ->get()
                                ->groupBy('doctor_id');
                        @endphp
                        
                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-4 text-left">Doctor</th>
                                        <th class="py-3 px-4 text-left">9:00 AM</th>
                                        <th class="py-3 px-4 text-left">10:00 AM</th>
                                        <th class="py-3 px-4 text-left">11:00 AM</th>
                                        <th class="py-3 px-4 text-left">1:00 PM</th>
                                        <th class="py-3 px-4 text-left">2:00 PM</th>
                                        <th class="py-3 px-4 text-left">3:00 PM</th>
                                        <th class="py-3 px-4 text-left">4:00 PM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctors as $doctor)
                                        <tr class="border-b border-gray-200">
                                            <td class="py-3 px-4 font-medium">Dr. {{ $doctor->name }}</td>
                                            
                                            @php
                                                $times = ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];
                                                $doctorBooked = isset($doctorAppointments[$doctor->id]) ? $doctorAppointments[$doctor->id] : collect();
                                            @endphp
                                            
                                            @foreach($times as $time)
                                                @php
                                                    $slotDateTime = \Carbon\Carbon::parse("$date $time");
                                                    $isBooked = $doctorBooked->contains(function($appointment) use ($slotDateTime) {
                                                        return \Carbon\Carbon::parse($appointment->start_datetime)->format('H:i') === $slotDateTime->format('H:i');
                                                    });
                                                @endphp
                                                
                                                <td class="py-3 px-4">
                                                    @if($isBooked)
                                                        <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Booked</span>
                                                    @else
                                                        <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Available</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Schedule Form -->
                    <form action="{{ route('assistant.appointments.schedule.store', $appointmentRequest->id) }}" method="POST">
                        @csrf
                        
                        <h3 class="text-lg font-semibold text-secondary mb-4">Schedule Appointment</h3>
                        
                        <!-- Error Messages -->
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
                            <!-- Doctor Selection -->
                            <div>
                                <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-1">Assign Doctor *</label>
                                <select id="doctor_id" name="doctor_id" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                    <option value="">Select a doctor</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
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
                                    value="{{ old('date', \Carbon\Carbon::parse($appointmentRequest->start_datetime)->format('Y-m-d')) }}"
                                    required>
                                @error('date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Time Selection -->
                            <div>
                                <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Appointment Time *</label>
                                <select id="time" name="time" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                    <option value="">Select time</option>
                                    <option value="09:00" {{ old('time') == '09:00' ? 'selected' : '' }}>9:00 AM</option>
                                    <option value="10:00" {{ old('time') == '10:00' ? 'selected' : '' }}>10:00 AM</option>
                                    <option value="11:00" {{ old('time') == '11:00' ? 'selected' : '' }}>11:00 AM</option>
                                    <option value="13:00" {{ old('time') == '13:00' ? 'selected' : '' }}>1:00 PM</option>
                                    <option value="14:00" {{ old('time') == '14:00' ? 'selected' : '' }}>2:00 PM</option>
                                    <option value="15:00" {{ old('time') == '15:00' ? 'selected' : '' }}>3:00 PM</option>
                                    <option value="16:00" {{ old('time') == '16:00' ? 'selected' : '' }}>4:00 PM</option>
                                </select>
                                @error('time')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <a href="{{ route('assistant.appointments.pending') }}" class="mr-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded">
                                Schedule Appointment
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
        
        // When either date or doctor changes, we could update the availability display
        dateInput.addEventListener('change', checkAvailability);
        doctorSelect.addEventListener('change', checkAvailability);
        
        function checkAvailability() {
            // In a real application, this would make an AJAX request to check 
            // the doctor's availability for the selected date and update the UI
            console.log('Checking availability for doctor: ' + doctorSelect.value + ' on date: ' + dateInput.value);
        }
    });
</script>
@endpush 