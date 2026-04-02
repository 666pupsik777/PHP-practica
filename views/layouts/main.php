<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Поликлиника "Здоровье"</title>
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
            <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->name ?>)</a>
        <?php endif; ?>
    </nav>
</header>

<main>
    <?= $content ?? '' ?>
</main>

</body>
</html>