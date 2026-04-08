<?php
return [
    //Класс аутентификации
    'auth' => \Src\Auth\Auth::class,

    //Класс пользователя
    'identity' => \Model\User::class,

    //Классы для middleware
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
    ], // <-- ВОТ ЗДЕСЬ НУЖНА БЫЛА ЗАПЯТАЯ

    //Твои новые валидаторы из методички
    'validators' => [
        'required' => \Validators\RequireValidator::class,
        'unique' => \Validators\UniqueValidator::class,
    ],
];