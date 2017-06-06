<?php
ini_set('display_errors',1);
error_reporting(E_ALL);


session_start();
//определение констант CAPTCHA
define('CAPTCHA_NUMCHARS', 6);
define('CAPTCHA_WIDTH', 100);
define('CAPTCHA_HEIGTH', 25);

//Создание случайной идентификационной фразы
$pass_phrase = '';
for ($i = 0; $i < CAPTCHA_NUMCHARS; $i++) {
	$pass_phrase .= chr(rand(97, 122));
}

//Сохранение идентификационной фразы в переменой сессии в зашифрованном виде
$_SESSION['pass_phrase'] = sha1($pass_phrase);

//Создание изображения
$img = imagecreatetruecolor(CAPTCHA_WIDTH, CAPTCHA_HEIGTH);

//Установка цветов: белого для фона, черного для текста и серого для графических элементов
$bg_color = imagecolorallocate($img, 255, 255, 255); #белый цвет
$text_color = imagecolorallocate($img, 0, 0, 0); #черный цвет
$graphic_color = imagecolorallocate($img, 64, 64, 64); #темно-серый цвет

//Заполнение фона
imagefilledrectangle($img, 0, 0, CAPTCHA_WIDTH, CAPTCHA_HEIGTH, $bg_color);

//Рисование линий, расположенных случайным образом
for ($i = 0; $i < 5; $i++) {
	imageline($img, 0, rand() % CAPTCHA_HEIGTH, CAPTCHA_WIDTH, rand() % CAPTCHA_HEIGTH,  $graphic_color); 
}

//Рисование точек, расположенных случайным образом
for ($i = 0; $i < 50; $i++) {
	imagesetpixel($img, rand() % CAPTCHA_WIDTH, rand() % CAPTCHA_HEIGTH, $graphic_color);
}

//Написание строки, содержащей идентификационную фразу
imagettftext($img, 18, 0, 5, CAPTCHA_HEIGTH - 5, $text_color, "Courier New Bold.ttf", $pass_phrase);

//Вывод изображения в формате PNG с помощью HTTP-заголовка
header("Content-type: image/png");
imagepng($img);

//Удаление изображения
imagedestroy($img);

?>