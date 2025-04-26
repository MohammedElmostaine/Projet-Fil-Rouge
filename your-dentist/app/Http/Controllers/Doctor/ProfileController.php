<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the doctor's profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('doctor.profile');
    }

    /**
     * Update the doctor's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Validate the doctor info based on actual database columns
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialization' => ['nullable', 'string', 'max:255'],
        ]);
        
        // Update user data
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        
        // Update doctor-specific fields
        if (isset($validated['specialization'])) {
            $user->specialization = $validated['specialization'];
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
        
        return redirect()->route('doctor.profile')->with('success', 'Profile updated successfully.');
    }
} 