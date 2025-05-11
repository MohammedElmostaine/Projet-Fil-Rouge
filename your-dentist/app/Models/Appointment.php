<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'assistant_id',
        'start_datetime',
        'end_datetime',
        'description',
        'status',
        'duration',
        'created_by_role',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];

    /**
     * Get the scheduled date attribute.
     */
    protected function scheduledDate(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                // If scheduled_date is null but start_datetime exists, extract the date part
                if ($value === null && $this->start_datetime) {
                    return date('Y-m-d', strtotime($this->start_datetime));
                }
                return $value;
            }
        );
    }
    
    /**
     * Scope a query to only include pending appointments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }
    
    /**
     * Scope a query to only include scheduled appointments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'Scheduled');
    }
    
    /**
     * Scope a query to only include completed appointments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }
    
    /**
     * Scope a query to only include today's appointments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday($query)
    {
        return $query->whereDate('start_datetime', Carbon::today());
    }

    /**
     * Get the patient associated with the appointment.
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Get the doctor associated with the appointment.
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Get the assistant associated with the appointment.
     */
    public function assistant()
    {
        return $this->belongsTo(User::class, 'assistant_id');
    }

    /**
     * Get the medical history associated with this appointment.
     */
    public function medicalHistory()
    {
        return $this->hasOne(MedicalHistory::class, 'patient_id', 'patient_id')
            ->whereDate('date', $this->start_datetime->toDateString());
    }
    
    /**
     * Get the status color for UI display.
     */
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'Pending':
                return 'yellow';
            case 'Scheduled':
                return 'blue';
            case 'In Progress':
                return 'indigo';
            case 'Completed':
                return 'green';
            case 'Cancelled':
                return 'red';
            case 'Rejected':
                return 'red';
            default:
                return 'gray';
        }
    }
}
