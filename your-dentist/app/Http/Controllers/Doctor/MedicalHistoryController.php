<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalHistory;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MedicalHistoryController extends Controller
{
    /**
     * Show the form for creating a new medical history.
     *
     * @param  int  $appointmentId
     * @return \Illuminate\View\View
     */
    public function create($appointmentId)
    {
        $appointment = Appointment::with('patient')->findOrFail($appointmentId);
        
        // Authorization: Check if the logged-in doctor is assigned to this appointment
        if ($appointment->doctor_id !== Auth::id()) {
            return redirect()->route('doctor.appointments.all')
                ->with('error', 'You are not authorized to access this appointment.');
        }
        
        // Check if a medical history already exists for this appointment
        $medicalHistory = MedicalHistory::where('patient_id', $appointment->patient_id)
            ->where('doctor_id', Auth::id())
            ->whereDate('date', Carbon::parse($appointment->start_datetime)->toDateString())
            ->first();
            
        // Get patient's previous medical history records
        $patientHistory = MedicalHistory::where('patient_id', $appointment->patient_id)
            ->with('doctor')
            ->where(function($query) use ($appointment) {
                // Exclude the current appointment's history if it exists
                if (Carbon::parse($appointment->start_datetime)->isToday()) {
                    $query->whereDate('date', '!=', Carbon::today());
                }
            })
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
            
        return view('doctor.appointments.show', [
            'appointment' => $appointment,
            'medicalHistory' => $medicalHistory,
            'patientHistory' => $patientHistory
        ]);
    }

    /**
     * Store a newly created medical history.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $appointmentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        
        // Authorization: Check if the logged-in doctor is assigned to this appointment
        if ($appointment->doctor_id !== Auth::id()) {
            return redirect()->route('doctor.appointments.all')
                ->with('error', 'You are not authorized to access this appointment.');
        }
        
        // Validate the request
        $request->validate([
            'details' => 'required|string',
            'patient_id' => 'required|exists:users,id',
        ]);
        
        // Create the medical history
        $medicalHistory = new MedicalHistory([
            'patient_id' => $request->patient_id,
            'doctor_id' => Auth::id(),
            'details' => $request->details,
            'date' => Carbon::now()->toDateString(),
        ]);
        
        $medicalHistory->save();
        
        // If action is complete, also update the appointment status
        if ($request->action === 'complete') {
            $appointment->status = 'Completed';
            $appointment->end_datetime = Carbon::now();
            $appointment->save();
            
            return redirect()->route('doctor.appointments.all')
                ->with('success', 'Appointment completed and medical history saved successfully.');
        }
        
        return redirect()->route('doctor.appointments.show', $appointmentId)
            ->with('success', 'Medical history saved successfully.');
    }
} 