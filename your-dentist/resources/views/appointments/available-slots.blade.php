@extends('layouts.dashboard')

@section('title', 'Available Appointment Slots')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Available Appointment Slots</h1>
            <p class="text-gray-600">Select a date and available time slot to schedule your dental appointment.</p>
                </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p class="font-medium">Success!</p>
                <p>{{ session('success') }}</p>
                        </div>
        @endif

                        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p class="font-medium">Error!</p>
                <p>{{ session('error') }}</p>
                            </div>
                        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p class="font-medium">Please fix the following errors:</p>
                <ul class="mt-2 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                            </div>
                        @endif

        <!-- Date Selection -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form action="{{ route('appointments.slots') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
                <div class="w-full sm:w-1/2">
                    <label for="date" class="block text-sm font-semibold text-secondary mb-2">Select Date</label>
                    <input type="date" id="date" name="date" 
                           value="{{ $selectedDate->format('Y-m-d') }}" 
                           min="{{ now()->format('Y-m-d') }}"
                           class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                <div class="w-full sm:w-1/2">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white py-2.5 px-4 rounded-md transition duration-200">
                        <i class="fas fa-calendar-check mr-2"></i> View Available Slots
                            </button>
                        </div>
                    </form>
                </div>

        <!-- Time Filter -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-semibold text-secondary mb-3">Filter by Time</h2>
            <div class="flex flex-wrap gap-2" id="time-filters">
                <button type="button" data-filter="all" class="time-filter px-4 py-2 bg-accent text-primary rounded-full text-sm font-medium hover:bg-accent/80 active">
                    All Times
                </button>
                <button type="button" data-filter="morning" class="time-filter px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-full text-sm font-medium hover:bg-gray-50">
                    Morning (9AM - 12PM)
                </button>
                <button type="button" data-filter="afternoon" class="time-filter px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-full text-sm font-medium hover:bg-gray-50">
                    Afternoon (1PM - 5PM)
                </button>
            </div>
        </div>

        <!-- Available Slots for Selected Date -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 bg-primary text-white">
                <h2 class="text-xl font-semibold">Available Slots for {{ $selectedDate->format('l, F j, Y') }}</h2>
            </div>
            
            <div class="p-6">
                @if(!$hasOfficeHours)
                    <div class="text-center py-8">
                        <i class="far fa-calendar-times text-4xl text-gray-400 mb-3 block"></i>
                        <p class="text-lg text-gray-600">No appointments available on {{ $selectedDate->format('l') }}s.</p>
                        <p class="text-gray-500 mt-2">Please select a weekday (Monday to Friday).</p>
                    </div>
                @elseif($selectedDate->isWeekend())
                    <div class="text-center py-8">
                        <i class="far fa-calendar-times text-4xl text-gray-400 mb-3 block"></i>
                        <p class="text-lg text-gray-600">We are closed on weekends.</p>
                        <p class="text-gray-500 mt-2">Please select a weekday (Monday to Friday).</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                        @forelse($availableSlots as $slot)
                            @if(!empty($slot['time']))
                                @php
                                    $slotDateTime = \Carbon\Carbon::parse($selectedDate->format('Y-m-d') . ' ' . $slot['time']);
                                    $timeClass = (substr($slot['time'], 0, 2) >= 9 && substr($slot['time'], 0, 2) < 12) 
                                                ? 'morning' : 'afternoon';
                                @endphp
                                
                                <!-- DIRECT FORM SUBMISSION - NO JAVASCRIPT NEEDED -->
                                <form action="{{ route('appointments.book') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="date" value="{{ $selectedDate->format('Y-m-d') }}">
                                    <input type="hidden" name="time" value="{{ $slot['time'] }}">
                                    <input type="hidden" name="description" value="Dental appointment on {{ $selectedDate->format('l, F j, Y') }} at {{ $slot['formatted_time'] }}">
                                    
                                    <button type="submit" 
                                        class="w-full p-4 rounded-md text-center bg-accent border border-primary/20 text-primary hover:bg-primary hover:text-white transition-colors font-medium"
                                    >
                                        <span class="block text-lg">{{ $slot['formatted_time'] }}</span>
                                        <span class="text-xs block mt-1">
                                            <i class="fas fa-check-circle mr-1"></i>Click to Book
                                        </span>
                                    </button>
                                </form>
                            @endif
                        @empty
                            <div class="col-span-full text-center py-8 text-gray-500">
                                <i class="far fa-clock text-4xl mb-3 block"></i>
                                <p>No available slots for this date.</p>
                                <p class="mt-2">Try selecting a different date.</p>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(app()->environment('local'))
<div class="mt-8 p-4 bg-gray-100 rounded-lg">
    <h3 class="text-lg font-semibold text-gray-700">Debug Information</h3>
    <div class="mt-2">
        <p>Selected Date: {{ $selectedDate->format('Y-m-d') }}</p>
        <p>Day of Week: {{ $dayOfWeek }} (1 = Monday, 7 = Sunday)</p>
        <p>Has Office Hours: {{ $hasOfficeHours ? 'Yes' : 'No' }}</p>
        <p>Booked Slots Count: {{ count($bookedSlots) }}</p>
        <p>Available Slots Count: {{ count($availableSlots) }}</p>
        
        @if(count($availableSlots) > 0 && isset($availableSlots[0]['all_debug']))
            <h4 class="mt-3 font-semibold">Debug Log:</h4>
            <pre class="mt-1 bg-white p-2 rounded text-xs">{{ json_encode($availableSlots[0]['all_debug'], JSON_PRETTY_PRINT) }}</pre>
        @endif
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const timeSelect = document.getElementById('time');
    const appointmentForm = document.getElementById('appointmentForm');

    // Form submission validation
    appointmentForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const selectedDate = formData.get('date');
        const selectedTime = formData.get('time');

        // Check if slot is still available
        try {
            const response = await fetch(`/api/booked-slots?date=${selectedDate}`);
            const data = await response.json();
            
            // Check if the selected time is in the booked slots
            const isBooked = data.bookedSlots.some(slot => {
                const slotTime = new Date(slot.start_datetime).toTimeString().substring(0, 5);
                return slotTime === selectedTime;
            });
            
            if (isBooked) {
                showBookedModal();
                return;
            }

            // If slot is available, submit the form
            this.submit();
        } catch (error) {
            console.error('Error checking slot availability:', error);
            this.submit(); // Submit anyway if the check fails
        }
    });
});

// Modal functions
function showBookedModal() {
    document.getElementById('bookedModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('bookedModal').classList.add('hidden');
}
</script>
@endpush
