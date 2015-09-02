<?php
	if (!defined('FLUX_ROOT')) exit;
	
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
	
	$char_name  = $params->get('char_name');
	if ($char_name) 
	{
		$sqlpartial .= " and `c`.name like '%{$char_name}%'";
	}

	$sortable = array('completed' => 'desc');
	
	$sql  = "SELECT count(distinct p.cid) AS total FROM {$server->charMapDatabase}.`player_mission` AS p left join {$server->charMapDatabase}.`char` as c on `c`.char_id=`p`.cid left join {$server->charMapDatabase}.`guild` as g on `c`.guild_id=`g`.guild_id left join login ON `login`.account_id =`c`.account_id {$sqlpartial}";
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	
	$paginator = $this->getPaginator($sth->fetch()->total);
	$paginator->setSortableColumns($sortable);
	
	$col  = "p.*,count(p.cid) as completed ,c.*,g.name as g_name";
	
	$sql  = $paginator->getSQL("SELECT $col FROM {$server->charMapDatabase}.`player_mission` AS p left join {$server->charMapDatabase}.`char` as c on `c`.char_id=`p`.cid left join {$server->charMapDatabase}.`guild` as g on `c`.guild_id=`g`.guild_id left join login ON `login`.account_id =`c`.account_id {$sqlpartial} group by `p`.cid");
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	$chars = $sth->fetchAll();
?>