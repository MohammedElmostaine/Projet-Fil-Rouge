@extends('layouts.dashboard')

@section('title', 'Admin Dashboard | DentalCare Clinic')

@section('content')
    <!-- Dashboard Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Card 1: Total Patients -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Patients</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['patients_count'] ?? '0' }}</p>
                    <p class="text-sm text-green-600 mt-1"><i class="fas fa-arrow-up"></i> {{ $stats['patients_increase'] ?? '0' }}% from last month</p>
                </div>
                <div class="bg-primary-100 rounded-full p-3">
                    <i class="fas fa-user-injured text-xl text-primary"></i>
                </div>
            </div>
        </div>
        
        <!-- Card 2: Active Doctors -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Doctors</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['doctors_count'] ?? '0' }}</p>
                    <p class="text-sm text-green-600 mt-1"><i class="fas fa-arrow-up"></i> {{ $stats['new_doctors'] ?? '0' }} new this month</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-user-md text-xl text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <!-- Card 3: Today's Appointments -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Today's Appointments</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['todays_appointments'] ?? '0' }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $stats['completed_appointments'] ?? '0' }} completed, {{ $stats['remaining_appointments'] ?? '0' }} remaining</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-calendar-check text-xl text-green-600"></i>
                </div>
            </div>
        </div>
        
        <!-- Card 4: Monthly Revenue -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Monthly Revenue</p>
                    <p class="text-3xl font-bold text-gray-900">${{ $stats['monthly_revenue'] ?? '0' }}</p>
                    <p class="text-sm text-green-600 mt-1"><i class="fas fa-arrow-up"></i> {{ $stats['revenue_increase'] ?? '0' }}% from last month</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-dollar-sign text-xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Staff Management Section -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="bg-primary text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold">Staff Management</h2>
                <a href="{{ route('admin.staff.create') }}" class="bg-white text-primary px-4 py-2 rounded hover:bg-gray-200 transition">+ Add Staff</a>
            </div>
            <div class="p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($staff ?? [] as $member)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full" src="{{ $member->profile_photo ?? 'https://randomuser.me/api/portraits/men/1.jpg' }}" alt="{{ $member->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $member->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($member->role == 'doctor') bg-blue-100 text-blue-800
                                        @elseif($member->role == 'assistant') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($member->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($member->status == 'active') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($member->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.staff.edit', $member->id) }}" class="text-primary hover:text-primary-dark mr-3">Edit</a>
                                    <a href="{{ route('admin.staff.show', $member->id) }}" class="text-gray-600 hover:text-gray-900">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No staff members found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions & Notifications -->
        <div class="lg:col-span-1">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden">
                <div class="bg-primary text-white px-6 py-4">
                    <h2 class="text-xl font-semibold">Quick Actions</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <a href="{{ route('admin.staff.create') }}" class="flex items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-user-plus text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-medium">Add Staff Member</h3>
                                <p class="text-sm text-gray-500">Register new doctor or assistant</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.appointments.index') }}" class="flex items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <i class="fas fa-calendar-alt text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="font-medium">Manage Appointments</h3>
                                <p class="text-sm text-gray-500">View and edit appointments</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.reports.index') }}" class="flex items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="bg-purple-100 p-3 rounded-full mr-4">
                                <i class="fas fa-chart-line text-purple-600"></i>
                            </div>
                            <div>
                                <h3 class="font-medium">View Reports</h3>
                                <p class="text-sm text-gray-500">Check clinic performance</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="flex items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="bg-gray-200 p-3 rounded-full mr-4">
                                <i class="fas fa-cog text-gray-600"></i>
                            </div>
                            <div>
                                <h3 class="font-medium">System Settings</h3>
                                <p class="text-sm text-gray-500">Configure clinic settings</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Notifications -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="bg-primary text-white px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-semibold">System Notifications</h2>
                    <a href="{{ route('admin.notifications.index') }}" class="text-white hover:text-accent">View All</a>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($notifications ?? [] as $notification)
                            <div class="border-l-4 
                                @if($notification->type == 'success') border-green-500 bg-green-50
                                @elseif($notification->type == 'warning') border-yellow-500 bg-yellow-50
                                @elseif($notification->type == 'danger') border-red-500 bg-red-50
                                @else border-blue-500 bg-blue-50 @endif
                                p-4 rounded-r-lg">
                                <div class="flex justify-between">
                                    <h3 class="font-medium 
                                        @if($notification->type == 'success') text-green-800
                                        @elseif($notification->type == 'warning') text-yellow-800
                                        @elseif($notification->type == 'danger') text-red-800
                                        @else text-blue-800 @endif">
                                        {{ $notification->title }}
                                    </h3>
                                    <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                            </div>
                        @empty
                            <div class="text-center py-4 text-gray-500">
                                <p>No new notifications</p>
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
        console.log('Admin dashboard loaded');
    });
</script>
@endpush 