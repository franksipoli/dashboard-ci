<!-- Page content-->
<div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","grupocaracteristica","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroGrupoCaracteristica" method="POST" action="<?php echo isset($grupo) ? makeUrl("dci","grupocaracteristica","update","?id=".$grupo->nidtbxgrc) : makeUrl("dci","grupocaracteristica","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Descrição</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Descrição" name="cnomegrc" class="form-control" required="required" value="<?php echo isset($grupo) ? $grupo->cnomegrc : $this->session->flashdata('cnomegrc')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Características</label>
                  <div class="col-lg-10">
                     <?php
                        foreach ($caracteristicas as $item):
                           ?>
                              <div class="checkbox">
                                 <label>
                                    <input type="checkbox"<?php echo isset($caracteristicas_selecionadas) && in_array($item->nidtbxcar, $caracteristicas_selecionadas) ? ' checked="checked"' : ''?> name="nidtbxcar[]" value="<?php echo $item->nidtbxcar?>">
                                    <?php echo $item->cnomecar?>
                                 </label>
                              </div>
                           <?php
                        endforeach;
                     ?>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($grupo) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($grupo)){
                     		?>
                     		<a href="<?php echo makeUrl("dci","grupocaracteristica","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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