<?php
if (!function_exists('h')) {
    function h($text) {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}
?>
<div class="form-container">
    <h2>Регистрация нового сотрудника</h2>
    <p style="color: #666;">Текущий администратор: <?= h(app()->auth::user()->name) ?></p>

    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
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
            <label>Роль в системе:</label>
            <select name="role_id">
                <option value="1">Администратор</option>
                <option value="3">Сотрудник регистратуры</option>
            </select>
        </div>
        <button type="submit" class="btn">Зарегистрировать в системе</button>
    </form>
</div>