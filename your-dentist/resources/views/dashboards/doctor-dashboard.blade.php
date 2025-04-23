@extends('layouts.dashboard')

@section('title', 'Doctor Dashboard | DentalCare Clinic')

@section('content')
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-secondary">Hello, Dr. {{ Auth::user()->name }}</h1>
                    <p class="text-gray-600">Today is {{ now()->format('F j, Y') }} | {{ now()->format('g:i A') }}</p>
                </div>
                <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                    <a href="#appointments" class="bg-primary hover:bg-primary/80 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-calendar-day mr-2"></i> Today's Schedule
                    </a>
                    <a href="{{ route('doctor.appointments.create') }}" class="bg-white border border-primary text-primary hover:bg-primary hover:text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add Appointment
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar - Doctor Information -->
        <div class="lg:col-span-1">
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-accent p-6 text-center">
                        <div class="w-24 h-24 rounded-full bg-primary mx-auto mb-4 overflow-hidden">
                            <img src="{{ Auth::user()->profile_photo ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}" alt="Dr. {{ Auth::user()->name }}" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-xl font-bold text-secondary">Dr. {{ Auth::user()->name }}</h3>
                        <p class="text-gray-600">{{ Auth::user()->specialization ?? 'Dentist' }}</p>
                    </div>
                    <div class="p-6 border-t border-gray-200">
                        <div class="mb-4">
                            <h4 class="text-sm text-gray-500 mb-1">Today's Appointments</h4>
                            <p class="font-semibold">{{ $todayStats['appointment_count'] ?? '0' }} Scheduled</p>
                        </div>
                        <div class="mb-4">
                            <h4 class="text-sm text-gray-500 mb-1">Pending Reviews</h4>
                            <p class="font-semibold">{{ $todayStats['pending_reviews'] ?? '0' }} Patients</p>
                        </div>
                        <div>
                            <h4 class="text-sm text-gray-500 mb-1">Working Hours</h4>
                            <p class="font-semibold">{{ $doctor->schedule ?? '9:00 AM - 5:00 PM' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-secondary text-white px-6 py-4">
                        <h2 class="text-lg font-semibold">Quick Stats</h2>
                    </div>
                    <div class="grid grid-cols-2 gap-4 p-6">
                        <div class="bg-accent rounded-lg p-4 text-center">
                            <p class="text-2xl font-bold text-primary">{{ $stats['weekly_appointments'] ?? '0' }}</p>
                            <p class="text-sm text-gray-600">This Week</p>
                        </div>
                        <div class="bg-accent rounded-lg p-4 text-center">
                            <p class="text-2xl font-bold text-primary">{{ $stats['monthly_appointments'] ?? '0' }}</p>
                            <p class="text-sm text-gray-600">This Month</p>
                        </div>
                        <div class="bg-accent rounded-lg p-4 text-center">
                            <p class="text-2xl font-bold text-primary">{{ $stats['new_patients'] ?? '0' }}</p>
                            <p class="text-sm text-gray-600">New Patients</p>
                        </div>
                        <div class="bg-accent rounded-lg p-4 text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $stats['satisfaction_rate'] ?? '0' }}%</p>
                            <p class="text-sm text-gray-600">Satisfaction</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-primary text-white px-6 py-4">
                        <h2 class="text-lg font-semibold">Quick Actions</h2>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-4">
                            <li>
                                <a href="{{ route('doctor.prescriptions.create') }}" class="flex items-center text-secondary hover:text-primary">
                                    <i class="fas fa-file-prescription mr-3 text-primary"></i>
                                    <span>Write Prescription</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('doctor.medical-records.index') }}" class="flex items-center text-secondary hover:text-primary">
                                    <i class="fas fa-notes-medical mr-3 text-primary"></i>
                                    <span>View Medical Records</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('doctor.schedule.edit') }}" class="flex items-center text-secondary hover:text-primary">
                                    <i class="fas fa-calendar-alt mr-3 text-primary"></i>
                                    <span>Adjust Schedule</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('doctor.notifications.index') }}" class="flex items-center text-secondary hover:text-primary">
                                    <i class="fas fa-bell mr-3 text-primary"></i>
                                    <span>Notifications ({{ $notificationCount ?? '0' }})</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3">
            <!-- Today's Appointments Section -->
            <div class="mb-8" id="appointments">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-primary text-white px-6 py-4 flex justify-between items-center">
                        <h2 class="text-xl font-semibold">Today's Appointments</h2>
                        <div class="flex gap-2">
                            <button class="bg-white text-primary hover:bg-gray-100 px-3 py-1 rounded text-sm">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                            <button class="bg-white text-primary hover:bg-gray-100 px-3 py-1 rounded text-sm">
                                <i class="fas fa-print mr-1"></i> Print
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-4 text-left">Time</th>
                                        <th class="py-3 px-4 text-left">Patient</th>
                                        <th class="py-3 px-4 text-left">Service</th>
                                        <th class="py-3 px-4 text-left">Status</th>
                                        <th class="py-3 px-4 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointments ?? [] as $appointment)
                                        <tr class="border-b border-gray-200">
                                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($appointment->start_datetime)->format('g:i A') }}</td>
                                            <td class="py-3 px-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-gray-300 mr-3 overflow-hidden">
                                                        <img src="{{ $appointment->patient->profile_photo ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}" alt="Patient" class="w-full h-full object-cover">
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold">{{ $appointment->patient->name }}</p>
                                                        <p class="text-xs text-gray-500">ID: {{ $appointment->patient_id }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4">{{ $appointment->description }}</td>
                                            <td class="py-3 px-4">
                                                <span class="bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-600 px-2 py-1 rounded-full text-xs font-semibold">
                                                    {{ $appointment->status }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4">
                                                <div class="flex space-x-2">
                                                    @if($appointment->status == 'Confirmed')
                                                        <a href="{{ route('doctor.appointments.start', $appointment->id) }}" class="bg-primary hover:bg-primary/80 text-white px-3 py-1 rounded text-sm">
                                                            Start
                                                        </a>
                                                    @elseif($appointment->status == 'In Progress')
                                                        <a href="{{ route('doctor.appointments.complete', $appointment->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                                            Complete
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('doctor.appointments.show', $appointment->id) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded text-sm">
                                                        View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-4 px-6 text-center text-gray-500">No appointments scheduled for today</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Appointment Requests -->
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-secondary text-white px-6 py-4">
                        <h2 class="text-xl font-semibold">Pending Appointment Requests</h2>
                    </div>
                    <div class="p-6">
                        @forelse($appointmentRequests ?? [] as $request)
                            <div class="border-b border-gray-200 last:border-0 pb-4 mb-4 last:mb-0">
                                <div class="flex flex-col md:flex-row justify-between md:items-center">
                                    <div class="mb-4 md:mb-0">
                                        <div class="flex items-center mb-2">
                                            <div class="w-10 h-10 rounded-full bg-gray-300 mr-3 overflow-hidden">
                                                <img src="{{ $request->patient->profile_photo ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}" alt="{{ $request->patient->name }}" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <h3 class="font-medium">{{ $request->patient->name }}</h3>
                                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($request->start_datetime)->format('F j, Y - g:i A') }}</p>
                                            </div>
                                        </div>
                                        <p class="text-gray-700">{{ $request->description }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('doctor.appointments.accept', $request->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Accept</button>
                                        </form>
                                        <form action="{{ route('doctor.appointments.reject', $request->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Decline</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-calendar-check text-gray-300 text-4xl mb-3"></i>
                                <p>No pending appointment requests</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // You can add additional JavaScript functionality here
        console.log('Doctor dashboard loaded');
    });
</script>
@endpush 