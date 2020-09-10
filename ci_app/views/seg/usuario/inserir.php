 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <!-- START panel-->
      <div class="panel panel-default">
         <div class="panel-body">
            <form class="form-horizontal" id="frmCadastroUsuario" method="POST" action="<?php echo makeUrl("seg","usuario","insert")?>">
               <?php
               		$this->load->view('general/messages');
               ?>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Tipo de usuário</label>
                  <div class="col-lg-10">
					  <select required="required" class="form-control" id="nidtbxtipousu" name="nidtbxtipousu">
					     <?php
					     	foreach ($tipos as $tipo){
					     		?>
					     			<option<?php echo $tipo->nidtbxsegtipo==$this->session->flashdata('tipo') ? " selected='selected'" : ""?> value="<?php echo $tipo->nidtbxsegtipo?>"><?php echo $tipo->cdescricao?></option>
					     		<?php
					     	}	
					     ?>
					  </select>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Nome</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Nome" name="cnome" class="form-control" required="required" value="<?php echo $this->session->flashdata('nome')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Usuário</label>
                  <div class="col-lg-10">
                     <input type="text" placeholder="Login" name="clogin" class="form-control" required="required" value="<?php echo $this->session->flashdata('login')?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Senha</label>
                  <div class="col-lg-10">
                     <input type="password" placeholder="Senha" name="senha" id="senha" class="form-control" required="required" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-lg-2 control-label">Repetir senha</label>
                  <div class="col-lg-10">
                     <input type="password" placeholder="Senha" name="csenha" id="csenha" class="form-control" required="required" />
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                     <button type="submit" class="btn btn-sm btn-default">Cadastrar</button>
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