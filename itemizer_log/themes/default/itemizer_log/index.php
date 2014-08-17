<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Itemizer</h2>

<?php if ($chars): ?>

<form action="<?php echo $this->url ?>" method="get" >
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<p>
		<label for="char_name">Search by Character Name:</label>
		<input type="text" name="char_name" id="char_name" value="<?=htmlspecialchars($params->get('char_name'))?>" />
	</p>
	<p>
		<label for="gm_name">Search by GM Name:</label>
		<input type="text" name="gm_name" id="gm_name" value="<?=htmlspecialchars($params->get('gm_name'))?>" />
	</p>
	<p>
		<input type="submit" value="Search" />
		<input type="button" value="Reset" onclick="reload()" />
	</p>
</form>

<?php echo $paginator->infoText() ?>

	<table class="horizontal-table">
		<tr>
			<th><?php echo $paginator->sortableColumn('char_name', 'Character') ?></th>
			<th><?php echo $paginator->sortableColumn('item_name', 'Item') ?></th>
			<th><?php echo $paginator->sortableColumn('item_amount', 'Amount') ?></th>
			<th><?php echo $paginator->sortableColumn('reason', 'Reason') ?></th>
			<th><?php echo $paginator->sortableColumn('by_gm', 'GM') ?></th>
			<th><?php echo $paginator->sortableColumn('when', 'Date') ?></th>
			
		</tr>
		<?php foreach ($chars as $char): ?>
		<tr style="text-align: center;">
			<td>
				<?=htmlspecialchars($char->char_name)?>
			</td>
			<td>
				<?php echo $char->item_name ?>
			</td>
			<td>
				<?php echo number_format($char->item_amount) ?>
			</td>
			<td>
				<?php echo $char->reason ?>
			</td>
			<td>
				<?php echo $char->by_gm ?>
			</td>
			<td>
				<?php echo $char->when ?>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Nothing was found on <?php echo htmlspecialchars($server->serverName) ?>. <a href="javascript:history.go(-1)">Go back</a>.</p>
<?php endif ?>