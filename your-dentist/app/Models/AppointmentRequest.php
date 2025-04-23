<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'start_datetime',
        'end_datetime',
        'description',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id')->where('role', 'patient');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id')->where('role', 'doctor');
    }
}
