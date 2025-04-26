@extends('layouts.dashboard')

@section('title', 'Scheduled Appointments | DentalCare Clinic')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-secondary">Scheduled Appointments</h1>
            <a href="{{ route('assistant.appointments.create') }}" class="bg-primary hover:bg-primary/80 text-white px-4 py-2 rounded">
                <i class="fas fa-plus mr-2"></i> New Appointment
            </a>
        </div>
        
        <!-- Filter/Search Bar -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-8">
            <form action="{{ route('assistant.appointments.scheduled') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" id="search" name="search" placeholder="Search by patient name or ID" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div class="w-full md:w-1/4">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" id="date" name="date" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div class="w-full md:w-1/4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status" class="w-full p-2 border border-gray-300 rounded">
                        <option value="">All Statuses</option>
                        <option value="Scheduled">Scheduled</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-primary text-white p-2 rounded hover:bg-primary/80 transition-colors duration-150 h-10 px-4">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Appointments Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
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
                                <td colspan="6" class="py-6 text-center text-gray-500">No scheduled appointments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $scheduledAppointments->links() }}
            </div>
        </div>
    </div>
@endsection 