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
    private function checkAccess(array $roles): void
    {
        if (!Auth::check() || !in_array(Auth::user()->role_id, $roles)) {
            app()->route->redirect('/hello?message=Недостаточно прав');
        }
    }

    public function index(): string { return new View('site.index'); }
    public function hello(): string { return new View('site.hello', ['message' => 'Система управления поликлиникой']); }

    public function login(Request $request): string
    {
        if (Auth::check()) $this->redirectAfterLogin();
        if ($request->method === 'POST') {
            if (Auth::attempt($request->all())) $this->redirectAfterLogin();
        }
        return new View('site.login');
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
    public function admin_create_user(Request $request): string
    {
        $this->checkAccess([1]);
        if ($request->method === 'POST') {
            if (User::create($request->all())) app()->route->redirect('/hello?message=Сотрудник добавлен');
        }
        return new View('site.admin.create_user');
    }

    /* РЕГИСТРАТОР */
    public function registrar_dashboard(): string { $this->checkAccess([3]); return new View('site.registrar.dashboard'); }

    public function create_patient(Request $request): string
    {
        $this->checkAccess([3]);
        if ($request->method === 'POST') {
            if (Patient::create($request->all())) app()->route->redirect('/registrar/dashboard?message=Пациент добавлен');
        }
        return new View('site.registrar.create_patient');
    }

    public function create_doctor(Request $request): string
    {
        $this->checkAccess([3]);
        if ($request->method === 'POST') {
            if (Doctor::create($request->all())) {
                app()->route->redirect('/registrar/dashboard?message=Врач успешно добавлен');
            }
        }
        return new View('site.registrar.create_doctor', [
            'positions' => Position::all(),
            'specializations' => ['Терапевт', 'Хирург', 'Офтальмолог', 'Невролог', 'Стоматолог', 'Кардиолог']
        ]);
    }

    public function registrar_create_appointment(Request $request): string
    {
        $this->checkAccess([3]);
        if ($request->method === 'POST') {
            $data = $request->all();
            $data['status_id'] = 1;
            if (Appointment::create($data)) app()->route->redirect('/registrar/appointments?message=Запись создана');
        }
        return new View('site.registrar.create_appointment', ['doctors' => Doctor::all(), 'patients' => Patient::all()]);
    }

    public function all_appointments(Request $request): string
    {
        $this->checkAccess([3]);
        $query = Appointment::with(['patient', 'doctor']);
        if ($request->patient_id) $query->where('patient_id', $request->patient_id);
        return new View('site.registrar.all_appointments', ['appointments' => $query->get(), 'patients' => Patient::all()]);
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