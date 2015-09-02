<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Player WoE Stats</h2>

<?php if ($char): ?>
<form action="?<?php echo http_build_query($_GET); ?>" method="get" >
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<input type="hidden" name="player_id" value="<?=$params->get('player_id')?>" />
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
		<input type="submit" value="Search" />
	</p>
</form>

<table class="horizontal-table" style="text-align: center; margin-bottom: 15px;">
	<tr>
		<td rowspan="10">
			<?php $sex = ($char->sex == 'M') ? 1:0; ?>
			<img src="./addons/woe_stats/char.php?gender=<?=$sex?>&viewid=<?=$char->head_top?>&location=512&job=<?=$char->class?>&hdye=<?=$char->hair_color?>&dye=<?=$char->clothes_color?>&hair=<?=$char->hair?>">
			<h2><?=htmlspecialchars($char->name)?></h2>
			<p><img title="<?=$char->g_name?>" src="<?=$this->emblem($char->guild_id)?>" /></p>
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


<?php if ($kills): ?>
<table class="horizontal-table" style="text-align: center; margin-bottom: 15px;">
	<tr>
		<th>
			#
		</th>
		<th>
			Victim
		</th>
		<th>
			Victim Class
		</th>
		<th>
			Map
		</th>
		<th>
			Skill
		</th>
		<th>
			Time
		</th>
	</tr>
	<?php $i=0; foreach ($kills as $kill): $i++;?>
	<tr>
		<td>
			<?=$i?>
		</td>
		<td>
			<a title="Open this Character Stats" href="<?=$this->url('woe_stats', 'player', array('player_id' => $kill->killed_id,'woe_date' => htmlspecialchars($params->get('woe_date'))))?>"><?php echo htmlspecialchars($kill->name) ?></a>
		</td>
		<td>
			<?php echo $this->jobClassText($kill->class) ?>
		</td>
		<td>
			<?php echo $kill->map ?>
		</td>
		<td>
			<?php if($kill->skill > 0) echo $skills[$kill->skill]; else echo "No Skill"; ?>
		</td>
		<td>
			<?php echo $kill->time ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php endif ?>

<?php if ($deaths): ?>
<table class="horizontal-table" style="text-align: center; margin-bottom: 15px;">
	<tr>
		<th>
			#
		</th>
		<th>
			Killer
		</th>
		<th>
			Killer Class
		</th>
		<th>
			Map
		</th>
		<th>
			Skill
		</th>
		<th>
			Time
		</th>
	</tr>
	<?php $i=0; foreach ($deaths as $death): $i++;?>
	<tr>
		<td>
			<?=$i?>
		</td>
		<td>
			<a title="Open this Character Stats" href="<?=$this->url('woe_stats', 'player', array('player_id' => $death->killer_id,'woe_date' => htmlspecialchars($params->get('woe_date'))))?>"><?php echo htmlspecialchars($death->name) ?></a>
		</td>
		<td>
			<?php echo $this->jobClassText($death->class) ?>
		</td>
		<td>
			<?php echo $death->map ?>
		</td>
		<td>
			<?php if($death->skill > 0) echo $skills[$death->skill]; else echo "No Skill"; ?>
		</td>
		<td>
			<?php echo $death->time ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php endif ?>

<?php else: ?>
<p>Player was not found on <?php echo htmlspecialchars($server->serverName) ?>. <a href="javascript:history.go(-1)">Go back</a>.</p>
<?php endif ?>