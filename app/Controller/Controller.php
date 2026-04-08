<?php

namespace Controller;

use Src\View;

abstract class Controller
{
    public function __construct()
    {
        // Запускаем сессию, если она еще не запущена (нужно для токена)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Генерируем токен, если его нет
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        // Если кто-то прислал данные (POST), проверяем их на честность
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifyCsrf();
        }
    }

    private function verifyCsrf(): void
    {
        // Достаем токен из того, что прислал пользователь, и из сессии
        $postToken = $_POST['csrf_token'] ?? '';
        $sessionToken = $_SESSION['csrf_token'] ?? '';

        // Если они не совпадают — это атака
        if (!$postToken || !hash_equals($sessionToken, $postToken)) {
            header('HTTP/1.1 403 Forbidden');
            die("Ошибка безопасности: Неверный CSRF-токен! Запрос отклонен.");
        }
    }

    protected function render(string $view, array $data = []): string
    {
        // Твоя защита от XSS (очистка вывода)
        array_walk_recursive($data, function (&$item) {
            if (is_string($item)) {
                $item = htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
            }
        });

        return new View($view, $data);
    }
}