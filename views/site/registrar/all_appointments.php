<div class="appointments-container" style="padding: 20px; font-family: sans-serif;">
    <h2 style="color: #2c3e50; border-bottom: 2px solid #27ae60; padding-bottom: 10px;">Все записи на прием</h2>

    <div style="margin-bottom: 20px;">
        <form method="get" action="<?= app()->route->getUrl('/registrar/appointments') ?>" style="display: flex; gap: 15px; background: #f4f7f6; padding: 20px; border-radius: 10px; border: 1px solid #e0e0e0; align-items: flex-end;">

            <div style="display: flex; flex-direction: column; gap: 5px;">
                <label style="font-weight: bold; font-size: 14px;">Пациент:</label>
                <select name="patient_id" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="">Все пациенты</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?= $patient->patient_id ?>" <?= (($request->patient_id ?? '') == $patient->patient_id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($patient->lastname . ' ' . $patient->firstname) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display: flex; flex-direction: column; gap: 5px;">
                <label style="font-weight: bold; font-size: 14px;">Врач:</label>
                <select name="doctor_id" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="">Все врачи</option>
                    <?php foreach ($doctors as $doctor): ?>
                        <option value="<?= $doctor->doctor_id ?>" <?= (($request->doctor_id ?? '') == $doctor->doctor_id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($doctor->lastname) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display: flex; flex-direction: column; gap: 5px;">
                <label style="font-weight: bold; font-size: 14px;">Дата:</label>
                <input type="date" name="date" value="<?= htmlspecialchars($request->date ?? '') ?>" style="padding: 7px; border-radius: 4px; border: 1px solid #ccc;">
            </div>

            <button type="submit" style="background: #27ae60; color: white; border: none; padding: 9px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">Применить</button>
            <a href="<?= app()->route->getUrl('/registrar/appointments') ?>" style="background: #95a5a6; color: white; text-decoration: none; padding: 9px 15px; border-radius: 4px; font-size: 14px;">Сбросить</a>
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
                    <strong><?= date('d.m.Y', strtotime($appointment->appointment_datetime)) ?></strong><br>
                    <span style="color: #666;"><?= date('H:i', strtotime($appointment->appointment_datetime)) ?></span>
                </td>
                <td style="padding: 12px;"><?= htmlspecialchars($appointment->patient->lastname ?? '—') ?></td>
                <td style="padding: 12px;"><?= htmlspecialchars($appointment->doctor->lastname ?? '—') ?></td>
                <td style="padding: 12px;">
                    <?php
                    $st = [1 => 'Активна', 2 => 'Выполнена', 3 => 'Отменена'];
                    echo $st[$appointment->status_id] ?? '—';
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>