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


  // Connect to the database 
  $dbc = mysqli_connect('localhost', 'root', '', 'gwdb');

  // Извлечение данных их базы 
  $query = "SELECT * FROM guitarwars";
  $data = mysqli_query($dbc, $query);

  // Извлечение данных из массива в цикле. Форматирование в виде кода HTML 
  echo '<table>';
  while ($row = mysqli_fetch_array($data)) { 
    // Display the score data
    echo '<tr><td class="scoreinfo">';
    echo '<span class="score">' . $row['score'] . '</span><br />';
    echo '<strong>Name:</strong> ' . $row['name'] . '<br />';
    echo '<strong>Date:</strong> ' . $row['date'] . '</td></tr>';
  }
  echo '</table>';

  mysqli_close($dbc);

  //phpinfo();
?>
