<?
error_reporting(0); //Не показывать ошибки

$host  = "localhost"; 
$user  = "ragnarok"; 
$pass  = "ragnarok"; 

$rodb = "ragnarok";

$md5 = true; // Хеширование паролей

$secret = 'aasfkqjt1qiu0aisjfasf'; // Секретный ключ
$form_key = "JD34HrOg1cIBGsbv8KL3zq3hPzjYkGuhleP/rKMwrSA="; // Ключ формы, генерируется в кабинете A1pay

$db = mysql_connect($host, $user, $pass) or die("Ошибка подключения к базе данных"); 
mysql_select_db($rodb,$db);


?>
