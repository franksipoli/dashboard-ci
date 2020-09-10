 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","tipoimovel","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroTipoImovel" method="POST" action="<?php echo isset($tipoimovel) ? makeUrl("dci","tipoimovel","update","?id=".$tipoimovel->nidtbxtpi) : makeUrl("dci","tipoimovel","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Descrição</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Descrição" name="cnometpi" class="form-control" required="required" value="<?php echo isset($tipoimovel) ? $tipoimovel->cnometpi : $this->session->flashdata('cnometpi')?>" />
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
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($tipoimovel) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($tipoimovel)){
                     		?>
                     		<a href="<?php echo makeUrl("dci","tipoimovel","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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