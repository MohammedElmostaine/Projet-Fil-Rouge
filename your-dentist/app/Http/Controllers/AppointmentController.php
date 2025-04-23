<?php

namespace App\Http\Controllers;

use App\Models\AppointmentRequest;
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
     * Cancel an appointment request
     */
    public function cancel(AppointmentRequest $appointment)
    {
        // Check if the appointment belongs to the authenticated user
        if ($appointment->patient->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to cancel this appointment.');
        }

        // Only allow cancellation of pending appointments
        if ($appointment->status !== 'Pending') {
            return redirect()->back()->with('error', 'Only pending appointments can be cancelled.');
        }

        try {
            // Update the appointment status to Rejected
            $appointment->status = 'Rejected';
            $appointment->save();

            return redirect()->back()->with('success', 'Appointment cancelled successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while cancelling the appointment.');
        }
    }
}
