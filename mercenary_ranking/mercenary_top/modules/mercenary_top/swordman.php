<?php
	if (!defined('FLUX_ROOT')) exit;
	
	
	
	$bind = array();
	$sqlpartial = '';
	$iname  = $params->get('char_name');
	
	if ($iname) {
		if(is_numeric($iname))
		{
			$sql  = "SELECT char_id  FROM {$server->charMapDatabase}.`char` where char_id='{$iname}'";
			$sth  = $server->connection->getStatement($sql);
			$sth->execute();
			$char = $sth->fetchAll();
		}
		else
		{
			$sql  = "SELECT char_id  FROM {$server->charMapDatabase}.`char` where UPPER(name) LIKE '%{$iname}%'";
			$sth  = $server->connection->getStatement($sql);
			$sth->execute();
			$char = $sth->fetchAll();
		}
		$search = array();
		foreach($char as $char_id)
		{
			$search[] = $char_id->char_id;
		}
		
		$charids = implode(",",$search);
		$sqlpartial .= "where c.`char_id` in ({$charids})";
	}
	
	
	
	
	$sql  = "SELECT count(*) AS total FROM {$server->charMapDatabase}.`mercenary_owner` AS m left join {$server->charMapDatabase}.`char` as c on `c`.char_id=`m`.char_id $sqlpartial";
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	
	$sortable = array('sword_calls', 'sword_faith' => 'desc');
	
	$paginator = $this->getPaginator($sth->fetch()->total);
	$paginator->setSortableColumns($sortable);
	
	
	$col  = "m.*,c.name, c.class, c.base_level, c.job_level, c.guild_id, g.name as g_name";
	
	$sql  = $paginator->getSQL("SELECT $col FROM {$server->charMapDatabase}.`mercenary_owner` AS m left join {$server->charMapDatabase}.`char` as c on `c`.char_id=`m`.char_id left join {$server->charMapDatabase}.`guild` as g on `c`.guild_id=`g`.guild_id $sqlpartial");
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	
	$chars = $sth->fetchAll();
?>