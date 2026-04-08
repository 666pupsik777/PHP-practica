<?php
if (!function_exists('h')) {
    function h($text) {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}
?>
<div class="form-container">
    <h2>Записать пациента на прием</h2>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

        <div class="form-group">
            <label>Пациент:</label>
            <select name="patient_id" required>
                <?php foreach ($patients as $p): ?>
                    <option value="<?= h($p->patient_id) ?>">
                        <?= h($p->lastname) ?> <?= h($p->firstname) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Врач:</label>
            <select name="doctor_id" required>
                <?php foreach ($doctors as $d): ?>
                    <option value="<?= h($d->doctor_id) ?>">
                        <?= h($d->lastname) ?> (<?= h($d->specialization) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Дата и время:</label>
            <input type="datetime-local" name="appointment_datetime" required>
        </div>
        <button type="submit" class="btn">Создать запись</button>
    </form>
</div>