<?php
$erro = $this->session->flashdata('erro');
if ($erro){
	?>
	<p class="alert alert-danger temp-message"><?php echo $erro?></p>
	<?php
}
$sucesso = $this->session->flashdata('sucesso');
if ($sucesso){
	?>
	<p class="alert alert-success temp-message"><?php echo $sucesso?></p>
	<?php
}
?>