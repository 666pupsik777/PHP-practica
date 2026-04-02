<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctor';
    public $timestamps = false; // так как в твоей БД нет полей created_at/updated_at
}