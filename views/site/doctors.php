<?php
?>
<h2>Список наших специалистов</h2>

    <?php foreach ($doctors as $doctor): ?>
        <p><strong>ФИО:</strong>
            <?= $doctor->lastname ?>
            <?= $doctor->firstname ?>
            <?= $doctor->patronymic ?>
        </p>
        <p><strong>Специализация:</strong> <?= $doctor->specialization ?></p>
    <?php endforeach; ?>
