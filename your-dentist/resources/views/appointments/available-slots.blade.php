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

<!-- Booking Modal -->
<div id="booking-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 overflow-hidden">
        <div class="bg-primary text-white p-4">
            <h3 class="text-xl font-semibold">Confirm Your Appointment</h3>
        </div>
        <div class="p-6">
            <p class="mb-4 text-gray-600">You are about to book an appointment for:</p>
            <div class="mb-6 p-4 bg-gray-50 rounded-md">
                <div class="mb-2">
                    <span class="text-gray-500">Date:</span>
                    <span class="font-medium text-gray-800" id="modal-date">{{ $selectedDate->format('l, F j, Y') }}</span>
                </div>
                <div class="mb-2">
                    <span class="text-gray-500">Time:</span>
                    <span class="font-medium text-gray-800" id="modal-time"></span>
                </div>
            </div>
            
            <form id="final-booking-form" action="{{ route('appointments.book') }}" method="POST">
                @csrf
                <input type="hidden" name="date" id="modal-date-input">
                <input type="hidden" name="time" id="modal-time-input">
                
                <div class="mb-4">
                    <label for="modal-description" class="block text-sm font-semibold text-secondary mb-2">Reason for Visit</label>
                    <textarea name="description" id="modal-description" rows="3" 
                        class="w-full border border-gray-300 rounded-md p-3 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        placeholder="Please describe your dental concern or reason for appointment"
                        required minlength="10" maxlength="500"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Please provide at least 10 characters</p>
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="hideBookingModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-md">
                        Book Appointment
            </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Time filter functionality
    const timeFilters = document.querySelectorAll('.time-filter');
    const timeSlots = document.querySelectorAll('.time-slot');
    
    timeFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            // Update active state
            timeFilters.forEach(f => {
                f.classList.remove('active', 'bg-accent', 'text-primary');
                f.classList.add('bg-white', 'border', 'border-gray-300', 'text-gray-700');
            });
            
            this.classList.remove('bg-white', 'border', 'border-gray-300', 'text-gray-700');
            this.classList.add('active', 'bg-accent', 'text-primary');

            const timeCategory = this.dataset.filter;
            
            // Filter time slots
            document.querySelectorAll('.slot-booking-form').forEach(form => {
                const slot = form.querySelector('.time-slot');
                if (timeCategory === 'all' || slot.dataset.timeCategory === timeCategory) {
                    form.style.display = 'block';
                } else {
                    form.style.display = 'none';
                }
            });
        });
    });
});

// Modal functions
function showBookingModal(button) {
    const form = button.closest('form');
    const dateInput = form.querySelector('input[name="date"]');
    const timeInput = form.querySelector('input[name="time"]');
    
    // Set date and time in modal
    const date = new Date(dateInput.value);
    const timeText = button.querySelector('span').textContent.trim();
    
    document.getElementById('modal-time').textContent = timeText;
    document.getElementById('modal-date-input').value = dateInput.value;
    document.getElementById('modal-time-input').value = timeInput.value;
    
    // Show modal
    document.getElementById('booking-modal').classList.remove('hidden');
}

function hideBookingModal() {
    document.getElementById('booking-modal').classList.add('hidden');
}
</script>
@endpush
@endsection
