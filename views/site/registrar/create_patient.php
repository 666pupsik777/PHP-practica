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
        <hr>
        <div class="form-group">
            <label>Логин для входа (ЛК):</label>
            <input type="text" name="login" required>
        </div>
        <div class="form-group">
            <label>Пароль:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn">Добавить пациента</button>
    </form>
</div>