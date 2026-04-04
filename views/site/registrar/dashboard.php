<div class="registrar-container">
    <h2 class="page-title">Панель сотрудника регистратуры</h2>
    <p class="welcome-text">Добро пожаловать, <?= app()->auth::user()->name ?>! Выберите нужное действие:</p>

    <div class="dashboard-grid">
        <a href="<?= app()->route->getUrl('/registrar/appointments') ?>" class="dash-card">
            <div class="card-icon">📋</div>
            <h3>Все записи</h3>
            <p>Просмотр общего списка записей и поиск по конкретному пациенту.</p>
        </a>

        <a href="<?= app()->route->getUrl('/registrar/patients-by-doctor') ?>" class="dash-card">
            <div class="card-icon">👨‍⚕️</div>
            <h3>Записи к врачу</h3>
            <p>Список пациентов, записанных к определенному врачу на выбранную дату.</p>
        </a>

        <a href="<?= app()->route->getUrl('/registrar/doctors-by-patient') ?>" class="dash-card">
            <div class="card-icon">🔍</div>
            <h3>Врачи пациента</h3>
            <p>Узнать, к каким специалистам записан конкретный пациент.</p>
        </a>

        <a href="<?= app()->route->getUrl('/admin/create-user') ?>" class="dash-card highlight">
            <div class="card-icon">👤</div>
            <h3>Новый сотрудник/врач</h3>
            <p>Добавление новых пользователей в систему (врачей или коллег).</p>
        </a>
    </div>
</div>

<style>
    .registrar-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
    }
    .page-title {
        color: #2c3e50;
        border-bottom: 2px solid #27ae60;
        padding-bottom: 10px;
    }
    .welcome-text {
        margin-bottom: 30px;
        color: #7f8c8d;
    }
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
        box-shadow: 0 8px 15px rgba(0,0,0,0.15);
        border-color: #27ae60;
    }
    .card-icon {
        font-size: 40px;
        margin-bottom: 15px;
    }
    .dash-card h3 {
        margin: 10px 0;
        color: #27ae60;
    }
    .dash-card p {
        font-size: 0.9em;
        color: #636e72;
    }
    .dash-card.highlight {
        background: #f9f9f9;
        border-left: 5px solid #e67e22;
    }
</style>