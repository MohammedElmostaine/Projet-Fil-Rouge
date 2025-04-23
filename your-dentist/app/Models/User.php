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
        'role',
        'specialization',
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

    /**
     * Check if user is an admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a doctor
     *
     * @return bool
     */
    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    /**
     * Check if user is an assistant
     *
     * @return bool
     */
    public function isAssistant(): bool
    {
        return $this->role === 'assistant';
    }

    /**
     * Check if user is a patient
     *
     * @return bool
     */
    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get all appointments for the user
     */
    public function appointments()
    {
        return $this->hasMany(AppointmentRequest::class, 'patient_id')
            ->when($this->role === 'patient', function ($query) {
                return $query->where('patient_id', $this->id);
            })
            ->when($this->role === 'doctor', function ($query) {
                return $query->where('doctor_id', $this->id);
            });
    }

    /**
     * Get appointment requests for the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointmentRequests()
    {
        if ($this->role === 'patient') {
            return $this->hasMany(AppointmentRequest::class, 'patient_id');
        } elseif ($this->role === 'doctor') {
            return $this->hasMany(AppointmentRequest::class, 'doctor_id');
        }
        
        return $this->hasMany(AppointmentRequest::class, 'patient_id')->whereNull('id'); // Empty relation for other roles
    }
}
