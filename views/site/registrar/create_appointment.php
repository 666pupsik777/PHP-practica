<div class="form-container">
    <h2>Записать пациента на прием</h2>
    <form method="post">
        <div class="form-group">
            <label>Пациент:</label>
            <select name="patient_id" required>
                <?php foreach ($patients as $p): ?>
                    <option value="<?= $p->patient_id ?>"><?= $p->lastname ?> <?= $p->firstname ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Врач:</label>
            <select name="doctor_id" required>
                <?php foreach ($doctors as $d): ?>
                    <option value="<?= $d->doctor_id ?>"><?= $d->lastname ?> (<?= $d->specialization ?>)</option>
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