<div class="form-container">
    <h2>Регистрация нового сотрудника</h2>
    <p style="color: #666;">Текущий администратор: <?= app()->auth::user()->name ?></p>

    <form method="post">
        <div class="form-group">
            <label>ФИО сотрудника:</label>
            <input type="text" name="name" required placeholder="Введите полное имя">
        </div>

        <div class="form-group">
            <label>Логин для входа:</label>
            <input type="text" name="login" required>
        </div>

        <div class="form-group">
            <label>Временный пароль:</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Назначить роль:</label>
            <select name="role" required>
                <option value="3">Сотрудник регистратуры</option>
                <option value="1">Системный администратор</option>
                <option value="2">Пациент (тестовый)</option>
            </select>
        </div>

        <button type="submit" class="btn">Зарегистрировать в системе</button>
    </form>
</div>