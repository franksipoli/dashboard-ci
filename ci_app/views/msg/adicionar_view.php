 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

		<form action="/msg/mensagem/save" method="post" class="form-horizontal">

			<?php 
				echo (validation_errors()) 
					? '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>' 
					: '';
			?>

			<div class="form-group">
				<label for="to" class="col-lg-2 control-label">Para:</label>
				<div class="col-lg-10">
					<ul>
						<?php foreach ($this->users as $u): ?>
						<li><label class="checkbox"><input type="checkbox" name="destinatarios[]" value="<?php echo $u->user_id ?>" <?php echo set_checkbox('destinatarios[]', $u->user_id ) ?>><?php echo $u->user_name ?></label></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>

			<div class="form-group">
				<label for="to" class="col-lg-2 control-label">Assunto:</label>
				<div class="col-lg-10">
					<input type="text" name="assunto" id="assunto" value="<?php echo set_value('assunto') ?>" class="form-control" minlength="5" maxlength="100" autocomplete="off">
				</div>
			</div>

			<div class="form-group">
				<label for="to" class="col-lg-2 control-label">Mensagem:</label>
				<div class="col-lg-10">
					<textarea class="form-control" id="mensagem" name="mensagem" ><?php echo set_value('mensagem') ?></textarea>
				</div>
			</div>

			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-10">
					<button type="submit" class="btn btn-primary">Enviar mensagem</button>
				</div>
			</div>

		</form>

		</div>
	</div>
 </div>