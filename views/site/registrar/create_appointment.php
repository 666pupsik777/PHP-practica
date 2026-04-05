<div class="form-container">
    <h2>Записать пациента на прием</h2>
    <form method="post">
        <div class="form-group">
            <label>Выберите пациента:</label>
            <select name="patient_id" required>
                <?php foreach ($patients as $p): ?>
                    <option value="<?= $p->patient_id ?>">
                        <?= htmlspecialchars($p->lastname . ' ' . $p->firstname . ' ' . $p->patronymic) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Выберите врача:</label>
            <select name="doctor_id" required>
                <?php foreach ($doctors as $d): ?>
                    <option value="<?= $d->doctor_id ?>">
                        <?= htmlspecialchars($d->lastname . ' ' . $d->firstname) ?> (<?= $d->specialization ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Дата и время приема:</label>
            <input type="datetime-local" name="appointment_datetime" required>
        </div>

        <button type="submit" class="btn">Записать</button>
    </form>
</div>