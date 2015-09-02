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
	
	$player_id  = (int)$params->get('player_id');
	$sqlpartial .= " and `p`.cid = ?";
	$bind = array_merge($bind, (array)$player_id);
	
	$sql  = "SELECT p.*,login.sex,c.*,g.name as g_name, mb.title, mb.desc FROM {$server->charMapDatabase}.`player_mission` AS p left join {$server->charMapDatabase}.`mission_board` as mb on `mb`.id=`p`.mission_id left join {$server->charMapDatabase}.`char` as c on `c`.char_id=`p`.cid left join {$server->charMapDatabase}.`guild` as g on `c`.guild_id=`g`.guild_id left join login ON `login`.account_id =`c`.account_id {$sqlpartial}";
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	$missions = $sth->fetchAll();
?>