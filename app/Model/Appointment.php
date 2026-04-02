<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointment';
    protected $primaryKey = 'appointment_id';
    public $timestamps = false;

    protected $fillable = [
        'appointment_datetime',
        'patient_id',
        'doctor_id',   // Проверь, что в БД колонка называется именно так
        'status_id',
        'user_id'
    ];
}