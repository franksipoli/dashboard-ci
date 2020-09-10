 <!-- Page content-->
 <div class="content-wrapper">
	<h3><?php echo $title ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">

		<form action="/msg/mensagem/save" method="post" class="form-horizontal">

			<h4><?php echo $this->msg->subject ?></h4>
			<p><small>Enviado por <?php echo $this->msg->sender_name ?> em <?php echo toUserDateTime($this->msg->send_date, TRUE) ?>.</small></p>

			<hr>

			<div><?php echo $this->msg->message ?></div>

			<hr>

			<div class="voltar"><a href="<?php echo makeUrl('msg','mensagem') ?>" class="btn btn-primary">Voltar para mensagens</a></div>

		</form>

		</div>
	</div>
 </div>