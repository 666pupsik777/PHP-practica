<div class="profile-container">
    <h2>Личный кабинет пациента</h2>
    <div class="appointments-section">
        <h3>Мои записи на прием</h3>
        <table class="med-table">
            <thead>
            <tr>
                <th>Дата и время</th>
                <th>Врач</th>
                <th>Специализация</th>
                <th>Статус</th>
                <th>Действие</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($appointments as $app):
                $isCancelled = ($app->status_id == 3); // Проверка на статус "Отменено"
                ?>
                <tr style="<?= $isCancelled ? 'opacity: 0.5;' : '' ?>">
                    <td><?= date('d.m.Y H:i', strtotime($app->appointment_datetime)) ?></td>
                    <td><?= $app->doctor->lastname ?? '—' ?></td>
                    <td><?= $app->doctor->specialization ?? '—' ?></td>
                    <td>
                            <span class="status-badge" style="background: <?= $isCancelled ? '#fce4ec' : '#e8f5e9' ?>; color: <?= $isCancelled ? '#c2185b' : '#2e7d32' ?>;">
                                <?= $isCancelled ? 'Отменена' : 'Подтверждена' ?>
                            </span>
                    </td>
                    <td>
                        <?php if (!$isCancelled): ?>
                            <form method="post" action="<?= app()->route->getUrl('/cancel-appointment') ?>" style="margin:0;">
                                <input type="hidden" name="appointment_id" value="<?= $app->appointment_id ?>">
                                <button type="submit" class="btn-cancel" onclick="return confirm('Вы уверены, что хотите отменить запись?')">
                                    Отменить
                                </button>
                            </form>
                        <?php else: ?>
                            <span style="color: #999; font-size: 0.8em;">Недоступно</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>