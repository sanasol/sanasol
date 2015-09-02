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
	
	
	$sqlpartial .= " group by m.kill_char_id";
	
	
	$sql  = "SELECT count(*) AS total FROM {$server->charMapDatabase}.`mvplog` as m inner join `char` as ch ON ch.char_id = `m`.kill_char_id left join login ON `login`.account_id =ch.account_id $sqlpartial";
	
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	$sortable = array('name', 'char_id', 'class', 'amount' => 'desc', 'base_level', 'job_level');
	$paginator = $this->getPaginator($sth->fetch()->total);
	$paginator->setSortableColumns($sortable);
	
	
	$col  = "ch.name, ch.char_id, class, ch.guild_id, count(3) as amount, base_level, job_level, guild.name as g_name";
	
	$sql  = $paginator->getSQL("SELECT $col FROM {$server->charMapDatabase}.`mvplog` as m inner join `char` as ch ON ch.char_id = `m`.kill_char_id left join login ON `login`.account_id =ch.account_id left join guild on guild.guild_id=ch.guild_id $sqlpartial");
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	
	$chars = $sth->fetchAll();
?>