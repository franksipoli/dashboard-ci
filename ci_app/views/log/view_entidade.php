<h4>Log</h4>
<table class="table table-condensed table-striped">
	<?php
	foreach ($results as $log):
		?>
			<tr>
				<th width="10%"><?php echo toUserDateTime($log->dtdata)?></th>
				<td width="15%">
					<?php echo $log->usuario?>
				</td>
				<td>
					<?php echo $log->cacao?>
				</td>
			</tr>
		<?php
	endforeach;
	?>
</table>