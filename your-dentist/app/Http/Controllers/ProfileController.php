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
        
        // Validate common fields for all users
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);
        
        // Update common user data
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        
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
        
        // Dynamic redirect based on role
        $role = $user->role;
        $redirectRoute = ($role !== 'patient') ? "{$role}.profile" : "profile";
        
        return redirect()->route($redirectRoute)->with('success', 'Profile updated successfully.');
    }
} 