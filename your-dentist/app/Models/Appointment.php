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
}
