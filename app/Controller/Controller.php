<?php

namespace Controller;

use Illuminate\Validation\Factory;
use Illuminate\Translation\Translator;
use Illuminate\Translation\ArrayLoader;
use View\View;

abstract class Controller
{
    // Твои существующие методы (например, checkAccess) должны быть здесь...

    /**
     * Метод для валидации данных
     */
    protected function validate($data, $rules, $messages = [])
    {
        // 1. Создаем загрузчик сообщений (опционально на русском)
        $loader = new ArrayLoader();
        $loader->addMessages('ru', 'validation', [
            'required' => 'Поле :attribute обязательно для заполнения',
            'date' => 'Поле :attribute должно быть корректной датой',
            'min' => 'Поле :attribute должно быть не короче :min символов',
            'string' => 'Поле :attribute должно быть строкой',
        ]);

        // 2. Настраиваем транслятор и фабрику валидации
        $translator = new Translator($loader, 'ru');
        $factory = new Factory($translator);

        // 3. Создаем сам валидатор
        $validator = $factory->make($data, $rules, $messages);

        // 4. Если проверка провалена
        if ($validator->fails()) {
            // В учебных целях выводим ошибки и останавливаем работу
            // В реальных проектах здесь делают редирект обратно с ошибками
            dd($validator->errors()->all());
        }

        // 5. Возвращаем только проверенные данные
        return $validator->validated();
    }
}