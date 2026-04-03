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

    // Описываем связь с моделью Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'doctor_id');
    }
}