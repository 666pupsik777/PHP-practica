<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поликлиника</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<header>
    <div class="logo">Поликлиника</div>
    <nav>
        <a href="<?= app()->route->getUrl('/hello') ?>">Главная</a>
        <a href="<?= app()->route->getUrl('/doctors') ?>">Наши врачи</a>

        <?php if (!app()->auth::check()): ?>
            <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
            <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
        <?php else: ?>
            <a href="<?= app()->route->getUrl('/appointment') ?>">Записаться</a>
            <a href="<?= app()->route->getUrl('/profile') ?>">Профиль</a>

            <?php if (app()->auth::user()->role_id === 3): ?>
                <a href="<?= app()->route->getUrl('/registrar/dashboard') ?>"
                   style="color: #27ae60; font-weight: bold;">
                    Панель управления
                </a>
            <?php endif; ?>

            <?php if (app()->auth::user()->role_id === 1): ?>
                <a href="<?= app()->route->getUrl('/registrar/dashboard') ?>">Админ-панель</a>
            <?php endif; ?>

            <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->name ?>)</a>
        <?php endif; ?>
    </nav>
</header>

<main>
    <?php if (isset($_GET['message'])): ?>
        <div class="message" style="background: #e8f5e9; padding: 10px; border: 1px solid #27ae60; margin-bottom: 20px;">
            <?= htmlspecialchars($_GET['message']) ?>
        </div>
    <?php endif; ?>

    <?= $content ?>
</main>

</body>
</html>