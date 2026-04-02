<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctor';
    protected $primaryKey = 'doctor_id'; // Это очень важно для Eloquent!
    public $timestamps = false;
}