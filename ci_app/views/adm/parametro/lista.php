 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("adm","parametro","inserir")?>" class="btn btn-sm btn-success">Inserir novo parâmetro</a>
		</div>
	</div>
</div>
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
                        <th>Chave</th>
                        <th>Valor</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	$i = 1;
                  	foreach ($parametros as $parametro){
                  		?>
		                     <tr>
		                        <td><?php echo $i?></td>
		                        <td><?php echo $parametro->cchave?></td>
		                        <td><?php echo $parametro->cvalor?></td>
		                        <td>
		                        	<a href="<?php echo makeUrl("adm","parametro","editar","?id=".$parametro->nidtbxprm)?>" class="btn btn-square btn-info btn-xs">Editar</a>
		                        	<a href="<?php echo makeUrl("adm","parametro","excluir","?id=".$parametro->nidtbxprm)?>" class="btn btn-square btn-danger btn-xs" data-confirm="true" data-message="Tem certeza que deseja remover o parâmetro <?php echo $parametro->cchave?>?">Remover</a>
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