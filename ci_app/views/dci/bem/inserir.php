<!-- Page content-->
<div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","bem","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroBem" method="POST" action="<?php echo isset($bem) ? makeUrl("dci","bem","update","?id=".$bem->nidtbxbem) : makeUrl("dci","bem","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Descrição</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Descrição" name="cnomebem" class="form-control" required="required" value="<?php echo isset($bem) ? $bem->cnomebem : $this->session->flashdata('cnomebem')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Grupos</label>
                  <div class="col-lg-10 lista-grupos">
                     <?php
                        foreach ($grb as $item):
                           ?>
                              <div class="checkbox">
                                 <label>
                                    <input type="checkbox"<?php echo isset($grupos_escolhidos) && in_array($item->nidtbxgrb, $grupos_escolhidos) ? ' checked="checked"' : ''?> name="nidtbxgrb[]" value="<?php echo $item->nidtbxgrb?>">
                                    <?php echo $item->cnomegrb?>
                                    <input type="text" class="form-control" name="quantidade[<?php echo $item->nidtbxgrb?>]"<?php echo isset($quantidades[$item->nidtbxgrb]) ? ' value="'.$quantidades[$item->nidtbxgrb].'"' : ''?> placeholder="Quantidade padrão">
                                 </label>
                              </div>
                           <?php
                        endforeach;
                     ?>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($bem) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($bem)){
                     		?>
                     		<a href="<?php echo makeUrl("dci","bem","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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