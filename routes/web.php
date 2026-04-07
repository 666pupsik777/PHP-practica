<?php

use Src\Route;
use Controller\Site;

Route::add('GET', '/', [Site::class, 'index']);
Route::add('GET', '/hello', [Site::class, 'hello'])->middleware('auth');
Route::add(['GET', 'POST'], '/login', [Site::class, 'login']);
Route::add('GET', '/logout', [Site::class, 'logout']);

// Регистратор
Route::add('GET', '/registrar/dashboard', [Site::class, 'registrar_dashboard'])->middleware('auth');
Route::add('GET', '/registrar/appointments', [Site::class, 'all_appointments'])->middleware('auth');
Route::add(['GET', 'POST'], '/registrar/create-patient', [Site::class, 'create_patient'])->middleware('auth');
Route::add(['GET', 'POST'], '/registrar/create-doctor', [Site::class, 'create_doctor'])->middleware('auth');
Route::add(['GET', 'POST'], '/registrar/create-appointment', [Site::class, 'registrar_create_appointment'])->middleware('auth');
Route::add('POST', '/registrar/appointment/cancel', [Site::class, 'cancel_appointment'])->middleware('auth');

// Админ
Route::add(['GET', 'POST'], '/admin/create-user', [Site::class, 'admin_create_user'])->middleware('auth');

// Пациент
Route::add('GET', '/doctors', [Site::class, 'doctors']);
Route::add('GET', '/profile', [Site::class, 'profile'])->middleware('auth');