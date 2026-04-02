<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    public $timestamps = false;
    protected $table = 'users'; // Указываем таблицу из БД
    protected $fillable = [
        'name',
        'login',
        'password'
    ];

    // Хэширование пароля перед сохранением
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->password = md5($user->password);
        });
    }

    // Поиск пользователя по id
    public function findIdentity(int $id)
    {
        return self::where('id', $id)->first();
    }

    // Возвращает id пользователя
    public function getId(): int
    {
        return $this->id;
    }

    // Проверка пароля при входе
    public function attemptIdentity(array $credentials)
    {
        return self::where(['login' => $credentials['login'],
            'password' => md5($credentials['password'])])
            ->first();
    }
}