<?php
	if (!defined('FLUX_ROOT')) exit;
	
	$bind = array();
	$sqlpartial = 'where 1';
	$chars = array();
	
	$char_name  = $params->get('char_name');
	if ($char_name) 
	{
		$sqlpartial .= " and `p`.char_name like '%{$char_name}%'";
	}
	
	$gm_name  = $params->get('gm_name');
	if ($gm_name) 
	{
		$sqlpartial .= " and `p`.by_gm like '%{$gm_name}%'";
	}

	$sortable = array('id' => 'desc');
	
	$sql  = "SELECT count(*) AS total FROM {$server->charMapDatabase}.`itemizer` AS p left join {$server->charMapDatabase}.`char` as c on `c`.char_id=`p`.char_id left join login ON `login`.account_id =`c`.account_id {$sqlpartial}";
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	
	$paginator = $this->getPaginator($sth->fetch()->total);
	$paginator->setSortableColumns($sortable);
	
	$col  = "p.*, `c`.name as name";
	
	$sql  = $paginator->getSQL("SELECT $col FROM {$server->charMapDatabase}.`itemizer` AS p left join {$server->charMapDatabase}.`char` as c on `c`.char_id=`p`.char_id left join login ON `login`.account_id =`c`.account_id {$sqlpartial}");
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	$chars = $sth->fetchAll();
?>