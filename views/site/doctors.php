<?php
// views/site/doctors.php
?>
<h2>Список наших специалистов</h2>
<ul>
    <?php foreach ($doctors as $doctor): ?>
        <li><?= $doctor->name ?></li>
    <?php endforeach; ?>
</ul>