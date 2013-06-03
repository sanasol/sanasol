<?
if($_SESSION["OnUserGm"] == "yes") {
		echo "<form action='?page=delete&finishdelete' method='post'";
		echo "<p>"."Выберите вещь для удаления"."</p>";
		$result = mysql_query("SELECT `name`,`id` FROM `shop_db`");
		$myrow = mysql_fetch_array($result);
		do
		{
		printf ("<div align='left'><p><input name='iid' type='radio' value='%s'><label> %s</label></p></div>",$myrow['id'], $myrow['name']);
		}
		while($myrow = mysql_fetch_array($result));
		echo "<input name='submit' type='submit' value='Удалить'>";
		echo "</form>";
		
	if ($_POST['submit']) {
		
	    $iid = trim($_POST["iid"]);
		$result = mysql_query("DELETE FROM `shop_db` WHERE `id`='$iid'");
		
	if($result == 'true')
	{
	echo "<div align='center'><font color='#0066FF'>вещь удалена</font></div>";
	echo '<head>
		<META HTTP-EQUIV="Refresh" CONTENT="3;URL=index.php?id=delete">
	</head>';
	}
	else
	{
	echo "<div align='center'><font color='#FF0000'>Вещь не удалена попробуйте повторить попытку!!</font></div>";
	echo '<head>
		<META HTTP-EQUIV="Refresh" CONTENT="3;URL=index.php?page=delete">
	</head>';
	}	
	}
}
?>