<?php

namespace App\Http\Controllers;

use App\Models\AppointmentRequest;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AssistantController extends Controller
{
    /**
     * Display a list of all appointment requests
     */
    public function appointmentRequests()
    {
        $appointmentRequests = AppointmentRequest::with(['patient', 'doctor'])
            ->where('status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('assistant.appointment-requests', compact('appointmentRequests'));
    }
    
    /**
     * Show the form for scheduling an appointment from a request
     */
    public function scheduleAppointmentForm($id)
    {
        $appointmentRequest = AppointmentRequest::with(['patient', 'doctor'])->findOrFail($id);
        $doctors = User::where('role', 'doctor')->get();
        
        return view('assistant.schedule-appointment', compact('appointmentRequest', 'doctors'));
    }
    
    /**
     * Transform an appointment request into a confirmed appointment
     */
    public function scheduleAppointment(Request $request, $id)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i'
        ]);
        
        // Get the appointment request
        $appointmentRequest = AppointmentRequest::findOrFail($id);
        
        // Only allow scheduling of pending appointments
        if ($appointmentRequest->status !== 'Pending') {
            return redirect()->back()->with('error', 'Only pending appointment requests can be scheduled.');
        }
        
        try {
            DB::beginTransaction();
            
            // Parse the selected date and time
            $appointmentDateTime = Carbon::parse($request->date . ' ' . $request->time);
            $endDateTime = (clone $appointmentDateTime)->addHour(); // 1-hour appointments
            
            // Create a new confirmed appointment
            $appointment = new Appointment();
            $appointment->patient_id = $appointmentRequest->patient_id;
            $appointment->doctor_id = $request->doctor_id;
            $appointment->assistant_id = Auth::id(); // Current assistant
            $appointment->start_datetime = $appointmentDateTime;
            $appointment->end_datetime = $endDateTime;
            $appointment->scheduled_date = $appointmentDateTime->toDateString(); // Set scheduled_date field
            $appointment->description = $appointmentRequest->description;
            $appointment->status = 'Scheduled';
            $appointment->save();
            
            // Update the appointment request status
            $appointmentRequest->status = 'Accepted';
            $appointmentRequest->save();
            
            DB::commit();
            
            return redirect()->route('assistant.appointments.scheduled')
                ->with('success', 'Appointment has been scheduled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred while scheduling the appointment: ' . $e->getMessage());
        }
    }
    
    /**
     * Check in a patient for their appointment
     */
    public function checkInPatient($id)
    {
        $appointment = Appointment::findOrFail($id);
        
        if ($appointment->status !== 'Scheduled') {
            return redirect()->back()->with('error', 'Only scheduled appointments can be checked in.');
        }
        
        try {
            $appointment->status = 'Completed';
            $appointment->save();
            
            return redirect()->back()->with('success', 'Patient checked in successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while checking in the patient.');
        }
    }
    
    /**
     * Show all pending appointments
     */
    public function pendingAppointments()
    {
        $pendingAppointments = AppointmentRequest::with(['patient', 'doctor'])
            ->where('status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('assistant.pending-appointments', compact('pendingAppointments'));
    }
    
    /**
     * Show all scheduled appointments
     */
    public function scheduledAppointments()
    {
        $scheduledAppointments = Appointment::with(['patient', 'doctor'])
            ->where('status', 'Scheduled')
            ->orderBy('start_datetime', 'desc')
            ->paginate(10);
            
        foreach ($scheduledAppointments as $appointment) {
            $appointment->status_color = $this->getStatusColor($appointment->status);
        }
            
        return view('assistant.scheduled-appointments', compact('scheduledAppointments'));
    }
    
    /**
     * Get color for status
     */
    private function getStatusColor($status)
    {
        switch ($status) {
            case 'Pending':
                return 'yellow';
            case 'Accepted':
                return 'blue';
            case 'Scheduled':
                return 'blue';
            case 'Completed':
                return 'green';
            case 'Cancelled':
                return 'red';
            case 'Rejected':
                return 'red';
            default:
                return 'gray';
        }
    }
} 