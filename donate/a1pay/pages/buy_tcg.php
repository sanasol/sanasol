<?
if ($_SESSION["OnUser"] == "yes") {


?>
  <script type='text/javascript'>
function updtcg() {
 document.getElementById('tcgsum').value=document.getElementById('count').value*15; // 15 Цена в рублях за ТЦГ
}
</script>
  <form method="POST" action="./?page=buy_tcg&done">
 <span class="BoldBlack">1 TCG = 15р<br />Перед покупкой TCG вы ДОЛЖНЫ выйти из игры</span><br />
  Кол-во TCG: <input type="input" name="c0unt" id="count" onchange='updtcg();' onkeyup='updtcg();' onblur='updtcg();' /> за <input type='text' id='tcgsum' value='0' size=3 style='text-align: center' readonly /> руб.
  <input type="submit" value="Купить" />
</form>
<br />
<?
if (isset($_POST["c0unt"])) {

$count = trim($_POST["c0unt"]);

if($count == "" or $count <= 0) { echo "Вы должны купить хотя бы 1 поинт"; } else {

$item_id = "7227";
$cost = 15; // Цена в рублях за 1 ТЦГ

$full_cost = $count*$cost;

$result2 = mysql_query("SELECT * FROM `login` where `userid`='".$_SESSION["UserName"]."'");
$myrow2 = mysql_fetch_array($result2);

if ($full_cost > $myrow2["balance"]) {
echo "У вас недостаточно средств на счете для приобретения такого количества TCG";
} else {

$result = mysql_query("UPDATE `login` SET  `balance` = `balance`-".$full_cost." WHERE `userid`='".$_SESSION["UserName"]."'");

$account = mysql_query("SELECT account_id FROM `login` where `userid`='".$_SESSION["UserName"]."'");
$account_id = mysql_fetch_array($account);

$check = mysql_query("SELECT * FROM `storage` where `account_id`='".$account_id["account_id"]."' and `nameid`='$item_id'");
$check2 = mysql_fetch_array($check);
if ($check2["account_id"] == null) {
$result2 =mysql_query("INSERT INTO `storage` (`id`, `account_id`, `nameid`, `amount`, `equip`, `identify`, `refine`, `attribute`, `card0`, `card1`, `card2`, `card3`, `expire_time`) VALUES (NULL, '".$account_id["account_id"]."', '$item_id', '$count', '0', '1', '0', '0', '0', '0', '0', '0', '0');");
} else {

$result2 = mysql_query("UPDATE `storage` SET `amount` = `amount`+'$count' WHERE `account_id` = '".$account_id["account_id"]."' and `nameid`='$item_id'");

}
if ($result2) {
//Пишем Логи
$today = date("F j, Y, g:i a");
$log = mysql_query("INSERT INTO `shop_log` (`id`, `item_id`, `item_count`, `cost`, `account_id`, `time`) VALUES (NULL, '7227', '$count', '$full_cost', '".$account_id["account_id"]."', '$today')");
//Пишем Логи

echo "TCG добавлены на ваш аккаунт";
	echo '<head>
		<META HTTP-EQUIV="Refresh" CONTENT="3;URL=./">
	</head>';
}

}
}
}
} else {

echo "Необходимо авторизироваться на сайте через форму слева";

}
?>
