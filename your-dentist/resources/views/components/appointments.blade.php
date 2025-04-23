<!-- Upcoming Appointments Section -->
<div class="mb-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-primary text-white px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold">Upcoming Appointments</h2>
            <a href="{{ route('patient.appointments') }}" class="text-white hover:text-accent">View All</a>
        </div>
        <div class="p-6">
            @forelse($upcomingAppointments ?? [] as $appointment)
                <!-- Appointment Card -->
                <div class="border-b border-gray-200 pb-4 mb-4 last:mb-0 last:border-0 last:pb-0">
                    <div class="flex flex-col md:flex-row justify-between md:items-center">
                        <div class="mb-2 md:mb-0">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-calendar-check text-primary mr-2"></i>
                                <span class="font-semibold">{{ $appointment->description ?? 'Appointment' }}</span>
                            </div>
                            <p class="text-gray-600">
                                {{ $appointment->doctor_name ?? 'Your Dentist' }}
                            </p>
                        </div>
                        <div class="flex flex-col md:items-end">
                            <div class="bg-accent text-primary px-3 py-1 rounded-full mb-2 inline-block text-sm">
                                <i class="far fa-clock mr-1"></i> 
                                {{ \Carbon\Carbon::parse($appointment->start_datetime)->format('F j, Y - g:i A') }}
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('appointments.available') }}" class="text-sm bg-primary hover:bg-primary/80 text-white px-3 py-1 rounded">
                                    Reschedule
                                </a>
                                <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
                                        onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- No appointments message (shown when no appointments) -->
                <div class="text-center py-4">
                    <p class="text-gray-600">No upcoming appointments.</p>
                    <a href="{{ route('appointments.available') }}" class="mt-2 bg-primary hover:bg-primary/80 text-white px-4 py-2 rounded-md inline-flex items-center">
                        <i class="fas fa-calendar-plus mr-2"></i> Schedule New Appointment
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
