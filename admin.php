<?php
//Имя пользователя и пароль для аутентификации
$username = 'rock';
$password = 'roll';

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
	($_SERVER['PHP_AUTH_USER'] != $username) || 
	($_SERVER['PHP_AUTH_PW'] != $password)) {
	//Имя пользователя/пароль не действительны для отправки HTTP-заголовков,
	//подтверждающих аутентификацию
	header('HTTP/1.1 401 Unauthorized');
	header('WWW-Authenticate:Basic realm="Гитарные войны"');
	exit ('<h2>Гитарные войны <h2>Извините, вы должны ввести правильные имя пользователя и пароль, чтобы получить доступ к этой странице.');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Гитарные войны. Панель администратора</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h2>Гитарные войны. Панель администратора</h2>

<?php
require_once('appvars.php');
require_once('connectvars.php');

//Соединение с БД
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

//Извлечение данных из БД
$query = "SELECT * FROM guitarwars ORDER BY score DESC, date ASC";
$data = mysqli_query($dbc, $query);

//Извлечение данных из массива в цикле
//Формирование данных записей в виде кода HTML
echo '<table>';
while ($row = mysqli_fetch_array($data)) {
	//Вывод данных
	echo '<tr class="scorerow"><td><strong>' . $row['name'] . '</strong><td>';
	echo '<td>' . $row['date'] . '</td>';
	echo '<td>' . $row['score'] . '</td>';
	echo '<td><a href="removescore.php?id=' . $row['id'] . '&amp;date=' . $row['date'] . '&amp;name=' . $row['name'] . '&amp;score=' . $row['score'] . '&amp;screenshot=' . $row['screenshot'] . '">Удалить</a></td></tr>';
}

echo '</table>';

mysqli_close($dbc);