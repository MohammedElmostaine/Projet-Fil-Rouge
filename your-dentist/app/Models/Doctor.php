<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function appointmentRequests()
    {
        return $this->hasMany(AppointmentRequest::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class);
    }
}
