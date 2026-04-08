<?php
if (!function_exists('h')) {
    function h($text) {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}
?>
<div class="form-container">
    <h2>Добавление нового врача</h2>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

        <div class="form-group">
            <label>Фамилия:</label>
            <input type="text" name="lastname" required>
        </div>
        <div class="form-group">
            <label>Имя:</label>
            <input type="text" name="firstname" required>
        </div>
        <div class="form-group">
            <label>Отчество:</label>
            <input type="text" name="patronymic">
        </div>
        <div class="form-group">
            <label>Специализация:</label>
            <input type="text" name="specialization" required>
        </div>
        <div class="form-group">
            <label>Дата рождения:</label>
            <input type="date" name="birth_date" required>
        </div>
        <button type="submit" class="btn">Добавить врача</button>
    </form>
</div>
<style>
    .form-group label { display: block; font-weight: bold; }
    .form-group input { width: 100%; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; padding: 8px; margin-top: 5px; }
    .form-container { max-width: 500px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .btn { background: #27ae60; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; margin-top: 10px; }
</style>