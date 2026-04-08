<?php
if (!function_exists('h')) {
    function h($text) {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}
?>
<div class="filter-page-container">
    <div class="header-section">
        <h2 class="title">Список пациентов по врачам</h2>
        <p class="subtitle">Выберите специалиста и дату для просмотра расписания</p>
    </div>

    <div class="filter-card">
        <form method="GET" action="<?= h(app()->route->getUrl('/registrar/patients-by-doctor')) ?>" class="filter-form-row">
            <div class="field-group doctor-field">
                <label>Врач:</label>
                <select name="doctor_id" required>
                    <option value="">-- Выберите врача --</option>
                    <?php foreach ($doctors as $doctor): ?>
                        <option value="<?= h($doctor->doctor_id) ?>" <?= isset($_GET['doctor_id']) && $_GET['doctor_id'] == $doctor->doctor_id ? 'selected' : '' ?>>
                            <?php
                            $name = trim(($doctor->lastname ?? '') . ' ' . ($doctor->firstname ?? '') . ' ' . ($doctor->patronymic ?? ''));
                            echo h($name) . " (" . h($doctor->specialization) . ")";
                            ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="field-group date-field">
                <label>Дата приема:</label>
                <input type="date" name="date" required value="<?= h($_GET['date'] ?? date('Y-m-d')) ?>">
            </div>

            <div class="field-group button-field">
                <button type="submit" class="btn-primary">Показать расписание</button>
            </div>
        </form>
    </div>

    <?php if (isset($appointments)): ?>
        <div class="results-section">
            <h3 class="results-title">Результаты поиска</h3>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                    <tr>
                        <th>Время</th>
                        <th>Пациент</th>
                        <th>Дата рождения</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($appointments) > 0): ?>
                        <?php foreach ($appointments as $app): ?>
                            <tr>
                                <td><strong><?= h(date('H:i', strtotime($app->appointment_datetime))) ?></strong></td>
                                <td><?= h(($app->patient->lastname ?? '') . ' ' . ($app->patient->firstname ?? '')) ?></td>
                                <td><?= h($app->patient->birth_date ?? '—') ?></td>
                                <td><?= h($app->status_id == 3 ? 'Отменена' : 'Активна') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" style="text-align: center; padding: 30px;">На выбранную дату записей не найдено.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>