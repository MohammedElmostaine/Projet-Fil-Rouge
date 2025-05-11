<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the user's profile.
     * This should be overridden by role-specific profile controllers.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        $role = $user->role;
        
        // Default view path based on role
        return view("{$role}.profile.edit", compact('user'));
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Validate the basic user info based on actual database columns
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'in:male,female'],
        ]);
        
        // Update user data
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        
        // Update patient-specific fields if they exist
        if (isset($validated['date_of_birth'])) {
            $user->date_of_birth = $validated['date_of_birth'];
        }
        
        if (isset($validated['gender'])) {
            $user->gender = $validated['gender'];
        }
        
        // Handle password update if provided
        if ($request->filled('current_password') && $request->filled('password')) {
            $request->validate([
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            
            // Verify the current password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
            }
            
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
} 