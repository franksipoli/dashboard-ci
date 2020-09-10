 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("adm","parametro","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroParametro" method="POST" action="<?php echo isset($parametro) ? makeUrl("adm","parametro","update","?id=".$parametro->nidtbxprm) : makeUrl("adm","parametro","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Chave</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Chave" name="cchave" class="form-control" required="required" value="<?php echo isset($parametro) ? $parametro->cchave : $this->session->flashdata('cchave')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Valor</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Valor" name="cvalor" class="form-control" required="required" value="<?php echo isset($parametro) ? $parametro->cvalor : $this->session->flashdata('cvalor')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($parametro) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($parametro)){
                     		?>
                     		<a href="<?php echo makeUrl("adm","parametro","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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