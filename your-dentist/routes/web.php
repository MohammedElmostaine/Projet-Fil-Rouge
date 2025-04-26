<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentSlotsController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Doctor\ProfileController as DoctorProfileController;
use App\Http\Controllers\Assistant\ProfileController as AssistantProfileController;
use App\Http\Controllers\Doctor\MedicalHistoryController;

// Authentication routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Guest routes
Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Protected routes requiring authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard - This will check role and redirect to appropriate dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Available appointment slots - MAKE SURE THIS COMES BEFORE appointments/{id} routes!
    Route::get('/appointments/available', [AppointmentSlotsController::class, 'index'])
        ->name('appointments.slots');
    
    // Book appointment
    Route::post('/appointments/book', [AppointmentSlotsController::class, 'book'])
        ->name('appointments.book');
    
    // Patient appointments
    Route::get('/appointments', [AppointmentController::class, 'patientAppointments'])
        ->name('patient.appointments');
        
    // Cancel appointment
    Route::delete('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])
        ->name('appointments.cancel');
        
    // API route to fetch booked slots
    Route::get('/api/booked-slots', [AppointmentSlotsController::class, 'getBookedSlots']);

    // Patient profile routes (for authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Staff management routes
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{id}', [StaffController::class, 'show'])->name('staff.show');
    Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{id}', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');
    
    // Keep other existing admin routes
    Route::get('/appointments', function() {
        return view('admin.appointments.index');
    })->name('appointments.index');
    
    Route::get('/reports', function() {
        return view('admin.reports.index');
    })->name('reports.index');
    
    Route::get('/settings', function() {
        return view('admin.settings.index');
    })->name('settings.index');
    
    Route::get('/notifications', function() {
        return view('admin.notifications.index');
    })->name('notifications.index');

    // Admin profile routes
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
});

// Doctor Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments/all', [DoctorController::class, 'allAppointments'])->name('appointments.all');
    
    // Appointment management
    Route::get('/appointments/{id}', [MedicalHistoryController::class, 'create'])->name('appointments.show');
    Route::post('/appointments/{id}/medical-history', [MedicalHistoryController::class, 'store'])->name('medical-history.store');
    
    Route::get('/prescriptions/create', function() {
        return view('doctor.prescriptions.create');
    })->name('prescriptions.create');
    
    Route::get('/medical-records', function() {
        return view('doctor.medical-records.index');
    })->name('medical-records.index');
    
    Route::get('/schedule/edit', function() {
        return view('doctor.schedule.edit');
    })->name('schedule.edit');
    
    Route::get('/notifications', function() {
        return view('doctor.notifications.index');
    })->name('notifications.index');
    
    Route::get('/appointments/create', function() {
        return view('doctor.appointments.create');
    })->name('appointments.create');
    
    Route::post('/appointments/{id}/start', function($id) {
        // Logic to start appointment
        return redirect()->back()->with('success', 'Appointment started');
    })->name('appointments.start');
    
    Route::post('/appointments/{id}/complete', function($id) {
        // Logic to complete appointment
        return redirect()->back()->with('success', 'Appointment completed');
    })->name('appointments.complete');
    
    Route::post('/appointments/{id}/accept', function($id) {
        // Logic to accept appointment
        return redirect()->back()->with('success', 'Appointment accepted');
    })->name('appointments.accept');
    
    Route::post('/appointments/{id}/reject', function($id) {
        // Logic to reject appointment
        return redirect()->back()->with('success', 'Appointment rejected');
    })->name('appointments.reject');

    // Doctor profile routes
    Route::get('/profile', [DoctorProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [DoctorProfileController::class, 'update'])->name('profile.update');
});

// Assistant Routes
Route::middleware(['auth', 'role:assistant'])->prefix('assistant')->name('assistant.')->group(function () {
    Route::get('/dashboard', function() {
        return redirect()->route('dashboard');
    });
    
    Route::get('/appointments/create', function() {
        return view('assistant.appointments.create');
    })->name('appointments.create');
    
    Route::get('/patients/create', function() {
        return view('assistant.patients.create');
    })->name('patients.create');
    
    Route::get('/reminders/send', function() {
        return view('assistant.reminders.send');
    })->name('reminders.send');
    
    // Appointment management routes
    Route::get('/appointments/pending', [AssistantController::class, 'pendingAppointments'])
        ->name('appointments.pending');
    
    // Scheduled appointments route
    Route::get('/appointments/scheduled', [AssistantController::class, 'scheduledAppointments'])
        ->name('appointments.scheduled');
    
    // Use the schedule-form route for showing the form and schedule for processing the form
    Route::get('/appointments/{id}/schedule', [AssistantController::class, 'scheduleAppointmentForm'])
        ->name('appointments.schedule');
    
    Route::post('/appointments/{id}/schedule', [AssistantController::class, 'scheduleAppointment'])
        ->name('appointments.schedule.store');
    
    Route::get('/appointments/{id}/check-in', [AssistantController::class, 'checkInPatient'])
        ->name('appointments.check-in');
    
    Route::get('/appointments/{id}', function($id) {
        return view('assistant.appointments.show', ['id' => $id]);
    })->name('appointments.show');
    
    Route::post('/appointments/check-in-search', function() {
        // Logic to search for appointment to check in
        return redirect()->back()->with('success', 'Patient found');
    })->name('appointments.check-in-search');
    
    Route::get('/schedule/view', function() {
        return view('assistant.schedule.view');
    })->name('schedule.view');
    
    Route::get('/patients', function() {
        return view('assistant.patients.index');
    })->name('patients.index');
    
    Route::get('/payments', function() {
        return view('assistant.payments.index');
    })->name('payments.index');

    // Assistant profile routes
    Route::get('/profile', [AssistantProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [AssistantProfileController::class, 'update'])->name('profile.update');
});