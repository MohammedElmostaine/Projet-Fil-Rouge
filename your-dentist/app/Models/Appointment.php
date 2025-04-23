<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'assistant_id',
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

    public function assistant()
    {
        return $this->belongsTo(User::class, 'assistant_id')->where('role', 'assistant');
    }
}
