<!-- filepath: resources/views/components/welcome-section.blade.php -->
<div class="mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex flex-col md:flex-row justify-between md:items-center">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-secondary">Welcome, {{ Auth::user()->name }}</h1>
                <p class="text-gray-600">Last login: {{ now()->format('F d, Y \a\t H:i') }}</p>
            </div>
            <div class="text-center mt-4 md:mt-0">
                <span class="block text-lg font-semibold text-primary">Current Date:</span>
                <span class="text-gray-600">{{ now()->format('Y-m-d') }}</span>
            </div>
        </div>
        <div class="mt-4 flex flex-wrap gap-4">
            <a href="{{ route('appointments.slots') }}" class="bg-[#075985] hover:bg-[#0369a1] text-white px-4 py-2 rounded-md inline-flex items-center">
                <i class="fas fa-calendar-plus mr-2"></i> Book Appointment
            </a>
        </div>
    </div>
</div>
