@extends('layouts.dashboard')

@section('title', 'Staff Details | DentalCare Clinic')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Staff Details</h1>
            <div class="flex space-x-3">
                <a href="{{ route('admin.staff.edit', $staff->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="h-20 w-20 flex-shrink-0">
                        <img class="h-20 w-20 rounded-full" src="{{ $staff->profile_photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($staff->name) . '&color=7F9CF5&background=EBF4FF&size=120' }}" alt="{{ $staff->name }}">
                    </div>
                    <div class="ml-6">
                        <h2 class="text-xl font-semibold text-gray-900">{{ $staff->name }} {{ $staff->last_name }}</h2>
                        <div class="mt-1 flex items-center">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($staff->role == 'doctor') bg-blue-100 text-blue-800
                                @elseif($staff->role == 'assistant') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($staff->role) }}
                            </span>
                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($staff->status == 'active') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($staff->status ?? 'inactive') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $staff->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $staff->phone ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $staff->created_at->format('F d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $staff->updated_at->format('F d, Y') }}</dd>
                        </div>
                    </dl>
                </div>
                
                @if($staff->role == 'doctor')
                <div class="border-t border-gray-200 mt-6 pt-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Doctor Information</h3>
                    
                    <!-- These would be custom fields for doctors -->
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Specialization</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $staff->specialization ?? 'General Dentistry' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">License Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $staff->license_number ?? 'Not provided' }}</dd>
                        </div>
                    </dl>
                    
                    <!-- Doctor Statistics -->
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-500 mb-3">Statistics</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500">Total Patients</p>
                                <p class="text-xl font-bold text-gray-900">{{ $staff->patients_count ?? 0 }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500">Appointments (Month)</p>
                                <p class="text-xl font-bold text-gray-900">{{ $staff->monthly_appointments ?? 0 }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500">Completed Appointments</p>
                                <p class="text-xl font-bold text-gray-900">{{ $staff->completed_appointments ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end">
                    <form action="{{ route('admin.staff.destroy', $staff->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this staff member?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                            <i class="fas fa-trash mr-2"></i> Delete Staff Member
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection 