 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","statusimovel","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroStatusImovel" method="POST" action="<?php echo isset($statusimovel) ? makeUrl("dci","statusimovel","update","?id=".$statusimovel->nidtbxsti) : makeUrl("dci","statusimovel","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                   <label class="col-lg-2 control-label">Finalidade</label>
                   <div class="col-lg-10">
                     <select name="nidtbxfin" class="form-control">
                         <?php
                             foreach ($finalidades as $finalidade):
                                 ?> 
                                     <option value="<?php echo $finalidade->nidtbxfin?>" <?php echo isset($statusimovel) && $statusimovel->nidtbxfin == $finalidade->nidtbxfin ? 'selected="selected"' : ''?>><?php echo $finalidade->cnomefin?></option>
                                 <?php
                             endforeach;
                         ?>
                     </select>
                   </div>
                </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Descrição</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Descrição" name="cdescristi" class="form-control" required="required" value="<?php echo isset($statusimovel) ? $statusimovel->cdescristi : $this->session->flashdata('cdescristi')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($statusimovel) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($statusimovel)){
                     		?>
                     		<a href="<?php echo makeUrl("dci","statusimovel","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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