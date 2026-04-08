<div class="appointment-form-container">
    <h2>Записаться на прием</h2>
    <form method="post">
        <label>Выберите врача:</label>
        <select name="doctor_id" required>
            <?php foreach ($doctors as $doctor): ?>
                <option value="<?= $doctor->doctor_id ?>">
                    <?= $doctor->lastname ?> (<?= $doctor->specialization ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label>Дата и время:</label>
        <input type="datetime-local" name="appointment_datetime" required>

        <button type="submit">Подтвердить запись</button>
    </form>
</div>