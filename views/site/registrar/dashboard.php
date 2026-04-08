<?php
if (!function_exists('h')) {
    function h($text) {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}
?>
<div class="registrar-container">
    <h2 class="page-title">Панель сотрудника регистратуры</h2>
    <p class="welcome-text">Добро пожаловать, <?= h(app()->auth::user()->name) ?>!</p>

    <div class="dashboard-grid">
        <a href="<?= h(app()->route->getUrl('/registrar/appointments')) ?>" class="dash-card">
            <div class="card-icon">📋</div>
            <h3>Все записи</h3>
            <p>Просмотр списка и фильтрация</p>
        </a>

        <a href="<?= h(app()->route->getUrl('/registrar/create-patient')) ?>" class="dash-card">
            <div class="card-icon">👤</div>
            <h3>Новый пациент</h3>
            <p>Регистрация пациента в базе</p>
        </a>

        <a href="<?= h(app()->route->getUrl('/registrar/create-doctor')) ?>" class="dash-card">
            <div class="card-icon">👨‍⚕️</div>
            <h3>Новый врач</h3>
            <p>Добавление врача в систему</p>
        </a>

        <a href="<?= h(app()->route->getUrl('/registrar/create-appointment')) ?>" class="dash-card">
            <div class="card-icon">📅</div>
            <h3>Записать на прием</h3>
            <p>Выбор времени и специалиста</p>
        </a>
    </div>
</div>
<style>
    .registrar-container { max-width: 1100px; margin: 0 auto; padding: 20px; }
    .page-title { color: #2c3e50; border-bottom: 2px solid #27ae60; padding-bottom: 10px; }
    .welcome-text { margin-bottom: 30px; color: #7f8c8d; }
    .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
    .dash-card {
        background: white; padding: 25px; border-radius: 12px; text-decoration: none; color: inherit;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.2s; border: 1px solid #eee;
        display: flex; flex-direction: column; align-items: center; text-align: center;
    }
    .dash-card:hover { transform: translateY(-5px); box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
    .card-icon { font-size: 40px; margin-bottom: 15px; }
    .dash-card h3 { margin: 0 0 10px 0; color: #2c3e50; }
    .dash-card p { margin: 0; color: #7f8c8d; font-size: 14px; }
</style>