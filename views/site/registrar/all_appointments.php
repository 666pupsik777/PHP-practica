<div class="appointments-container">
    <h2 class="page-title">Все записи на прием</h2>

    <div class="filter-section">
        <form method="GET" action="<?= app()->route->getUrl('/registrar/appointments') ?>" class="filter-form">
            <div class="form-group">
                <label for="patient_id">Поиск по пациенту:</label>
                <select name="patient_id" id="patient_id">
                    <option value="">-- Все пациенты --</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?= $patient->patient_id ?>" <?= isset($_GET['patient_id']) && $_GET['patient_id'] == $patient->patient_id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($patient->lastname . ' ' . $patient->firstname) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn-filter">Применить фильтр</button>
            <a href="<?= app()->route->getUrl('/registrar/appointments') ?>" class="btn-reset">Сбросить</a>
        </form>
    </div>

    <div class="table-wrapper">
        <?php if (count($appointments) > 0): ?>
            <table class="styled-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Дата и время</th>
                    <th>Пациент</th>
                    <th>Врач</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($appointments as $app): ?>
                    <tr>
                        <td><?= $app->appointment_id ?></td>
                        <td><?= date('d.m.Y H:i', strtotime($app->appointment_datetime)) ?></td>
                        <td>
                            <strong><?= htmlspecialchars($app->patient->lastname ?? 'Не указан') ?></strong><br>
                            <small><?= htmlspecialchars($app->patient->firstname ?? '') ?></small>
                        </td>
                        <td><?= htmlspecialchars($app->doctor->name ?? 'Врач удален') ?></td>
                        <td>
                            <?php if ($app->status_id == 1): ?>
                                <span class="status-new">Новая</span>
                            <?php elseif ($app->status_id == 3): ?>
                                <span class="status-cancelled">Отменена</span>
                            <?php else: ?>
                                <span class="status-default">Подтверждена</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <p>Записей не найдено.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="back-link">
        <a href="<?= app()->route->getUrl('/registrar/dashboard') ?>">← Вернуться в панель</a>
    </div>
</div>

<style>
    .appointments-container { max-width: 1100px; margin: 20px auto; padding: 20px; font-family: sans-serif; }
    .page-title { color: #2c3e50; border-bottom: 2px solid #27ae60; padding-bottom: 10px; margin-bottom: 20px; }

    /* Стили фильтра */
    .filter-section { background: #f4f7f6; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    .filter-form { display: flex; align-items: flex-end; gap: 15px; }
    .form-group { display: flex; flex-direction: column; gap: 5px; }
    .form-group select { padding: 8px; border-radius: 4px; border: 1px solid #ccc; min-width: 200px; }

    .btn-filter { background: #27ae60; color: white; border: none; padding: 9px 15px; border-radius: 4px; cursor: pointer; }
    .btn-reset { background: #95a5a6; color: white; text-decoration: none; padding: 9px 15px; border-radius: 4px; font-size: 14px; }

    /* Таблица */
    .table-wrapper { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden; }
    .styled-table { width: 100%; border-collapse: collapse; text-align: left; }
    .styled-table th { background-color: #27ae60; color: white; padding: 12px 15px; }
    .styled-table td { padding: 12px 15px; border-bottom: 1px solid #eee; }
    .styled-table tbody tr:hover { background-color: #f1f1f1; }

    /* Статусы */
    .status-new { color: #2980b9; font-weight: bold; }
    .status-cancelled { color: #e74c3c; font-weight: bold; }
    .status-default { color: #27ae60; }

    .back-link { margin-top: 20px; }
    .back-link a { color: #34495e; text-decoration: none; font-weight: bold; }
</style>