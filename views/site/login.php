<h2>Вход в систему</h2>

<?php if (isset($message)): ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

<?php if (!app()->auth::check()): ?>
    <form method="post">
        <div class="form-group">
            <label>Логин</label>
            <input type="text" name="login" value="<?= $request['login'] ?? '' ?>">        </div>
        <div class="form-group">
            <label>Пароль</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Войти</button>
    </form>
<?php else: ?>
    <div class="message">Вы уже авторизованы как <?= app()->auth->user()->name ?></div>
<?php endif; ?>