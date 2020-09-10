<!-- Page content-->
<div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dci","tiposecundarioimovel","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroTipoSecundarioImovel" method="POST" action="<?php echo isset($tiposecundarioimovel) ? makeUrl("dci","tiposecundarioimovel","update","?id=".$tiposecundarioimovel->nidtbxtp2) : makeUrl("dci","tiposecundarioimovel","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Descrição</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Descrição" name="cnometp2" class="form-control" required="required" value="<?php echo isset($tiposecundarioimovel) ? $tiposecundarioimovel->cnometp2 : $this->session->flashdata('cnometp2')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Tipos primários</label>
                  <div class="col-lg-10">
                     <?php
                        foreach ($tpi as $item):
                           ?>
                              <div class="checkbox">
                                 <label>
                                    <input type="checkbox"<?php echo isset($tipos_selecionados) && in_array($item->nidtbxtpi, $tipos_selecionados) ? ' checked="checked"' : ''?> name="nidtbxtpi[]" value="<?php echo $item->nidtbxtpi?>">
                                    <?php echo $item->cnometpi?>
                                 </label>
                              </div>
                           <?php
                        endforeach;
                     ?>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($tiposecundarioimovel) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($tiposecundarioimovel)){
                     		?>
                     		<a href="<?php echo makeUrl("dci","tiposecundarioimovel","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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