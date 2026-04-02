<?php

namespace Controller;

use Src\View;
use Src\Request;
use Model\User;
use Model\Doctor;
use Model\Appointment;
use Src\Auth\Auth;

class Site
{
    public function index(): string
    {
        return new View('site.index');
    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'Система управления поликлиникой']);
    }

    // Вывод списка врачей
    public function doctors(): string
    {
        $doctors = Doctor::all();
        return (new View())->render('site.doctors', ['doctors' => $doctors]);
    }

    // Запись на прием
    public function appointment(Request $request): string
    {
        $doctors = Doctor::all();

        if ($request->method === 'POST') {
            $data = $request->all();

            // 1. Берем ID текущего пользователя
            $currentUserId = app()->auth::user()->id;

            // 2. Наполняем массив данными, которые требует БД
            $data['user_id'] = $currentUserId;
            $data['patient_id'] = $currentUserId;
            $data['status_id'] = 1; // Убедись, что в табл. status есть ID 1

            // 3. Пытаемся создать запись
            if (Appointment::create($data)) {
                return app()->route->redirect('/hello?message=Запись успешно создана');
            }
        }

        return (new View())->render('site.appointment', ['doctors' => $doctors]);
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            if (User::create($request->all())) {
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
    }

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function profile(): string
    {
        $user = app()->auth::user();

        // Загружаем записи ТЕКУЩЕГО пользователя вместе с данными их врачей
        $appointments = \Model\Appointment::where('user_id', $user->id)
            ->with('doctor')
            ->get();

        return (new View())->render('site.profile', [
            'user' => $user,
            'appointments' => $appointments
        ]);
    }

    // Добавь в класс Site
    public function cancel_appointment(Request $request): void
    {
        // Проверяем, пришел ли ID записи
        if ($request->method === 'POST' && $request->appointment_id) {
            $appointment = \Model\Appointment::where('appointment_id', $request->appointment_id)
                ->where('user_id', app()->auth::user()->id) // Защита: отменить можно только свою запись
                ->first();

            if ($appointment) {
                $appointment->update(['status_id' => 3]); // Ставим ID статуса "Отменено"
            }
        }
        // Возвращаемся обратно в профиль
        app()->route->redirect('/profile');
    }

}