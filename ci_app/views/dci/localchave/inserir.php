<!-- Page content-->
<div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","localchave","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroLocalChave" method="POST" action="<?php echo isset($localchave) ? makeUrl("dci","localchave","update","?id=".$localchave->nidtbxlch) : makeUrl("dci","localchave","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Nome</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Nome" name="cnomelch" class="form-control" required="required" value="<?php echo isset($localchave) ? $localchave->cnomelch : $this->session->flashdata('cnomelch')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Local com controle</label>
                  <div class="col-lg-10">
                     <div class="checkbox">
                        <label><input type="checkbox" name="ncontrole" value="1" <?php echo (isset($localchave) && $localchave->ncontrole) || $this->session->flashdata('ncontrole') ? " checked='checked'" : ""?>></label>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($localchave) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($localchave)){
                     		?>
                     		<a href="<?php echo makeUrl("dci","localchave","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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