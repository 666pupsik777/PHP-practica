<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patient';
    protected $primaryKey = 'patient_id';
    public $timestamps = false;

    protected $fillable = [
        'lastname',
        'firstname',
        'patronymic',
        'birth_date',
        'user_id'
    ];
}