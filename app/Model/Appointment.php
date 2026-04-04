<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointment';
    protected $primaryKey = 'appointment_id';
    public $timestamps = false;

    protected $fillable = [
        'doctor_id',
        'appointment_datetime',
        'user_id',
        'patient_id',
        'status_id',
    ];

    // Связь с доктором (уже должна быть)
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'doctor_id');
    }

    // ДОБАВЬ ЭТО: Связь с пациентом
    // Без этого метода $query->with(['patient']) в контроллере не сработает
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }
}