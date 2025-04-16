<!-- Upcoming Appointments Section -->
<div class="mb-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-primary text-white px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold">Upcoming Appointments</h2>
            <a href="#" class="text-white hover:text-accent">View All</a>
        </div>
        <div class="p-6">
            <!-- Appointment Card 1 -->
            <div class="border-b border-gray-200 pb-4 mb-4">
                <div class="flex flex-col md:flex-row justify-between md:items-center">
                    <div class="mb-2 md:mb-0">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-calendar-check text-primary mr-2"></i>
                            <span class="font-semibold">Regular Check-up</span>
                        </div>
                        <p class="text-gray-600">Dr. Sarah Johnson - Dentist</p>
                    </div>
                    <div class="flex flex-col md:items-end">
                        <div class="bg-accent text-primary px-3 py-1 rounded-full mb-2 inline-block text-sm">
                            <i class="far fa-clock mr-1"></i> April 5, 2025 - 10:30 AM
                        </div>
                        <div class="flex space-x-2">
                            <button class="text-sm bg-primary hover:bg-primary/80 text-white px-3 py-1 rounded">
                                Reschedule
                            </button>
                            <button class="text-sm bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointment Card 2 -->
            <div class="border-b border-gray-200 pb-4 mb-4">
                <div class="flex flex-col md:flex-row justify-between md:items-center">
                    <div class="mb-2 md:mb-0">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-teeth text-primary mr-2"></i>
                            <span class="font-semibold">Teeth Cleaning</span>
                        </div>
                        <p class="text-gray-600">Dr. Michael Chen - Hygienist</p>
                    </div>
                    <div class="flex flex-col md:items-end">
                        <div class="bg-accent text-primary px-3 py-1 rounded-full mb-2 inline-block text-sm">
                            <i class="far fa-clock mr-1"></i> May 12, 2025 - 2:00 PM
                        </div>
                        <div class="flex space-x-2">
                            <button class="text-sm bg-primary hover:bg-primary/80 text-white px-3 py-1 rounded">
                                Reschedule
                            </button>
                            <button class="text-sm bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- No appointments message (conditionally shown) -->
            <div class="hidden text-center py-4">
                <p class="text-gray-600">No upcoming appointments.</p>
                <button class="mt-2 bg-primary hover:bg-primary/80 text-white px-4 py-2 rounded-md">
                    Schedule New Appointment
                </button>
            </div>
        </div>
    </div>
</div>
