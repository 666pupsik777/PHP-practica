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
                    <th>Дата и время</th>
                    <th>Пациент</th>
                    <th>Врач</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?= date('d.m.Y H:i', strtotime($appointment->appointment_datetime)) ?></td>

                        <td>
                            <?php if ($appointment->patient): ?>
                                <?= htmlspecialchars($appointment->patient->lastname . ' ' . $appointment->patient->firstname) ?>
                            <?php else: ?>
                                <span style="color: #999;">Не указан</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?= $appointment->doctor->lastname ?? '—' ?>
                        </td>

                        <td>
                            <?php
                            $statusNames = [1 => 'Активна', 2 => 'Выполнена', 3 => 'Отменена'];
                            echo $statusNames[$appointment->status_id] ?? 'Неизвестно';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="padding: 20px; text-align: center;">Записей не найдено.</p>
        <?php endif; ?>
    </div>
</div>

<style>
    .page-title { color: #2c3e50; border-bottom: 2px solid #27ae60; padding-bottom: 10px; margin-bottom: 20px; }
    .filter-section { background: #f4f7f6; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    .filter-form { display: flex; align-items: flex-end; gap: 15px; }
    .form-group { display: flex; flex-direction: column; gap: 5px; }
    .form-group select { padding: 8px; border-radius: 4px; border: 1px solid #ccc; min-width: 200px; }
    .btn-filter { background: #27ae60; color: white; border: none; padding: 9px 15px; border-radius: 4px; cursor: pointer; }
    .btn-reset { background: #95a5a6; color: white; text-decoration: none; padding: 9px 15px; border-radius: 4px; font-size: 14px; }
    .table-wrapper { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden; }
    .styled-table { width: 100%; border-collapse: collapse; }
    .styled-table th { background: #27ae60; color: white; padding: 12px; text-align: left; }
    .styled-table td { padding: 12px; border-bottom: 1px solid #eee; }
    .styled-table tr:hover { background: #f9f9f9; }
</style>