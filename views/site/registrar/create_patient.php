<div class="form-container">
    <h2>Регистрация нового пациента</h2>
    <form method="post">
        <div class="form-group">
            <label>Фамилия:</label>
            <input type="text" name="lastname" required>
        </div>
        <div class="form-group">
            <label>Имя:</label>
            <input type="text" name="firstname" required>
        </div>
        <div class="form-group">
            <label>Отчество:</label>
            <input type="text" name="patronymic">
        </div>

        <div class="form-group">
            <label>Дата рождения:</label>
            <input type="date" name="birth_date" required>
        </div>

        <button type="submit" class="btn">Добавить пациента</button>
    </form>
</div>