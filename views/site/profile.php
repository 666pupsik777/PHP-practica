<div class="profile-container">
    <h2>Личный кабинет пациента</h2>

    <div class="user-card">
        <h3>Данные профиля</h3>
        <p><strong>Имя:</strong> <?= $user->name ?></p>
        <p><strong>Логин:</strong> <?= $user->login ?></p>
    </div>

    <div class="appointments-section">
        <h3>Мои записи на прием</h3>
        <table class="med-table">
            <thead>
            <tr>
                <th>Дата и время</th>
                <th>Имя Врача</th>
                <th>Специализация</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($appointments as $app): ?>
                <tr>
                    <td><?= date('d.m.Y H:i', strtotime($app->appointment_datetime)) ?></td>

                    <td>
                        <?= $app->doctor->lastname ?? 'Врач не найден' ?>
                        <?= $app->doctor->firstname ?? '' ?>
                    </td>

                    <td><?= $app->doctor->specialization ?? '—' ?></td>

                    <td><span class="status-badge">Подтверждена</span></td>
                </tr>
            <?php endforeach; ?>

            <?php if (count($appointments) === 0): ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px; color: #7f8c8d;">
                        У вас пока нет активных записей.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>