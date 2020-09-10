<div class="panel panel-dark panel-flat">
<div class="panel-heading text-center">
   <a href="#">
      <img src="<?php echo base_url("assets/app/img/logo_cabeca.png")?>" alt="Image" class="block-center img-rounded">
   </a>
</div>
<div class="panel-body">
   <?php
      $sucesso = $this->session->flashdata('sucesso');
   	  $erro = $this->session->flashdata('erro');
   	  if (!empty($erro)){
   	  	?>
   	  	<p class="alert alert-danger temp-message"><?php echo $erro?></p>
   	  	<?php
   	  }
	  if (!empty($sucesso)){
   	  	?>
   	  	<p class="alert alert-success temp-message"><?php echo $sucesso?></p>
   	  	<?php
   	  }
   ?>
   <p class="text-center pv">FAÇA LOGIN PARA CONTINUAR.</p>
   <form role="form" action="<?php echo makeUrl('seg/login/login')?>" method="POST" data-parsley-validate="" novalidate="" class="mb-lg">
      <div class="form-group has-feedback">
         <input id="exampleInputLogin1" type="text" placeholder="Seu login" name="login" autocomplete="off" required class="form-control">
         <span class="fa fa-envelope form-control-feedback text-muted"></span>
      </div>
      <div class="form-group has-feedback">
         <input id="exampleInputPassword1" type="password" placeholder="Sua senha" name="senha" required class="form-control">
         <span class="fa fa-lock form-control-feedback text-muted"></span>
      </div>
      <button type="submit" class="btn btn-block btn-primary mt-lg">Entrar</button>
   </form>
</div>
 </div>