<?php
	
	require("config.php");	
	
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
	
	if(empty($_POST['order']))
	{
		$order = 'nameid';
	}
	else
	{
		$order_cols = array("amount"=>"amount", "price"=>"price", "name"=>"shop");
		$order = $order_cols[$_POST['order']];
	}
	if(empty($_POST['order2']))
	{
		$order2 = 'DESC';
	}
	else
	{
		$order2_cols = array("ASC"=>"ASC", "DESC"=>"DESC");
		$order2 = $order2_cols[$_POST['order2']];
	}
	
	$totalrows = 0;
	$search_info = "";
	
	$pages = new Paginator;  
	
	if(!empty($_POST['name']))
	{
		$name = strtoupper(htmlspecialchars($_POST['name']));
		
		if(is_numeric($_POST['name']))
		{
			$name = filter_var($name,FILTER_SANITIZE_NUMBER_INT);
			if($name > 0)
			{
				$item = $db->select("item_db","id=:itemid", array(":itemid"=> "{$name}"), "id");
			}
		}
		else
		{
			$name = preg_replace("/[^a-zA-Z0-9\s]+/", "", $name);
			$item = $db->select("item_db","UPPER(name_japanese) LIKE :search", array(":search"=> "%{$name}%"), "id");
		}
		
		foreach($item as $search_id)
		{
			$itemsearch[] = $search_id->id;
		}
		$items = implode(",",$itemsearch);
		if(count($itemsearch) >= 1)
		{
			$result = true;
			$count = $db->select("vending","type='0' and `nameid` in ({$items})", "", "count(*) as cnt");
			$pages->items_total = $count[0]->cnt;
			$pages->mid_range = 5;  
			$pages->paginate();	
			
			$results = $db->select("vending_stat","type='0' and `nameid` in ({$items}) ORDER BY {$order} {$order2} {$pages->limit}", "", "vending_stat.*");
			$totalrows = count($results);
			
			$search_info .= "<b>Perhaps you were looking for:</b> ";
			$i=0;
			foreach($itemsearch as $id){ if($i>10) break; $searchitems[] = get_item_name($id); $i++;}
			$search_info .= implode(", ",$searchitems);
		}
	}
	else
	{
		$count = $db->select("vending_stat","type='0'", "", "count(*) as cnt");
		$pages->items_total = $count[0]->cnt;
		$pages->mid_range = 5;  
		$pages->paginate();	
		
		$results = $db->select("vending_stat","type='0' ORDER BY {$order} {$order2} {$pages->limit}", "", "vending_stat.*");
		$totalrows = count($results);
	}
?>
<head>
	<META http-equiv="Content-Type" content="text/html" charset="utf-8">
	<title>Merchbase</title>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<style>
		.map {
		width: 250px;
		}
		.ui-tooltip {
		max-height: 350px;
		}
		.mapinfo
		{
		text-align: center;
		border-bottom: 1px dashed gray;
		color: gray;
		}
		.mapinfo:hover
		{
		cursor: pointer;
		color: white;
		background: gray;
		border-bottom: 1px dashed white;
		}
		.head,.main
		{
		text-align: center;
		}
	</style>
	<script>
		$(function() {
			$( document ).tooltip({
				position: { my: "left+5 top-50", at: "right center", collision: "flipfit" },
				items: "[data-map]",
				content: function() {
					if ( $( this ).is( "[data-map]" ) ) {
						return "<img class='map' src='map.php?map="+$(this).data('map')+"&x="+$(this).data('x')+"&y="+$(this).data('y')+"'>";
					}
				}
			});
		});
	</script>
