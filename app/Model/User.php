<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    public $timestamps = false;
    protected $table = 'users';
    // КРИТИЧНО: указываем, что первичный ключ не 'id', а 'user_id'
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'login',
        'password',
        'role_id',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->password = md5($user->password);

            // Если роль передана из формы (как у админа), оставляем её.
            // Если роли нет (обычная регистрация), ставим 2 (пациент).
            if (empty($user->role_id)) {
                $user->role_id = 2;
            }
        });
    }

    public function findIdentity(int $id)
    {
        // Здесь $id передается из сессии, ищем по user_id
        return self::where('user_id', $id)->first();
    }

    public function getId(): int
    {
        return $this->user_id;
    }

    public function attemptIdentity(array $credentials)
    {
        return self::where([
            'login' => $credentials['login'],
            'password' => md5($credentials['password'])
        ])->first();
    }
}