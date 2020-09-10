 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dcg","tipotelefone","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroTipoTelefone" method="POST" action="<?php echo isset($tipotelefone) ? makeUrl("dcg","tipotelefone","update","?id=".$tipotelefone->nidtbxttl) : makeUrl("dcg","tipotelefone","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Descrição</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Descrição" name="cdescrittl" class="form-control" required="required" value="<?php echo isset($tipotelefone) ? $tipotelefone->cdescrittl : $this->session->flashdata('cdescrittl')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($tipotelefone) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($tipotelefone)){
                     		?>
                     		<a href="<?php echo makeUrl("dcg","tipotelefone","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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