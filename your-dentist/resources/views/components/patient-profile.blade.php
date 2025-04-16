<!-- filepath: c:\Users\elmos\Desktop\Ycode\Projet-Fil-Rouge\your-dentist\resources\views\components\patient-profile.blade.php -->
<div class="mb-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-accent p-6 text-center">
            <div class="w-24 h-24 rounded-full bg-primary text-white mx-auto mb-4 flex items-center justify-center text-3xl">
                <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->name, strpos(Auth::user()->name, ' ') + 1, 1)) }}</span>
            </div>
            <h3 class="text-xl font-bold text-secondary">{{ Auth::user()->name }}</h3>
            <p class="text-gray-600">Patient ID: 10023456</p>
        </div>
        <div class="p-6 border-t border-gray-200">
            <div class="mb-4">
                <h4 class="text-sm text-gray-500 mb-1">Next Appointment</h4>
                <p class="font-semibold">April 5, 2025 - 10:30 AM</p>
            </div>
            <div class="mb-4">
                <h4 class="text-sm text-gray-500 mb-1">Primary Dentist</h4>
                <p class="font-semibold">Dr. Sarah Johnson</p>
            </div>
            <div>
                <h4 class="text-sm text-gray-500 mb-1">Insurance Plan</h4>
                <p class="font-semibold">DentalPlus Premium</p>
            </div>
        </div>
    </div>
</div>