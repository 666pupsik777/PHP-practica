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
        if (Auth::check()) {
            app()->route->redirect('/profile');
        }

        if ($request->method === 'POST') {
            if (Auth::attempt($request->all())) {
                app()->route->redirect('/profile');
            } else {
                return new View('site.login', ['message' => 'Неправильный логин или пароль']);
            }
        }
        return new View('site.login');
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function profile(): string
    {
        $user = Auth::user();
        // Получаем записи текущего пользователя с врачами
        $appointments = Appointment::where('user_id', $user->user_id)
            ->with('doctor')
            ->get();

        return (new View())->render('site.profile', [
            'user' => $user,
            'appointments' => $appointments
        ]);
    }

    public function admin_create_user(Request $request): string
    {
        // Разрешаем доступ только Администратору (role_id = 1)
        if (app()->auth::user()->role_id !== 1) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        if ($request->method === 'POST') {
            if (\Model\User::create($request->all())) {
                app()->route->redirect('/profile?message=Пользователь успешно создан');
            }
        }

        return new View('site.admin_create_user');
    }

    public function doctors(): string
    {
        $doctors = Doctor::all();
        return (new View())->render('site.doctors', ['doctors' => $doctors]);
    }

    public function appointment(Request $request): string
    {
        $doctors = \Model\Doctor::all();

        if ($request->method === 'POST') {
            $data = $request->all();
            $user = app()->auth::user();

            // 1. Ищем пациента в таблице patient по его user_id
            $patient = \Model\Patient::where('user_id', $user->user_id)->first();

            // 2. Если записи о пациенте еще нет — создаем её
            if (!$patient) {
                $patient = \Model\Patient::create([
                    'lastname' => $user->name, // Берем ФИО из таблицы users
                    'firstname' => 'Имя',      // Заглушка (можно будет изменить в профиле)
                    'patronymic' => 'Отчество', // Заглушка
                    'user_id' => $user->user_id // Привязываем к текущему аккаунту
                ]);
            }

            // 3. Подготавливаем данные для таблицы записей (appointment)
            $appointmentData = [
                'doctor_id' => $data['doctor_id'],
                'appointment_datetime' => $data['appointment_datetime'],
                'user_id' => $user->user_id,
                'patient_id' => $patient->patient_id,
                'status_id' => 1 // Статус "Новая"
            ];

            if (\Model\Appointment::create($appointmentData)) {
                app()->route->redirect('/profile?message=Вы успешно записаны к врачу!');
            }
        }

        return new View('site.appointment', ['doctors' => $doctors]);
    }

    public function cancel_appointment(Request $request): void
    {
        if ($request->method === 'POST' && $request->appointment_id) {
            $appointment = Appointment::where('appointment_id', $request->appointment_id)
                ->where('user_id', Auth::user()->user_id)
                ->first();

            if ($appointment) {
                $appointment->update(['status_id' => 3]); // Статус "Отменено"
            }
        }
        app()->route->redirect('/profile');
    }
}