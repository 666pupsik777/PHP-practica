<?php

namespace Controller;

use Src\View;
use Src\Request;
use Model\User;
use Model\Doctor;
use Model\Patient;
use Model\Appointment;
use Src\Auth\Auth;
use Src\Validator\Validator;

class Site extends Controller
{
    protected function checkAccess(array $roles): void
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, $roles)) {
            app()->route->redirect('/hello?message=Недостаточно прав');
        }
    }

    public function index(): string
    {
        return $this->render('site.index');
    }

    public function login(Request $request): string
    {
        if (Auth::check()) {
            $this->redirectAfterLogin();
        }

        if ($request->method === 'POST') {
            if (Auth::attempt($request->all())) {
                $this->redirectAfterLogin();
            }
            // Если вход не удался, передаем всё, что ввел пользователь, обратно в форму
            return $this->render('site.login', ['request' => $request->all()]);
        }

        return $this->render('site.login');
    }

    private function redirectAfterLogin(): void
    {
        $role = Auth::user()->role_id;
        if ($role === 1) app()->route->redirect('/hello');
        elseif ($role === 3) app()->route->redirect('/registrar/dashboard');
        else app()->route->redirect('/profile');
    }

    public function logout(): void { Auth::logout(); app()->route->redirect('/hello'); }

    /* АДМИН */
    // Регистрация обычного пациента (самостоятельная)
    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);

            if($validator->fails()){
                return new View('site.signup',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (User::create($request->all())) {
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
    }

// Регистрация сотрудника АДМИНИСТРАТОРОМ
    public function admin_create_user(Request $request): string
    {
        $this->checkAccess([1]); // Проверка на админа
        if ($request->method === 'POST') {
            if (User::create($request->all())) {
                app()->route->redirect('/hello?message=Сотрудник успешно добавлен');
            }
        }
        return new View('site.admin_create_user');
    }

    /* РЕГИСТРАТОР */
    public function appointment(Request $request): string
    {
        $this->checkAccess([2]); // Только для роли "Пациент"

        if ($request->method === 'POST') {
            $data = $request->all();

            // 1. Исправляем формат даты (убираем T)
            if (!empty($data['appointment_datetime'])) {
                $data['appointment_datetime'] = str_replace('T', ' ', $data['appointment_datetime']);
            }

            // 2. Находим ID пациента, привязанного к текущему пользователю
            $patient = Patient::where('user_id', Auth::user()->user_id)->first();

            if (!$patient) {
                app()->route->redirect('/hello?message=Ошибка: профиль пациента не найден');
            }

            $data['patient_id'] = $patient->patient_id;
            $data['status_id'] = 1; // Активна
            $data['user_id'] = Auth::user()->user_id;

            if (Appointment::create($data)) {
                app()->route->redirect('/profile?message=Вы успешно записаны');
            }
        }

        return new View('site.appointment', ['doctors' => Doctor::all()]);
    }
    public function registrar_dashboard(): string { $this->checkAccess([3]); return new View('site.registrar.dashboard'); }

// Регистрация пациента РЕГИСТРАТОРОМ
    public function create_patient(Request $request): string
    {
        $this->checkAccess([3]);

        if ($request->method === 'POST') {
            if (Patient::create($request->all())) {
                app()->route->redirect('/registrar/dashboard?message=Пациент успешно добавлен');
            }
        }

        // Добавляем (string), чтобы точно вернуть строку
        return new View('site.registrar.create_patient');    }


    // Регистрация врача РЕГИСТРАТОРОМ
    public function create_doctor(Request $request): string
    {
        $this->checkAccess([3]); // Доступ для регистратора

        if ($request->method === 'POST') {
            $data = $request->all();

            // Устанавливаем ID должности по умолчанию (например, 1)
            $data['position_id'] = 1;

            if (Doctor::create($data)) {
                app()->route->redirect('/registrar/dashboard?message=Врач успешно добавлен');
            }
        }

        return new View('site.registrar.create_doctor');
    }

    public function registrar_create_appointment(Request $request): string
    {
        $this->checkAccess([3]); // Только регистратор

        if ($request->method === 'POST') {
            $data = $request->all();

            // 1. Убираем букву 'T' из даты, чтобы MySQL не ругался
            if (!empty($data['appointment_datetime'])) {
                $data['appointment_datetime'] = str_replace('T', ' ', $data['appointment_datetime']);
            }

            // 2. Устанавливаем статус "Активна" (обычно 1)
            $data['status_id'] = 1;

            // 3. Добавляем ID сотрудника, который создает запись (если нужно для БД)
            $data['user_id'] = Auth::user()->user_id;

            // 4. Пытаемся создать запись
            if (Appointment::create($data)) {
                app()->route->redirect('/registrar/appointments?message=Запись успешно создана');
            }
        }

        return new View('site.registrar.create_appointment', [
            'doctors' => Doctor::all(),
            'patients' => Patient::all()
        ]);
    }
    public function all_appointments(Request $request): string
    {
        $this->checkAccess([3]); // Доступ только для регистратора

        $query = \Model\Appointment::query();

        // 1. Фильтр по пациенту
        if ($request->patient_id) {
            $query->where('patient_id', $request->patient_id);
        }

        // 2. Фильтр по врачу
        if ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        // 3. Фильтр по дате (хитрая магия для поля datetime)
        if ($request->date) {
            $query->whereRaw('DATE(appointment_datetime) = ?', [$request->date]);
        }

        // Загружаем данные вместе со связями (врачи и пациенты)
        $appointments = $query->with(['patient', 'doctor'])->get();

        return new View('site.registrar.all_appointments', [
            'appointments' => $appointments,
            'patients' => \Model\Patient::all(),
            'doctors' => \Model\Doctor::all(),
            'request' => $request // Передаем сам запрос обратно для меток в форме
        ]);
    }

    public function cancel_appointment(Request $request): void
    {
        $this->checkAccess([3]);
        if ($request->method === 'POST' && $request->appointment_id) {
            $appointment = Appointment::find($request->appointment_id);
            if ($appointment) { $appointment->status_id = 3; $appointment->save(); }
        }
        app()->route->redirect('/registrar/appointments?message=Запись отменена');
    }

    /* ПАЦИЕНТ */
    public function profile(): string
    {
        $this->checkAccess([2]);
        return new View('site.profile', ['appointments' => Appointment::where('patient_id', Auth::user()->id)->get()]);
    }

    public function doctors(): string { return new View('site.doctors', ['doctors' => Doctor::all()]); }



}