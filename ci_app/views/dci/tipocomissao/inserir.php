 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","tipocomissao","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroTipoComissao" method="POST" action="<?php echo isset($tipocomissao) ? makeUrl("dci","tipocomissao","update","?id=".$tipocomissao->nidtbxtcm) : makeUrl("dci","tipocomissao","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Descrição</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Descrição" name="cdescritcm" class="form-control" required="required" value="<?php echo isset($tipocomissao) ? $tipocomissao->cdescritcm : $this->session->flashdata('cdescritcm')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Principal</label>
                  <div class="col-lg-10">
                     <div class="checkbox">
                        <label>
                           <input type="checkbox" name="nprincipal" value="1" <?php echo isset($tipocomissao) && $tipocomissao->nprincipal ? 'checked="checked"' : ''?>>
                        </label>
                     </div>
                  </div>
               </div>
               <?php
               foreach ($finalidades as $finalidade):
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Valor Padrão (<?php echo $finalidade->cnomefin?>)</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Valor padrão" data-jmask="number" name="nvalorpadrao[<?php echo $finalidade->nidtbxfin?>]" class="form-control" required="required" value="<?php echo isset($valores[$finalidade->nidtbxfin]) ? $valores[$finalidade->nidtbxfin] : ""?>" />
                  </div>
               </div>
               <?php
               endforeach;
               ?>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($tipocomissao) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($tipocomissao)){
                     		?>
                     		<a href="<?php echo makeUrl("dci","tipocomissao","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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