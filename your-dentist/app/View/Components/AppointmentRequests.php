<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class AppointmentRequests extends Component
{
    public $appointmentRequests;

    public function __construct()
    {
        $user = Auth::user();
        if ($user) {
            $this->appointmentRequests = $user->pendingAppointments()
                ->with(['doctor'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        } else {
            $this->appointmentRequests = collect();
        }
    }

    public function render()
    {
        return view('components.appointment-requests');
    }
} 