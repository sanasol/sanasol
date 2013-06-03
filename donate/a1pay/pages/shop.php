<?

if ($_SESSION["OnUser"] == "yes") {

$type = trim($_GET["t"]);

if ($type == null) { $type = 0; }

$result = mysql_query("SELECT * FROM `shop_db` where `type`='$type'");
$myrow = mysql_fetch_array($result);

if ($myrow['name'] == null) { echo "Магазин пуст<br /><br />"; } else {

echo "<font size='4' color='red'>Перед покупкой вы должны выйти из игры</font><br /><table class='RegTableInput2' cellspacing='2' cellpadding='2' width='100%'><tr align='center'><td width='75'></td><td width='150'></td><td width='120'></td></tr>";

 do {
printf("
<tr><td colspan='3'><div align='center' class='BoldBlack'><b>%s %s руб.</b></div></td></tr>
<tr align=\"center\">
        <td><img src=\"%s\"></td>
        <td>%s</td>
		<td><form action='./?page=buying_process' method='post'><input type=\"hidden\" name=\"item_id\" value=\"%s\" /><input name='buy' value='Купить' type='submit'/></form></td>
    </tr><tr height='40'><td></td></tr>
", $myrow['name'],$myrow['cost'],$myrow['img'], $myrow['desc'],$myrow['item_id']);
     }
while ($myrow = mysql_fetch_array($result));

echo "</table>";
}
} else {

echo "Необходимо авторизироваться на сайте через форму слева";

}
?>