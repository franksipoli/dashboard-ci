 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dep","tipodocumento","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroTipoDocumento" method="POST" action="<?php echo isset($tipodocumento) ? makeUrl("dep","tipodocumento","update","?id=".$tipodocumento->nidtbxtdo) : makeUrl("dep","tipodocumento","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Nome</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Nome" name="cnometdo" class="form-control" required="required" value="<?php echo isset($tipodocumento) ? $tipodocumento->cnometdo : $this->session->flashdata('cnometdo')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Obrigatório</label>
                  <div class="col-lg-10">
                     <div class="checkbox">
                        <label>
                           <input type="checkbox" name="nbloqueia" value="1" <?php echo isset($tipodocumento) && $tipodocumento->nbloqueia ? ' checked="checked"' : ''?>>
                        </label>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Aplicações</label>
                  <div class="col-lg-10">
                     <?php
                        foreach ($apps as $app):
                           ?>
                              <div class="checkbox">
                                 <label>
                                    <input type="checkbox"<?php echo isset($apps_escolhidos) && in_array($app->nidtbxapp, $apps_escolhidos) ? ' checked="checked"' : ''?> name="nidtbxapp[]" value="<?php echo $app->nidtbxapp?>">
                                    <?php echo $app->cname?>
                                 </label>
                              </div>
                           <?php
                        endforeach;
                     ?>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($tipodocumento) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($tipodocumento)){
                     		?>
                     		<a href="<?php echo makeUrl("dep","tipodocumento","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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