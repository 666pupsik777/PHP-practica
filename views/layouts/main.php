<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поликлиника "Здоровье"</title>
    <link rel="stylesheet" href="/../css/style.css">
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

            <?php if (app()->auth::user()->role === 'registrar'): ?>
                <a href="<?= app()->route->getUrl('/admin/create-user') ?>"
                   style="color: #e67e22; border: 1px solid #e67e22; padding: 5px 10px; border-radius: 5px;">
                    + Регистратор
                </a>
            <?php endif; ?>

            <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->name ?>)</a>
        <?php endif; ?>
    </nav>
</header>

<main>
    <?php if (isset($_GET['message'])): ?>
        <div class="message" style="background: #e8f5e9; color: #2e7d32; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
            <?= htmlspecialchars($_GET['message']) ?>
        </div>
    <?php endif; ?>

    <?= $content ?? '' ?>
</main>
</body>
</html>