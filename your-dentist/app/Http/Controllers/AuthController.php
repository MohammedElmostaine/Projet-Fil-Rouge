<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
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
                'password' => Hash::make($validated['password']),
            ]);

            // Create a corresponding patient record
            Patient::create([
                'user_id' => $user->id,
                'role' => 'patient',
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
        return view('dashboard');
    }
}