<!-- Medical History Section -->
<div class="mb-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-primary text-white px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold">Medical History</h2>
            <a href="{{ route('patient.medical-history.all') }}" class="bg-white text-primary hover:bg-gray-100 px-3 py-1 rounded text-sm">
                <i class="fas fa-history mr-1"></i> View Full History
            </a>
        </div>
        <div class="p-6">
            @php
                // Get medical history for the current patient
                $medicalHistories = \App\Models\MedicalHistory::where('patient_id', Auth::id())
                    ->with('doctor')
                    ->orderBy('date', 'desc')
                    ->limit(5)
                    ->get();
                
                // Get latest medical history for summary
                $latestMedicalHistory = $medicalHistories->first();
            @endphp
            
            <!-- Medical History Summary -->
            <div class="mb-6 bg-blue-50 border border-blue-100 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold text-secondary mb-3">Medical Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-700 font-medium mb-1">Last Visit</p>
                        <p class="font-medium text-primary">{{ $latestMedicalHistory ? \Carbon\Carbon::parse($latestMedicalHistory->date)->format('M d, Y') : 'No visits recorded' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-700 font-medium mb-1">Last Doctor Seen</p>
                        <p class="font-medium text-primary">{{ $latestMedicalHistory && $latestMedicalHistory->doctor ? 'Dr. ' . $latestMedicalHistory->doctor->name : 'None' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-700 font-medium mb-1">Total Records</p>
                        <p class="font-medium text-primary">{{ \App\Models\MedicalHistory::where('patient_id', Auth::id())->count() }}</p>
                    </div>
                    <div>
                        <p class="text-gray-700 font-medium mb-1">Status</p>
                        <p class="font-medium">
                            @if($latestMedicalHistory && \Carbon\Carbon::parse($latestMedicalHistory->date)->diffInMonths(now()) < 6)
                                <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i> Up to date</span>
                            @else
                                <span class="text-yellow-600"><i class="fas fa-exclamation-circle mr-1"></i> Check-up recommended</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <h3 class="text-lg font-semibold text-secondary mb-3">Recent Treatment History</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Date</th>
                            <th class="py-3 px-4 text-left">Doctor</th>
                            <th class="py-3 px-4 text-left">Treatment Summary</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($medicalHistories as $history)
                            <tr class="border-b border-gray-200">
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($history->date)->format('M d, Y') }}</td>
                                <td class="py-3 px-4">Dr. {{ $history->doctor->name ?? 'Unknown' }}</td>
                                <td class="py-3 px-4">{{ \Illuminate\Support\Str::limit(strip_tags($history->details), 50) }}</td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('patient.medical-history.show', $history->id) }}" 
                                        class="bg-primary hover:bg-primary-dark text-white px-3 py-1 rounded text-sm">
                                        <i class="fas fa-eye mr-1"></i> View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-3 px-4 text-center text-gray-500">No medical history records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>