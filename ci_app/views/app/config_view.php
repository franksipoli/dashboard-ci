<!-- Page content-->
<div class="content-wrapper">
	<h3><?php echo $title?></h3>
	<div class="row">
		<div class="col-xs-12">
			<div class="form-group">
				<a href="<?php echo makeUrl("app/app","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="<?php echo makeUrl("app/app","update",$app_id)?>" method="POST">
						<?php
               				$this->load->view('general/messages');
               			?>
						<table class="table table-striped table-hover datatable">
							<thead>
								<tr>
									<th>Campo</th>
									<th>Obrigatório</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($fields as $field): ?>
									<tr>
										<td><?php echo $field->field_label ?></td>
										<td>
											<input type="checkbox" name="required[<?php echo $field->nidtagfld?>]" <?php echo $field->required == 1 ? " checked=\"checked\"" : ""?> value="1">
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<br />
						<div class="form-group">
							<button type="submit" class="btn btn-sm btn-default">Salvar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>