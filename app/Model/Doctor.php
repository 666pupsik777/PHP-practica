<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctor';
    protected $primaryKey = 'doctor_id';
    public $timestamps = false;

    // Проверь, чтобы эти поля были тут:
    protected $fillable = [
        'lastname',
        'firstname',
        'patronymic',
        'specialization',
        'position_id' // ОБЯЗАТЕЛЬНО ДОБАВЬ ЭТО
    ];
}