<?php

namespace Controller;

use Src\View;
use Src\Request;
use Model\User;
use Model\Doctor; // Убедись, что модель Doctor создана в папке Model
use Src\Auth\Auth;

class Site
{
    // 1. Приветственная страница (index.php)
    public function index(): string
    {
        return new View('site.index');
    }

    // 2. Список врачей из БД (doctors.php)
    public function doctors(): string
    {
        // Получаем всех врачей из БД через модель
        $doctors = Doctor::all();
        // Передаем массив врачей в представление под ключом 'doctors'
        return (new View())->render('site.doctors', ['doctors' => $doctors]);
    }

    // 3. Форма записи на прием (appointment.php)
    public function appointment(Request $request): string
    {
        // Для выбора врача в форме нам все равно нужно их загрузить
        $doctors = Doctor::all();
        return new View('site.appointment', ['doctors' => $doctors]);
    }

    // Стандартная заглушка приветствия (из методички)
    public function hello(): string
    {
        return new View('site.hello', ['message' => 'Система управления поликлиникой']);
    }

    // Регистрация
    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            // Простая валидация: если данные заполнены
            if (User::create($request->all())) {
                // После успешной регистрации отправляем на вход
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
    }

    // Вход
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

    // Выход
    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

}