 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("cadgrl","entidade","visualizar")?>" class="btn btn-sm btn-info">Visualizar lista</a>
		</div>
	</div>
</div>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroEntidade" method="POST" action="<?php echo isset($entidade) ? makeUrl("cadgrl","entidade","update","?id=".$entidade->nidtbxent) : makeUrl("cadgrl","entidade","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Tipo</label>
                  <div class="col-lg-10">
                     <div class="radio">
                        <label>
                           <input type="radio" name="tipo_pessoa" value="f">Pessoa Física
                        </label>
                     </div>
                     <div class="radio">
                        <label>
                           <input type="radio" name="tipo_pessoa" value="j">Pessoa Jurídica
                        </label>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Matriz</label>
                  <div class="col-lg-10">
                     <select name="nidtbxent_pai" class="form-control">
                        <?php
                           foreach ($entidades as $entidade):
                              ?>
                                 <option value="<?php echo $entidade['nidtbxent']?>"><?php echo $entidade['nome']?></option>
                              <?php
                           endforeach;
                        ?>
                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Cadastro</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Buscar cadastro" data-action="<?php echo makeUrl("cadgrl", "cadastro", "buscarAjaxNomeCPF")?>" name="term" class="form-control" required="required" readonly="readonly" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Creci Jurídico</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Creci Jurídico" name="ccrecijuridico" class="form-control" required="required" value="<?php echo isset($entidade) ? $entidade->ccrecijuridico : $this->session->flashdata('ccrecijuridico')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default"><?php echo isset($entidade) ? "Salvar" : "Cadastrar"?></button>
                     <?php
                     	if (isset($entidade)){
                     		?>
                     		<a href="<?php echo makeUrl("cadgrl","entidade","visualizar")?>" class="btn btn-sm btn-info">Cancelar</a>
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