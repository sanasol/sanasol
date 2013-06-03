<?
	session_start();
	include("./db.php");
	$userid = trim($_POST["log"]);
	$user_pass = trim($_POST["pass"]);
	if(!empty($_POST["yes"]))
	{
		
		
		if(empty($userid) || empty($user_pass))
		
		{
			echo "Введите логин и пароль";
			echo '<head><META HTTP-EQUIV="Refresh" CONTENT="2;URL=./"></head>';
			
		} 
		else if(strlen($userid) < 3 || strlen($userid) > 16)
		{
			echo "Введите логин и пароль";
			echo '<head><META HTTP-EQUIV="Refresh" CONTENT="2;URL=./"></head>';
		}
		
		else
		{
			if($_SESSION["OnUser"] == "yes")
			{ 
				echo "Вы уже вошли";     
			}
			else 
			{
				$unoun = mysql_query("SELECT user_pass,level,account_id FROM login where userid='{$userid}'", $db);
				$unexuser = mysql_num_rows($unoun);
				if($unexuser == "1")
				{
					$rows = mysql_fetch_array($unoun);
					$passs = $rows["user_pass"];
					$level = $rows["level"];
					$_SESSION["OnUser"] = "no";
					$_SESSION["OnUserGm"] = "no";
					if($md5) { $user_pass = md5($user_pass); }
					if($passs == $user_pass)
					{
						$_SESSION["OnUser"] = "yes";
						$_SESSION["UserName"] = $userid;
						$_SESSION["account_id"] = $rows["account_id"];
						if($level >= 99) {$_SESSION["OnUserGm"] = "yes";}	
						echo '<head><META HTTP-EQUIV="Refresh" CONTENT="0;URL=index.php"></head>';
					}
					else
					{
						echo "Неправильный пароль";
					}
					
				}
				else
				{
					echo "Вы не зарегистрированы";
				}
				
			}		
		}
	}
	
	
	if(!empty($_POST["UserOff"]))
	{
		unset($_SESSION["OnUser"], $_SESSION["UserName"]);
		if($_SESSION["OnUserGm"] == "yes")
		{
			unset($_SESSION["OnUserGm"]);
		}
		echo '<head>
		<META HTTP-EQUIV="Refresh" CONTENT="0;URL=./">
		</head>';
		
	}
	
?>
<div class="ul">               
	<?	
		if($_SESSION["OnUser"] == "yes")
		{
			if($_SESSION["OnUserGm"] == "yes")
			{
				echo '<li>Привет адм: <b>'.$_SESSION["UserName"].'</b></li>
				<li><a href="./?page=add_item">Добавить вещь</a></li>
				<li><a href="./?page=edit">Редактировать вещь</a></li>
				<li><a href="./?page=delete">Удалить вещь</a><br /></li>';
			}
			else
			{
				echo '<li>Привет: <b>'.$_SESSION["UserName"].'</b></li>';
			}
			$query = mysql_query("SELECT * FROM `login` where `userid`='".$_SESSION["UserName"]."'", $db);
			$myrow = mysql_fetch_array($query);
			
			$pop = ($myrow["balance"] == null) ? "0" : "{$myrow["balance"]}";
			
			echo '
			<li>Баланс аккаунта: <br />'.$pop.' руб.</li>
			<li><a href="./?page=balance" title="Пополнить баланс">Пополнить баланс</a></li>
			<li><a href="./?page=buy_tcg" title="Купить поинты">Купить TCG</a></li>
			<li><a href="./?page=history" title="История платежей">История платежей</a></li>
			<li>-</li>
			<li><a href="./?page=shop&t=0" title="Магазин расхода">Магазин расхода</a></li>
			<li><a href="./?page=shop&t=1" title="Магазин блюд">Магазин блюд</a></li>
			<li><a href="./?page=shop&t=2" title="Магазин Свитков">Магазин Свитков</a></li>
			<li><a href="./?page=shop&t=3" title="Магазин Шапок">Магазин Шапок</a></li>
			<li><a href="./?page=shop&t=4" title="Магазин экипировки">Магазин экипировки</a></li>
			<li><a href="./?page=shop&t=5" title="Магазин оружия">Магазин оружия</a></li>
			
			</ul>
			<form action="" method="post"><input name="UserOff" value="Выход" type="submit"/></form><br />'; 
			
			
			//Контент страниц
			if(isset($_GET["page"])){
				$page = $_GET["page"].".php";
			}else $page = "blank.php";
			if(file_exists("pages/$page")){ include "pages/$page"; }else{ echo "404 - Страница не найдена."; }
			//Контент страниц
			
		}  
		else
		{
			
			echo '<form action="" method="post" id="form">
			<input name="log" type="text" class="input" value="логин" onfocus="javascrit:if(this.value == &#39;логин&#39;) this.value = &#39;&#39;;" onblur="javascript:if(!this.value) this.value=&#39;логин&#39;">
			<input name="pass" type="password" class="input" value="пароль" onfocus="javascrit:if(this.value == &#39;пароль&#39;) this.value = &#39;&#39;;" onblur="javascript:if(!this.value) this.value=&#39;пароль&#39;">
			<br /><input name="yes" type="submit" value="Войти">	
			</form>';
			
		} ?>
		
</div>
