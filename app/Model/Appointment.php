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

    // Связь с доктором
    public function doctor()
    {
        // Указываем внешний ключ doctor_id и локальный ключ doctor_id
        return $this->belongsTo(Doctor::class, 'doctor_id', 'doctor_id');
    }

    // Связь с пациентом
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }
}