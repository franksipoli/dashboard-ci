 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dep","uf","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroUf" method="POST" action="<?php echo isset($uf) ? makeUrl("dep","uf","update","?id=".$uf->nidtbxuf) : makeUrl("dep","uf","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                 <label class="col-lg-2 control-label">País</label>
                 <div class="col-lg-2">
                  	 <select class="form-control" name="nidtbxpas">
						<?php
							foreach ($lista_paises as $key=>$value){
								?>
									<option value="<?php echo $value->nidtbxpas?>"<?php echo (isset($uf) && $uf->nidtbxpas==$value->nidtbxpas) || $this->session->flashdata('nditbxpas') == $value->nidtbxpas ? ' selected="selected"' : "" ?>><?php echo $value->cdescripas?></option>
								<?php
							}
						?>
                  	 </select>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Sigla</label>
                  <div class="col-lg-2">
                     <input type="text" placeholder="Sigla" name="csiglauf" class="form-control" required="required" value="<?php echo isset($uf) ? $uf->csiglauf : $this->session->flashdata('csiglauf')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Descrição</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Descrição" name="cdescriuf" class="form-control" required="required" value="<?php echo isset($uf) ? $uf->cdescriuf : $this->session->flashdata('cdescriuf')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($uf) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($uf)){
                     		?>
                     		<a href="<?php echo makeUrl("dep","uf","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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