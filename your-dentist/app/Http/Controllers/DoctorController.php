<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DoctorController extends Controller
{
    /**
     * Display doctor's dashboard
     */
    public function dashboard()
    {
        // Get upcoming scheduled appointments
        $upcomingAppointments = Appointment::with(['patient', 'assistant'])
            ->where('doctor_id', Auth::id())
            ->where('status', 'Scheduled')
            ->where('start_datetime', '>', now())
            ->orderBy('start_datetime')
            ->take(5)
            ->get()
            ->map(function($appointment) {
                $appointment->status_color = $this->getStatusColor($appointment->status);
                return $appointment;
            });
        
        return view('dashboards.doctor-dashboard', [
            'appointments' => $this->getTodayDoctorAppointments(),
            'appointmentRequests' => $this->getDoctorAppointmentRequests(),
            'stats' => $this->getDoctorStats(),
            'todayStats' => $this->getDoctorTodayStats(),
            'upcomingAppointments' => $upcomingAppointments,
            'doctor' => Auth::user(),
            'notificationCount' => 5 // Example value
        ]);
    }

    /**
     * Display all appointments, organized by day
     */
    public function allAppointments(Request $request)
    {
        // Default to current week if no date specified
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfWeek();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : $startDate->copy()->addDays(6);
        
        // Get the doctor's ID
        $doctorId = Auth::id();
        
        // Create an array to hold appointments for each day
        $appointmentsByDay = [];
        
        // Loop through each day in the date range
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dateString = $currentDate->format('Y-m-d');
            
            // Get appointments from the appointments table
            $appointments = Appointment::with(['patient', 'assistant'])
                ->where('doctor_id', $doctorId)
                ->whereDate('start_datetime', $dateString)
                ->orderBy('start_datetime')
                ->get();
            
            // Get appointment requests that are accepted
            $appointmentRequests = AppointmentRequest::with('patient')
                ->where('doctor_id', $doctorId)
                ->whereDate('start_datetime', $dateString)
                ->whereIn('status', ['Accepted', 'Scheduled'])
                ->orderBy('start_datetime')
                ->get();
            
            // Combine both collections and add status colors
            $dayAppointments = $appointments->concat($appointmentRequests)
                ->map(function($appointment) {
                    $appointment->status_color = $this->getStatusColor($appointment->status);
                    
                    // Make sure we have a valid patient
                    if (!$appointment->patient) {
                        $appointment->patient = (object)[
                            'name' => 'Unknown Patient',
                            'id' => $appointment->patient_id,
                            'email' => 'N/A',
                            'phone' => 'N/A'
                        ];
                    }
                    
                    return $appointment;
                })
                ->sortBy('start_datetime');
            
            // Add this day's appointments to the array
            $appointmentsByDay[$dateString] = [
                'date' => $currentDate->copy(),
                'date_formatted' => $currentDate->format('l, F j, Y'),
                'appointments' => $dayAppointments
            ];
            
            // Move to the next day
            $currentDate->addDay();
        }
        
        return view('doctor.appointments.all', [
            'appointmentsByDay' => $appointmentsByDay,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'doctor' => Auth::user()
        ]);
    }

    /**
     * Get doctor's appointments for today
     */
    private function getTodayDoctorAppointments()
    {
        $doctorId = Auth::id();
        $today = today()->toDateString();
        
        // Get regular appointments
        $confirmedAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->whereDate('start_datetime', $today)
            ->orderBy('start_datetime')
            ->get();
            
        // Get appointment requests
        $appointmentRequests = AppointmentRequest::with('patient')
            ->where('doctor_id', $doctorId)
            ->whereDate('start_datetime', $today)
            ->whereIn('status', ['Accepted', 'Scheduled'])
            ->orderBy('start_datetime')
            ->get();
            
        // Combine both collections
        $allAppointments = $confirmedAppointments->concat($appointmentRequests)
            ->map(function($appointment) {
                $appointment->status_color = $this->getStatusColor($appointment->status);
                
                // Make sure we have a valid patient with a valid name
                if (!$appointment->patient) {
                    $appointment->patient = (object)[
                        'name' => 'Unknown Patient',
                        'id' => $appointment->patient_id,
                        'email' => 'N/A',
                        'phone' => 'N/A'
                    ];
                }
                
                return $appointment;
            });
            
        return $allAppointments->sortBy('start_datetime');
    }
    
    /**
     * Get doctor's appointment requests
     */
    private function getDoctorAppointmentRequests()
    {
        $doctorId = Auth::id();
        return AppointmentRequest::with('patient')
            ->where('doctor_id', $doctorId)
            ->where('status', 'Pending')
            ->orderBy('start_datetime')
            ->take(5)
            ->get();
    }
    
    /**
     * Get doctor stats
     */
    private function getDoctorStats()
    {
        $doctorId = Auth::id();
        
        // Count confirmed appointments from the appointment table
        $scheduledAppointments = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'Scheduled')
            ->count();
            
        return [
            'weekly_appointments' => Appointment::where('doctor_id', $doctorId)
                ->whereBetween('start_datetime', [now()->startOfWeek(), now()->endOfWeek()])
                ->count() + 
                AppointmentRequest::where('doctor_id', $doctorId)
                ->whereBetween('start_datetime', [now()->startOfWeek(), now()->endOfWeek()])
                ->whereIn('status', ['Accepted'])
                ->count(),
                
            'monthly_appointments' => Appointment::where('doctor_id', $doctorId)
                ->whereBetween('start_datetime', [now()->startOfMonth(), now()->endOfMonth()])
                ->count() +
                AppointmentRequest::where('doctor_id', $doctorId)
                ->whereBetween('start_datetime', [now()->startOfMonth(), now()->endOfMonth()])
                ->whereIn('status', ['Accepted'])
                ->count(),
            
            'scheduled_appointments' => $scheduledAppointments,
            'new_patients' => 12,
            'satisfaction_rate' => 95
        ];
    }
    
    /**
     * Get doctor's today stats
     */
    private function getDoctorTodayStats()
    {
        $doctorId = Auth::id();
        $today = today()->toDateString();
        
        $appointmentsToday = Appointment::where('doctor_id', $doctorId)
            ->whereDate('start_datetime', $today)
            ->count();
            
        $requestsToday = AppointmentRequest::where('doctor_id', $doctorId)
            ->whereDate('start_datetime', $today)
            ->whereIn('status', ['Accepted', 'Scheduled'])
            ->count();
            
        $scheduledToday = Appointment::where('doctor_id', $doctorId)
            ->whereDate('start_datetime', $today)
            ->where('status', 'Scheduled')
            ->count();
            
        return [
            'appointment_count' => $appointmentsToday + $requestsToday,
            'scheduled_today' => $scheduledToday,
            'pending_reviews' => 3
        ];
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