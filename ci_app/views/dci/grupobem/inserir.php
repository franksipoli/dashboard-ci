<!-- Page content-->
<div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","grupobem","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroGrupoBem" method="POST" action="<?php echo isset($grb) ? makeUrl("dci","grupobem","update","?id=".$grb->nidtbxgrb) : makeUrl("dci","grupobem","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Descrição</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Descrição" name="cnomegrb" class="form-control" required="required" value="<?php echo isset($grb) ? $grb->cnomegrb : $this->session->flashdata('cnomegrb')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Cor</label>
                  <div class="col-lg-10">
                     <div class="bfh-colorpicker" data-name="ccor" data-color="<?php echo isset($grb) ? $grb->ccor : $this->session->flashdata('ccor')?>">
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($grb) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($grb)){
                     		?>
                     		<a href="<?php echo makeUrl("dci","grupobem","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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