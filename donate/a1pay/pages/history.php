<?

if ($_SESSION["OnUser"] == "yes") {

echo "<br /><table class='RegTableInput' border='0' cellspacing='0' cellpadding='0' width='90%'><tr align='center'><td width='150'>Номер оплаты</td><td width='150'>Платёжная система</td><td width='100'>Количество (в рублях)</td></tr>";

$result = mysql_query("SELECT * FROM `a1lite_system` WHERE `comment`='".$_SESSION["account_id"]."'");
$myrow = mysql_fetch_array($result);

 do {
printf("<tr align='center'>
			<td>
			%s
			</td>
			<td>
			%s
			</td>
			<td>%s руб.
			</td></tr>
", $myrow['tid'],$myrow['type'],$myrow['system_income']);
     }
while ($myrow = mysql_fetch_array($result));

echo "</table>";

} else {

echo "Необходимо авторизироваться на сайте через форму слева";

}

?>