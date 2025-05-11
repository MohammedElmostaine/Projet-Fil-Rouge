<!-- Appointment Requests Section -->
<div class="mb-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-primary text-white px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold">Pending Appointments</h2>
            <a href="{{ route('patient.appointments') }}" class="bg-white text-primary hover:bg-gray-100 px-3 py-1 rounded text-sm">
                <i class="fas fa-list-alt mr-1"></i> View All Appointments
            </a>
        </div>
        <div class="p-6">
            @forelse($appointmentRequests as $appointment)
                <!-- Appointment Request Card -->
                <div class="border-b border-gray-200 pb-4 mb-4 last:mb-0 last:border-0 last:pb-0">
                    <div class="flex flex-col md:flex-row justify-between md:items-center">
                        <div class="mb-2 md:mb-0">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-calendar-alt text-primary mr-2"></i>
                                <span class="font-semibold">{{ $appointment->description }}</span>
                            </div>
                            <p class="text-gray-600">
                                {{ $appointment->doctor ? $appointment->doctor->name : 'Pending Assignment' }}
                            </p>
                        </div>
                        <div class="flex flex-col md:items-end">
                            <div class="bg-accent text-primary px-3 py-1 rounded-full mb-2 inline-block text-sm">
                                <i class="far fa-clock mr-1"></i> 
                                {{ \Carbon\Carbon::parse($appointment->start_datetime)->format('M d, Y - g:i A') }}
                            </div>
                            <div class="flex items-center">
                                <span class="px-3 py-1 rounded-full text-sm 
                                    @if($appointment->status === 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif($appointment->status === 'Scheduled') bg-blue-100 text-blue-800
                                    @elseif($appointment->status === 'In Progress') bg-indigo-100 text-indigo-800
                                    @elseif($appointment->status === 'Completed') bg-green-100 text-green-800
                                    @elseif($appointment->status === 'Rejected') bg-red-100 text-red-800
                                    @elseif($appointment->status === 'Cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $appointment->status }}
                                </span>
                                @if($appointment->status === 'Pending')
                                    <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
                                            onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- No requests message -->
                <div class="text-center py-4">
                    <p class="text-gray-600">No appointment requests.</p>
                    <a href="{{ route('appointments.slots') }}" class="mt-2 bg-primary hover:bg-primary/80 text-white px-4 py-2 rounded-md inline-flex items-center">
                        <i class="fas fa-calendar-plus mr-2"></i> Schedule New Appointment
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div> 