<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function assistant()
    {
        return $this->hasOne(Assistant::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get all appointments for the user through their patient profile
     */
    public function appointments()
    {
        return $this->hasManyThrough(
            AppointmentRequest::class,
            Patient::class,
            'user_id', // Foreign key on patients table...
            'patient_id', // Foreign key on appointment_requests table...
            'id', // Local key on users table...
            'id' // Local key on patients table...
        );
    }

    /**
     * Get all appointment requests for the user through their patient profile
     */
    public function appointmentRequests()
    {
        return $this->hasManyThrough(
            AppointmentRequest::class,
            Patient::class,
            'user_id', // Foreign key on patients table...
            'patient_id', // Foreign key on appointment_requests table...
            'id', // Local key on users table...
            'id' // Local key on patients table...
        );
    }
}
