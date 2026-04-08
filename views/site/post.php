<?php
if (!function_exists('h')) {
    function h($text) {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}
?>
<h1>Список статей</h1>
<ol>
    <?php
    foreach ($posts as $post) {
        // Защищаем заголовок статьи функцией h()
        echo '<li>' . h($post->title) . '</li>';
    }
    ?>
</ol>