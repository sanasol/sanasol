<?
	include("db.php");
	
	FUNCTION A1Lite_processor ($t,$secret)
	{
		$params = array(	'tid' => $t['tid'],
		'name' => $t['name'], 
		'comment' => $t['comment'],
		'partner_id' => $t['partner_id'],
		'service_id' => $t['service_id'],
		'order_id' => $t['order_id'],
		'type' => $t['type'],
		'partner_income' => $t['partner_income'],
		'system_income' => $t['system_income']
		);
		
		$params['check'] = md5(join('', array_values($params)) . $secret);
		
		if ($params['check'] === $t['check'])
		{
			$ok=true;
		}
		else
		{
			$ok=false;
		}
		
		return $ok;
	}
	
	
	if (A1Lite_processor($_POST,$secret)) 
	{
		
		$check = mysql_query("select * from `a1lite_system` where `tid`='{$_POST['tid']}'") or die(mysql_error()); 
		$myrow = mysql_num_rows($check);
		
		if ($myrow >= 1) 
		{ 
			die("Данная оплата уже прошла"); 
		} 
		else 
		{
			mysql_query("INSERT INTO `a1lite_system` (`tid`, `name`, `comment`, `partner_id`, `service_id`, `order_id`, `type`, `partner_income`, `system_income`, `check`, `state`) VALUES ('{$_POST['tid']}', '{$_POST['name']}', '{$_POST['comment']}', '{$_POST['partner_id']}', '{$_POST['service_id']}', '{$_POST['order_id']}', '{$_POST['type']}', '{$_POST['partner_income']}', '{$_POST['system_income']}', '', '0');",$db) or die(mysql_error()); 
			
			mysql_query("UPDATE `login` SET  `balance` = `balance`+'{$_POST['system_income']}' WHERE `account_id`='{$_POST['comment']}';",$db) or die(mysql_error()); 
			
			echo "ok"; 
		}
		
	} 
	else 
	{ 
		echo "error"; 
	}
	
?>
