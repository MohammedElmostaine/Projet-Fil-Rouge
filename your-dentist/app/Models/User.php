<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

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

    /**
     * Get all appointments for the user
     */
    public function appointments()
    {
        if ($this->role === 'patient') {
            return $this->hasMany(Appointment::class, 'patient_id');
        } elseif ($this->role === 'doctor') {
            return $this->hasMany(Appointment::class, 'doctor_id');
        } elseif ($this->role === 'assistant') {
            return $this->hasMany(Appointment::class, 'assistant_id');
        }
        
        return $this->hasMany(Appointment::class, 'patient_id')->whereNull('id'); // Empty relation for other roles
    }

    /**
     * Get pending appointment requests for the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pendingAppointments()
    {
        if ($this->role === 'patient') {
            return $this->hasMany(Appointment::class, 'patient_id')->where('status', 'Pending');
        } elseif ($this->role === 'doctor') {
            return $this->hasMany(Appointment::class, 'doctor_id')->where('status', 'Pending');
        }
        
        return $this->hasMany(Appointment::class, 'patient_id')->whereNull('id'); // Empty relation for other roles
    }
    
    /**
     * Self-referential relationship for User model
     * 
     * This is needed for the dashboard
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
