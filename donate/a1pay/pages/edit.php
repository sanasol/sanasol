<?
if($_SESSION["OnUserGm"] == "yes") {
		echo "<p>Выберите вещь для редактирования</p>";
		$result = mysql_query("SELECT `name`,`id` FROM `shop_db`");
		$myrow = mysql_fetch_array($result);
		do
		{
		printf ("<a href='?page=edit&iid=%s' style='color: #6b9200;'>%s</a><br />",$myrow['id'], $myrow['name']);
		}
		while($myrow = mysql_fetch_array($result));
		
	

	if ($_GET["iid"] >= 1) {
		
	    $id2 = trim($_GET["iid"]);
		$result2 = mysql_query("SELECT * FROM `shop_db` WHERE `id`='$id2'");
		$myrow2 = mysql_fetch_array($result2);
		
		?><div align="center">
		<form action="?page=edit&iid=<? echo $id2; ?>" method="post" class="RegTableInput">
<table width="50%" border="0" cellspacing="1" cellpadding="1">
<tr>
<td height="50"></td>
<td></td>
</tr>
<tr>
<td>Название</td>
<td><input name="name" type="text" size="15"  value="<? echo $myrow2["name"]; ?>" /></td>
</tr>
<tr>
<td>ID вещи</td>
<td><input name="item_id" type="text" size="15"  value="<? echo $myrow2["item_id"]; ?>"  /></td>
</tr>
<tr>
<td>Описание</td>
<td><textarea name="desc" rows="10" cols="50"><? echo $myrow2["desc"]; ?></textarea></td>
</tr>
<tr>
<td>Картинка</td>
<td><input name="img" type="text" size="70" value="<? echo $myrow2["img"]; ?>"  /></td>
</tr>
<tr>
<td>Цена</td>
<td><input name="cost" type="text" size="15"  value="<? echo $myrow2["cost"]; ?>"  /></td>
</tr>
<tr>
<td>Тип</td>
<td><select name="type">
   <option selected="selected" value="0">Расходники</option>
    <option value="1">Блюда</option>
	<option value="2">Свитки</option>
	<option value="3">Шапки</option>
	<option value="4">Экипировка</option>
	<option value="5">Оружие</option>
  </select></td>
</tr>
<tr>
<td colspan="2" height="50"></td>
</tr>
<tr>
<td colspan="2"><div align="center"><input value="<? echo $id2; ?>" type="hidden" name="id2"  />
<input value="Обновить" type="submit" name="submit"  /></div></td>
</tr>
</table>
      </form></div>
		
		<?
		
		if ($_POST["submit"]) {
mysql_query("SET SESSION CHARACTER SET utf-8");
mysql_query("SET NAMES utf-8");
		$additem = mysql_query("UPDATE `shop_db` SET `name`='".$_POST["name"]."', `item_id`='".$_POST["item_id"]."',`desc`='".$_POST["desc"]."',`img`='".$_POST["img"]."',`cost`='".$_POST["cost"]."',`type`='".$_POST["type"]."' WHERE `id`='".$_POST["id2"]."';");

if ($additem) { echo "<br />Вещь обновлена"; } else { echo ":("; }
		}
	
	}
		
		}
		
		?>