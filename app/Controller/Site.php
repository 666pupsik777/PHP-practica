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
    // Вспомогательный метод для защиты маршрутов
    private function checkAccess(array $roles): void
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, $roles)) {
            app()->route->redirect('/hello?message=Недостаточно прав');
        }
    }

    public function index(): string
    {
        return new View('site.index');
    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'Система управления поликлиникой']);
    }

    // Регистрация пациента (самостоятельная)
    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            if (User::create($request->all())) {
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
    }

    // Вход в систему
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

    // Личный кабинет пациента
    public function profile(): string
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->user_id)->first();

        $appointments = [];
        if ($patient) {
            $appointments = Appointment::where('patient_id', $patient->patient_id)
                ->with('doctor')
                ->orderBy('appointment_datetime', 'desc')
                ->get();
        }

        return new View('site.profile', [
            'user' => $user,
            'patient' => $patient,
            'appointments' => $appointments
        ]);
    }

    // --- ФУНКЦИИ РЕГИСТРАТОРА И АДМИНА ---

    public function registrar_dashboard(): string
    {
        $this->checkAccess([1, 3]);
        return new View('site.registrar.dashboard');
    }

    // Список всех записей с фильтром
    public function all_appointments(Request $request): string
    {
        $this->checkAccess([1, 3]);
        $query = Appointment::with(['patient', 'doctor']);

        if ($request->patient_id) {
            $query->where('patient_id', $request->patient_id);
        }

        return new View('site.registrar.all_appointments', [
            'appointments' => $query->get(),
            'patients' => Patient::all()
        ]);
    }

    // Поиск пациентов к врачу на конкретную дату
    public function patients_by_doctor(Request $request): string
    {
        $this->checkAccess([1, 3]);
        $doctors = Doctor::all();
        $appointments = [];

        if ($request->doctor_id && $request->date) {
            $appointments = Appointment::where('doctor_id', $request->doctor_id)
                ->where('appointment_datetime', 'LIKE', $request->date . '%')
                ->with('patient')
                ->get();
        }

        return new View('site.registrar.filter_doctor', [
            'doctors' => $doctors,
            'appointments' => $appointments
        ]);
    }

    // Врачи, у которых был пациент
    public function doctors_by_patient(Request $request): string
    {
        $this->checkAccess([1, 3]);
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

    // Добавление пациента сотрудником
    public function create_patient(Request $request): string
    {
        $this->checkAccess([1, 3]);

        if ($request->method === 'POST') {
            // Создаем пользователя
            $user = User::create([
                'name' => $request->lastname . ' ' . $request->firstname . ' ' . $request->patronymic,
                'login' => $request->login,
                'password' => $request->password,
                'role_id' => 2
            ]);

            if ($user) {
                // Привязываем к таблице пациентов
                Patient::create([
                    'lastname' => $request->lastname,
                    'firstname' => $request->firstname,
                    'patronymic' => $request->patronymic,
                    'user_id' => $user->user_id
                ]);
                app()->route->redirect('/registrar/dashboard?message=Пациент успешно добавлен');
            }
        }
        return new View('site.registrar.create_patient');
    }

    // Добавление врача сотрудником/админом
    public function create_doctor(Request $request): string
    {
        $this->checkAccess([1, 3]);

        if ($request->method === 'POST') {
            $doctor = new Doctor();
            $doctor->lastname = $request->lastname;
            $doctor->firstname = $request->firstname;
            $doctor->patronymic = $request->patronymic ?? '';
            $doctor->specialization = $request->specialization;

            // ВНИМАНИЕ: Укажи здесь существующий ID из таблицы position
            // Если ты не знаешь какой, поставь 1 (обычно это первая запись)
            $doctor->position_id = 1;

            if ($doctor->save()) {
                app()->route->redirect('/registrar/dashboard?message=Врач успешно добавлен');
            }
        }
        return new View('site.registrar.create_doctor');
    }

    // Создание новой записи регистратором
    public function registrar_appointment(Request $request): string
    {
        $this->checkAccess([1, 3]);

        if ($request->method === 'POST') {
            // Статус 1 - Новая запись
            Appointment::create($request->all() + ['status_id' => 1]);
            app()->route->redirect('/registrar/appointments?message=Запись создана');
        }

        return new View('site.registrar.create_appointment', [
            'doctors' => Doctor::all(),
            'patients' => Patient::all()
        ]);
    }

    // Отмена записи (общий метод)
    public function cancel_appointment(Request $request): void
    {
        if ($request->method === 'POST' && $request->appointment_id) {
            $appointment = Appointment::find($request->appointment_id);
            if ($appointment) {
                $appointment->update(['status_id' => 3]); // 3 - Отменено
                $role = Auth::user()->role_id;
                $path = ($role == 1 || $role == 3) ? '/registrar/appointments' : '/profile';
                app()->route->redirect($path . '?message=Запись отменена');
            }
        }
    }

    // Для пациента: выбор врача и времени
    public function appointment(Request $request): string
    {
        if ($request->method === 'POST') {
            $patient = Patient::where('user_id', Auth::user()->user_id)->first();
            if ($patient) {
                Appointment::create($request->all() + [
                        'patient_id' => $patient->patient_id,
                        'status_id' => 1
                    ]);
                app()->route->redirect('/profile?message=Вы записаны');
            }
        }
        return new View('site.appointment', ['doctors' => Doctor::all()]);
    }

    public function doctors(): string
    {
        return new View('site.doctors', ['doctors' => Doctor::all()]);
    }

    // Метод для админа (создание регистраторов/админов)
    public function admin_create_user(Request $request): string
    {
        $this->checkAccess([1]);
        if ($request->method === 'POST') {
            if (User::create($request->all())) {
                app()->route->redirect('/registrar/dashboard?message=Сотрудник создан');
            }
        }
        return new View('site.admin_create_user');
    }
}