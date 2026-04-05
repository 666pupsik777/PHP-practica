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
            <input type="text" name="specialization" required placeholder="Например: Терапевт">
        </div>
        <button type="submit" class="btn">Внести в базу</button>
    </form>
</div>