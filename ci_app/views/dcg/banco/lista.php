 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dcg","banco","inserir")?>" class="btn btn-sm btn-success">Inserir novo banco</a>
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
                        <th>Banco</th>
                        <th>Código</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	$i = 1;
                  	foreach ($bancos as $banco){
                  		?>
		                     <tr>
		                        <td><?php echo $i?></td>
		                        <td><?php echo $banco->cnomebco?></td>
                              <td><?php echo $banco->ccodigo?></td>
		                        <td>
		                        	<a href="<?php echo makeUrl("dcg","banco","editar","?id=".$banco->nidtbxbco)?>" class="btn btn-square btn-info btn-xs">Editar</a>
		                        	<a href="<?php echo makeUrl("dcg","banco","excluir","?id=".$banco->nidtbxbco)?>" class="btn btn-square btn-danger btn-xs" data-confirm="true" data-message="Tem certeza que deseja remover o banco <?php echo $banco->cnomebco?>?">Remover</a>
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