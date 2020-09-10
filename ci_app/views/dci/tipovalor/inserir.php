 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","tipovalor","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroTipoValor" method="POST" action="<?php echo isset($tipovalor) ? makeUrl("dci","tipovalor","update","?id=".$tipovalor->nidtbxtpv) : makeUrl("dci","tipovalor","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Descrição</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Descrição" name="cnometpv" class="form-control" required="required" value="<?php echo isset($tipovalor) ? $tipovalor->cnometpv : $this->session->flashdata('cnometpv')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Rótulo</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Rótulo" name="clabel" class="form-control" required="required" value="<?php echo isset($tipovalor) ? $tipovalor->clabel : $this->session->flashdata('clabel')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Finalidades</label>
                  <div class="col-lg-10">
                     <div class="row">
                        <div class="col-xs-12 col-sm-2">
                           <strong>Principal</strong>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                           <strong>Finalidade</strong>
                        </div>
                     </div>
                     <?php
                        foreach ($finalidades as $item):
                           ?>
                              <div class="row">
                                 <div class="col-xs-12 col-sm-2">
                                    <div class="checkbox">
                                       <label>
                                          <input type="checkbox"<?php echo isset($principais) && in_array($item->nidtbxfin, $principais) ? ' checked="checked"' : ''?> name="nprincipal[]" value="<?php echo $item->nidtbxfin?>">
                                       </label>
                                    </div>
                                 </div>
                                 <div class="col-xs-12 col-sm-2">
                                    <div class="checkbox">
                                       <label>
                                          <input type="checkbox"<?php echo isset($finalidades_escolhidas) && in_array($item->nidtbxfin, $finalidades_escolhidas) ? ' checked="checked"' : ''?> name="nidtbxfin[]" value="<?php echo $item->nidtbxfin?>">
                                          <?php echo $item->cnomefin?>
                                       </label>
                                    </div>
                                 </div>
                              </div>
                           <?php
                        endforeach;
                     ?>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($tipovalor) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($tipovalor)){
                     		?>
                     		<a href="<?php echo makeUrl("dci","tipovalor","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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