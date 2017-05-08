<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Guitar Wars - High Scores</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h2>Guitar Wars - High Scores</h2>
  <p>Добро пожаловать, гитарный воин! Твой рейтинг бьет рекорды? Если да, то <a href="addscore.php">добавь себя в наш рейтинг</a>.</p>
  <hr />

<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

//Поключаем конфигурационные файлы
require_once('connectvars.php');
require_once('appvars.php');

// //Инициализация константы, содержащей имя каталога для загружаемых файлов изображений
// define('GW_UPLOADPATH', 'images/');

// Connect to the database 
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Извлечение данных их базы 
$query = "SELECT * FROM guitarwars ORDER BY score DESC, date ASC";
$data = mysqli_query($dbc, $query);

// Извлечение данных из массива в цикле. Форматирование в виде кода HTML 
echo '<table>';
$i = 0;
while ($row = mysqli_fetch_array($data)) { 
    //Самый большой рейтинг выделяем
    if ( $i == 0) {
        echo '<tr><th class="topscoreheader">' . 'Наивысший рейтинг: ' . $row['score'] . '</th></tr>';
        $i++;
    }


    // Выводим рейтинговую таблицу
    echo '<tr><td class="scoreinfo">';
    echo '<span class="score">' . $row['score'] . '</span><br />';
    echo '<strong>Имя:</strong> ' . $row['name'] . '<br />';
    echo '<strong>Дата:</strong> ' . $row['date'] . '</td></tr>';
    if (is_file(GW_UPLOADPATH . $row['screenshot']) && filesize(GW_UPLOADPATH . $row['screenshot']) > 0) {
        echo '<td><img src="' . GW_UPLOADPATH . $row['screenshot'] . '" alt="Подтверждено" /></td></tr>';
    }
    else {
        echo '<td><img src="' . GW_UPLOADPATH . 'unverified.gif' . '" alt="Не подтверждено" /></td></tr>';
    }

}
echo '</table>';

mysqli_close($dbc);

//phpinfo(32);
?>
