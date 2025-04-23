<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentSlotsController;
use App\Http\Middleware\CheckRole;

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
        ->name('appointments.available');
    
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
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function() {
        return redirect()->route('dashboard');
    });
    
    Route::get('/staff/create', function() {
        return view('admin.staff.create');
    })->name('staff.create');
    
    Route::get('/staff/{id}/edit', function($id) {
        return view('admin.staff.edit', ['id' => $id]);
    })->name('staff.edit');
    
    Route::get('/staff/{id}', function($id) {
        return view('admin.staff.show', ['id' => $id]);
    })->name('staff.show');
    
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
});

// Doctor Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', function() {
        return redirect()->route('dashboard');
    });
    
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
    
    Route::get('/appointments/{id}', function($id) {
        return view('doctor.appointments.show', ['id' => $id]);
    })->name('appointments.show');
    
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
    
    Route::get('/appointments/{id}/schedule', function($id) {
        return view('assistant.appointments.schedule', ['id' => $id]);
    })->name('appointments.schedule');
    
    Route::get('/appointments/{id}', function($id) {
        return view('assistant.appointments.show', ['id' => $id]);
    })->name('appointments.show');
    
    Route::get('/appointments/{id}/check-in', function($id) {
        // Logic to check in patient
        return redirect()->back()->with('success', 'Patient checked in');
    })->name('appointments.check-in');
    
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
    
    Route::get('/appointments/pending', function() {
        return view('assistant.appointments.pending');
    })->name('appointments.pending');
    
    Route::get('/payments', function() {
        return view('assistant.payments.index');
    })->name('payments.index');
});