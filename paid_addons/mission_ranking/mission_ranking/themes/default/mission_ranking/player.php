<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Player Mission Stats</h2>

<?php if ($missions): ?>
<?php $sex = ($missions[0]->sex == 'M') ? 1:0; ?>
<p style="text-align: center;"><img src="./addons/mission_ranking/char.php?gender=<?=$sex?>&viewid=<?=$missions[0]->head_top?>&location=512&job=<?=$missions[0]->class?>&hdye=<?=$missions[0]->hair_color?>&dye=<?=$missions[0]->clothes_color?>&hair=<?=$missions[0]->hair?>"></p>
<h2 style="text-align: center;"><?=htmlspecialchars($missions[0]->name)?></h2>
<p style="text-align: center;"><img title="<?=$missions[0]->g_name?>" src="<?=$this->emblem($missions[0]->guild_id)?>" /></p>


<table class="horizontal-table" style="text-align: center; margin-bottom: 15px;">
	<tr>
		<th>
			#
		</th>
		<th colspan="2">
			Mission
		</th>
		<th>
			Time
		</th>
	</tr>
	<?php $i=0; foreach ($missions as $mission): $i++;?>
	<tr>
		<td>
			<?=$i?>
		</td>
		<td>
			<?php echo $mission->title ?>
		</td>
		<td>
			<?php echo $mission->desc ?>
		</td>
		<td>
			<?php echo $mission->completion ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>

<?php else: ?>
<p>Player was not found on <?php echo htmlspecialchars($server->serverName) ?>. <a href="javascript:history.go(-1)">Go back</a>.</p>
<?php endif ?>