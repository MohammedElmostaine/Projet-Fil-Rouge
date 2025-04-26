@extends('layouts.dashboard')

@section('title', 'Pending Appointments | DentalCare Clinic')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-secondary mb-2">Pending Appointment Requests</h1>
        <p class="text-gray-600">Review and schedule appointment requests from patients</p>
    </div>
    
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
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-primary text-white px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold">Appointment Requests</h2>
            <div class="flex gap-2">
                <button class="bg-white text-primary hover:bg-gray-100 px-3 py-1 rounded text-sm">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <button class="bg-white text-primary hover:bg-gray-100 px-3 py-1 rounded text-sm">
                    <i class="fas fa-download mr-1"></i> Export
                </button>
            </div>
        </div>
        
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
                        @forelse($pendingAppointments as $request)
                            <tr class="border-b border-gray-200">
                                <td class="py-3 px-4">{{ $request->created_at->format('M d, Y') }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gray-300 mr-3 overflow-hidden">
                                            <img src="{{ $request->patient->profile_photo ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}" 
                                                alt="Patient" class="w-full h-full object-cover">
                                        </div>
                                        <span>{{ $request->patient->name ?? 'Unknown Patient' }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">{{ $request->description }}</td>
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($request->start_datetime)->format('M d, Y - g:i A') }}</td>
                                <td class="py-3 px-4">
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">
                                        {{ $request->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('assistant.appointments.schedule', $request->id) }}" 
                                        class="bg-primary hover:bg-primary-dark text-white px-3 py-1 rounded text-sm">
                                        Schedule
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 px-6 text-center text-gray-500">No pending appointment requests found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $pendingAppointments->links() }}
            </div>
        </div>
    </div>
@endsection 