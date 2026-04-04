<div class="filter-page-container">
    <div class="header-section">
        <h2 class="title">Поиск врачей по пациенту</h2>
        <p class="subtitle">Выберите пациента, чтобы увидеть список специалистов, у которых он наблюдался</p>
    </div>

    <div class="filter-card">
        <form method="GET" action="<?= app()->route->getUrl('/registrar/filter-patient') ?>" class="filter-form-row">
            <div class="field-group patient-field">
                <label>Выберите пациента из базы:</label>
                <select name="patient_id" required>
                    <option value="">-- Выберите пациента --</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?= $patient->patient_id ?>" <?= isset($_GET['patient_id']) && $_GET['patient_id'] == $patient->patient_id ? 'selected' : '' ?>>
                            <?php
                            $pName = trim(($patient->lastname ?? '') . ' ' . ($patient->firstname ?? '') . ' ' . ($patient->patronymic ?? ''));
                            echo htmlspecialchars($pName ?: 'Имя не указано');
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

    <?php if (isset($_GET['patient_id'])): ?>
        <div class="results-section">
            <h3 class="results-title">Врачи, к которым есть записи:</h3>

            <?php if (!empty($doctors)): ?>
                <div class="doctors-grid">
                    <?php foreach ($doctors as $doctor): ?>
                        <div class="doctor-card">
                            <div class="doctor-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00b894" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.3.3 0 1 0 .2.3"></path>
                                    <path d="M8 15v1a6 6 0 0 0 6 6h2a6 6 0 0 0 6-6v-1"></path>
                                    <circle cx="16" cy="15" r="2"></circle>
                                </svg>
                            </div>
                            <div class="doctor-info">
                                <div class="doctor-name">
                                    <?php
                                    echo htmlspecialchars(($doctor->lastname ?? '') . ' ' . ($doctor->firstname ?? '') . ' ' . ($doctor->patronymic ?? ''));
                                    ?>
                                </div>
                                <div class="doctor-specialty">
                                    <?= htmlspecialchars($doctor->specialization ?? 'Специализация не указана') ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-data-alert">
                    У данного пациента пока нет записей к врачам в нашей базе.
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="page-footer">
        <a href="<?= app()->route->getUrl('/registrar/dashboard') ?>">← Назад в панель</a>
    </div>
</div>

<style>
    .filter-page-container { max-width: 900px; margin: 40px auto; padding: 0 20px; font-family: 'Segoe UI', sans-serif; }
    .header-section { text-align: center; margin-bottom: 30px; }
    .title { color: #2d3436; font-size: 26px; }
    .subtitle { color: #636e72; }

    .filter-card { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); margin-bottom: 40px; }
    .filter-form-row { display: flex; align-items: flex-end; gap: 15px; }

    .field-group { display: flex; flex-direction: column; gap: 8px; }
    .field-group label { font-size: 13px; font-weight: 600; color: #4a5568; }
    .patient-field { flex: 3; }
    .button-field { flex: 1; }

    .filter-form-row select, .btn-primary { height: 48px; border-radius: 8px; font-size: 15px; box-sizing: border-box; }
    .filter-form-row select { width: 100%; padding: 0 15px; border: 1.5px solid #cbd5e0; }

    .btn-primary { background: #00b894; color: white; border: none; font-weight: bold; cursor: pointer; transition: 0.2s; width: 100%; }
    .btn-primary:hover { background: #00a383; }

    .results-title { font-size: 18px; color: #2d3436; margin-bottom: 20px; }

    .doctors-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px; }

    .doctor-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        transition: transform 0.2s;
    }
    .doctor-card:hover { transform: translateY(-3px); box-shadow: 0 6px 15px rgba(0,0,0,0.05); }

    .doctor-icon { background: #e3fcef; padding: 12px; border-radius: 10px; margin-right: 15px; }
    .doctor-name { font-weight: bold; color: #2d3436; font-size: 16px; margin-bottom: 2px; }
    .doctor-specialty { color: #00b894; font-size: 14px; font-weight: 500; }

    .no-data-alert { text-align: center; padding: 30px; background: #f8fafc; border-radius: 12px; color: #636e72; }
    .page-footer { text-align: center; margin-top: 30px; }
    .page-footer a { color: #a0aec0; text-decoration: none; font-size: 14px; }
</style>