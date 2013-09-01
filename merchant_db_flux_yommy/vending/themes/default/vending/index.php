<?php if (!defined('FLUX_ROOT')) exit; ?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
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
					return "<img class='map' src='addons/vending/modules/map/map.php?map="+$(this).data('map')+"&x="+$(this).data('x')+"&y="+$(this).data('y')+"'>";
				}
			}
		});
	});
</script>

<h2>Vending Database</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Search...</a></p>
<form action="<?php echo $this->url ?>" method="get" class="search-form">
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<p>
		<label for="item_name">Item Name or ID:</label>
		<input type="text" name="item_name" id="item_name" value="<?php echo htmlspecialchars($params->get('item_name')) ?>" />
		<input type="submit" value="Search" />
		<input type="button" value="Reset" onclick="reload()" />
	</p>
</form>

<p><?php echo @$search_info ?></p>
<?php if ($chars): ?>
<?php echo $paginator->infoText() ?>

<table class="horizontal-table">
	<tr>
		<th><?php echo $paginator->sortableColumn('shop', 'Shop') ?></th>
		<th><?php echo $paginator->sortableColumn('owner', 'Merchant') ?></th>
		<th>Position</th>
		<th colspan="2"><?php echo $paginator->sortableColumn('nameid', 'Item') ?></th>
		<th><?php echo $paginator->sortableColumn('amount', 'Amount') ?></th>
		<th><?php echo $paginator->sortableColumn('price', 'Price') ?></th>
		<th><?php echo $paginator->sortableColumn('refine', 'Refine') ?></th>
		<th><?php echo $paginator->sortableColumn('card0', 'Card(1)') ?></th>
		<th><?php echo $paginator->sortableColumn('card1', 'Card(2)') ?></th>
		<th><?php echo $paginator->sortableColumn('card2', 'Card(3)') ?></th>
		<th><?php echo $paginator->sortableColumn('card3', 'Card(4)') ?></th>
	</tr>
	<?php foreach ($chars as $char): ?>
	<?php
		$char->shop2 = $char->shop;
		$char->shop = mb_substr($char->shop,0, 10, "UTF-8")."...";
		
		$vvs = "";
		if ($char->card0 == 255 && intval($char->card1/1280) > 0)
		{
			for ($i = 0; $i < intval($char->card1/1280); $i++)
			{
				$vvs .= "Very ";
			}
			$vvs .= "Strong ";
			$vvs = "<span style='color: blue;'>{$vvs}</span> ";
		}	
	?>
	<tr>
		<td title="<?php echo htmlspecialchars($char->shop2) ?>">
			<?php echo htmlspecialchars($char->shop) ?>
		</td>
		<td>
			<?php echo htmlspecialchars($char->owner) ?>
		</td>
		<td>
			<span class='mapinfo' data-map='<?=$char->map?>' data-x='<?=$char->x?>' data-y='<?=$char->y?>'><?php echo htmlspecialchars($char->map)." ".htmlspecialchars($char->x).",".htmlspecialchars($char->y) ?></span>
		</td>
		<?php if ($icon=$this->iconImage($char->nameid)) ?>
		<td width="24"><img src="<?php echo htmlspecialchars($icon); ?>?nocache=<?php echo rand(); ?>" /></td>
		<td>
			<?php 
				$nick = "";
				if($char->card0 == 254) {  $nick_just = get_char_name($char->card2,$server); $nick = "<span style='color: blue;'>{$nick_just}'s</span> "; }
				echo $nick.$vvs;
				echo $this->linkToItem($char->nameid,get_item_name($char->nameid,$server));
			?>
		</td>
		<td>
			<?php echo number_format($char->amount) ?>
		</td>
		<td>
			<?php echo number_format($char->price) ?>
		</td>
		<td>
			<?php echo htmlspecialchars($refine[$char->refine]) ?>
		</td>
		<td>
			<?php echo $this->linkToItem($char->card0, get_item_name($char->card0,$server)) ?>
		</td>
		<td>
			<?php echo $this->linkToItem($char->card1, get_item_name($char->card1,$server)) ?>
		</td>
		<td>
			<?php echo $this->linkToItem($char->card2, get_item_name(($char->card2 > 255 && $char->card0 != 254) ? $char->card2:0,$server)) ?>
		</td>
		<td>
			<?php echo $this->linkToItem($char->card3, get_item_name($char->card3,$server)) ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Nothing was found on <?php echo htmlspecialchars($server->serverName) ?>. <a href="javascript:history.go(-1)">Go back</a>.</p>
<?php endif ?>