<?php
if (!function_exists('h')) {
    function h($text) {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}
?>
    <h2>Список наших специалистов</h2>
<?php foreach ($doctors as $doctor): ?>
    <p><strong>ФИО:</strong>
        <?= h($doctor->lastname) ?>
        <?= h($doctor->firstname) ?>
        <?= h($doctor->patronymic) ?>
    </p>
    <p><strong>Специализация:</strong> <?= h($doctor->specialization) ?></p>
<?php endforeach; ?>