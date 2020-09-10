 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dcg","banco","visualizar")?>" class="btn btn-sm btn-info">Visualizar banco</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroBanco" enctype="multipart/form-data" method="POST" action="<?php echo isset($banco) ? makeUrl("dcg","banco","update","?id=".$banco->nidtbxbco) : makeUrl("dcg","banco","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Nome</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Nome" name="cnomebco" class="form-control" required="required" value="<?php echo isset($banco) ? $banco->cnomebco : $this->session->flashdata('cnomebco')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Código</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Código" name="ccodigo" class="form-control" value="<?php echo isset($banco) ? $banco->ccodigo : $this->session->flashdata('ccodigo')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Ícone</label>
                  <div class="col-lg-10">
                     <input type="file" name="userfile" class="form-control" />
                  </div>
               </div>
               <?php
               if ($banco->cicone):
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Ícone atual</label>
                  <div class="col-lg-10">
                     <img src="<?php echo base_url("assets/app/img/banco/".$banco->cicone)?>" style="max-width: 200px; height: auto;">
                     <br/><br/>
                     <a href="<?php echo makeUrl("dcg", "banco", "excluiricone", $banco->nidtbxbco)?>" class="btn btn-xs btn-warning">Excluir ícone</a>
                  </div>
               </div>
               <?php
               endif;
               ?>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($banco) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($banco)){
                     		?>
                     		<a href="<?php echo makeUrl("dcg","banco","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
                     		<?php
                     	}
                     ?>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <!-- END panel-->
   </div>
</div>
<!-- END row-->
<!-- END panel-->
</div>