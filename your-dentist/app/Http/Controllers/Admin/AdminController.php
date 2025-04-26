<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // Get stats for dashboard
        $stats = $this->getDashboardStats();

        // Get staff for dashboard
        $staff = User::whereIn('role', ['doctor', 'assistant'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get notifications
        $notifications = $this->getNotifications();

        return view('dashboards.admin-dashboard', compact('stats', 'staff', 'notifications'));
    }

    /**
     * Get dashboard statistics.
     *
     * @return array
     */
    private function getDashboardStats()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $lastMonth = $now->copy()->subMonth();
        $startOfLastMonth = $lastMonth->copy()->startOfMonth();
        $endOfLastMonth = $lastMonth->copy()->endOfMonth();
        $today = Carbon::today();

        // Patient stats
        $patientsCount = User::where('role', 'patient')->count();
        $lastMonthPatientsCount = User::where('role', 'patient')
            ->whereDate('created_at', '>=', $startOfLastMonth)
            ->whereDate('created_at', '<=', $endOfLastMonth)
            ->count();
        
        $currentMonthPatientsCount = User::where('role', 'patient')
            ->whereDate('created_at', '>=', $startOfMonth)
            ->whereDate('created_at', '<=', $endOfMonth)
            ->count();
        
        $patientsIncrease = $lastMonthPatientsCount > 0 
            ? round((($currentMonthPatientsCount - $lastMonthPatientsCount) / $lastMonthPatientsCount) * 100, 1)
            : 0;

        // Doctor stats
        $doctorsCount = User::where('role', 'doctor')->count();
        $newDoctors = User::where('role', 'doctor')
            ->whereDate('created_at', '>=', $startOfMonth)
            ->whereDate('created_at', '<=', $endOfMonth)
            ->count();

        // Today's appointments
        $todaysAppointments = Appointment::whereDate('start_datetime', $today)->count();
        $completedAppointments = Appointment::whereDate('start_datetime', $today)
            ->where('status', 'Completed')
            ->count();
        $remainingAppointments = $todaysAppointments - $completedAppointments;

        // Revenue stats - using completed appointments count multiplied by average appointment cost
        $avgAppointmentCost = 150; // Average cost per appointment in $ (hardcoded value)
        
        // Count completed appointments for current month
        $currentMonthCompletedCount = Appointment::whereDate('start_datetime', '>=', $startOfMonth)
            ->whereDate('start_datetime', '<=', $endOfMonth)
            ->where('status', 'Completed')
            ->count();
            
        // Count completed appointments for last month
        $lastMonthCompletedCount = Appointment::whereDate('start_datetime', '>=', $startOfLastMonth)
            ->whereDate('start_datetime', '<=', $endOfLastMonth)
            ->where('status', 'Completed')
            ->count();
        
        // Calculate revenue based on completed appointments count
        $currentMonthRevenue = $currentMonthCompletedCount * $avgAppointmentCost;
        $lastMonthRevenue = $lastMonthCompletedCount * $avgAppointmentCost;

        $revenueIncrease = $lastMonthRevenue > 0 
            ? round((($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : 0;

        return [
            'patients_count' => $patientsCount,
            'patients_increase' => $patientsIncrease,
            'doctors_count' => $doctorsCount,
            'new_doctors' => $newDoctors,
            'todays_appointments' => $todaysAppointments,
            'completed_appointments' => $completedAppointments,
            'remaining_appointments' => $remainingAppointments,
            'monthly_revenue' => $currentMonthRevenue,
            'revenue_increase' => $revenueIncrease,
        ];
    }

    /**
     * Get system notifications.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getNotifications()
    {
        // Example notifications - modify based on your notification system
        return collect([
            (object)[
                'id' => 1,
                'title' => 'System Update',
                'message' => 'The system will be updated on ' . Carbon::now()->addDays(2)->format('M d, Y') . ' at 2:00 AM.',
                'type' => 'info',
                'created_at' => Carbon::now()->subHours(2),
            ],
            (object)[
                'id' => 2,
                'title' => 'Backup Successful',
                'message' => 'The daily database backup completed successfully.',
                'type' => 'success',
                'created_at' => Carbon::now()->subHours(5),
            ],
        ]);
    }
} 