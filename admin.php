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
	echo '<td><a href="removescore.php?id=' . $row['id'] . '&amp;score=' . $row['score'] . '&amp;screenshot=' . $row['screenshot'] . '">Удалить</a></td></tr>';
}

echo '</table>';

mysqli_close($dbc);