<div class="registrar-container">
    <h2 class="page-title">Панель сотрудника регистратуры</h2>
    <p class="welcome-text">Добро пожаловать, <?= app()->auth::user()->name ?>! Выберите нужное действие:</p>

    <div class="dashboard-grid">
        <a href="<?= app()->route->getUrl('/registrar/appointments') ?>" class="dash-card">
            <div class="card-icon">📋</div>
            <h3>Все записи</h3>
            <p>Просмотр общего списка записей и поиск по конкретному пациенту.</p>
        </a>

        <a href="<?= app()->route->getUrl('/registrar/new-appointment') ?>" class="dash-card highlight-green">
            <div class="card-icon">📅</div>
            <h3>Записать на прием</h3>
            <p>Выбрать врача, пациента и назначить время визита.</p>
        </a>

        <a href="<?= app()->route->getUrl('/registrar/create-patient') ?>" class="dash-card">
            <div class="card-icon">👤+</div>
            <h3>Новый пациент</h3>
            <p>Регистрация нового пациента в базе данных системы.</p>
        </a>

        <a href="<?= app()->route->getUrl('/registrar/create-doctor') ?>" class="dash-card">
            <div class="card-icon">👨‍⚕️</div>
            <h3>Новый врач</h3>
            <p>Добавление нового специалиста в список врачей.</p>
        </a>

        <a href="<?= app()->route->getUrl('/registrar/patients-by-doctor') ?>" class="dash-card">
            <div class="card-icon">🩺</div>
            <h3>Записи к врачу</h3>
            <p>Список пациентов к врачу на выбранную дату.</p>
        </a>

        <a href="<?= app()->route->getUrl('/registrar/doctors-by-patient') ?>" class="dash-card">
            <div class="card-icon">🔍</div>
            <h3>Врачи пациента</h3>
            <p>История посещений конкретного пациента.</p>
        </a>
    </div>
</div>

<style>
    .registrar-container { max-width: 1100px; margin: 0 auto; padding: 20px; }
    .page-title { color: #2c3e50; border-bottom: 2px solid #27ae60; padding-bottom: 10px; }
    .welcome-text { margin-bottom: 30px; color: #7f8c8d; }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .dash-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid #eee;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .dash-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        border-color: #27ae60;
    }

    .highlight-green {
        border: 2px solid #27ae60;
        background: #f0fff4;
    }

    .card-icon { font-size: 40px; margin-bottom: 15px; }
    .dash-card h3 { margin: 10px 0; color: #2c3e50; }
    .dash-card p { font-size: 14px; color: #7f8c8d; margin: 0; }
</style>