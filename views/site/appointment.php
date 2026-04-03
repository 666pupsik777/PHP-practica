<div class="appointment-form-container">
    <h2>Записаться на прием</h2>
    <form method="post">
        <div class="form-group">
            <label>Выберите врача:</label>
            <select name="doctor_id" required>
                <option value="">-- Выберите врача --</option>
                <?php foreach ($doctors as $doctor): ?>
                    <option value="<?= $doctor->doctor_id ?>">
                        <?= $doctor->lastname ?> <?= $doctor->firstname ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Дата и время:</label>
            <input type="datetime-local" name="appointment_datetime" required>
        </div>


        <button type="submit" class="btn">Подтвердить запись</button>
    </form>
</div>