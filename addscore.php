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



  if (isset($_POST['submit'])) {
    // Grab the score data from the POST
    $name = $_POST['name'];
    $score = $_POST['score'];

    if (!empty($name) && !empty($score)) {
      // Connect to the database
      $dbc = mysqli_connect('localhost', 'root', '', 'gwdb');

      // Write the data to the database
      $query = "INSERT INTO guitarwars VALUES (0, NOW(), '$name', '$score')";
      mysqli_query($dbc, $query);

      // Confirm success with the user
      echo '<p>Спасибо за добавление твоего нового достижения!</p>';
      echo '<p><strong>Имя:</strong> ' . $name . '<br />';
      echo '<strong>Рейтинг:</strong> ' . $score . '</p>';
      echo '<p><a href="index.php">&lt;&lt; Back to high scores</a></p>';

      // Clear the score data to clear the form
      $name = "";
      $score = "";

      mysqli_close($dbc);
    }
    else {
      echo '<p class="error">Please enter all of the information to add your high score.</p>';
    }
  }
?>

  <hr />
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php if (!empty($name)) echo $name; ?>" /><br />
    <label for="score">Score:</label>
    <input type="text" id="score" name="score" value="<?php if (!empty($score)) echo $score; ?>" />
    <hr />
    <input type="submit" value="Add" name="submit" />
  </form>
</body> 
</html>