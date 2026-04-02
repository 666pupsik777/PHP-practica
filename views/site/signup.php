<h2>Регистрация пациента</h2>

<?php if (isset($message)): ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

<form method="post">
    <div class="form-group">
        <label>ФИО</label>
        <input type="text" name="name" placeholder="Введите полное имя" required>
    </div>
    <div class="form-group">
        <label>Логин</label>
        <input type="text" name="login" placeholder="Придумайте логин" required>
    </div>
    <div class="form-group">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль" required>
    </div>
    <button type="submit">Создать аккаунт</button>
</form>