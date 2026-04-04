<?php

namespace Controller;

use Src\View;
use Src\Request;
use Model\User;
use Model\Doctor;
use Model\Patient;
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

    // Регистрация пациента
    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            if (User::create($request->all())) {
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
    }

    // Вход
    public function login(Request $request): string
    {
        if (Auth::check()) {
            app()->route->redirect('/profile');
        }

        if ($request->method === 'POST') {
            if (Auth::attempt($request->all())) {
                app()->route->redirect('/profile');
            }
            return new View('site.login', ['message' => 'Неправильный логин или пароль']);
        }
        return new View('site.login');
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    // Список врачей
    public function doctors(): string
    {
        $doctors = Doctor::all();
        return new View('site.doctors', ['doctors' => $doctors]);
    }

    // Личный кабинет пациента
    public function profile(): string
    {
        $user = app()->auth::user();
        $patient = Patient::where('user_id', $user->user_id)->first();

        $appointments = [];
        if ($patient) {
            $appointments = Appointment::where('patient_id', $patient->patient_id)
                ->with('doctor')
                ->get();
        }

        return new View('site.profile', [
            'user' => $user,
            'appointments' => $appointments
        ]);
    }

    // Запись на прием
    public function appointment(Request $request): string
    {
        $doctors = Doctor::all();
        if ($request->method === 'POST') {
            $user = app()->auth::user();

            // Находим или создаем пациента, привязанного к юзеру
            $patient = Patient::firstOrCreate(
                ['user_id' => $user->user_id],
                [
                    'lastname' => $user->name,
                    'firstname' => 'Имя',
                    'patronymic' => 'Отчество'
                ]
            );

            $data = $request->all();
            $data['user_id'] = $user->user_id;
            $data['patient_id'] = $patient->patient_id;
            $data['status_id'] = 1;

            if (Appointment::create($data)) {
                app()->route->redirect('/profile?message=Вы успешно записаны');
            }
        }
        return new View('site.appointment', ['doctors' => $doctors]);
    }

    // Отмена записи
    public function cancel_appointment(Request $request): void
    {
        if ($request->method === 'POST' && $request->appointment_id) {
            $appointment = Appointment::where('appointment_id', $request->appointment_id)->first();
            if ($appointment) {
                $appointment->update(['status_id' => 3]); // 3 - Отменено
            }
        }
        app()->route->redirect('/profile');
    }

    /* --- АДМИНИСТРАТОР --- */

    public function admin_create_user(Request $request): string
    {
        if (app()->auth::user()->role_id !== 1) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        if ($request->method === 'POST') {
            if (User::create($request->all())) {
                app()->route->redirect('/profile?message=Сотрудник создан');
            }
        }
        return new View('site.admin_create_user');
    }

    /* --- РЕГИСТРАТОР --- */

    public function registrar_dashboard(): string
    {
        // Доступ для админа (1) и регистратора (3)
        if (!in_array(app()->auth::user()->role_id, [1, 3])) {
            app()->route->redirect('/hello?message=Нет доступа');
        }
        return new View('site.registrar.dashboard');
    }

    // 1. Все записи / По пациенту
    public function all_appointments(Request $request): string
    {
        if (!in_array(app()->auth::user()->role_id, [1, 3])) {
            app()->route->redirect('/hello?message=Нет доступа');
        }

        $query = Appointment::with(['doctor', 'patient']);
        if ($request->patient_id) {
            $query->where('patient_id', $request->patient_id);
        }

        return new View('site.registrar.all_appointments', [
            'appointments' => $query->get(),
            'patients' => Patient::all()
        ]);
    }

    // 2. Пациенты к врачу на дату
    public function patients_by_doctor(Request $request): string
    {
        $doctors = \Model\Doctor::all();
        $appointments = [];

        // Проверяем, пришли ли данные из формы
        if ($request->doctor_id && $request->date) {
            $appointments = \Model\Appointment::where('doctor_id', $request->doctor_id)
                ->where('appointment_datetime', 'LIKE', $request->date . '%')
                ->with('patient')
                ->get();
        }

        return new View('site.registrar.filter_doctor', [
            'doctors' => $doctors,
            'appointments' => $appointments
        ]);
    }

    // 3. Врачи конкретного пациента
    public function doctors_by_patient(Request $request): string
    {
        if (!in_array(app()->auth::user()->role_id, [1, 3])) {
            app()->route->redirect('/hello?message=Нет доступа');
        }

        $doctors = [];
        if ($request->patient_id) {
            $doctorIds = Appointment::where('patient_id', $request->patient_id)
                ->pluck('doctor_id')
                ->unique();
            $doctors = Doctor::whereIn('doctor_id', $doctorIds)->get();
        }

        return new View('site.registrar.filter_patient', [
            'patients' => Patient::all(),
            'doctors' => $doctors
        ]);
    }
}