<?php
	if (!defined('FLUX_ROOT')) exit;
	
	$refine = array(0=>"-", "+1", "+2", "+3", "+4", "+5", "+6", "+7", "+8", "+9", "+10");
	
	function get_item_name($id, $server)
	{
		if($id>255)
		{
			$sql  = "SELECT name_japanese, slots  FROM {$server->charMapDatabase}.`item_db` where id='{$id}'";
			$sth  = $server->connection->getStatement($sql);
			$sth->execute();
			$r = $sth->fetch();
			$slots = ($r->slots > 0) ? "[{$r->slots}]":""; 
			return $r->name_japanese.$slots;
		}
		else
		{
			return "";
		}
	}
	
	function get_char_name($id, $server)
	{
		$sql  = "SELECT name FROM {$server->charMapDatabase}.`char` where char_id='{$id}'";
		$sth  = $server->connection->getStatement($sql);
		$sth->execute();
		$r = $sth->fetch();
		return $r->name;
	}
	
	$bind = array();
	$sqlpartial = '';
	$iname  = $params->get('item_name');
	
	if ($iname) {
		if(is_numeric($iname))
		{
			$sql  = "SELECT id  FROM {$server->charMapDatabase}.`item_db` where id='{$iname}'";
			$sth  = $server->connection->getStatement($sql);
			$sth->execute();
			$item = $sth->fetchAll();
		}
		else
		{
			$sql  = "SELECT id  FROM {$server->charMapDatabase}.`item_db` where UPPER(name_japanese) LIKE '%{$iname}%'";
			$sth  = $server->connection->getStatement($sql);
			$sth->execute();
			$item = $sth->fetchAll();
		}
		$itemsearch = array();
		foreach($item as $search_id)
		{
			$itemsearch[] = $search_id->id;
		}
		
		$items = implode(",",$itemsearch);
		
		if(count($itemsearch) >= 1)
		{
			$search_info = "<b>Perhaps you were looking for:</b> ";
			$i=0;
			foreach($itemsearch as $id){ if($i>10) break; $searchitems[] = $this->linkToItem($id, get_item_name($id,$server)); $i++;}
			$search_info .= implode(", ",$searchitems);
			
			$sqlpartial .= "where v.`nameid` in ({$items})";
		}
	}
	
	
	
	
	$sql  = "SELECT count(*) AS total FROM {$server->charMapDatabase}.`vending_stat` AS v $sqlpartial";
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	
	$sortable = array('shop', 'owner', 'nameid', 'amount', 'price', 'refine', 'card0', 'card1', 'card2', 'card3');
	
	$paginator = $this->getPaginator($sth->fetch()->total);
	$paginator->setSortableColumns($sortable);
	
	
	$col  = "v.*";
	
	$sql  = $paginator->getSQL("SELECT $col FROM {$server->charMapDatabase}.`vending_stat` AS v $sqlpartial");
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	
	$chars = $sth->fetchAll();
?>