<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Spearman Mercenary Ranking</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Search...</a></p>
<form action="<?php echo $this->url ?>" method="get" class="search-form">
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<p>
		<label for="char_name">Character Name or ID:</label>
		<input type="text" name="char_name" id="char_name" value="<?php echo htmlspecialchars($params->get('char_name')) ?>" />
		<input type="submit" value="Search" />
		<input type="button" value="Reset" onclick="reload()" />
	</p>
</form>

<?php if ($chars): ?>
<?php echo $paginator->infoText() ?>

<table class="horizontal-table">
	<tr>
		<th><?php echo "Rank"; ?></th>
		<th></th>
		<th><?php echo $paginator->sortableColumn('name', 'Character') ?></th>
		<th><?php echo $paginator->sortableColumn('spear_faith', 'Loyalty') ?></th>
		<th><?php echo $paginator->sortableColumn('spear_calls', 'Contracts') ?></th>
		<th><?php echo $paginator->sortableColumn('class', 'Class') ?></th>
		<th><?php echo $paginator->sortableColumn('base_level', 'B.level') ?></th>
		<th><?php echo $paginator->sortableColumn('job_level', 'J.level') ?></th>
	</tr>
	<?php
		$rank = 0;
	foreach ($chars as $char): ?>
	<tr>
		<td>
			<?php $rank++; echo $rank ?>
		</td>
		<td width="24">
				<img title="<? echo $char->g_name; ?>" src="<?php echo $this->emblem($char->guild_id) ?>" />
		</td>
		<td>
			<?php if ($auth->actionAllowed('character', 'view') && $auth->allowedToViewCharacter): ?>
			<?php echo $this->linkToCharacter($char->char_id, $char->name) ?>
			<?php else: ?>
			<?php echo htmlspecialchars($char->name) ?>
			<?php endif ?>
		</td>
		<td>
			<?php echo number_format($char->spear_faith) ?>
		</td>
		<td>
			<?php echo number_format($char->spear_calls) ?>
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