<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Show the registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle registration
    public function register(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'fullName' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20',
                'date_of_birth' => 'required|date|before:today',
                'gender' => 'required|in:male,female',
                'password' => 'required|string|min:8|confirmed',
                'terms' => 'required|accepted'
            ], [
                'fullName.required' => 'Please enter your full name.',
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered.',
                'phone.required' => 'Please enter your phone number.',
                'date_of_birth.required' => 'Please enter your date of birth.',
                'date_of_birth.before' => 'Date of birth must be in the past.',
                'gender.required' => 'Please select your gender.',
                'gender.in' => 'Please select a valid gender option.',
                'password.required' => 'Please enter a password.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.confirmed' => 'Passwords do not match.',
                'terms.accepted' => 'You must accept the Terms of Service.'
            ]);

            DB::beginTransaction();

            // Create the user
            $user = User::create([
                'name' => $validated['fullName'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'role' => 'patient', // Default role for new registrations
                'password' => Hash::make($validated['password']),
            ]);

            DB::commit();

            // Log the user in automatically
            Auth::login($user);

            return redirect()->route('dashboard')
                ->with('success', 'Welcome to DentalCare! Your account has been created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput($request->except(['password', 'password_confirmation']));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration error: ' . $e->getMessage());
            
            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', 'Registration failed. Please try again later.');
        }
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember_me'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')
                ->with('success', 'Welcome back!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }

    // Show the dashboard
    public function dashboard()
    {
        $user = Auth::user();
        
        // Redirect based on role
        switch ($user->role) {
            case 'admin':
                return view('dashboards.admin-dashboard', [
                    'stats' => $this->getAdminStats(),
                    'staff' => $this->getStaffList(),
                    'notifications' => $this->getAdminNotifications()
                ]);
                
            case 'doctor':
                return view('dashboards.doctor-dashboard', [
                    'appointments' => $this->getTodayDoctorAppointments(),
                    'appointmentRequests' => $this->getDoctorAppointmentRequests(),
                    'stats' => $this->getDoctorStats(),
                    'todayStats' => $this->getDoctorTodayStats(),
                    'doctor' => $user,
                    'notificationCount' => $this->getUnreadNotificationCount($user->id)
                ]);
                
            case 'assistant':
                return view('dashboards.assistant-dashboard', [
                    'stats' => $this->getAssistantStats(),
                    'appointmentRequests' => $this->getPendingAppointmentRequests(),
                    'todayAppointments' => $this->getTodayAppointments()
                ]);
                
            case 'patient':
            default:
                return view('dashboard');
        }
    }
    
    /**
     * Get admin dashboard statistics
     */
    private function getAdminStats()
    {
        return [
            'patients_count' => User::where('role', 'patient')->count(),
            'patients_increase' => 5,
            'doctors_count' => User::where('role', 'doctor')->count(),
            'new_doctors' => 2,
            'todays_appointments' => \App\Models\AppointmentRequest::whereDate('start_datetime', today())->count(),
            'completed_appointments' => \App\Models\AppointmentRequest::whereDate('start_datetime', today())->where('status', 'Completed')->count(),
            'remaining_appointments' => \App\Models\AppointmentRequest::whereDate('start_datetime', today())->where('status', '!=', 'Completed')->count(),
            'monthly_revenue' => 12500,
            'revenue_increase' => 8
        ];
    }
    
    /**
     * Get staff list for admin dashboard
     */
    private function getStaffList()
    {
        $doctors = User::where('role', 'doctor')->get()->map(function($user) {
            return (object)[
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => 'doctor',
                'specialization' => $user->specialization,
                'status' => 'active',
                'profile_photo' => $user->profile_photo ?? null
            ];
        });
        
        $assistants = User::where('role', 'assistant')->get()->map(function($user) {
            return (object)[
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => 'assistant',
                'status' => 'active',
                'profile_photo' => $user->profile_photo ?? null
            ];
        });
        
        return $doctors->concat($assistants);
    }
    
    /**
     * Get admin notifications
     */
    private function getAdminNotifications()
    {
        return collect([
            (object)[
                'id' => 1,
                'title' => 'System Update Completed',
                'message' => 'The system has been updated to the latest version successfully.',
                'type' => 'success',
                'created_at' => now()->subHours(2)
            ],
            (object)[
                'id' => 2,
                'title' => 'Backup Reminder',
                'message' => 'Please remember to backup the database before the end of the day.',
                'type' => 'warning',
                'created_at' => now()->subHours(5)
            ],
            (object)[
                'id' => 3,
                'title' => 'Server Maintenance',
                'message' => 'Scheduled maintenance will occur tonight from 2AM to 4AM.',
                'type' => 'info',
                'created_at' => now()->subDay()
            ]
        ]);
    }
    
    /**
     * Get doctor's appointments for today
     */
    private function getTodayDoctorAppointments()
    {
        $doctorId = Auth::id();
        return \App\Models\AppointmentRequest::with('patient')
            ->where('doctor_id', $doctorId)
            ->whereDate('start_datetime', today())
            ->orderBy('start_datetime')
            ->get()
            ->map(function($appointment) {
                $appointment->status_color = $this->getStatusColor($appointment->status);
                return $appointment;
            });
    }
    
    /**
     * Get doctor's appointment requests
     */
    private function getDoctorAppointmentRequests()
    {
        $doctorId = Auth::id();
        return \App\Models\AppointmentRequest::with('patient')
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
        return [
            'weekly_appointments' => \App\Models\AppointmentRequest::where('doctor_id', $doctorId)
                ->whereBetween('start_datetime', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'monthly_appointments' => \App\Models\AppointmentRequest::where('doctor_id', $doctorId)
                ->whereBetween('start_datetime', [now()->startOfMonth(), now()->endOfMonth()])
                ->count(),
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
        return [
            'appointment_count' => \App\Models\AppointmentRequest::where('doctor_id', $doctorId)
                ->whereDate('start_datetime', today())
                ->count(),
            'pending_reviews' => 3
        ];
    }
    
    /**
     * Get unread notification count
     */
    private function getUnreadNotificationCount($userId)
    {
        return 5; // Example value, replace with actual count from notifications table
    }
    
    /**
     * Get assistant stats
     */
    private function getAssistantStats()
    {
        return [
            'todays_appointments' => \App\Models\AppointmentRequest::whereDate('start_datetime', today())->count(),
            'total_appointments' => \App\Models\AppointmentRequest::whereDate('start_datetime', today())->count(),
            'checked_in' => \App\Models\AppointmentRequest::whereDate('start_datetime', today())->where('status', 'Checked-in')->count(),
            'pending' => \App\Models\AppointmentRequest::whereDate('start_datetime', today())->where('status', 'Pending')->count(),
            'new_requests' => \App\Models\AppointmentRequest::where('status', 'Pending')->count(),
            'doctors_available' => User::where('role', 'doctor')->count()
        ];
    }
    
    /**
     * Get pending appointment requests
     */
    private function getPendingAppointmentRequests()
    {
        return \App\Models\AppointmentRequest::with('patient')
            ->where('status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($request) {
                $request->status_color = $this->getStatusColor($request->status);
                return $request;
            });
    }
    
    /**
     * Get today's appointments
     */
    private function getTodayAppointments()
    {
        return \App\Models\AppointmentRequest::with(['patient', 'doctor'])
            ->whereDate('start_datetime', today())
            ->orderBy('start_datetime')
            ->get()
            ->map(function($appointment) {
                $appointment->status_color = $this->getStatusColor($appointment->status);
                return $appointment;
            });
    }
    
    /**
     * Get color for status
     */
    private function getStatusColor($status)
    {
        switch ($status) {
            case 'Pending':
                return 'yellow';
            case 'Confirmed':
                return 'blue';
            case 'Checked-in':
                return 'green';
            case 'In Progress':
                return 'purple';
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