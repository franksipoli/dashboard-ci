<!-- Page content-->
<div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","tipomidia","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroTipoMidia" method="POST" action="<?php echo isset($tipomidia) ? makeUrl("dci","tipomidia","update","?id=".$tipomidia->nidtbxmid) : makeUrl("dci","tipomidia","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Nome</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Nome" name="cnomemid" class="form-control" required="required" value="<?php echo isset($tipomidia) ? $tipomidia->cnomemid : $this->session->flashdata('cnomemid')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Descrição</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Descrição" name="cdescrimid" class="form-control" required="required" value="<?php echo isset($tipomidia) ? $tipomidia->cdescrimid : $this->session->flashdata('cdescrimid')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Largura</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Largura" name="nwidth" class="form-control" required="required" value="<?php echo isset($tipomidia) ? $tipomidia->nwidth : $this->session->flashdata('nwidth')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Altura</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Altura" name="nheight" class="form-control" required="required" value="<?php echo isset($tipomidia) ? $tipomidia->nheight : $this->session->flashdata('nheight')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Largura (thumbnail)</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Largura" name="nwidththu" class="form-control" required="required" value="<?php echo isset($tipomidia) ? $tipomidia->nwidththu : $this->session->flashdata('nwidththu')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Altura (thumbnail)</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Altura" name="nheightthu" class="form-control" required="required" value="<?php echo isset($tipomidia) ? $tipomidia->nheightthu : $this->session->flashdata('nheightthu')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Pasta</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Pasta" name="cfoldermid" class="form-control" required="required" value="<?php echo isset($tipomidia) ? $tipomidia->cfoldermid : $this->session->flashdata('cfoldermid')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($tipomidia) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($tipomidia)){
                     		?>
                     		<a href="<?php echo makeUrl("dci","tipomidia","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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