@extends('layouts.dashboard')

@section('title', 'Assistant Dashboard | DentalCare Clinic')

@section('content')
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-secondary">Welcome, {{ Auth::user()->name }}</h1>
                    <p class="text-gray-600">
                        Current Date and Time: {{ now()->format('F j, Y g:i A') }} | 
                        Last login: {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('F j, Y g:i A') : 'First login' }}
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="bg-accent rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="bg-primary rounded-full p-2 mr-3">
                                <i class="fas fa-calendar-check text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Today's Appointments</p>
                                <p class="text-2xl font-bold text-primary">{{ $stats['todays_appointments'] ?? '0' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Action Card 1: New Appointment -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-white">
                            <i class="fas fa-calendar-plus text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-secondary">New Appointment</h3>
                            <p class="text-gray-600 text-sm">Schedule a new appointment</p>
                        </div>
                    </div>
                    <a href="{{ route('assistant.appointments.create') }}" class="block w-full mt-4 bg-primary hover:bg-primary/80 text-white px-4 py-2 rounded-md text-sm text-center">Create Appointment</a>
                </div>
            </div>

            <!-- Action Card 2: New Patient -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white">
                            <i class="fas fa-user-plus text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-secondary">New Patient</h3>
                            <p class="text-gray-600 text-sm">Register a new patient</p>
                        </div>
                    </div>
                    <a href="{{ route('assistant.patients.create') }}" class="block w-full mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm text-center">Register Patient</a>
                </div>
            </div>

            <!-- Action Card 3: Appointment Reminders -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-yellow-500 flex items-center justify-center text-white">
                            <i class="fas fa-bell text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-secondary">Appointment Reminders</h3>
                            <p class="text-gray-600 text-sm">Send reminders to patients</p>
                        </div>
                    </div>
                    <a href="{{ route('assistant.reminders.send') }}" class="block w-full mt-4 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm text-center">Send Reminders</a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <!-- Appointment Requests Section -->
            <section id="appointment-requests" class="mb-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-secondary text-white px-6 py-4 flex justify-between items-center">
                        <h2 class="text-xl font-semibold">Appointment Requests</h2>
                        <div class="flex gap-2">
                            <button class="bg-white text-secondary hover:bg-gray-100 px-3 py-1 rounded text-sm">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                            <button class="bg-white text-secondary hover:bg-gray-100 px-3 py-1 rounded text-sm">
                                <i class="fas fa-download mr-1"></i> Export
                            </button>
                        </div>
                    </div>
                    
                    <!-- Appointment Requests Table -->
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-4 text-left">Request Date</th>
                                        <th class="py-3 px-4 text-left">Patient</th>
                                        <th class="py-3 px-4 text-left">Requested Service</th>
                                        <th class="py-3 px-4 text-left">Preferred Date</th>
                                        <th class="py-3 px-4 text-left">Status</th>
                                        <th class="py-3 px-4 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointmentRequests ?? [] as $request)
                                        <tr class="border-b border-gray-200">
                                            <td class="py-3 px-4">{{ $request->created_at->format('M d, Y') }}</td>
                                            <td class="py-3 px-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-gray-300 mr-3 overflow-hidden">
                                                        <img src="{{ $request->patient->profile_photo ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}" alt="Patient" class="w-full h-full object-cover">
                                                    </div>
                                                    <span>{{ $request->patient->name ?? 'Unknown Patient' }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4">{{ $request->description }}</td>
                                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($request->start_datetime)->format('M d, Y - g:i A') }}</td>
                                            <td class="py-3 px-4">
                                                <span class="bg-{{ $request->status_color ?? 'yellow' }}-100 text-{{ $request->status_color ?? 'yellow' }}-800 px-2 py-1 rounded-full text-xs">
                                                    {{ $request->status }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4">
                                                @if($request->status == 'Pending')
                                                    <a href="{{ route('assistant.appointments.schedule', $request->id) }}" class="bg-primary hover:bg-primary/80 text-white px-3 py-1 rounded text-sm">
                                                        Schedule
                                                    </a>
                                                @else
                                                    <a href="{{ route('assistant.appointments.show', $request->id) }}" class="text-primary hover:text-primary-dark">
                                                        View
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-4 px-6 text-center text-gray-500">No appointment requests found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Today's Appointments Section -->
            <section id="todays-appointments" class="mb-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-primary text-white px-6 py-4 flex justify-between items-center">
                        <h2 class="text-xl font-semibold">Today's Appointments</h2>
                        <span class="bg-white text-primary px-3 py-1 rounded text-sm">{{ now()->format('l, F j, Y') }}</span>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-4 text-left">Time</th>
                                        <th class="py-3 px-4 text-left">Patient</th>
                                        <th class="py-3 px-4 text-left">Doctor</th>
                                        <th class="py-3 px-4 text-left">Service</th>
                                        <th class="py-3 px-4 text-left">Status</th>
                                        <th class="py-3 px-4 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($todayAppointments ?? [] as $appointment)
                                        <tr class="border-b border-gray-200">
                                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($appointment->start_datetime)->format('g:i A') }}</td>
                                            <td class="py-3 px-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-gray-300 mr-3 overflow-hidden">
                                                        <img src="{{ $appointment->patient->profile_photo ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}" alt="Patient" class="w-full h-full object-cover">
                                                    </div>
                                                    <span>{{ $appointment->patient->name ?? 'Unknown Patient' }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4">{{ $appointment->doctor ? 'Dr. ' . $appointment->doctor->name : 'Not Assigned' }}</td>
                                            <td class="py-3 px-4">{{ $appointment->description }}</td>
                                            <td class="py-3 px-4">
                                                <span class="bg-{{ $appointment->status_color ?? 'gray' }}-100 text-{{ $appointment->status_color ?? 'gray' }}-800 px-2 py-1 rounded-full text-xs">
                                                    {{ $appointment->status }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4">
                                                @if($appointment->status == 'Scheduled')
                                                    <a href="{{ route('assistant.appointments.check-in', $appointment->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                                        Check-in
                                                    </a>
                                                @elseif($appointment->status == 'Completed')
                                                    <a href="{{ route('assistant.appointments.show', $appointment->id) }}" class="text-primary hover:text-primary-dark">
                                                        View
                                                    </a>
                                                @else
                                                    <a href="{{ route('assistant.appointments.show', $appointment->id) }}" class="text-primary hover:text-primary-dark">
                                                        View
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-4 px-6 text-center text-gray-500">No appointments scheduled for today</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Confirmed Schedules Section -->
            <section id="confirmed-schedules" class="mb-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-secondary text-white px-6 py-4 flex justify-between items-center">
                        <h2 class="text-xl font-semibold">Confirmed Schedules</h2>
                        <a href="{{ route('assistant.appointments.scheduled') }}" class="bg-white text-secondary hover:bg-gray-100 px-3 py-1 rounded text-sm">
                            <i class="fas fa-calendar-check mr-1"></i> View All Scheduled
                        </a>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-4 text-left">Date & Time</th>
                                        <th class="py-3 px-4 text-left">Patient</th>
                                        <th class="py-3 px-4 text-left">Doctor</th>
                                        <th class="py-3 px-4 text-left">Service</th>
                                        <th class="py-3 px-4 text-left">Status</th>
                                        <th class="py-3 px-4 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $scheduledAppointments = \App\Models\Appointment::with(['patient', 'doctor'])
                                            ->where('status', 'Scheduled')
                                            ->orderBy('start_datetime')
                                            ->take(5)
                                            ->get()
                                            ->map(function($appointment) {
                                                switch ($appointment->status) {
                                                    case 'Scheduled': $appointment->status_color = 'blue'; break;
                                                    case 'Completed': $appointment->status_color = 'green'; break;
                                                    default: $appointment->status_color = 'gray';
                                                }
                                                return $appointment;
                                            });
                                    @endphp
                                    
                                    @forelse($scheduledAppointments as $appointment)
                                        <tr class="border-b border-gray-200">
                                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($appointment->start_datetime)->format('M d, Y - g:i A') }}</td>
                                            <td class="py-3 px-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-gray-300 mr-3 overflow-hidden">
                                                        <img src="{{ $appointment->patient->profile_photo ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}" alt="Patient" class="w-full h-full object-cover">
                                                    </div>
                                                    <span>{{ $appointment->patient->name ?? 'Unknown Patient' }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4">{{ $appointment->doctor ? 'Dr. ' . $appointment->doctor->name : 'Not Assigned' }}</td>
                                            <td class="py-3 px-4">{{ $appointment->description }}</td>
                                            <td class="py-3 px-4">
                                                <span class="bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800 px-2 py-1 rounded-full text-xs">
                                                    {{ $appointment->status }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4">
                                                <div class="flex space-x-2">
                                                    @if($appointment->status == 'Scheduled')
                                                        <a href="{{ route('assistant.appointments.check-in', $appointment->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                                            Check-in
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('assistant.appointments.show', $appointment->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                        View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-6 text-center text-gray-500">No confirmed schedules found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('assistant.appointments.scheduled') }}" class="text-primary hover:text-primary-dark font-medium">
                                View All Confirmed Schedules <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        <div class="lg:col-span-1">
            <!-- Today's Stats -->
            <div class="mb-8 bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-primary text-white px-6 py-4">
                    <h2 class="text-xl font-semibold">Today's Stats</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                            <span class="text-gray-600">Total Appointments</span>
                            <span class="font-semibold">{{ $stats['total_appointments'] ?? '0' }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                            <span class="text-gray-600">Checked In</span>
                            <span class="font-semibold">{{ $stats['checked_in'] ?? '0' }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                            <span class="text-gray-600">Today's Pending</span>
                            <span class="font-semibold">{{ $stats['pending'] ?? '0' }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                            <span class="text-gray-600">Pending Requests</span>
                            <span class="font-semibold">{{ $stats['new_requests'] ?? '0' }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                            <span class="text-gray-600">All Scheduled Appointments</span>
                            <span class="font-semibold">{{ $stats['scheduled_appointments'] ?? '0' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Doctors Available</span>
                            <span class="font-semibold">{{ $stats['doctors_available'] ?? '0' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Patient Check-in -->
            <div class="mb-8 bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-primary text-white px-6 py-4">
                    <h2 class="text-xl font-semibold">Patient Check-in</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('assistant.appointments.check-in-search') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-1">Patient ID or Name</label>
                            <input type="text" id="patient_id" name="patient_search" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter patient ID or name...">
                        </div>
                        <div class="mb-4">
                            <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-1">Appointment Time</label>
                            <select id="appointment_time" name="appointment_time" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Select time...</option>
                                <option value="09:00">09:00 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="13:00">01:00 PM</option>
                                <option value="14:00">02:00 PM</option>
                                <option value="15:00">03:00 PM</option>
                                <option value="16:00">04:00 PM</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded hover:bg-primary-600 transition-colors">Check-in Patient</button>
                    </form>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="mb-8 bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-primary text-white px-6 py-4">
                    <h2 class="text-xl font-semibold">Quick Actions</h2>
                </div>
                <div class="p-6">
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('assistant.schedule.view') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                                <span class="bg-primary text-white p-2 rounded-full mr-3">
                                    <i class="fas fa-calendar-alt text-sm"></i>
                                </span>
                                <span>View Full Schedule</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('assistant.appointments.scheduled') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                                <span class="bg-blue-500 text-white p-2 rounded-full mr-3">
                                    <i class="fas fa-calendar-check text-sm"></i>
                                </span>
                                <span>Scheduled Appointments</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('assistant.patients.index') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                                <span class="bg-primary text-white p-2 rounded-full mr-3">
                                    <i class="fas fa-users text-sm"></i>
                                </span>
                                <span>Patient Directory</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('assistant.appointments.pending') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                                <span class="bg-primary text-white p-2 rounded-full mr-3">
                                    <i class="fas fa-phone text-sm"></i>
                                </span>
                                <span>Call Pending Patients</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('assistant.payments.index') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                                <span class="bg-primary text-white p-2 rounded-full mr-3">
                                    <i class="fas fa-file-invoice-dollar text-sm"></i>
                                </span>
                                <span>Payment Records</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // You can add additional JavaScript functionality here
        console.log('Assistant dashboard loaded');
    });
</script>
@endpush 