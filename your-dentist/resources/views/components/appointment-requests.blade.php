<!-- Appointment Requests Section -->
<div class="mb-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-primary text-white px-6 py-4">
            <h2 class="text-xl font-semibold">Recent Appointment Requests</h2>
        </div>
        <div class="p-6">
            @forelse($appointmentRequests as $request)
                <!-- Appointment Request Card -->
                <div class="border-b border-gray-200 pb-4 mb-4 last:mb-0 last:border-0 last:pb-0">
                    <div class="flex flex-col md:flex-row justify-between md:items-center">
                        <div class="mb-2 md:mb-0">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-calendar-alt text-primary mr-2"></i>
                                <span class="font-semibold">{{ $request->description }}</span>
                            </div>
                            <p class="text-gray-600">
                                {{ $request->doctor ? $request->doctor->user->name : 'Pending Assignment' }}
                            </p>
                        </div>
                        <div class="flex flex-col md:items-end">
                            <div class="bg-accent text-primary px-3 py-1 rounded-full mb-2 inline-block text-sm">
                                <i class="far fa-clock mr-1"></i> 
                                {{ \Carbon\Carbon::parse($request->start_datetime)->format('F j, Y - g:i A') }}
                            </div>
                            <div class="flex items-center">
                                <span class="px-3 py-1 rounded-full text-sm 
                                    @if($request->status === 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif($request->status === 'Accepted') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $request->status }}
                                </span>
                                @if($request->status === 'Pending')
                                    <form action="{{ route('appointments.cancel', $request) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
                                            onclick="return confirm('Are you sure you want to cancel this appointment request?')">
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
                    <a href="{{ route('appointments.available') }}" class="mt-2 bg-primary hover:bg-primary/80 text-white px-4 py-2 rounded-md inline-flex items-center">
                        <i class="fas fa-calendar-plus mr-2"></i> Schedule New Appointment
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div> 