<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>WoE Stats</h2>

<?php if ($chars): ?>
<style>
	*:focus {
    outline: 0;
	}
	.tableview {
	cursor: pointer;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ffffff), color-stop(1, #e0e0e0) );
	background:-moz-linear-gradient( center top, #ffffff 5%, #e0e0e0 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#e0e0e0');
	background-color:#ffffff;
	-webkit-border-top-left-radius:0px;
	-moz-border-radius-topleft:0px;
	border-top-left-radius:0px;
	-webkit-border-top-right-radius:37px;
	-moz-border-radius-topright:37px;
	border-top-right-radius:37px;
	-webkit-border-bottom-right-radius:0px;
	-moz-border-radius-bottomright:0px;
	border-bottom-right-radius:0px;
	-webkit-border-bottom-left-radius:37px;
	-moz-border-radius-bottomleft:37px;
	border-bottom-left-radius:37px;
	text-indent:0;
	border:1px solid #000000;
	display:inline-block;
	color:#000000;
	font-family:Arial;
	font-size:15px;
	font-weight:bold;
	font-style:normal;
	height:65px;
	line-height:65px;
	width:113px;
	text-decoration:none;
	text-align:center;
	}
	.tableview:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #e0e0e0), color-stop(1, #ffffff) );
	background:-moz-linear-gradient( center top, #e0e0e0 5%, #ffffff 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#e0e0e0', endColorstr='#ffffff');
	background-color:#e0e0e0;
	}
	.tableview:active {
	position:relative;
	top:1px;
	}
	.tableview.active,.blocksview.active {
	border:1px solid #002bff;
	}
	.blocksview {
	cursor: pointer;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ffffff), color-stop(1, #e0e0e0) );
	background:-moz-linear-gradient( center top, #ffffff 5%, #e0e0e0 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#e0e0e0');
	background-color:#ffffff;
	-webkit-border-top-left-radius:37px;
	-moz-border-radius-topleft:37px;
	border-top-left-radius:37px;
	-webkit-border-top-right-radius:0px;
	-moz-border-radius-topright:0px;
	border-top-right-radius:0px;
	-webkit-border-bottom-right-radius:37px;
	-moz-border-radius-bottomright:37px;
	border-bottom-right-radius:37px;
	-webkit-border-bottom-left-radius:0px;
	-moz-border-radius-bottomleft:0px;
	border-bottom-left-radius:0px;
	text-indent:0;
	border:1px solid #000000;
	display:inline-block;
	color:#000000;
	font-family:Arial;
	font-size:15px;
	font-weight:bold;
	font-style:normal;
	height:65px;
	line-height:65px;
	width:113px;
	text-decoration:none;
	text-align:center;
	}
	.blocksview:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #e0e0e0), color-stop(1, #ffffff) );
	background:-moz-linear-gradient( center top, #e0e0e0 5%, #ffffff 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#e0e0e0', endColorstr='#ffffff');
	background-color:#e0e0e0;
	}.blocksview:active {
	position:relative;
	top:1px;
	}
	
</style>
<form action="<?php echo $this->url ?>" method="get" >
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<p>
		<label for="woe_date">WoE Date:</label>
		<select name="woe_date" id="woe_date">
			<?php
				foreach ($woe_list as $woe_date)
				{
					$selected = "";
					if(htmlspecialchars($params->get('woe_date')) == $woe_date->date) $selected = " selected";
					echo "<option value=\"{$woe_date->date}\"{$selected}>".date('D m.d',strtotime($woe_date->date))."</option>";
				}
			?>
		</select>
	</p>
	<p>
		<label for="char_name">Search by Character Name:</label>
		<input type="text" name="char_name" id="char_name" value="<?=htmlspecialchars($params->get('char_name'))?>" />
	</p>
	<p>
		<label for="guild_name">Search by Guild Name:</label>
		<input type="text" name="guild_name" id="guild_name" value="<?=htmlspecialchars($params->get('guild_name'))?>" />
	</p>
	<p>
		<input type="submit" value="Search" />
		<input type="button" value="Reset" onclick="reload()" />
	</p>
</form>


<form action="?<?php echo http_build_query($_GET); ?>" method="post" >
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<p style="text-align: center;">
		<button type="submit" name="view" value="Table" class="tableview <?php if(empty($_COOKIE['woe_stats_view']) || $_COOKIE['woe_stats_view'] == 'Table') { echo "active"; }?>" >Table View</button>
		<button type="submit" name="view" value="Blocks" class="blocksview <?php if($_COOKIE['woe_stats_view'] == 'Blocks') { echo "active"; }?>">Blocks View</button>
	</p>
</form>


<?php echo $paginator->infoText() ?>

<?php
	if(empty($_COOKIE['woe_stats_view']) || $_COOKIE['woe_stats_view'] == 'Table')
	{
	?>
	
	<table class="horizontal-table">
		<tr>
			<th></th>
			<th><?php echo $paginator->sortableColumn('name', 'Character') ?></th>
			<th><?php echo $paginator->sortableColumn('class', 'Class') ?></th>
			<th><?php echo $paginator->sortableColumn('base_level', 'B.level') ?></th>
			<th><?php echo $paginator->sortableColumn('job_level', 'J.level') ?></th>
			<th><?php echo $paginator->sortableColumn('kill_count', 'Kill Count') ?></th>
			<th><?php echo $paginator->sortableColumn('death_count', 'Death Count') ?></th>
			<th><?php echo $paginator->sortableColumn('date', 'WoE Date') ?></th>
			
		</tr>
		<?php foreach ($chars as $char): ?>
		<tr style="text-align: center;">
			<td width="24">
				<?php
					$_GET["guild_name"] = $char->g_name;
				?>
				<a href="?<?=http_build_query($_GET)?>" title="Filter by this guild: <? echo $char->g_name; ?>"><img src="<?php echo $this->emblem($char->guild_id) ?>" /></a>
			</td>
			<td>
				<a title="Full Character Stats" href="<?=$this->url('woe_stats', 'player', array('player_id' => $char->char_id,'woe_date' => htmlspecialchars($params->get('woe_date'))))?>"><?=htmlspecialchars($char->name)?></a>
			</td>
			<td>
				<?php if ($job=$this->jobClassText($char->class)): ?>
				<?php echo htmlspecialchars($job) ?>
				<?php else: ?>
				<span class="not-applicable">Unknown</span>
				<?php endif ?>
			</td>
			<td>
				<?php echo number_format($char->base_level) ?>
			</td>
			<td>
				<?php echo number_format($char->job_level) ?>
			</td>
			<td>
				<?php echo number_format($char->kill_count) ?>
			</td>
			<td>
				<?php echo number_format($char->death_count) ?>
			</td>
			<td>
				<?php echo date('D m.d',strtotime($char->date)) ?>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	
	<?php
	}
	else
	{
	?>
	
	<?php $i=0; foreach ($chars as $char): $i++;?>
	<table class="horizontal-table" style="text-align: center; margin-bottom: 15px;">
		<tr>
			<td rowspan="10">
				<h3><?=$i?></h3>
				<?php $sex = ($char->sex == 'M') ? 1:0; ?>
				<img src="./addons/woe_stats/char.php?gender=<?=$sex?>&viewid=<?=$char->head_top?>&location=512&job=<?=$char->class?>&hdye=<?=$char->hair_color?>&dye=<?=$char->clothes_color?>&hair=<?=$char->hair?>">
				<h2><a title="Full Character Stats" href="<?=$this->url('woe_stats', 'player', array('player_id' => $char->char_id,'woe_date' => htmlspecialchars($params->get('woe_date'))))?>"><?=htmlspecialchars($char->name)?></a></h2>
				<p>
					<?php
						$_GET["guild_name"] = $char->g_name;
					?>
					<a href="?<?=http_build_query($_GET)?>" title="Filter by this guild: <? echo $char->g_name; ?>"><img src="<?php echo $this->emblem($char->guild_id) ?>" /></a>
				</p>
			</td>
			<td colspan="3" style="font-weight: bold;background-color: #EBEBEB;">
				General statistics
			</td>
			<td colspan="3" style="font-weight: bold;background-color: #FFE7E7;">
				Damage vs Player
			</td>
		</tr>
		<tr>
			<td>
				<p style="font-weight: bold;">Score</p>
				<p><?=$char->score?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Kills</p>
				<p><?=$char->kill_count?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Deaths</p>
				<p><?=$char->death_count?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Top Damage</p>
				<p><?=$char->top_damage?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Damage Done</p>
				<p><?=$char->damage_done?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Damage Received</p>
				<p><?=$char->damage_received?></p>
			</td>
		</tr>
		<tr>
			<td colspan="6" style="font-weight: bold;background-color: #FFF0C8;">
				Damage and Structures
			</td>
		</tr>
		<tr>
			<td>
				<p style="font-weight: bold;">Emperium</p>
				<p><?=$char->emperium_damage?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Emperiums broken</p>
				<p><?=$char->emperium_kill?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Guardian Damage</p>
				<p><?=$char->guardian_damage?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Guardian Kill</p>
				<p><?=$char->guardian_kill?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Barricade Damage</p>
				<p><?=$char->barricade_damage?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Barricade Kill</p>
				<p><?=$char->barricade_kill?></p>
			</td>
		</tr>
		<tr>
			<td colspan="6" style="font-weight: bold;background-color: #E1FFDB;">
				Support and Healing
			</td>
		</tr>
		<tr>
			<td>
				<p style="font-weight: bold;">Support Skills Used</p>
				<p><?=$char->support_skills_used?></p>
			</td>
			<td colspan="2">
				<p style="font-weight: bold;">Wrong Support Skills Used</p>
				<p><?=$char->wrong_support_skills_used?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Healing Done</p>
				<p><?=$char->healing_done?></p>
			</td>
			<td colspan="2">
				<p style="font-weight: bold;">Wrong Healing Done</p>
				<p><?=$char->wrong_healing_done?></p>
			</td>
		</tr>
		<tr>
			<td colspan="6" style="font-weight: bold;background-color: #EBEBEB;">
				Consumption of Items
			</td>
		</tr>
		<tr>
			<td style="background-color: #E1FFDB;">
				<p style="font-weight: bold;">HP Heal Potions</p>
				<p><?=$char->hp_heal_potions?></p>
			</td>
			<td style="background-color: #D3CFFF;">
				<p style="font-weight: bold;">SP Heal Potions</p>
				<p><?=$char->sp_heal_potions?></p>
			</td>
			<td style="background-color: #D3CFFF;">
				<p style="font-weight: bold;">SP Used</p>
				<p><?=$char->sp_used?></p>
			</td>
			<td style="background-color: #FFE7E7;">
				<p style="font-weight: bold;">Red Gemstones</p>
				<p><?=$char->red_gemstones?></p>
			</td>
			<td style="background-color: #D3CFFF;">
				<p style="font-weight: bold;">Blue Gemstones</p>
				<p><?=$char->blue_gemstones?></p>
			</td>
			<td style="background-color: #FDFFCF;">
				<p style="font-weight: bold;">Yellow Gemstones</p>
				<p><?=$char->yellow_gemstones?></p>
			</td>
		</tr>
		<tr>
			<td>
				<p style="font-weight: bold;">Acid Demostration</p>
				<p><?=$char->acid_demostration?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Acid Demostration Fail</p>
				<p><?=$char->acid_demostration_fail?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Poison Bottles</p>
				<p><?=$char->poison_bottles?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Zeny Used</p>
				<p><?=$char->zeny_used?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Spirit Balls Used</p>
				<p><?=$char->spiritb_used?></p>
			</td>
			<td>
				<p style="font-weight: bold;">Ammo Used</p>
				<p><?=$char->ammo_used?></p>
			</td>
		</tr>
	</table>
	<?php endforeach ?>
	<?
	}
?>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Nothing was found on <?php echo htmlspecialchars($server->serverName) ?>. <a href="javascript:history.go(-1)">Go back</a>.</p>
<?php endif ?>