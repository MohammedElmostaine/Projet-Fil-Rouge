<!-- filepath: c:\Users\elmos\Desktop\Ycode\Projet-Fil-Rouge\your-dentist\resources\views\appointments\available-slots.blade.php -->
@extends('layouts.dashboard')

@section('title', 'Available Appointment Slots')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Available Appointment Slots</h1>
            <p class="text-gray-600">Select an available time slot to schedule your dental appointment.</p>
        </div>

        <!-- Date Filter -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form id="date-filter-form" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="w-full md:w-1/3">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" id="start_date" name="start_date" 
                           value="{{ $startDate->format('Y-m-d') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50">
                </div>
                <div class="w-full md:w-1/3">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" id="end_date" name="end_date" 
                           value="{{ $endDate->format('Y-m-d') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50">
                </div>
                <div class="w-full md:w-1/3">
                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md">
                        <i class="fas fa-filter mr-2"></i> Filter Appointments
                    </button>
                </div>
            </form>
        </div>

        <!-- Time Filter -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-medium text-gray-700 mb-3">Filter by Time</h2>
            <div class="flex flex-wrap gap-2">
                <button type="button" class="time-filter px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-medium hover:bg-primary-200 active" data-time="all">
                    All Times
                </button>
                <button type="button" class="time-filter px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-full text-sm font-medium hover:bg-gray-50" data-time="morning">
                    Morning (9AM - 12PM)
                </button>
                <button type="button" class="time-filter px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-full text-sm font-medium hover:bg-gray-50" data-time="afternoon">
                    Afternoon (1PM - 5PM)
                </button>
            </div>
        </div>

        <!-- Calendar View -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 bg-primary-700 text-white flex justify-between items-center">
                <h2 class="text-xl font-semibold">Appointment Calendar</h2>
                <div class="flex space-x-4">
                    <button id="prev-week" class="text-white hover:text-primary-200">
                        <i class="fas fa-chevron-left"></i> Previous Week
                    </button>
                    <button id="next-week" class="text-white hover:text-primary-200">
                        Next Week <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-6 overflow-x-auto">
                <div class="calendar-legend flex items-center justify-end mb-4 space-x-4 text-sm">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-primary-100 border border-primary-300 rounded mr-2"></div>
                        <span>Available</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-primary-500 rounded mr-2"></div>
                        <span>Selected</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-gray-200 rounded mr-2"></div>
                        <span>Booked</span>
                    </div>
                </div>

                <div id="appointments-calendar" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-7 gap-6">
                    @forelse($slots as $date => $dayData)
                        <div class="border rounded-lg overflow-hidden day-column" data-date="{{ $date }}">
                            <div class="bg-primary-600 text-white p-3 text-center">
                                <h3 class="font-medium">{{ $dayData['day_name'] }}</h3>
                                <p class="text-sm">{{ $dayData['formatted_date'] }}</p>
                            </div>
                            <div class="p-3 space-y-2 slot-container">
                                @forelse($dayData['slots'] as $slot)
                                    @php
                                        $isBooked = isset($bookedSlots[$slot['start']]);
                                        $slotTime = \Carbon\Carbon::parse($slot['start'])->format('H:i');
                                        $timeClass = 
                                            (substr($slotTime, 0, 2) >= 9 && substr($slotTime, 0, 2) < 12) 
                                            ? 'morning' 
                                            : 'afternoon';
                                    @endphp
                                    <div 
                                        class="time-slot p-2 rounded text-center text-sm transition-colors cursor-pointer {{ $isBooked ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-primary-100 text-primary-800 hover:bg-primary-200' }}"
                                        data-start="{{ $slot['start'] }}"
                                        data-end="{{ $slot['end'] }}"
                                        data-booked="{{ $isBooked ? 'true' : 'false' }}"
                                        data-time-category="{{ $timeClass }}"
                                    >
                                        {{ $slot['formatted_time'] }}
                                        @if($isBooked)
                                            <span class="block text-xs mt-1">Booked</span>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center text-gray-500 py-4">No slots available</div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-10 text-gray-500">
                            <i class="far fa-calendar-times text-4xl mb-3 block"></i>
                            <p>No appointment slots available for the selected date range.</p>
                            <p class="mt-2">Try selecting different dates or contact the clinic directly.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Selected Appointment Summary -->
        <div id="appointment-summary" class="mt-8 bg-white rounded-lg shadow-md p-6 hidden">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Selected Appointment</h2>
            <div class="flex flex-col md:flex-row justify-between">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-700"><span class="font-medium">Date:</span> <span id="selected-date"></span></p>
                    <p class="text-gray-700"><span class="font-medium">Time:</span> <span id="selected-time"></span></p>
                </div>
                <div class="flex items-center space-x-4">
                    <button id="confirm-appointment" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md">
                        <i class="fas fa-check-circle mr-1"></i> Confirm Booking
                    </button>
                    <button id="cancel-selection" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 py-2 px-4 rounded-md">
                        <i class="fas fa-times-circle mr-1"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Appointment Booking Form Modal -->
