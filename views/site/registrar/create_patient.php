<div class="form-container">
    <h2>Регистрация нового пациента</h2>
    <form method="post">
        <div class="form-group">
            <label>Фамилия:</label>
            <input type="text" name="lastname" placeholder="Введите фамилию" required>
        </div>
        <div class="form-group">
            <label>Имя:</label>
            <input type="text" name="firstname" placeholder="Введите имя" required>
        </div>
        <div class="form-group">
            <label>Отчество:</label>
            <input type="text" name="patronymic" placeholder="Введите отчество">
        </div>
        <div class="form-group">
            <label>Дата рождения:</label>
            <input type="date" name="birth_date" required>
        </div>
        <button type="submit" class="btn">Добавить пациента</button>
    </form>
</div>

<style>
    .form-container { max-width: 500px; margin: 30px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #2c3e50; }
    .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
    .btn { width: 100%; background-color: #27ae60; color: white; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; }
    .btn:hover { background-color: #219150; }
</style>