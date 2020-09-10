 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

		<form id="atendimento" action="/ate/atendimento/save" method="post" class="form-horizontal">

			<?php 
				echo (validation_errors()) 
					? '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>' 
					: '';
			?>

			<div class="form-group">
				<label for="tipo" class="col-lg-2 col-md-2 control-label">Tipo*:</label>
				<div class="col-lg-5 col-md-5">
					<select name="tipo" id="tipo" class="form-control" required="required">
						<?php
							foreach ($fin as $finalidade):
								?>
									<option value="<?php echo $finalidade->nidtbxfin?>"><?php echo $finalidade->cnomefin?></option>
								<?php
							endforeach;
						?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="nome" class="col-lg-2 col-md-2 control-label">Nome*:</label>
				<div class="col-lg-5 col-md-5">
					<input type="text" name="nome" id="nome" value="<?php echo set_value('nome') ?>" class="form-control" minlength="3" maxlength="100" required="required" autocomplete="off">
				</div>
			</div>

			<div class="form-group">
				<label for="telefone" class="col-lg-2 col-md-2 control-label">Telefone*:</label>
				<div class="col-lg-3 col-md-3">
					<input type="text" name="telefone" id="telefone" data-jmask="phone" value="<?php echo set_value('telefone') ?>" class="form-control" maxlength="15" required="required" autocomplete="off">
				</div>

				<div class="col-lg-2 col-md-2">
					<select name="telefone_tipo" id="telefone_tipo" class="form-control">
						<option value="">Selecione</option>
						<?php foreach ($this->telefone_tipo as $t): ?>
						<option value="<?php echo $t->nidtbxttl ?>"<?php echo set_select('telefone_tipo', $t->nidtbxttl) ?>><?php echo $t->cdescrittl ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="email" class="col-lg-2 col-md-2 control-label">E-mail:</label>
				<div class="col-lg-3 col-md-3">
					<input type="email" name="email" id="email" value="<?php echo set_value('email') ?>" class="form-control" minlength="5" maxlength="100" autocomplete="off">
				</div>
				<div class="col-lg-2 col-md-2">
					<select name="email_tipo" id="email_tipo" class="form-control">
						<option value="">Selecione</option>
						<?php foreach ($this->email_tipo as $e): ?>
						<option value="<?php echo $e->nidtbxtem ?>"<?php echo set_select('email_tipo', $e->nidtbxtem) ?>><?php echo $e->cdescritem ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="corretor" class="col-lg-2 col-md-2 control-label">Atendente*:</label>
				<div class="col-lg-5 col-md-5">
					<select name="corretor" id="corretor" required="required" class="form-control">
						<option value="">Selecione</option>
						<?php foreach ($this->users as $u): ?>
						<option value="<?php echo $u->user_id ?>"<?php echo set_select('corretor', $u->user_id) ?>><?php echo $u->user_name ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="como_chegou" class="col-lg-2 col-md-2 control-label">Como chegou:</label>
				<div class="col-lg-5 col-md-5">
					<select name="como_chegou" id="como_chegou" class="form-control">
						<option value="">Selecione</option>
						<?php foreach ($this->como_chegou as $ch): ?>
						<option value="<?php echo $ch->nidtbxchg ?>"<?php echo set_select('como_chegou', $ch->nidtbxchg) ?>><?php echo $ch->cdescrichg ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="obs" class="col-lg-2 col-md-2 control-label">Observações:</label>
				<div class="col-lg-5 col-md-5">
					<textarea class="form-control" id="obs" name="obs" ><?php echo set_value('obs') ?></textarea>
				</div>
			</div>


			<div class="form-group">
				<div class="col-lg-offset-2 col-md-offset-2 col-lg-10 col-md-10">
					<p><small>*Campos obrigatórios</small></p>
					<button type="submit" class="btn btn-primary">Inserir atendimento</button>
				</div>
			</div>

		</form>

		</div>
	</div>
 </div>