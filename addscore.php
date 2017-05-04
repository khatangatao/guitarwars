<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Guitar Wars - Add Your High Score</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h2>Guitar Wars - Введи свой результат</h2>

<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

//Поключаем конфигурационные файлы
require_once('connectvars.php');
require_once('appvars.php');

// //Инициализация константы, содержащей имя каталога для загружаемых файлов изображений
// define('GW_UPLOADPATH', 'images/');



if (isset($_POST['submit'])) {
    // Grab the score data from the POST
    $name = $_POST['name'];
    $score = $_POST['score'];
    $screenshot = $_FILES['screenshot']['name'];

    if (!empty($name) && !empty($score) && !empty($screenshot)) {
        $target = GW_UPLOADPATH . $screenshot;
        if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
            // Соденинение с БД
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            // Формирование запроса в БД
            $query = "INSERT INTO guitarwars VALUES (0, NOW(), '$name', '$score', '$screenshot')";

            //выполнение запроса в БД
            mysqli_query($dbc, $query);

            // Подтверждаем успешный ввод данных
            echo '<p>Спасибо за добавление твоего нового достижения!</p>';
            echo '<p><strong>Имя:</strong> ' . $name . '<br />';
            echo '<strong>Рейтинг:</strong> ' . $score . '<br />';
            echo '<img src="' . GW_UPLOADPATH . $screenshot . '" alt="Изображение подтверждающее рейтинг" /></p>';
            echo '<br>';          
            echo '<p><a href="index.php">&lt;&lt; Назад к списку рейтингов</a></p>';

            // Очистка полей формы
            $name = "";
            $score = "";

            mysqli_close($dbc);
        } else {
            echo '<p class="error">Ошибка перемещения файла.</p>';
        }

    } else {
      echo '<p class="error">Пожалуйста введите недостающую информацию</p>';
    }

  //phpinfo(32); 
}
?>

  <hr />
  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  	<input type="hidden" name="MAX_FILE_SIZE" value="32768" />
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php if (!empty($name)) echo $name; ?>" /><br />
    <label for="score">Score:</label>
    <input type="text" id="score" name="score" value="<?php if (!empty($score)) echo $score; ?>" /><br />
    <input type="file" id="screenshot" name="screenshot" />

    <hr />
    <input type="submit" value="Add" name="submit" />
<!--     <img src="unverified.gif">
    <img src="images/phizsscore.gif"> -->
  </form>
</body> 
</html>