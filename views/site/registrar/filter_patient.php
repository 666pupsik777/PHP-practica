<?php
if (!function_exists('h')) {
    function h($text) {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}
?>
<div class="filter-page-container">
    <div class="header-section">
        <h2 class="title">Поиск врачей по пациенту</h2>
        <p class="subtitle">Выберите пациента, чтобы увидеть список специалистов</p>
    </div>

    <div class="filter-card">
        <form method="GET" action="<?= h(app()->route->getUrl('/registrar/filter-patient')) ?>" class="filter-form-row">
            <div class="field-group patient-field">
                <label>Выберите пациента из базы:</label>
                <select name="patient_id" required>
                    <option value="">-- Выберите пациента --</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?= h($patient->patient_id) ?>" <?= isset($_GET['patient_id']) && $_GET['patient_id'] == $patient->patient_id ? 'selected' : '' ?>>
                            <?php
                            $pName = trim(($patient->lastname ?? '') . ' ' . ($patient->firstname ?? '') . ' ' . ($patient->patronymic ?? ''));
                            echo h($pName ?: 'Имя не указано');
                            ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="field-group button-field">
                <button type="submit" class="btn-primary">Найти врачей</button>
            </div>
        </form>
    </div>

    <?php if (isset($doctors_list)): ?>
        <div class="results-section">
            <h3 class="results-title">Врачи, у которых наблюдался пациент:</h3>
            <div class="doctors-grid">
                <?php foreach ($doctors_list as $doc): ?>
                    <div class="doctor-card">
                        <div class="doc-info">
                            <h4 style="margin:0;"><?= h($doc->lastname) ?> <?= h($doc->firstname) ?></h4>
                            <p style="color: #666; margin: 5px 0 0;"><?= h($doc->specialization) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($doctors_list)): ?>
                    <p>У данного пациента еще нет завершенных или активных записей.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>