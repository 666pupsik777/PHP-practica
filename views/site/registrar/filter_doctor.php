<div class="filter-page-container">
    <div class="header-section">
        <h2 class="title">Список пациентов по врачам</h2>
        <p class="subtitle">Выберите специалиста и дату для просмотра расписания</p>
    </div>

    <div class="filter-card">
        <form method="GET" action="<?= app()->route->getUrl('/registrar/patients-by-doctor') ?>" class="filter-form-row">

            <div class="field-group doctor-field">
                <label>Врач:</label>
                <select name="doctor_id" required>
                    <option value="">-- Выберите врача --</option>
                    <?php foreach ($doctors as $doctor): ?>
                        <option value="<?= $doctor->doctor_id ?>" <?= isset($_GET['doctor_id']) && $_GET['doctor_id'] == $doctor->doctor_id ? 'selected' : '' ?>>
                            <?php
                            $name = trim(($doctor->lastname ?? '') . ' ' . ($doctor->firstname ?? '') . ' ' . ($doctor->patronymic ?? ''));
                            echo htmlspecialchars($name) . " (" . htmlspecialchars($doctor->specialization) . ")";
                            ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="field-group date-field">
                <label>Дата приема:</label>
                <input type="date" name="date" required value="<?= $_GET['date'] ?? date('Y-m-d') ?>">
            </div>

            <div class="field-group button-field">
                <button type="submit" class="btn-primary">Показать список</button>
            </div>

        </form>
    </div>

    <?php if (isset($_GET['doctor_id'])): ?>
        <div class="results-section">
            <h3 class="results-title">Результаты поиска</h3>

            <?php if (!empty($appointments) && count($appointments) > 0): ?>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                        <tr>
                            <th>Время</th>
                            <th>ФИО Пациента</th>
                            <th>Статус</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($appointments as $app): ?>
                            <tr>
                                <td class="time-col"><?= date('H:i', strtotime($app->appointment_datetime)) ?></td>
                                <td class="name-col">
                                    <?php
                                    $p = $app->patient;
                                    echo htmlspecialchars(($p->lastname ?? '') . ' ' . ($p->firstname ?? '') . ' ' . ($p->patronymic ?? ''));
                                    ?>
                                </td>
                                <td><span class="status-tag">Записан</span></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="no-data-alert">
                    На выбранную дату записей не найдено.
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="page-footer">
        <a href="<?= app()->route->getUrl('/registrar/dashboard') ?>">← Вернуться в панель</a>
    </div>
</div>

<style>
    /* Основные настройки */
    .filter-page-container { max-width: 1100px; margin: 40px auto; padding: 0 20px; font-family: 'Segoe UI', Roboto, sans-serif; }
    .header-section { text-align: center; margin-bottom: 30px; }
    .title { color: #2d3436; font-size: 26px; margin-bottom: 8px; }
    .subtitle { color: #636e72; font-size: 15px; }

    /* Контейнер формы - выравнивание по одной линии */
    .filter-card {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #edf2f7;
    }

    .filter-form-row {
        display: flex;
        align-items: flex-end; /* Выравнивание по нижней линии */
        gap: 15px;
    }

    .field-group { display: flex; flex-direction: column; gap: 8px; }
    .field-group label { font-size: 13px; font-weight: 600; color: #4a5568; }

    /* Гибкая ширина для врача, чтобы ФИО влезало */
    .doctor-field { flex: 2; min-width: 300px; }
    .date-field { flex: 1; min-width: 180px; }
    .button-field { flex: 0.8; }

    /* Одинаковая высота для всех элементов управления */
    .filter-form-row select,
    .filter-form-row input,
    .filter-form-row .btn-primary {
        height: 48px; /* Жестко заданная высота */
        box-sizing: border-box;
        border-radius: 8px;
        font-size: 15px;
    }

    .filter-form-row select,
    .filter-form-row input {
        width: 100%;
        padding: 0 15px;
        border: 1.5px solid #cbd5e0;
        background-color: #fff;
    }

    .filter-form-row select:focus,
    .filter-form-row input:focus { border-color: #00b894; outline: none; }

    /* Кнопка */
    .btn-primary {
        width: 100%;
        background: #00b894;
        color: white;
        border: none;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-primary:hover { background: #00a383; }

    /* Таблица результатов */
    .results-section { margin-top: 40px; }
    .results-title { font-size: 18px; color: #2d3436; margin-bottom: 20px; padding-left: 10px; border-left: 4px solid #00b894; }

    .table-container { background: #fff; border-radius: 12px; border: 1px solid #edf2f7; overflow: hidden; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8fafc; padding: 15px; text-align: left; font-size: 12px; color: #718096; text-transform: uppercase; }
    .data-table td { padding: 15px; border-top: 1px solid #edf2f7; }

    .time-col { font-weight: bold; color: #00b894; }
    .name-col { color: #2d3436; font-weight: 500; }
    .status-tag { background: #defcf0; color: #00b894; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: bold; }

    .no-data-alert { text-align: center; padding: 30px; background: #fffaf0; border: 1px solid #feebc8; border-radius: 12px; color: #c05621; }
    .page-footer { text-align: center; margin-top: 30px; }
    .page-footer a { color: #a0aec0; text-decoration: none; font-size: 14px; }
</style>