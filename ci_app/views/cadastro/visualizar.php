 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

			<h4><?php echo $this->cad->cnomegrl ?></h4>
			<p>
				<small>
					Cadastrado em <?php echo toUserDateTime($this->cad->datacriacao) ?>
					<?php if($this->cad->ddataatualizacao) echo '<br>última atualização em '.toUserDateTime($this->cad->ddataatualizacao); ?>
				.</small>
			</p>

			<hr>

			<table class="table">
				<?php if($this->cad->cnomegrl) echo '<tr><th>Nome:</th><td>'.$this->cad->cnomegrl.'</td></tr>' ?>
				<?php if($this->cad->ccpfcnpj) echo '<tr><th>CPF / CNPJ:</th><td>'.$this->cad->ccpfcnpj.'</td></tr>' ?>
				<?php if($this->cad->crgie) echo '<tr><th>Inscr. Est:</th><td>'.$this->cad->crgie.'</td></tr>' ?>
				<?php if($this->cad->ccreci) echo '<tr><th>CRECI:</th><td>'.$this->cad->ccreci.'</td></tr>' ?>
				<?php if($this->cad->crgie) echo '<tr><th>Observações:</th><td>'.$this->cad->cobs.'</td></tr>' ?>
			</table>

			<hr>

			<div class="row">
				<div class="voltar col-lg-3"><a href="<?php echo makeUrl('cadgrl','cadastro','listar') ?>" class="btn btn-default">Voltar para cadastros</a></div>
				<div class="editar col-lg-2 pull-right"><a href="<?php echo makeUrl('cadgrl','cadastro','editar') ?>" class="btn btn-primary">Editar cadastro</a></div>
			</div>

		</div>
	</div>
 </div>