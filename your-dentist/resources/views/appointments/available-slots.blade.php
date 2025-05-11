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

                <!-- Appointment Booking Form -->
                <div class="max-w-3xl mx-auto">
                    <!-- Date Selection Form -->
                    <form id="dateSelectionForm" action="{{ route('appointments.slots') }}" method="GET" class="mb-8">
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <label for="date" class="block text-base font-semibold text-gray-700 mb-3">
                                <i class="fas fa-calendar-alt mr-2 text-primary"></i>Select Date
                            </label>
                            <input type="date" 
                                id="date" 
                                name="date" 
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-gray-700"
                                min="{{ date('Y-m-d') }}"
                                value="{{ old('date', $selectedDate->format('Y-m-d')) }}"
                                onchange="document.getElementById('dateSelectionForm').submit()"
                                required>
                        </div>
                    </form>

                    <!-- Appointment Booking Form -->
                    <form id="appointmentForm" action="{{ route('appointments.book') }}" method="POST" class="space-y-8">
                        @csrf
                        <input type="hidden" name="date" value="{{ old('date', $selectedDate->format('Y-m-d')) }}">

                        <!-- Error Messages -->
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

                        <!-- Success Message -->
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

                        <!-- Time Selection -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <label for="time" class="block text-base font-semibold text-gray-700 mb-3">
                                <i class="fas fa-clock mr-2 text-primary"></i>Select Time
                            </label>
                            <select id="time" 
                                name="time" 
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-gray-700"
                                required>
                                <option value="">Choose a time slot</option>
                                @foreach($availableSlots as $slot)
                                    <option value="{{ $slot['time'] }}" {{ old('time') == $slot['time'] ? 'selected' : '' }}>
                                        {{ $slot['formatted_time'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <label for="description" class="block text-base font-semibold text-gray-700 mb-3">
                                <i class="fas fa-notes-medical mr-2 text-primary"></i>Appointment Description
                            </label>
                            <textarea id="description" 
                                name="description" 
                                rows="4" 
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-gray-700"
                                placeholder="Please describe your dental concern or the type of appointment you need..."
                                required>{{ old('description') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg text-primary-600 font-medium bg-primary hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200 hover:text-white shadow-lg">
                                <i class="fas fa-calendar-check mr-2"></i>
                                Book Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Time Slot Already Booked Modal -->
<div id="bookedModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white p-8 rounded-xl shadow-xl max-w-sm w-full mx-4">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-red-100 mb-6">
                <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Time Slot Not Available</h3>
            <p class="text-base text-gray-600 mb-6">This time slot has already been booked. Please select a different time.</p>
            <button onclick="closeModal()" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-lg px-6 py-3 bg-primary text-base font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200">
                OK
            </button>
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
