@extends('layouts.dashboard')

@section('title', 'All Appointments | DentalCare Clinic')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-secondary">All Appointments</h1>
                <p class="text-gray-600">View your appointments for {{ $startDate->format('M d') }} - {{ $endDate->format('M d, Y') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('doctor.dashboard') }}" class="bg-white border border-primary text-primary hover:bg-primary hover:text-white px-4 py-2 rounded">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                </a>
                <a href="{{ route('doctor.appointments.all', ['start_date' => Carbon\Carbon::now()->startOfWeek()->format('Y-m-d')]) }}"
                   class="bg-white border border-primary text-primary hover:bg-primary hover:text-white px-4 py-2 rounded">
                    Current Week
                </a>
            </div>
        </div>

        <!-- Date Navigation -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-8">
            <form action="{{ route('doctor.appointments.all') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" id="start_date" name="start_date" 
                           value="{{ $startDate->format('Y-m-d') }}"
                           class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div class="flex-1">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" id="end_date" name="end_date" 
                           value="{{ $endDate->format('Y-m-d') }}"
                           class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div>
                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-dark">
                        <i class="fas fa-search mr-2"></i> View Appointments
                    </button>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('doctor.appointments.all', ['start_date' => $startDate->copy()->subDays(7)->format('Y-m-d'), 'end_date' => $endDate->copy()->subDays(7)->format('Y-m-d')]) }}" 
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a href="{{ route('doctor.appointments.all', ['start_date' => $startDate->copy()->addDays(7)->format('Y-m-d'), 'end_date' => $endDate->copy()->addDays(7)->format('Y-m-d')]) }}" 
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Appointments by Day -->
        @forelse($appointmentsByDay as $dateString => $dayData)
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-primary text-white px-6 py-4 flex justify-between items-center">
                        <h2 class="text-xl font-semibold">{{ $dayData['date_formatted'] }}</h2>
                        <span class="bg-white text-primary px-3 py-1 rounded text-sm">
                            {{ $dayData['appointments']->count() }} Appointment{{ $dayData['appointments']->count() != 1 ? 's' : '' }}
                        </span>
                    </div>
                    <div class="p-6">
                        @if($dayData['appointments']->isEmpty())
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-calendar-day text-gray-300 text-4xl mb-3"></i>
                                <p>No appointments scheduled for this day</p>
                            </div>
                        @else
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
                                        @foreach($dayData['appointments'] as $appointment)
                                            <tr class="border-b border-gray-200">
                                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($appointment->start_datetime)->format('g:i A') }}</td>
                                                <td class="py-3 px-4">
                                                    <div class="flex items-center">
                                                        <div class="w-8 h-8 rounded-full bg-gray-300 mr-3 overflow-hidden">
                                                            <img src="{{ $appointment->patient->profile_photo ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}" alt="Patient" class="w-full h-full object-cover">
                                                        </div>
                                                        <div>
                                                            <p class="font-semibold">{{ $appointment->patient->name }}</p>
                                                            <p class="text-xs text-gray-500">ID: {{ $appointment->patient->id }}</p>
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
                                                        @if(get_class($appointment) === 'App\Models\Appointment' && $appointment->status === 'Scheduled')
                                                            <a href="{{ route('doctor.appointments.start', $appointment->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                                                Start
                                                            </a>
                                                        @elseif(get_class($appointment) === 'App\Models\Appointment' && $appointment->status === 'In Progress')
                                                            <a href="{{ route('doctor.appointments.complete', $appointment->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                                Complete
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('doctor.appointments.show', $appointment->id) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded text-sm">
                                                            View
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="text-center">
                    <div class="mb-4 text-gray-400">
                        <i class="fas fa-calendar-times text-6xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">No Appointments Found</h3>
                    <p class="text-gray-600 mb-6">There are no appointments scheduled for the selected date range.</p>
                    <a href="{{ route('doctor.dashboard') }}" class="bg-primary text-white px-6 py-2 rounded hover:bg-primary-dark">
                        Return to Dashboard
                    </a>
                </div>
            </div>
        @endforelse
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any additional JavaScript functionality here
    });
</script>
@endpush 