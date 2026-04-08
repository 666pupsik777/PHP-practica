<?php

namespace Controller;

use Src\View;
use Illuminate\Validation\Factory;
use Illuminate\Translation\Translator;
use Illuminate\Translation\ArrayLoader;

abstract class Controller
{
    /**
     * Исправленный метод рендеринга с защитой XSS
     */
    protected function render(string $view, array $data = []): string
    {
        // Очистка данных от вредоносных скриптов (XSS защита)
        array_walk_recursive($data, function (&$item) {
            if (is_string($item)) {
                $item = htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
            }
        });

        // Возвращаем объект View.
        // Если твое ядро само вызывает метод render() при выводе строки,
        // то оставляем так. Если нет — добавим ->render() в конце.
        return new View($view, $data);
    }

    /**
     * Базовый метод проверки прав (защищенный)
     */
    protected function checkAccess(array $roles): void
    {
        if (!\Src\Auth\Auth::check() || !in_array(\Src\Auth\Auth::user()->role_id, $roles)) {
            app()->route->redirect('/hello?message=Недостаточно прав');
        }
    }
}