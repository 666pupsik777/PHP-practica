<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public $timestamps = false;
    protected $table = 'doctor';
    protected $primaryKey = 'doctor_id';

    // ЭТОГО НЕ ХВАТАЛО: разрешаем запись полей
    protected $fillable = [
        'lastname',
        'firstname',
        'patronymic',
        'specialization'
    ];
}