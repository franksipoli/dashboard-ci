 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("cadimo","tipocontrato","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroTipoContrato" method="POST" action="<?php echo isset($tipocontrato) ? makeUrl("cadimo","tipocontrato","update","?id=".$tipocontrato->nidtbxcon) : makeUrl("cadimo","tipocontrato","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>

               <div class="form-group">
                  <label class="col-lg-2 control-label">Código</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Código" name="ccodcon" class="form-control" required="required" value="<?php echo isset($tipocontrato) ? $tipocontrato->ccodcon : $this->session->flashdata('ccodcon')?>" />
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-lg-2 control-label">Descrição</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Descrição" name="cnomecon" class="form-control" required="required" value="<?php echo isset($tipocontrato) ? $tipocontrato->cnomecon : $this->session->flashdata('cnomecon')?>" />
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-lg-2 control-label">Conteúdo</label>
                  <div class="col-lg-10">
                     <div data-role="editor-toolbar" data-target="#editor" class="btn-toolbar btn-editor">
                        <div class="btn-group">
                           <a data-edit="bold" data-toggle="tooltip" title="Bold (Ctrl/Cmd+B)" class="btn btn-default">
                              <em class="fa fa-bold"></em>
                           </a>
                           <a data-edit="italic" data-toggle="tooltip" title="Italic (Ctrl/Cmd+I)" class="btn btn-default">
                              <em class="fa fa-italic"></em>
                           </a>
                           <a data-edit="underline" data-toggle="tooltip" title="Underline (Ctrl/Cmd+U)" class="btn btn-default">
                              <em class="fa fa-underline"></em>
                           </a>
                        </div>
                     </div>
                     <div style="overflow:scroll; height:450px;max-height:450px" class="form-control wysiwyg mt-lg"><?php echo isset($tipocontrato) ? $tipocontrato->tconteudo : $this->session->flashdata('tconteudo')?></div>
                  </div>
               </div>

               <input type="hidden" name="tconteudo" id="recebe-wysiwyg">

               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($tipocontrato) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($tipocontrato)){
                     		?>
                     		<a href="<?php echo makeUrl("cadimo","tipocontrato","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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