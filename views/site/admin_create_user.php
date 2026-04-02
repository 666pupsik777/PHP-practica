<div class="form-container">
    <h2>Регистрация нового пользователя (Админ)</h2>
    <form method="post">
        <div class="form-group">
            <label>ФИО пользователя:</label>
            <input type="text" name="name" required placeholder="Иванов Иван Иванович">
        </div>

        <div class="form-group">
            <label>Логин:</label>
            <input type="text" name="login" required>
        </div>

        <div class="form-group">
            <label>Пароль:</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Роль в системе:</label>
            <select name="role">
                <option value="0">Пациент</option>
                <option value="1">Администратор</option>
            </select>
        </div>

        <button type="submit" class="btn">Создать аккаунт</button>
    </form>
</div>