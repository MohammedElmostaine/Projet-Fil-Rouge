<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentSlotsController;

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
    // Dashboard
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