<div id="booking-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6 m-4 relative">
        <button id="close-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div class="text-center mb-6">
            <div class="mx-auto w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-calendar-check text-primary-600 text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">Confirm Your Appointment</h3>
            <p class="text-gray-600 mt-2">Please provide additional details for your appointment</p>
        </div>
        
        <form id="booking-form" action="{{ route('appointments.book') }}" method="POST">
            @csrf
            <input type="hidden" id="appointment_start_datetime" name="start_datetime">
            <input type="hidden" id="appointment_end_datetime" name="end_datetime">
            
            <div class="mb-4">
                <label for="appointment_reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Visit</label>
                <select id="appointment_reason" name="description" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" required>
                    <option value="">Select a reason</option>
                    <option value="Regular Check-up">Regular Check-up</option>
                    <option value="Teeth Cleaning">Teeth Cleaning</option>
                    <option value="Toothache">Toothache</option>
                    <option value="Filling">Filling</option>
                    <option value="Root Canal">Root Canal</option>
                    <option value="Extraction">Extraction</option>
                    <option value="Consultation">Consultation</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            
            <div class="mb-4" id="other_reason_container" style="display: none;">
                <label for="other_reason" class="block text-sm font-medium text-gray-700 mb-1">Please Specify</label>
                <textarea id="other_reason" name="other_reason" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50"></textarea>
            </div>
            
            <div class="mb-4">
                <label for="additional_notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes (Optional)</label>
                <textarea id="additional_notes" name="additional_notes" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50"></textarea>
            </div>
            
            <div class="mb-6">
                <label class="flex items-start">
                    <input type="checkbox" name="terms" required class="mt-1 rounded text-primary-600 focus:ring-primary-500 mr-2">
                    <span class="text-sm text-gray-600">I understand that I must cancel or reschedule at least 24 hours before my appointment to avoid a cancellation fee.</span>
                </label>
            </div>
            
            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-lg font-medium transition-colors">
                <i class="fas fa-calendar-check mr-2"></i> Book Appointment
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables
        let selectedSlot = null;
        const timeSlots = document.querySelectorAll('.time-slot');
        const timeFilters = document.querySelectorAll('.time-filter');
        const appointmentSummary = document.getElementById('appointment-summary');
        const selectedDate = document.getElementById('selected-date');
        const selectedTime = document.getElementById('selected-time');
        const confirmAppointmentBtn = document.getElementById('confirm-appointment');
        const cancelSelectionBtn = document.getElementById('cancel-selection');
        const bookingModal = document.getElementById('booking-modal');
        const closeModalBtn = document.getElementById('close-modal');
        const bookingForm = document.getElementById('booking-form');
        const appointmentStartInput = document.getElementById('appointment_start_datetime');
        const appointmentEndInput = document.getElementById('appointment_end_datetime');
        const appointmentReasonSelect = document.getElementById('appointment_reason');
        const otherReasonContainer = document.getElementById('other_reason_container');
        
        // Previous and Next Week navigation
        document.getElementById('prev-week').addEventListener('click', function() {
            const startDate = new Date(document.getElementById('start_date').value);
            startDate.setDate(startDate.getDate() - 7);
            
            const endDate = new Date(document.getElementById('end_date').value);
            endDate.setDate(endDate.getDate() - 7);
            
            document.getElementById('start_date').value = formatDateForInput(startDate);
            document.getElementById('end_date').value = formatDateForInput(endDate);
            
            document.getElementById('date-filter-form').submit();
        });
        
        document.getElementById('next-week').addEventListener('click', function() {
            const startDate = new Date(document.getElementById('start_date').value);
            startDate.setDate(startDate.getDate() + 7);
            
            const endDate = new Date(document.getElementById('end_date').value);
            endDate.setDate(endDate.getDate() + 7);
            
            document.getElementById('start_date').value = formatDateForInput(startDate);
            document.getElementById('end_date').value = formatDateForInput(endDate);
            
            document.getElementById('date-filter-form').submit();
        });
        
        // Helper function to format date for input field
        function formatDateForInput(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
        
        // Time slot selection
        timeSlots.forEach(slot => {
            if (slot.dataset.booked === 'false') {
                slot.addEventListener('click', function() {
                    // Clear previous selection
                    if (selectedSlot) {
                        selectedSlot.classList.remove('bg-primary-500', 'text-white');
                        selectedSlot.classList.add('bg-primary-100', 'text-primary-800');
                    }
                    
                    // Update new selection
                    selectedSlot = this;
                    this.classList.remove('bg-primary-100', 'text-primary-800');
                    this.classList.add('bg-primary-500', 'text-white');
                    
                    // Show appointment summary
                    const startDateTime = new Date(this.dataset.start);
                    const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    const timeOptions = { hour: 'numeric', minute: 'numeric', hour12: true };
                    
                    selectedDate.textContent = startDateTime.toLocaleDateString('en-US', dateOptions);
                    selectedTime.textContent = this.textContent.trim();
                    appointmentSummary.classList.remove('hidden');
                    
                    // Scroll to summary if it's out of view
                    appointmentSummary.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                });
            }
        });
        
        // Time filter functionality
        timeFilters.forEach(filter => {
            filter.addEventListener('click', function() {
                // Update active filter button
                timeFilters.forEach(btn => {
                    btn.classList.remove('bg-primary-100', 'text-primary-700', 'active');
                    btn.classList.add('bg-white', 'border', 'border-gray-300', 'text-gray-700');
                });
                
                this.classList.remove('bg-white', 'border', 'border-gray-300', 'text-gray-700');
                this.classList.add('bg-primary-100', 'text-primary-700', 'active');
                
                const selectedTime = this.dataset.time;
                
                // Filter time slots
                timeSlots.forEach(slot => {
                    const slotColumn = slot.closest('.day-column');
                    
                    if (selectedTime === 'all') {
                        slot.classList.remove('hidden');
                    } else if (selectedTime === slot.dataset.timeCategory) {
                        slot.classList.remove('hidden');
                    } else {
                        slot.classList.add('hidden');
                    }
                });
                
                // Check if all slots in a day are hidden
                document.querySelectorAll('.day-column').forEach(dayCol => {
                    const visibleSlots = dayCol.querySelectorAll('.time-slot:not(.hidden)');
                    const noSlotsMessage = dayCol.querySelector('.slot-container .text-center.text-gray-500');
                    
                    if (visibleSlots.length === 0 && !noSlotsMessage) {
                        const noSlotsDiv = document.createElement('div');
                        noSlotsDiv.className = 'text-center text-gray-500 py-4 no-slots-message';
                        noSlotsDiv.textContent = 'No slots available for selected time';
                        dayCol.querySelector('.slot-container').appendChild(noSlotsDiv);
                    } else if (visibleSlots.length > 0 && noSlotsMessage) {
                        const messages = dayCol.querySelectorAll('.no-slots-message');
                        messages.forEach(msg => msg.remove());
                    }
                });
            });
        });
        
        // Cancel selection button
        cancelSelectionBtn.addEventListener('click', function() {
            if (selectedSlot) {
                selectedSlot.classList.remove('bg-primary-500', 'text-white');
                selectedSlot.classList.add('bg-primary-100', 'text-primary-800');
                selectedSlot = null;
            }
            appointmentSummary.classList.add('hidden');
        });
        
        // Confirm appointment button - show booking modal
        confirmAppointmentBtn.addEventListener('click', function() {
            if (selectedSlot) {
                appointmentStartInput.value = selectedSlot.dataset.start;
                appointmentEndInput.value = selectedSlot.dataset.end;
                bookingModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        });
        
        // Close modal
        closeModalBtn.addEventListener('click', function() {
            bookingModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
        
        // Close modal when clicking outside
        bookingModal.addEventListener('click', function(e) {
            if (e.target === bookingModal) {
                bookingModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
        
        // Show/hide "Other" reason field
        appointmentReasonSelect.addEventListener('change', function() {
            if (this.value === 'Other') {
                otherReasonContainer.style.display = 'block';
            } else {
                otherReasonContainer.style.display = 'none';
            }
        });
        
        // Booking form submission
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Combine reason if "Other" is selected
            if (appointmentReasonSelect.value === 'Other') {
                const otherReason = document.getElementById('other_reason').value;
                if (otherReason) {
                    appointmentReasonSelect.value = 'Other: ' + otherReason;
                }
            }
            
            // Submit form
            this.submit();
        });
    });
</script>
@endsection