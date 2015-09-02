<?php
	if (!defined('FLUX_ROOT')) exit;
	
	if(!empty($_POST['view']))
	{
		setcookie("woe_stats_view", $_POST['view'], time()+time(), '/');
		$_COOKIE['woe_stats_view'] = $_POST['view'];
	}
	
	$bind = array();
	$sqlpartial = '';
	$chars = array();
	
	$hideGroupLevel = Flux::config('HideFromWhosOnline');
	$groups = AccountLevel::getGroupID($hideGroupLevel, '<');
	
	if(!empty($groups)) {
		$ids = implode(', ', array_fill(0, count($groups), '?'));
		$sqlpartial .= " where login.group_id IN ($ids) ";
		$bind = array_merge($bind, $groups);
	}
	
	$sql  = "SELECT date FROM {$server->charMapDatabase}.`char_woe_statistics` group by `char_woe_statistics`.date desc";
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute();
	
	$woe_list = $sth->fetchAll();
	
	//echo $woe_list[0]->date;
	
	$woe_date  = $params->get('woe_date');
	
	if ($woe_date) 
	{
		$sqlpartial .= " and `p`.date = ?";
		$bind = array_merge($bind, (array)$woe_date);
	}
	else
	{
		$sqlpartial .= " and `p`.date = ?";
		$bind = array_merge($bind, (array)$woe_list[0]->date);
	}
	
	$guild_name  = $params->get('guild_name');
	if ($guild_name) 
	{
		$sqlpartial .= " and LOWER(`g`.name) like LOWER('%{$guild_name}%')";
	}
	
	$char_name  = $params->get('char_name');
	if ($char_name) 
	{
		$sqlpartial .= " and `c`.name like '%{$char_name}%'";
	}

	$sortable = array('death_count', 'kill_count' => 'desc');
	
	$sql  = "SELECT count(*) AS total FROM {$server->charMapDatabase}.`char_woe_statistics` AS p left join {$server->charMapDatabase}.`char` as c on `c`.char_id=`p`.char_id left join {$server->charMapDatabase}.`guild` as g on `c`.guild_id=`g`.guild_id left join login ON `login`.account_id =`c`.account_id {$sqlpartial}";
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	
	$paginator = $this->getPaginator($sth->fetch()->total);
	$paginator->setSortableColumns($sortable);
	
	$col  = "p.*,c.*,login.sex, g.name as g_name";
	
	$sql  = $paginator->getSQL("SELECT $col FROM {$server->charMapDatabase}.`char_woe_statistics` AS p left join {$server->charMapDatabase}.`char` as c on `c`.char_id=`p`.char_id left join {$server->charMapDatabase}.`guild` as g on `c`.guild_id=`g`.guild_id left join login ON `login`.account_id =`c`.account_id {$sqlpartial}");
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	$chars = $sth->fetchAll();
?>