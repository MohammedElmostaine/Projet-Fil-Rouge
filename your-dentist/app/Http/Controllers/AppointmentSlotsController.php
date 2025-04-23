<?php

namespace App\Http\Controllers;

use App\Models\AppointmentRequest;
use App\Models\Patient;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentSlotsController extends Controller
{
    /**
     * Show available appointment slots
     */
    public function index(Request $request)
    {
        // Get selected date or use current date
        $selectedDate = $request->input('date') 
            ? Carbon::parse($request->input('date'))
            : Carbon::now();

        // Define office hours (9:00 AM to 5:00 PM, Monday to Friday)
        $officeHours = [
            1 => ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'], // Monday
            2 => ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'], // Tuesday
            3 => ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'], // Wednesday
            4 => ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'], // Thursday
            5 => ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'], // Friday
        ];

        // Get all booked slots for the selected date
        $bookedSlots = $this->getBookedSlotsForDate($selectedDate);
        
        // Get available time slots for the selected date
        $availableSlots = $this->getAvailableSlots($selectedDate, $officeHours, $bookedSlots);
        
        // Get user's patient record
        $patient = $this->getCurrentPatient();
        
        return view('appointments.available-slots', compact(
            'selectedDate',
            'officeHours',
            'availableSlots',
            'patient'
        ));
    }

    /**
     * Get available slots for a specific date
     */
    private function getAvailableSlots($date, $officeHours, $bookedSlots)
    {
        $dayOfWeek = $date->dayOfWeek;
        $availableSlots = [];

        // Return empty array if weekend
        if ($dayOfWeek == 0 || $dayOfWeek == 6) {
            return $availableSlots;
        }

        // Only process if we have office hours for this day
        if (isset($officeHours[$dayOfWeek])) {
            foreach ($officeHours[$dayOfWeek] as $time) {
                $slotDateTime = Carbon::parse($date->format('Y-m-d') . ' ' . $time);
                
                // Skip if slot is in the past
                if ($slotDateTime->isPast()) {
                    continue;
                }
                
                // Check if slot is booked
                $isBooked = $bookedSlots->contains(function($appointment) use ($slotDateTime) {
                    return Carbon::parse($appointment->start_datetime)->format('H:i') === $slotDateTime->format('H:i');
                });
                
                if (!$isBooked) {
                    $availableSlots[] = [
                        'time' => $time,
                        'formatted_time' => $slotDateTime->format('g:i A')
                    ];
                }
            }
        }

        return $availableSlots;
    }

    /**
     * Get booked slots for a specific date
     */
    private function getBookedSlotsForDate($date)
    {
        return AppointmentRequest::where('start_datetime', '>=', $date->startOfDay())
            ->where('start_datetime', '<=', $date->copy()->endOfDay())
            ->where('status', '!=', 'Rejected')
            ->get();
    }

    /**
     * Book an appointment
     */
    public function book(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => [
                'required',
                'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/',
            ],
            'description' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Parse the selected date and time
            $appointmentDateTime = Carbon::parse($request->date . ' ' . $request->time);
            
            // Check if slot is still available
            if (!$this->isSlotAvailable($appointmentDateTime)) {
                return back()
                    ->withInput()
                    ->with('error', 'Sorry, this time slot has just been booked. Please choose another time.');
            }
            
            // Get the patient ID of current user
            $patient = Patient::where('user_id', Auth::id())->firstOrFail();
            
            // Create new appointment request
            $appointment = new AppointmentRequest();
            $appointment->patient_id = $patient->id;
            $appointment->start_datetime = $appointmentDateTime;
            $appointment->end_datetime = $appointmentDateTime->copy()->addHour(); // 1-hour appointments
            $appointment->description = $request->description;
            $appointment->status = 'Pending';
            $appointment->save();

            DB::commit();
            
            return redirect()->route('dashboard')
                ->with('success', 'Your appointment request has been submitted successfully. You will receive a confirmation soon.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'An error occurred while booking your appointment. Please try again.');
        }
    }

    /**
     * Get current authenticated user's patient record
     */
    private function getCurrentPatient()
    {
        return Patient::where('user_id', Auth::id())->firstOrFail();
    }

    /**
     * Check if a time slot is available
     */
    private function isSlotAvailable(Carbon $dateTime)
    {
        // Check if it's a weekday
        if ($dateTime->isWeekend()) {
            return false;
        }

        // Check if it's within office hours (9 AM to 5 PM)
        $hour = (int) $dateTime->format('H');
        if ($hour < 9 || $hour >= 17 || $hour === 12) { // Excluding lunch hour (12-1)
            return false;
        }

        // Check if there's any existing appointment
        return !AppointmentRequest::where('start_datetime', $dateTime)
            ->where('status', '!=', 'Rejected')
            ->exists();
    }
}