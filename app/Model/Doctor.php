<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public $timestamps = false;
    protected $table = 'doctor';
    protected $primaryKey = 'doctor_id';
}