 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("cadimo","tipocontrato","inserir")?>" class="btn btn-sm btn-success">Inserir novo tipo de contrato</a>
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
                        <th>Tipo de Contrato</th>
                        <th>Código</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	$i = 1;
                  	foreach ($tipos as $tipo){
                  		?>
		                     <tr>
		                        <td><?php echo $i?></td>
		                        <td><?php echo $tipo->cnomecon?></td>
		                        <td><?php echo $tipo->ccodcon?></td>
                              <td>
		                        	<a href="<?php echo makeUrl("cadimo","tipocontrato","editar","?id=".$tipo->nidtbxcon)?>" class="btn btn-square btn-info btn-xs">Editar</a>
		                        	<a href="<?php echo makeUrl("cadimo","tipocontrato","excluir","?id=".$tipo->nidtbxcon)?>" class="btn btn-square btn-danger btn-xs" data-confirm="true" data-message="Tem certeza que deseja remover o tipo de contrato <?php echo $tipo->cnomecon?>?">Remover</a>
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