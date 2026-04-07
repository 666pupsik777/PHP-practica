<div class="appointments-container" style="padding: 20px;">
    <h2 style="color: #2c3e50; border-bottom: 2px solid #27ae60; padding-bottom: 10px;">Все записи на прием</h2>

    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden; margin-top: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
            <tr style="background: #27ae60; color: white;">
                <th style="padding: 12px; text-align: left;">Дата и время</th>
                <th style="padding: 12px; text-align: left;">Пациент</th>
                <th style="padding: 12px; text-align: left;">Врач</th>
                <th style="padding: 12px; text-align: left;">Статус</th>
                <th style="padding: 12px; text-align: left;">Действие</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;"><?= date('d.m.Y H:i', strtotime($appointment->appointment_datetime)) ?></td>

                    <td style="padding: 12px;">
                        <?php if ($appointment->patient): ?>
                            <?= htmlspecialchars($appointment->patient->lastname . ' ' . $appointment->patient->firstname) ?>
                        <?php else: ?>
                            <span style="color: red;">Пациент удален</span>
                        <?php endif; ?>
                    </td>

                    <td style="padding: 12px;">
                        <?= htmlspecialchars($appointment->doctor->lastname ?? 'Врач не назначен') ?>
                    </td>

                    <td style="padding: 12px;">
                        <?php
                        $st = [1 => 'Активна', 2 => 'Выполнена', 3 => 'Отменена'];
                        echo $st[$appointment->status_id] ?? '—';
                        ?>
                    </td>

                    <td style="padding: 12px;">
                        <?php if ($appointment->status_id == 1): ?>
                            <form method="POST" action="<?= app()->route->getUrl('/registrar/appointment/cancel') ?>">
                                <input type="hidden" name="appointment_id" value="<?= $appointment->appointment_id ?>">
                                <button type="submit" style="background:#e74c3c; color:white; border:none; padding:5px 10px; border-radius:4px; cursor:pointer;" onclick="return confirm('Отменить запись?')">Отменить</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>