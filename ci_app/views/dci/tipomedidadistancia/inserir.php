<!-- Page content-->
<div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","tipomedidadistancia","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroTipoMedidaDistancia" method="POST" action="<?php echo isset($tipomedidadistancia) ? makeUrl("dci","tipomedidadistancia","update","?id=".$tipomedidadistancia->nidtbxtmd) : makeUrl("dci","tipomedidadistancia","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Descrição</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Descrição" name="cnometmd" class="form-control" required="required" value="<?php echo isset($tipomedidadistancia) ? $tipomedidadistancia->cnometmd : $this->session->flashdata('cnometmd')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Sigla</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Sigla" name="csiglatmd" class="form-control" required="required" value="<?php echo isset($tipomedidadistancia) ? $tipomedidadistancia->csiglatmd : $this->session->flashdata('csiglatmd')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($tipomedidadistancia) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($tipomedidadistancia)){
                     		?>
                     		<a href="<?php echo makeUrl("dci","tipomedidadistancia","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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