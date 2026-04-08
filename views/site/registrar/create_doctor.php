<div class="form-container">
    <h2>Добавление нового врача</h2>
    <form method="post">
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
    .form-group label {
        display: block;
        font-weight: bold;
    }

    .form-group input {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>