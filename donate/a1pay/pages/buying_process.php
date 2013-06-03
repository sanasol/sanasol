<?
if ($_SESSION["OnUser"] == "yes") {

if ($_POST["item_id"] > 1) {

$item_id = trim($_POST["item_id"]);

$result = mysql_query("SELECT * FROM `shop_db` where `item_id`='$item_id'");
$myrow = mysql_fetch_array($result);
$hack = mysql_num_rows($result);

$result2 = mysql_query("SELECT * FROM `login` where `userid`='".$_SESSION["UserName"]."'");
$myrow2 = mysql_fetch_array($result2);

if ($hack <= 0) { die("hacking attempt!"); } else {

if ($myrow["cost"] > $myrow2["balance"]) {
echo "У вас недостаточно средств на счете для приобретения ".$myrow["name"];
} else {

$result = mysql_query("UPDATE `login` SET  `balance` = `balance`-".$myrow["cost"]." WHERE `userid`='".$_SESSION["UserName"]."'");

$account = mysql_query("SELECT account_id FROM `login` where `userid`='".$_SESSION["UserName"]."'");
$account_id = mysql_fetch_array($account);

$result2 = mysql_query("INSERT INTO `storage` (`id`, `account_id`, `nameid`, `amount`, `equip`, `identify`, `refine`, `attribute`, `card0`, `card1`, `card2`, `card3`, `expire_time`) VALUES (NULL, '".$account_id["account_id"]."', '$item_id', '1', '0', '1', '0', '0', '0', '0', '0', '0', '0');");

if ($result2) {
//Пишем Логи
$today = date("F j, Y, g:i a");
$log = mysql_query("INSERT INTO `shop_log` (`id`, `item_id`, `item_count`, `cost`, `account_id`, `time`) VALUES (NULL, '$item_id', '1', '".$myrow["cost"]."', '".$account_id["account_id"]."', '$today')");
//Пишем Логи

echo "Вещь добавлена в Сундук Кафры";
	echo '<head>
		<META HTTP-EQUIV="Refresh" CONTENT="3;URL=index.php">
	</head>';
} else {echo "Ошибка";}

}

}
} else { echo "Что это вам тут надо?"; }

} else {

echo "Необходимо авторизироваться на сайте через форму слева";

}
?>