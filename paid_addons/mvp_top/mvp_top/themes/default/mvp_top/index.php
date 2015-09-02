<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>MvP Ranking</h2>

<?php if ($chars): ?>
<?php echo $paginator->infoText() ?>

<table class="horizontal-table">
	<tr>
		<th>Rank</th>
		<th></th>
		<th><?php echo $paginator->sortableColumn('name', 'Character') ?></th>
		<th><?php echo $paginator->sortableColumn('amount', 'MvP Killed') ?></th>
		<th><?php echo $paginator->sortableColumn('class', 'Class') ?></th>
		<th><?php echo $paginator->sortableColumn('base_level', 'B.level') ?></th>
		<th><?php echo $paginator->sortableColumn('job_level', 'J.level') ?></th>
	</tr>
	<?php $rank = 0; foreach ($chars as $char): ?>
	<tr style="text-align: center;">
		<td><?php $rank++; echo $rank ?></td>
		<td><img title="<? echo $char->g_name; ?>" src="<?php echo $this->emblem($char->guild_id) ?>" /></td>
		<td>
			<?php if ($auth->actionAllowed('character', 'view') && $auth->allowedToViewCharacter): ?>
			<?php echo $this->linkToCharacter($char->char_id, $char->name) ?>
			<?php else: ?>
			<?php echo htmlspecialchars($char->name) ?>
			<?php endif ?>
		</td>
		<td>
			<?php echo number_format($char->amount) ?>
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
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Nothing was found on <?php echo htmlspecialchars($server->serverName) ?>. <a href="javascript:history.go(-1)">Go back</a>.</p>
<?php endif ?>