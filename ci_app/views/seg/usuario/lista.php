<!-- Page content-->
<div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
   <div class="col-xs-12">
      <div class="panel panel-default">
         <div class="panel-body">
         	<?php
           		$this->load->view('general/messages');
           ?>
            <div class="table-responsive">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Tipo de Usuário</th>
                        <th>Nome</th>
                        <th>Usuário</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	$i = 1;
                  	foreach ($usuarios as $usuario){
                  		/**
						 * TODO: excluir, como será o procedimento
						 */
                  		?>
		                     <tr>
		                        <td><?php echo $i?></td>
		                        <td><?php echo Segusuariotipo_model::getById($usuario->nidtbxtipousu)->cdescricao?></td>
		                        <td><?php echo $usuario->cnome?></td>
		                        <td><?php echo $usuario->clogin?></td>
		                        <td>
		                        	<button type="button" class="btn btn-square btn-info btn-xs">Editar</button>
		                        	<button type="button" class="btn btn-square btn-danger btn-xs">Remover</button>
		                        </td>
		                     </tr>
                  		<?php
                  		$i++;
                  	}
                  	?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- END row-->
</div>