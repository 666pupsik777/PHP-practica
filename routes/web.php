<?php

use Src\Route;

Route::add('GET', '/', [Controller\Site::class, 'index']);
Route::add('GET', '/hello', [Controller\Site::class, 'hello'])->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

// Пациент
Route::add('GET', '/doctors', [Controller\Site::class, 'doctors']);
Route::add(['GET', 'POST'], '/appointment', [Controller\Site::class, 'appointment'])->middleware('auth');
Route::add('GET', '/profile', [Controller\Site::class, 'profile'])->middleware('auth');
Route::add('POST', '/cancel-appointment', [Controller\Site::class, 'cancel_appointment'])->middleware('auth');

// Админ (Создание сотрудников)
Route::add(['GET', 'POST'], '/admin/create-user', [Controller\Site::class, 'admin_create_user'])->middleware('auth');

// Регистратор (Управление и фильтры)
Route::add('GET', '/registrar/dashboard', [Controller\Site::class, 'registrar_dashboard'])->middleware('auth');
Route::add('GET', '/registrar/appointments', [Controller\Site::class, 'all_appointments'])->middleware('auth');
Route::add('GET', '/registrar/patients-by-doctor', [Controller\Site::class, 'patients_by_doctor'])->middleware('auth');
Route::add('GET', '/registrar/doctors-by-patient', [Controller\Site::class, 'doctors_by_patient'])->middleware('auth');