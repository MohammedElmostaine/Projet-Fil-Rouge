<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\AppointmentRequest;

class AppointmentRequests extends Component
{
    public $appointmentRequests;

    public function __construct()
    {
        $user = Auth::user();
        if ($user) {
            $this->appointmentRequests = $user->appointmentRequests()
                ->with(['doctor.user'])
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