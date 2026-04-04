<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patient';
    protected $primaryKey = 'patient_id';
    public $timestamps = false;

    // Указываем только те колонки, которые есть в твоей БД
    protected $fillable = [
        'lastname',
        'firstname',
        'patronymic',
        'user_id'
    ];
}