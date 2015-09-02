<?php
	if (!defined('FLUX_ROOT')) exit;
	
	
	$bind = array();
	$sqlpartial = '';
	$chars = array();
	
	$hideGroupLevel = Flux::config('HideFromWhosOnline');
	$groups = AccountLevel::getGroupID($hideGroupLevel, '<');
	
	if(!empty($groups)) {
		$ids = implode(', ', array_fill(0, count($groups), '?'));
		$sqlpartial .= " where login.level IN ($ids) ";
		$bind = array_merge($bind, $groups);
	}
	
	$sortable = array('death', 'kill' => 'desc', 'kdr', 'killingstreak', 'multikill');
	
	$sql  = "SELECT count(*) AS total FROM {$server->charMapDatabase}.`pvp_rank` as p left join login ON `login`.account_id =p.account_id $sqlpartial";
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	
	$paginator = $this->getPaginator($sth->fetch()->total);
	$paginator->setSortableColumns($sortable);
	
	
	$col  = "p.*,c.name, c.class, c.base_level, c.job_level, c.guild_id, g.name as g_name";
	
	$sql  = $paginator->getSQL("SELECT $col FROM {$server->charMapDatabase}.`pvp_rank` AS p left join {$server->charMapDatabase}.`char` as c on `c`.char_id=`p`.char_id left join {$server->charMapDatabase}.`guild` as g on `c`.guild_id=`g`.guild_id left join login ON `login`.account_id =p.account_id $sqlpartial");
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	
	$chars = $sth->fetchAll();
?>