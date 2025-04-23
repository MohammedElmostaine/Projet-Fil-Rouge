<?php

namespace App\Http\Controllers;

use App\Models\AppointmentRequest;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
   
   public function  patientAppointments()
    {
         // Fetch and return the patient's appointments
         $appointments = auth()->user()->appointments()->with('doctor')->get();
         return view('appointments.index', compact('appointments'));
    }

    /**
     * Cancel an appointment or appointment request
     */
    public function cancel($appointmentId)
    {
        // First try to find an appointment request with this ID
        $appointment = AppointmentRequest::find($appointmentId);
        
        if (!$appointment) {
            // If not found, try to find a confirmed appointment
            $appointment = Appointment::find($appointmentId);
        }
        
        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found.');
        }

        // Check if the appointment belongs to the authenticated user
        if ($appointment->patient_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to cancel this appointment.');
        }

        try {
            // Delete the appointment from the database
            $appointment->delete();

            return redirect()->back()->with('success', 'Appointment cancelled successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while cancelling the appointment: ' . $e->getMessage());
        }
    }
}
