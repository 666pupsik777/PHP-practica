<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

// app/Model/Doctor.php
class Doctor extends Model {
    protected $table = 'doctor';
    protected $primaryKey = 'doctor_id'; // Если первичный ключ не id
    public $timestamps = false;
}