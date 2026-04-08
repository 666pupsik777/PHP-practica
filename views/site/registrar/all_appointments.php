<?php
// Вспомогательная функция для защиты от XSS
if (!function_exists('h')) {
    function h($text) {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}
?>
<div class="appointments-container" style="padding: 20px; font-family: sans-serif;">
    <h2 style="color: #2c3e50; border-bottom: 2px solid #27ae60; padding-bottom: 10px;">Все записи на прием</h2>

    <div style="margin-bottom: 20px;">
        <form method="get" action="<?= h(app()->route->getUrl('/registrar/appointments')) ?>" style="display: flex; gap: 15px; background: #f4f7f6; padding: 20px; border-radius: 10px; border: 1px solid #e0e0e0; align-items: flex-end;">

            <div style="display: flex; flex-direction: column; gap: 5px;">
                <label style="font-weight: bold; font-size: 14px;">Пациент:</label>
                <select name="patient_id" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="">Все пациенты</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?= h($patient->patient_id) ?>" <?= (($request->patient_id ?? '') == $patient->patient_id) ? 'selected' : '' ?>>
                            <?= h($patient->lastname . ' ' . $patient->firstname) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" style="background: #27ae60; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">Фильтровать</button>
        </form>
    </div>

    <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <thead>
        <tr style="background: #27ae60; color: white; text-align: left;">
            <th style="padding: 12px;">Дата и время</th>
            <th style="padding: 12px;">Пациент</th>
            <th style="padding: 12px;">Врач</th>
            <th style="padding: 12px;">Статус</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($appointments as $appointment): ?>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px;">
                    <strong><?= h(date('d.m.Y', strtotime($appointment->appointment_datetime))) ?></strong><br>
                    <span style="color: #666;"><?= h(date('H:i', strtotime($appointment->appointment_datetime))) ?></span>
                </td>
                <td style="padding: 12px;"><?= h($appointment->patient->lastname ?? '—') ?></td>
                <td style="padding: 12px;"><?= h($appointment->doctor->lastname ?? '—') ?></td>
                <td style="padding: 12px;">
                    <?php
                    $st = [1 => 'Активна', 2 => 'Выполнена', 3 => 'Отменена'];
                    echo h($st[$appointment->status_id] ?? 'Неизвестно');
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>