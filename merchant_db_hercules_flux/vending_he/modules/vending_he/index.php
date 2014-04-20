<?php
	if (!defined('FLUX_ROOT')) exit;
	
	$refine = array(0=>"-", "+1", "+2", "+3", "+4", "+5", "+6", "+7","+8","+9","+10");
	
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
			
			$sqlpartial .= "where ci.`nameid` in ({$items})";
		}
	}
	
	$sql  = "SELECT count(*) AS total FROM {$server->charMapDatabase}.`autotrade_data` $sqlpartial";
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	
	$sortable = array('merchant_name', 'am.title', 'ci.nameid', 'ci.amount', 'price', 'ci.refine', 'ci.card0', 'ci.card1', 'ci.card2', 'ci.card3');

	$paginator = $this->getPaginator($sth->fetch()->total);
	$paginator->setSortableColumns($sortable);
	
	
	$col  = "ad.*,ci.*,am.title,c.name as merchant_name, c.last_map, c.last_x, c.last_y";
	
	$sql  = $paginator->getSQL("SELECT $col FROM {$server->charMapDatabase}.`autotrade_data` AS ad left join {$server->charMapDatabase}.`cart_inventory` as ci on ci.id=ad.itemkey  left join {$server->charMapDatabase}.`autotrade_merchants` as am on ad.char_id=am.char_id left join {$server->charMapDatabase}.`char` as c on c.char_id=am.char_id $sqlpartial");
	$sth  = $server->connection->getStatement($sql);
	
	$sth->execute($bind);
	
	$chars = $sth->fetchAll();
?>