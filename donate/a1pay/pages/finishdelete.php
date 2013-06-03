<?
if($_SESSION["OnUserGm"] == "yes") {

	    $iid = trim($_POST["iid"]);
		$result = mysql_query("DELETE FROM `shop_db` WHERE `id`='$id'");
		
	if($result == 'true')
	{
	echo "<div align='center'><font color='#0066FF'>вещь удалена</font></div>";
	echo '<head>
		<META HTTP-EQUIV="Refresh" CONTENT="3;URL=index.php?page=delete">
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
?>