<?php
echo "<h2>Диагностика сайта</h2>";

// 1. Проверка PHP
echo "<h3>1. PHP работает: ✓</h3>";
echo "Версия PHP: " . phpversion() . "<br>";

// 2. Проверка wp-config
if (file_exists('wp-config.php')) {
    require_once('wp-config.php');
    echo "<h3>2. wp-config.php найден: ✓</h3>";
    echo "База: " . DB_NAME . "<br>";
    echo "Пользователь: " . DB_USER . "<br>";
} else {
    echo "<h3>2. wp-config.php НЕ НАЙДЕН: ✗</h3>";
    exit;
}

// 3. Проверка подключения к базе
$link = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($link) {
    echo "<h3>3. Подключение к базе: ✓</h3>";
    
    // 4. Проверка таблиц WordPress
    $result = mysqli_query($link, "SHOW TABLES LIKE 'wp_%'");
    $tables = mysqli_num_rows($result);
    
    if ($tables > 0) {
        echo "<h3>4. Таблицы WordPress: ✓ ($tables таблиц)</h3>";
        
        // 5. Проверка настроек URL
        $result = mysqli_query($link, "SELECT option_name, option_value FROM wp_options WHERE option_name IN ('siteurl', 'home') LIMIT 2");
        
        if (mysqli_num_rows($result) > 0) {
            echo "<h3>5. Настройки URL:</h3>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo $row['option_name'] . ": " . $row['option_value'] . "<br>";
            }
            
            // 6. Проверка темы
            $result = mysqli_query($link, "SELECT option_value FROM wp_options WHERE option_name = 'template' LIMIT 1");
            if ($result && $row = mysqli_fetch_assoc($result)) {
                echo "<h3>6. Активная тема: " . $row['option_value'] . "</h3>";
                
                if (is_dir('wp-content/themes/' . $row['option_value'])) {
                    echo "Папка темы существует: ✓<br>";
                } else {
                    echo "Папка темы НЕ СУЩЕСТВУЕТ: ✗<br>";
                }
            }
            
        } else {
            echo "<h3>5. Настройки URL: ✗ (не найдены)</h3>";
        }
        
    } else {
        echo "<h3>4. Таблицы WordPress: ✗ (база пустая)</h3>";
    }
    
    mysqli_close($link);
} else {
    echo "<h3>3. Подключение к базе: ✗</h3>";
    echo "Ошибка: " . mysqli_connect_error();
}

echo "<br><hr>";
echo "<a href='wp-admin/'>Админка</a> | ";
echo "<a href='./'>Главная</a>";
?>