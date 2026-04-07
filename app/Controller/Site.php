<?php

namespace Controller;

use Src\View;
use Src\Request;
use Model\User;
use Model\Doctor;
use Model\Patient;
use Model\Appointment;
use Model\Position;
use Src\Auth\Auth;

class Site
{
    /**
     * Проверка прав доступа.
     */
    private function checkAccess(array $roles): void
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, $roles)) {
            app()->route->redirect('/hello?message=Недостаточно прав');
        }
    }

    /**
     * Логика перенаправления после входа.
     */
    private function redirectAfterLogin(): void
    {
        $role = Auth::user()->role_id;
        if ($role === 1) {
            app()->route->redirect('/hello');
        } elseif ($role === 3) {
            app()->route->redirect('/registrar/dashboard');
        } else {
            app()->route->redirect('/profile');
        }
    }

    public function index(): string { return new View('site.index'); }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'Система управления поликлиникой']);
    }

    public function login(Request $request): string
    {
        if (Auth::check()) { $this->redirectAfterLogin(); }
        if ($request->method === 'POST') {
            if (Auth::attempt($request->all())) { $this->redirectAfterLogin(); }
            return new View('site.login', ['message' => 'Неправильный логин или пароль']);
        }
        return new View('site.login');
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            if (User::create($request->all())) { app()->route->redirect('/login'); }
        }
        return new View('site.signup');
    }

    public function doctors(): string
    {
        return new View('site.doctors', ['doctors' => Doctor::all()]);
    }

    // --- ПАЦИЕНТ ---
    public function profile(): string
    {
        $this->checkAccess([2]);
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->user_id)->first();
        $appointments = $patient ? Appointment::where('patient_id', $patient->patient_id)->with('doctor')->get() : [];
        return new View('site.profile', ['user' => $user, 'patient' => $patient, 'appointments' => $appointments]);
    }

    public function appointment(Request $request): string
    {
        $this->checkAccess([2]);
        if ($request->method === 'POST') {
            $patient = Patient::where('user_id', Auth::user()->user_id)->first();
            if ($patient) {
                $data = $request->all();
                $data['patient_id'] = $patient->patient_id;
                $data['status_id'] = 1;
                if (Appointment::create($data)) { app()->route->redirect('/profile?message=Запись создана'); }
            }
        }
        return new View('site.appointment', ['doctors' => Doctor::all()]);
    }

    // --- АДМИНИСТРАТОР ---
    public function admin_create_user(Request $request): string
    {
        $this->checkAccess([1]);
        if ($request->method === 'POST') {
            if (User::create($request->all())) {
                app()->route->redirect('/hello?message=Сотрудник добавлен');
            }
        }
        return new View('site.admin_create_user');
    }

    // --- РЕГИСТРАТОР ---

    public function registrar_dashboard(): string
    {
        $this->checkAccess([3]);
        return new View('site.registrar.dashboard');
    }

    // Создание врача (регистратор вписывает специализацию руками)
    public function create_doctor(Request $request): string
    {
        $this->checkAccess([3]); // Только для регистратора

        if ($request->method === 'POST') {
            // Просто сохраняем всё, что пришло из формы (там уже есть скрытый position_id = 1)
            if (Doctor::create($request->all())) {
                app()->route->redirect('/registrar/dashboard?message=Врач успешно добавлен');
            }
        }

        return new View('site.registrar.create_doctor');
    }

    public function create_patient(Request $request): string
    {
        $this->checkAccess([3]);
        if ($request->method === 'POST') {
            if (Patient::create($request->all())) {
                app()->route->redirect('/registrar/dashboard?message=Пациент добавлен');
            }
        }
        return new View('site.registrar.create_patient');
    }

    public function registrar_create_appointment(Request $request): string
    {
        $this->checkAccess([3]);
        if ($request->method === 'POST') {
            $data = $request->all();
            $data['status_id'] = 1;
            if (Appointment::create($data)) {
                app()->route->redirect('/registrar/appointments?message=Запись создана');
            }
        }
        return new View('site.registrar.create_appointment', [
            'doctors' => Doctor::all(),
            'patients' => Patient::all()
        ]);
    }

    public function all_appointments(Request $request): string
    {
        $this->checkAccess([3]);
        $query = Appointment::with(['patient', 'doctor']);
        if ($request->patient_id) {
            $query->where('patient_id', $request->patient_id);
        }
        return new View('site.registrar.all_appointments', [
            'appointments' => $query->get(),
            'patients' => Patient::all()
        ]);
    }
}