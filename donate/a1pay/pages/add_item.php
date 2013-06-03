<?
if($_SESSION["OnUserGm"] == "yes") {
?><center>
<form action="?page=add_item&add" method="post" class="RegTableInput">
	  <table width="50%" border="0" cellspacing="1" cellpadding="1">
<tr>
<td height="50"></td>
<td></td>
</tr>
<tr>
<td>Название</td>
<td><input name="name" type="text" size="15" /></td>
</tr>
<tr>
<td>ID вещи</td>
<td><input name="item_id" type="text" size="15" /></td>
</tr>
<tr>
<td>Описание</td>
<td><textarea name="desc" rows="10" cols="50"></textarea></td>
</tr>
<tr>
<td>Картинка</td>
<td><input name="img" type="text" size="70" /></td>
</tr>
<tr>
<td>Цена</td>
<td><input name="cost" type="text" size="15" /></td>
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
  </select>	</td>
</tr>
<tr>
<td colspan="2" height="10"></td>
</tr>
<tr>
<td colspan="2"><div align="center"><input value="Добавить" type="submit" name="submit"  /></div></td>
</tr>
<tr>
<td colspan="2" height="10"></td>
</tr>
</table>
      </form>
	  </center>
<?

if ($_POST["submit"]) {

mysql_query("SET SESSION CHARACTER SET utf-8");
mysql_query("SET NAMES utf-8");

$additem = mysql_query("INSERT INTO `shop_db` (`id`, `name`, `item_id`, `desc`, `img`, `cost`, `type`) VALUES (NULL, '".$_POST["name"]."', '".$_POST["item_id"]."', '".$_POST["desc"]."', '".$_POST["img"]."', '".$_POST["cost"]."', '".$_POST["type"]."');");

if ($additem) { echo "<br />Вещь Добавлена"; } else { echo ":("; }

}

}
?>