</head>
<body>
	<div style="text-align: center; padding: 5px;">
		<p><a href="./index.php" class="btn btn-danger">Main</a></p>
		<form action="" method="post" class="form-inline">
			<div class="form-group">
				<input type="text" name="name" size="30" class="form-control" value="<?=$name?>" placeholder="Item name or ID"/>
			</div>
			<button type="submit" class="btn btn-primary">Search</button>
		</form>
		
		<table class="table table-striped table-bordered text-center">
			<thead>
				<?php
					
					if(!empty($search_info))
					{
						echo "<tr><td colspan=\"12\">{$search_info}</td></tr>";
					}	
				?>
				<tr>
					<td colspan="12">
						<?php
							echo $pages->display_pages();  	
						?>
					</td>
				</tr>
				<tr>
					<td style="width: 200px !important;">Shop</td>
					<td>Merchant</td>
					<td>Position</td>
					<td></td>
					<td>Item</td>
					<td>Amount</td>
					<td>Price</td>
					<td>Refine</td>
					<td>Card(1)</td>
					<td>Card(2)</td>
					<td>Card(3)</td>
					<td>Card(4)</td>
				</tr>
			</thead>
			<tfoot>
				<td colspan="12">
					<?php
						echo $pages->display_pages();  	
					?>
				</td>
				<tr><td colspan="12">Items shown: <?php echo $totalrows; ?> of <?=$count[0]->cnt?></td></tr>
				<tr><td colspan="12">
					<form action="" method="post" class="form-inline">
						<div class="form-group">
							<label class="sr-only" for="sort">Sorting:</label>
							<select name="order" class="form-control" >
								<option value="price">By price</option>
								<option value="amount">By amount</option>
								<option value="name" selected="selected">By shop</option>
							</select>
						</div>
						<div class="form-group">
							<select name="order2" class="form-control" >
								<option value="DESC" selected="selected">Descending</option>
								<option value="ASC">Ascending</option>
							</select>
						</div>
						<div class="form-group">
							<?php
								echo $pages->display_items_per_page();  	
							?>
						</div>
						<input type="submit" name="Submit" value="Sort"  class="btn btn-primary"/>
					</form>
				</td></tr>
			</tfoot>
			<tbody>
				<?php 
					if($totalrows >= 1)
					{
						foreach($results as $row)
						{
							$nick = "";
							if($row->card0 == 254) {  $char_sign = $db->select("`char`","char_id='{$row->card2}'", "", "name"); $nick_just = $char_sign[0]->name; $nick = "<span style='color: blue;'>{$nick_just}'s</span> "; }
							
							$row->price = number_format($row->price);
							$row->amount = number_format($row->amount);
							
							$row->shop2 = $row->shop;
							$row->shop = mb_substr($row->shop,0, 10, "UTF-8")."...";
							
							$vvs = "";
							if ($row->card0 == 255 && intval($row->card1/1280) > 0)
							{
								for ($i = 0; $i < intval($row->card1/1280); $i++)
								{
									$vvs .= "Very ";
								}
								$vvs .= "Strong ";
								$vvs = "<span style='color: blue;'>{$vvs}</span> ";
							}
							
							
							$item = get_item_name($row->nameid);
							echo "<tr>
							<td title=\"{$row->shop2}\">{$row->shop}</td>
							<td>{$row->owner}</td>
							<td><p class='mapinfo' data-map='{$row->map}' data-x='{$row->x}' data-y='{$row->y}'>{$row->map} {$row->x},{$row->y}</p></td>
							<td><img height='20' src='items_small/{$row->nameid}.png' title='{$item}' /></td>
							<td>{$nick}{$vvs}{$item}</td>
							<td>{$row->amount}</td>
							<td>{$row->price}z</td>
							<td>".refine_lvl($row->refine)."</td>
							<td>".get_item_name($row->card0)."</td>
							<td>".get_item_name($row->card1)."</td>
							<td>".get_item_name(($row->card2 > 255 && $row->card0 != 254) ? $row->card2:0)."</td>
							<td>".get_item_name($row->card3)."</td>
							</tr>";
						}
					}
					else
					{
						echo "<tr><td colspan=\"12\">Nothing was found</td></tr>";
					}
				?>
			</tbody>
		</table>
	</div>
</body>	