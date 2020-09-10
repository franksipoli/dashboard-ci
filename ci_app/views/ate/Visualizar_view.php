 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

		<form action="/ate/atendimento/save" method="post" class="form-horizontal">

			<h4><?php echo $this->ate->title ?></h4>
			<p><small>Registrado por <?php echo $this->ate->inome ?> em <?php echo toUserDateTime($this->ate->didata) ?>.</small></p>
			
			<?php if($this->ate->dudata): ?>
			<p><small>Última modificação por <?php echo $this->ate->unome ?> em <?php echo toUserDateTime($this->ate->dudata) ?>.</small></p>
			<?php endif; ?>

			<hr>

			

			<hr>

			<div class="voltar"><a href="<?php echo makeUrl('ate','atendimento') ?>" class="btn btn-primary">Voltar para atendimentos</a></div>

		</form>

		</div>
	</div>
 </div>