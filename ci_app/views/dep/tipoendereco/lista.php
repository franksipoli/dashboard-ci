 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dep","tipoendereco","inserir")?>" class="btn btn-sm btn-success">Inserir novo tipo de endereço</a>
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
                        <th>Tipo de Endereço</th>
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
		                        <td><?php echo $tipo->cdescritpe?></td>
		                        <td>
		                        	<a href="<?php echo makeUrl("dep","tipoendereco","editar","?id=".$tipo->nidtbxtpe)?>" class="btn btn-square btn-info btn-xs">Editar</a>
		                        	<a href="<?php echo makeUrl("dep","tipoendereco","excluir","?id=".$tipo->nidtbxtpe)?>" class="btn btn-square btn-danger btn-xs" data-confirm="true" data-message="Tem certeza que deseja remover o tipo de endereço <?php echo $tipo->cdescritpe?>?">Remover</a>
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