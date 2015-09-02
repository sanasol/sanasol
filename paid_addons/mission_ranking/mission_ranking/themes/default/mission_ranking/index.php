<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Mission Ranking</h2>

<?php if ($chars): ?>

<form action="<?php echo $this->url ?>" method="get" >
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<p>
		<label for="char_name">Search by Character Name:</label>
		<input type="text" name="char_name" id="char_name" value="<?=htmlspecialchars($params->get('char_name'))?>" />
	</p>
	<p>
		<input type="submit" value="Search" />
		<input type="button" value="Reset" onclick="reload()" />
	</p>
</form>

<?php echo $paginator->infoText() ?>

	<table class="horizontal-table">
		<tr>
			<th></th>
			<th><?php echo $paginator->sortableColumn('name', 'Character') ?></th>
			<th><?php echo $paginator->sortableColumn('class', 'Class') ?></th>
			<th><?php echo $paginator->sortableColumn('base_level', 'B.level') ?></th>
			<th><?php echo $paginator->sortableColumn('job_level', 'J.level') ?></th>
			<th><?php echo $paginator->sortableColumn('completed', 'Missions Accomplished') ?></th>
			
		</tr>
		<?php foreach ($chars as $char): ?>
		<tr style="text-align: center;">
			<td width="24">
				<img src="<?php echo $this->emblem($char->guild_id) ?>" title="<? echo $char->g_name; ?>" />
			</td>
			<td>
				<a title="Full Character Stats" href="<?=$this->url('mission_ranking', 'player', array('player_id' => $char->char_id))?>"><?=htmlspecialchars($char->name)?></a>
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
				<?php echo number_format($char->completed) ?>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Nothing was found on <?php echo htmlspecialchars($server->serverName) ?>. <a href="javascript:history.go(-1)">Go back</a>.</p>
<?php endif ?>