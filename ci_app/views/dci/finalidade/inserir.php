<!-- Page content-->
<div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","finalidade","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroFinalidade" method="POST" action="<?php echo isset($finalidade) ? makeUrl("dci","finalidade","update","?id=".$finalidade->nidtbxfin) : makeUrl("dci","finalidade","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Descrição</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Descrição" name="cnomefin" class="form-control" required="required" value="<?php echo isset($finalidade) ? $finalidade->cnomefin : $this->session->flashdata('cnomefin')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Grupos de Características</label>
                  <div class="col-lg-10">
                     <?php
                        foreach ($grupos as $item):
                           ?>
                              <div class="checkbox">
                                 <label>
                                    <input type="checkbox"<?php echo isset($grupos_escolhidos) && in_array($item->nidtbxgrc, $grupos_escolhidos) ? ' checked="checked"' : ''?> name="nidtbxgrc[]" value="<?php echo $item->nidtbxgrc?>">
                                    <?php echo $item->cnomegrc?>
                                 </label>
                              </div>
                           <?php
                        endforeach;
                     ?>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Tipos de Contrato</label>
                  <div class="col-lg-10">
                     <?php
                        foreach ($con as $item):
                           ?>
                              <div class="checkbox">
                                 <label>
                                    <input type="checkbox"<?php echo isset($con_escolhidos) && in_array($item->nidtbxcon, $con_escolhidos) ? ' checked="checked"' : ''?> name="nidtbxcon[]" value="<?php echo $item->nidtbxcon?>">
                                    <?php echo $item->cnomecon?>
                                 </label>
                              </div>
                           <?php
                        endforeach;
                     ?>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($finalidade) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($finalidade)){
                     		?>
                     		<a href="<?php echo makeUrl("dci","finalidade","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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