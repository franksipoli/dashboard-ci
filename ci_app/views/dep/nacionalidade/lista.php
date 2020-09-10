 <!-- Page content-->
 <div class="content-wrapper">
<h3><?php echo $title?></h3>
<!-- START row-->
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<a href="<?php echo makeUrl("dep","nacionalidade","inserir")?>" class="btn btn-sm btn-success">Inserir nova nacionalidade</a>
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
                        <th>Nacionalidade</th>
                        <th>Ações</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	$i = 1;
                  	foreach ($nacionalidades as $nacionalidade){
                  		?>
		                     <tr>
		                        <td><?php echo $i?></td>
		                        <td><?php echo $nacionalidade->cdescrinac?></td>
		                        <td>
		                        	<a href="<?php echo makeUrl("dep","nacionalidade","editar","?id=".$nacionalidade->nidtbxnac)?>" class="btn btn-square btn-info btn-xs">Editar</a>
		                        	<a href="<?php echo makeUrl("dep","nacionalidade","excluir","?id=".$nacionalidade->nidtbxnac)?>" class="btn btn-square btn-danger btn-xs" data-confirm="true" data-message="Tem certeza que deseja remover a nacionalidade <?php echo $nacionalidade->cdescrinac?>?">Remover</a>
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