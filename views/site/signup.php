<h2>Регистрация в системе "Здоровье"</h2>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <div class="form-group">
        <label>Ваше ФИО</label>
        <input type="text" name="name" required>
    </div>
    <div class="form-group">
        <label>Логин</label>
        <input type="text" name="login" required>
    </div>
    <div class="form-group">
        <label>Пароль</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Зарегистрироваться как пациент</button>
</form>