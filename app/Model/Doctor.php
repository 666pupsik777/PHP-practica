<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctor';
    protected $primaryKey = 'doctor_id';
    public $timestamps = false;

    protected $fillable = [
        'lastname',
        'firstname',
        'patronymic',
        'specialization',
        'position_id',
        'birth_date' // Это поле позволит Laravel сохранять дату
    ];
}