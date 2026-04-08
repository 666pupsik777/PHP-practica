<?php
if (!function_exists('h')) {
    function h($text) {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}
?>
<div class="appointment-form-container">
    <h2>Записаться на прием</h2>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <label>Выберите врача:</label>
        <select name="doctor_id" required>
            <?php foreach ($doctors as $doctor): ?>
                <option value="<?= h($doctor->doctor_id) ?>">
                    <?= h($doctor->lastname) ?> (<?= h($doctor->specialization) ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label>Дата и время:</label>
        <input type="datetime-local" name="appointment_datetime" required>

        <button type="submit">Подтвердить запись</button>
    </form>
</div>