<?php
	if (!defined('FLUX_ROOT')) exit;
	
	function refine_lvl($refine)
	{
		if($refine > 0)
		{
			return '+'.$refine;
		}
		else
		{
			return '-';
		}
	}
	
	function get_item_name($id, $server)
	{
		if($id>255)
		{
			$sql  = "SELECT name_japanese, slots  FROM {$server->charMapDatabase}.`item_db` where id='{$id}'";
			$sth  = $server->connection->getStatement($sql);
			$sth->execute();
			$r = $sth->fetch();
			$slots = (@$r->slots > 0) ? "[{$r->slots}]":""; 
			if(strlen(@$r->name_japanese) > 1)
				return $r->name_japanese.$slots;
			else
			return "Unknown Item";
		}
		else
		{
			return;
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
			$iname = filter_var($iname,FILTER_SANITIZE_NUMBER_INT);
			if($iname > 0)
			{
				$sql  = "SELECT id  FROM {$server->charMapDatabase}.`item_db` where id='{$iname}'";
				$sth  = $server->connection->getStatement($sql);
				$sth->execute();
				$item = $sth->fetchAll();
			}
		}
		else
		{
			$iname = preg_replace("/[^a-zA-Z0-9\s]+/", "", $iname);
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
	
	
	
	
	$sql  = "SELECT count(*) AS total FROM {$server->charMapDatabase}.`vending` AS v $sqlpartial";
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	
	$sortable = array('merchant_name', 'v.name', 'nameid', 'amount', 'price', 'refine', 'card0', 'card1', 'card2', 'card3');
	
	$paginator = $this->getPaginator($sth->fetch()->total);
	$paginator->setSortableColumns($sortable);
	
	
	$col  = "v.*,char.name as merchant_name, char.last_map, char.last_x, char.last_y";
	
	$sql  = $paginator->getSQL("SELECT $col FROM {$server->charMapDatabase}.`vending` AS v left join {$server->charMapDatabase}.`char` on `char`.char_id=`v`.char_id $sqlpartial");
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	
	$chars = $sth->fetchAll();
?>